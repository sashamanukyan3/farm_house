<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "chat".
 *
 * @property integer $id
 * @property string $username
 * @property string $link
 * @property integer $user_id
 * @property integer $sex
 * @property integer $is_blocked
 * @property string $text
 * @property integer $created_at
 * @property string $date
 * @property string $lang
 */
class Chat extends \yii\db\ActiveRecord
{
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at'],
                ],
            ],
        ];
    }
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'chat';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'sex', 'is_blocked', 'created_at'], 'integer'],
            [['text'], 'string'],
            [['created_at'], 'required'],
            [['date'], 'safe'],
            [['username', 'link', 'lang'], 'string', 'max' => 255],
            [['text'], 'filter', 'filter' => function($value) {
                $value = trim($value);
                $strip_tags = ["<script>", "</script>"];
                return str_replace($strip_tags, "", $value);
            }],
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
            'link' => 'Link',
            'user_id' => 'User ID',
            'sex' => 'Sex',
            'is_blocked' => 'Is Blocked',
            'text' => 'Text',
            'created_at' => 'Created At',
            'date' => 'Date',
            'lang' => 'Lang',
        ];
    }

    public function getUser(){
        return $this->hasOne(User::className(), ['username' => 'username']);
    }
}
