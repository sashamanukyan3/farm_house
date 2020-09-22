<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "users_news".
 *
 * @property integer $id
 * @property integer $news_id
 * @property integer $user_id
 */
class UsersNews extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'users_news';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['news_id', 'user_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'news_id' => 'News ID',
            'user_id' => 'User ID',
        ];
    }
}
