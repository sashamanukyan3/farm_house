<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "factories".
 *
 * @property integer $factory_id
 * @property string $name
 * @property string $alias
 * @property string $img
 * @property string $price_to_buy
 * @property integer $level
 * @property integer $energy
 * @property integer $experience
 */
class Factories extends \yii\db\ActiveRecord
{
    public $count;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'factories';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['price_to_buy'], 'number'],
            [['level', 'energy', 'experience'], 'integer'],
            [['name', 'alias', 'img'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'factory_id' => 'ID',
            'name' => Yii::t('app', 'Фабрика'),
            'alias' => 'Alias',
            'img' => 'Img',
            'price_to_buy' => Yii::t('app', 'Цена покупки'),
            'level' => Yii::t('app', 'Уровень доступности'),
            'energy' => Yii::t('app', 'Энергия'),
            'experience' => Yii::t('app', 'Опыт запуска и сбора'),
        ];
    }

    public function afterFind()
    {
        parent::afterFind();

        if (Yii::$app->id == 'app-frontend') {
            $this->name = Yii::t('app', $this->name);
        }
    }
}
