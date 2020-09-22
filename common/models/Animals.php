<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "animals".
 *
 * @property integer $animal_id
 * @property string $name
 * @property string $alias
 * @property string $img1
 * @property string $img2
 * @property string $img3
 * @property string $img4
 * @property integer $level
 * @property string $price_to_buy
 * @property integer $weight
 * @property integer $energy
 * @property integer $experience
 */
class Animals extends \yii\db\ActiveRecord
{
    public $count;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'animals';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['level', 'weight', 'energy', 'experience'], 'integer'],
            [['price_to_buy'], 'number'],
            [['name', 'alias', 'img1', 'img2', 'img3', 'img4'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'animal_id' => 'ID',
            'name' => 'Название',
            'alias' => 'Alias',
            'img1' => 'Img1',
            'img2' => 'Img2',
            'img3' => 'Img3',
            'img4' => 'Img4',
            'level' => Yii::t('app', 'Уровень доступности'),
            'price_to_buy' => Yii::t('app', 'Цена покупки'),
            'weight' => 'Weight',
            'energy' => Yii::t('app', 'Энергия'),
            'experience' => Yii::t('app', 'Опыт'),
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
