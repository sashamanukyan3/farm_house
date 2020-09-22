<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "main_objects".
 *
 * @property integer $id
 * @property string $name
 * @property string $img1
 * @property string $img2
 * @property string $img3
 * @property integer $need_lvl
 * @property string $price
 * @property integer $weight
 * @property integer $is_active
 */
class MainObject extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'main_objects';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['need_lvl', 'weight', 'is_active'], 'integer'],
            [['price'], 'number'],
            [['name', 'img1', 'img2', 'img3'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'img1' => 'Img1',
            'img2' => 'Img2',
            'img3' => 'Img3',
            'need_lvl' => 'Need Lvl',
            'price' => 'Price',
            'weight' => 'Weight',
            'is_active' => 'Is Active',
        ];
    }
}
