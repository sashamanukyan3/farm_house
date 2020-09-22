<?php

namespace frontend\controllers;

use common\models\AnimalFood;
use common\models\AnimalPens;
use common\models\Animals;
use common\models\Bakeries;
use common\models\CheeseBakery;
use common\models\CurdBakery;
use common\models\FabricProductType;
use common\models\FarmStorage;
use common\models\LandItem;
use common\models\MeatBakery;
use common\models\MyPurchaseHistory;
use common\models\PaddockBullItems;
use common\models\PaddockChickenItems;
use common\models\PaddockCowItems;
use common\models\PaddockGoatItems;
use common\models\Factories;
use common\models\FactoryCheese;
use common\models\FactoryCurd;
use common\models\FactoryDough;
use common\models\FactoryMince;
use common\models\Plant;
use common\models\ProductForBakery;
use common\models\PurchaseHistory;
use common\models\SaleQueueList;
use common\models\ShopBakery;
use common\models\Statistics;
use common\models\Settings;
use common\models\User;
use common\models\UserStorage;
use Yii;
use yii\data\Pagination;
use yii\web\NotFoundHttpException;

class GameController extends \yii\web\Controller
{
    public function actionIndex()
    {
        if(Yii::$app->user->isGuest)
        {
            return $this->goHome();
        }
        $user = User::find()
            ->where(['id'=>Yii::$app->user->id])
            ->one();
        if($user->banned)
        {
            return $this->redirect(['site/banned']);
        }
        $this->layout = false;
        Settings::setLocation('Ферма');

        //$animals = Animals::find()->all();
        //$plant = Plant::find()->all();
        return $this->render('index',
            [
                'user' => $user,
                //'animals'=>$animals,
                //'plant'=>$plant,
            ]
        );
    }

