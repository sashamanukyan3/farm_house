<?php
namespace frontend\controllers;

use common\models\Message;
use common\models\Reviews;
use common\models\Settings;
use common\models\Support;
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
class SupportController extends Controller
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
        Settings::setLocation('Тех. Поддержка');

        Yii::$app->db->createCommand()->update('user', ['last_visited' => time()], ['id' => \Yii::$app->user->identity->id])->execute();

        $model = new Support();

        $inTotalCount = Support::find()->where(['to' => Yii::$app->user->identity->id])->count();

        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();
            if(!empty($data))
            {
                Yii::$app->response->format = 'json';

                $subject    = $data['subject'];
                $message    = $data['message'];
                $from       = Yii::$app->user->identity->id;

                $support = new Support();

                $support->subject = $subject;
                $support->to = 1;
                $support->message = $message;
                $support->from = $from;
                $support->date = time();
                $support->status = Support::STATUS_OPEN;
                $support->user_viewed = Support::STATUS_USER_UNVIEWED;

                $support->save();
                return array('status' => true, 'msg'=>Yii::t('app', 'Ваш тикет отправлен'));

            }
        }

        return $this->render('send', [
                'user' => $user,
                'model' => $model,
                'inTotalCount' => $inTotalCount,
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
        Settings::setLocation('Тех. Поддержка');

        Yii::$app->db->createCommand()->update('user', ['last_visited' => time()], ['id' => \Yii::$app->user->identity->id])->execute();


        $id = Yii::$app->user->identity->id;

        $support = Support::find()->where(['from' => $id, 'reply' => 0])->orderBy(['id' => SORT_DESC])->all();

        return $this->render('out', [
                'user' => $user,
                'support' => $support,
            ]
        );

    }

    public function actionView($id){

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

        Settings::setLocation('Тех. Поддержка');

        Yii::$app->db->createCommand()->update('user', ['last_visited' => time()], ['id' => \Yii::$app->user->identity->id])->execute();

        Yii::$app->db->createCommand()->update('support', ['user_viewed' => Support::STATUS_USER_VIEWED], ['reply' => $id])->execute();
        Yii::$app->db->createCommand()->update('support', ['user_viewed' => Support::STATUS_USER_VIEWED], ['id' => $id])->execute();

        $userId = Yii::$app->user->identity->id;

        $support = Support::find()->where(['from' => $userId, 'id' => $id, 'reply' => 0])->all();
        if($support){

            $model = new Support();

            $supportReplyList = Support::find()->where(['reply' => $id])->all();

            if(Yii::$app->request->post()){
                $support[0]->status = Support::STATUS_OPEN;
                $support[0]->save();
                $data = Yii::$app->request->post();

                $model->reply = $id;
                $model->message = $data["message"];
                $model->to = 1;
                $model->from = $userId;
                $model->date = time();
                $model->status = Support::STATUS_OPEN;

                $model->save();
                if($model->save()){
                    return $this->redirect('/support/view?id='.$id);
                }

            }

        }else{
            return $this->redirect('/support/out/');
        }

        return $this->render('view', [
                'user' => $user,
                'model' => $model,
                'support' => $support,
                'supportReplyList' => $supportReplyList,
            ]
        );

    }

    public function actionClosed(){

        if (\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        if (Yii::$app->request->isAjax) {
            $user = User::findOne(['id' => Yii::$app->user->id]);
            if($user->banned)
            {
                return $this->redirect(['site/banned']);
            }
            $data = Yii::$app->request->post();

            Yii::$app->response->format = 'json';

            $sup_id = $data["sup_id"];

            Yii::$app->db->createCommand()->update('support', ['status' => Support::STATUS_CLOSED], ['id' => $sup_id])->execute();

            return array('supClosed' => true);

        }

    }

    public function actionOpen(){

        if (\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        if (Yii::$app->request->isAjax) {
            $user = User::findOne(['id' => Yii::$app->user->id]);
            if($user->banned)
            {
                return $this->redirect(['site/banned']);
            }
            $data = Yii::$app->request->post();

            Yii::$app->response->format = 'json';

            $sup_id = $data["sup_id"];

            Yii::$app->db->createCommand()->update('support', ['status' => Support::STATUS_OPEN], ['id' => $sup_id])->execute();

            return array('supOpen' => true);

        }

    }
}
