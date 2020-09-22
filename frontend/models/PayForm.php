<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 29.02.2016
 * Time: 12:30
 */

namespace frontend\models;
use Yii;
use yii\base\Model;

class PayForm extends Model
{
    public $sum;
    public $pay_type;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sum'],'number'],
            [['pay_type'],'number'],
            [['sum', 'pay_type'], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'sum' => Yii::t('app', 'Сумма для перевода'),
            'pay_type' => Yii::t('app', 'Тип кошелька'),
        ];
    }
}