    public function actionBuy()
    {
        if(Yii::$app->user->isGuest)
        {
            throw new NotFoundHttpException;
        }
        if(Yii::$app->request->isAjax)
        {
            Yii::$app->response->format = 'json';
            $id = Yii::$app->request->post('id');
            $count = Yii::$app->request->post('count');
            $alias = Yii::$app->request->post('alias');
            $energy = Yii::$app->request->post('energy');
            $exp = Yii::$app->request->post('experience');
            $userId = Yii::$app->user->id;
            $user = User::find()->where(['id'=>$userId])->one();
            $userForPay = $user->for_pay;
            $refForOut = $user->ref_for_out;
            $userLevel = $user->level;
            $userEnergy = $user->energy;
            $username = $user->username;
            $buyObject = $this->getProductPrice($id, $alias);
            $allPrice = $count * $buyObject['price_to_buy'];
            $animals = ['chicken', 'bull', 'goat', 'cow'];
            $productType = ['egg', 'meat', 'goat_milk', 'cow_milk', 'dough', 'mince', 'cheese', 'curd']; //в резерве
            $animalFood = ['feed_chickens', 'feed_bulls', 'feed_goats', 'feed_cows']; //в резерве
            $building = ['paddock_chickens', 'paddock_bulls', 'paddock_goats', 'paddock_cows', 'factory_dough', 'factory_mince', 'factory_cheese', 'factory_curd', 'meat_bakery', 'cheese_bakery', 'curd_bakery'];
            $countProduct = '';
            //return ['status'=>true, 'msg'=>"$alias"];
            if(!empty($id) && !empty($count) && !empty($alias)) {
                if ($buyObject) {
                    if ($userForPay >= $allPrice) {
                        if (array_key_exists('level', $buyObject)) {
                            if ((int)$buyObject['level'] > (int)$userLevel) {
                                return ['status' => false, 'msg' => Yii::t('app', 'Недостаточный уровень для покупки')];
                            }
                        }
                        //$userExp = Yii::$app->user->identity->experience;
                        $farmStorage = FarmStorage::find()->one();
                        $statistic = Statistics::find()->one();
                        $experience = $user->experience;
                        $showLevel = false;
                        $newLevel = false;
                        if (in_array($alias, $animals)) {//при покупки животных 90% в резерв ярмарки если есть реферер
                            if ($userEnergy > 0 && $userEnergy >= ($energy * $count)) {
                                if ($userForPay >= $allPrice) {
                                    $myPurchaseHistory = MyPurchaseHistory::find()
                                        ->select(['id', 'count_price', 'count_product'])
                                        ->where(['user_id' => $userId])
                                        ->andWhere(['alias' => $alias])->one();
                                    $myPurchaseHistory->count_price += $allPrice; //сколько всего я денег потратил на покупку
                                    $myPurchaseHistory->count_product += $count;
                                    $myPurchaseHistory->save();

                                    $userEnergy -= ($energy * $count);
                                    //$userExp += ($experience * $count);
                                    if ($userForPay >= $allPrice && (int)$buyObject['level'] <= (int)$userLevel) {
                                        if ($newLevel = $user->isLevelUp($exp * $count)) {
                                            $showLevel = true;
                                        }
                                    }
                                    $experience = $user->experience;

                                    $farmStorage->money_storage += $allPrice * 0.95;
                                    $farmStorage->save();
                                    $adminMoney = User::find()->where(['id' => 1])->one(); //учитывая что у админа id=1
                                    $adminMoney->for_out += $allPrice * 0.05;
                                    $adminMoney->save();

                                    /*$refId = Yii::$app->user->identity->ref_id;
                                    if ($refId == 0) {
                                        $farmStorage->money_storage += $allPrice * 0.95;
                                        $farmStorage->save();
                                        $adminMoney = User::find()->where(['id' => 1])->one(); //учитывая что у админа id=1
                                        $adminMoney->for_out += $allPrice * 0.05;
                                        $adminMoney->save();
                                    } else {
                                        $farmStorage->money_storage += ($allPrice * 0.9);
                                        $farmStorage->save();
                                        $adminMoney = User::find()->where(['id' => 1])->one();//admin
                                        $adminMoney->for_out += ($allPrice * 0.05);
                                        $adminMoney->save();
                                        $refMoney = User::find()->where(['id' => $refId])->one();
                                        $refMoney->for_out += ($allPrice * 0.05);
                                        $refForOut += ($allPrice * 0.05);//сумма моих начислений рефералу
                                        $refMoney->save();
                                        $refMoneyForOut = User::find()->where(['id' => $userId])->one(); //ведем статистику всей прибыли нашему рефереру
                                        $refMoneyForOut->ref_for_out = $refForOut;
                                        $refMoneyForOut->save();

                                        $purchaseHistory = PurchaseHistory::find()
                                            ->select(['id', 'count_price', 'count_product'])
                                            ->where(['username' => $username])
                                            ->andWhere(['alias' => $alias])->one(); //с какой покупки какая прибыль рефереру
                                        $purchaseHistory->count_price += $allPrice * 0.05;
                                        $purchaseHistory->count_product += $count;
                                        $purchaseHistory->time_buy = time();
                                        $purchaseHistory->save();
                                    }*/
                                    switch ($alias) {
                                        case 'chicken':
                                            $edit = 'today_bought_chickens';
                                            $addCount = 'all_bought_chickens';
                                            break;
                                        case 'bull':
                                            $edit = 'today_bought_bulls';
                                            $addCount = 'all_bought_bulls';
                                            break;
                                        case 'goat':
                                            $edit = 'today_bought_goats';
                                            $addCount = 'all_bought_goats';
                                            break;
                                        case 'cow':
                                            $edit = 'today_bought_cows';
                                            $addCount = 'all_bought_cows';
                                            break;
                                    }
                                    $arrayValue = $statistic->$edit;
                                    $buy = explode(':', $arrayValue);
                                    $buy[0] += $count;
                                    $buy[1] += $allPrice;
                                    $setValue = implode(':', $buy);
                                    $statistic->$edit = $setValue;

                                    $arrayCount = $statistic->$addCount;
                                    $statCount = explode(':', $arrayCount);
                                    $statCount[0] += $count;
                                    $statCount[1] += $allPrice;
                                    $setAllCountValue = implode(':', $statCount);
                                    $statistic->$addCount = $setAllCountValue;
                                    $statistic->save();
                                } else {
                                    return ['status' => false, 'msg' => Yii::t('app', 'Недостаточно денег для покупки')];
                                }
                            } else {
                                return ['status' => false, 'msg' => Yii::t('app', 'У вас недостаточно энергии') . '!'];
                            }
                        } elseif (in_array($alias, $productType)) {//при покупки продуктов 100% в резерв ярмарки
                            if ($userEnergy >= 3) {
                                if ($farmStorage->$alias >= $count) {
                                    if ($userForPay >= $allPrice) {
                                        $minCount = FabricProductType::find()->where(['alias' => $alias])->one();
                                        $minCount2 = ProductForBakery::find()->where(['alias' => $alias])->one();
                                        $min = is_object($minCount) ? $minCount->min_count : $minCount2->min_count; //минимальное количество продукции
                                        if ($count >= $min) {
                                            $userEnergy -= $energy; //Покупка или продажа любой продукции -3 энергии
                                            $farmStorage->money_storage += $allPrice;
                                            $countProduct = $farmStorage->$alias -= $count;
                                            $farmStorage->save();
                                            switch ($alias) {
                                                case 'egg':
                                                    $edit = 'today_bought_eggs';
                                                    $addCount = 'all_bought_eggs';
                                                    break;
                                                case 'meat':
                                                    $edit = 'today_bought_meat';
                                                    $addCount = 'all_bought_meat';
                                                    break;
                                                case 'goat_milk':
                                                    $edit = 'today_bought_goat_milk';
                                                    $addCount = 'all_bought_goat_milk';
                                                    break;
                                                case 'cow_milk':
                                                    $edit = 'today_bought_cow_milk';
                                                    $addCount = 'all_bought_cow_milk';
                                                    break;
                                                case 'dough':
                                                    $edit = 'today_bought_dough';
                                                    $addCount = 'all_bought_dough';
                                                    break;
                                                case 'mince':
                                                    $edit = 'today_bought_mince';
                                                    $addCount = 'all_bought_mince';
                                                    break;
                                                case 'cheese':
                                                    $edit = 'today_bought_cheese';
                                                    $addCount = 'all_bought_cheese';
                                                    break;
                                                case 'curd':
                                                    $edit = 'today_bought_curd';
                                                    $addCount = 'all_bought_curd';
                                                    break;
                                            }
                                            $arrayValue = $statistic->$edit;
                                            $buy = explode(':', $arrayValue);
                                            $buy[0] += $count;
                                            $buy[1] += $allPrice;
                                            $setValue = implode(':', $buy);
                                            $statistic->$edit = $setValue;

                                            $arrayCount = $statistic->$addCount;
                                            $statCount = explode(':', $arrayCount);
                                            $statCount[0] += $count;
                                            $statCount[1] += $allPrice;
                                            $setAllCountValue = implode(':', $statCount);
                                            $statistic->$addCount = $setAllCountValue;
                                            $statistic->save();
                                        } else {
                                            return ['status' => false, 'msg' =>  Yii::t('app', 'Минимальное колчество покупки', ['min' =>  $min])];
                                        }
                                    } else {
                                        return ['status' => false, 'msg' => Yii::t('app', 'Недостаточно денег для покупки')];
                                    }
                                } else {
                                    return ['status' => false, 'msg' => Yii::t('app', 'В резерве недостаточно продукции') . '!'];
                                }
                            } else {
                                return ['status' => false, 'msg' => Yii::t('app', 'У вас недостаточно энергии') . '!'];
                            }
                        } elseif (in_array($alias, $animalFood)) {//при покупки корма 100% в резерв ярмарки
                            if ($userEnergy >= 1) {
                                if ($farmStorage->$alias >= $count) {
                                    if ($userForPay >= $allPrice) {
                                        if ($count >= 100) {
                                            $userEnergy -= $energy;
                                            $farmStorage->money_storage += $allPrice; //100%
                                            $countProduct = $farmStorage->$alias -= $count;
                                            $farmStorage->save();
                                            switch ($alias) {
                                                case 'feed_chickens':
                                                    $edit = 'today_bought_feed_chickens';
                                                    $addCount = 'all_bought_feed_chickens';
                                                    break;
                                                case 'feed_bulls':
                                                    $edit = 'today_bought_feed_bulls';
                                                    $addCount = 'all_bought_feed_bulls';
                                                    break;
                                                case 'feed_goats':
                                                    $edit = 'today_bought_feed_goats';
                                                    $addCount = 'all_bought_feed_goats';
                                                    break;
                                                case 'feed_cows':
                                                    $edit = 'today_bought_feed_cows';
                                                    $addCount = 'all_bought_feed_cows';
                                                    break;
                                            }
                                            $arrayValue = $statistic->$edit;
                                            $buy = explode(':', $arrayValue);
                                            $buy[0] += $count;
                                            $buy[1] += $allPrice;
                                            $setValue = implode(':', $buy);
                                            $statistic->$edit = $setValue;

                                            $arrayCount = $statistic->$addCount;
                                            $statCount = explode(':', $arrayCount);
                                            $statCount[0] += $count;
                                            $statCount[1] += $allPrice;
                                            $setAllCountValue = implode(':', $statCount);
                                            $statistic->$addCount = $setAllCountValue;
                                            $statistic->save();

                                            $myPurchaseHistory = MyPurchaseHistory::find()
                                                ->select(['id', 'count_price', 'count_product'])
                                                ->where(['user_id' => $userId])
                                                ->andWhere(['alias' => $alias])->one();
                                            $myPurchaseHistory->count_price += $allPrice; //сколько всего я денег потратил на покупку
                                            $myPurchaseHistory->count_product += $count;
                                            $myPurchaseHistory->save();

                                        } else {
                                            return ['status' => false, 'msg' => Yii::t('app', 'Минимальное колчество покупки 100') . '!'];
                                        }
                                    } else {
                                        return ['status' => false, 'msg' => Yii::t('app', 'Недостаточно денег для покупки') . '!'];
                                    }
                                } else {
                                    return ['status' => false, 'msg' => Yii::t('app', 'В резерве недостаточно продукции') . '!'];
                                }
                            } else {
                                return ['status' => false, 'msg' => Yii::t('app', 'У вас недостаточно энергии') . '!'];
                            }
                        } elseif (in_array($alias, $building)) {
                            if ($userForPay >= $allPrice) {
                                $myPurchaseHistory = MyPurchaseHistory::find()
                                    ->select(['id', 'count_price', 'count_product'])
                                    ->where(['user_id' => $userId])
                                    ->andWhere(['alias' => $alias])->one();
                                $myPurchaseHistory->count_price += $allPrice; //сколько всего я денег потратил на покупку
                                $myPurchaseHistory->count_product += $count;
                                $myPurchaseHistory->save();

                                $farmStorage->money_storage += $allPrice * 0.9;
                                $farmStorage->save();
                                $adminMoney = User::find()->where(['id' => 1])->one(); //учитывая что у админа id=1
                                $adminMoney->for_out += $allPrice * 0.1;
                                $adminMoney->save();

                                /*$refId = Yii::$app->user->identity->ref_id;
                                if ($refId == 0) {
                                    $farmStorage->money_storage += $allPrice * 0.9;
                                    $farmStorage->save();
                                    $adminMoney = User::find()->where(['id' => 1])->one(); //учитывая что у админа id=1
                                    $adminMoney->for_out += $allPrice * 0.1;
                                    $adminMoney->save();
                                } else {
                                    $farmStorage->money_storage += $allPrice * 0.8;
                                    $farmStorage->save();
                                    $adminMoney = User::find()->where(['id' => 1])->one();
                                    $adminMoney->for_out += $allPrice * 0.1;
                                    $adminMoney->save();
                                    $refMoney = User::find()->where(['id' => $refId])->one();
                                    $refMoney->for_out += $allPrice * 0.1;
                                    $refForOut += ($allPrice * 0.1);//сумма моих начислений рефералам
                                    $refMoney->save();
                                    $refMoneyForOut = User::find()->where(['id' => $userId])->one(); //ведем статистику всей прибыли нашему рефереру
                                    $refMoneyForOut->ref_for_out += ($allPrice * 0.1);
                                    $refMoneyForOut->save();

                                    $purchaseHistory = PurchaseHistory::find()
                                        ->select(['id', 'count_price', 'count_product'])
                                        ->where(['username' => $username])
                                        ->andWhere(['alias' => $alias])->one(); //с какой покупки какая прибыль рефереру
                                    $purchaseHistory->count_price += $allPrice * 0.1;
                                    $purchaseHistory->count_product += $count;
                                    $purchaseHistory->time_buy = time();
                                    $purchaseHistory->save();
                                }*/
                                switch ($alias) {
                                    case 'paddock_chickens':
                                        $edit = 'today_bought_paddock_chickens';
                                        $addCount = 'all_bought_paddock_chickens';
                                        break;
                                    case 'paddock_bulls':
                                        $edit = 'today_bought_paddock_bulls';
                                        $addCount = 'all_bought_paddock_bulls';
                                        break;
                                    case 'paddock_goats':
                                        $edit = 'today_bought_paddock_goats';
                                        $addCount = 'all_bought_paddock_goats';
                                        break;
                                    case 'paddock_cows':
                                        $edit = 'today_bought_paddock_cows';
                                        $addCount = 'all_bought_paddock_cows';
                                        break;
                                    case 'factory_dough':
                                        $edit = 'today_bought_factory_dough';
                                        $addCount = 'all_bought_factory_dough';
                                        break;
                                    case 'factory_mince':
                                        $edit = 'today_bought_factory_mince';
                                        $addCount = 'all_bought_factory_mince';
                                        break;
                                    case 'factory_cheese':
                                        $edit = 'today_bought_factory_cheese';
                                        $addCount = 'all_bought_factory_cheese';
                                        break;
                                    case 'factory_curd':
                                        $edit = 'today_bought_factory_curd';
                                        $addCount = 'all_bought_factory_curd';
                                        break;
                                    case 'meat_bakery':
                                        $edit = 'today_bought_meat_bakery';
                                        $addCount = 'all_bought_meat_bakery';
                                        break;
                                    case 'cheese_bakery':
                                        $edit = 'today_bought_cheese_bakery';
                                        $addCount = 'all_bought_cheese_bakery';
                                        break;
                                    case 'curd_bakery':
                                        $edit = 'today_bought_curd_bakery';
                                        $addCount = 'all_bought_curd_bakery';
                                        break;
                                }
                                $arrayValue = $statistic->$edit;
                                $buy = explode(':', $arrayValue);
                                $buy[0] += $count;
                                $buy[1] += $allPrice;
                                $setValue = implode(':', $buy);
                                $statistic->$edit = $setValue;

                                $arrayCount = $statistic->$addCount;
                                $statCount = explode(':', $arrayCount);
                                $statCount[0] += $count;
                                $statCount[1] += $allPrice;
                                $setAllCountValue = implode(':', $statCount);
                                $statistic->$addCount = $setAllCountValue;
                                $statistic->save();
                            } else {
                                return ['status' => false, 'msg' => Yii::t('app', 'Недостаточно денег для покупки') . '!'];
                            }
                        } else {
                            $farmStorage->money_storage += $allPrice;
                            $farmStorage->save();
                        }
                        if (array_key_exists('level', $buyObject)) {
                            if ((int)$buyObject['level'] <= (int)$userLevel) {
                                if ($userForPay >= $allPrice) {
                                    $userForPay -= $allPrice;
                                    $model = UserStorage::find()
                                        ->where(['user_id' => $userId])
                                        ->one();
                                    $model->$alias += $count;
                                    $model->save();
                                    Yii::$app->db->createCommand()
                                        ->update('user', ['for_pay' => $userForPay, 'ref_for_out' => $refForOut, 'energy' => $userEnergy], 'id = :id', ['id' => $userId])
                                        ->execute();

                                    return ['status' => true, 'msg' => 'Товар отправлен на склад!', 'for_pay' => $userForPay, 'alias' => $model->$alias, 'energy' => $userEnergy, 'experience' => $experience, 'countProduct' => $countProduct, 'showLevel' => $showLevel, 'newLevel' => $newLevel];
                                    /*else{return ['status' => true, 'msg' => 'Товар отправлен на склад!', 'for_pay' => $userForPay, 'alias' => $model->$alias, 'energy' => $userEnergy, 'experience' => $experience, 'showLevel' => $showLevel, 'newLevel' => $newLevel];}*/
                                } else {
                                    return ['status' => false, 'msg' => Yii::t('app', 'Недостаточно денег для покупки') . '!'];
                                }
                            } else {
                                return ['status' => false, 'msg' => Yii::t('app', 'Недостаточный уровень для покупки') . '!'];
                            }
                        } else {
                            $userForPay -= $allPrice;
                            $model = UserStorage::find()
                                ->where(['user_id' => $userId])
                                ->one();
                            $model->$alias += $count;
                            $model->save();
                            Yii::$app->db->createCommand()
                                ->update('user', ['for_pay' => $userForPay, 'ref_for_out' => $refForOut, 'energy' => $userEnergy], 'id = :id', ['id' => $userId])
                                ->execute();

                            return ['status' => true, 'msg' => Yii::t('app', 'Товар отправлен на склад') . '!', 'for_pay' => $userForPay, 'alias' => $model->$alias, 'energy' => $userEnergy, 'experience' => $experience, 'countProduct' => $countProduct];
                            /*else{return ['status' => true, 'msg' => 'Товар отправлен на склад!', 'for_pay' => $userForPay, 'alias' => $model->$alias, 'energy' => $userEnergy, 'experience' => $experience];}*/
                        }
                    } else {
                        return ['status' => false, 'msg' => Yii::t('app', 'Недостаточно денег для покупки') . '!'];
                    }
                } else {
                    return ['status' => false, 'msg' => Yii::t('app', 'Ошибка на стороне сервера') . '!'];
                }
            }
        }
        else
        {
            throw new NotFoundHttpException;
        }
    }

