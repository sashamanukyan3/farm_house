<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "news".
 *
 * @property integer $id
 * @property string $title
 * @property string $teaser
 * @property string $content
 * @property string $title_en
 * @property string $teaser_en
 * @property string $content_en
 * @property integer $weight
 * @property integer $is_active
 * @property integer $created_at
 */
class News extends \yii\db\ActiveRecord
{

    public $comments_count = 0;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'news';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['teaser', 'content', 'teaser_en', 'content_en'], 'string'],
            [['image'], 'file'],
            [['weight', 'is_active','created_at'], 'integer'],
            [['title', 'title_en'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'image' => 'Картинка',
            'title' => 'Название (ru)',
            'teaser' => 'Краткое описание (ru)',
            'content' => 'Контент (ru)',
            'title_en' => 'Название (en)',
            'teaser_en' => 'Краткое описание (en)',
            'content_en' => 'Контент (en)',
            'weight' => 'Weight',
            'is_active' => 'Is Active',
        ];
    }
}
