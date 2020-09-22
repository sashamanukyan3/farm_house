<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "faq".
 *
 * @property integer $id
 * @property string $title
 * @property string $content
 * @property string $title_en
 * @property string $content_en
 * @property integer $is_active
 */
class Faq extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'faq';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['content', 'content_en'], 'string'],
            [['is_active'], 'integer'],
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
            'title' => 'Название (ru)',
            'content' => 'Содержание (ru)',
            'title_en' => 'Название (en)',
            'content_en' => 'Содержание (en)',
            'is_active' => 'Показать',
        ];
    }
}
