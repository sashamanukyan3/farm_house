<?php

namespace common\models;

use Faker\Provider\Image;
use vova07\fileapi\behaviors\UploadBehavior;
use Yii;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;

/**
 * This is the model class for table "wall_post".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $content
 * @property integer $like_count
 * @property integer $created_at
 * @property string $image
 * @property file $file
 */
class WallPost extends \yii\db\ActiveRecord
{
    /**
     * @var UploadedFile
     */
    public $file;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'wall_post';
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
            [['user_id', 'like_count', 'created_at'], 'integer'],
            [['content'], 'string'],
            [['user_wall_id'], 'integer'],
            [['created_at'], 'safe'],
            [['image'], 'string', 'max' => 255],
            [['file'], 'file', 'extensions' => ['gif', 'jpg', 'png', 'jpeg', 'JPG', 'JPEG', 'PNG', 'GIF'],
                'checkExtensionByMimeType'=>false,
                'maxSize' => 1024 * 1024 * 2],
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
            'content' => 'Text',
            'like_count' => 'Like Count',
            'created_at' => 'Created At',
            'image' => 'Image',
            'image_path' => 'Image Path',
            'file' => Yii::t('app', 'Прикрепить'),
        ];
    }

    public function getUser(){
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

}
