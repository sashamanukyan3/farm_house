<?php

namespace common\models;

use Yii;
use vova07\fileapi\behaviors\UploadBehavior;

/**
 * This is the model class for table "charity".
 *
 * @property integer $id
 * @property string $name
 * @property string $age
 * @property string $address
 * @property string $text
 * @property string $need
 * @property string $content
 * @property string $img
 * @property string $summ
 */
class Charity extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'charity';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['text', 'content'], 'string'],
            [['summ'], 'number'],
            [['name', 'age', 'address', 'need', 'img'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => Yii::t('app', 'Имя'),
            'age' => Yii::t('app', 'Возраст'),
            'address' => Yii::t('app', 'Адрес'),
            'text' => Yii::t('app', 'Текст'),
            'need' => Yii::t('app', 'Нужная сумма'),
            'content' => Yii::t('app', 'Контент'),
            'img' => 'Img',
            'summ' => Yii::t('app', 'Сумма'),
        ];
    }

    public function behaviors()
    {
        return [
            'uploadBehavior' => [
                'class' => UploadBehavior::className(),
                'attributes' => [
                    'img' => [
                        'path' => '@frontend/web/charity/',
                        'tempPath' => '@frontend/web/charity/',
                        'url' => '@frontend/web/img/charity/'
                    ],
                ]
            ],
        ];

    }

    public function getImage()
    {
        $image =  ($this->img) ? $this->img : 'profile.jpg';
        return Yii::getAlias('@frontendWebroot/charity').'/'.$image;
    }

    public function getImagePath()
    {
        $image =  ($this->img) ? $this->img : 'profile.jpg';
        return '@frontend/web/charity'.$image;
    }

    public function getUser(){
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
