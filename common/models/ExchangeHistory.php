<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "exchange_history".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $amount
 * @property integer $created
 */
class ExchangeHistory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'exchange_history';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'created'], 'integer'],
            [['amount'], 'number']
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
            'amount' => 'Amount',
            'created' => 'Created',
        ];
    }
}
