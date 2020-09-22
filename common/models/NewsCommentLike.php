<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "news_comment_like".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $comment_id
 * @property integer $type
 * @property string $date
 */
class NewsCommentLike extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'news_comment_like';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'comment_id', 'type'], 'required'],
            [['user_id', 'comment_id', 'type'], 'integer'],
            [['date'], 'safe']
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
            'comment_id' => 'Comment ID',
            'type' => 'Type',
            'date' => 'Date',
        ];
    }
}
