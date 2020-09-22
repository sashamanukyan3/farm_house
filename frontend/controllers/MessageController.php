<?php
namespace frontend\controllers;

use common\models\Friends;
use common\models\Message;
use common\models\FriendGifts;
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
class MessageController extends Controller
{

    public function actionIndex()
    {
        if (\Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $user = User::findOne(['id' => Yii::$app->user->id]);
        if($user->banned)
        {
            return $this->redirect(['site/banned']);
        }
        Settings::setLocation('Сообщения');

        Yii::$app->db->createCommand()->update('user', ['last_visited' => time()], ['id' => \Yii::$app->user->identity->id])->execute();

        $friends = Friends::find()->where(['friends.to' => Yii::$app->user->id, 'friends.status' => 1])->orWhere(['friends.from' => Yii::$app->user->id])->all();
        $ids = [];

        foreach($friends as $f)
                {
                    if($f['to'] == $user->id)
                       {
                            $ids[] = $f['from'];
                        }
            if($f['from'] == $user->id)
                       {
                           $ids[] = $f['to'];
                       }
        }

        $messageCount = Message::find()->where(['to_id' => Yii::$app->user->identity->id, 'viewed' => 0])->count();
        $giftCount = FriendGifts::find()->where(['to' => Yii::$app->user->identity->username])->count();

        $user_friends = [];
        $friend_count = 0;
        $requets_count = Friends::find()->where(['to' => Yii::$app->user->id, 'status' => 3])->count();
        if (!empty($ids)) {
            $user_friends = User::find()->where(['id' => $ids])->all();
            $friend_count = Friends::find()->where(['to' => Yii::$app->user->id, 'status' => 1])->orWhere(['from' => Yii::$app->user->id, 'status' => 1])->count();
        }
        return $this->render('index', [
                'user' => $user,
                'friends' => $user_friends,
                'friend_count' => $friend_count,
                'requets_count' => $requets_count,
                'giftCount' => $giftCount,
                'messageCount' => $messageCount
           ]
        );
    }

    public function actionIm($id = "")
    {
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

        Settings::setLocation('Сообщения');

        Yii::$app->db->createCommand()->update('user', ['last_visited' => time()], ['id' => \Yii::$app->user->identity->id])->execute();

        $online = Yii::$app->user->id;

        $imControl = Friends::find()
            ->innerJoinWith('user', 'friends.to = user.id')
            ->where(['friends.to' => Yii::$app->user->id, 'friends.from' => $id])
            ->orWhere(['friends.to' => $id, 'friends.from' => Yii::$app->user->id])
            ->all();

        $giftCount = FriendGifts::find()->where(['to' => Yii::$app->user->identity->username])->count();

        $messageCount = Message::find()->where(['to_id' => Yii::$app->user->identity->id, 'viewed' => 0])->count();

        if($imControl){
            $friend_count = Friends::find()->where(['to' => Yii::$app->user->id, 'status' => 1])->orWhere(['from' => Yii::$app->user->id, 'status' => 1])->count();
            $requets_count = Friends::find()->where(['to' => Yii::$app->user->id, 'status' => 3])->count();

            $message_list = Message::find()
                ->innerJoinWith('user', 'message.to_id = user.id')
                ->where(['message.to_id' => $id, 'message.from_id' => Yii::$app->user->id])
                ->orWhere(['message.from_id' => $id, 'message.to_id' => Yii::$app->user->id])
                ->orderBy(['id' => SORT_ASC])
                ->all();

            return $this->render('im', [
                    'user' => $user,
                    'friend_count' => $friend_count,
                    'requets_count' => $requets_count,
                    'message_list' => $message_list,
                    'giftCount' => $giftCount,
                    'messageCount' => $messageCount
                ]
            );

        }else{
            return $this->goHome();
        }

    }

    public function actionSend(){

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

            $content = $data['content'];
            $id = $data['id'];
            $date = $data['date'];
            $from_id = Yii::$app->user->id;

            $message = new Message();

            $message->message = $content;
            $message->to_id = $id;
            $message->date = $date;
            $message->from_id = $from_id;
            $message->viewed = 0;

            $message->save();

            return array('result' => true);

        }

    }

    public function actionViewed(){

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

            $from_id = $data['from_id'];
            $to_id = $data['to_id'];

            Yii::$app->db->createCommand()->update('message', ['viewed' => 1], ['from_id' => $from_id, 'to_id' => $to_id])->execute();

        }

    }

    public function actionUpdate(){

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

            $to_id = Yii::$app->user->identity->id;
            $from_id = $data["from_id"];

            $list = Message::find()->where(['to_id' => $to_id, 'from_id' => $from_id])
                ->orWhere(['from_id' => $to_id, 'to_id' => $from_id])
                ->orderBy(['id' => SORT_ASC])->all();

            if($list){

                Yii::$app->db->createCommand()->update('message', ['viewed' => 1], ['to_id' => $to_id])->execute();

                foreach($list as $li){

                    $result[] = '<div class="msg-user">'.

                        '<img src="/avatars/'.$li->user->photo.'" alt="" class="msg-avatar">'.

                        '<span class="msg-text" style="margin-left: 4px">'.$li->message.'</span>'.

                        '</div>';

                }
                return ['status'=>true, 'results'=>$result];
            }
        }
    }

}
