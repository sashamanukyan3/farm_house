<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "animal_food".
 *
 * @property integer $animal_food_id
 * @property integer $plant_id
 * @property string $alias
 * @property string $price_to_buy
 * @property integer $min_count
 * @property integer $energy
 * @property integer $experience
 */
class AnimalFood extends \yii\db\ActiveRecord
{
    public $count;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'animal_food';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['plant_id', 'min_count', 'energy', 'experience'], 'integer'],
            [['price_to_buy'], 'number'],
            [['alias'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'animal_food_id' => 'ID',
            'plant_id' => 'Plant ID',
            'alias' => 'Alias',
            'price_to_buy' => Yii::t('app', 'Цена покупки'),
            'min_count' => Yii::t('app', 'Минимальное количество покупки'),
            'energy' => Yii::t('app', 'Энергия'),
            'experience' => Yii::t('app', 'Опыт'),
        ];
    }

    public function getPlant()
    {
        return $this->hasOne(Plant::className(),['plant_id'=>'plant_id']);
    }
}
