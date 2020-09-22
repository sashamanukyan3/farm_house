<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "instructions".
 *
 * @property integer $id
 * @property string $title
 * @property string $content
 * @property string $content_en
 * @property integer $weight
 */
class Instruction extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'instructions';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'content'], 'required', 'message' => 'Madi'],
            [['content', 'content_en'], 'string'],
            [['weight'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['is_active'], 'boolean']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'content' => 'Контент (ru)',
            'content_en' => 'Контент (en)',
            'weight' => 'Weight',
            'is_active' => 'Active',
        ];
    }

    public function getImagePath()
    {
        $image =  ($this->photo) ? $this->photo : '';
        return '@frontend/web/images/'.$image;
    }
}
