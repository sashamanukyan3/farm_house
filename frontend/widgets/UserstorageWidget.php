<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 16.01.2016
 * Time: 15:31
 */
namespace frontend\widgets;

use common\models\AnimalPens;
use common\models\Animals;
use common\models\Bakeries;
use common\models\FabricProductType;
use common\models\Factories;
use common\models\Plant;
use common\models\ProductForBakery;
use common\models\ShopBakery;
use yii\base\Widget;
use common\models\AnimalFood;
use common\models\UserStorage;
use Yii;

class UserstorageWidget extends Widget{

    public $results = [];

    public function run(){
        $results['plant'] = AnimalFood::find()
            ->innerJoinWith('plant', 'animal_food.plant_id = plant.plant_id')
            ->all();
        $results['plant2'] = Plant::find()->limit(4)
            ->all();
        $results['animals'] = Animals::find()
            ->select(['name', 'img2', 'alias'])
            ->all();
        $results['animal_pens'] = AnimalPens::find()
            ->select(['name', 'img', 'alias'])
            ->all();
        $results['factories'] = Factories::find()
            ->select(['name', 'img', 'alias'])
            ->all();
        $results['bakeries'] = Bakeries::find()
            ->select(['name', 'img', 'alias'])
            ->all();
        $results['for_processing'][] = FabricProductType::find()
            ->select(['id', 'name', 'img', 'alias', 'model_name', 'price_for_sell', 'min_count_for_sell'])
            ->all();
        $results['for_sale'][] = FabricProductType::find()
            ->select(['id', 'name', 'img', 'alias2', 'model_name', 'price_for_sell', 'min_count_for_sell'])
            ->all();
        $results['for_processing'][] = ProductForBakery::find()
            ->select(['id', 'name', 'img', 'alias', 'model_name', 'price_for_sell', 'min_count_for_sell'])
            ->all();
        $results['for_sale'][] = ProductForBakery::find()
            ->select(['id', 'name', 'img', 'alias2', 'model_name', 'price_for_sell', 'min_count_for_sell'])
            ->all();
        $results['for_eat'] = ShopBakery::find()
            ->select(['id', 'name', 'img', 'alias', 'model_name', 'price_for_sell', 'min_count_for_sell'])
            ->all();
        $results['for_sale'][] = ShopBakery::find()
            ->select(['id', 'name', 'img', 'alias2', 'model_name', 'price_for_sell', 'min_count_for_sell'])
            ->all();

        $userStorage = UserStorage::find()
            ->where(['user_id' => Yii::$app->user->id])
            ->asArray()
            ->all();

        foreach($results['plant'] as $k=>$plant)
        {
            foreach($userStorage as $skey=>$storage)
            {
               $results['plant'][$k]->count = $storage[$plant->alias];
               unset($userStorage[$skey][$plant->alias]);
            }
        }
        foreach($results['plant2'] as $k=>$plant)
        {
            foreach($userStorage as $skey=>$storage)
            {
               $results['plant2'][$k]->count = $storage[$plant->alias];
               unset($userStorage[$skey][$plant->alias]);
            }
        }
        foreach($results['animals'] as $k=>$animal)
        {
            foreach($userStorage as $skey=>$storage)
            {
               $results['animals'][$k]->count = $storage[$animal->alias];
               unset($userStorage[$skey][$animal->alias]);
            }
        }
        foreach($results['animal_pens'] as $k=>$animal)
        {
            foreach($userStorage as $skey=>$storage)
            {
               $results['animal_pens'][$k]->count = $storage[$animal->alias];
               unset($userStorage[$skey][$animal->alias]);
            }
        }
        foreach($results['factories'] as $k=>$animal)
        {
            foreach($userStorage as $skey=>$storage)
            {
               $results['factories'][$k]->count = $storage[$animal->alias];
               unset($userStorage[$skey][$animal->alias]);
            }
        }
        foreach($results['bakeries'] as $k=>$animal)
        {
            foreach($userStorage as $skey=>$storage)
            {
               $results['bakeries'][$k]->count = $storage[$animal->alias];
               unset($userStorage[$skey][$animal->alias]);
            }
        }
        foreach($results['for_sale'] as $k=>$products) {
            foreach ($products as $p_k => $product)
            {
                foreach($userStorage as $skey=>$storage)
                {
                    $results['for_sale'][$k][$p_k]->count = $storage[$product->alias2];
                    unset($userStorage[$skey][$product->alias2]);
                }
            }
        }

        foreach($results['for_processing'] as $k=>$products) {
            foreach ($products as $p_k => $product)
            {
                //echo '<pre>'; var_dump($product->alias); die();
                foreach($userStorage as $skey=>$storage)
                {
                    $results['for_processing'][$k][$p_k]->count = $storage[$product->alias];
                    unset($userStorage[$skey][$product->alias]);
                }
            }
        }

        foreach($results['for_eat'] as $k=>$products) {
            foreach($userStorage as $skey=>$storage)
            {
                $results['for_eat'][$k]->count = $storage[$products->alias];
                unset($userStorage[$skey][$products->alias]);
            }
        }

        return $this->render('wuserstorage', compact('results'));
    }
}