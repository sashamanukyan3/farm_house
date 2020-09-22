<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "plant".
 *
 * @property integer $plant_id
 * @property string $name
 * @property string $img1
 * @property string $img2
 * @property string $img3
 * @property string $img4
 * @property integer $level
 * @property string $price
 * @property integer $weight
 * @property integer $energy
 * @property integer $experience
 */
class Plant extends \yii\db\ActiveRecord
{
    public $count;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'plant';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            //[['name', 'energy','experience','level'], 'required', 'message'=>'{attribute} не может быть пустым'],
            [['level', 'weight', 'energy', 'experience'], 'integer'],
            [['price_to_buy', 'price_for_sell'], 'number'],
            [['name','second_name', 'alias'], 'string', 'max' => 255],
            [['img1', 'img2', 'img3', 'img4'],'file']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'plant_id' => 'Plant ID',
            'name' => Yii::t('app', 'Название'),
            'second_name' => Yii::t('app', 'Название'),
            'img1' => 'Img1',
            'img2' => 'Img2',
            'img3' => 'Img3',
            'img4' => 'Img4',
            'level' => Yii::t('app', 'Уровень доступности'),
            'price_to_buy' => Yii::t('app', 'Цена покупки'),
            'price_for_sell' => Yii::t('app', 'Цена продажи'),
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
            $this->second_name = Yii::t('app', $this->second_name);
        }
    }
}
