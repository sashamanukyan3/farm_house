<?php

namespace common\models;

use vova07\fileapi\behaviors\UploadBehavior;
use Yii;
use yii\web\UploadedFile;

/**
 * This is the model class for table "attachments".
 *
 * @property integer $id
 * @property string $path
 * @property string $class_name
 * @property integer $object_id
 * @property string $name
 */
class Attachments extends \yii\db\ActiveRecord
{

    public $file;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'attachments';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['object_id'], 'integer'],
            [['path', 'class_name', 'name'], 'string', 'max' => 255],
            [['file'], 'file', 'maxFiles' => 10],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'path' => 'Path',
            'class_name' => 'Class Name',
            'object_id' => 'Object ID',
            'name' => 'Name',
        ];
    }

}
