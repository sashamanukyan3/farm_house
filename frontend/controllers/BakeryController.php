<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 29.01.2016
 * Time: 18:23
 */

namespace frontend\controllers;

use common\models\Bakeries;
use common\models\CheeseBakery;
use common\models\CurdBakery;
use common\models\MeatBakery;
use common\models\Settings;
use common\models\User;
use common\models\UserStorage;
use yii\web\NotFoundHttpException;
use Yii;

class BakeryController extends \yii\web\Controller
{
    public function actionBuildBakery(){
        if(Yii::$app->user->isGuest)
        {
            throw new NotFoundHttpException;
        }
        if(Yii::$app->request->isAjax) {
            Yii::$app->response->format = 'json';
            $factoryId = Yii::$app->request->post('item_id');
            $pole = Yii::$app->request->post('pole');
            $level = Yii::$app->request->post('level');
            $modelName = Yii::$app->request->post('modelName');
            $userLevel = Yii::$app->user->identity->level;
            $userId = Yii::$app->user->id;
            $model = UserStorage::find()->where(['user_id' => $userId])->one();
            $countProduct = 0;
            if (!empty($factoryId)) {
                switch ($modelName) {
                    case 'MeatBakery':
                        $build = MeatBakery::find()->where(['status_id'=>0])->andWhere(['user_id'=>$userId])->andWhere(['item_id' => $factoryId])->one();
                        if(count($build) != 0) {
                            if ($model->meat_bakery > 0) {
                                $model->meat_bakery -= 1;
                                $model->save();
                                Yii::$app->db->createCommand()
                                    ->update('meat_bakery', ['status_id' => MeatBakery::STATUS_READY, 'count_product' => $countProduct], 'item_id = :id', ['id' => $factoryId])
                                    ->execute();
                                if ($pole == 'pole-9') {
                                    //create 9 cow_items
                                    $factoryItems = array();
                                    for ($j = $level + 30; $j <= $level + 270; $j += 30) {
                                        $factoryItems[$j]['user_id'] = $userId;
                                        if ($j == 1) {
                                            $factoryItems[$j]['status_id'] = MeatBakery::STATUS_READY;
                                        } else {
                                            $factoryItems[$j]['status_id'] = MeatBakery::STATUS_NOT_AVAILABLE;
                                        }
                                        $factoryItems[$j]['level'] = $j;
                                    }
                                    Yii::$app->db->createCommand()
                                        ->batchInsert('meat_bakery', ['user_id', 'status_id', 'level'], $factoryItems)
                                        ->execute();
                                    unset($factoryItems);
                                }
                            } else {
                                return ['status' => false, 'msg' => Yii::t('app', 'У вас нет пекарни в наличии') . '!'];
                            }
                            return ['status' => true, 'msg' => Yii::t('app', 'Поздравляем, вы построили пекарню пирога с мясом') . '!'];
                        }else {
                            return ['status' => false, 'msg' => Yii::t('app', 'Здесь уже построена пекарня, обновите страницу') . '!'];
                        }
                        break;

                    case 'CheeseBakery': //мясо
                        $build = CheeseBakery::find()->where(['status_id'=>0])->andWhere(['user_id'=>$userId])->andWhere(['item_id' => $factoryId])->one();
                        if(count($build) != 0) {
                            if ($model->cheese_bakery > 0) {
                                $model->cheese_bakery -= 1;
                                $model->save();
                                Yii::$app->db->createCommand()
                                    ->update('cheese_bakery', ['status_id' => CheeseBakery::STATUS_READY, 'count_product' => $countProduct], 'item_id = :id', ['id' => $factoryId])
                                    ->execute();
                                if ($pole == 'pole-9') {
                                    //create 9 cow_items
                                    $factoryItems = array();
                                    for ($j = $level + 30; $j <= $level + 270; $j += 30) {
                                        $factoryItems[$j]['user_id'] = $userId;
                                        if ($j == 1) {
                                            $factoryItems[$j]['status_id'] = CheeseBakery::STATUS_READY;
                                        } else {
                                            $factoryItems[$j]['status_id'] = CheeseBakery::STATUS_NOT_AVAILABLE;
                                        }
                                        $factoryItems[$j]['level'] = $j;
                                    }
                                    Yii::$app->db->createCommand()
                                        ->batchInsert('cheese_bakery', ['user_id', 'status_id', 'level'], $factoryItems)
                                        ->execute();
                                    unset($factoryItems);
                                }
                            } else {
                                return ['status' => false, 'msg' => Yii::t('app', 'У вас нет пекарни в наличии') . '!'];
                            }
                            return ['status' => true, 'msg' => Yii::t('app', 'Поздравляем, вы построили пекарню пирога с сыром') . '!'];
                        }else {
                            return ['status' => false, 'msg' => Yii::t('app', 'Здесь уже построена пекарня, обновите страницу') . '!'];
                        }
                        break;

                    case 'CurdBakery':
                        $build = CurdBakery::find()->where(['status_id'=>0])->andWhere(['user_id'=>$userId])->andWhere(['item_id' => $factoryId])->one();
                        if(count($build) != 0) {
                            if ($model->curd_bakery > 0) {
                                $model->curd_bakery -= 1;
                                $model->save();
                                Yii::$app->db->createCommand()
                                    ->update('curd_bakery', ['status_id' => CurdBakery::STATUS_READY, 'count_product' => $countProduct], 'item_id = :id', ['id' => $factoryId])
                                    ->execute();
                                if ($pole == 'pole-9') {
                                    //create 9 cow_items
                                    $factoryItems = array();
                                    for ($j = $level + 30; $j <= $level + 270; $j += 30) {
                                        $factoryItems[$j]['user_id'] = $userId;
                                        if ($j == 1) {
                                            $factoryItems[$j]['status_id'] = CurdBakery::STATUS_READY;
                                        } else {
                                            $factoryItems[$j]['status_id'] = CurdBakery::STATUS_NOT_AVAILABLE;
                                        }
                                        $factoryItems[$j]['level'] = $j;
                                    }
                                    Yii::$app->db->createCommand()
                                        ->batchInsert('curd_bakery', ['user_id', 'status_id', 'level'], $factoryItems)
                                        ->execute();
                                    unset($factoryItems);
                                }
                            } else {
                                return ['status' => false, 'msg' => Yii::t('app', 'У вас нет пекарни в наличии') . '!'];
                            }
                            return ['status' => true, 'msg' => Yii::t('app', 'Поздравляем, вы построили пекарню пирога с творогом') . '!'];
                        }else {
                            return ['status' => false, 'msg' => Yii::t('app', 'Здесь уже построена пекарня, обновите страницу') . '!'];
                        }
                        break;
                }
            }else {
                return ['status' => false, 'msg' => Yii::t('app', 'Ошибка на стороне сервера') . '!'];
            }
        }
        else
        {
            throw new NotFoundHttpException;
        }
    } //построить пекарни

