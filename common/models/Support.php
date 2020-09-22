<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "support".
 *
 * @property integer $mail_id
 * @property string $subject
 * @property integer $from
 * @property integer $to
 * @property string $message
 * @property string $status
 * @property integer $reply
 */
class Support extends \yii\db\ActiveRecord
{
    const STATUS_OPEN = 1;
    const STATUS_CLOSED = 2;
    const STATUS_REPLY = 3;
    const STATUS_ADMIN_VIEWED = 4;
    const STATUS_USER_VIEWED = 1;
    const STATUS_USER_UNVIEWED = 0;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'support';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['message'], 'string'],
            [['to','from','reply'], 'integer'],
            [['status'], 'integer'],
            [['subject'], 'string'],
            [['to', 'message'], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'subject' => Yii::t('app', 'Тема'),
            'from' => Yii::t('app', 'Пользователь'),
            'to' => Yii::t('app', 'Пользователь'),
            'message' => Yii::t('app', 'Текст сообщения'),
            'date' => Yii::t('app', 'Дата'),
            'status'=> Yii::t('app', 'Статус'),
        ];
    }

    public function getUser(){
        return $this->hasOne(User::className(), ['id' => 'to']);
    }

    public function getUserreply(){
        return $this->hasOne(User::className(), ['id' => 'from']);
    }

}
