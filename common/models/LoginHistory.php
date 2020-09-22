<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "login_history".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $login_ip
 * @property integer $login_date
 * @property string $browser
 */
class LoginHistory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'login_history';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'login_date'], 'integer'],
            [['browser'], 'string'],
            [['login_ip'], 'string', 'max' => 20]
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
            'login_ip' => 'Login Ip',
            'login_date' => 'Login Date',
            'browser' => 'Browser',
        ];
    }
}
