<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "animal_pens".
 *
 * @property integer $animal_pens_id
 * @property string $name
 * @property string $alias
 * @property string $img
 * @property string $price_to_buy
 * @property integer $level
 * @property integer $energy
 * @property integer $experience
 */
class AnimalPens extends \yii\db\ActiveRecord
{
    public $count;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'animal_pens';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['price_to_buy'], 'number'],
            [['level', 'energy', 'experience'], 'integer'],
            [['name', 'alias'], 'string', 'max' => 255],
            [['img'], 'file']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'animal_pens_id' => 'ID',
            'name' => 'Название',
            'alias' => 'Alias',
            'img' => 'Img',
            'price_to_buy' => Yii::t('app', 'Цена покупки'),
            'level' => Yii::t('app', 'Уровень доступности'),
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
