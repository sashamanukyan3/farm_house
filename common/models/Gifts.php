<?php

namespace common\models;

use vova07\fileapi\behaviors\UploadBehavior;
use Yii;
use yii\web\UploadedFile;

/**
 * This is the model class for table "gifts".
 *
 * @property integer $id
 * @property string $photo
 */
class Gifts extends \yii\db\ActiveRecord
{

    public $image;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'gifts';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['photo'], 'string']
        ];
    }

    public function behaviors()
    {
        return [
            'uploadBehavior' => [
                'class' => UploadBehavior::className(),
                'attributes' => [
                    'photo' => [
                        'path' => '@frontend/web/img/gifts/',
                        'tempPath' => '@frontend/web/img/gifts/',
                        'url' => '@frontend/web/img/gifts/'
                    ],
                ]
            ],
        ];

    }


    public function getImage()
    {
        $image =  ($this->photo) ? $this->photo : 'profile.jpg';
        return Yii::getAlias('@frontendWebroot/img/gifts').'/'.$image;
    }

    public function getImagePath()
    {
        $image =  ($this->photo) ? $this->photo : 'profile.jpg';
        return '@frontend/web/img/gifts'.$image;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'image' => 'Image',
            'price' => Yii::t('app', 'Цена'),
        ];
    }

}
