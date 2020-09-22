<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 29.01.2016
 * Time: 12:00
 */

namespace frontend\controllers;
use common\models\FarmStorage;
use common\models\Land;
use common\models\LandItem;
use common\models\Statistics;
use common\models\User;
use common\models\UserStorage;
use common\models\Plant;
use Yii;
use yii\web\NotFoundHttpException;

class LandController extends \yii\web\Controller
{

    protected function addLand($min_lvl, $min_lvl_count)
    {
        $min_lvl = (int)$min_lvl;
        $min_lvl_count = (int)$min_lvl_count;
        $count_min_lvl = 4 - $min_lvl_count;
        //1) add min_level by min_lvl_count
        if($count_min_lvl < 0)
        {
            $count_min_lvl = 0;
        }
        for ($i = 1; $i <= $count_min_lvl; $i++) {
            $newItems[$i]['user_id'] = Yii::$app->user->id;
            $newItems[$i]['level'] = $min_lvl;
            $newItems[$i]['position_number'] = $i;
            $newItems[$i]['status_id'] = LandItem::STATUS_AVAILABLE;
            $newItems[$i]['is_fertilized'] = 0;
        }

        //2) find Next level, next level must be 4
        $next_lvl = $min_lvl + 1;
        $next_lvl_count = 9 - $count_min_lvl;

        for ($k = 1; $k <= $next_lvl_count; $k++) {
            $j = $count_min_lvl + $k;
            $newItems[$j]['user_id'] = Yii::$app->user->id;
            if ($k <= 4) {
                $newItems[$j]['level'] = $next_lvl;
            } elseif ($k > 4 && $k < 9) {
                $newItems[$j]['level'] = $next_lvl + 1;
            } elseif ($k == 9) {
                $newItems[$j]['level'] = $next_lvl + 2;
            }
            $newItems[$j]['position_number'] = $j;
            $newItems[$j]['status_id'] = LandItem::STATUS_NOT_AVAILABLE;
            $newItems[$j]['is_fertilized'] = 0;

        }
        return Yii::$app->db->createCommand()->batchInsert('land_items',
            ['user_id', 'level', 'position_number', 'status_id', 'is_fertilized'],
            $newItems
        )->execute();
    }