    public function actionRunBakery(){
        if(Yii::$app->user->isGuest)
        {
            throw new NotFoundHttpException;
        }
        if(Yii::$app->request->isAjax) {
            Yii::$app->response->format = 'json';
            $factoryId = Yii::$app->request->post('item_id');
            $modelName = Yii::$app->request->post('modelName');
            $userId = Yii::$app->user->id;
            $user = User::find()->where(['id' => $userId])->one();
            $userEnergy = $user->energy;
            $label = false;
            $showLevel = false;
            $newLevel = false;
            $userStorage = UserStorage::find()->where(['user_id' => $userId])->one();
            if (!empty($factoryId)) {
                //$experience += 100;
                switch ($modelName) {
                    case 'MeatBakery':
                        if($userEnergy >= Settings::$energyForRunMeatBakery) {//энергия запуска
                            $userEnergy -= Settings::$energyForRunMeatBakery;
                            $ready = MeatBakery::find()->where(['status_id' => MeatBakery::STATUS_READY])->andWhere(['user_id' => $userId])->andWhere(['item_id' => $factoryId])->one();
                            $expBakery = Bakeries::find()->select(['experience'])->where(['alias' => 'meat_bakery'])->one();
                            if (count($ready) != 0) {
                                if ($userStorage->dough >= Settings::$countDoughForRunBakery && $userStorage->mince >= Settings::$countMinceForRunBakery) {
                                    $userStorage->dough -= Settings::$countDoughForRunBakery;
                                    $userStorage->mince -= Settings::$countMinceForRunBakery;
                                    $factory = MeatBakery::find()->where(['item_id' => $factoryId])->one();
                                    $factory->status_id = MeatBakery::STATUS_RUN;
                                    $factory->time_start = time();
                                    $factory->time_finish = strtotime('tomorrow');
                                    $factory->save();
                                    Yii::$app->db->createCommand()
                                        ->update('user', ['energy' => $userEnergy], 'id = :id', ['id' => $userId])
                                        ->execute();
                                    $userStorage->save();
                                    if ($newLevel = $user->isLevelUp($expBakery->experience)) {
                                        $showLevel = true;
                                    }
                                    $experience = $user->experience;
                                    return ['status' => true, 'msg' => Yii::t('app', 'Поздравляем вы запустили пекарню') . '!', 'energy' => $userEnergy, 'exp' => $experience, 'dough' => $userStorage->dough, 'mince' => $userStorage->mince, 'label' => $label, 'showLevel' => $showLevel, 'newLevel' => $newLevel];
                                } else {
                                    return ['status' => false, 'msg' => Yii::t('app', 'У вас недостаточно продукции, необходимо {doughUnits} ед. тесто и {stuffingUnits} ед. фарша', [
                                        'doughUnits' => Settings::$countDoughForRunBakery,
                                        'stuffingUnits' => Settings::$countMinceForRunBakery,
                                    ]) . '!'];
                                }
                            } else {
                                return ['status' => false, 'msg' => Yii::t('app', 'Пекарня уже запущена, обновите страницу') . '!'];
                            }
                        }else{
                            return ['status' => false, 'msg' => Yii::t('app', 'У вас недостаточно {energyUnits} энергии', [
                                'energyUnits' => Settings::$energyForRunMeatBakery - $userEnergy,
                            ]) . '!'];
                        }
                        break;

                    case 'CheeseBakery':
                        if($userEnergy >= Settings::$energyForRunCheeseBakery) {//энергия запуска
                            $userEnergy -= Settings::$energyForRunCheeseBakery;
                            $ready = CheeseBakery::find()->where(['status_id' => CheeseBakery::STATUS_READY])->andWhere(['user_id' => $userId])->andWhere(['item_id' => $factoryId])->one();
                            $expBakery = Bakeries::find()->select(['experience'])->where(['alias' => 'cheese_bakery'])->one();
                            if (count($ready) != 0) {
                                if ($userStorage->dough >= Settings::$countDoughForRunBakery && $userStorage->cheese >= Settings::$countCheeseForRunBakery) {
                                    $userStorage->dough -= Settings::$countDoughForRunBakery;
                                    $userStorage->cheese -= Settings::$countCheeseForRunBakery;
                                    $factory = CheeseBakery::find()->where(['item_id' => $factoryId])->one();
                                    $factory->status_id = CheeseBakery::STATUS_RUN;
                                    $factory->time_start = time();
                                    $factory->time_finish = strtotime('tomorrow');
                                    $factory->save();
                                    Yii::$app->db->createCommand()
                                        ->update('user', ['energy' => $userEnergy], 'id = :id', ['id' => $userId])
                                        ->execute();
                                    $userStorage->save();
                                    if ($newLevel = $user->isLevelUp($expBakery->experience)) {
                                        $showLevel = true;
                                    }
                                    $experience = $user->experience;
                                    return ['status' => true, 'msg' => Yii::t('app', 'Поздравляем вы запустили пекарню') . '!', 'energy' => $userEnergy, 'exp' => $experience, 'dough' => $userStorage->dough, 'cheese' => $userStorage->cheese, 'label' => $label, 'showLevel' => $showLevel, 'newLevel' => $newLevel];
                                } else {
                                    return ['status' => false, 'msg' => Yii::t('app', 'У вас недостаточно продукции, необходимо {doughUnits} ед. тесто и {cheeseUnits} ед. сыра', [
                                        'doughUnits' => Settings::$countDoughForRunBakery,
                                        'cheeseUnits' => Settings::$countCheeseForRunBakery,
                                    ]) . '!'];
                                }
                            } else {
                                return ['status' => false, 'msg' => Yii::t('app', 'Пекарня уже запущена, обновите страницу') . '!'];
                            }
                        } else{
                            return ['status' => false, 'msg' => Yii::t('app', 'У вас недостаточно {energyUnits} энергии', [
                                'energyUnits' => Settings::$energyForRunCheeseBakery - $userEnergy,
                            ]) . '!'];
                        }
                        break;

                    case 'CurdBakery':
                        if($userEnergy >= Settings::$energyForRunCurdBakery) {//энергия запуска
                            $userEnergy -= Settings::$energyForRunCurdBakery;
                            $ready = CurdBakery::find()->where(['status_id' => CurdBakery::STATUS_READY])->andWhere(['user_id' => $userId])->andWhere(['item_id' => $factoryId])->one();
                            $expBakery = Bakeries::find()->select(['experience'])->where(['alias' => 'curd_bakery'])->one();
                            if (count($ready) != 0) {
                                if ($userStorage->dough >= Settings::$countDoughForRunBakery && $userStorage->curd >= Settings::$countCurdForRunBakery) {
                                    $userStorage->dough -= Settings::$countDoughForRunBakery;
                                    $userStorage->curd -= Settings::$countCurdForRunBakery;
                                    $factory = CurdBakery::find()->where(['item_id' => $factoryId])->one();
                                    $factory->status_id = CurdBakery::STATUS_RUN;
                                    $factory->time_start = time();
                                    $factory->time_finish = strtotime('tomorrow');
                                    $factory->save();
                                    Yii::$app->db->createCommand()
                                        ->update('user', ['energy' => $userEnergy], 'id = :id', ['id' => $userId])
                                        ->execute();
                                    $userStorage->save();
                                    if ($newLevel = $user->isLevelUp($expBakery->experience)) {
                                        $showLevel = true;
                                    }
                                    $experience = $user->experience;
                                    return ['status' => true, 'msg' => Yii::t('app', 'Поздравляем вы запустили пекарню') . '!', 'energy' => $userEnergy, 'exp' => $experience, 'dough' => $userStorage->dough, 'curd' => $userStorage->curd, 'label' => $label, 'showLevel' => $showLevel, 'newLevel' => $newLevel];
                                } else {
                                    return ['status' => false, 'msg' => Yii::t('app', 'У вас недостаточно продукции, необходимо {doughUnits} ед. тесто и {curdUnits} ед. творога', [
                                        'doughUnits' => Settings::$countDoughForRunBakery,
                                        'curdUnits' => Settings::$countCurdForRunBakery,
                                    ]) . '!'];
                                }
                            } else {
                                return ['status' => false, 'msg' => Yii::t('app', 'Пекарня уже запущена, обновите страницу') . '!'];
                            }
                        } else{
                            return ['status' => false, 'msg' => Yii::t('app', 'У вас недостаточно {energyUnits} энергии', [
                                'energyUnits' => Settings::$energyForRunCurdBakery - $userEnergy,
                            ]) . '!'];
                        }
                        break;
                    }
            }else {
                return ['status' => false, 'msg' => Yii::t('app', 'Ошибка на стороне сервера') . '!'];
            }
        }
        else
        {
            throw new NotFoundHttpException;
        }
    }

