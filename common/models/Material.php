<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "materials".
 *
 * @property integer $id
 * @property string $title
 * @property string $content
 * @property integer $is_enabled
 */
class Material extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'materials';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['is_enabled'], 'integer'],
            [['content'], 'string'],
            [['title'], 'string', 'max' => 255]
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
            'content' => 'Content',
            'is_enabled' => 'Is Enabled',
        ];
    }
}
