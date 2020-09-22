<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "bonus".
 *
 * @property integer $id
 * @property string $username
 * @property string $price
 * @property string $date
 */
class Bonus extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'bonus';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['price'], 'number'],
            [['date'], 'safe'],
            [['username'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'price' => 'Price',
            'date' => 'Date',
        ];
    }
}
