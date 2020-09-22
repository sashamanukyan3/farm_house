<?php
namespace frontend\controllers;

use common\models\Friends;
use common\models\Mails;
use common\models\Message;
use common\models\Reviews;
use common\models\Settings;
use common\models\User;
use vova07\imperavi\actions\GetAction;
use Yii;
use yii\base\InvalidParamException;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;

/**
 * Site controller
 */
class MailsController extends Controller
{

    public function actionSend(){

        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $user = User::findOne(['id' => Yii::$app->user->id]);
        if($user->banned)
        {
            return $this->redirect(['site/banned']);
        }
        Settings::setLocation('Внутренняя почта');

        Yii::$app->db->createCommand()->update('user', ['last_visited' => time()], ['id' => \Yii::$app->user->identity->id])->execute();

        $reviews = Reviews::find()->where(['is_active' => 1])->limit(2)->orderBy(["id" => SORT_DESC])->all();

        $model = new Mails();

        $inTotalCount = Mails::find()->where(['to' => Yii::$app->user->identity->username])->count();
        $inViewedCount = Mails::find()->where(['to' => Yii::$app->user->identity->username, 'status' => 0])->count();

        $outTotalCount = Mails::find()->where(['from' => Yii::$app->user->identity->username])->count();
        $outViewedCount = Mails::find()->where(['from' => Yii::$app->user->identity->username, 'status' => 0])->count();

        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();
            if(!empty($data))
            {
                Yii::$app->response->format = 'json';

                $subject    = $data['subject'];
                $to         = $data['to'];
                $message    = $data['message'];
                $from       = $data['from'];

                $mails = new Mails();

                $mails->subject = $subject;
                $mails->to = $to;
                $mails->message = $message;
                $mails->from = $from;

                $dateControl = Mails::find()->where(['from' => $from])->orderBy(['mail_id' => SORT_DESC])->limit(1)->one();
                if($dateControl){
                    // 2016-02-10 12:37:22
                    $dateTime = Yii::$app->formatter->asTimestamp($dateControl->date);

                    //2016-02-10 12:39:22
                    $dateTime1 = Yii::$app->formatter->asTimestamp(date("Y-m-d H:i:s"));
                }else{
                    $dateTime = 1;
                    $dateTime1 = 150;
                }

                $userControl = User::find()->where(['username' => $to])->one();
                if($userControl){
                    $energyControl = User::find()->where(['username' => $from])->one();
                    if($energyControl->energy > 9){
                        if(($dateTime1-$dateTime) < 120){
                            return array('status' => false, 'msg'=>Yii::t('app', 'Новое сообщение можно отправить только через 2 минуты') . '!');
                        }else {
                            $mails->save();
                            $energyControl->updateCounters(['energy' => -10]);
                            return array('status' => true, 'msg'=>Yii::t('app', 'Письмо отправлено') . '!');
                        }
                    }else{
                        return array('status' => false, 'msg'=>Yii::t('app', 'Недостаточно энергии') . '!');
                    }
                }else{
                    return array('status' => false, 'msg'=>Yii::t('app', 'Такого пользователя не существует') . '!');
                }

            }
        }

