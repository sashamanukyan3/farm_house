<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "news_like".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $news_id
 * @property integer $type
 * @property string $date
 */
class NewsLike extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'news_like';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'news_id', 'type'], 'integer'],
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
            'news_id' => 'News ID',
            'type' => 'Type',
            'date' => 'Date',
        ];
    }
}
