<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 29.02.2016
 * Time: 18:16
 */

namespace frontend\models;
use Yii;
use yii\base\Model;

class PayOutForm extends Model
{
    public $sum;
    public $pay_type;
    public $purse;
    public $pay_pass;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sum'],'number'],
            [['sum', 'pay_type'], 'required'],
            [['pay_type', 'purse'],'string'],
            [['pay_pass'], 'integer'],
            [['pay_type', 'purse'], 'filter', 'filter' => function($value) {
                return trim(htmlentities(strip_tags($value), ENT_QUOTES, 'UTF-8'));
            }],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'sum' => Yii::t('app', 'Сумма для вывода'),
            'pay_type' => Yii::t('app', 'Тип кошелька'),
            'purse' => Yii::t('app', 'Кошелек'),
            'pay_pass' => Yii::t('app', 'Платежный пароль'),
        ];
    }
}