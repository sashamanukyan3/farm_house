<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "purchase_history".
 *
 * @property integer $id
 * @property string $username
 * @property string $alias
 * @property string $count_price
 * @property integer $count_product
 * @property string $comment
 */
class PurchaseHistory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'purchase_history';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['count_price'], 'number'],
            [['count_product', 'time_buy'], 'integer'],
            [['username'], 'string', 'max' => 60],
            [['alias'], 'string', 'max' => 20],
            [['comment'], 'string', 'max' => 120]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'alias' => 'Alias',
            'count_price' => 'Count Price',
            'count_product' => 'Count Product',
            'comment' => 'Comment',
            'time_buy' => 'time_buy',
        ];
    }
}
