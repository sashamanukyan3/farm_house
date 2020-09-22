<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "wall_comments".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $wall_id
 * @property integer $text
 * @property integer $created_at
 */
class WallComments extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'wall_comments';
    }

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
    public function rules()
    {
        return [
            [['created_at'], 'integer'],
            [['wall_id'], 'string'],
            [['text'], 'string'],
            [['text'], 'required']
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
            'wall_id' => 'Wall ID',
            'text' => 'Text',
            'created_at' => 'Created At',
        ];
    }

    public function getWall(){
        return $this->hasOne(WallPost::className(), ['id' => 'wall_id']);
    }

    public function getUser(){
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

}
