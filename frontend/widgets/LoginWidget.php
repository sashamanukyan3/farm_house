<?php

namespace frontend\widgets;
use common\models\LoginForm;
use frontend\models\SignupForm;
use yii\base\Widget;
use Yii;
use common\models\User;

class LoginWidget extends Widget
{
    public function run(){
        $ref_id = (isset($_COOKIE['ref-id'])) ? $_COOKIE['ref-id'] : false;
        if(!$ref_id)
        {
            $ref_id = Yii::$app->request->get('ref-id');
        }
        if($ref_id)
        {
            $ref_id = (int)$ref_id;
            $ref_user = User::find()->select('id, username')->where(['id'=>$ref_id])->one();
        }
        $login_model = new LoginForm();
        $signup_model = new SignupForm();

        return $this->render('login',compact('login_model','signup_model','ref_user'));
    }
}