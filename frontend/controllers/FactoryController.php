<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 29.01.2016
 * Time: 17:14
 */

namespace frontend\controllers;
use common\models\Factories;
use common\models\FactoryCheese;
use common\models\FactoryCurd;
use common\models\FactoryDough;
use common\models\FactoryMince;
use common\models\Settings;
use common\models\User;
use common\models\UserStorage;
use Yii;
use yii\web\NotFoundHttpException;

class FactoryController extends \yii\web\Controller
{
    public function actionBuildFactory(){
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
            $userId = Yii::$app->user->id;
            $model = UserStorage::find()->where(['user_id' => $userId])->one();
            $countProduct = 0;
            if (!empty($factoryId)) {
                switch ($modelName) {
                    case 'FactoryDough':
                        $build = FactoryDough::find()->where(['status_id'=>0])->andWhere(['user_id'=>$userId])->andWhere(['item_id' => $factoryId])->one();
                        if(count($build) != 0) {
                            if ($model->factory_dough > 0) {
                                $model->factory_dough -= 1;
                                $model->save();
                                Yii::$app->db->createCommand()
                                    ->update('factory_dough', ['status_id' => FactoryDough::STATUS_READY, 'count_product' => $countProduct], 'item_id = :id', ['id' => $factoryId])
                                    ->execute();

                                if ($pole == 'pole-9') {
                                    //create 9 cow_items
                                    $factoryItems = array();
                                    for ($j = $level + 40; $j <= $level + 360; $j += 40) {
                                        $factoryItems[$j]['user_id'] = $userId;
                                        if ($j == 1) {
                                            $factoryItems[$j]['status_id'] = FactoryDough::STATUS_READY;
                                        } else {
                                            $factoryItems[$j]['status_id'] = FactoryDough::STATUS_NOT_AVAILABLE;
                                        }
                                        $factoryItems[$j]['level'] = $j;
                                    }
                                    Yii::$app->db->createCommand()
                                        ->batchInsert('factory_dough', ['user_id', 'status_id', 'level'], $factoryItems)
                                        ->execute();
                                    unset($factoryItems);
                                }
                            } else {
                                return ['status' => false, 'msg' => Yii::t('app', 'У вас нет фабрики в наличии') . '!'];
                            }
                        }else {
                            return ['status' => false, 'msg' => Yii::t('app', 'Здесь уже построена фабрика, обновите страницу') . '!'];
                        }
                        return ['status' => true, 'msg' => Yii::t('app', 'Поздравляем, вы построили фабрику теста') . '!'];
                        break;

                    case 'FactoryMince': //мясо
                        $build = FactoryMince::find()->where(['status_id'=>0])->andWhere(['user_id'=>$userId])->andWhere(['item_id' => $factoryId])->one();
                        if(count($build) != 0) {
                            if ($model->factory_mince > 0) {
                                $model->factory_mince -= 1;
                                $model->save();
                                Yii::$app->db->createCommand()
                                    ->update('factory_mince', ['status_id' => FactoryMince::STATUS_READY, 'count_product' => $countProduct], 'item_id = :id', ['id' => $factoryId])
                                    ->execute();

                                if ($pole == 'pole-9') {
                                    //create 9 cow_items
                                    $factoryItems = array();
                                    for ($j = $level + 40; $j <= $level + 360; $j += 40) {
                                        $factoryItems[$j]['user_id'] = $userId;
                                        if ($j == 1) {
                                            $factoryItems[$j]['status_id'] = FactoryMince::STATUS_READY;
                                        } else {
                                            $factoryItems[$j]['status_id'] = FactoryMince::STATUS_NOT_AVAILABLE;
                                        }
                                        $factoryItems[$j]['level'] = $j;
                                    }
                                    Yii::$app->db->createCommand()
                                        ->batchInsert('factory_mince', ['user_id', 'status_id', 'level'], $factoryItems)
                                        ->execute();
                                    unset($factoryItems);
                                }
                            } else {
                                return ['status' => false, 'msg' => Yii::t('app', 'У вас нет фабрики в наличии') . '!'];
                            }
                        }else {
                            return ['status' => false, 'msg' => Yii::t('app', 'Здесь уже построена фабрика, обновите страницу') . '!'];
                        }
                        return ['status' => true, 'msg' => Yii::t('app', 'Поздравляем, вы построили фабрику фарша') . '!'];
                        break;

                    case 'FactoryCheese':
                        $build = FactoryCheese::find()->where(['status_id'=>0])->andWhere(['user_id'=>$userId])->andWhere(['item_id' => $factoryId])->one();
                        if(count($build) != 0) {
                            if ($model->factory_cheese > 0) {
                                $model->factory_cheese -= 1;
                                $model->save();
                                Yii::$app->db->createCommand()
                                    ->update('factory_cheese', ['status_id' => FactoryCheese::STATUS_READY, 'count_product' => $countProduct], 'item_id = :id', ['id' => $factoryId])
                                    ->execute();

                                if ($pole == 'pole-9') {
                                    //create 9 cow_items
                                    $factoryItems = array();
                                    for ($j = $level + 40; $j <= $level + 360; $j += 40) {
                                        $factoryItems[$j]['user_id'] = $userId;
                                        if ($j == 1) {
                                            $factoryItems[$j]['status_id'] = FactoryCheese::STATUS_READY;
                                        } else {
                                            $factoryItems[$j]['status_id'] = FactoryCheese::STATUS_NOT_AVAILABLE;
                                        }
                                        $factoryItems[$j]['level'] = $j;
                                    }
                                    Yii::$app->db->createCommand()
                                        ->batchInsert('factory_cheese', ['user_id', 'status_id', 'level'], $factoryItems)
                                        ->execute();
                                    unset($factoryItems);
                                }
                            } else {
                                return ['status' => false, 'msg' => Yii::t('app', 'У вас нет фабрики в наличии') . '!'];
                            }
                        }else {
                            return ['status' => false, 'msg' => Yii::t('app', 'Здесь уже построена фабрика, обновите страницу') . '!'];
                        }
                        return ['status' => true, 'msg' => Yii::t('app', 'Поздравляем, вы построили фабрику сыра') . '!'];
                        break;

                    case 'FactoryCurd':
                        $build = FactoryCurd::find()->where(['status_id'=>0])->andWhere(['user_id'=>$userId])->andWhere(['item_id' => $factoryId])->one();
                        if(count($build) != 0) {
                            if ($model->factory_curd > 0) {
                                $model->factory_curd -= 1;
                                $model->save();
                                Yii::$app->db->createCommand()
                                    ->update('factory_curd', ['status_id' => FactoryCurd::STATUS_READY, 'count_product' => $countProduct], 'item_id = :id', ['id' => $factoryId])
                                    ->execute();

                                if ($pole == 'pole-9') {
                                    //create 9 cow_items
                                    $factoryItems = array();
                                    for ($j = $level + 40; $j <= $level + 360; $j += 40) {
                                        $factoryItems[$j]['user_id'] = $userId;
                                        if ($j == 1) {
                                            $factoryItems[$j]['status_id'] = FactoryCurd::STATUS_READY;
                                        } else {
                                            $factoryItems[$j]['status_id'] = FactoryCurd::STATUS_NOT_AVAILABLE;
                                        }
                                        $factoryItems[$j]['level'] = $j;
                                    }
                                    Yii::$app->db->createCommand()
                                        ->batchInsert('factory_curd', ['user_id', 'status_id', 'level'], $factoryItems)
                                        ->execute();
                                    unset($factoryItems);
                                }
                            } else {
                                return ['status' => false, 'msg' => Yii::t('app', 'У вас нет фабрики в наличии') . '!'];
                            }
                        }else {
                            return ['status' => false, 'msg' => Yii::t('app', 'Здесь уже построена фабрика, обновите страницу') . '!'];
                        }
                        return ['status' => true, 'msg' => Yii::t('app', 'Поздравляем, вы построили фабрику творога') . '!'];
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
    } //построить фабрики

    public function actionRunFactory(){
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
                if ($userEnergy >= Settings::$energyForRunFactory) {
                    $userEnergy -= Settings::$energyForRunFactory;
                    //$experience += 100;
                    switch ($modelName) {
                        case 'FactoryDough':
                            $ready = FactoryDough::find()->where(['status_id'=>FactoryDough::STATUS_READY])->andWhere(['user_id'=>$userId])->andWhere(['item_id' => $factoryId])->one();
                            $expRun = Factories::find()->select(['experience'])->where(['alias'=>'factory_dough'])->one();
                            if(count($ready) != 0) {
                                if ($userStorage->egg >= Settings::$countEggForRunFactoryDough) {
                                    $userStorage->egg -= Settings::$countEggForRunFactoryDough;
                                    $factory = FactoryDough::find()->where(['item_id' => $factoryId])->one();
                                    $factory->status_id = FactoryDough::STATUS_RUN;
                                    $factory->time_start = time();
                                    $factory->time_finish = strtotime('tomorrow');
                                    $factory->save();
                                    Yii::$app->db->createCommand()
                                        ->update('user', ['energy' => $userEnergy], 'id = :id', ['id' => $userId])
                                        ->execute();
                                    $userStorage->save();
                                    if ($newLevel = $user->isLevelUp($expRun->experience)) {
                                        $showLevel = true;
                                    }
                                    $experience = $user->experience;
                                    return ['status' => true, 'msg' => Yii::t('app', 'Поздравляем вы запустили фабрику теста') . '!', 'energy' => $userEnergy, 'exp' => $experience, 'egg' => $userStorage->egg, 'label' => $label, 'showLevel' => $showLevel, 'newLevel' => $newLevel];
                                } else {
                                    return ['status' => false, 'msg' => Yii::t('app', 'У вас недостаточно яиц для запуска фабрики, необходимо {eggsUnits} ед. яиц', [
                                        'eggsUnits' => Settings::$countEggForRunFactoryDough,
                                    ]) . '!'];
                                }
                            }else {
                                return ['status' => false, 'msg' => Yii::t('app', 'Фабрика уже запущена, обновите страницу') . '!'];
                            }
                            break;

                        case 'FactoryMince': //мясо
                            $ready = FactoryMince::find()->where(['status_id'=>FactoryMince::STATUS_READY])->andWhere(['user_id'=>$userId])->andWhere(['item_id' => $factoryId])->one();
                            $expRun = Factories::find()->select(['experience'])->where(['alias'=>'factory_mince'])->one();
                            if(count($ready) != 0) {
                                if ($userStorage->meat >= Settings::$countMeatForRunFactoryMince) {
                                    $userStorage->meat -= Settings::$countMeatForRunFactoryMince;
                                    $factory = FactoryMince::find()->where(['item_id' => $factoryId])->one();
                                    $factory->status_id = FactoryMince::STATUS_RUN;
                                    $factory->time_start = time();
                                    $factory->time_finish = strtotime('tomorrow');
                                    $factory->save();
                                    Yii::$app->db->createCommand()
                                        ->update('user', ['energy' => $userEnergy], 'id = :id', ['id' => $userId])
                                        ->execute();
                                    $userStorage->save();
                                    if ($newLevel = $user->isLevelUp($expRun->experience)) {
                                        $showLevel = true;
                                    }
                                    $experience = $user->experience;
                                    return ['status' => true, 'msg' => Yii::t('app', 'Поздравляем вы запустили фабрику фарша') . '!', 'energy' => $userEnergy, 'exp' => $experience, 'meat' => $userStorage->meat, 'label' => $label, 'showLevel' => $showLevel, 'newLevel' => $newLevel];
                                } else {
                                    return ['status' => false, 'msg' => Yii::t('app', 'У вас недостаточно мяса для запуска фабрики, необходимо {meatUnits} ед. мясо', [
                                        'meatUnits' => Settings::$countMeatForRunFactoryMince,
                                    ]) . '!'];
                                }
                            }else {
                                return ['status' => false, Yii::t('app', 'Фабрика уже запущена, обновите страницу') . '!'];
                            }
                            break;

                        case 'FactoryCheese':
                            $ready = FactoryCheese::find()->where(['status_id'=>FactoryCheese::STATUS_READY])->andWhere(['user_id'=>$userId])->andWhere(['item_id' => $factoryId])->one();
                            $expRun = Factories::find()->select(['experience'])->where(['alias'=>'factory_cheese'])->one();
                            if(count($ready) != 0) {
                                if ($userStorage->goat_milk >= Settings::$countGoatMilkForRunFactoryCheese) {
                                    $userStorage->goat_milk -= Settings::$countGoatMilkForRunFactoryCheese;
                                    $factory = FactoryCheese::find()->where(['item_id' => $factoryId])->one();
                                    $factory->status_id = FactoryCheese::STATUS_RUN;
                                    $factory->time_start = time();
                                    $factory->time_finish = strtotime('tomorrow');
                                    $factory->save();
                                    Yii::$app->db->createCommand()
                                        ->update('user', ['energy' => $userEnergy], 'id = :id', ['id' => $userId])
                                        ->execute();
                                    $userStorage->save();
                                    if ($newLevel = $user->isLevelUp($expRun->experience)) {
                                        $showLevel = true;
                                    }
                                    $experience = $user->experience;
                                    return ['status' => true, 'msg' => Yii::t('app', 'Поздравляем вы запустили фабрику сыра') . '!', 'energy' => $userEnergy, 'exp' => $experience, 'goat_milk' => $userStorage->goat_milk, 'label' => $label, 'showLevel' => $showLevel, 'newLevel' => $newLevel];
                                } else {
                                    return ['status' => false, 'msg' => Yii::t('app', 'У вас недостаточно молока козы для запуска фабрики, необходимо {goatMilkUnits} ед. молока козы', [
                                        'goatMilkUnits' => Settings::$countGoatMilkForRunFactoryCheese,
                                    ]) . '!'];
                                }
                            }else {
                                return ['status' => false, 'msg' => Yii::t('app', 'Фабрика уже запущена, обновите страницу') . '!'];
                            }
                            break;

                        case 'FactoryCurd':
                            $ready = FactoryCurd::find()->where(['status_id'=>FactoryCurd::STATUS_READY])->andWhere(['user_id'=>$userId])->andWhere(['item_id' => $factoryId])->one();
                            $expRun = Factories::find()->select(['experience'])->where(['alias'=>'factory_curd'])->one();
                            if(count($ready) != 0) {
                                if ($userStorage->cow_milk >= Settings::$countCowMilkForRunFactoryCurd) {
                                    $userStorage->cow_milk -= Settings::$countCowMilkForRunFactoryCurd;
                                    $factory = FactoryCurd::find()->where(['item_id' => $factoryId])->one();
                                    $factory->status_id = FactoryCurd::STATUS_RUN;
                                    $factory->time_start = time();
                                    $factory->time_finish = strtotime('tomorrow');
                                    $factory->save();
                                    Yii::$app->db->createCommand()
                                        ->update('user', ['energy' => $userEnergy], 'id = :id', ['id' => $userId])
                                        ->execute();
                                    $userStorage->save();
                                    if ($newLevel = $user->isLevelUp($expRun->experience)) {
                                        $showLevel = true;
                                    }
                                    $experience = $user->experience;
                                    return ['status' => true, 'msg' => Yii::t('app', 'Поздравляем вы запустили фабрику творога') . '!', 'energy' => $userEnergy, 'exp' => $experience, 'cow_milk' => $userStorage->cow_milk, 'label' => $label, 'showLevel' => $showLevel, 'newLevel' => $newLevel];
                                } else {
                                    return ['status' => false, 'msg' => Yii::t('app', 'У вас недостаточно молока коровы для запуска фабрики, необходимо {cowMilkUnits} ед. молока коровы', [
                                        'cowMilkUnits' => Settings::$countCowMilkForRunFactoryCurd,
                                    ]) . '!'];
                                }
                            }else {
                                return ['status' => false, 'msg' => Yii::t('app', 'Фабрика уже запущена, обновите страницу') . '!'];
                            }
                            break;
                    }
                }else{
                    return ['status' => false, 'msg' => Yii::t('app', 'У вас недостаточно {energyUnits} энергии', [
                        'energyUnits' => Settings::$energyForRunFactory - $userEnergy,
                    ]) . '!'];
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
            $user = User::find()->where(['id' => $userId])->one();
            $label = false;
            $showLevel = false;
            $newLevel = false;
            $userStorage = UserStorage::find()->where(['user_id' => $userId])->one();
            if (!empty($factoryId)) {
                if ($userEnergy >= Settings::$energyForGetProductFactory) {
                    $userEnergy -= Settings::$energyForGetProductFactory;
                    //$experience += 100;
                    switch ($modelName) {
                        case 'FactoryDough':
                            $readyProduct = FactoryDough::find()->where(['status_id'=>FactoryDough::STATUS_READY_PRODUCT])->andWhere(['user_id'=>$userId])->andWhere(['item_id' => $factoryId])->one();
                            $expRun = Factories::find()->select(['experience'])->where(['alias'=>'factory_dough'])->one();
                            if(count($readyProduct) != 0) {
                                $userStorage->dough_for_sell += Settings::$countDough;
                                $factory = FactoryDough::find()->where(['item_id' => $factoryId])->one();
                                $factory->count_product += 1;
                                if ($factory->count_product == Settings::$countCollectProductFactory) {
                                    $factory->status_id = FactoryDough::STATUS_AVAILABLE;
                                    $factory->count_product = 0;
                                    $label = true;
                                } else {
                                    $factory->status_id = FactoryDough::STATUS_READY;
                                }
                                $factory->time_start = 0;
                                $factory->time_finish = 0;
                                $factory->save();
                                Yii::$app->db->createCommand()
                                    ->update('user', ['energy' => $userEnergy], 'id = :id', ['id' => $userId])
                                    ->execute();
                                $userStorage->save();
                                if ($newLevel = $user->isLevelUp($expRun->experience)) {
                                    $showLevel = true;
                                }
                                $experience = $user->experience;
                                return ['status' => true, 'msg' => Yii::t('app', 'Поздравляем вы получили {doughUnits} ед. теста', [
                                    'doughUnits' => 200,
                                ]) . '!', 'energy' => $userEnergy, 'exp' => $experience, 'dough_for_sell' => $userStorage->dough_for_sell, 'label' => $label, 'showLevel' => $showLevel, 'newLevel' => $newLevel];
                            }else{
                                return ['status' => false, 'msg' => Yii::t('app', 'Продукция уже собрана, обновите страницу') . '!'];
                            }
                            break;

                        case 'FactoryMince': //мясо
                            $readyProduct = FactoryMince::find()->where(['status_id'=>FactoryMince::STATUS_READY_PRODUCT])->andWhere(['user_id'=>$userId])->andWhere(['item_id' => $factoryId])->one();
                            $expRun = Factories::find()->select(['experience'])->where(['alias'=>'factory_mince'])->one();
                            if(count($readyProduct) != 0) {
                                $userStorage->mince_for_sell += Settings::$countMince;
                                $factory = FactoryMince::find()->where(['item_id' => $factoryId])->one();
                                $factory->count_product += 1;
                                if ($factory->count_product == Settings::$countCollectProductFactory) {
                                    $factory->status_id = FactoryMince::STATUS_AVAILABLE;
                                    $label = true;
                                } else {
                                    $factory->status_id = FactoryMince::STATUS_READY;
                                }
                                $factory->time_start = 0;
                                $factory->time_finish = 0;
                                $factory->save();
                                Yii::$app->db->createCommand()
                                    ->update('user', ['energy' => $userEnergy], 'id = :id', ['id' => $userId])
                                    ->execute();
                                $userStorage->save();
                                if ($newLevel = $user->isLevelUp($expRun->experience)) {
                                    $showLevel = true;
                                }
                                $experience = $user->experience;
                                return ['status' => true, 'msg' => Yii::t('app', 'Поздравляем вы получили {minceUnits} ед. фарша', [
                                    'minceUnits' => 200,
                                ]) . '!', 'energy' => $userEnergy, 'exp' => $experience, 'mince_for_sell' => $userStorage->mince_for_sell, 'label' => $label, 'showLevel' => $showLevel, 'newLevel' => $newLevel];
                            }else{
                                return ['status' => false, 'msg' => Yii::t('app', 'Продукция уже собрана, обновите страницу') . '!'];
                            }
                            break;

                        case 'FactoryCheese':
                            $readyProduct = FactoryCheese::find()->where(['status_id'=>FactoryCheese::STATUS_READY_PRODUCT])->andWhere(['user_id'=>$userId])->andWhere(['item_id' => $factoryId])->one();
                            $expRun = Factories::find()->select(['experience'])->where(['alias'=>'factory_cheese'])->one();
                            if(count($readyProduct) != 0) {
                                $userStorage->cheese_for_sell += Settings::$countCheese;
                                $factory = FactoryCheese::find()->where(['item_id' => $factoryId])->one();
                                $factory->count_product += 1;
                                if ($factory->count_product == Settings::$countCollectProductFactory) {
                                    $factory->status_id = FactoryCheese::STATUS_AVAILABLE;
                                    $label = true;
                                } else {
                                    $factory->status_id = FactoryCheese::STATUS_READY;
                                }
                                $factory->time_start = 0;
                                $factory->time_finish = 0;
                                $factory->save();
                                Yii::$app->db->createCommand()
                                    ->update('user', ['energy' => $userEnergy], 'id = :id', ['id' => $userId])
                                    ->execute();
                                $userStorage->save();
                                if ($newLevel = $user->isLevelUp($expRun->experience)) {
                                    $showLevel = true;
                                }
                                $experience = $user->experience;
                                return ['status' => true, 'msg' => Yii::t('app', 'Поздравляем вы получили {cheeseUnits} ед. сыра', [
                                    'cheeseUnits' => 200,
                                ]) . '!', 'energy' => $userEnergy, 'exp' => $experience, 'cheese_for_sell' => $userStorage->cheese_for_sell, 'label' => $label, 'showLevel' => $showLevel, 'newLevel' => $newLevel];
                            }else{
                                return ['status' => false, 'msg' => Yii::t('app', 'Продукция уже собрана, обновите страницу') . '!'];
                            }
                            break;

                        case 'FactoryCurd':
                            $readyProduct = FactoryCurd::find()->where(['status_id'=>FactoryCurd::STATUS_READY_PRODUCT])->andWhere(['user_id'=>$userId])->andWhere(['item_id' => $factoryId])->one();
                            $expRun = Factories::find()->select(['experience'])->where(['alias'=>'factory_curd'])->one();
                            if(count($readyProduct) != 0) {
                                $userStorage->curd_for_sell += Settings::$countCurd;
                                $factory = FactoryCurd::find()->where(['item_id' => $factoryId])->one();
                                $factory->count_product += 1;
                                if ($factory->count_product == Settings::$countCollectProductFactory) {
                                    $factory->status_id = FactoryCurd::STATUS_AVAILABLE;
                                    $label = true;
                                } else {
                                    $factory->status_id = FactoryCurd::STATUS_READY;
                                }
                                $factory->time_start = 0;
                                $factory->time_finish = 0;
                                $factory->save();
                                Yii::$app->db->createCommand()
                                    ->update('user', ['energy' => $userEnergy], 'id = :id', ['id' => $userId])
                                    ->execute();
                                $userStorage->save();
                                if ($newLevel = $user->isLevelUp($expRun->experience)) {
                                    $showLevel = true;
                                }
                                $experience = $user->experience;
                                return ['status' => true, 'msg' => Yii::t('app', 'Поздравляем вы получили {curdUnits} ед. творога', [
                                    'curdUnits' => 200,
                                ]) . '!', 'energy' => $userEnergy, 'exp' => $experience, 'curd_for_sell' => $userStorage->curd_for_sell, 'label' => $label, 'showLevel' => $showLevel, 'newLevel' => $newLevel];
                            }else{
                                return ['status' => false, 'msg' => Yii::t('app', 'Продукция уже собрана, обновите страницу') . '!'];
                            }
                            break;
                    }
                }else{
                    return ['status' => false, 'msg' => Yii::t('app', 'У вас недостаточно {energyUnits} энергии', [
                        'energyUnits' => Settings::$energyForGetProductFactory - $userEnergy,
                    ]) . '!'];
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
                    //тесто
                    case 'FactoryDough':
                        $factory = FactoryDough::findOne(['item_id'=>$itemId]);
                        $timeNow = time();
                        $timeFinish = (int)$factory->time_finish;
                        if ($timeNow < $timeFinish) {
                            $diff = $timeFinish - $timeNow;
                            return ['status' => false, 'timer' => $diff, 'count'=>$factory->count_product . '/365'];
                        } else {
                            $factory->status_id = FactoryDough::STATUS_READY_PRODUCT;
                            $factory->save();
                            return ['status' => true, 'alias' => $factory->plant_alias, 'msg' => Yii::t('app', 'Продукция готова') . '!'];
                        }
                        break;
                    // мясо
                    case 'FactoryMince':
                        $factory = FactoryMince::findOne(['item_id'=>$itemId]);
                        $timeNow = time();
                        $timeFinish = (int)$factory->time_finish;
                        if ($timeNow < $timeFinish) {
                            $diff = $timeFinish - $timeNow;
                            return ['status' => false, 'timer' => $diff, 'count'=>$factory->count_product . '/365'];
                        } else {
                            $factory->status_id = FactoryMince::STATUS_READY_PRODUCT;
                            $factory->save();
                            return ['status' => true, 'alias' => $factory->plant_alias, 'msg' => Yii::t('app', 'Продукция готова') . '!'];
                        }
                        break;
                    //сыр
                    case 'FactoryCheese':
                        $factory = FactoryCheese::findOne(['item_id'=>$itemId]);
                        $timeNow = time();
                        $timeFinish = (int)$factory->time_finish;
                        if ($timeNow < $timeFinish) {
                            $diff = $timeFinish - $timeNow;
                            return ['status' => false, 'timer' => $diff, 'count'=>$factory->count_product . '/365'];
                        } else {
                            $factory->status_id = FactoryCheese::STATUS_READY_PRODUCT;
                            $factory->save();
                            return ['status' => true, 'alias' => $factory->plant_alias, 'msg' => Yii::t('app', 'Продукция готова') . '!'];
                        }
                        break;
                    //творог
                    case 'FactoryCurd':
                        $factory = FactoryCurd::findOne(['item_id'=>$itemId]);
                        $timeNow = time();
                        $timeFinish = (int)$factory->time_finish;
                        if ($timeNow < $timeFinish) {
                            $diff = $timeFinish - $timeNow;
                            return ['status' => false, 'timer' => $diff, 'count'=>$factory->count_product . '/365'];
                        } else {
                            $factory->status_id = FactoryCurd::STATUS_READY_PRODUCT;
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
