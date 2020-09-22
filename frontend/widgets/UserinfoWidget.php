<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 17.02.2016
 * Time: 16:20
 */
namespace frontend\widgets;

use yii\base\Widget;
use common\models\User;
use Yii;

class UserinfoWidget extends Widget{

    public function run(){
        $user = User::find()
            ->where(['id'=>Yii::$app->user->id])
            ->one();
        return $this->render('wuserinfo', compact('user'));
    }
}