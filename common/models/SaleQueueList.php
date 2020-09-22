<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "sale_queue_list".
 *
 * @property integer $queue_id
 * @property integer $user_id
 * @property integer $product_id
 * @property string $model_name
 * @property string $price
 * @property integer $count
 * @property integer $sell_time
 */
class SaleQueueList extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sale_queue_list';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'product_id', 'count', 'sell_time'], 'integer'],
            [['price'], 'number'],
//            [['sell_time'], 'required'],
            [['model_name'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'queue_id' => 'Queue ID',
            'user_id' => 'User ID',
            'product_id' => 'Product ID',
            'model_name' => 'Model Name',
            'price' => 'Price',
            'count' => 'Count',
            'sell_time' => 'Sell Time',
        ];
    }
    public function getShopBakery()
    {
        return $this->hasOne(ShopBakery::className(),['id'=>'product_id']);
    }
}
