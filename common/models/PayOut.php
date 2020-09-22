<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "pay_out".
 *
 * @property integer $id
 * @property integer $username
 * @property string $amount
 * @property string $pay_type
 * @property string $purse
 * @property integer $created_at
 * @property integer $status_id
 */
class PayOut extends \yii\db\ActiveRecord
{
    const STATUS_OPEN = 1;
    const STATUS_CONFIRMED = 2;
    const STATUS_CANCELED = 3;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pay_out';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_at', 'status_id'], 'integer'],
            [['amount'], 'number'],
            [['username', 'pay_type', 'purse'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => Yii::t('app', 'Логин'),
            'amount' => Yii::t('app', 'Сумма'),
            'pay_type' => Yii::t('app', 'Тип системы'),
            'purse' => Yii::t('app', 'Кошелек'),
            'created_at' => Yii::t('app', 'Дата'),
            'status_id' => Yii::t('app', 'Статус'),
        ];
    }
}
