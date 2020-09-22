<?php

namespace common\models;

use Yii;
use vova07\fileapi\behaviors\UploadBehavior;

/**
 * This is the model class for table "banner".
 *
 * @property integer $id
 * @property string $link
 */
class Banner extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'banner';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['link'], 'string', 'max' => 255],
            [['img'], 'file']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'img' => Yii::t('app', 'Картинка'),
            'link' => Yii::t('app', 'Ссылка на баннер'),
        ];
    }
}
