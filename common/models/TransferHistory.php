<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "transfer_history".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $amount
 * @property string $username
 * @property integer $created
 */
class TransferHistory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'transfer_history';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'created'], 'integer'],
            [['amount'], 'number'],
            [['username'], 'string', 'max' => 255]
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
            'amount' => Yii::t('app', 'Сумма'),
            'username' => Yii::t('app', 'Логин'),
            'created' => Yii::t('app', 'Дата'),
        ];
    }
}