    public function actionBuyCake(){
        if(Yii::$app->user->isGuest)
        {
            throw new NotFoundHttpException;
        }
        if(Yii::$app->request->isAjax) {
            Yii::$app->response->format = 'json';
            $queueId= Yii::$app->request->post('queueId');
            $productId = Yii::$app->request->post('productId');
            $userIdSell = Yii::$app->request->post('userId');
            $userId = Yii::$app->user->identity->id;
            $currentCount = Yii::$app->request->post('currentCount');
            $count = Yii::$app->request->post('count');
            $alias = Yii::$app->request->post('alias');
            $buyObject = $this->getProductPrice($productId, $alias);
            $allPrice = $count * $buyObject['price_to_buy'];
            if(!empty($queueId) && !empty($productId) && !empty($userId) && !empty($count) && !empty($currentCount) && !empty($alias)){
                if($currentCount >= $count) {
                    if ($buyObject) {
                        $user = User::find()->where(['id'=>$userId])->one();
                        $userForPay = $user->for_pay;
                        $userLevel = $user->level;
                        if (array_key_exists('level', $buyObject)) {
                            if ((int)$buyObject['level'] <= (int)$userLevel) {
                                if ($allPrice <= $userForPay) {
                                    $userForPay -= $allPrice;
                                    $queueList = SaleQueueList::find()->where(['queue_id' => $queueId])->andWhere(['user_id' => $userIdSell])->one();
                                    if($queueList->count>=$count) {
                                        $queueList->count -= $count;
                                        $queueList->save(); //print_r($queueList); die();
                                    } else{
                                        return ['status' => false, 'msg' => Yii::t('app', 'Недостаточно пирогов, перезагрузите страницу') . '!'];
                                    }

                                    $model = UserStorage::find()
                                        ->select(['user_storage_id', 'user_id', 'wheat', 'clover', 'cabbage', 'beets', 'chicken',
                                            'bull', 'goat', 'cow', 'feed_chickens', 'feed_bulls', 'feed_goats', 'feed_cows', 'egg', 'meat', 'goat_milk', 'cow_milk', 'dough', 'mince', 'cheese',
                                            'curd', 'cakewithmeat', 'cakewithcheese', 'cakewithcurd', 'paddock_chickens', 'paddock_bulls',
                                            'paddock_goats', 'paddock_cows', 'factory_dough', 'factory_mince', 'factory_cheese', 'factory_curd',
                                            'meat_bakery', 'cheese_bakery', 'curd_bakery'])
                                        ->where(['user_id' => $userId])
                                        ->one();
                                    $model->$alias += $count;
                                    $model->save();

                                    Yii::$app->db->createCommand()
                                        ->update('user', ['for_pay' => $userForPay], 'id = :id', ['id' => $userId])
                                        ->execute();
                                    $userSell = User::find()->where(['id' => $userIdSell])->one();
                                    $userSell->for_out += $allPrice-($count*0.01);
                                    $userSell->save();
                                    $admin = User::find()->where(['id' => 1])->one();
                                    $admin->for_out += $count*0.01; //с каждого пирога копейка админу на счет
                                    $admin->save();
                                    return ['status' => true, 'msg' => Yii::t('app', 'Товар отправлен на склад') . '!', 'for_pay' => $userForPay, 'alias' => $model->$alias, 'count' => $queueList->count];
                                } else {
                                    return ['status' => false, 'msg' => Yii::t('app', 'Недостаточно денег для покупки') . '!'];
                                }
                            } else {
                                return ['status' => false, 'msg' => Yii::t('app', 'Недостаточный уровень для покупки') . '!'];
                            }
                        } else {
                            if ($allPrice <= $userForPay) {
                                $userForPay -= $allPrice;

                                $queueList = SaleQueueList::find()->where(['queue_id' => $queueId])->andWhere(['user_id' => $userIdSell])->one();
                                if($queueList->count>=$count) {
                                    $queueList->count -= $count;
                                    $queueList->save(); //print_r($queueList); die();
                                } else{
                                    return ['status' => false, 'msg' => Yii::t('app', 'Недостаточно пирогов, перезагрузите страницу') . '!'];
                                }

                                $model = UserStorage::find()
                                    ->select(['user_storage_id', 'user_id', 'wheat', 'clover', 'cabbage', 'beets', 'chicken',
                                        'bull', 'goat', 'cow', 'feed_chickens', 'feed_bulls', 'feed_goats', 'feed_cows', 'egg', 'meat', 'goat_milk', 'cow_milk', 'dough', 'mince', 'cheese',
                                        'curd', 'cakewithmeat', 'cakewithcheese', 'cakewithcurd', 'paddock_chickens', 'paddock_bulls',
                                        'paddock_goats', 'paddock_cows', 'factory_dough', 'factory_mince', 'factory_cheese', 'factory_curd',
                                        'meat_bakery', 'cheese_bakery', 'curd_bakery'])
                                    ->where(['user_id' => $userId])
                                    ->one();
                                $model->$alias += $count;
                                $model->save();

                                Yii::$app->db->createCommand()
                                    ->update('user', ['for_pay' => $userForPay], 'id = :id', ['id' => $userId])
                                    ->execute();
                                $userSell = User::find()->where(['id' => $userIdSell])->one();
                                $userSell->for_out += $allPrice-($count*0.01);
                                $userSell->save();
                                $admin = User::find()->where(['id' => 1])->one();
                                $admin->for_out += $count*0.01;
                                $admin->save();
                                return ['status' => true, 'msg' => Yii::t('app', 'Товар отправлен на склад') . '!', 'for_pay' => $userForPay, 'alias' => $model->$alias, 'count' => $queueList->count];
                            } else {
                                return ['status' => false, 'msg' => Yii::t('app', 'Недостаточно денег для покупки') . '!'];
                            }
                        }
                    } else {
                        return ['status' => false, 'msg' => Yii::t('app', 'Ошибка на стороне сервера') . '!'];
                    }
                } else{ return ['status' => false, 'msg' => Yii::t('app', 'Максимально доступное количество {qty}', [
                        'qty' => $currentCount,
                    ]) . '!']; }
            }
        }
        else
        {
            throw new NotFoundHttpException;
        }
    }

