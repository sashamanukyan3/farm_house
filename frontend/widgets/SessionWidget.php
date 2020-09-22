<?php

    namespace frontend\widgets;

    use common\models\Session;
    use yii\base\Widget;
    use yii\helpers\Html;
    use common\models\Reviews;
    use Yii;

    class SessionWidget extends Widget
    {
        public $location = '';
        public function init()
        {

            if(Yii::$app->user->isGuest){

                $sessionControl = Session::find()->where(['session_id' => Yii::$app->getSession()->getId()])->all();
                if($sessionControl){
                    Yii::$app->db->createCommand()->update('session', ['time' => time(), 'location' => 'Главная страница'], ['session_id' => Yii::$app->getSession()->getId()])->execute();
                }else{
                    Yii::$app->db->createCommand()->insert('session', ['time' => time(), 'location' => 'Главная страница', 'session_id' => Yii::$app->getSession()->getId()])->execute();
                }

            }else{

                $sessionControl = Session::find()->where(['username' => Yii::$app->user->identity->username])->all();
                if($sessionControl){
                    Yii::$app->db->createCommand()->update('session', ['time' => time(), 'session_id' => Yii::$app->getSession()->getId(), 'location' => 'Главная страница'], ['username' => Yii::$app->user->identity->username])->execute();
                }else{
                    Yii::$app->db->createCommand()->insert('session', ['time' => time(), 'location' => 'Главная страница', 'session_id' => Yii::$app->getSession()->getId(), 'username' => Yii::$app->user->identity->username])->execute();
                }

            }

        }

    }


?>