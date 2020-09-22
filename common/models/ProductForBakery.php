<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "product_for_bakery".
 *
 * @property integer $id
 * @property string $name
 * @property string $alias
 * @property string $alias2
 * @property string $img
 * @property string $price_to_buy
 * @property string $price_for_sell
 * @property integer $min_count
 * @property integer $min_count_for_sell
 * @property string $model_name
 * @property integer $energy
 * @property integer $experience
 */
class ProductForBakery extends \yii\db\ActiveRecord
{
    public $count;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_for_bakery';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['price_to_buy', 'price_for_sell'], 'number'],
            [['min_count', 'min_count_for_sell', 'energy', 'experience'], 'integer'],
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
            'price_to_buy' => Yii::t('app', 'Цена покупки'),
            'price_for_sell' => Yii::t('app', 'Цена продажи'),
            'min_count' => Yii::t('app', 'Минимальное количество покупки'),
            'min_count_for_sell' => Yii::t('app', 'Минимальное количество продажи'),
            'model_name' => Yii::t('app', 'Имя модели'),
            'energy' => 'Energy',
            'experience' => 'Experience',
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
