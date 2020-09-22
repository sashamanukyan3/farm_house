<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "cheese_bakery".
 *
 * @property integer $item_id
 * @property integer $user_id
 * @property integer $status_id
 * @property integer $level
 * @property integer $time_start
 * @property integer $time_finish
 * @property integer $count_product
 */
class CheeseBakery extends \yii\db\ActiveRecord
{
    const STATUS_NOT_AVAILABLE = 0;
    const STATUS_AVAILABLE = 1;
    const STATUS_READY= 2;
    const STATUS_RUN = 3; //запущен
    const STATUS_READY_PRODUCT = 4; //продукция готова
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cheese_bakery';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'status_id', 'level', 'time_start', 'time_finish', 'count_product'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'item_id' => 'Item ID',
            'user_id' => 'User ID',
            'status_id' => 'Status ID',
            'level' => 'Level',
            'time_start' => 'Time Start',
            'time_finish' => 'Time Finish',
            'count_product' => 'Count Product',
        ];
    }
}
