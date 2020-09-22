<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "farm_storage".
 *
 * @property integer $storage_id
 * @property integer $feed_chickens
 * @property integer $feed_bulls
 * @property integer $feed_goats
 * @property integer $feed_cows
 * @property integer $egg
 * @property integer $meat
 * @property integer $goat_milk
 * @property integer $cow_milk
 * @property integer $dough
 * @property integer $mince
 * @property integer $cheese
 * @property integer $curd
 * @property string $money_storage
 * @property string $money_for_out
 */
class FarmStorage extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'farm_storage';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['feed_chickens', 'feed_bulls', 'feed_goats', 'feed_cows', 'egg', 'meat', 'goat_milk', 'cow_milk', 'dough', 'mince', 'cheese', 'curd'], 'integer'],
            [['money_storage', 'money_for_out'], 'number']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'storage_id' => 'Storage ID',
            'feed_chickens' => 'Feed Chickens',
            'feed_bulls' => 'Feed Bulls',
            'feed_goats' => 'Feed Goats',
            'feed_cows' => 'Feed Cows',
            'egg' => 'Egg',
            'meat' => 'Meat',
            'goat_milk' => 'Goat Milk',
            'cow_milk' => 'Cow Milk',
            'dough' => 'Dough',
            'mince' => 'Mince',
            'cheese' => 'Cheese',
            'curd' => 'Curd',
            'money_storage' => 'Money Storage',
            'money_for_out' => 'Money For Out',
        ];
    }
}