    public function actionCollectProduct(){
        if(Yii::$app->user->isGuest)
        {
            throw new NotFoundHttpException;
        }
        if(Yii::$app->request->isAjax) {
            Yii::$app->response->format = 'json';
            $factoryId = Yii::$app->request->post('item_id');
            $modelName = Yii::$app->request->post('modelName');
            $userId = Yii::$app->user->id;
            $userEnergy = Yii::$app->user->identity->energy;
            //$experience = Yii::$app->user->identity->experience;
            $user = User::find()->where(['id' => $userId])->one();
            $label = false;
            $showLevel = false;
            $newLevel = false;
            $userStorage = UserStorage::find()->where(['user_id' => $userId])->one();
            if (!empty($factoryId)) {
                //$experience += 100;
                switch ($modelName) {
                    case 'MeatBakery':
                        $readyProduct = MeatBakery::find()->where(['status_id'=>MeatBakery::STATUS_READY_PRODUCT])->andWhere(['user_id'=>$userId])->andWhere(['item_id' => $factoryId])->one();
                        $getBakery = Bakeries::find()->select(['energy', 'experience'])->where(['alias' => 'meat_bakery'])->one();
                        if(count($readyProduct) != 0) {
                            if ($userEnergy >= $getBakery->energy) {
                                $userEnergy -= $getBakery->energy;
                                $userStorage->cakewithmeat_for_sell += Settings::$countCakeWithMeat;
                                $factory = MeatBakery::find()->where(['item_id' => $factoryId])->one();
                                $factory->count_product += 1;
                                if ($factory->count_product == Settings::$countCollectProductBakery) {
                                    $factory->status_id = MeatBakery::STATUS_AVAILABLE;
                                    $label = true;
                                } else {
                                    $factory->status_id = MeatBakery::STATUS_READY;
                                }
                                $factory->time_start = 0;
                                $factory->time_finish = 0;
                                $factory->save();
                                Yii::$app->db->createCommand()
                                    ->update('user', ['energy' => $userEnergy], 'id = :id', ['id' => $userId])
                                    ->execute();
                                $userStorage->save();
                                if ($newLevel = $user->isLevelUp($getBakery->experience)) {
                                    $showLevel = true;
                                }
                                $experience = $user->experience;
                                return ['status' => true, 'msg' => Yii::t('app', 'Поздравляем вы получили {piesUnits} пирога с мясом', [
                                    'piesUnits' => Settings::$countCakeWithMeat,
                                ]) . '!', 'energy' => $userEnergy, 'exp' => $experience, 'cakewithmeat_for_sell' => $userStorage->cakewithmeat_for_sell, 'label' => $label, 'showLevel' => $showLevel, 'newLevel' => $newLevel];
                            } else {
                                return ['status' => false, 'msg' => Yii::t('app', 'У вас недостаточно {energyUnits} энергии', [
                                    'energyUnits' => $getBakery->experience - $userEnergy,
                                ]) . '!'];
                            }
                        }else{
                            return ['status' => false, 'msg' => Yii::t('app', 'Продукция уже собрана, обновите страницу') . '!'];
                        }
                        break;

                    case 'CheeseBakery':
                        $readyProduct = CheeseBakery::find()->where(['status_id'=>CheeseBakery::STATUS_READY_PRODUCT])->andWhere(['user_id'=>$userId])->andWhere(['item_id' => $factoryId])->one();
                        $getBakery = Bakeries::find()->select(['energy', 'experience'])->where(['alias' => 'cheese_bakery'])->one();
                        if(count($readyProduct) != 0) {
                            if ($userEnergy >= $getBakery->energy) {
                                $userEnergy -= $getBakery->energy;
                                $userStorage->cakewithcheese_for_sell += Settings::$countCakeWithCheese;
                                $factory = CheeseBakery::find()->where(['item_id' => $factoryId])->one();
                                $factory->count_product += 1;
                                if ($factory->count_product == Settings::$countCollectProductBakery) {
                                    $factory->status_id = CheeseBakery::STATUS_AVAILABLE;
                                    $label = true;
                                } else {
                                    $factory->status_id = CheeseBakery::STATUS_READY;
                                }
                                $factory->time_start = 0;
                                $factory->time_finish = 0;
                                $factory->save();
                                Yii::$app->db->createCommand()
                                    ->update('user', ['energy' => $userEnergy], 'id = :id', ['id' => $userId])
                                    ->execute();
                                $userStorage->save();
                                if ($newLevel = $user->isLevelUp($getBakery->experience)) {
                                    $showLevel = true;
                                }
                                $experience = $user->experience;
                                return ['status' => true, 'msg' => Yii::t('app', 'Поздравляем вы получили {piesUnits} пирога с сыром', [
                                    'piesUnits' => Settings::$countCakeWithCheese,
                                ]) . '!', 'energy' => $userEnergy, 'exp' => $experience, 'cakewithcheese_for_sell' => $userStorage->cakewithcheese_for_sell, 'label' => $label, 'showLevel' => $showLevel, 'newLevel' => $newLevel];
                            } else {
                                return ['status' => false, 'msg' => Yii::t('app', 'У вас недостаточно {energyUnits} энергии', [
                                    'energyUnits' => $getBakery->energy - $userEnergy,
                                ]) . '!'];
                            }
                        }else{
                            return ['status' => false, 'msg' => Yii::t('app', 'Продукция уже собрана, обновите страницу') . '!'];
                        }
                        break;

                    case 'CurdBakery':
                        $readyProduct = CurdBakery::find()->where(['status_id'=>CurdBakery::STATUS_READY_PRODUCT])->andWhere(['user_id'=>$userId])->andWhere(['item_id' => $factoryId])->one();
                        $getBakery = Bakeries::find()->select(['energy', 'experience'])->where(['alias' => 'curd_bakery'])->one();
                        if(count($readyProduct) != 0) {
                            if ($userEnergy >= $getBakery->energy) {
                                $userEnergy -= $getBakery->energy;
                                $userStorage->cakewithcurd_for_sell += Settings::$countCakeWithCurd;
                                $factory = CurdBakery::find()->where(['item_id' => $factoryId])->one();
                                $factory->count_product += 1;
                                if ($factory->count_product == Settings::$countCollectProductBakery) {
                                    $factory->status_id = CurdBakery::STATUS_AVAILABLE;
                                    $label = true;
                                } else {
                                    $factory->status_id = CurdBakery::STATUS_READY;
                                }
                                $factory->time_start = 0;
                                $factory->time_finish = 0;
                                $factory->save();
                                Yii::$app->db->createCommand()
                                    ->update('user', ['energy' => $userEnergy], 'id = :id', ['id' => $userId])
                                    ->execute();
                                $userStorage->save();
                                if ($newLevel = $user->isLevelUp($getBakery->experience)) {
                                    $showLevel = true;
                                }
                                $experience = $user->experience;
                                return ['status' => true, 'msg' => Yii::t('app', 'Поздравляем вы получили {piesUnits} пирога с творогом', [
                                    'piesUnits' => Settings::$countCakeWithCurd,
                                ]) . '!', 'energy' => $userEnergy, 'exp' => $experience, 'cakewithcurd_for_sell' => $userStorage->cakewithcurd_for_sell, 'label' => $label, 'showLevel' => $showLevel, 'newLevel' => $newLevel];
                            } else {
                                return ['status' => false, 'msg' => Yii::t('app', 'У вас недостаточно {energyUnits} энергии', [
                                    'energyUnits' => $getBakery->experience - $userEnergy,
                                ]) . '!'];
                            }
                        }else{
                            return ['status' => false, 'msg' => Yii::t('app', 'Продукция уже собрана, обновите страницу') . '!'];
                        }
                        break;
                }
            }else {
                return ['status' => false, 'msg' => Yii::t('app', 'Ошибка на стороне сервера') . '!'];
            }
        }
        else
        {
            throw new NotFoundHttpException;
        }
    }

