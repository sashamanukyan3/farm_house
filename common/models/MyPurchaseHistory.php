<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "my_purchase_history".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $alias
 * @property string $count_price
 * @property integer $count_product
 * @property string $comment
 */
class MyPurchaseHistory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'my_purchase_history';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'count_product'], 'integer'],
            [['count_price'], 'number'],
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
            'user_id' => 'User ID',
            'alias' => 'Alias',
            'count_price' => 'Count Price',
            'count_product' => 'Count Product',
            'comment' => 'Comment',
        ];
    }
}
