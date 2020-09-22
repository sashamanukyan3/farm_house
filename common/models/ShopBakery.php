<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "shop_bakery".
 *
 * @property integer $id
 * @property string $name
 * @property string $alias
 * @property string $alias2
 * @property string $img
 * @property string $price_for_sell
 * @property string $price_to_buy
 * @property integer $level
 * @property integer $min_count_for_sell
 * @property string $model_name
 * @property integer $energy
 * @property integer $experience
 * @property integer $energy_in_food
 */
class ShopBakery extends \yii\db\ActiveRecord
{
    public $count;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'shop_bakery';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['price_for_sell', 'price_to_buy'], 'number'],
            [['level', 'min_count_for_sell', 'energy', 'experience', 'energy_in_food'], 'integer'],
            [['name', 'alias', 'alias2', 'img', 'model_name'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => Yii::t('app', 'Название'),
            'alias' => 'Alias',
            'alias2' => 'Alias2',
            'img' => Yii::t('app', 'Изображение'),
            'price_for_sell' => Yii::t('app', 'Цена продажи'),
            'price_to_buy' => Yii::t('app', 'Цена покупки'),
            'level' => 'Level',
            'min_count_for_sell' => Yii::t('app', 'Минимальное кол-во продажи'),
            'model_name' => Yii::t('app', 'Имя модели'),
            'energy' => 'Energy',
            'experience' => 'Experience',
            'energy_in_food' => Yii::t('app', 'Энергия за употребление'),
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
