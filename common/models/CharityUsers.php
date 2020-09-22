<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "charity_users".
 *
 * @property integer $id
 * @property integer $charity_id
 * @property integer $user_id
 * @property string $summ
 * @property string $date
 */
class CharityUsers extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'charity_users';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['charity_id', 'user_id'], 'integer'],
            [['summ'], 'number'],
            [['date'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'charity_id' => 'Charity ID',
            'user_id' => 'User ID',
            'summ' => 'Summ',
            'date' => 'Date',
        ];
    }

    public function getUser(){
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