    public function actionCheck()
    {
        if(Yii::$app->user->isGuest)
        {
            throw new NotFoundHttpException;
        }
        if(Yii::$app->request->isAjax) {
            Yii::$app->response->format = 'json';
            $modelName = Yii::$app->request->post('modelName');
            $itemId    = Yii::$app->request->post('item_id');
            if(!empty($itemId) && !empty($modelName))
            {
                switch($modelName){
                    case 'MeatBakery':
                        $factory = MeatBakery::findOne(['item_id'=>$itemId]);
                        $timeNow = time();
                        $timeFinish = (int)$factory->time_finish;
                        if ($timeNow < $timeFinish) {
                            $diff = $timeFinish - $timeNow;
                            return ['status' => false, 'timer' => $diff, 'count'=>$factory->count_product . '/365'];
                        } else {
                            $factory->status_id = MeatBakery::STATUS_READY_PRODUCT;
                            $factory->save();
                            return ['status' => true, 'alias' => $factory->plant_alias, 'msg' => Yii::t('app', 'Продукция готова') . '!'];
                        }
                        break;
                    case 'CheeseBakery':
                        $factory = CheeseBakery::findOne(['item_id'=>$itemId]);
                        $timeNow = time();
                        $timeFinish = (int)$factory->time_finish;
                        if ($timeNow < $timeFinish) {
                            $diff = $timeFinish - $timeNow;
                            return ['status' => false, 'timer' => $diff, 'count'=>$factory->count_product . '/365'];
                        } else {
                            $factory->status_id = CheeseBakery::STATUS_READY_PRODUCT;
                            $factory->save();
                            return ['status' => true, 'alias' => $factory->plant_alias, 'msg' => Yii::t('app', 'Продукция готова') . '!'];
                        }
                        break;
                    case 'CurdBakery':
                        $factory = CurdBakery::findOne(['item_id'=>$itemId]);
                        $timeNow = time();
                        $timeFinish = (int)$factory->time_finish;
                        if ($timeNow < $timeFinish) {
                            $diff = $timeFinish - $timeNow;
                            return ['status' => false, 'timer' => $diff, 'count'=>$factory->count_product . '/365'];
                        } else {
                            $factory->status_id = CurdBakery::STATUS_READY_PRODUCT;
                            $factory->save();
                            return ['status' => true, 'alias' => $factory->plant_alias, 'msg' => Yii::t('app', 'Продукция готова') . '!'];
                        }
                        break;
                }
            }
        }
        else
        {
            throw new NotFoundHttpException;
        }
    }
}
