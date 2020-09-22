<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "auth_users".
 *
 * @property integer $user_id
 * @property string $username
 * @property string $password
 */
class AuthUsers extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'auth_users';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'password'], 'required'],
            [['username', 'password'], 'string', 'max' => 60]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'username' => 'Login',
            'password' => 'Password',
        ];
    }
}
