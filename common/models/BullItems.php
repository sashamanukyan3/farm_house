<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "bull_items".
 *
 * @property integer $item_id
 * @property integer $paddock_id
 * @property integer $status_id
 * @property integer $user_id
 * @property integer $position
 * @property integer $time_start
 * @property integer $time_finish
 * @property integer $count_meat
 */
class BullItems extends \yii\db\ActiveRecord
{
    const STATUS_DEFAULT = 1;
    const STATUS_HUNGRY = 2;
    const STATUS_MEAT = 3;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'bull_items';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['paddock_id', 'status_id', 'user_id', 'position', 'time_start', 'time_finish', 'count_meat'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'item_id' => 'Item ID',
            'paddock_id' => 'Paddock ID',
            'status_id' => 'Status ID',
            'user_id' => 'User ID',
            'position' => 'Position',
            'time_start' => 'Time Start',
            'time_finish' => 'Time Finish',
            'count_meat' => 'Count Meat',
        ];
    }
}
