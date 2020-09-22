<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "land_items".
 *
 * @property integer $land_item_id
 * @property integer $user_id
 * @property integer $position_number
 * @property string $plant_alias
 * @property integer $status_id
 * @property integer $is_fertilized
 * @property integer $level
 * @property string $time_start
 * @property string $time_finish
 */
class LandItem extends \yii\db\ActiveRecord
{
    const STATUS_NOT_AVAILABLE = 0;
    const STATUS_AVAILABLE = 1;
    const STATUS_READY_FOR_SOW = 3;
    const STATUS_SOW = 4;
    const STATUS_PRODUCT_READY = 5;
    const FERTILIZED = 1;
    const NOT_FERTILIZED = 0;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'land_items';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'position_number', 'status_id', 'is_fertilized', 'level'], 'integer'],
            [['time_start', 'time_finish'], 'safe'],
            [['plant_alias'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'land_item_id' => 'Land Item ID',
            'user_id' => 'User ID',
            'position_number' => 'Position Number',
            'plant_alias' => 'Plant Alias',
            'status_id' => 'Status ID',
            'is_fertilized' => 'Is Fertilized',
            'level' => 'Level',
            'time_start' => 'Time Start',
            'time_finish' => 'Time Finish',
        ];
    }
}