        return $this->render('send', [
                'user' => $user,
                'model' => $model,
                'reviews' => $reviews,
                'inTotalCount' => $inTotalCount,
                'inViewedCount' => $inViewedCount,
                'outTotalCount' => $outTotalCount,
                'outViewedCount' => $outViewedCount,
            ]
        );

    }

    public function actionOut(){

        if (\Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $user = User::findOne(['id' => Yii::$app->user->id]);
        if($user->banned)
        {
            return $this->redirect(['site/banned']);
        }
        Settings::setLocation('Внутренняя почта');

        Yii::$app->db->createCommand()->update('user', ['last_visited' => time()], ['id' => \Yii::$app->user->identity->id])->execute();

        $username = Yii::$app->user->identity->username;

        $mails = Mails::find()->where(['from' => $username])->orderBy(['mail_id' => SORT_DESC])->all();

        $inTotalCount = Mails::find()->where(['to' => Yii::$app->user->identity->username])->count();
        $inViewedCount = Mails::find()->where(['to' => Yii::$app->user->identity->username, 'status' => 0])->count();

        $outTotalCount = Mails::find()->where(['from' => Yii::$app->user->identity->username])->count();
        $outViewedCount = Mails::find()->where(['from' => Yii::$app->user->identity->username, 'status' => 0])->count();

        return $this->render('out', [
                'user' => $user,
                'mails' => $mails,
                'inTotalCount' => $inTotalCount,
                'inViewedCount' => $inViewedCount,
                'outTotalCount' => $outTotalCount,
                'outViewedCount' => $outViewedCount,
            ]
        );

    }

    public function actionOutview($id){

        if (\Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $user = User::findOne(['id' => Yii::$app->user->id]);
        if($user->banned)
        {
            return $this->redirect(['site/banned']);
        }

        $id = (int)$id;
        if(!$id || $id==0)
        {
            throw new NotFoundHttpException;
        }

        Settings::setLocation('Внутренняя почта');

        Yii::$app->db->createCommand()->update('user', ['last_visited' => time()], ['id' => \Yii::$app->user->identity->id])->execute();

        $username = Yii::$app->user->identity->username;

        $mails = Mails::find()->where(['from' => $username, 'mail_id' => $id])->all();

        $inTotalCount = Mails::find()->where(['to' => Yii::$app->user->identity->username])->count();
        $inViewedCount = Mails::find()->where(['to' => Yii::$app->user->identity->username, 'status' => 0])->count();

        $outTotalCount = Mails::find()->where(['from' => Yii::$app->user->identity->username])->count();
        $outViewedCount = Mails::find()->where(['from' => Yii::$app->user->identity->username, 'status' => 0])->count();

        return $this->render('outview', [
                'user' => $user,
                'mails' => $mails,
                'inTotalCount' => $inTotalCount,
                'inViewedCount' => $inViewedCount,
                'outTotalCount' => $outTotalCount,
                'outViewedCount' => $outViewedCount,
            ]
        );

    }

    public function actionOutdelete($id){

        if (\Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $user = User::findOne(['id'=>Yii::$app->user->id]);
        if($user->banned)
        {
            return $this->redirect(['site/banned']);
        }

        $id = (int)$id;
        if(!$id || $id==0)
        {
            throw new NotFoundHttpException;
        }

        $username = Yii::$app->user->identity->username;

        $mails = Mails::find()->where(['mail_id' => $id, 'from' => $username])->all();

        if($mails){

            Yii::$app->db->createCommand()->delete('mails', ['mail_id' => $id])->execute();

            return $this->redirect('/mails/out');

        }else{
            echo 'Ошибка...';
        }

    }

    public function actionIn(){

        if (\Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $user = User::findOne(['id' => Yii::$app->user->id]);
        if($user->banned)
        {
            return $this->redirect(['site/banned']);
        }
        Settings::setLocation('Внутренняя почта');

        Yii::$app->db->createCommand()->update('user', ['last_visited' => time()], ['id' => \Yii::$app->user->identity->id])->execute();

        $username = Yii::$app->user->identity->username;

        $mails = Mails::find()->where(['to' => $username])->orderBy(['mail_id' => SORT_DESC])->all();

        $inTotalCount = Mails::find()->where(['to' => Yii::$app->user->identity->username])->count();
        $inViewedCount = Mails::find()->where(['to' => Yii::$app->user->identity->username, 'status' => 0])->count();

        $outTotalCount = Mails::find()->where(['from' => Yii::$app->user->identity->username])->count();
        $outViewedCount = Mails::find()->where(['from' => Yii::$app->user->identity->username, 'status' => 0])->count();

        return $this->render('in', [
                'user' => $user,
                'mails' => $mails,
                'inTotalCount' => $inTotalCount,
                'inViewedCount' => $inViewedCount,
                'outTotalCount' => $outTotalCount,
                'outViewedCount' => $outViewedCount,
            ]
        );

    }

    public function actionInview($id){

        if (\Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $user = User::findOne(['id' => Yii::$app->user->id]);
        if($user->banned)
        {
            return $this->redirect(['site/banned']);
        }

        $id = (int)$id;
        if(!$id || $id==0)
        {
            throw new NotFoundHttpException;
        }

        Settings::setLocation('Внутренняя почта');

        Yii::$app->db->createCommand()->update('user', ['last_visited' => time()], ['id' => \Yii::$app->user->identity->id])->execute();

        $model = new Mails();

        $username = Yii::$app->user->identity->username;

        $mails = Mails::find()->where(['to' => $username, 'mail_id' => $id])->all();

        $inTotalCount = Mails::find()->where(['to' => Yii::$app->user->identity->username])->count();
        $inViewedCount = Mails::find()->where(['to' => Yii::$app->user->identity->username, 'status' => 0])->count();

        $outTotalCount = Mails::find()->where(['from' => Yii::$app->user->identity->username])->count();
        $outViewedCount = Mails::find()->where(['from' => Yii::$app->user->identity->username, 'status' => 0])->count();

        Yii::$app->db->createCommand()->update('mails', ['status' => 1], ['mail_id' => $id])->execute();

        return $this->render('inview', [
                'user' => $user,
                'mails' => $mails,
                'model' => $model,
                'inTotalCount' => $inTotalCount,
                'inViewedCount' => $inViewedCount,
                'outTotalCount' => $outTotalCount,
                'outViewedCount' => $outViewedCount,
            ]
        );

    }

    public function actionIndelete($id){

        if (\Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $user = User::findOne(['id' => Yii::$app->user->id]);
        if($user->banned)
        {
            return $this->redirect(['site/banned']);
        }

        $id = (int)$id;
        if(!$id || $id==0)
        {
            throw new NotFoundHttpException;
        }

        $username = Yii::$app->user->identity->username;

        $mails = Mails::find()->where(['mail_id' => $id, 'to' => $username])->all();

        if($mails){

            Yii::$app->db->createCommand()->delete('mails', ['mail_id' => $id])->execute();

            return $this->redirect('/mails/in');

        }else{
            echo 'Ошибка...';
        }

    }

    public function actionReply(){

        if (\Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $energyControl = User::find()->where(['username' => Yii::$app->user->identity->username])->one();
        if($energyControl->banned)
        {
            return $this->redirect(['site/banned']);
        }
        Settings::setLocation('Внутренняя почта');

        Yii::$app->db->createCommand()->update('user', ['last_visited' => time()], ['id' => \Yii::$app->user->identity->id])->execute();

        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();
            if(!empty($data))
            {
                Yii::$app->response->format = 'json';

                $subject    = $data['subject'];
                $to         = $data['to'];
                $message    = $data['message'];
                $from       = $data['from'];

                $mails = new Mails();

                $mails->subject = 'RE: '.$subject;
                $mails->to = $to;
                $mails->message = $message;
                $mails->from = $from;

                $userControl = User::find()->where(['username' => $to])->one();
                if($userControl){
                    if($energyControl->energy > 9){
                        $mails->save();
                        $energyControl->updateCounters(['energy' => -10]);
                        return array('status' => true, 'msg'=>Yii::t('app', 'Письмо отправлено') . '!');
                    }else{
                        return array('status' => false, 'msg'=>Yii::t('app', 'Недостаточно энергии') . '!');
                    }
                }else{
                    return array('status' => false, 'msg'=>Yii::t('app', 'Такого пользователя не существует') . '!');
                }
            }
        }

    }
}
