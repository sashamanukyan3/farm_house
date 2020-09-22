<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "exchange".
 *
 * @property integer $id
 * @property string $alias
 * @property integer $count
 * @property integer $energy
 * @property integer $experience
 * @property integer $is_active
 */
class Exchange extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'exchange';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['count', 'energy', 'experience', 'is_active'], 'integer'],
            [['alias'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'alias' => Yii::t('app', 'Продукция'),
            'count' => Yii::t('app', 'Количество'),
            'energy' => Yii::t('app', 'Снимется энергии'),
            'experience' => Yii::t('app', 'Получение опыта'),
            'is_active' => Yii::t('app', 'Биржа включена'),
        ];
    }
}