    public function actionSell()
    {
        if(Yii::$app->user->isGuest)
        {
            throw new NotFoundHttpException;
        }
        if(Yii::$app->request->isAjax)
        {
            Yii::$app->response->format = 'json';
            $productId = Yii::$app->request->post('id');
            $modelName = Yii::$app->request->post('model_name');
            $priceForSell = Yii::$app->request->post('price_for_sell');
            $count = Yii::$app->request->post('count');
            $minCount = Yii::$app->request->post('min_count');
            $alias = Yii::$app->request->post('alias');
            $userId = Yii::$app->user->id;
            $userStore = UserStorage::find()->where(['user_id'=>$userId])->one();
            $currentCount = $userStore->$alias;
            $for_out = Yii::$app->user->identity->for_out;
            $userEnergy = Yii::$app->user->identity->energy;
            $for_out += $count * $priceForSell;
            if(!empty($productId)&& !empty($modelName) && !empty($priceForSell) && !empty($count) && !empty($minCount)) {
                switch($alias){
                    case 'egg_for_sell':
                        $alias2 = 'egg';
                        break;
                    case 'meat_for_sell':
                        $alias2 = 'meat';
                        break;
                    case 'goat_milk_for_sell':
                        $alias2 = 'goat_milk';
                        break;
                    case 'cow_milk_for_sell':
                        $alias2 = 'cow_milk';
                        break;
                    case 'dough_for_sell':
                        $alias2 = 'dough';
                        break;
                    case 'mince_for_sell':
                        $alias2 = 'mince';
                        break;
                    case 'cheese_for_sell':
                        $alias2 = 'cheese';
                        break;
                    case 'curd_for_sell':
                        $alias2 = 'curd';
                        break;
                }
                if($currentCount >= $count) {
                    $statistic = Statistics::find()->one();
                    if ($count >= $minCount) {
                        $farmStorage = FarmStorage::find()->one();
                        if($modelName == 'Plant'){
                            if($farmStorage->money_storage >= $count*$priceForSell) {
                                if ($farmStorage->$alias < 10000 && ($farmStorage->$alias + $count) <= 10000) {
                                    $farmStorage->$alias += $count;
                                    $farmStorage->money_storage -= $count * $priceForSell;
                                    $farmStorage->save();
                                    if ($userEnergy >= 1) {
                                        $userEnergy -= 1;
                                    } else {
                                        return ['status' => false, 'msg' => Yii::t('app', 'У вас недостаточно энергии! Необходимо {qty} энергии для продажи', [
                                            'qty' => 1,
                                        ]) . '.'];
                                    }
                                } else {
                                    return ['status' => false, 'msg' => Yii::t('app', 'Резерв переполнен! Необходимо подождать освобождение места для продажи') . '.'];
                                }
                            }else{
                                return ['status' => false, 'msg' => Yii::t('app', 'В резерве недостаточно денег') . '!'];
                            }
                        }
                        if($modelName == 'FabricProductType' || $modelName == 'ProductForBakery'){
                            if($farmStorage->money_storage >= $count*$priceForSell) {
                                $farmStorage->$alias2 += $count;
                                $farmStorage->money_storage -= $count * $priceForSell; //100% вычитываем из резерва
                                $farmStorage->save();
                                if ($userEnergy >= 3) {
                                    $userEnergy -= 3;
                                } else {
                                    return ['status' => false, 'msg' => Yii::t('app', 'У вас недостаточно энергии! Необходимо {qty} энергии для продажи', [
                                        'qty' => 3,
                                    ]) . '.'];
                                }
                            }else{
                                return ['status' => false, 'msg' => Yii::t('app', 'В резерве недостаточно денег') . '!'];
                            }
                        }
                        Yii::$app->db->createCommand()
                            ->update('user', ['for_out' => $for_out, 'energy' => $userEnergy], 'id = :id', ['id' => $userId])
                            ->execute();
                        $userStore->$alias -= $count;
                        $userStore->save();
                        switch($alias){
                            case 'feed_chickens':
                                $edit = 'today_sold_feed_chickens';
                                $addCount = 'all_sold_feed_chickens';
                                break;
                            case 'feed_bulls':
                                $edit = 'today_sold_feed_bulls';
                                $addCount = 'all_sold_feed_bulls';
                                break;
                            case 'feed_goats':
                                $edit = 'today_sold_feed_goats';
                                $addCount = 'all_sold_feed_goats';
                                break;
                            case 'feed_cows':
                                $edit = 'today_sold_feed_cows';
                                $addCount = 'all_sold_feed_cows';
                                break;
                            case 'egg_for_sell':
                                $edit = 'today_sold_eggs';
                                $addCount = 'all_sold_eggs';
                                break;
                            case 'meat_for_sell':
                                $edit = 'today_sold_meat';
                                $addCount = 'all_sold_meat';
                                break;
                            case 'goat_milk_for_sell':
                                $edit = 'today_sold_goat_milk';
                                $addCount = 'all_sold_goat_milk';
                                break;
                            case 'cow_milk_for_sell':
                                $edit = 'today_sold_cow_milk';
                                $addCount = 'all_sold_cow_milk';
                                break;
                            case 'dough_for_sell':
                                $edit = 'today_sold_dough';
                                $addCount = 'all_sold_dough';
                                break;
                            case 'mince_for_sell':
                                $edit = 'today_sold_mince';
                                $addCount = 'all_sold_mince';
                                break;
                            case 'cheese_for_sell':
                                $edit = 'today_sold_cheese';
                                $addCount = 'all_sold_cheese';
                                break;
                            case 'curd_for_sell':
                                $edit = 'today_sold_curd';
                                $addCount = 'all_sold_curd';
                                break;
                        }
                        $arrayValue = $statistic->$edit;
                        $buy = explode(':', $arrayValue);
                        $buy[0]+=$count; $buy[1]+=$count * $priceForSell;
                        $setValue = implode(':', $buy);
                        $statistic->$edit = $setValue;

                        $arrayCount = $statistic->$addCount;
                        $statCount = explode(':', $arrayCount);
                        $statCount[0]+=$count; $statCount[1]+=$count * $priceForSell;
                        $setAllCountValue = implode(':', $statCount);
                        $statistic->$addCount = $setAllCountValue;
                        $statistic->save();
                        return ['status' => true, 'msg' => Yii::t('app', 'Товар успешно продан! Вы получили {rub} руб.', [
                            'rub' => ($count * $priceForSell),
                        ]), 'count'=>$userStore->$alias, 'energy'=>$userEnergy];
                    } else {
                        return ['status' => false, 'msg' => Yii::t('app', 'Минимальное количество продажи {qty}', [
                            'qty' => $minCount,
                        ])];
                    }
                } else{
                    return ['status' => false, 'msg' => Yii::t('app', 'Минимальное количество продажи {qty}', [
                        'qty' => 100,
                    ]) . '!'];
                }
            }
        }
        else
        {
            throw new NotFoundHttpException;
        }
    }

    public function actionCakeSell(){
        if(Yii::$app->user->isGuest)
        {
            throw new NotFoundHttpException;
        }
        if(Yii::$app->request->isAjax)
        {
            Yii::$app->response->format = 'json';
            $productId = Yii::$app->request->post('id');
            $modelName = Yii::$app->request->post('model_name');
            $priceForSell = Yii::$app->request->post('price_for_sell'); //за ед. продукции
            $count = Yii::$app->request->post('count');
            $minCount = Yii::$app->request->post('min_count');
            $alias = Yii::$app->request->post('alias');
            $userId = Yii::$app->user->id;
            $userStore = UserStorage::find()->where(['user_id'=>$userId])->one();
            $currentCount = $userStore->$alias;
            if(!empty($productId)&& !empty($modelName) && !empty($priceForSell) && !empty($count) && !empty($minCount)) {
                if($currentCount >= $count) {
                    $model = new SaleQueueList();
                    $model->product_id = $productId;
                    $model->user_id = $userId;
                    $model->model_name = $modelName;
                    $model->price = $priceForSell;
                    $model->count = $count;
                    $model->sell_time = time();
                    if ($count >= $minCount) {
                        $model->save();
                        $userStorage = UserStorage::find()->where(['user_id'=>$userId])->one();
                        $userStorage->$alias -= $count;
                        $userStorage->save();
                        return ['status' => true, 'msg' => Yii::t('app', 'Ваши пироги успешно добавлены в очередь на продажу') . '!', 'count'=>$userStorage->$alias];
                    } else {
                        return ['status' => false, 'msg' => Yii::t('app', 'Минимальное количество продажи {qty}', [
                            'qty' => $minCount,
                        ])];
                    }
                } else{
                    return ['status' => false, 'msg' => Yii::t('app', 'У вас недостаточное количество для продажи, минимальное количество продажи {qty}', [
                        'qty' => 100,
                    ]) . '!'];
                }
            }
        }
        else
        {
            throw new NotFoundHttpException;
        }
    }

    public function getProductPrice($id, $alias){
        $alias_plant = ['wheat','clover', 'cabbage','beets'];
        $alias_animals = ['chicken', 'bull', 'goat', 'cow'];
        $alias_animal_food = ['feed_chickens', 'feed_bulls', 'feed_goats', 'feed_cows'];
        $alias_product_type = ['egg', 'meat', 'goat_milk', 'cow_milk'];
        $alias_product_type_bakery = ['dough', 'mince', 'cheese', 'curd'];
        $alias_animal_pens = ['paddock_chickens', 'paddock_bulls', 'paddock_goats', 'paddock_cows'];
        $alias_factory = ['factory_dough', 'factory_mince', 'factory_cheese', 'factory_curd'];
        $alias_bakery = ['meat_bakery', 'cheese_bakery', 'curd_bakery'];
        $alias_shop_bakery = ['cakewithcheese', 'cakewithcurd', 'cakewithmeat'];
        if(in_array($alias, $alias_plant))
        {
            $buyObject = Plant::find()->select(['level', 'price_to_buy'])
                ->where(['plant_id'=>$id])
                ->asArray()
                ->one();
            return $buyObject;
        }
        elseif(in_array($alias, $alias_animals))
        {
            $buyObject = Animals::find()
                ->select(['level', 'price_to_buy'])
                ->where(['animal_id'=>$id])
                ->asArray()
                ->one();
            return $buyObject;
        }
        elseif(in_array($alias, $alias_animal_food))
        {
            $buyObject = AnimalFood::find()
                ->select(['price_to_buy'])
                ->where(['animal_food_id'=>$id])
                ->asArray()
                ->one();
            return $buyObject;
        }
        elseif(in_array($alias, $alias_product_type))
        {
            $buyObject = FabricProductType::find()
                ->select(['price_to_buy'])
                ->where(['id'=>$id])
                ->asArray()
                ->one();
            return $buyObject;
        }
        elseif(in_array($alias, $alias_product_type_bakery))
        {
            $buyObject = ProductForBakery::find()
                ->select(['price_to_buy'])
                ->where(['id'=>$id])
                ->asArray()
                ->one();
            return $buyObject;
        }
        elseif(in_array($alias, $alias_animal_pens))
        {
            $buyObject = AnimalPens::find()
                ->select(['level', 'price_to_buy'])
                ->where(['animal_pens_id'=>$id])
                ->asArray()
                ->one();
            return $buyObject;
        }
        elseif(in_array($alias, $alias_factory))
        {
            $buyObject = Factories::find()
                ->select(['level', 'price_to_buy'])
                ->where(['factory_id'=>$id])
                ->asArray()
                ->one();
            return $buyObject;
        }
        elseif(in_array($alias, $alias_bakery))
        {
            $buyObject = Bakeries::find()
                ->select(['level', 'price_to_buy'])
                ->where(['bakery_id'=>$id])
                ->asArray()
                ->one();
            return $buyObject;
        }
        elseif(in_array($alias, $alias_shop_bakery))
        {
            $buyObject = ShopBakery::find()
                ->select(['level', 'price_to_buy'])
                ->where(['id'=>$id])
                ->asArray()
                ->one();
            return $buyObject;
        }

    }

