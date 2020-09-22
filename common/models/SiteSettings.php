<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "site_settings".
 *
 * @property integer $id
 * @property string $name
 * @property string $email
 * @property string $min_paid
 * @property integer $ref_percent
 * @property string $start_project
 */
class SiteSettings extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */

    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => \yii\behaviors\TimestampBehavior::className(),
                'attributes' => [
                    \yii\db\ActiveRecord::EVENT_BEFORE_INSERT => ['start_project'],
                ],
                'value' => new \yii\db\Expression('NOW()'),
            ],
        ];
    }

    public static function tableName()
    {
        return 'site_settings';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['min_paid'], 'number'],
            [['ref_percent'], 'integer'],
            [['start_project'], 'safe'],
            [['name', 'email'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => Yii::t('app', 'Название сайта'),
            'email' => Yii::t('app', 'Email сайта'),
            'min_paid' => Yii::t('app', 'Минимум к выплате'),
            'ref_percent' => Yii::t('app', 'Реф. процент'),
            'start_project' => Yii::t('app', 'Старт проекта (UNIX дата)'),
        ];
    }
}
