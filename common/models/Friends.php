<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "friends".
 *
 * @property integer $id
 * @property integer $to
 * @property integer $from
 * @property integer $status
 */
class Friends extends \yii\db\ActiveRecord
{

    public $username;
    public $first_name;
    public $last_name;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'friends';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['to', 'from', 'status'], 'required'],
            [['to', 'from', 'status'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'to' => 'To',
            'from' => 'From',
            'status' => 'Status',
        ];
    }

    public function getUser(){
        return $this->hasOne(User::className(), ['id' => 'from']);
    }

}