    public function actionEat(){
        if(Yii::$app->user->isGuest)
        {
            throw new NotFoundHttpException;
        }
        if(Yii::$app->request->isAjax)
        {
            Yii::$app->response->format = 'json';
            $cakeId = Yii::$app->request->post('id');
            $alias = Yii::$app->request->post('alias');
            $type = Yii::$app->request->post('type');
            $count = Yii::$app->request->post('count');
            if(!empty($cakeId) && !empty($alias) && !empty($type) && !empty($count)) {
                $userId = Yii::$app->user->id;
                $cakeEnergy = ShopBakery::find()->select(['energy_in_food'])->where(['id' => $cakeId])->one();
                $model = UserStorage::find()->where(['user_id'=>$userId])->one();
                if($type==1) {
                    $userEnergy = Yii::$app->user->identity->energy + ($cakeEnergy->energy_in_food);
                    $model->$alias = $model->$alias - 1;
                    $model->save();
                    Yii::$app->db->createCommand()
                        ->update('user', ['energy' => $userEnergy], 'id = :id', ['id' => $userId])
                        ->execute();
                    return ['status' => true, 'msg' => Yii::t('app', 'Вы получили {units} энергии', [
                            'units' => $cakeEnergy->energy_in_food,
                        ]) . '!', 'user_energy' => $userEnergy, 'count'=>$model->$alias];
                } else {
                    $userEnergy = Yii::$app->user->identity->energy + ($cakeEnergy->energy_in_food * $count);
                    $model->$alias = 0;
                    $model->save();
                    Yii::$app->db->createCommand()
                        ->update('user', ['energy' => $userEnergy], 'id = :id', ['id' => $userId])
                        ->execute();
                    return ['status' => true, 'msg' => Yii::t('app', 'Вы получили {units} энергии', [
                        'units' => $cakeEnergy->energy_in_food * $count,
                    ]) . '!', 'user_energy' => $userEnergy, 'count'=>$model->$alias];
                }
            }else{
                return ['status' => false, 'msg' => Yii::t('app', 'Ошибка на стороне сервера') . '!'];
            }
        }
        else
        {
            throw new NotFoundHttpException;
        }
    }

