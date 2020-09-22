<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "friend_gifts".
 *
 * @property integer $id
 * @property string $to
 * @property string $from
 * @property integer $gifts_id
 * @property string $comment
 */
class FriendGifts extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'friend_gifts';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['gifts_id'], 'integer'],
            [['comment'], 'string'],
            [['to', 'from'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'to' => 'To',
            'from' => 'From',
            'gifts_id' => 'Gifts ID',
            'comment' => 'Comment',
        ];
    }

    public function getGifts(){
        return $this->hasOne(Gifts::className(), ['id' => 'gifts_id']);
    }

}
