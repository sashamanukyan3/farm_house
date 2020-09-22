<?php

namespace common\models;

use Yii;
use common\models\User;

/**
 * This is the model class for table "reviews".
 *
 * @property integer $id
 * @property string $user_id
 * @property string $content
 * @property string $date
 * @property integer $is_active
 */
class Reviews extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'reviews';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['content'], 'string'],
            [['date'], 'safe'],
            [['is_active', 'user_id'], 'integer'],
            [['content'], 'filter', 'filter' => function($value) {
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
            'id' => 'ID',
            'user_id' => 'User ID',
            'content' => 'Content',
            'date' => 'Date',
            'is_active' => 'Is Active',
        ];
    }

    public function getUser(){
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

}
