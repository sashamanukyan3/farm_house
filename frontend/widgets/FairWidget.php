<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 17.01.2016
 * Time: 12:05
 */
namespace frontend\widgets;

use common\models\FarmStorage;
use common\models\SaleQueueList;
use common\models\Statistics;
use Yii;
use common\models\AnimalFood;
use common\models\AnimalPens;
use common\models\Animals;
use common\models\Bakeries;
use common\models\FabricProductType;
use common\models\Factories;
use common\models\ProductForBakery;
use common\models\ShopBakery;
use common\models\UserStorage;
use yii\base\Widget;
use common\models\Plant;

class FairWidget extends Widget{

    public function run(){
        $plants = Plant::find()->limit(4)
            ->all();
        $animals = Animals::find()
            ->all();
        $animalfoods = AnimalFood::find()
            ->innerJoinWith('plant', 'animal_food.plant_id = plant.plant_id')
            ->all();
        $countProduct = FarmStorage::find()->all();
        $productTypes = FabricProductType::find()
            ->all();
        foreach($animalfoods as $k=>$product)
        {
            foreach($countProduct as $key=>$countPr)
            {
                $animalfoods[$k]->count = $countPr[$product->alias];
                unset($countProduct[$key][$product->alias]);
            }
        }
        foreach($productTypes as $k=>$product)
        {
            foreach($countProduct as $key=>$countPr)
            {
                $productTypes[$k]->count = $countPr[$product->alias];
                unset($countProduct[$key][$product->alias]);
            }
        }
        $productBakery = ProductForBakery::find()
            ->all();
        foreach($productBakery as $k=>$product)
        {
            foreach($countProduct as $key=>$countPr)
            {
                $productBakery[$k]->count = $countPr[$product->alias];
                unset($countProduct[$key][$product->alias]);
            }
        }
        $animalpens = AnimalPens::find()
            ->all();
        $factories = Factories::find()
            ->all();
        $bakeries = Bakeries::find()
            ->all();
        $bakeryproduct = ShopBakery::find()
            ->select(['id', 'name', 'img', 'alias', 'energy_in_food'])
            ->all();
        $userStorage = UserStorage::find()
            ->where(['user_id' => Yii::$app->user->id])
            ->asArray()
            ->all();
        foreach($bakeryproduct as $k=>$cake)
        {
            foreach($userStorage as $skey=>$storage)
            {
                $bakeryproduct[$k]->count = $storage[$cake->alias];
                unset($userStorage[$skey][$cake->alias]);
            }
        }

        return $this->render('wfair', compact('plants', 'animals', 'animalfoods', 'productTypes', 'productBakery', 'animalpens', 'factories', 'bakeries', 'bakeryproduct'));
    }
}