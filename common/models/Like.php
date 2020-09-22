<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "like".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $wall_id
 * @property integer $created_at
 */
class Like extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'like';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'wall_id'], 'required'],
            [['user_id', 'wall_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'wall_id' => 'Wall ID',
            'created_at' => 'Created At',
        ];
    }
}
