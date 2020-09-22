<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "user_storage".
 *
 * @property integer $user_storage_id
 * @property integer $user_id
 * @property integer $wheat
 * @property integer $clover
 * @property integer $cabbage
 * @property integer $beets
 * @property integer $chicken
 * @property integer $bull
 * @property integer $goat
 * @property integer $cow
 * @property integer $egg
 * @property integer $meat
 * @property integer $goat_milk
 * @property integer $cow_milk
 * @property integer $dough
 * @property integer $mince
 * @property integer $cheese
 * @property integer $curd
 * @property integer $cakewithmeat
 * @property integer $cakewithcheese
 * @property integer $cakewithcurd
 * @property integer $feed_chickens
 * @property integer $feed_bulls
 * @property integer $feed_goats
 * @property integer $feed_cows
 */
class UserStorage extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_storage';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'wheat', 'clover', 'cabbage', 'beets', 'chicken', 'bull', 'goat', 'cow', 'egg', 'meat', 'goat_milk', 'cow_milk', 'dough', 'mince', 'cheese', 'curd', 'cakewithmeat', 'cakewithcheese', 'cakewithcurd', 'feed_chickens', 'feed_bulls', 'feed_goats', 'feed_cows'], 'integer'],
            [['feed_chickens', 'feed_bulls', 'feed_goats', 'feed_cows'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_storage_id' => 'User Storage ID',
            'user_id' => 'User ID',
            'wheat' => 'Wheat',
            'clover' => 'Clover',
            'cabbage' => 'Cabbage',
            'beets' => 'Beets',
            'chicken' => 'Chicken',
            'bull' => 'Bull',
            'goat' => 'Goat',
            'cow' => 'Cow',
            'egg' => 'Egg',
            'meat' => 'Meat',
            'goat_milk' => 'Goat Milk',
            'cow_milk' => 'Cow Milk',
            'dough' => 'Dough',
            'mince' => 'Mince',
            'cheese' => 'Cheese',
            'curd' => 'Curd',
            'cakewithmeat' => 'Cakewithmeat',
            'cakewithcheese' => 'Cakewithcheese',
            'cakewithcurd' => 'Cakewithcurd',
            'feed_chickens' => 'Feed Chickens',
            'feed_bulls' => 'Feed Bulls',
            'feed_goats' => 'Feed Goats',
            'feed_cows' => 'Feed Cows',
        ];
    }
}
