<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "pay_in".
 *
 * @property integer $id
 * @property string $username
 * @property integer $created
 * @property string $purse
 * @property string $amount
 * @property string $m_sign
 * @property integer $fraud_count
 * @property integer $complete
 */
class PayIn extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pay_in';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created', 'fraud_count', 'complete'], 'integer'],
            [['amount'], 'number'],
            [['username', 'purse', 'm_sign'], 'string', 'max' => 255]
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
            'created' => Yii::t('app', 'Дата'),
            'purse' => Yii::t('app', 'Система'),
            'amount' => Yii::t('app', 'Сумма'),
            'm_sign' => 'M Sign',
            'fraud_count' => 'Fraud Count',
            'complete' => Yii::t('app', 'Завершен'),
        ];
    }
}