    //посадка семян
    public function actionLandSow()
    {
        //сажаем семя
        if (Yii::$app->user->isGuest) {
            throw new NotFoundHttpException;
        }
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = 'json';

            $landId = Yii::$app->request->post('land_id');
            $alias = Yii::$app->request->post('alias');
            $isFertilized = Yii::$app->request->post('is_fertilized');
            $plantId = Yii::$app->request->post('plant_id');
            if (!empty($landId) && !empty($alias) && !empty($plantId)) {
                $land = Plant::findOne(['plant_id' => 5]);
                $user = User::findOne(['id' => Yii::$app->user->id]);

                //za posev luibyh semyan minus -2, za udobrenie -1
                $landItem = LandItem::findOne(['land_item_id' => $landId,'status_id'=>LandItem::STATUS_READY_FOR_SOW,'user_id'=>Yii::$app->user->id]);
                if ($landItem) {
                    $minus_energy = $land->energy;

                    $timeStart = time();
                    $timeFinish = $this->getFinishTime($alias, $isFertilized);
                    if ($isFertilized) {
                        $minus_energy += 1;
                    }

                    if ($user->energy < $minus_energy) {
                        return ['status' => false, 'msg' => Yii::t('app', 'Недостаточно энергии') . '!'];
                    }

                    $plant = Plant::findOne(['plant_id' => $plantId]);
                    //проверка уровни доступа
                    if ($plant->level > $user->level) {
                        return ['status' => false, 'msg' => Yii::t('app', 'Нежен {level} уровень', [
                            'level' => $plant->level,
                        ])];
                    }

                    $userStorage = UserStorage::find()->select($alias)->where(['user_id' => $user->id])->asArray()->one();
                    //проверка склада
                    if ($userStorage[$alias] <= 0) {
                        return ['status' => false, 'msg' => Yii::t('app', 'У Вас недостаточное количество семян') . '!'];
                    }
                    $userStorage[$alias] -= 1;
                    Yii::$app->db->createCommand()
                        ->update('user_storage', [$alias => $userStorage[$alias]], 'user_id = :user_id', ['user_id' => $user->id])
                        ->execute();
                    $landItem->time_start = $timeStart;
                    $landItem->time_finish = $timeFinish;
                    $landItem->user_id = $user->id;
                    $landItem->is_fertilized = ($isFertilized) ? 1 : 0;
                    $landItem->status_id = LandItem::STATUS_SOW;
                    $landItem->plant_alias = $alias;
                    $landItem->save();
                    $user->energy -= $minus_energy;
                    $user->save();
                    return ['status' => true, 'landId' => $landId, 'energy' => $user->energy, 'msg' => Yii::t('app', 'Семена посажены успешно') . '!'];
                } else {
                    return ['status' => false, 'msg' => Yii::t('app', 'Ошибка. Попробуйте обновить страницу') . '!'];
                }
            } else {
                return ['status' => false, 'msg' => Yii::t('app', 'Ошибка при покупке. Попробуйте обновить страницу') . '!'];
            }
        } else {
            throw new NotFoundHttpException;
        }
    }

    //покупка земли
    public function actionLandBuy()
    {
        //покупка поля
        if (Yii::$app->user->isGuest) {
            throw new NotFoundHttpException;
        }
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = 'json';
            //$type 1-посев, 2-покупка
            $landId = Yii::$app->request->post('land_id');
            //для новых 9
            $isNew = boolval(Yii::$app->request->post('is_new'));
            $lvlCount = Yii::$app->request->post('lvl_count');
            $maxLvl = Yii::$app->request->post('max_lvl');

            if (!empty($landId) && !empty($lvlCount) && !empty($maxLvl)) {
                $land = Plant::findOne(['plant_id' => 5]);
                $user = User::findOne(['id' => Yii::$app->user->id]);
                //проверяем деньги
                if ($user->for_pay < $land->price_to_buy) {
                    return ['status' => false, 'msg' => Yii::t('app', 'Недостаточно денег для покупки') . '!'];
                }

                $landItem = LandItem::findOne(['land_item_id' => $landId,'user_id'=>Yii::$app->user->id, 'status_id'=>[LandItem::STATUS_AVAILABLE,LandItem::STATUS_NOT_AVAILABLE]]);
                if ($landItem) {
                    if($landItem->level > $user->level)
                    {
                        return ['status' => false, 'msg' => Yii::t('app', 'Недостаточный уровень для покупки') . '!'];
                    }
                    $landItem->status_id = LandItem::STATUS_READY_FOR_SOW;
                    if ($landItem->save()) {
                        if ($isNew) {
                            $this->addLand($maxLvl, $lvlCount);
                        }
                        $user->for_pay -= $land->price_to_buy;
                        $user->save();
                        //статистика покупки
                        $statistic = Statistics::find()->one();
                        $arrayValue = $statistic->all_bought_lands;
                        $buy = explode(':', $arrayValue);
                        $buy[0]+=1; $buy[1]+=$land->price_to_buy;
                        $setValue = implode(':', $buy);
                        $statistic->all_bought_lands = $setValue;
                        $statistic->save();
                        $farmStorage = FarmStorage::findOne(['storage_id'=>1]);
                        $farmStorage->money_storage += $land->price_to_buy;
                        $farmStorage->save();
                        return ['status' => true, 'msg' => Yii::t('app', 'Поле куплено успешно') . '!', 'for_pay' => $user->for_pay];
                    }
                } else {
                    return ['status' => false, 'msg' => Yii::t('app', 'Поле уже куплено. Обновите страницу') . '!'];
                }
            }
        } else {
            throw new NotFoundHttpException;
        }
    }

    //проверка урожая
    public function actionHarvest()
    {
        if (Yii::$app->user->isGuest) {
            throw new NotFoundHttpException;
        }
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = 'json';

            $landItemId = Yii::$app->request->post('land_id');
            if ($landItemId) {
                $landItem = LandItem::findOne(['land_item_id' => $landItemId,'user_id'=>Yii::$app->user->id,'status_id'=>LandItem::STATUS_SOW]);
                if (!$landItem) {
                    return ['status' => false, 'msg' => Yii::t('app', 'Кажется, урожай либо не готов, либо уже собран. Обновите страницу') . '!'];
                }
                $timeNow = time();
                $timeFinish = (int)$landItem->time_finish;
                if ($timeNow < $timeFinish) {
                    $diff = $timeFinish - $timeNow;
                    return ['status' => false, 'timer' => $diff];
                } else {
                    $landItem->status_id = LandItem::STATUS_PRODUCT_READY;
                    $landItem->save();
                    if(!$landItem->plant_alias)
                    {
                        return ['status'=>false, 'msg' => Yii::t('app', 'Что-то пошло не так') . '!'];
                    }
                    return ['status' => true, 'alias' => $landItem->plant_alias, 'msg' => Yii::t('app', 'Поле готово к сборке') . '!'];
                }
            } else {
                return ['status' => false, 'msg' => Yii::t('app', 'Данные не дошли до сервера') . '!'];
            }
        } else {
            throw new NotFoundHttpException;
        }
    }

    //сборка
    public function actionCollection()
    {
        if (Yii::$app->user->isGuest) {
            throw new NotFoundHttpException;
        }
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = 'json';
            $landItemId = Yii::$app->request->post('land_id');
            $alias = Yii::$app->request->post('alias');
            if (!empty($landItemId) && !empty($alias)) {
                $user = User::findOne(['id' => Yii::$app->user->id]);
                $land = LandItem::findOne(['land_item_id' => $landItemId,'user_id'=>Yii::$app->user->id,'status_id'=>LandItem::STATUS_PRODUCT_READY]);
                if($land)
                {
                    $land->status_id = LandItem::STATUS_READY_FOR_SOW;
                    $land->time_start = 0;
                    $land->time_finish = 0;
                    $land->is_fertilized = 0;
                    $land->plant_alias = null;

                    if (!$land->save()) {
                        return ['status' => false, 'msg'=>Yii::t('app', 'Ошибка при сохранении поля') . '!'];
                    }

                    $userStorage = UserStorage::find()->where(['user_id' => $user->id])->asArray()->one();
                    $feed_alias = $this->getStorageAlias($alias);

                    $userStorage[$feed_alias] += 1;
                    Yii::$app->db->createCommand()
                        ->update('user_storage', [$feed_alias => $userStorage[$feed_alias]], 'user_id = :user_id', ['user_id' => $user->id])
                        ->execute();

                    return ['status' => true, 'msg' => Yii::t('app', 'Урожай собран успешно') . '!'];
                }
                else
                {
                    return ['status' => false, 'msg' => Yii::t('app', 'Кажется, урожай либо не готов, либо уже собран. Обновите страницу') . '!'];
                }
            } else {
                return ['status' => false, 'msg' => Yii::t('app', 'Данные не дошли до сервера') . '!'];
            }
        } else {
            throw new NotFoundHttpException;
        }
    }

    public function actionFertilize()
    {
        if (Yii::$app->user->isGuest) {
            throw new NotFoundHttpException;
        }
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = 'json';
            $user = User::findOne(['id'=>Yii::$app->user->id]);
            if($user->energy < 1)
            {
                return ['status' => false, 'msg' => Yii::t('app', 'Недостаточно энергии') . '!'];
            }
            $landItemId = Yii::$app->request->post('land_id');
            if ($landItemId) {
                $landItem = LandItem::findOne(['land_item_id' => $landItemId]);
                if (!$landItem) {
                    return ['status' => false, 'msg' => Yii::t('app', 'Ячейка не найдена') . '!'];
                }
                if($landItem->is_fertilized == 1)
                {
                    return ['status' => false, 'msg' => Yii::t('app', 'Поле уже удобрено') . '!'];
                }
                $user->energy -= 1;
                $user->save();
                $timeNow = time();
                $timeFinish = (int)$landItem->time_finish;
                $halfDiff = ($timeFinish - $timeNow)/2;
                $landItem->is_fertilized = 1;
                $landItem->time_finish = $timeNow + $halfDiff;;
                $landItem->save();
                return ['status' => true, 'alias' => $landItem->plant_alias,'energy'=>$user->energy];
            } else {
                return ['status' => false, 'msg' => Yii::t('app', 'Ошибка на стороне сервера') . '!'];
            }
        } else {
            throw new NotFoundHttpException;
        }
    }

    //get finish time by alias
    protected function getFinishTime($alias, $isFertilized)
    {
        if (!$alias) {
            return false;
        }
        switch ($alias) {
            case 'wheat':
                if ($isFertilized) {
                    $timeFinish = strtotime("+15 min");
                } else {
                    $timeFinish = strtotime("+30 min");
                }
                break;
            case 'clover':
                if ($isFertilized) {
                    $timeFinish = strtotime("+23 min");
                } else {
                    $timeFinish = strtotime("+45 min");
                }
                break;
            case 'cabbage':
                if ($isFertilized) {
                    $timeFinish = strtotime("+30 min");
                } else {
                    $timeFinish = strtotime("+60 min");
                }
                break;
            case 'beets':
                if ($isFertilized) {
                    $timeFinish = strtotime("+68 min");
                } else {
                    $timeFinish = strtotime("+135 min");
                }
                break;
        }
        return $timeFinish;
    }

    protected function getStorageAlias($plant_alias)
    {
        switch ($plant_alias) {
            case 'wheat':
                $storageAlias = 'feed_chickens';
                break;
            case 'clover':
                $storageAlias = 'feed_bulls';
                break;
            case 'cabbage':
                $storageAlias = 'feed_goats';
                break;
            case 'beets':
                $storageAlias = 'feed_cows';
                break;
        }
        return $storageAlias;
    }

    public function actionCollectAll()
    {
        if (Yii::$app->user->isGuest) {
            throw new NotFoundHttpException;
        }
        $startTimer = microtime(true);
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = 'json';
            $models = LandItem::find()->where(['user_id' => Yii::$app->user->id])->andWhere(['status_id' => [LandItem::STATUS_PRODUCT_READY, LandItem::STATUS_SOW]])->all();

            $countProduct = count($models);
            if ($countProduct != 0) {

                $countFeedChickens = 0;
                $countFeedBulls = 0;
                $countGoats = 0;
                $countFeedCows = 0;

                foreach ($models as $i => $model) {
                    if (time() > $model->time_finish) {
                        if ($model->plant_alias == 'wheat') {
                            $countFeedChickens += 1;
                        } elseif ($model->plant_alias == 'clover') {
                            $countFeedBulls += 1;
                        } elseif ($model->plant_alias == 'cabbage') {
                            $countGoats += 1;
                        } elseif ($model->plant_alias == 'beets') {
                            $countFeedCows += 1;
                        }

                        $model->status_id = LandItem::STATUS_READY_FOR_SOW;
                        $model->time_start = 0;
                        $model->time_finish = 0;
                        $model->save();
                    }
                }

                $userId = Yii::$app->user->id;
                $userStorage = UserStorage::find()->where(['user_id' => $userId])->one();
                $userStorage->feed_chickens += $countFeedChickens;
                $userStorage->feed_bulls += $countFeedBulls;
                $userStorage->feed_goats += $countGoats;
                $userStorage->feed_cows += $countFeedCows;

                $userStorage->save();

                $endTimer = microtime(true);
                $diffTimer = (int)($endTimer - $startTimer);
                return ['status' => true, 'msg' => Yii::t('app', 'Вы собрали весь урожай') . '!', 'timer' => $diffTimer];
            } else {
                return ['status' => false, 'msg' => Yii::t('app', 'У вас нет урожая для сбора') . '!'];
            }
        } else {
            throw new NotFoundHttpException;
        }
    }

    public function actionFeedAll()
    {
        if (Yii::$app->user->isGuest) {
            throw new NotFoundHttpException;
        }
        $startTimer = microtime(true);
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = 'json';
            $landAlias = Yii::$app->request->post('plant_alias');
            $isFertilized = Yii::$app->request->post('is_fertilized');
            $energy = 2;
            if($isFertilized)
            {
                $energy += 1;
            }
            $models = LandItem::find()->where(['user_id' => Yii::$app->user->id])->andWhere(['status_id' => [LandItem::STATUS_READY_FOR_SOW]])->all();
            if($models)
            {
                $countModels = count($models);
                $allEnergy = $countModels * $energy;
                $user = User::findOne(['id'=>Yii::$app->user->id]);
                if($user->energy < $allEnergy)
                {
                    return ['status'=>false, 'msg'=>Yii::t('app', 'Недостаточно энергии') . '!'];
                }

                $userStorage = UserStorage::findOne(['user_id'=>Yii::$app->user->id]);
                if($userStorage->$landAlias < $countModels)
                {
                    return ['status'=>false, 'msg'=>Yii::t('app', 'У Вас недостаточное количество семян') . '!'];
                }

                $timeFinish = $this->getFinishTime($landAlias, $isFertilized);
                foreach($models as $i=>$model)
                {
                    $model->time_start = time();
                    $model->time_finish = $timeFinish;
                    $model->user_id = Yii::$app->user->id;
                    $model->is_fertilized = ($isFertilized) ? 1 : 0;
                    $model->status_id = LandItem::STATUS_SOW;
                    $model->plant_alias = $landAlias;
                    $model->save();
                }

                $userStorage->$landAlias -= $countModels;
                $userStorage->save();
                $user->energy -= $allEnergy;
                $user->save();
                $endTimer = microtime(true);
                $diffTimer = (int)($endTimer - $startTimer);
                return ['status' => true, 'msg' => Yii::t('app', 'Поля засеяны') . '!', 'timer' => $diffTimer];
            }
            else
            {
                return ['status'=>false, 'msg'=>Yii::t('app', 'Нет полей для посева') . '!'];
            }

        } else {
            throw new NotFoundHttpException;
        }
    }

    public function actionCollectSaw()
    {
        if (Yii::$app->user->isGuest) {
            throw new NotFoundHttpException;
        }
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = 'json';
            $landAlias = Yii::$app->request->post('plant_alias');
            $isFertilized = Yii::$app->request->post('is_fertilized');
            $landId = Yii::$app->request->post('land_id');
            if(!empty($landAlias) && !empty($landId))
            {
                $landItem = LandItem::find()->where(['land_item_id'=>$landId, 'user_id'=>Yii::$app->user->id, 'status_id'=>LandItem::STATUS_PRODUCT_READY])->one();
                if($landItem)
                {
                    $landItem->status_id = LandItem::STATUS_READY_FOR_SOW;
                    $landItem->time_start = 0;
                    $landItem->time_finish = 0;
                    $landItem->is_fertilized = 0;
                    $landItem->plant_alias = null;

                    if (!$landItem->save()) {
                        return ['status' => false, 'msg'=>Yii::t('app', 'Ошибка при сохранении поля') . '!'];
                    }
                    $userStorage = UserStorage::find()->where(['user_id' => Yii::$app->user->id])->asArray()->one();
                    $feed_alias = $this->getStorageAlias($landAlias);

                    $userStorage[$feed_alias] += 1;
                    Yii::$app->db->createCommand()
                        ->update('user_storage', [$feed_alias => $userStorage[$feed_alias]], 'user_id = :user_id', ['user_id' => Yii::$app->user->id])
                        ->execute();

                        // --- посев

                    $land = Plant::findOne(['plant_id' => 5]);
                    $user = User::findOne(['id' => Yii::$app->user->id]);

                    //za posev luibyh semyan minus -2, za udobrenie -1
                    $minus_energy = $land->energy;

                    $timeStart = time();
                    $timeFinish = $this->getFinishTime($landAlias, $isFertilized);
                    if ($isFertilized) {
                        $minus_energy += 1;
                    }

                    if ($user->energy < $minus_energy) {
                        return ['status' => false, 'msg' => Yii::t('app', 'Недостаточно энергии для посева') . '!','step'=>2];
                    }

                    $plant = Plant::findOne(['alias' => $landAlias]);
                    //проверка уровни доступа
                    if ($plant->level > $user->level) {
                        return ['status' => false, 'msg' => Yii::t('app', 'Нежен {level} уровень', ['level' => $plant->level]) . '!', 'step'=>2];
                    }

                    //$userStorage = UserStorage::find()->select($landAlias)->where(['user_id' => $user->id])->asArray()->one();
                    //проверка склада
                    if ($userStorage[$landAlias] <= 0) {
                        return ['status' => false, 'msg' => Yii::t('app', 'У Вас недостаточное количество семян') . '!','step'=>2];
                    }
                    $userStorage[$landAlias] -= 1;
                    Yii::$app->db->createCommand()
                        ->update('user_storage', [$landAlias => $userStorage[$landAlias]], 'user_id = :user_id', ['user_id' => $user->id])
                        ->execute();
                    $landItem->time_start = $timeStart;
                    $landItem->time_finish = $timeFinish;
                    $landItem->user_id = $user->id;
                    $landItem->is_fertilized = ($isFertilized) ? 1 : 0;
                    $landItem->status_id = LandItem::STATUS_SOW;
                    $landItem->plant_alias = $landAlias;
                    $landItem->save();
                    $user->energy -= $minus_energy;
                    $user->save();
                    return ['status' => true, 'landId' => $landId, 'energy' => $user->energy, 'msg' => Yii::t('app', 'Семена посажены успешно') . '!'];
                }
                else
                {
                    return ['status'=>false, 'msg'=>Yii::t('app', 'Такого поля не существует') . '!'];
                }
            }
            else
            {
                return ['status'=>false, 'msg'=>Yii::t('app', 'Данные не дошли до сервера') . '!'];
            }
        }
        else
        {
            throw new NotFoundHttpException;
        }
    }
}
