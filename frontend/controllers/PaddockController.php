<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 29.01.2016
 * Time: 16:42
 */

namespace frontend\controllers;
use common\models\BullItems;
use common\models\ChickenItems;
use common\models\CowItems;
use common\models\GoatItems;
use common\models\PaddockBullItems;
use common\models\PaddockChickenItems;
use common\models\PaddockCowItems;
use common\models\PaddockGoatItems;
use common\models\Settings;
use common\models\User;
use common\models\UserStorage;
use Yii;
use yii\web\NotFoundHttpException;


class PaddockController extends \yii\web\Controller
{
    public function actionBuildPaddock()
    {
        if(Yii::$app->user->isGuest)
        {
            throw new NotFoundHttpException;
        }
        if(Yii::$app->request->isAjax) {
            Yii::$app->response->format = 'json';
            $paddockId = Yii::$app->request->post('id');
            $pole = Yii::$app->request->post('pole');
            $level = Yii::$app->request->post('level');
            $userId = Yii::$app->user->id;
            $build = PaddockChickenItems::find()->where(['status_id'=>0])->andWhere(['user_id'=>$userId])->andWhere(['item_id' => $paddockId])->one();
            if (!empty($paddockId)) {
                if (count($build) != 0) {
                    $model = UserStorage::find()->where(['user_id' => $userId])->one();
                    if ($model->paddock_chickens > 0) {
                        $model->paddock_chickens -= 1;
                        $model->save();
                        $chickenItems = array();
                        for ($k = 1; $k < 10; $k++) {
                            $chickenItems[$k]['paddock_id'] = $paddockId;
                            $chickenItems[$k]['user_id'] = $userId;
                            $chickenItems[$k]['position'] = $k;
                        }
                        Yii::$app->db->createCommand()
                            ->batchInsert('chicken_items', ['paddock_id', 'user_id', 'position'], $chickenItems)
                            ->execute();
                        unset($chickenItems);
                        Yii::$app->db->createCommand()
                            ->update('paddock_chicken_items', ['status_id' => PaddockChickenItems::STATUS_READY], 'item_id = :id', ['id' => $paddockId])
                            ->execute();
                        if ($pole == 'pole-9') {
                            //create 9 paddock_chicken_items
                            $paddockItems = array();
                            for ($j = $level + 1; $j < $level + 10; $j++) {
                                $paddockItems[$j]['user_id'] = $userId;
                                if ($j == 1) {
                                    $paddockItems[$j]['status_id'] = PaddockChickenItems::STATUS_READY;
                                } else {
                                    $paddockItems[$j]['status_id'] = PaddockChickenItems::STATUS_NOT_AVAILABLE;
                                }
                                $paddockItems[$j]['level'] = $j;
                            }
                            Yii::$app->db->createCommand()
                                ->batchInsert('paddock_chicken_items', ['user_id', 'status_id', 'level'], $paddockItems)
                                ->execute();
                            unset($paddockItems);
                        }
                    } else {
                        return ['status' => false, 'msg' => Yii::t('app', 'У вас нет загона в наличии') . '!'];
                    }
                    return ['status' => true, 'msg' => Yii::t('app', 'Поздравляем, вы построили загон кур') . '!'];
                }else {
                    return ['status' => false, 'msg' => Yii::t('app', 'Здесь уже построен загон, обновите страницу') . '!'];
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

    public function actionOpenPaddock()
    {
        if(Yii::$app->user->isGuest)
        {
            throw new NotFoundHttpException;
        }
        if(Yii::$app->request->isAjax) {
            Yii::$app->response->format = 'json';
            $paddockId = Yii::$app->request->post('paddockId');
            if (!empty($paddockId)) {
                $chickenItems = ChickenItems::find()->where(['paddock_id'=>$paddockId])->orderBy(['item_id'=>SORT_ASC])->limit(9)->all();
                foreach($chickenItems as $item){
                    if(time() > $item->time_finish && $item->time_finish!=0){
                        $item->status_id = ChickenItems::STATUS_EGG;
                        $item->save();
                    }
                }
                //echo "<pre>"; var_dump($chickenItems); die();
                return ['status' => true, 'chickenItems'=>$chickenItems];
            } else {
                return ['status' => false, 'msg' => Yii::t('app', 'Ошибка на стороне сервера') . '!'];
            }
        }
        else
        {
            throw new NotFoundHttpException;
        }
    }

    public function actionSetChicken(){
        if(Yii::$app->user->isGuest)
        {
            throw new NotFoundHttpException;
        }
        if(Yii::$app->request->isAjax) {
            Yii::$app->response->format = 'json';
            $paddockId = Yii::$app->request->post('paddockId');
            $position = Yii::$app->request->post('position');
            $userId = Yii::$app->user->id;
            $set = ChickenItems::find()->where(['status_id'=>0])->andWhere(['user_id'=>$userId])->andWhere(['paddock_id' => $paddockId])->andWhere(['position' => $position])->one();
            $status = ChickenItems::STATUS_HUNGRY;
            //echo '<pre>'; var_dump(count($notSet)); die();
            if (!empty($paddockId) && !empty($position)) {
                if (count($set) != 0) {
                    $chickens = UserStorage::find()->where(['user_id' => $userId])->one();
                    if ($chickens->chicken > 0) {
                        $chickens->chicken -= 1;
                        $chickens->save();

                        $model = ChickenItems::find()->where(['paddock_id' => $paddockId])->andWhere(['position' => $position])->one();
                        $model->status_id = $status;
                        $model->user_id = $userId;
                        $model->time_start = 0;
                        $model->time_finish = 0;
                        $model->count_eggs = 0;
                        $model->save();
                        $countChicken = ChickenItems::find()->where(['user_id' => $userId])->andWhere(['paddock_id' => $paddockId])->andWhere(['not', ['status_id' => 0]])->all();
                        $countChicken = count($countChicken);
                    } else {
                        return ['status' => false, 'msg' => 'У вас нет кур'];
                    }
                    return ['status' => true, 'msg' => Yii::t('app', 'Вы посадили курицу') . '!', 'chicken' => $chickens->chicken, 'countAnimal' => $countChicken];
                }else {
                    return ['status' => false, 'msg' => Yii::t('app', 'Курица уже посажена, обновите страницу') . '!'];
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

    public function actionFeedChicken(){
        if(Yii::$app->user->isGuest)
        {
            throw new NotFoundHttpException;
        }
        if(Yii::$app->request->isAjax) {
            Yii::$app->response->format = 'json';
            $paddockId = Yii::$app->request->post('paddockId');
            $position = Yii::$app->request->post('position');
            $userId = Yii::$app->user->identity->id;
            $user = User::find()->where(['id'=>$userId])->one();
            $energy = $user->energy;
            $showLevel = false;
            $feeding = ChickenItems::find()->where(['status_id'=>ChickenItems::STATUS_HUNGRY])->andWhere(['user_id'=>$userId])->andWhere(['paddock_id' => $paddockId])->andWhere(['position' => $position])->one();
            if (!empty($paddockId) && !empty($position)) {
                if (count($feeding) != 0) {
                    $userStorage = UserStorage::find()->where(['user_id' => $userId])->one();
                    if ($userStorage->feed_chickens >= 2) {
                        //-4 энергии
                        if ($energy >= Settings::$countEnergyForFeedChicken) {
                            $energy -= Settings::$countEnergyForFeedChicken;
                            if ($newLevel = $user->isLevelUp(2)) {
                                $showLevel = true;
                            }

                            $userStorage->feed_chickens -= 2;
                            $userStorage->save();

                            $model = ChickenItems::find()->where(['paddock_id' => $paddockId])->andWhere(['position' => $position])->one();
                            $model->status_id = ChickenItems::STATUS_DEFAULT;
                            $model->time_start = time();
                            $model->time_finish = strtotime('tomorrow');
                            $model->save();

                            Yii::$app->db->createCommand()
                                ->update('user', ['energy' => $energy], 'id = :id', ['id' => $userId])
                                ->execute();
                            return ['status' => true, 'msg' => Yii::t('app', 'Вы покормили курицу') . '!', 'energy' => $energy, 'experience' => $user->experience, 'feed' => $userStorage->feed_chickens, 'showLevel' => $showLevel, 'newLevel' => $newLevel];
                        } else {
                            return ['status' => false, 'msg' => Yii::t('app', 'У вас недостаточно энергии, необходимо {energyUnits} энергии', [
                                'energyUnits' => Settings::$countEnergyForFeedChicken,
                            ]) . '!'];
                        }
                    } else {
                        return ['status' => false, 'msg' => Yii::t('app', 'У вас недостаточно корма, необходимо {units} корма', [
                            'units' => 2,
                        ]) . '!'];
                    }
                } else {
                    return ['status' => false, 'msg' => Yii::t('app', 'Курица уже посажена, обновите страницу') . '!'];
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

    public function actionGetEgg(){
        if(Yii::$app->user->isGuest)
        {
            throw new NotFoundHttpException;
        }
        if(Yii::$app->request->isAjax) {
            Yii::$app->response->format = 'json';
            $paddockId = Yii::$app->request->post('paddockId');
            $position = Yii::$app->request->post('position');
            $userId = Yii::$app->user->identity->id;
            $user = User::find()->where(['id'=>$userId])->one();
            $energy = $user->energy;
            $showLevel = false;
            $egg = ChickenItems::find()->where(['status_id'=>ChickenItems::STATUS_EGG])->andWhere(['user_id'=>$userId])->andWhere(['paddock_id' => $paddockId])->andWhere(['position' => $position])->one();
            if (!empty($paddockId) && !empty($position)) {
                if (count($egg) != 0) {
                    if ($energy >= Settings::$countEnergyForGetEggChicken) {
                        $energy -= Settings::$countEnergyForGetEggChicken;
                        if ($newLevel = $user->isLevelUp(Settings::$countExpGetEgg)) { //2 опыта
                            $showLevel = true;
                        }
                        $model = ChickenItems::find()->where(['paddock_id' => $paddockId])->andWhere(['position' => $position])->one();
                        $model->status_id = ChickenItems::STATUS_HUNGRY;
                        $model->time_start = 0;
                        $model->time_finish = 0;
                        $model->count_eggs += 2;
                        if ($model->count_eggs == 60) {
                            $model->status_id = 0; // курица сдохла
                        }
                        $model->save();

                        Yii::$app->db->createCommand()
                            ->update('user', ['energy' => $energy], 'id = :id', ['id' => $userId])
                            ->execute();

                        $userStorage = UserStorage::find()->where(['user_id' => $userId])->one();
                        $userStorage->egg_for_sell += 2; //собранная продукция идет на продажу
                        $userStorage->save();
                    } else {
                        return ['status' => false, 'msg' => Yii::t('app', 'У вас недостаточно энергии, необходимо {energyUnits} энергии', [
                            'energyUnits' => Settings::$countEnergyForGetEggChicken,
                        ]) . '!'];
                    }
                    return ['status' => true, 'msg' => Yii::t('app', 'Вы собрали яйца') . '!', 'energy' => $energy, 'experience' => $user->experience, 'count_eggs' => $model->count_eggs, 'status_id' => $model->status_id, 'egg' => $userStorage->egg_for_sell, 'showLevel' => $showLevel, 'newLevel' => $newLevel];
                }else{
                    return ['status' => false, 'msg' => Yii::t('app', 'Яица уже собраны, обновите страницу') . '!'];
                }
            }
            else {
                return ['status' => false, 'msg' => Yii::t('app', 'Ошибка на стороне сервера') . '!'];
            }
        }
        else
        {
            throw new NotFoundHttpException;
        }
    }

    public function actionGetFeed(){
        if(Yii::$app->user->isGuest)
        {
            throw new NotFoundHttpException;
        }
        if(Yii::$app->request->isAjax) {
            Yii::$app->response->format = 'json';
            $paddockId = Yii::$app->request->post('paddockId');
            $position = Yii::$app->request->post('position');
            $type = Yii::$app->request->post('type');
            $userId = Yii::$app->user->identity->id;
            $user = User::find()->where(['id'=>$userId])->one();
            $energy = $user->energy;
            $showLevel = false;
            if (!empty($paddockId) && !empty($position)) {
                switch($type){
                    case 'Chickens': //сбор
                        $egg = ChickenItems::find()->where(['status_id'=>ChickenItems::STATUS_EGG])->andWhere(['user_id'=>$userId])->andWhere(['paddock_id' => $paddockId])->andWhere(['position' => $position])->one();
                        $feeding = ChickenItems::find()->where(['status_id'=>ChickenItems::STATUS_EGG])->andWhere(['user_id'=>$userId])->andWhere(['paddock_id' => $paddockId])->andWhere(['position' => $position])->one();
                        if (count($egg) != 0) {
                            if ($energy >= Settings::$countEnergyForGetEggChicken) {
                                $energy -= Settings::$countEnergyForGetEggChicken;
                                if ($newLevel = $user->isLevelUp(Settings::$countExpGetEgg)) { //2 опыта
                                    $showLevel = true;
                                }
                                $model = ChickenItems::find()->where(['paddock_id' => $paddockId])->andWhere(['position' => $position])->one();
                                $model->status_id = ChickenItems::STATUS_HUNGRY;
                                $model->time_start = 0;
                                $model->time_finish = 0;
                                $model->count_eggs += 2;
                                if ($model->count_eggs == 60) {
                                    $model->status_id = 0; // курица сдохла
                                }
                                $model->save();

                                Yii::$app->db->createCommand()
                                    ->update('user', ['energy' => $energy], 'id = :id', ['id' => $userId])
                                    ->execute();

                                $userStorage = UserStorage::find()->where(['user_id' => $userId])->one();
                                $userStorage->egg_for_sell += 2; //собранная продукция идет на продажу
                                $userStorage->save();
                                $count_eggs = $model->count_eggs;
                                $status_id = $model->status_id;
                                $egg = $userStorage->egg_for_sell;
                            } else {
                                return ['status' => false, 'msg' => Yii::t('app', 'У вас недостаточно энергии, необходимо {energyUnits} энергии', [
                                    'energyUnits' => Settings::$countEnergyForGetEggChicken,
                                ]) . '!'];
                            }
                        }else{
                            return ['status' => false, 'msg' => Yii::t('app', 'Яица уже собраны, обновите страницу') . '!'];
                        }
                        if($model->status_id != 0) { //кормление
                            if (count($feeding) != 0) {
                                $userStorage = UserStorage::find()->where(['user_id' => $userId])->one();
                                if ($userStorage->feed_chickens >= 2) {
                                    //-4 энергии
                                    if ($energy >= Settings::$countEnergyForFeedChicken) {
                                        $energy -= Settings::$countEnergyForFeedChicken;
                                        if ($newLevel = $user->isLevelUp(2)) {
                                            $showLevel = true;
                                        }
                                        $userStorage->feed_chickens -= 2;
                                        $userStorage->save();
                                        $model = ChickenItems::find()->where(['paddock_id' => $paddockId])->andWhere(['position' => $position])->one();
                                        $model->status_id = ChickenItems::STATUS_DEFAULT;
                                        $model->time_start = time();
                                        $model->time_finish = strtotime('tomorrow');
                                        $model->save();
                                        Yii::$app->db->createCommand()
                                            ->update('user', ['energy' => $energy], 'id = :id', ['id' => $userId])
                                            ->execute();
                                        return ['status' => true, 'msg' => Yii::t('app', 'Вы покормили курицу') . '!', 'energy' => $energy, 'experience' => $user->experience, 'count_eggs' => $count_eggs, 'status_id' => $status_id, 'egg' => $egg, 'feed' => $userStorage->feed_chickens, 'showLevel' => $showLevel, 'newLevel' => $newLevel];
                                    } else {
                                        return ['status' => false, 'msg' => Yii::t('app', 'У вас недостаточно энергии, необходимо {energyUnits} энергии', [
                                            'energyUnits' => Settings::$countEnergyForFeedChicken,
                                        ]) . '!', 'energy' => $energy, 'experience' => $user->experience, 'count_eggs' => $count_eggs, 'status_id' => $status_id, 'egg' => $egg, 'feed' => $userStorage->feed_chickens, 'showLevel' => $showLevel, 'newLevel' => $newLevel];
                                    }
                                } else {
                                    return ['status' => false, 'msg' => Yii::t('app', 'У вас недостаточно корма, необходимо {units} корма', [
                                        'units' => 2,
                                    ]) . '!', 'energy' => $energy, 'experience' => $user->experience, 'count_eggs' => $count_eggs, 'status_id' => $status_id, 'egg' => $egg, 'feed' => $userStorage->feed_chickens, 'showLevel' => $showLevel, 'newLevel' => $newLevel];
                                }
                            } else {
                                return ['status' => false, 'msg' => Yii::t('app', 'Курица уже покормлена, обновите страницу') . '!'];
                            }
                        } else{
                            return ['status' => true, 'msg' => Yii::t('app', 'Вы собрали яйца') . '!', 'energy' => $energy, 'experience' => $user->experience, 'count_eggs' => $model->count_eggs, 'status_id' => $model->status_id, 'egg' => $userStorage->egg_for_sell, 'showLevel' => $showLevel, 'newLevel' => $newLevel];
                        }
                        break;
                    case 'Bulls':
                        $meat = BullItems::find()->where(['status_id'=>BullItems::STATUS_MEAT])->andWhere(['user_id'=>$userId])->andWhere(['paddock_id' => $paddockId])->andWhere(['position' => $position])->one();
                        $feeding = BullItems::find()->where(['status_id'=>BullItems::STATUS_MEAT])->andWhere(['user_id'=>$userId])->andWhere(['paddock_id' => $paddockId])->andWhere(['position' => $position])->one();
                        if (count($meat) != 0) {
                            if ($energy >= Settings::$countEnergyForGetMeat) {
                                $energy -= Settings::$countEnergyForGetMeat;
                                if ($newLevel = $user->isLevelUp(Settings::$countExpGetMeat)) { //4 опыта
                                    $showLevel = true;
                                }
                                $model = BullItems::find()->where(['paddock_id' => $paddockId])->andWhere(['position' => $position])->one();
                                $model->status_id = BullItems::STATUS_HUNGRY;
                                $model->time_start = 0;
                                $model->time_finish = 0;
                                $model->count_meat += 2;
                                if ($model->count_meat == 60) {
                                    $model->status_id = 0; // is dead
                                }
                                $model->save();

                                Yii::$app->db->createCommand()
                                    ->update('user', ['energy' => $energy], 'id = :id', ['id' => $userId])
                                    ->execute();

                                $userStorage = UserStorage::find()->where(['user_id' => $userId])->one();
                                $userStorage->meat_for_sell += 2; //собранная продукция идет на продажу
                                $userStorage->save();
                                $count_meat = $model->count_meat;
                                $status_id = $model->status_id;
                                $meat = $userStorage->meat_for_sell;
                            } else {
                                return ['status' => false, 'msg' => Yii::t('app', 'У вас недостаточно энергии, необходимо {energyUnits} энергии', [
                                    'energyUnits' => Settings::$countEnergyForGetMeat,
                                ]) . '!'];
                            }
                        }else{
                            return ['status' => false, 'msg' => Yii::t('app', 'Мясо уже собрано, обновите страницу') . '!'];
                        }
                        if($model->status_id != 0) {
                            if (count($feeding) != 0) {
                                $userStorage = UserStorage::find()->where(['user_id' => $userId])->one();
                                if ($userStorage->feed_bulls >= 2) {
                                    //-4 энергии
                                    if ($energy >= Settings::$countEnergyForFeedBull) {
                                        $energy -= Settings::$countEnergyForFeedBull;
                                        if ($newLevel = $user->isLevelUp(2)) {
                                            $showLevel = true;
                                        }
                                        $userStorage->feed_bulls -= 2;
                                        $userStorage->save();
                                        $model = BullItems::find()->where(['paddock_id' => $paddockId])->andWhere(['position' => $position])->one();
                                        $model->status_id = BullItems::STATUS_DEFAULT;
                                        $model->time_start = time();
                                        $model->time_finish = strtotime('tomorrow');
                                        $model->save();
                                        Yii::$app->db->createCommand()
                                            ->update('user', ['energy' => $energy], 'id = :id', ['id' => $userId])
                                            ->execute();
                                        return ['status' => true, 'msg' => Yii::t('app', 'Вы покормили бычка') . '!', 'energy' => $energy, 'experience' => $user->experience, 'count_meat' => $count_meat, 'status_id' => $status_id, 'meat' => $meat, 'feed' => $userStorage->feed_bulls, 'showLevel' => $showLevel, 'newLevel' => $newLevel];
                                    } else {
                                        return ['status' => false, 'msg' => Yii::t('app', 'У вас недостаточно энергии, необходимо {energyUnits} энергии', [
                                            'energyUnits' => Settings::$countEnergyForFeedBull,
                                        ]) . '!', 'energy' => $energy, 'experience' => $user->experience, 'count_meat' => $count_meat, 'status_id' => $status_id, 'meat' => $meat, 'feed' => $userStorage->feed_bulls, 'showLevel' => $showLevel, 'newLevel' => $newLevel];
                                    }
                                } else {
                                    return ['status' => false, 'msg' => Yii::t('app', 'У вас недостаточно корма, необходимо {units} корма', [
                                        'units' => 2,
                                    ]) . '!', 'energy' => $energy, 'experience' => $user->experience, 'count_meat' => $count_meat, 'status_id' => $status_id, 'meat' => $meat, 'feed' => $userStorage->feed_bulls, 'showLevel' => $showLevel, 'newLevel' => $newLevel];
                                }
                            } else {
                                return ['status' => false, 'msg' => Yii::t('app', 'Бычок уже покормлен, обновите страницу') . '!'];
                            }
                        } else{
                            return ['status' => true, 'msg' => Yii::t('app', 'Вы собрали мясо') . '!', 'energy' => $energy, 'experience' => $user->experience, 'count_meat' => $model->count_meat, 'status_id' => $model->status_id, 'meat' => $userStorage->meat_for_sell, 'showLevel' => $showLevel, 'newLevel' => $newLevel];
                        }
                        break;
                    case 'Goats':
                        $milk = GoatItems::find()->where(['status_id'=>GoatItems::STATUS_MILK])->andWhere(['user_id'=>$userId])->andWhere(['paddock_id' => $paddockId])->andWhere(['position' => $position])->one();
                        $feeding = GoatItems::find()->where(['status_id'=>GoatItems::STATUS_MILK])->andWhere(['user_id'=>$userId])->andWhere(['paddock_id' => $paddockId])->andWhere(['position' => $position])->one();
                        if (count($milk) != 0) {
                            if ($energy >= Settings::$countEnergyForGetMilkGoat) {
                                $energy -= Settings::$countEnergyForGetMilkGoat;
                                if ($newLevel = $user->isLevelUp(Settings::$countExpGetGMilk)) { //4 опыта
                                    $showLevel = true;
                                }
                                $model = GoatItems::find()->where(['paddock_id' => $paddockId])->andWhere(['position' => $position])->one();
                                $model->status_id = GoatItems::STATUS_HUNGRY;
                                $model->time_start = 0;
                                $model->time_finish = 0;
                                $model->count_milk += 2;
                                if ($model->count_milk == 60) {
                                    $model->status_id = 0; // is dead
                                }
                                $model->save();

                                Yii::$app->db->createCommand()
                                    ->update('user', ['energy' => $energy], 'id = :id', ['id' => $userId])
                                    ->execute();

                                $userStorage = UserStorage::find()->where(['user_id' => $userId])->one();
                                $userStorage->goat_milk_for_sell += 2; //собранная продукция идет на продажу
                                $userStorage->save();
                                $count_milk = $model->count_milk;
                                $status_id = $model->status_id;
                                $milk = $userStorage->goat_milk_for_sell;
                            } else {
                                return ['status' => false, 'msg' => Yii::t('app', 'У вас недостаточно энергии, необходимо {energyUnits} энергии', [
                                    'energyUnits' => Settings::$countEnergyForGetMilkGoat,
                                ]) . '!'];
                            }
                        }else{
                            return ['status' => false, 'msg' => Yii::t('app', 'Молоко уже собрано, обновите страницу') . '!'];
                        }
                        if($model->status_id != 0) {
                            if (count($feeding) != 0) {
                                $userStorage = UserStorage::find()->where(['user_id' => $userId])->one();
                                if ($userStorage->feed_goats >= 2) {
                                    //-4 энергии
                                    if ($energy >= Settings::$countEnergyForFeedGoat) {
                                        $energy -= Settings::$countEnergyForFeedGoat;
                                        if ($newLevel = $user->isLevelUp(2)) {
                                            $showLevel = true;
                                        }
                                        $userStorage->feed_goats -= 2;
                                        $userStorage->save();
                                        $model = GoatItems::find()->where(['paddock_id' => $paddockId])->andWhere(['position' => $position])->one();
                                        $model->status_id = GoatItems::STATUS_DEFAULT;
                                        $model->time_start = time();
                                        $model->time_finish = strtotime('tomorrow');
                                        $model->save();
                                        Yii::$app->db->createCommand()
                                            ->update('user', ['energy' => $energy], 'id = :id', ['id' => $userId])
                                            ->execute();
                                        return ['status' => true, 'msg' => Yii::t('app', 'Вы покормили козу') . '!', 'energy' => $energy, 'experience' => $user->experience, 'count_milk' => $count_milk, 'status_id' => $status_id, 'milk' => $milk, 'feed' => $userStorage->feed_goats, 'showLevel' => $showLevel, 'newLevel' => $newLevel];
                                    } else {
                                        return ['status' => false, 'msg' => Yii::t('app', 'У вас недостаточно энергии, необходимо {energyUnits} энергии', [
                                            'energyUnits' => Settings::$countEnergyForFeedGoat,
                                        ]) . '!', 'energy' => $energy, 'experience' => $user->experience, 'count_milk' => $count_milk, 'status_id' => $status_id, 'milk' => $milk, 'feed' => $userStorage->feed_goats, 'showLevel' => $showLevel, 'newLevel' => $newLevel];
                                    }
                                } else {
                                    return ['status' => false, 'msg' => Yii::t('app', 'У вас недостаточно корма, необходимо {units} корма', [
                                        'units' => 2,
                                    ]) . '!', 'energy' => $energy, 'experience' => $user->experience, 'count_milk' => $count_milk, 'status_id' => $status_id, 'milk' => $milk, 'feed' => $userStorage->feed_goats, 'showLevel' => $showLevel, 'newLevel' => $newLevel];
                                }
                            } else {
                                return ['status' => false, 'msg' => Yii::t('app', 'Коза уже покормлена, обновите страницу') . '!'];
                            }
                        } else{
                            return ['status' => true, 'msg' => Yii::t('app', 'Вы собрали молоко') . '!', 'energy' => $energy, 'experience' => $user->experience, 'count_milk' => $model->count_milk, 'status_id' => $model->status_id, 'milk' => $userStorage->goat_milk_for_sell, 'showLevel' => $showLevel, 'newLevel' => $newLevel];
                        }
                        break;
                    case 'Cows':
                        $milk = CowItems::find()->where(['status_id'=>CowItems::STATUS_MILK])->andWhere(['user_id'=>$userId])->andWhere(['paddock_id' => $paddockId])->andWhere(['position' => $position])->one();
                        $feeding = CowItems::find()->where(['status_id'=>CowItems::STATUS_MILK])->andWhere(['user_id'=>$userId])->andWhere(['paddock_id' => $paddockId])->andWhere(['position' => $position])->one();
                        if (count($milk) != 0) {
                            if ($energy >= Settings::$countEnergyForGetMilkCow) {
                                $energy -= Settings::$countEnergyForGetMilkCow;
                                if ($newLevel = $user->isLevelUp(Settings::$countExpGetCMilk)) { //4 опыта
                                    $showLevel = true;
                                }
                                $model = CowItems::find()->where(['paddock_id' => $paddockId])->andWhere(['position' => $position])->one();
                                $model->status_id = CowItems::STATUS_HUNGRY;
                                $model->time_start = 0;
                                $model->time_finish = 0;
                                $model->count_milk += 2;
                                if ($model->count_milk == 60) {
                                    $model->status_id = 0; // is dead
                                }
                                $model->save();

                                Yii::$app->db->createCommand()
                                    ->update('user', ['energy' => $energy], 'id = :id', ['id' => $userId])
                                    ->execute();

                                $userStorage = UserStorage::find()->where(['user_id' => $userId])->one();
                                $userStorage->cow_milk_for_sell += 2; //собранная продукция идет на продажу
                                $userStorage->save();
                                $count_milk = $model->count_milk;
                                $status_id = $model->status_id;
                                $milk = $userStorage->cow_milk_for_sell;
                            } else {
                                return ['status' => false, 'msg' => Yii::t('app', 'У вас недостаточно энергии, необходимо {energyUnits} энергии', [
                                    'energyUnits' => Settings::$countEnergyForGetMilkCow,
                                ]) . '!'];
                            }
                        }else{
                            return ['status' => false, 'msg' => Yii::t('app', 'Молоко уже собрано, обновите страницу') . '!'];
                        }
                        if($model->status_id != 0) {
                            if (count($feeding) != 0) {
                                $userStorage = UserStorage::find()->where(['user_id' => $userId])->one();
                                if ($userStorage->feed_cows >= 2) {
                                    //-4 энергии
                                    if ($energy >= Settings::$countEnergyForFeedCow) {
                                        $energy -= Settings::$countEnergyForFeedCow;
                                        if ($newLevel = $user->isLevelUp(2)) {
                                            $showLevel = true;
                                        }
                                        $userStorage->feed_cows -= 2;
                                        $userStorage->save();
                                        $model = CowItems::find()->where(['paddock_id' => $paddockId])->andWhere(['position' => $position])->one();
                                        $model->status_id = CowItems::STATUS_DEFAULT;
                                        $model->time_start = time();
                                        $model->time_finish = strtotime('tomorrow');
                                        $model->save();
                                        Yii::$app->db->createCommand()
                                            ->update('user', ['energy' => $energy], 'id = :id', ['id' => $userId])
                                            ->execute();
                                        return ['status' => true, 'msg' => Yii::t('app', 'Вы покормили корову') . '!', 'energy' => $energy, 'experience' => $user->experience, 'count_milk' => $count_milk, 'status_id' => $status_id, 'milk' => $milk, 'feed' => $userStorage->feed_cows, 'showLevel' => $showLevel, 'newLevel' => $newLevel];
                                    } else {
                                        return ['status' => false, 'msg' => Yii::t('app', 'У вас недостаточно энергии, необходимо {energyUnits} энергии', [
                                            'energyUnits' => Settings::$countEnergyForFeedCow,
                                        ]) . '!', 'energy' => $energy, 'experience' => $user->experience, 'count_milk' => $count_milk, 'status_id' => $status_id, 'milk' => $milk, 'feed' => $userStorage->feed_cows, 'showLevel' => $showLevel, 'newLevel' => $newLevel];
                                    }
                                } else {
                                    return ['status' => false, 'msg' => Yii::t('app', 'У вас недостаточно корма, необходимо {units} корма', [
                                        'units' => 2,
                                    ]) . '!', 'energy' => $energy, 'experience' => $user->experience, 'count_milk' => $count_milk, 'status_id' => $status_id, 'milk' => $milk, 'feed' => $userStorage->feed_cows, 'showLevel' => $showLevel, 'newLevel' => $newLevel];
                                }
                            } else {
                                return ['status' => false, 'msg' => Yii::t('app', 'Корова уже покормлена, обновите страницу') . '!'];
                            }
                        } else{
                            return ['status' => true, 'msg' => Yii::t('app', 'Вы собрали молоко') . '!', 'energy' => $energy, 'experience' => $user->experience, 'count_milk' => $model->count_milk, 'status_id' => $model->status_id, 'milk' => $userStorage->cow_milk_for_sell, 'showLevel' => $showLevel, 'newLevel' => $newLevel];
                        }
                        break;
                }
            }
            else {
                return ['status' => false, 'msg' => Yii::t('app', 'Ошибка на стороне сервера') . '!'];
            }
        }
        else
        {
            throw new NotFoundHttpException;
        }
    }

    public function actionBuildPaddockBull(){
        if(Yii::$app->user->isGuest)
        {
            throw new NotFoundHttpException;
        }
        if(Yii::$app->request->isAjax) {
            Yii::$app->response->format = 'json';
            $paddockId = Yii::$app->request->post('id');
            $pole = Yii::$app->request->post('pole');
            $level = Yii::$app->request->post('level');
            $userId = Yii::$app->user->id;
            $build = PaddockBullItems::find()->where(['status_id'=>0])->andWhere(['user_id'=>$userId])->andWhere(['item_id' => $paddockId])->one();
            if (!empty($paddockId)) {
                if (count($build) != 0) {
                    $model = UserStorage::find()->where(['user_id' => $userId])->one();
                    if ($model->paddock_bulls > 0) {
                        $model->paddock_bulls -= 1;
                        $model->save();
                        $bullItems = array();
                        for ($k = 1; $k < 10; $k++) {
                            $bullItems[$k]['paddock_id'] = $paddockId;
                            $bullItems[$k]['user_id'] = $userId;
                            $bullItems[$k]['position'] = $k;
                        }
                        Yii::$app->db->createCommand()
                            ->batchInsert('bull_items', ['paddock_id', 'user_id', 'position'], $bullItems)
                            ->execute();
                        unset($bullItems);
                        Yii::$app->db->createCommand()
                            ->update('paddock_bull_items', ['status_id' => PaddockBullItems::STATUS_READY], 'item_id = :id', ['id' => $paddockId])
                            ->execute();
                        if ($pole == 'pole-9') {
                            //create 9 paddock_bull_items
                            $paddockItems = array();
                            for ($j = $level + 1; $j < $level + 10; $j++) {
                                $paddockItems[$j]['user_id'] = $userId;
                                if ($j == 1) {
                                    $paddockItems[$j]['status_id'] = PaddockBullItems::STATUS_READY;
                                } else {
                                    $paddockItems[$j]['status_id'] = PaddockBullItems::STATUS_NOT_AVAILABLE;
                                }
                                $paddockItems[$j]['level'] = $j;
                            }
                            Yii::$app->db->createCommand()
                                ->batchInsert('paddock_bull_items', ['user_id', 'status_id', 'level'], $paddockItems)
                                ->execute();
                            unset($paddockItems);
                        }
                    } else {
                        return ['status' => false, 'msg' => Yii::t('app', 'У вас нет загона в наличии') . '!'];
                    }
                    return ['status' => true, 'msg' => Yii::t('app', 'Поздравляем, вы построили загон бычков') . '!'];
                }else{
                    return ['status' => false, 'msg' => Yii::t('app', 'Здесь уже построен загон, обновите страницу') . '!'];
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

    public function actionOpenPaddockBull()
    {
        if(Yii::$app->user->isGuest)
        {
            throw new NotFoundHttpException;
        }
        if(Yii::$app->request->isAjax) {
            Yii::$app->response->format = 'json';
            $paddockId = Yii::$app->request->post('paddockId');
            if (!empty($paddockId)) {
                $bullItems = BullItems::find()->where(['paddock_id'=>$paddockId])->orderBy(['item_id'=>SORT_ASC])->limit(9)->all();
                foreach($bullItems as $item){
                    if(time() > $item->time_finish && $item->time_finish!=0){
                        $item->status_id = BullItems::STATUS_MEAT;
                        $item->save();
                    }
                }
                return ['status' => true, 'bullItems'=>$bullItems];
            } else {
                return ['status' => false, 'msg' => Yii::t('app', 'Ошибка на стороне сервера') . '!'];
            }
        }
        else
        {
            throw new NotFoundHttpException;
        }
    }

    public function actionSetBull(){
        if(Yii::$app->user->isGuest)
        {
            throw new NotFoundHttpException;
        }
        if(Yii::$app->request->isAjax) {
            Yii::$app->response->format = 'json';
            $paddockId = Yii::$app->request->post('paddockId');
            $position = Yii::$app->request->post('position');
            $userId = Yii::$app->user->id;
            $set = BullItems::find()->where(['status_id'=>0])->andWhere(['user_id'=>$userId])->andWhere(['paddock_id' => $paddockId])->andWhere(['position' => $position])->one();
            if (!empty($paddockId) && !empty($position)) {
                if (count($set) != 0) {
                    $bulls = UserStorage::find()->where(['user_id' => $userId])->one();
                    if ($bulls->bull > 0) {
                        $bulls->bull -= 1;
                        $bulls->save();

                        $model = BullItems::find()->where(['paddock_id' => $paddockId])->andWhere(['position' => $position])->one();
                        $model->status_id = BullItems::STATUS_HUNGRY;
                        $model->user_id = $userId;
                        $model->time_start = 0;
                        $model->time_finish = 0;
                        $model->count_meat = 0;
                        $model->save();
                        $countBull = BullItems::find()->where(['user_id' => $userId])->andWhere(['paddock_id' => $paddockId])->andWhere(['not', ['status_id' => 0]])->all();
                        $countBull = count($countBull);
                    } else {
                        return ['status' => false, 'msg' => Yii::t('app', 'У вас нет бычков') . '!'];
                    }
                    return ['status' => true, 'msg' => Yii::t('app', 'Вы посадили бычка') . '!', 'bull' => $bulls->bull, 'countAnimal' => $countBull];
                }else {
                    return ['status' => false, 'msg' => Yii::t('app', 'Бычок уже посажен, обновите страницу') . '!'];
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

    public function actionFeedBull(){
        if(Yii::$app->user->isGuest)
        {
            throw new NotFoundHttpException;
        }
        if(Yii::$app->request->isAjax) {
            Yii::$app->response->format = 'json';
            $paddockId = Yii::$app->request->post('paddockId');
            $position = Yii::$app->request->post('position');
            $userId = Yii::$app->user->identity->id;
            $user = User::find()->where(['id'=>$userId])->one();
            $energy = $user->energy;
            $showLevel = false;
            $feeding = BullItems::find()->where(['status_id'=>BullItems::STATUS_HUNGRY])->andWhere(['user_id'=>$userId])->andWhere(['paddock_id' => $paddockId])->andWhere(['position' => $position])->one();
            if (!empty($paddockId) && !empty($position)) {
                if (count($feeding) != 0) {
                    $userStorage = UserStorage::find()->where(['user_id' => $userId])->one();
                    if ($userStorage->feed_bulls >= 2) {
                        if ($energy >= Settings::$countEnergyForFeedBull) {
                            $energy -= Settings::$countEnergyForFeedBull;
                            if ($newLevel = $user->isLevelUp(2)) {
                                $showLevel = true;
                            } //+2 опыта

                            $userStorage->feed_bulls -= 2;
                            $userStorage->save();

                            $model = BullItems::find()->where(['paddock_id' => $paddockId])->andWhere(['position' => $position])->one();
                            $model->status_id = BullItems::STATUS_DEFAULT;
                            $model->time_start = time();
                            $model->time_finish = strtotime('tomorrow');
                            $model->save();

                            Yii::$app->db->createCommand()
                                ->update('user', ['energy' => $energy], 'id = :id', ['id' => $userId])
                                ->execute();
                            return ['status' => true, 'msg' => Yii::t('app', 'Вы покормили бычка') . '!', 'energy' => $energy, 'experience' => $user->experience, 'feed' => $userStorage->feed_bulls, 'showLevel' => $showLevel, 'newLevel' => $newLevel];
                        } else {
                            return ['status' => false, 'msg' => Yii::t('app', 'У вас недостаточно энергии, необходимо {energyUnits} энергии', [
                                'energyUnits' => Settings::$countEnergyForFeedBull,
                            ]) . '!'];
                        }
                    } else {
                        return ['status' => false, 'msg' => Yii::t('app', 'У вас недостаточно корма, необходимо {units} корма', [
                            'units' => 2,
                        ]) . '!'];
                    }
                } else {
                    return ['status' => false, 'msg' => Yii::t('app', 'Бычок уже покормлен, обновите страницу') . '!'];
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

    public function actionGetMeat(){
        if(Yii::$app->user->isGuest)
        {
            throw new NotFoundHttpException;
        }
        if(Yii::$app->request->isAjax) {
            Yii::$app->response->format = 'json';
            $paddockId = Yii::$app->request->post('paddockId');
            $position = Yii::$app->request->post('position');
            $userId = Yii::$app->user->identity->id;
            $user = User::find()->where(['id'=>$userId])->one();
            $energy = $user->energy;
            $showLevel = false;
            $meat = BullItems::find()->where(['status_id'=>BullItems::STATUS_MEAT])->andWhere(['user_id'=>$userId])->andWhere(['paddock_id' => $paddockId])->andWhere(['position' => $position])->one();
            if (!empty($paddockId) && !empty($position)) {
                if (count($meat) != 0) {
                    if ($energy >= Settings::$countEnergyForGetMeat) {
                        $energy -= Settings::$countEnergyForGetMeat;
                        if ($newLevel = $user->isLevelUp(Settings::$countExpGetMeat)) {
                            $showLevel = true;
                        } //+4 опыта

                        $model = BullItems::find()->where(['paddock_id' => $paddockId])->andWhere(['position' => $position])->one();
                        $model->status_id = BullItems::STATUS_HUNGRY;
                        $model->time_start = 0;
                        $model->time_finish = 0;
                        $model->count_meat += 2;
                        if ($model->count_meat == 60) {
                            $model->status_id = 0; // бычок кончился
                        }
                        $model->save();

                        Yii::$app->db->createCommand()
                            ->update('user', ['energy' => $energy], 'id = :id', ['id' => $userId])
                            ->execute();

                        $userStorage = UserStorage::find()->where(['user_id' => $userId])->one();
                        $userStorage->meat_for_sell += 2;
                        $userStorage->save();
                        return ['status' => true, 'msg' => Yii::t('app', 'Вы собрали мясо') . '!', 'energy' => $energy, 'experience' => $user->experience, 'count_meat' => $model->count_meat, 'status_id' => $model->status_id, 'meat' => $userStorage->meat_for_sell, 'showLevel' => $showLevel, 'newLevel' => $newLevel];
                    } else {
                        return ['status' => false, 'msg' => Yii::t('app', 'У вас недостаточно энергии, необходимо {energyUnits} энергии', [
                            'energyUnits' => Settings::$countEnergyForGetMeat,
                        ]) . '!'];
                    }
                }else{
                    return ['status' => false, 'msg' => Yii::t('app', 'Мясо уже собрано, обновите страницу') . '!'];
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

    public function actionBuildPaddockGoat(){
        if(Yii::$app->user->isGuest)
        {
            throw new NotFoundHttpException;
        }
        if(Yii::$app->request->isAjax) {
            Yii::$app->response->format = 'json';
            $paddockId = Yii::$app->request->post('id');
            $pole = Yii::$app->request->post('pole');
            $level = Yii::$app->request->post('level');
            $userId = Yii::$app->user->id;
            $build = PaddockGoatItems::find()->where(['status_id'=>0])->andWhere(['user_id'=>$userId])->andWhere(['item_id' => $paddockId])->one();
            if (!empty($paddockId)) {
                if (count($build) != 0) {
                    $model = UserStorage::find()->where(['user_id' => $userId])->one();
                    if ($model->paddock_goats > 0) {
                        $model->paddock_goats -= 1;
                        $model->save();
                        $goatItems = array();
                        for ($k = 1; $k < 10; $k++) {
                            $goatItems[$k]['paddock_id'] = $paddockId;
                            $goatItems[$k]['user_id'] = $userId;
                            $goatItems[$k]['position'] = $k;
                        }
                        Yii::$app->db->createCommand()
                            ->batchInsert('goat_items', ['paddock_id', 'user_id', 'position'], $goatItems)
                            ->execute();
                        unset($goatItems);
                        Yii::$app->db->createCommand()
                            ->update('paddock_goat_items', ['status_id' => PaddockGoatItems::STATUS_READY], 'item_id = :id', ['id' => $paddockId])
                            ->execute();
                        if ($pole == 'pole-9') {
                            //create 9 paddock_bull_items
                            $paddockItems = array();
                            for ($j = $level + 1; $j < $level + 10; $j++) {
                                $paddockItems[$j]['user_id'] = $userId;
                                if ($j == 1) {
                                    $paddockItems[$j]['status_id'] = PaddockGoatItems::STATUS_READY;
                                } else {
                                    $paddockItems[$j]['status_id'] = PaddockGoatItems::STATUS_NOT_AVAILABLE;
                                }
                                $paddockItems[$j]['level'] = $j;
                            }
                            Yii::$app->db->createCommand()
                                ->batchInsert('paddock_goat_items', ['user_id', 'status_id', 'level'], $paddockItems)
                                ->execute();
                            unset($paddockItems);
                        }
                    } else {
                        return ['status' => false, 'msg' => Yii::t('app', 'У вас нет загона в наличии') . '!'];
                    }
                    return ['status' => true, 'msg' => Yii::t('app', 'Поздравляем, вы построили загон коз') . '!'];
                }else{
                    return ['status' => false, 'msg' => Yii::t('app', 'Здесь уже построен загон') . '!'];
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

    public function actionOpenPaddockGoat()
    {
        if(Yii::$app->user->isGuest)
        {
            throw new NotFoundHttpException;
        }
        if(Yii::$app->request->isAjax) {
            Yii::$app->response->format = 'json';
            $paddockId = Yii::$app->request->post('paddockId');
            if (!empty($paddockId)) {
                $goatItems = GoatItems::find()->where(['paddock_id'=>$paddockId])->orderBy(['item_id'=>SORT_ASC])->limit(9)->all();
                foreach($goatItems as $item){
                    if(time() > $item->time_finish && $item->time_finish!=0){
                        $item->status_id = GoatItems::STATUS_MILK;
                        $item->save();
                    }
                }
                return ['status' => true, 'goatItems'=>$goatItems];
            } else {
                return ['status' => false, 'msg' => Yii::t('app', 'Ошибка на стороне сервера') . '!'];
            }
        }
        else
        {
            throw new NotFoundHttpException;
        }
    }

    public function actionSetGoat(){
        if(Yii::$app->user->isGuest)
        {
            throw new NotFoundHttpException;
        }
        if(Yii::$app->request->isAjax) {
            Yii::$app->response->format = 'json';
            $paddockId = Yii::$app->request->post('paddockId');
            $position = Yii::$app->request->post('position');
            $userId = Yii::$app->user->id;
            $set = GoatItems::find()->where(['status_id'=>0])->andWhere(['user_id'=>$userId])->andWhere(['paddock_id' => $paddockId])->andWhere(['position' => $position])->one();
            $status = GoatItems::STATUS_HUNGRY;
            if (!empty($paddockId) && !empty($position)) {
                if (count($set) != 0) {
                    $goats = UserStorage::find()->where(['user_id' => $userId])->one();
                    if ($goats->goat > 0) {
                        $goats->goat -= 1;
                        $goats->save();

                        $model = GoatItems::find()->where(['paddock_id' => $paddockId])->andWhere(['position' => $position])->one();
                        $model->status_id = $status;
                        $model->user_id = $userId;
                        $model->time_start = 0;
                        $model->time_finish = 0;
                        $model->count_milk = 0;
                        $model->save();
                        $countGoat = GoatItems::find()->where(['user_id' => $userId])->andWhere(['paddock_id' => $paddockId])->andWhere(['not', ['status_id' => 0]])->all();
                        $countGoat = count($countGoat);
                    } else {
                        return ['status' => false, 'msg' => 'У вас нет коз'];
                    }
                    return ['status' => true, 'msg' => Yii::t('app', 'Вы посадили козу') . '!', 'goat' => $goats->goat, 'countAnimal' => $countGoat];
                }else {
                    return ['status' => false, 'msg' => Yii::t('app', 'Коза уже посажена, обновите страницу') . '!'];
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

    public function actionFeedGoat(){
        if(Yii::$app->user->isGuest)
        {
            throw new NotFoundHttpException;
        }
        if(Yii::$app->request->isAjax) {
            Yii::$app->response->format = 'json';
            $paddockId = Yii::$app->request->post('paddockId');
            $position = Yii::$app->request->post('position');
            $userId = Yii::$app->user->identity->id;
            $user = User::find()->where(['id'=>$userId])->one();
            $energy = $user->energy;
            $showLevel = false;
            $feeding = GoatItems::find()->where(['status_id'=>GoatItems::STATUS_HUNGRY])->andWhere(['user_id'=>$userId])->andWhere(['paddock_id' => $paddockId])->andWhere(['position' => $position])->one();
            if (!empty($paddockId) && !empty($position)) {
                if (count($feeding) != 0) {
                    $userStorage = UserStorage::find()->where(['user_id' => $userId])->one();
                    if ($userStorage->feed_goats >= 2) {
                        //-4 энергии
                        if ($energy >= Settings::$countEnergyForFeedGoat) {
                            $energy -= Settings::$countEnergyForFeedGoat;
                            if ($newLevel = $user->isLevelUp(2)) {
                                $showLevel = true;
                            } //+2 опыта

                            $userStorage->feed_goats -= 2;
                            $userStorage->save();

                            $model = GoatItems::find()->where(['paddock_id' => $paddockId])->andWhere(['position' => $position])->one();
                            $model->status_id = GoatItems::STATUS_DEFAULT;
                            $model->time_start = time();
                            $model->time_finish = strtotime('tomorrow');
                            $model->save();

                            Yii::$app->db->createCommand()
                                ->update('user', ['energy' => $energy], 'id = :id', ['id' => $userId])
                                ->execute();
                            return ['status' => true, 'msg' => Yii::t('app', 'Вы покормили козу') . '!', 'energy' => $energy, 'experience' => $user->experience, 'feed' => $userStorage->feed_goats, 'showLevel' => $showLevel, 'newLevel' => $newLevel];
                        } else {
                            return ['status' => false, 'msg' => Yii::t('app', 'У вас недостаточно энергии, необходимо {energyUnits} энергии', [
                                'energyUnits' => Settings::$countEnergyForFeedGoat,
                            ]) . '!'];
                        }
                    } else {
                        return ['status' => false, 'msg' => Yii::t('app', 'У вас недостаточно корма, необходимо {units} корма', [
                            'units' => 2,
                        ]) . '!'];
                    }
                }else {
                    return ['status' => false, 'msg' => Yii::t('app', 'Коза уже покормлена, обновите страницу') . '!'];
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

    public function actionGetGoatMilk(){
        if(Yii::$app->user->isGuest)
        {
            throw new NotFoundHttpException;
        }
        if(Yii::$app->request->isAjax) {
            Yii::$app->response->format = 'json';
            $paddockId = Yii::$app->request->post('paddockId');
            $position = Yii::$app->request->post('position');
            $userId = Yii::$app->user->identity->id;
            $user = User::find()->where(['id'=>$userId])->one();
            $energy = $user->energy;
            $showLevel = false;
            $milk = GoatItems::find()->where(['status_id'=>GoatItems::STATUS_MILK])->andWhere(['user_id'=>$userId])->andWhere(['paddock_id' => $paddockId])->andWhere(['position' => $position])->one();
            if (!empty($paddockId) && !empty($position)) {
                if (count($milk) != 0) {
                    if ($energy >= Settings::$countEnergyForGetMilkGoat) {
                        $energy -= Settings::$countEnergyForGetMilkGoat;
                        if ($newLevel = $user->isLevelUp(Settings::$countExpGetGMilk)) {
                            $showLevel = true;
                        }  //+6 опыта

                        $model = GoatItems::find()->where(['paddock_id' => $paddockId])->andWhere(['position' => $position])->one();
                        $model->status_id = GoatItems::STATUS_HUNGRY;
                        $model->time_start = 0;
                        $model->time_finish = 0;
                        $model->count_milk += 2;
                        if ($model->count_milk == 60) {
                            $model->status_id = 0; // коза сдохла
                        }
                        $model->save();

                        Yii::$app->db->createCommand()
                            ->update('user', ['energy' => $energy], 'id = :id', ['id' => $userId])
                            ->execute();

                        $userStorage = UserStorage::find()->where(['user_id' => $userId])->one();
                        $userStorage->goat_milk_for_sell += 2;
                        $userStorage->save();
                        return ['status' => true, 'msg' => Yii::t('app', 'Вы собрали молоко') . '!', 'energy' => $energy, 'experience' => $user->experience, 'count_milk' => $model->count_milk, 'status_id' => $model->status_id, 'milk' => $userStorage->goat_milk_for_sell, 'showLevel' => $showLevel, 'newLevel' => $newLevel];
                    } else {
                        return ['status' => false, 'msg' => Yii::t('app', 'У вас недостаточно энергии, необходимо {energyUnits} энергии', [
                            'energyUnits' => Settings::$countEnergyForGetMilkGoat,
                        ]) . '!'];
                    }
                }else{
                    return ['status' => false, 'msg' => Yii::t('app', 'Молоко уже собрано, обновите страницу') . '!'];
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

    public function actionBuildPaddockCow(){
        if(Yii::$app->user->isGuest)
        {
            throw new NotFoundHttpException;
        }
        if(Yii::$app->request->isAjax) {
            Yii::$app->response->format = 'json';
            $paddockId = Yii::$app->request->post('id');
            $pole = Yii::$app->request->post('pole');
            $level = Yii::$app->request->post('level');
            $userId = Yii::$app->user->id;
            $build = PaddockCowItems::find()->where(['status_id'=>0])->andWhere(['user_id'=>$userId])->andWhere(['item_id' => $paddockId])->one();
            if (!empty($paddockId)) {
                if (count($build) != 0) {
                    $model = UserStorage::find()->where(['user_id' => $userId])->one();
                    if ($model->paddock_cows > 0) {
                        $model->paddock_cows -= 1;
                        $model->save();
                        $cowItems = array();
                        for ($k = 1; $k < 10; $k++) {
                            $cowItems[$k]['paddock_id'] = $paddockId;
                            $cowItems[$k]['user_id'] = Yii::$app->user->id;
                            $cowItems[$k]['position'] = $k;
                        }
                        Yii::$app->db->createCommand()
                            ->batchInsert('cow_items', ['paddock_id', 'user_id', 'position'], $cowItems)
                            ->execute();
                        unset($cowItems);
                        Yii::$app->db->createCommand()
                            ->update('paddock_cow_items', ['status_id' => PaddockCowItems::STATUS_READY], 'item_id = :id', ['id' => $paddockId])
                            ->execute();
                        if ($pole == 'pole-9') {
                            //create 9 cow_items
                            $paddockItems = array();
                            for ($j = $level + 1; $j < $level + 10; $j++) {
                                $paddockItems[$j]['user_id'] = Yii::$app->user->id;
                                if ($j == 1) {
                                    $paddockItems[$j]['status_id'] = PaddockCowItems::STATUS_READY;
                                } else {
                                    $paddockItems[$j]['status_id'] = PaddockCowItems::STATUS_NOT_AVAILABLE;
                                }
                                $paddockItems[$j]['level'] = $j;
                            }
                            Yii::$app->db->createCommand()
                                ->batchInsert('paddock_cow_items', ['user_id', 'status_id', 'level'], $paddockItems)
                                ->execute();
                            unset($paddockItems);
                        }
                    } else {
                        return ['status' => false, 'msg' => Yii::t('app', 'У вас нет загона в наличии') . '!'];
                    }
                    return ['status' => true, 'msg' => Yii::t('app', 'Поздравляем, вы построили загон коров') . '!'];
                }else{
                    return ['status' => false, 'msg' => Yii::t('app', 'Здесь уже построен загон, обновите страницу') . '!'];
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

    public function actionOpenPaddockCow()
    {
        if(Yii::$app->user->isGuest)
        {
            throw new NotFoundHttpException;
        }
        if(Yii::$app->request->isAjax) {
            Yii::$app->response->format = 'json';
            $paddockId = Yii::$app->request->post('paddockId');
            if (!empty($paddockId)) {
                $cowItems = CowItems::find()->where(['paddock_id'=>$paddockId])->orderBy(['item_id'=>SORT_ASC])->limit(9)->all();
                foreach($cowItems as $item){
                    if(time() > $item->time_finish && $item->time_finish!=0){
                        $item->status_id = CowItems::STATUS_MILK;
                        $item->save();
                    }
                }
                return ['status' => true, 'cowItems'=>$cowItems];
            } else {
                return ['status' => false, 'msg' => Yii::t('app', 'Ошибка на стороне сервера') . '!'];
            }
        }
        else
        {
            throw new NotFoundHttpException;
        }
    }

    public function actionSetCow(){
        if(Yii::$app->user->isGuest)
        {
            throw new NotFoundHttpException;
        }
        if(Yii::$app->request->isAjax) {
            Yii::$app->response->format = 'json';
            $paddockId = Yii::$app->request->post('paddockId');
            $position = Yii::$app->request->post('position');
            $userId = Yii::$app->user->id;
            $set = CowItems::find()->where(['status_id'=>0])->andWhere(['user_id'=>$userId])->andWhere(['paddock_id' => $paddockId])->andWhere(['position' => $position])->one();
            $status = CowItems::STATUS_HUNGRY;
            if (!empty($paddockId) && !empty($position)) {
                if (count($set) != 0) {
                    $cows = UserStorage::find()->where(['user_id' => $userId])->one();
                    if ($cows->cow > 0) {
                        $cows->cow -= 1;
                        $cows->save();

                        $model = CowItems::find()->where(['paddock_id' => $paddockId])->andWhere(['position' => $position])->one();
                        $model->status_id = $status;
                        $model->user_id = $userId;
                        $model->time_start = 0;
                        $model->time_finish = 0;
                        $model->count_milk = 0;
                        $model->save();
                        $countCow = CowItems::find()->where(['user_id' => $userId])->andWhere(['paddock_id' => $paddockId])->andWhere(['not', ['status_id' => 0]])->all();
                        $countCow = count($countCow);
                    } else {
                        return ['status' => false, 'msg' => 'У вас нет коров'];
                    }
                    return ['status' => true, 'msg' => Yii::t('app', 'Вы посадили корову') . '!', 'cow' => $cows->cow, 'countAnimal' => $countCow];
                }else {
                    return ['status' => false, 'msg' => Yii::t('app', 'Корова уже посажена, обновите страницу') . '!'];
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

    public function actionFeedCow(){
        if(Yii::$app->user->isGuest)
        {
            throw new NotFoundHttpException;
        }
        if(Yii::$app->request->isAjax) {
            Yii::$app->response->format = 'json';
            $paddockId = Yii::$app->request->post('paddockId');
            $position = Yii::$app->request->post('position');
            $userId = Yii::$app->user->identity->id;
            $user = User::find()->where(['id'=>$userId])->one();
            $energy = $user->energy;
            $showLevel = false;
            $feeding = CowItems::find()->where(['status_id'=>CowItems::STATUS_HUNGRY])->andWhere(['user_id'=>$userId])->andWhere(['paddock_id' => $paddockId])->andWhere(['position' => $position])->one();
            if (!empty($paddockId) && !empty($position)) {
                if (count($feeding) != 0) {
                    $userStorage = UserStorage::find()->where(['user_id' => $userId])->one();
                    if ($userStorage->feed_cows >= 2) {
                        //-4 энергии
                        if ($energy >= Settings::$countEnergyForFeedCow) {
                            $energy -= Settings::$countEnergyForFeedCow;
                            if ($newLevel = $user->isLevelUp(2)) {
                                $showLevel = true;
                            }//+2 опыта

                            $userStorage->feed_cows -= 2;
                            $userStorage->save();

                            $model = CowItems::find()->where(['paddock_id' => $paddockId])->andWhere(['position' => $position])->one();
                            $model->status_id = CowItems::STATUS_DEFAULT;
                            $model->time_start = time();
                            $model->time_finish = strtotime('tomorrow');
                            $model->save();

                            Yii::$app->db->createCommand()
                                ->update('user', ['energy' => $energy], 'id = :id', ['id' => $userId])
                                ->execute();
                            return ['status' => true, 'msg' => Yii::t('app', 'Вы покормили корову') . '!', 'energy' => $energy, 'experience' => $user->experience, 'feed' => $userStorage->feed_cows, 'showLevel' => $showLevel, 'newLevel' => $newLevel];
                        } else {
                            return ['status' => false, 'msg' => Yii::t('app', 'У вас недостаточно энергии, необходимо {energyUnits} энергии', [
                                'energyUnits' => Settings::$countEnergyForFeedCow,
                            ]) . '!'];
                        }
                    } else {
                        return ['status' => false, 'msg' => Yii::t('app', 'У вас недостаточно корма, необходимо {units} корма', [
                            'units' => 2,
                        ]) . '!'];
                    }
                }else {
                    return ['status' => false, 'msg' => Yii::t('app', 'Корова уже покормлена, обновите страницу') . '!'];
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

    public function actionGetCowMilk(){
        if(Yii::$app->user->isGuest)
        {
            throw new NotFoundHttpException;
        }
        if(Yii::$app->request->isAjax) {
            Yii::$app->response->format = 'json';
            $paddockId = Yii::$app->request->post('paddockId');
            $position = Yii::$app->request->post('position');
            $userId = Yii::$app->user->identity->id;
            $user = User::find()->where(['id'=>$userId])->one();
            $energy = $user->energy;
            $showLevel = false;
            $milk = CowItems::find()->where(['status_id'=>CowItems::STATUS_MILK])->andWhere(['user_id'=>$userId])->andWhere(['paddock_id' => $paddockId])->andWhere(['position' => $position])->one();
            if (!empty($paddockId) && !empty($position)) {
                if (count($milk) != 0) {
                    //-16 энергии
                    if ($energy >= Settings::$countEnergyForGetMilkCow) {
                        $energy -= Settings::$countEnergyForGetMilkCow;
                        if ($newLevel = $user->isLevelUp(Settings::$countExpGetCMilk)) {
                            $showLevel = true;
                        }  //+8 опыта

                        $model = CowItems::find()->where(['paddock_id' => $paddockId])->andWhere(['position' => $position])->one();
                        $model->status_id = CowItems::STATUS_HUNGRY;
                        $model->time_start = 0;
                        $model->time_finish = 0;
                        $model->count_milk += 2;
                        if ($model->count_milk == 60) {
                            $model->status_id = 0; // курица сдохла
                        }
                        $model->save();

                        Yii::$app->db->createCommand()
                            ->update('user', ['energy' => $energy], 'id = :id', ['id' => $userId])
                            ->execute();

                        $userStorage = UserStorage::find()->where(['user_id' => $userId])->one();
                        $userStorage->cow_milk_for_sell += 2;
                        $userStorage->save();
                        return ['status' => true, 'msg' => Yii::t('app', 'Вы собрали молоко') . '!', 'energy' => $energy, 'experience' => $user->experience, 'count_milk' => $model->count_milk, 'status_id' => $model->status_id, 'milk' => $userStorage->cow_milk_for_sell, 'showLevel' => $showLevel, 'newLevel' => $newLevel];
                    } else {
                        return ['status' => false, 'msg' => Yii::t('app', 'У вас недостаточно энергии, необходимо {energyUnits} энергии', [
                            'energyUnits' => Settings::$countEnergyForGetMilkCow,
                        ]) . '!'];
                    }
                }else{
                    return ['status' => false, 'msg' => Yii::t('app', 'Молоко уже собрано, обновите страницу') . '!'];
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

    public function actionCollectAll(){
        if(Yii::$app->user->isGuest)
        {
            throw new NotFoundHttpException;
        }
        $startTimer = microtime(true);
        if(Yii::$app->request->isAjax) {
            Yii::$app->response->format = 'json';
            $modelName = Yii::$app->request->post('modelName');
            $userId = Yii::$app->user->identity->id;
            $eggs = UserStorage::find()->where(['user_id' => $userId])->one();
            $user = User::find()->where(['id' => $userId])->one();
            $energy =$user->energy;
            $showLevel = false;
            switch($modelName) {
                case 'ChickenItems':
                    $models = ChickenItems::find()->where(['user_id' => $userId])
                        ->andWhere(['status_id' => [ChickenItems::STATUS_EGG, ChickenItems::STATUS_DEFAULT]])
                        ->andWhere(['not', ['time_finish' => 0]])
                        ->andWhere(['<=', 'time_finish', strtotime('now')])
                        ->all();
                    $countProduct = count($models);
                    //echo '<pre>'; var_dump($countProduct); die();
                    if ($countProduct != 0) {
                        if ($energy >= $countProduct * Settings::$countEnergyForAutoGetEggChicken) {
                            $energy -= $countProduct * Settings::$countEnergyForAutoGetEggChicken;
                            if ($newLevel = $user->isLevelUp($countProduct * Settings::$countExpGetEgg)) {
                                $showLevel = true;
                            }
                            foreach ($models as $model) {
                                $model->status_id = ChickenItems::STATUS_HUNGRY;
                                $model->time_start = 0;
                                $model->time_finish = 0;
                                $model->count_eggs += 2;
                                if ($model->count_eggs == 60) {
                                    $model->status_id = 0; // курица сдохла
                                }
                                $model->save();
                            }
                            $eggs->egg_for_sell += ($countProduct * 2); //с каждого животного по 2 ед. продукции
                            $eggs->save();
                            Yii::$app->db->createCommand()
                                ->update('user', ['energy' => $energy], 'id = :id', ['id' => $userId])
                                ->execute();
                            $endTimer = microtime(true);
                            $diffTimer = (int)($endTimer - $startTimer);
                            return ['status' => true, 'msg' => Yii::t('app', 'Вы собрали все яйца') . '!', 'timer' => $diffTimer, 'showLevel' => $showLevel, 'newLevel' => $newLevel];
                        }else{
                            return ['status' => false, 'msg' => Yii::t('app', 'У вас недостаточно энергии, необходимо {energyUnits} энергии', [
                                'energyUnits' => ($countProduct * Settings::$countEnergyForAutoGetEggChicken),
                            ]) . '!'];
                        }
                    }else {
                        return ['status' => false, 'msg' => Yii::t('app', 'У вас нет яиц для сбора') . '!'];
                    }
                    break;

                case 'BullItems':
                    $models = BullItems::find()->where(['user_id' => $userId])
                        ->andWhere(['status_id' => [BullItems::STATUS_MEAT, BullItems::STATUS_DEFAULT]])
                        ->andWhere(['not', ['time_finish' => 0]])
                        ->andWhere(['<=', 'time_finish', strtotime('now')])
                        ->all();
                    $countProduct = count($models);
                    if ($countProduct != 0) {
                        if ($energy >= $countProduct * Settings::$countEnergyForAutoGetMeatBull) {
                            $energy -= $countProduct * Settings::$countEnergyForAutoGetMeatBull;
                            if ($newLevel = $user->isLevelUp($countProduct * Settings::$countExpGetMeat)) {
                                $showLevel = true;
                            }
                            foreach ($models as $model) {
                                $model->status_id = BullItems::STATUS_HUNGRY;
                                $model->time_start = 0;
                                $model->time_finish = 0;
                                $model->count_meat += 2;
                                if ($model->count_meat == 60) {
                                    $model->status_id = 0; // курица сдохла
                                }
                                $model->save();
                            }
                            $eggs->meat_for_sell += ($countProduct * 2); //с каждого животного по 2 ед. продукции
                            $eggs->save();
                            Yii::$app->db->createCommand()
                                ->update('user', ['energy' => $energy], 'id = :id', ['id' => $userId])
                                ->execute();
                            $endTimer = microtime(true);
                            $diffTimer = (int)($endTimer - $startTimer);
                            return ['status' => true, 'msg' => Yii::t('app', 'Вы собрали все мясо') . '!', 'timer' => $diffTimer, 'showLevel' => $showLevel, 'newLevel' => $newLevel];
                        }else{
                            return ['status' => false, 'msg' => Yii::t('app', 'У вас недостаточно энергии, необходимо {energyUnits} энергии', [
                                'energyUnits' => ($countProduct * Settings::$countEnergyForAutoGetMeatBull),
                            ]) . '!'];
                        }
                    }else {
                        return ['status' => false, 'msg' => Yii::t('app', 'У вас нет мяса для сбора') . '!'];
                    }
                    break;

                case 'GoatItems':
                    $models = GoatItems::find()->where(['user_id' => $userId])
                        ->andWhere(['status_id' => [GoatItems::STATUS_MILK, GoatItems::STATUS_DEFAULT]])
                        ->andWhere(['not', ['time_finish' => 0]])
                        ->andWhere(['<=', 'time_finish', strtotime('now')])
                        ->all();
                    $countProduct = count($models);
                    if ($countProduct != 0) {
                        if ($energy >= $countProduct * Settings::$countEnergyForAutoGetMilkGoat) {
                            $energy -= $countProduct * Settings::$countEnergyForAutoGetMilkGoat;
                            if ($newLevel = $user->isLevelUp($countProduct * Settings::$countExpGetGMilk)) {
                                $showLevel = true;
                            }
                            foreach ($models as $model) {
                                $model->status_id = GoatItems::STATUS_HUNGRY;
                                $model->time_start = 0;
                                $model->time_finish = 0;
                                $model->count_milk += 2;
                                if ($model->count_milk == 60) {
                                    $model->status_id = 0; // курица сдохла
                                }
                                $model->save();
                            }
                            $eggs->goat_milk_for_sell += ($countProduct * 2); //с каждого животного по 2 ед. продукции
                            $eggs->save();
                            Yii::$app->db->createCommand()
                                ->update('user', ['energy' => $energy], 'id = :id', ['id' => $userId])
                                ->execute();
                            $endTimer = microtime(true);
                            $diffTimer = (int)($endTimer - $startTimer);
                            return ['status' => true, 'msg' => Yii::t('app', 'Вы собрали все молоко') . '!', 'timer' => $diffTimer, 'showLevel' => $showLevel, 'newLevel' => $newLevel];
                        }else{
                            return ['status' => false, 'msg' => Yii::t('app', 'У вас недостаточно энергии, необходимо {energyUnits} энергии', [
                                'energyUnits' => ($countProduct * Settings::$countEnergyForAutoGetMilkGoat),
                            ]) . '!'];
                        }
                    }else {
                        return ['status' => false, 'msg' => Yii::t('app', 'У вас нет молока для сбора') . '!'];
                    }
                    break;

                case 'CowItems':
                    $models = CowItems::find()->where(['user_id' => $userId])
                        ->andWhere(['status_id' => [CowItems::STATUS_MILK, CowItems::STATUS_DEFAULT]])
                        ->andWhere(['not', ['time_finish' => 0]])
                        ->andWhere(['<=', 'time_finish', strtotime('now')])
                        ->all();
                    $countProduct = count($models);
                    if ($countProduct != 0) {
                        if ($energy >= $countProduct * Settings::$countEnergyForAutoGetMilkCow) {
                            $energy -= $countProduct * Settings::$countEnergyForAutoGetMilkCow;
                            if ($newLevel = $user->isLevelUp($countProduct * Settings::$countExpGetCMilk)) {
                                $showLevel = true;
                            }
                            foreach ($models as $model) {
                                $model->status_id = CowItems::STATUS_HUNGRY;
                                $model->time_start = 0;
                                $model->time_finish = 0;
                                $model->count_milk += 2;
                                if ($model->count_milk == 60) {
                                    $model->status_id = 0; // курица сдохла
                                }
                                $model->save();
                            }
                            $eggs->cow_milk_for_sell += ($countProduct * 2); //с каждого животного по 2 ед. продукции
                            $eggs->save();
                            Yii::$app->db->createCommand()
                                ->update('user', ['energy' => $energy], 'id = :id', ['id' => $userId])
                                ->execute();
                            $endTimer = microtime(true);
                            $diffTimer = (int)($endTimer - $startTimer);
                            return ['status' => true, 'msg' => Yii::t('app', 'Вы собрали все молоко') . '!', 'timer' => $diffTimer, 'showLevel' => $showLevel, 'newLevel' => $newLevel];
                        }else{
                            return ['status' => false, 'msg' => Yii::t('app', 'У вас недостаточно энергии, необходимо {energyUnits} энергии', [
                                'energyUnits' => ($countProduct * Settings::$countEnergyForAutoGetMilkCow),
                            ]) . '!'];
                        }
                    }else {
                        return ['status' => false, 'msg' => Yii::t('app', 'У вас нет молока для сбора') . '!'];
                    }
                    break;
            }
        }
        else
        {
            throw new NotFoundHttpException;
        }
    } //общий функционал сбора продукции

    public function actionFeedAll(){
        if(Yii::$app->user->isGuest)
        {
            throw new NotFoundHttpException;
        }
        $startTimer = microtime(true);
        if(Yii::$app->request->isAjax) {
            Yii::$app->response->format = 'json';
            $modelName = Yii::$app->request->post('modelName');
            $userId = Yii::$app->user->identity->id;
            $feedChickens = UserStorage::find()->where(['user_id' => $userId])->one();
            $user = User::find()->where(['id' => $userId])->one();
            $energy =$user->energy;
            $showLevel = false;
            switch($modelName){
                case 'ChickenItems':
                    $models = ChickenItems::find()->where(['user_id' => $userId])->andWhere(['status_id' => ChickenItems::STATUS_HUNGRY])->all();
                    $feed = count($models);
                    //echo '<pre>'; var_dump($feed); die();
                    if ($feed != 0) {
                        if ($energy >= ($feed * Settings::$countEnergyForAutoFeedChicken)) {
                            if ($feedChickens->feed_chickens >= ($feed * 2)) { //одно животное употребляет 2 ед. корма
                                $energy -= $feed * Settings::$countEnergyForAutoFeedChicken;
                                if ($newLevel = $user->isLevelUp($feed * Settings::$countExpGetEgg)) {//если за все кормление 2 ед. опыта
                                    $showLevel = true;
                                }
                                foreach ($models as $model) {
                                    $model->status_id = ChickenItems::STATUS_DEFAULT;
                                    $model->time_start = time();
                                    $model->time_finish = strtotime('tomorrow');
                                    $model->save();
                                }
                                $feedChickens->feed_chickens -= ($feed * 2); //с каждого животного по 2 ед. продукции
                                $feedChickens->save();

                                Yii::$app->db->createCommand()
                                    ->update('user', ['energy' => $energy], 'id = :id', ['id' => $userId])
                                    ->execute();
                                $endTimer = microtime(true);
                                $diffTimer = (int)($endTimer - $startTimer);
                                return ['status' => true, 'timer' => $diffTimer, 'msg' => Yii::t('app', 'Вы покормили всех куриц') . '!', 'showLevel' => $showLevel, 'newLevel' => $newLevel];
                            } else {
                                $countFeed = ($feed * 2) - $feedChickens->feed_chickens;
                                return ['status' => false, 'msg' => Yii::t('app', 'У вас недостаточно {units} ед. корма', [
                                    'units' => $countFeed,
                                ]) . '!'];
                            }
                        }else{
                            return ['status' => false, 'msg' => Yii::t('app', 'У вас недостаточно энергии, необходимо {energyUnits} энергии', [
                                'energyUnits' => ($feed * Settings::$countEnergyForAutoFeedChicken),
                            ]) . '!'];
                        }
                    }else {
                        return ['status' => false, 'msg' => Yii::t('app', 'У вас нет куриц для кормления') . '!'];
                    }
                    break;

                case 'BullItems':
                    $models = BullItems::find()->where(['user_id' => $userId])->andWhere(['status_id' => BullItems::STATUS_HUNGRY])->all();
                    $feed = count($models);
                    if ($feed != 0) {
                        if ($energy >= ($feed * Settings::$countEnergyForAutoFeedBull)) {
                            if ($feedChickens->feed_bulls >= ($feed * 2)) { //одно животное употребляет 2 ед. корма
                                $energy -= $feed * Settings::$countEnergyForAutoFeedBull;
                                if ($newLevel = $user->isLevelUp($feed * Settings::$countExpGetMeat)) {//если за все кормление 2 ед. опыта
                                    $showLevel = true;
                                }
                                foreach ($models as $model) {
                                    $model->status_id = BullItems::STATUS_DEFAULT;
                                    $model->time_start = time();
                                    $model->time_finish = strtotime('tomorrow');
                                    $model->save();
                                }
                                $feedChickens->feed_bulls -= ($feed * 2); //с каждого животного по 2 ед. продукции
                                $feedChickens->save();

                                Yii::$app->db->createCommand()
                                    ->update('user', ['energy' => $energy], 'id = :id', ['id' => $userId])
                                    ->execute();
                                $endTimer = microtime(true);
                                $diffTimer = (int)($endTimer - $startTimer);
                                return ['status' => true, 'timer' => $diffTimer, 'msg' => Yii::t('app', 'Вы покормили всех бычков') . '!', 'showLevel' => $showLevel, 'newLevel' => $newLevel];
                            } else {
                                $countFeed = ($feed * 2) - $feedChickens->feed_bulls;
                                return ['status' => false, 'msg' => Yii::t('app', 'У вас недостаточно {units} ед. корма', [
                                    'units' => $countFeed,
                                ]) . '!'];
                            }
                        }else{
                            return ['status' => false, 'msg' => Yii::t('app', 'У вас недостаточно энергии, необходимо {energyUnits} энергии', [
                                'energyUnits' => ($feed * Settings::$countEnergyForAutoFeedBull),
                            ]) . '!'];
                        }
                    }else {
                        return ['status' => false, 'msg' => Yii::t('app', 'У вас нет бычков для кормления') . '!'];
                    }
                    break;

                case 'GoatItems':
                    $models = GoatItems::find()->where(['user_id' => $userId])->andWhere(['status_id' => GoatItems::STATUS_HUNGRY])->all();
                    $feed = count($models);
                    if ($feed != 0) {
                        if ($energy >= ($feed * Settings::$countEnergyForAutoFeedGoat)) {
                            if ($feedChickens->feed_goats >= ($feed * 2)) { //одно животное употребляет 2 ед. корма
                                $energy -= $feed * Settings::$countEnergyForAutoFeedGoat;
                                if ($newLevel = $user->isLevelUp($feed * Settings::$countExpGetGMilk)) {//если за все кормление 2 ед. опыта
                                    $showLevel = true;
                                }
                                foreach ($models as $model) {
                                    $model->status_id = GoatItems::STATUS_DEFAULT;
                                    $model->time_start = time();
                                    $model->time_finish = strtotime('tomorrow');
                                    $model->save();
                                }
                                $feedChickens->feed_goats -= ($feed * 2); //с каждого животного по 2 ед. продукции
                                $feedChickens->save();

                                Yii::$app->db->createCommand()
                                    ->update('user', ['energy' => $energy], 'id = :id', ['id' => $userId])
                                    ->execute();
                                $endTimer = microtime(true);
                                $diffTimer = (int)($endTimer - $startTimer);
                                return ['status' => true, 'timer' => $diffTimer, 'msg' => 'Вы покормили всех коз', 'showLevel' => $showLevel, 'newLevel' => $newLevel];
                            } else {
                                $countFeed = ($feed * 2) - $feedChickens->feed_goats;
                                return ['status' => false, 'msg' => 'У вас недостаточно ' . $countFeed . ' ед. корма!'];
                            }
                        }else{
                            return ['status' => false, 'msg' => 'У вас недостаточно энергии, необходимо '.($feed*Settings::$countEnergyForAutoFeedGoat).' энергии'];
                        }
                    }else {
                        return ['status' => false, 'msg' => 'У вас нет коз для кормления!'];
                    }
                    break;

                case 'CowItems':
                    $models = CowItems::find()->where(['user_id' => $userId])->andWhere(['status_id' => CowItems::STATUS_HUNGRY])->all();
                    $feed = count($models);
                    if ($feed != 0) {
                        if ($energy >= ($feed * Settings::$countEnergyForAutoFeedCow)) {
                            if ($feedChickens->feed_cows >= ($feed * 2)) { //одно животное употребляет 2 ед. корма
                                $energy -= $feed * Settings::$countEnergyForAutoFeedCow;
                                if ($newLevel = $user->isLevelUp($feed * Settings::$countExpGetCMilk)) {//если за все кормление 2 ед. опыта
                                    $showLevel = true;
                                }
                                foreach ($models as $model) {
                                    $model->status_id = GoatItems::STATUS_DEFAULT;
                                    $model->time_start = time();
                                    $model->time_finish = strtotime('tomorrow');
                                    $model->save();
                                }
                                $feedChickens->feed_cows -= ($feed * 2); //с каждого животного по 2 ед. продукции
                                $feedChickens->save();

                                Yii::$app->db->createCommand()
                                    ->update('user', ['energy' => $energy], 'id = :id', ['id' => $userId])
                                    ->execute();
                                $endTimer = microtime(true);
                                $diffTimer = (int)($endTimer - $startTimer);
                                return ['status' => true, 'timer' => $diffTimer, 'msg' => 'Вы покормили всех коров', 'showLevel' => $showLevel, 'newLevel' => $newLevel];
                            } else {
                                $countFeed = ($feed * 2) - $feedChickens->feed_cows;
                                return ['status' => false, 'msg' => 'У вас недостаточно ' . $countFeed . ' ед. корма!'];
                            }
                        }else{
                            return ['status' => false, 'msg' => 'У вас недостаточно энергии, необходимо '.($feed*Settings::$countEnergyForAutoFeedCow).' энергии'];
                        }
                    }else {
                        return ['status' => false, 'msg' => 'У вас нет коров для кормления!'];
                    }
                    break;
            }
        }
        else
        {
            throw new NotFoundHttpException;
        }
    } //кормление

    public function actionCollectOnePaddock(){
        if(Yii::$app->user->isGuest)
        {
            throw new NotFoundHttpException;
        }
        $startTimer = microtime(true);
        if(Yii::$app->request->isAjax) {
            Yii::$app->response->format = 'json';
            $paddockId = Yii::$app->request->post('paddockid');
            $modelName = Yii::$app->request->post('modelName');
            $userId = Yii::$app->user->identity->id;
            $userStorage = UserStorage::find()->where(['user_id'=>$userId])->one();
            $user = User::find()->where(['id' => $userId])->one();
            $energy =$user->energy;
            //$experience = $user->experience;
            $showLevel=false;
            switch($modelName){
                case 'ChickenItems':
                    $milk = ChickenItems::find()->where(['user_id' => $userId])
                        ->andWhere(['paddock_id' => $paddockId])
                        ->andWhere(['status_id' => [ChickenItems::STATUS_EGG, ChickenItems::STATUS_DEFAULT]])
                        ->andWhere(['not', ['time_finish' => 0]])->andWhere(['<=', 'time_finish', strtotime('now')])->all();
                    $countMilk = count($milk);

                    $hungryCows = ChickenItems::find()->where(['user_id' => $userId])
                        ->andWhere(['status_id' => ChickenItems::STATUS_HUNGRY])
                        ->andWhere(['paddock_id' => $paddockId])->all();
                    $countHungry = count($hungryCows);
                    // сбор кормление кормление - голодного
                    if($energy >= (($countMilk*Settings::$countEnergyForGetEggChicken)+($countMilk*Settings::$countEnergyForFeedChicken)+($countHungry*Settings::$countEnergyForFeedChicken))) {
                        if($userStorage->feed_chickens >= (($countMilk*2)+($countHungry*2))) {//одно животное употребляет 2 ед. корма
                            if ($countMilk > 0 || $countHungry > 0) {
                                if ($countMilk != 0) {
                                    foreach ($milk as $ml) {
                                        $ml->status_id = ChickenItems::STATUS_HUNGRY;
                                        $ml->time_start = 0;
                                        $ml->time_finish = 0;
                                        $ml->count_eggs += 2;
                                        if ($ml->count_eggs == 60) {
                                            $ml->status_id = 0;
                                        }
                                        $ml->save();
                                    }
                                    $userStorage->egg_for_sell += ($countMilk * 2); //с каждого животного по 2 ед. продукции
                                    if ($newLevel = $user->isLevelUp($countMilk * 2)) {//опыт
                                        $showLevel = true;
                                    }
                                    unset($countHungry);
                                    $energy -= $countMilk * Settings::$countEnergyForGetEggChicken; //чтобы собрать 1 го - 4
                                }

                                $hungryCows = ChickenItems::find()->where(['user_id' => $userId])
                                    ->andWhere(['status_id' => ChickenItems::STATUS_HUNGRY])
                                    ->andWhere(['paddock_id' => $paddockId])->all();
                                $countHungry = count($hungryCows);

                                if ($countHungry != 0) {
                                    /*if ($userStorage->feed_chickens >= $countHungry * 2) {*/ //одно животное употребляет 2 ед. корма
                                    foreach ($hungryCows as $hungry) {
                                        $hungry->status_id = ChickenItems::STATUS_DEFAULT;
                                        $hungry->time_start = time();
                                        $hungry->time_finish = strtotime('tomorrow');
                                        $hungry->save();
                                    }
                                    $userStorage->feed_chickens -= $countHungry * 2;//с каждого животного по 2 ед. корма
                                    if ($newLevel = $user->isLevelUp($countHungry * 2)) {//опыт
                                        $showLevel = true;
                                    }
                                    /*} else {
                                        $countFeed = ($countHungry * 2) - $userStorage->feed_chickens;
                                        return ['status' => false, 'msg' => 'У вас недостаточно ' . $countFeed . ' ед. корма!'];
                                    }*/
                                    $energy -= $countHungry * Settings::$countEnergyForFeedChicken; //чтобы покормить 1 го - 4
                                }
                                $userStorage->save();

                                Yii::$app->db->createCommand()
                                    ->update('user', ['energy' => $energy], 'id = :id', ['id' => $userId])
                                    ->execute();
                                $endTimer = microtime(true);
                                $diffTimer = (int)($endTimer - $startTimer);
                                return ['status' => true, 'timer' => $diffTimer, 'msg' => 'Вы собрали все яйца и покормили всех кур', 'showLevel' => $showLevel, 'newLevel' => $newLevel];
                            }else {
                                return ['status' => false, 'msg' => 'У вас нет яиц для сбора и нет кур для кормления'];
                            }
                        }else {
                            $countFeed = (($countMilk*2)+($countHungry*2)) - $userStorage->feed_chickens;
                            return ['status' => false, 'msg' => 'У вас недостаточно ' . $countFeed . ' ед. корма!'];
                        }
                    } else{
                        return ['status' => false, 'msg' => 'У вас недостаточно энергии, необходимо '.(($countMilk*Settings::$countEnergyForGetEggChicken)+($countMilk*Settings::$countEnergyForFeedChicken)+($countHungry*Settings::$countEnergyForFeedChicken)).' энергии'];
                    }
                    break;
                case 'BullItems':
                    $milk = BullItems::find()->where(['user_id' => $userId])
                        ->andWhere(['paddock_id' => $paddockId])
                        ->andWhere(['status_id' => [BullItems::STATUS_MEAT, BullItems::STATUS_DEFAULT]])
                        ->andWhere(['not', ['time_finish' => 0]])->andWhere(['<=', 'time_finish', strtotime('now')])->all();
                    $countMilk = count($milk);

                    $hungryCows = BullItems::find()->where(['user_id' => $userId])
                        ->andWhere(['status_id' => BullItems::STATUS_HUNGRY])
                        ->andWhere(['paddock_id' => $paddockId])->all();
                    $countHungry = count($hungryCows);
                    //                   сбор           кормление     кормление - голодного
                    if($energy >= (($countMilk*Settings::$countEnergyForGetMeat)+($countMilk*Settings::$countEnergyForFeedBull)+($countHungry*Settings::$countEnergyForFeedBull))) {
                        if ($userStorage->feed_bulls >= (($countMilk * 2) + ($countHungry * 2))) {
                            if ($countMilk > 0 || $countHungry > 0) {
                                if ($countMilk != 0) {
                                    foreach ($milk as $ml) {
                                        $ml->status_id = GoatItems::STATUS_HUNGRY;
                                        $ml->time_start = 0;
                                        $ml->time_finish = 0;
                                        $ml->count_meat += 2;
                                        if ($ml->count_meat == 60) {
                                            $ml->status_id = 0;
                                        }
                                        $ml->save();
                                    }
                                    $userStorage->meat_for_sell += ($countMilk * 2); //с каждого животного по 2 ед. продукции
                                    if ($newLevel = $user->isLevelUp($countMilk * 2)) {//опыт
                                        $showLevel = true;
                                    }
                                    unset($countHungry);
                                    $energy -= $countMilk * Settings::$countEnergyForGetMeat; //чтобы собрать 1 го - 8
                                }

                                $hungryCows = BullItems::find()->where(['user_id' => $userId])
                                    ->andWhere(['status_id' => BullItems::STATUS_HUNGRY])
                                    ->andWhere(['paddock_id' => $paddockId])->all();
                                $countHungry = count($hungryCows);

                                if ($countHungry != 0) {
                                    foreach ($hungryCows as $hungry) {
                                        $hungry->status_id = BullItems::STATUS_DEFAULT;
                                        $hungry->time_start = time();
                                        $hungry->time_finish = strtotime('tomorrow');
                                        $hungry->save();
                                    }
                                    $userStorage->feed_bulls -= $countHungry * 2;//с каждого животного по 2 ед. корма
                                    if ($newLevel = $user->isLevelUp($countHungry * 2)) {//опыт
                                        $showLevel = true;
                                    }
                                    $energy -= $countHungry * Settings::$countEnergyForFeedBull; //чтобы покормить 1 го - 4
                                }

                                $userStorage->save();

                                Yii::$app->db->createCommand()
                                    ->update('user', ['energy' => $energy], 'id = :id', ['id' => $userId])
                                    ->execute();
                                $endTimer = microtime(true);
                                $diffTimer = (int)($endTimer - $startTimer);
                                return ['status' => true, 'timer' => $diffTimer, 'msg' => Yii::t('app', 'Вы собрали все мясо и покормили всех бычков') . '!', 'showLevel' => $showLevel, 'newLevel' => $newLevel];
                            } else {
                                return ['status' => false, 'msg' => Yii::t('app', 'У вас нет мясо для сбора и нет бычков для кормления') . '!'];
                            }
                        }else {
                            $countFeed = (($countMilk*2)+($countHungry*2)) - $userStorage->feed_bulls;
                            return ['status' => false, 'msg' => Yii::t('app', 'У вас недостаточно {units} ед. корма', [
                                'units' => $countFeed,
                            ]) . '!'];
                        }
                    } else{
                        return ['status' => false, 'msg' => Yii::t('app', 'У вас недостаточно энергии, необходимо {energyUnits} энергии', [
                            'energyUnits' => (($countMilk*Settings::$countEnergyForGetMeat)+($countMilk*Settings::$countEnergyForFeedBull)+($countHungry*Settings::$countEnergyForFeedBull)),
                        ]) . '!'];
                    }
                    break;

                case 'GoatItems':
                    $milk = GoatItems::find()->where(['user_id' => $userId])
                        ->andWhere(['paddock_id' => $paddockId])
                        ->andWhere(['status_id' => [GoatItems::STATUS_MILK, GoatItems::STATUS_DEFAULT]])
                        ->andWhere(['not', ['time_finish' => 0]])->andWhere(['<=', 'time_finish', strtotime('now')])->all();
                    $countMilk = count($milk);

                    $hungryCows = GoatItems::find()->where(['user_id' => $userId])
                        ->andWhere(['status_id' => GoatItems::STATUS_HUNGRY])
                        ->andWhere(['paddock_id' => $paddockId])->all();
                    $countHungry = count($hungryCows);
                    if($energy >= (($countMilk*Settings::$countEnergyForGetMilkGoat)+($countMilk*Settings::$countEnergyForFeedGoat)+($countHungry*Settings::$countEnergyForFeedGoat))) {
                        if($userStorage->feed_goats >= (($countMilk*2)+($countHungry*2))) {//одно животное употребляет 2 ед. корма
                            if ($countMilk > 0 || $countHungry > 0) {
                                if ($countMilk != 0) {
                                    foreach ($milk as $ml) {
                                        $ml->status_id = GoatItems::STATUS_HUNGRY;
                                        $ml->time_start = 0;
                                        $ml->time_finish = 0;
                                        $ml->count_milk += 2;
                                        if ($ml->count_milk == 60) {
                                            $ml->status_id = 0;
                                        }
                                        $ml->save();
                                    }
                                    $userStorage->goat_milk_for_sell += ($countMilk * 2); //с каждого животного по 2 ед. продукции
                                    if ($newLevel = $user->isLevelUp($countMilk * 2)) {//опыт
                                        $showLevel = true;
                                    }
                                    unset($countHungry);
                                    $energy -= $countMilk * Settings::$countEnergyForGetMilkGoat; //чтобы собрать 1 го - 12
                                }

                                $hungryCows = GoatItems::find()->where(['user_id' => $userId])
                                    ->andWhere(['status_id' => GoatItems::STATUS_HUNGRY])
                                    ->andWhere(['paddock_id' => $paddockId])->all();
                                $countHungry = count($hungryCows);

                                if ($countHungry != 0) {
                                    foreach ($hungryCows as $hungry) {
                                        $hungry->status_id = GoatItems::STATUS_DEFAULT;
                                        $hungry->time_start = time();
                                        $hungry->time_finish = strtotime('tomorrow');
                                        $hungry->save();
                                    }
                                    $userStorage->feed_goats -= $countHungry * 2;//с каждого животного по 2 ед. корма
                                    if ($newLevel = $user->isLevelUp($countHungry * 2)) {//опыт
                                        $showLevel = true;
                                    }
                                    $energy -= $countHungry * Settings::$countEnergyForFeedGoat; //чтобы покормить 1 го - 4
                                }
                                $userStorage->save();

                                Yii::$app->db->createCommand()
                                    ->update('user', ['energy' => $energy], 'id = :id', ['id' => $userId])
                                    ->execute();
                                $endTimer = microtime(true);
                                $diffTimer = (int)($endTimer - $startTimer);
                                return ['status' => true, 'timer' => $diffTimer, 'msg' => Yii::t('app', 'Вы собрали все молоко и покормили всех коз') . '!', 'showLevel' => $showLevel, 'newLevel' => $newLevel];
                            } else {
                                return ['status' => false, 'msg' => Yii::t('app', 'У вас нет молока для сбора и нет коз для кормления') . '!'];
                            }
                        }else {
                            $countFeed = (($countMilk*2)+($countHungry*2)) - $userStorage->feed_goats;
                            return ['status' => false, 'msg' => Yii::t('app', 'У вас недостаточно {units} ед. корма', [
                                'units' => $countFeed,
                            ]) . '!'];
                        }
                    } else{
                        return ['status' => false, 'msg' => Yii::t('app', 'У вас недостаточно энергии, необходимо {energyUnits} энергии', [
                            'energyUnits' => (($countMilk*Settings::$countEnergyForGetMilkGoat)+($countMilk*Settings::$countEnergyForFeedGoat)+($countHungry*Settings::$countEnergyForFeedGoat)),
                        ]) . '!'];
                    }
                    break;

                case 'CowItems':
                    $milk = CowItems::find()->where(['user_id' => $userId])
                        ->andWhere(['paddock_id' => $paddockId])
                        ->andWhere(['status_id' => [CowItems::STATUS_MILK, CowItems::STATUS_DEFAULT]])
                        ->andWhere(['not', ['time_finish' => 0]])->andWhere(['<=', 'time_finish', strtotime('now')])->all();
                    $countMilk = count($milk);

                    $hungryCows = CowItems::find()->where(['user_id' => $userId])
                        ->andWhere(['status_id' => CowItems::STATUS_HUNGRY])
                        ->andWhere(['paddock_id' => $paddockId])->all();
                    $countHungry = count($hungryCows);
                    if($energy >= (($countMilk*Settings::$countEnergyForGetMilkCow)+($countMilk*Settings::$countEnergyForFeedCow)+($countHungry*Settings::$countEnergyForFeedCow))) {
                        if($userStorage->feed_cows >= (($countMilk*2)+($countHungry*2))) {//одно животное употребляет 2 ед. корма
                            if ($countMilk > 0 || $countHungry > 0) {
                                if ($countMilk != 0) {
                                    foreach ($milk as $ml) {
                                        $ml->status_id = CowItems::STATUS_HUNGRY;
                                        $ml->time_start = 0;
                                        $ml->time_finish = 0;
                                        $ml->count_milk += 2;
                                        if ($ml->count_milk == 60) {
                                            $ml->status_id = 0;
                                        }
                                        $ml->save();
                                    }
                                    $userStorage->cow_milk_for_sell += ($countMilk * 2); //с каждого животного по 2 ед. продукции
                                    if ($newLevel = $user->isLevelUp($countMilk * 2)) {//опыт
                                        $showLevel = true;
                                    }
                                    unset($countHungry);
                                    $energy -= $countMilk * Settings::$countEnergyForGetMilkCow; //чтобы собрать 1 го - 16
                                }

                                $hungryCows = CowItems::find()->where(['user_id' => $userId])
                                    ->andWhere(['status_id' => CowItems::STATUS_HUNGRY])
                                    ->andWhere(['paddock_id' => $paddockId])->all();
                                $countHungry = count($hungryCows);

                                if ($countHungry != 0) {
                                    foreach ($hungryCows as $hungry) {
                                        $hungry->status_id = CowItems::STATUS_DEFAULT;
                                        $hungry->time_start = time();
                                        $hungry->time_finish = strtotime('tomorrow');
                                        $hungry->save();
                                    }
                                    $userStorage->feed_cows -= $countHungry * 2;//с каждого животного по 2 ед. корма
                                    if ($newLevel = $user->isLevelUp($countHungry * 2)) {//опыт
                                        $showLevel = true;
                                    }
                                    $energy -= $countHungry * Settings::$countEnergyForFeedCow; //чтобы покормить 1 го - 4
                                }
                                $userStorage->save();

                                Yii::$app->db->createCommand()
                                    ->update('user', ['energy' => $energy], 'id = :id', ['id' => $userId])
                                    ->execute();
                                $endTimer = microtime(true);
                                $diffTimer = (int)($endTimer - $startTimer);
                                return ['status' => true, 'timer' => $diffTimer, 'msg' => Yii::t('app', 'Вы собрали все молоко и покормили всех коров') . '!', 'showLevel' => $showLevel, 'newLevel' => $newLevel];
                            } else {
                                return ['status' => false, 'msg' => Yii::t('app', 'У вас нет молока для сбора и нет коров для кормления') . '!'];
                            }
                        } else {
                            $countFeed = (($countMilk*2)+($countHungry*2)) - $userStorage->feed_cows;
                            return ['status' => false, 'msg' => Yii::t('app', 'У вас недостаточно {units} ед. корма', [
                                'units' => $countFeed,
                            ]) . '!'];
                        }
                    } else{
                        return ['status' => false, 'msg' => Yii::t('app', 'У вас недостаточно энергии, необходимо {energyUnits} энергии', [
                            'energyUnits' => (($countMilk*Settings::$countEnergyForGetMilkCow)+($countMilk*Settings::$countEnergyForFeedCow)+($countHungry*Settings::$countEnergyForFeedCow)),
                        ]) . '!'];
                    }
                    break;
            }
        }
        else
        {
            throw new NotFoundHttpException;
        }
    }//общий функционал сбора с одного загона

    /**
     * проверка на готовность мясо, если мясо готово, меняем статус - на готово, если нет, то таймер
     */

    public function actionChickenCheck()
    {
        if(Yii::$app->user->isGuest)
        {
            throw new NotFoundHttpException;
        }
        $paddockId = Yii::$app->request->post('bull_id');
        $position = Yii::$app->request->post('position');
        Yii::$app->response->format = 'json';
        if(!empty($paddockId) && !empty($position))
        {
            $chickenItem = ChickenItems::findOne(['paddock_id'=>$paddockId,'position'=>$position]);
            $timeNow = time();
            if($chickenItem->time_finish > time())
            {
                $count = ((int)$chickenItem->count_eggs) / 2;
                $diff = $chickenItem->time_finish-$timeNow;
                return ['status'=>false, 'timer'=>$diff, 'count'=>$count.'/30'];
            }
            else
            {
                $chickenItem->status_id = ChickenItems::STATUS_EGG;
                $chickenItem->save();
                return ['status'=>true, 'class'=>''];
            }
        }
        else
        {
            throw new NotFoundHttpException;
        }
    }

    public function actionBullCheck()
    {
        if(Yii::$app->user->isGuest)
        {
            throw new NotFoundHttpException;
        }
        $paddockId = Yii::$app->request->post('bull_id');
        $position = Yii::$app->request->post('position');
        Yii::$app->response->format = 'json';
        if(!empty($paddockId) && !empty($position))
        {
            $bullItem = BullItems::findOne(['paddock_id'=>$paddockId,'position'=>$position]);
            $timeNow = time();
            if($bullItem->time_finish > time())
            {
                $count = ((int)$bullItem->count_meat ) / 2;
                $diff = $bullItem->time_finish-$timeNow;
                return ['status'=>false, 'timer'=>$diff, 'count'=> $count.'/30'];
            }
            else
            {
                $bullItem->status_id = BullItems::STATUS_MEAT;
                $bullItem->save();
                return ['status'=>true, 'class'=>''];
            }
        }
        else
        {
            throw new NotFoundHttpException;
        }
    }

    public function actionCowCheck()
    {
        if(Yii::$app->user->isGuest)
        {
            throw new NotFoundHttpException;
        }
        $paddockId = Yii::$app->request->post('bull_id');
        $position = Yii::$app->request->post('position');
        Yii::$app->response->format = 'json';
        if(!empty($paddockId) && !empty($position))
        {
            $cowItem = CowItems::findOne(['paddock_id'=>$paddockId,'position'=>$position]);
            $timeNow = time();
            if($cowItem->time_finish > time())
            {
                $count = ((int)$cowItem->count_milk ) / 2;
                $diff = $cowItem->time_finish-$timeNow;
                return ['status'=>false, 'timer'=>$diff, 'count'=> $count . '/30'];
            }
            else
            {
                $cowItem->status_id = CowItems::STATUS_MILK;
                $cowItem->save();
                return ['status'=>true, 'class'=>''];
            }
        }
        else
        {
            throw new NotFoundHttpException;
        }
    }

    public function actionGoatCheck()
    {
        if(Yii::$app->user->isGuest)
        {
            throw new NotFoundHttpException;
        }
        $paddockId = Yii::$app->request->post('bull_id');
        $position = Yii::$app->request->post('position');
        Yii::$app->response->format = 'json';
        if(!empty($paddockId) && !empty($position))
        {
            $goatItem = GoatItems::findOne(['paddock_id'=>$paddockId,'position'=>$position]);
            $timeNow = time();
            if($goatItem->time_finish > time())
            {
                $count = ((int)$goatItem->count_milk) / 2;
                $diff = $goatItem->time_finish-$timeNow;
                return ['status'=>false, 'timer'=>$diff, 'count'=> $count . '/30'];
            }
            else
            {
                $goatItem->status_id = GoatItems::STATUS_MILK;
                $goatItem->save();
                return ['status'=>true, 'class'=>''];
            }
        }
        else
        {
            throw new NotFoundHttpException;
        }
    }
}
