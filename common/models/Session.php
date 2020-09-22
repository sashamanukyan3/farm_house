<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "session".
 *
 * @property integer $id
 * @property string $session_id
 * @property string $username
 * @property string $location
 * @property string $time
 */
class Session extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'session';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['time'], 'safe'],
            [['session_id', 'username', 'location'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'session_id' => 'Session ID',
            'username' => 'Username',
            'location' => 'Location',
            'time' => 'Time',
        ];
    }

    public function getUser(){
        return $this->hasOne(User::className(), ['username' => 'username']);
    }

}
