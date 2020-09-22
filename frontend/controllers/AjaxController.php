<?php
namespace frontend\controllers;

use common\models\User;
use frontend\models\ChangePasswordForm;
use frontend\models\Profile;
use vova07\imperavi\actions\GetAction;
use Yii;
use yii\base\InvalidParamException;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * Ajax controller
 */
class AjaxController extends Controller
{

    public function actionProfile(){

        if (\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();
            if(!empty($data))
            {
                Yii::$app->response->format = 'json';

                $mailing    = $data['mailing'];
                $sex        = $data['sex'];
                $userId     = $data['userId'];

                $userControl = User::find()->where(['id' => $userId])->one();
                if($userControl->banned)
                {
                    return $this->redirect(['site/banned']);
                }
                if($userControl){
                    Yii::$app->db->createCommand()->update('user', ['sex' => $sex, 'is_subscribed' => $mailing], ['id' => $userId])->execute();
                    return array('status' => true, 'msg'=>Yii::t('app', 'Данные успешно изменены') . '!');
                }else{
                    return array('status' => false, 'msg'=>'Fatal Error');
                }
                }else{
                    return array('status' => false, 'msg'=>Yii::t('app', 'Такого пользователя не существует') . '!');
                }
            }
        }

    public function actionPassword(){

        if (\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        if(Yii::$app->request->isAjax && Yii::$app->request->post()) {
            Yii::$app->response->format = 'json';
            $oldPassword = Yii::$app->request->post('oldPassword');
            $password = Yii::$app->request->post("password");
            $repeatPassword = Yii::$app->request->post("repeatPassword");
            if(!empty($oldPassword) && !empty($password) && !empty($repeatPassword))
            {
                $passwordModel = new ChangePasswordForm();
                $passwordModel->oldPassword = $oldPassword;
                $passwordModel->password = $password;
                $passwordModel->repeatPassword = $repeatPassword;
                if($passwordModel->validate())
                {
                    $user = User::findOne(['id' => Yii::$app->user->id]);
                    if($user->banned)
                    {
                        return $this->redirect(['site/banned']);
                    }
                    if($user->validatePassword($oldPassword))
                    {
                        $user->setPassword($password);
                        $user->generateAuthKey();
                        $user->save();
                        return array('status' => true, 'msg'=>Yii::t('app', 'Ваш пароль успешно изменен'));
                    }
                    else
                    {
                        return array('status' => false, 'msg'=>Yii::t('app', 'Текущий пароль неверен'));
                    }
                }
                else
                {
                    $msg = Yii::t('app', 'Ошибка на стороне сервера') . '!';
                    //Получаем первую ошибку
                    foreach($passwordModel->getErrors() as $errors)
                    {
                        $msg = $errors[0];
                        break;
                    }
                    return array('status' => false, 'msg'=>$msg);
                }
            }
            else
            {
                return array('status' => false, 'msg'=>Yii::t('app', 'Все поля должны быть заполнены') . '!');
            }
        }

    }

    public function actionPaypass(){

        if (\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        if(Yii::$app->request->isAjax) {

            Yii::$app->response->format = 'json';
            $userId = Yii::$app->user->identity->id;
            $userEmail = User::find()->select(['username', 'email','banned'])->where(['id' => $userId])->one();
            if($userEmail->banned)
            {
                return $this->redirect(['site/banned']);
            }
            //echo '<pre>'; var_dump($userEmail->email); die();
            $newPayPass = rand(1000,9999);
            $updatePayPass = Yii::$app->db->createCommand()
                ->update('user', ['pay_pass' => $newPayPass, 'pay_pass_date'=>time()], ['id' => $userId])
                ->execute();
            if($updatePayPass) {
                $this->sendEmail($userEmail->username, $userEmail->email, $newPayPass);
                return array('status' => true, 'msg' => Yii::t('app', 'Новый платёжный пароль отправлен на почту'));
            }else{
                return array('status' => false, 'msg' => Yii::t('app', 'Ошибка ошибки'));
            }
        }
        else
        {

        }

    }

    public function sendEmail($userName, $userEmail, $newPayPass)
    {
       if(!empty($userName) && !empty($userEmail) && !empty($newPayPass)){
           $textBody = Yii::t('app', 'Здравствуйте, {username}! Ваш новый платежный пароль: {password}', [
               'username' => $userName,
               'password' => $newPayPass,
           ]);
           return Yii::$app->mailer->compose()
               ->setFrom(['support@ferma.ru' => Yii::$app->name . ' robot'])
               ->setTo($userEmail)
               ->setSubject(Yii::t('app', 'Сброс платежного пароля на сайте Ферма') . '!')
               ->setTextBody($textBody)
               ->send();
        }
        return false;
    }
}