    public function actionLand()
    {
        if(Yii::$app->user->isGuest)
        {
            return $this->goHome();
        }
        $user = User::findOne(['id'=>Yii::$app->user->id]);
        if($user->banned)
        {
            return $this->redirect(['site/banned']);
        }
        Settings::setLocation('Поля');
        $this->layout = false;
        $newPage = false;

//получаем items

        $query = LandItem::find()->where(['user_id'=>Yii::$app->user->id]);

        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => 9]);
        $countAllItem = LandItem::find()->where(['user_id'=>Yii::$app->user->id])->count();
        $page = (int)Yii::$app->request->get('page');
        if($page)
        {
            if($countAllItem / $page == 9)
            {
                $newPage = true;
            }
        }
        else
        {
            if($countAllItem / 1 == 9)
            {
                $newPage = true;
            }
        }
        $pages->pageSizeParam = false;
        $items = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->asArray()
            ->all();

        return $this->render('land',compact('items','pages','user','newPage'));
    }

    public function actionPaddockChickens()
    {
        if(Yii::$app->user->isGuest)
        {
            return $this->goHome();
        }
        $userId = Yii::$app->user->id;
        $user = User::find()
            ->select(['username', 'photo', 'level', 'for_pay', 'for_out', 'energy', 'experience', 'need_experience'])
            ->where(['id'=>$userId])
            ->one();
        if($user->banned)
        {
            return $this->redirect(['site/banned']);
        }
        Settings::setLocation('Загон кур');
        $this->layout = false;

        $query = PaddockChickenItems::find()
            ->where(['user_id' => $userId])
            ->orderBy(['item_id'=>SORT_DESC]);

        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => 9]);
        $pages->pageSizeParam = false;
        $paddockItems = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->asArray()
            ->all();
        return $this->render('paddock-chickens',
            [
                'user' => $user,
                'paddockItems' => $paddockItems,
                'pages' => $pages,
            ]
        );
    } //Петухи

    public function actionPaddockBulls()
    {
        if(Yii::$app->user->isGuest)
        {
            return $this->goHome();
        }
        Settings::setLocation('Загон бычков');
        $this->layout = false;
        $user = User::find()
            ->select(['username', 'photo', 'level', 'for_pay', 'for_out', 'energy', 'experience', 'need_experience'])
            ->where(['id'=>Yii::$app->user->id])
            ->one();
        if($user->banned)
        {
            return $this->redirect(['site/banned']);
        }
        $query = PaddockBullItems::find()
            ->where(['user_id' => Yii::$app->user->id])
            ->orderBy(['item_id'=>SORT_ASC]);

        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => 9]);
        $pages->pageSizeParam = false;
        $paddockItems = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->asArray()
            ->all();

        return $this->render('paddock-bulls',
            [
                'user' => $user,
                'paddockItems' => $paddockItems,
                'pages' => $pages,
            ]
        );
    } //Бычки

    public function actionPaddockGoats() //Козы
    {
        if(Yii::$app->user->isGuest)
        {
            return $this->goHome();
        }
        $user = User::find()
            ->select(['username', 'photo', 'level', 'for_pay', 'for_out', 'energy', 'experience', 'need_experience'])
            ->where(['id'=>Yii::$app->user->id])
            ->one();
        if($user->banned)
        {
            return $this->redirect(['site/banned']);
        }
        Settings::setLocation('Загон коз');
        $this->layout = false;

        $query = PaddockGoatItems::find()
            ->where(['user_id' => Yii::$app->user->id])
            ->orderBy(['item_id'=>SORT_ASC]);

        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => 9]);
        $pages->pageSizeParam = false;
        $paddockItems = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->asArray()
            ->all();

        return $this->render('paddock-goats',
            [
                'user' => $user,
                'paddockItems' => $paddockItems,
                'pages' => $pages,
            ]
        );
    }

    public function actionPaddockCows() //Коровы
    {
        if(Yii::$app->user->isGuest)
        {
            return $this->goHome();
        }
        $user = User::find()
            ->select(['username', 'photo', 'level', 'for_pay', 'for_out', 'energy', 'experience', 'need_experience'])
            ->where(['id'=>Yii::$app->user->id])
            ->one();
        if($user->banned)
        {
            return $this->redirect(['site/banned']);
        }
        Settings::setLocation('Загон коров');
        $this->layout = false;

        $query = PaddockCowItems::find()
            ->where(['user_id' => Yii::$app->user->id])
            ->orderBy(['item_id'=>SORT_ASC]);

        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => 9]);
        $pages->pageSizeParam = false;
        $paddockItems = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->asArray()
            ->all();

        return $this->render('paddock-cows',
            [
                'user' => $user,
                'paddockItems' => $paddockItems,
                'pages' => $pages,
            ]
        );
    }

    public function actionFactoryDough()
    {
        if(Yii::$app->user->isGuest)
        {
            return $this->goHome();
        }
        $user = User::find()
            ->where(['id'=>Yii::$app->user->id])
            ->one();
        if($user->banned)
        {
            return $this->redirect(['site/banned']);
        }
        Settings::setLocation('Фабрика теста');
        $this->layout = false;

        $models = FactoryDough::find()->where(['not', ['time_finish' => 0]])->andWhere(['<=', 'time_finish', strtotime('now')])->all();
        if(count($models) != 0) {
            foreach ($models as $model) {
                $model->status_id = FactoryDough::STATUS_READY_PRODUCT;
                $model->save();
            }
        }

        $query = FactoryDough::find()
            ->where(['user_id' => Yii::$app->user->id])
            ->orderBy(['item_id'=>SORT_ASC]);

        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => 9]);
        $pages->pageSizeParam = false;
        $factoryItems = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->asArray()
            ->all();

        return $this->render('factory-dough',
            [
                'user' => $user,
                'factoryItems' => $factoryItems,
                'pages' => $pages,
            ]
        );
    } //Фабрика

    public function actionFactoryMince()
    {
        if(Yii::$app->user->isGuest)
        {
            return $this->goHome();
        }
        $user = User::find()
            ->where(['id'=>Yii::$app->user->id])
            ->one();
        if($user->banned)
        {
            return $this->redirect(['site/banned']);
        }
        Settings::setLocation('Фабрика фарша');
        $this->layout = false;

        $models = FactoryMince::find()->where(['not', ['time_finish' => 0]])->andWhere(['<=', 'time_finish', strtotime('now')])->all();
        if(count($models) != 0) {
            foreach ($models as $model) {
                $model->status_id = FactoryMince::STATUS_READY_PRODUCT;
                $model->save();
            }
        }

        $query = FactoryMince::find()
            ->where(['user_id' => Yii::$app->user->id])
            ->orderBy(['item_id'=>SORT_ASC]);

        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => 9]);
        $pages->pageSizeParam = false;
        $factoryItems = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->asArray()
            ->all();

        return $this->render('factory-mince',
            [
                'user' => $user,
                'factoryItems' => $factoryItems,
                'pages' => $pages,
            ]
        );
    }

    public function actionFactoryCheese()
    {
        if(Yii::$app->user->isGuest)
        {
            return $this->goHome();
        }
        $user = User::find()
            ->where(['id'=>Yii::$app->user->id])
            ->one();
        if($user->banned)
        {
            return $this->redirect(['site/banned']);
        }
        Settings::setLocation('Фабрика сыра');
        $this->layout = false;

        $models = FactoryCheese::find()->where(['not', ['time_finish' => 0]])->andWhere(['<=', 'time_finish', strtotime('now')])->all();
        if(count($models) != 0) {
            foreach ($models as $model) {
                $model->status_id = FactoryCheese::STATUS_READY_PRODUCT;
                $model->save();
            }
        }

        $query = FactoryCheese::find()
            ->where(['user_id' => Yii::$app->user->id])
            ->orderBy(['item_id'=>SORT_ASC]);

        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => 9]);
        $pages->pageSizeParam = false;
        $factoryItems = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->asArray()
            ->all();

        return $this->render('factory-cheese',
            [
                'user' => $user,
                'factoryItems' => $factoryItems,
                'pages' => $pages,
            ]
        );
    }

    public function actionFactoryCurd()
    {
        if(Yii::$app->user->isGuest)
        {
            return $this->goHome();
        }
        $user = User::find()
            ->where(['id'=>Yii::$app->user->id])
            ->one();
        if($user->banned)
        {
            return $this->redirect(['site/banned']);
        }
        Settings::setLocation('Фабрика творога');
        $this->layout = false;

        $models = FactoryCurd::find()->where(['not', ['time_finish' => 0]])->andWhere(['<=', 'time_finish', strtotime('now')])->all();
        if(count($models) != 0) {
            foreach ($models as $model) {
                $model->status_id = FactoryCurd::STATUS_READY_PRODUCT;
                $model->save();
            }
        }

        $query = FactoryCurd::find()
            ->where(['user_id' => Yii::$app->user->id])
            ->orderBy(['item_id'=>SORT_ASC]);

        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => 9]);
        $pages->pageSizeParam = false;
        $factoryItems = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->asArray()
            ->all();

        return $this->render('factory-curd',
            [
                'user' => $user,
                'factoryItems' => $factoryItems,
                'pages' => $pages,
            ]
        );
    }

    public function actionMeatBakery()
    {
        if(Yii::$app->user->isGuest)
        {
            return $this->goHome();
        }
        $user = User::find()
            ->where(['id'=>Yii::$app->user->id])
            ->one();
        if($user->banned)
        {
            return $this->redirect(['site/banned']);
        }

        Settings::setLocation('Пирог с мясом');
        $this->layout = false;

        $models = MeatBakery::find()->where(['not', ['time_finish' => 0]])->andWhere(['<=', 'time_finish', strtotime('now')])->all();
        if(count($models) != 0) {
            foreach ($models as $model) {
                $model->status_id = MeatBakery::STATUS_READY_PRODUCT;
                $model->save();
            }
        }

        $query = MeatBakery::find()
            ->where(['user_id' => Yii::$app->user->id])
            ->orderBy(['item_id'=>SORT_ASC]);

        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => 9]);
        $pages->pageSizeParam = false;
        $factoryItems = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->asArray()
            ->all();

        return $this->render('meat-bakery',
            [
                'user' => $user,
                'factoryItems' => $factoryItems,
                'pages' => $pages,
            ]
        );
    } //Пекарни

    public function actionCheeseBakery()
    {
        if(Yii::$app->user->isGuest)
        {
            return $this->goHome();
        }
        $user = User::find()
            ->where(['id'=>Yii::$app->user->id])
            ->one();
        if($user->banned)
        {
            return $this->redirect(['site/banned']);
        }
        Settings::setLocation('Пирог с сыром');
        $this->layout = false;

        $models = CheeseBakery::find()->where(['not', ['time_finish' => 0]])->andWhere(['<=', 'time_finish', strtotime('now')])->all();
        if(count($models) != 0) {
            foreach ($models as $model) {
                $model->status_id = CheeseBakery::STATUS_READY_PRODUCT;
                $model->save();
            }
        }

        $query = CheeseBakery::find()
            ->where(['user_id' => Yii::$app->user->id])
            ->orderBy(['item_id'=>SORT_ASC]);

        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => 9]);
        $pages->pageSizeParam = false;
        $factoryItems = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->asArray()
            ->all();

        return $this->render('cheese-bakery',
            [
                'user' => $user,
                'factoryItems' => $factoryItems,
                'pages' => $pages,
            ]
        );
    }

    public function actionCurdBakery()
    {
        if(Yii::$app->user->isGuest)
        {
            return $this->goHome();
        }
        $user = User::find()
            ->where(['id'=>Yii::$app->user->id])
            ->one();
        if($user->banned)
        {
            return $this->redirect(['site/banned']);
        }
        Settings::setLocation('Пирог с творогом');
        $this->layout = false;

        $models = CurdBakery::find()->where(['not', ['time_finish' => 0]])->andWhere(['<=', 'time_finish', strtotime('now')])->all();
        if(count($models) != 0) {
            foreach ($models as $model) {
                $model->status_id = CurdBakery::STATUS_READY_PRODUCT;
                $model->save();
            }
        }

        $query = CurdBakery::find()
            ->where(['user_id' => Yii::$app->user->id])
            ->orderBy(['item_id'=>SORT_ASC]);

        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => 9]);
        $pages->pageSizeParam = false;
        $factoryItems = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->asArray()
            ->all();

        return $this->render('curd-bakery',
            [
                'user' => $user,
                'factoryItems' => $factoryItems,
                'pages' => $pages,
            ]
        );
    }

    public function actionStatisticsFair(){

        if(Yii::$app->user->isGuest)
        {
            throw new NotFoundHttpException;
        }
        if(Yii::$app->request->isAjax) {
            Yii::$app->response->format = 'json';
            $statistics = Statistics::find()->one();
            //$htmlElement = "<h4>".explode(':', $statistics->all_bought_feed_chickens)[1]."<h4>";
            if($statistics) {
                $htmlElement = " <div class='col-sm-12 col-mod-1 thumbnail thymb-mi price'>
        <div class='col-md-6'>
            <span>" . Yii::t('app', 'Название') . "</span>
        </div>
        <div class='col-md-3'>
            <span>" . Yii::t('app', 'Количество') . "</span>
        </div>
        <div class='col-md-3'>
            <span>" . Yii::t('app', 'Сумма') . "</span>
        </div>
    </div>
    <div class='col-sm-12 col-mod-1'>
        <div class='col-sm-12 col-mod-1 thumbnail thymb-mi price'>
            <div class='col-md-6'>
                <span>" . Yii::t('app', 'Покупка Корма кур') . "</span><br/>
                <span>" . Yii::t('app', 'Покупка Корма кур сегодня') . "</span><br/>
                <span>" . Yii::t('app', 'Продажа Корма кур') . "</span><br/>
                <span>" . Yii::t('app', 'Продажа Корма кур сегодня') . "</span><br/>
            </div>
            <div class='col-md-3'>
                <span>" . explode(':', $statistics->all_bought_feed_chickens)[0] . "</span><br/>
                <span>" . explode(':', $statistics->today_bought_feed_chickens)[0] . "</span><br/>
                <span>" . explode(':', $statistics->all_sold_feed_chickens)[0] . "</span><br/>
                <span>" . explode(':', $statistics->today_sold_feed_chickens)[0] . "</span><br/>
            </div>
            <div class='col-md-3'>
                <span>" . explode(':', $statistics->all_bought_feed_chickens)[1] . "</span><br/>
                <span>" . explode(':', $statistics->today_bought_feed_chickens)[1] . "</span><br/>
                <span>" . explode(':', $statistics->all_sold_feed_chickens)[1] . "</span><br/>
                <span>" . explode(':', $statistics->today_sold_feed_chickens)[1] . "</span><br/>
            </div>
        </div>
    </div>
    <div class='col-sm-12 col-mod-1'>
        <div class='col-sm-12 col-mod-1 thumbnail thymb-mi price'>
            <div class='col-md-6'>
                <span>" . Yii::t('app', 'Покупка Корма бычков') . "</span><br/>
                <span>" . Yii::t('app', 'Покупка Корма бычков сегодня') . "</span><br/>
                <span>" . Yii::t('app', 'Продажа Корма бычков') . "</span><br/>
                <span>" . Yii::t('app', 'Продажа Корма бычков сегодня') . "</span><br/>
            </div>
            <div class='col-md-3'>
                <span>" . explode(':', $statistics->all_bought_feed_bulls)[0] . "</span><br/>
                <span>" . explode(':', $statistics->today_bought_feed_bulls)[0] . "</span><br/>
                <span>" . explode(':', $statistics->all_sold_feed_bulls)[0] . "</span><br/>
                <span>" . explode(':', $statistics->today_sold_feed_bulls)[0] . "</span><br/>
            </div>
            <div class='col-md-3'>
                <span>" . explode(':', $statistics->all_bought_feed_bulls)[1] . "</span><br/>
                <span>" . explode(':', $statistics->today_bought_feed_bulls)[1] . "</span><br/>
                <span>" . explode(':', $statistics->all_sold_feed_bulls)[1] . "</span><br/>
                <span>" . explode(':', $statistics->today_sold_feed_bulls)[1] . "</span><br/>
            </div>
        </div>
    </div>
    <div class='col-sm-12 col-mod-1'>
        <div class='col-sm-12 col-mod-1 thumbnail thymb-mi price'>
            <div class='col-md-6'>
                <span>" . Yii::t('app', 'Покупка Корма коз') . "</span><br/>
                <span>" . Yii::t('app', 'Покупка Корма коз сегодня') . "</span><br/>
                <span>" . Yii::t('app', 'Продажа Корма коз') . "</span><br/>
                <span>" . Yii::t('app', 'Продажа Корма коз сегодня') . "</span><br/>
            </div>
            <div class='col-md-3'>
                <span>" . explode(':', $statistics->all_bought_feed_goats)[0] . "</span><br/>
                <span>" . explode(':', $statistics->today_bought_feed_goats)[0] . "</span><br/>
                <span>" . explode(':', $statistics->all_sold_feed_goats)[0] . "</span><br/>
                <span>" . explode(':', $statistics->today_sold_feed_goats)[0] . "</span><br/>
            </div>
            <div class='col-md-3'>
                <span>" . explode(':', $statistics->all_bought_feed_goats)[1] . "</span><br/>
                <span>" . explode(':', $statistics->today_bought_feed_goats)[1] . "</span><br/>
                <span>" . explode(':', $statistics->all_sold_feed_goats)[1] . "</span><br/>
                <span>" . explode(':', $statistics->today_sold_feed_goats)[1] . "</span><br/>
            </div>
        </div>
    </div>
    <div class='col-sm-12 col-mod-1'>
        <div class='col-sm-12 col-mod-1 thumbnail thymb-mi price'>
            <div class='col-md-6'>
                <span>" . Yii::t('app', 'Покупка Корма коров') . "</span><br/>
                <span>" . Yii::t('app', 'Покупка Корма коров сегодня') . "</span><br/>
                <span>" . Yii::t('app', 'Продажа Корма коров') . "</span><br/>
                <span>" . Yii::t('app', 'Продажа Корма коров сегодня') . "</span><br/>
            </div>
            <div class='col-md-3'>
                <span>" . explode(':', $statistics->all_bought_feed_cows)[0] . "</span><br/>
                <span>" . explode(':', $statistics->today_bought_feed_cows)[0] . "</span><br/>
                <span>" . explode(':', $statistics->all_sold_feed_cows)[0] . "</span><br/>
                <span>" . explode(':', $statistics->today_sold_feed_cows)[0] . "</span><br/>
            </div>
            <div class='col-md-3'>
                <span>" . explode(':', $statistics->all_bought_feed_cows)[1] . "</span><br/>
                <span>" . explode(':', $statistics->today_bought_feed_cows)[1] . "</span><br/>
                <span>" . explode(':', $statistics->all_sold_feed_cows)[1] . "</span><br/>
                <span>" . explode(':', $statistics->today_sold_feed_cows)[1] . "</span><br/>
            </div>
        </div>
    </div>
    <div class='col-sm-12 col-mod-1'>
        <div class='col-sm-12 col-mod-1 thumbnail thymb-mi price'>
            <div class='col-md-6'>
                <span>" . Yii::t('app', 'Покупка Яиц') . "</span><br/>
                <span>" . Yii::t('app', 'Покупка Яиц сегодня') . "</span><br/>
                <span>" . Yii::t('app', 'Продажа Яиц') . "</span><br/>
                <span>" . Yii::t('app', 'Продажа Яиц сегодня') . "</span><br/>
            </div>
            <div class='col-md-3'>
                <span>" . explode(':', $statistics->all_bought_eggs)[0] . "</span><br/>
                <span>" . explode(':', $statistics->today_bought_eggs)[0] . "</span><br/>
                <span>" . explode(':', $statistics->all_sold_eggs)[0] . "</span><br/>
                <span>" . explode(':', $statistics->today_sold_eggs)[0] . "</span><br/>
            </div>
            <div class='col-md-3'>
                <span>" . explode(':', $statistics->all_bought_eggs)[1] . "</span><br/>
                <span>" . explode(':', $statistics->today_bought_eggs)[1] . "</span><br/>
                <span>" . explode(':', $statistics->all_sold_eggs)[1] . "</span><br/>
                <span>" . explode(':', $statistics->today_sold_eggs)[1] . "</span><br/>
            </div>
        </div>
    </div>
    <div class='col-sm-12 col-mod-1'>
        <div class='col-sm-12 col-mod-1 thumbnail thymb-mi price'>
            <div class='col-md-6'>
                <span>" . Yii::t('app', 'Покупка Мяса') . "</span><br/>
                <span>" . Yii::t('app', 'Покупка Мяса сегодня') . "</span><br/>
                <span>" . Yii::t('app', 'Продажа Мяса') . "</span><br/>
                <span>" . Yii::t('app', 'Продажа Мяса сегодня') . "</span><br/>
            </div>
            <div class='col-md-3'>
                <span>" . explode(':', $statistics->all_bought_meat)[0] . "</span><br/>
                <span>" . explode(':', $statistics->today_bought_meat)[0] . "</span><br/>
                <span>" . explode(':', $statistics->all_sold_meat)[0] . "</span><br/>
                <span>" . explode(':', $statistics->today_sold_meat)[0] . "</span><br/>
            </div>
            <div class='col-md-3'>
                <span>" . explode(':', $statistics->all_bought_meat)[1] . "</span><br/>
                <span>" . explode(':', $statistics->today_bought_meat)[1] . "</span><br/>
                <span>" . explode(':', $statistics->all_sold_meat)[1] . "</span><br/>
                <span>" . explode(':', $statistics->today_sold_meat)[1] . "</span><br/>
            </div>
        </div>
    </div>
    <div class='col-sm-12 col-mod-1'>
        <div class='col-sm-12 col-mod-1 thumbnail thymb-mi price'>
            <div class='col-md-6'>
                <span>" . Yii::t('app', 'Покупка Молока козы') . "</span><br/>
                <span>" . Yii::t('app', 'Покупка Молока козы сегодня') . "</span><br/>
                <span>" . Yii::t('app', 'Продажа Молока козы') . "</span><br/>
                <span>" . Yii::t('app', 'Продажа Молока козы сегодня') . "</span><br/>
            </div>
            <div class='col-md-3'>
                <span>" . explode(':', $statistics->all_bought_goat_milk)[0] . "</span><br/>
                <span>" . explode(':', $statistics->today_bought_goat_milk)[0] . "</span><br/>
                <span>" . explode(':', $statistics->all_sold_goat_milk)[0] . "</span><br/>
                <span>" . explode(':', $statistics->today_sold_goat_milk)[0] . "</span><br/>
            </div>
            <div class='col-md-3'>
                <span>" . explode(':', $statistics->all_bought_goat_milk)[1] . "</span><br/>
                <span>" . explode(':', $statistics->today_bought_goat_milk)[1] . "</span><br/>
                <span>" . explode(':', $statistics->all_sold_goat_milk)[1] . "</span><br/>
                <span>" . explode(':', $statistics->today_sold_goat_milk)[1] . "</span><br/>
            </div>
        </div>
    </div>
    <div class='col-sm-12 col-mod-1'>
        <div class='col-sm-12 col-mod-1 thumbnail thymb-mi price'>
            <div class='col-md-6'>
                <span>" . Yii::t('app', 'Покупка Молока коровы') . "</span><br/>
                <span>" . Yii::t('app', 'Покупка Молока коровы сегодня') . "</span><br/>
                <span>" . Yii::t('app', 'Продажа Молока коровы') . "</span><br/>
                <span>" . Yii::t('app', 'Продажа Молока коровы сегодня') . "</span><br/>
            </div>
            <div class='col-md-3'>
                <span>" . explode(':', $statistics->all_bought_cow_milk)[0] . "</span><br/>
                <span>" . explode(':', $statistics->today_bought_cow_milk)[0] . "</span><br/>
                <span>" . explode(':', $statistics->all_sold_cow_milk)[0] . "</span><br/>
                <span>" . explode(':', $statistics->today_sold_cow_milk)[0] . "</span><br/>
            </div>
            <div class='col-md-3'>
                <span>" . explode(':', $statistics->all_bought_cow_milk)[1] . "</span><br/>
                <span>" . explode(':', $statistics->today_bought_cow_milk)[1] . "</span><br/>
                <span>" . explode(':', $statistics->all_sold_cow_milk)[1] . "</span><br/>
                <span>" . explode(':', $statistics->today_sold_cow_milk)[1] . "</span><br/>
            </div>
        </div>
    </div>
    <div class='col-sm-12 col-mod-1'>
        <div class='col-sm-12 col-mod-1 thumbnail thymb-mi price'>
            <div class='col-md-6'>
                <span>" . Yii::t('app', 'Покупка Теста') . "</span><br/>
                <span>" . Yii::t('app', 'Покупка Теста сегодня') . "</span><br/>
                <span>" . Yii::t('app', 'Продажа Теста') . "</span><br/>
                <span>" . Yii::t('app', 'Продажа Теста сегодня') . "</span><br/>
            </div>
            <div class='col-md-3'>
                <span>" . explode(':', $statistics->all_bought_dough)[0] . "</span><br/>
                <span>" . explode(':', $statistics->today_bought_dough)[0] . "</span><br/>
                <span>" . explode(':', $statistics->all_sold_dough)[0] . "</span><br/>
                <span>" . explode(':', $statistics->today_sold_dough)[0] . "</span><br/>
            </div>
            <div class='col-md-3'>
                <span>" . explode(':', $statistics->all_bought_dough)[1] . "</span><br/>
                <span>" . explode(':', $statistics->today_bought_dough)[1] . "</span><br/>
                <span>" . explode(':', $statistics->all_sold_dough)[1] . "</span><br/>
                <span>" . explode(':', $statistics->today_sold_dough)[1] . "</span><br/>
            </div>
        </div>
    </div>
    <div class='col-sm-12 col-mod-1'>
        <div class='col-sm-12 col-mod-1 thumbnail thymb-mi price'>
            <div class='col-md-6'>
                <span>" . Yii::t('app', 'Покупка Фарша') . "</span><br/>
                <span>" . Yii::t('app', 'Покупка Фарша сегодня') . "</span><br/>
                <span>" . Yii::t('app', 'Продажа Фарша') . "</span><br/>
                <span>" . Yii::t('app', 'Продажа Фарша сегодня') . "</span><br/>
            </div>
            <div class='col-md-3'>
                <span>" . explode(':', $statistics->all_bought_mince)[0] . "</span><br/>
                <span>" . explode(':', $statistics->today_bought_mince)[0] . "</span><br/>
                <span>" . explode(':', $statistics->all_sold_mince)[0] . "</span><br/>
                <span>" . explode(':', $statistics->today_sold_mince)[0] . "</span><br/>
            </div>
            <div class='col-md-3'>
                <span>" . explode(':', $statistics->all_bought_mince)[1] . "</span><br/>
                <span>" . explode(':', $statistics->today_bought_mince)[1] . "</span><br/>
                <span>" . explode(':', $statistics->all_sold_mince)[1] . "</span><br/>
                <span>" . explode(':', $statistics->today_sold_mince)[1] . "</span><br/>
            </div>
        </div>
    </div>
    <div class='col-sm-12 col-mod-1'>
        <div class='col-sm-12 col-mod-1 thumbnail thymb-mi price'>
            <div class='col-md-6'>
                <span>" . Yii::t('app', 'Покупка Сыра') . "</span><br/>
                <span>" . Yii::t('app', 'Покупка Сыра сегодня') . "</span><br/>
                <span>" . Yii::t('app', 'Продажа Сыра') . "</span><br/>
                <span>" . Yii::t('app', 'Продажа Сыра сегодня') . "</span><br/>
            </div>
            <div class='col-md-3'>
                <span>" . explode(':', $statistics->all_bought_cheese)[0] . "</span><br/>
                <span>" . explode(':', $statistics->today_bought_cheese)[0] . "</span><br/>
                <span>" . explode(':', $statistics->all_sold_cheese)[0] . "</span><br/>
                <span>" . explode(':', $statistics->today_sold_cheese)[0] . "</span><br/>
            </div>
            <div class='col-md-3'>
                <span>" . explode(':', $statistics->all_bought_cheese)[1] . "</span><br/>
                <span>" . explode(':', $statistics->today_bought_cheese)[1] . "</span><br/>
                <span>" . explode(':', $statistics->all_sold_cheese)[1] . "</span><br/>
                <span>" . explode(':', $statistics->today_sold_cheese)[1] . "</span><br/>
            </div>
        </div>
    </div>
    <div class='col-sm-12 col-mod-1'>
        <div class='col-sm-12 col-mod-1 thumbnail thymb-mi price'>
            <div class='col-md-6'>
                <span>" . Yii::t('app', 'Покупка Творога') . "</span><br/>
                <span>" . Yii::t('app', 'Покупка Творога сегодня') . "</span><br/>
                <span>" . Yii::t('app', 'Продажа Творога') . "</span><br/>
                <span>" . Yii::t('app', 'Продажа Творога сегодня') . "</span><br/>
            </div>
            <div class='col-md-3'>
                <span>" . explode(':', $statistics->all_bought_curd)[0] . "</span><br/>
                <span>" . explode(':', $statistics->today_bought_curd)[0] . "</span><br/>
                <span>" . explode(':', $statistics->all_sold_curd)[0] . "</span><br/>
                <span>" . explode(':', $statistics->today_sold_curd)[0] . "</span><br/>
            </div>
            <div class='col-md-3'>
                <span>" . explode(':', $statistics->all_bought_curd)[1] . "</span><br/>
                <span>" . explode(':', $statistics->today_bought_curd)[1] . "</span><br/>
                <span>" . explode(':', $statistics->all_sold_curd)[1] . "</span><br/>
                <span>" . explode(':', $statistics->today_sold_curd)[1] . "</span><br/>
            </div>
        </div>
    </div>";
                //echo '<pre>'; var_dump($tbody);
                return ['status' => true, 'htmlElement' => $htmlElement];
            }else{
                return ['status' => false, 'msg' => Yii::t('app', 'Ошибка на стороне сервера') . '!'];
            }
        }
        else
        {
            throw new NotFoundHttpException;
        }
    }

    public function actionQueuelistFair()
    {
        if (Yii::$app->user->isGuest) {
            throw new NotFoundHttpException;
        }
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = 'json';
            $queueList = SaleQueueList::find()
                ->where(['sale_queue_list.model_name' => 'ShopBakery'])
                ->andWhere(['>', 'sale_queue_list.count', 0])
                ->innerJoinWith('shopBakery', 'sale_queue_list.product_id = shop_bakery.id')
                ->orderBy(['queue_id' => SORT_ASC])
                ->all();
            if ($queueList) {
                $tbody = '';
                foreach($queueList as $queue) {
                    if($queue->user_id == Yii::$app->user->id){
                        $style = "style='background-color: rgba(76, 175, 80, .2)!important;'";
                    }else{
                        $style = '';
                    }
                    $tbody .= "<tr ".$style.">
                        <td>".$queue->shopBakery->name."
                            <input type='hidden' class='queueId' value='".$queue->queue_id."'>
                            <input class='productId' type='hidden' value='".$queue->product_id."'>
                            <input class='userId' type='hidden' value='".$queue->user_id."'>
                            <input class='price' type='hidden' value='".$queue->shopBakery->price_to_buy."'><!--Цена за 1 ед-->
                            <input class='alias' type='hidden' value='".$queue->shopBakery->alias."'>
                        </td>
                        <td class='queueCount'>".$queue->count."</td>
                        <td>".$queue->shopBakery->price_to_buy."</td><!--Цена за 1 ед-->
                        <td>".date('d.m.Y H:i:s', $queue->sell_time)."</td>
                    </tr>";
                }
                return ['status' => true, 'tbody' => $tbody];
            } else {
                return ['status' => false, 'msg' => Yii::t('app', 'Пирогов в продаже нет') . '!'];
            }
        } else {
            throw new NotFoundHttpException;
        }
    }

    public function actionProductForSell()
    {
        if (Yii::$app->user->isGuest) {
            throw new NotFoundHttpException;
        }
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = 'json';
            $results['for_sale'][] = FabricProductType::find()
                ->select(['id', 'name', 'img', 'alias2', 'model_name', 'price_for_sell', 'min_count_for_sell'])
                ->all();
            $results['for_sale'][] = ProductForBakery::find()
                ->select(['id', 'name', 'img', 'alias2', 'model_name', 'price_for_sell', 'min_count_for_sell'])
                ->all();
            $results['for_sale'][] = ShopBakery::find()
                ->select(['id', 'name', 'img', 'alias2', 'model_name', 'price_for_sell', 'min_count_for_sell'])
                ->all();

            $userStorage = UserStorage::find()
                ->where(['user_id' => Yii::$app->user->id])
                ->asArray()
                ->all();
            foreach ($results['for_sale'] as $k => $products) {
                foreach ($products as $p_k => $product) {
                    foreach ($userStorage as $skey => $storage) {
                        $results['for_sale'][$k][$p_k]->count = $storage[$product->alias2];
                        unset($userStorage[$skey][$product->alias2]);
                    }
                }
            }
            $forSell = '';
            foreach ($results['for_sale'] as $products) {
                foreach ($products as $product) {
                    $forSell .= "<div class='col-sm-4 col-mod-1'>
                        <div class='thumbnail thymb-mi'>
                            <div class='captions'>
                                <div class='row raw storage'>
                                    <div class='col-md-3 imag-stock-min'>
                                        <img src='" . Yii::$app->homeUrl . "img/product/" . $product->img . "'
                                             class='sale-mod'/>
                                        <span class='badge bmd-bg-success sette for-sale'
                                              id='" . $product->alias2 . "'>" . $product->count . "</span>
                                    </div>
                                    <div class='col-md-7 col-mod-1 sette height'>
                                        <span class='font-style'>" . $product->name . "</span>
                                    </div>
                                    <center>
                                        <div class='btn-group sette'>
                                            <button
                                                class='btn btn-success bmd-ripple bmd-flat-btn but-ton fs_style set dropdown-toggle'
                                                type='button' data-toggle='dropdown'>". Yii::t('app', 'Продать') ."
                                            </button>
                                            <ul class='dropdown-menu menu-style'>
                                                <div class='input-group'>
                                                    <input type='number' class='in-put form-control product-count' min='100'
                                                           value='" . $product->min_count_for_sell . "'
                                                           data-id='" . $product->id . "'
                                                           data-model='" . $product->model_name . "'
                                                           data-price='" . $product->price_for_sell . "'
                                                           data-min_count='" . $product->min_count_for_sell . "'
                                                           data-alias='" . $product->alias2 . "'
                                                           data-current_count='" . $product->count . "'>
                                                    <span class='input-group-btn'>";
                                                    if ($product->model_name == 'ShopBakery') {
                                                        $sell = 'cake-sell';
                                                    } else {
                                                        $sell = 'product-sell';
                                                    }
                                                    $forSell .= "<button class='btn btn-success but-ton $sell'
                                                            type='button'>". Yii::t('app', 'Продать') ."
                                                        </button>
                                                    </span>
                                                </div>
                                            </ul>
                                        </div>
                                    </center>
                                    <div class='col-md-12 col-mod-1 sette'>
                                        <span class='price fs_style'>
                                            <span class='badge bmd-bg-success sette'>" . $product->price_for_sell . "
                                                ". Yii::t('app', 'Руб/ед') ."</span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>";
                }
            }
            return ['status' => true, 'forSell' => $forSell];
        }else {
            throw new NotFoundHttpException;
        }
    }

}
