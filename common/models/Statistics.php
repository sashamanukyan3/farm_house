<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "statistics".
 *
 * @property integer $id
 * @property string $today_bought_feed_chickens
 * @property string $today_sold_feed_chickens
 * @property string $all_bought_feed_chickens
 * @property string $all_sold_feed_chickens
 * @property string $today_bought_feed_bulls
 * @property string $today_sold_feed_bulls
 * @property string $all_bought_feed_bulls
 * @property string $all_sold_feed_bulls
 * @property string $today_bought_feed_goats
 * @property string $today_sold_feed_goats
 * @property string $all_bought_feed_goats
 * @property string $all_sold_feed_goats
 * @property string $today_bought_feed_cows
 * @property string $today_sold_feed_cows
 * @property string $all_bought_feed_cows
 * @property string $all_sold_feed_cows
 * @property string $today_bought_eggs
 * @property string $today_sold_eggs
 * @property string $all_bought_eggs
 * @property string $all_sold_eggs
 * @property string $today_bought_meat
 * @property string $today_sold_meat
 * @property string $all_bought_meat
 * @property string $all_sold_meat
 * @property string $today_bought_goat_milk
 * @property string $today_sold_goat_milk
 * @property string $all_bought_goat_milk
 * @property string $all_sold_goat_milk
 * @property string $today_bought_cow_milk
 * @property string $today_sold_cow_milk
 * @property string $all_bought_cow_milk
 * @property string $all_sold_cow_milk
 * @property string $today_bought_dough
 * @property string $today_sold_dough
 * @property string $all_bought_dough
 * @property string $all_sold_dough
 * @property string $today_bought_mince
 * @property string $today_sold_mince
 * @property string $all_bought_mince
 * @property string $all_sold_mince
 * @property string $today_bought_cheese
 * @property string $today_sold_cheese
 * @property string $all_bought_cheese
 * @property string $all_sold_cheese
 * @property string $today_bought_curd
 * @property string $today_sold_curd
 * @property string $all_bought_curd
 * @property string $all_sold_curd
 * @property string $today_bought_chickens
 * @property string $all_bought_chickens
 * @property string $today_bought_bulls
 * @property string $all_bought_bulls
 * @property string $today_bought_goats
 * @property string $all_bought_goats
 * @property string $today_bought_cows
 * @property string $all_bought_cows
 * @property string $today_bought_paddock_chickens
 * @property string $all_bought_paddock_chickens
 * @property string $today_bought_paddock_bulls
 * @property string $all_bought_paddock_bulls
 * @property string $today_bought_paddock_goats
 * @property string $all_bought_paddock_goats
 * @property string $today_bought_paddock_cows
 * @property string $all_bought_paddock_cows
 * @property string $today_bought_factory_dough
 * @property string $all_bought_factory_dough
 * @property string $today_bought_factory_mince
 * @property string $all_bought_factory_mince
 * @property string $today_bought_factory_cheese
 * @property string $all_bought_factory_cheese
 * @property string $today_bought_factory_curd
 * @property string $all_bought_factory_curd
 * @property string $today_bought_meat_bakery
 * @property string $all_bought_meat_bakery
 * @property string $today_bought_cheese_bakery
 * @property string $all_bought_cheese_bakery
 * @property string $today_bought_curd_bakery
 * @property string $all_bought_curd_bakery
 * @property string $all_bought_lands
 */
