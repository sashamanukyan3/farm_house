<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "mails".
 *
 * @property integer $mail_id
 * @property string $subject
 * @property integer $from
 * @property integer $to
 * @property string $message
 * @property string $date
 */
class Mails extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'mails';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['message','to','from'], 'string'],
            [['date'], 'safe'],
            [['subject'], 'string', 'max' => 255],
            [['subject', 'to', 'message'], 'required'],
            [['subject', 'to', 'message'], 'filter', 'filter' => function($value) {
                return trim(htmlentities(strip_tags($value), ENT_QUOTES, 'UTF-8'));
            }],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'mail_id' => 'Mail ID',
            'subject' => Yii::t('app', 'Тема'),
            'from' => 'From',
            'to' => Yii::t('app', 'Пользователь'),
            'message' => Yii::t('app', 'Текст сообщения'),
            'date' => 'Date',
        ];
    }
}
