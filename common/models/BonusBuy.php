<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "bonus_buy".
 *
 * @property integer $id
 * @property string $username
 * @property string $date
 */
class BonusBuy extends \yii\db\ActiveRecord
{
    public $verifyCode;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'bonus_buy';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['date'], 'safe'],
            [['username'], 'string', 'max' => 255],
            ['verifyCode', 'captcha']
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
            'date' => 'Date',
        ];
    }
}