class Statistics extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'statistics';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['today_bought_feed_chickens', 'today_sold_feed_chickens', 'all_bought_feed_chickens', 'all_sold_feed_chickens', 'today_bought_feed_bulls', 'today_sold_feed_bulls', 'all_bought_feed_bulls', 'all_sold_feed_bulls', 'today_bought_feed_goats', 'today_sold_feed_goats', 'all_bought_feed_goats', 'all_sold_feed_goats', 'today_bought_feed_cows', 'today_sold_feed_cows', 'all_bought_feed_cows', 'all_sold_feed_cows', 'today_bought_eggs', 'today_sold_eggs', 'all_bought_eggs', 'all_sold_eggs', 'today_bought_meat', 'today_sold_meat', 'all_bought_meat', 'all_sold_meat', 'today_bought_goat_milk', 'today_sold_goat_milk', 'all_bought_goat_milk', 'all_sold_goat_milk', 'today_bought_cow_milk', 'today_sold_cow_milk', 'all_bought_cow_milk', 'all_sold_cow_milk', 'today_bought_dough', 'today_sold_dough', 'all_bought_dough', 'all_sold_dough', 'today_bought_mince', 'today_sold_mince', 'all_bought_mince', 'all_sold_mince', 'today_bought_cheese', 'today_sold_cheese', 'all_bought_cheese', 'all_sold_cheese', 'today_bought_curd', 'today_sold_curd', 'all_bought_curd', 'all_sold_curd', 'today_bought_chickens', 'all_bought_chickens', 'today_bought_bulls', 'all_bought_bulls', 'today_bought_goats', 'all_bought_goats', 'today_bought_cows', 'all_bought_cows', 'today_bought_paddock_chickens', 'all_bought_paddock_chickens', 'today_bought_paddock_bulls', 'all_bought_paddock_bulls', 'today_bought_paddock_goats', 'all_bought_paddock_goats', 'today_bought_paddock_cows', 'all_bought_paddock_cows', 'today_bought_factory_dough', 'all_bought_factory_dough', 'today_bought_factory_mince', 'all_bought_factory_mince', 'today_bought_factory_cheese', 'all_bought_factory_cheese', 'today_bought_factory_curd', 'all_bought_factory_curd', 'today_bought_meat_bakery', 'all_bought_meat_bakery', 'today_bought_cheese_bakery', 'all_bought_cheese_bakery', 'today_bought_curd_bakery', 'all_bought_curd_bakery', 'all_bought_lands'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'today_bought_feed_chickens' => 'Today Bought Feed Chickens',
            'today_sold_feed_chickens' => 'Today Sold Feed Chickens',
            'all_bought_feed_chickens' => 'All Bought Feed Chickens',
            'all_sold_feed_chickens' => 'All Sold Feed Chickens',
            'today_bought_feed_bulls' => 'Today Bought Feed Bulls',
            'today_sold_feed_bulls' => 'Today Sold Feed Bulls',
            'all_bought_feed_bulls' => 'All Bought Feed Bulls',
            'all_sold_feed_bulls' => 'All Sold Feed Bulls',
            'today_bought_feed_goats' => 'Today Bought Feed Goats',
            'today_sold_feed_goats' => 'Today Sold Feed Goats',
            'all_bought_feed_goats' => 'All Bought Feed Goats',
            'all_sold_feed_goats' => 'All Sold Feed Goats',
            'today_bought_feed_cows' => 'Today Bought Feed Cows',
            'today_sold_feed_cows' => 'Today Sold Feed Cows',
            'all_bought_feed_cows' => 'All Bought Feed Cows',
            'all_sold_feed_cows' => 'All Sold Feed Cows',
            'today_bought_eggs' => 'Today Bought Eggs',
            'today_sold_eggs' => 'Today Sold Eggs',
            'all_bought_eggs' => 'All Bought Eggs',
            'all_sold_eggs' => 'All Sold Eggs',
            'today_bought_meat' => 'Today Bought Meat',
            'today_sold_meat' => 'Today Sold Meat',
            'all_bought_meat' => 'All Bought Meat',
            'all_sold_meat' => 'All Sold Meat',
            'today_bought_goat_milk' => 'Today Bought Goat Milk',
            'today_sold_goat_milk' => 'Today Sold Goat Milk',
            'all_bought_goat_milk' => 'All Bought Goat Milk',
            'all_sold_goat_milk' => 'All Sold Goat Milk',
            'today_bought_cow_milk' => 'Today Bought Cow Milk',
            'today_sold_cow_milk' => 'Today Sold Cow Milk',
            'all_bought_cow_milk' => 'All Bought Cow Milk',
            'all_sold_cow_milk' => 'All Sold Cow Milk',
            'today_bought_dough' => 'Today Bought Dough',
            'today_sold_dough' => 'Today Sold Dough',
            'all_bought_dough' => 'All Bought Dough',
            'all_sold_dough' => 'All Sold Dough',
            'today_bought_mince' => 'Today Bought Mince',
            'today_sold_mince' => 'Today Sold Mince',
            'all_bought_mince' => 'All Bought Mince',
            'all_sold_mince' => 'All Sold Mince',
            'today_bought_cheese' => 'Today Bought Cheese',
            'today_sold_cheese' => 'Today Sold Cheese',
            'all_bought_cheese' => 'All Bought Cheese',
            'all_sold_cheese' => 'All Sold Cheese',
            'today_bought_curd' => 'Today Bought Curd',
            'today_sold_curd' => 'Today Sold Curd',
            'all_bought_curd' => 'All Bought Curd',
            'all_sold_curd' => 'All Sold Curd',
            'today_bought_chickens' => 'Today Bought Chickens',
            'all_bought_chickens' => 'All Bought Chickens',
            'today_bought_bulls' => 'Today Bought Bulls',
            'all_bought_bulls' => 'All Bought Bulls',
            'today_bought_goats' => 'Today Bought Goats',
            'all_bought_goats' => 'All Bought Goats',
            'today_bought_cows' => 'Today Bought Cows',
            'all_bought_cows' => 'All Bought Cows',
            'today_bought_paddock_chickens' => 'Today Bought Paddock Chickens',
            'all_bought_paddock_chickens' => 'All Bought Paddock Chickens',
            'today_bought_paddock_bulls' => 'Today Bought Paddock Bulls',
            'all_bought_paddock_bulls' => 'All Bought Paddock Bulls',
            'today_bought_paddock_goats' => 'Today Bought Paddock Goats',
            'all_bought_paddock_goats' => 'All Bought Paddock Goats',
            'today_bought_paddock_cows' => 'Today Bought Paddock Cows',
            'all_bought_paddock_cows' => 'All Bought Paddock Cows',
            'today_bought_factory_dough' => 'Today Bought Factory Dough',
            'all_bought_factory_dough' => 'All Bought Factory Dough',
            'today_bought_factory_mince' => 'Today Bought Factory Mince',
            'all_bought_factory_mince' => 'All Bought Factory Mince',
            'today_bought_factory_cheese' => 'Today Bought Factory Cheese',
            'all_bought_factory_cheese' => 'All Bought Factory Cheese',
            'today_bought_factory_curd' => 'Today Bought Factory Curd',
            'all_bought_factory_curd' => 'All Bought Factory Curd',
            'today_bought_meat_bakery' => 'Today Bought Meat Bakery',
            'all_bought_meat_bakery' => 'All Bought Meat Bakery',
            'today_bought_cheese_bakery' => 'Today Bought Cheese Bakery',
            'all_bought_cheese_bakery' => 'All Bought Cheese Bakery',
            'today_bought_curd_bakery' => 'Today Bought Curd Bakery',
            'all_bought_curd_bakery' => 'All Bought Curd Bakery',
            'all_bought_lands' => 'All Bought Lands',
        ];
    }
}
