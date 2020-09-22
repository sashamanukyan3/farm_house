<?php
namespace frontend\controllers;

use common\models\Chat;
use common\models\Settings;
use common\models\User;
use vova07\imperavi\actions\GetAction;
use Yii;
use yii\base\InvalidParamException;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;

/**
 * Site controller
 */
class ChatController extends Controller
{

    public function actionIndex()
    {
        if (\Yii::$app->user->isGuest) {
        return $this->goHome();
        }

        Settings::setLocation('Чат');

        Yii::$app->db->createCommand()->update('user', ['location' => 'Чат', 'last_visited' => time()], ['id' => \Yii::$app->user->identity->id])->execute();
        $user = User::findOne(['id'=>Yii::$app->user->id]);
        if($user->banned)
        {
            return $this->redirect(['site/banned']);
        }
        $model = new Chat();

        $chatList = Chat::find()
            ->where(['is_blocked' => 1])
            ->andWhere(['lang' => Yii::$app->language])
            ->orderBy(['id' => SORT_DESC])
            ->all();

        $last15min = strtotime('-15 min');
        $userList = User::find()->where(['location' => 'Чат'])->andWhere(['>','last_visited',$last15min])->all();
        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();

            Yii::$app->response->format = 'json';

            $username   = $data['username'];
            $text       = $data['text'];
            $userID     = Yii::$app->user->identity->id;
            $status     = $user->chat_status;
            $sex        = $user->sex;
            $link        = $user->username;

            if($status == 1) {

                $find = array("*1*", "*2*", "*3*", "*4*", "*5*", "*6*", "*7*", "*8*", "*9*", "*10*",
                              "*11*", "*12*", "*13*", "*14*", "*15*", "*16*", "*17*", "*18*", "*19*", "*20*",
                              "*21*", "*22*", "*23*", "*24*", "*25*", "*26*", "*27*", "*28*", "*29*", "*30*",
                              "*31*", "*32*", "*33*", "*34*", "*35*", "*36*", "*37*", "*38*", "*39*", "*40*",
                              "*41*", "*42*", "*43*"
                    );

                $change = array(
                    "<img src='/img/smile/1.gif'>",
                    "<img src='/img/smile/2.gif'>",
                    "<img src='/img/smile/3.gif'>",
                    "<img src='/img/smile/4.gif'>",
                    "<img src='/img/smile/5.gif'>",
                    "<img src='/img/smile/6.gif'>",
                    "<img src='/img/smile/7.gif'>",
                    "<img src='/img/smile/8.gif'>",
                    "<img src='/img/smile/9.gif'>",
                    "<img src='/img/smile/10.gif'>",
                    "<img src='/img/smile/11.gif'>",
                    "<img src='/img/smile/12.gif'>",
                    "<img src='/img/smile/13.gif'>",
                    "<img src='/img/smile/14.gif'>",
                    "<img src='/img/smile/15.gif'>",
                    "<img src='/img/smile/16.gif'>",
                    "<img src='/img/smile/17.gif'>",
                    "<img src='/img/smile/18.gif'>",
                    "<img src='/img/smile/19.gif'>",
                    "<img src='/img/smile/20.gif'>",
                    "<img src='/img/smile/21.gif'>",
                    "<img src='/img/smile/22.gif'>",
                    "<img src='/img/smile/23.gif'>",
                    "<img src='/img/smile/24.gif'>",
                    "<img src='/img/smile/25.gif'>",
                    "<img src='/img/smile/26.gif'>",
                    "<img src='/img/smile/27.gif'>",
                    "<img src='/img/smile/28.gif'>",
                    "<img src='/img/smile/29.gif'>",
                    "<img src='/img/smile/30.gif'>",
                    "<img src='/img/smile/31.gif'>",
                    "<img src='/img/smile/32.gif'>",
                    "<img src='/img/smile/33.gif'>",
                    "<img src='/img/smile/34.gif'>",
                    "<img src='/img/smile/35.gif'>",
                    "<img src='/img/smile/36.gif'>",
                    "<img src='/img/smile/37.gif'>",
                    "<img src='/img/smile/38.gif'>",
                    "<img src='/img/smile/39.gif'>",
                    "<img src='/img/smile/40.gif'>",
                    "<img src='/img/smile/41.gif'>",
                    "<img src='/img/smile/42.gif'>",
                    "<img src='/img/smile/43.gif'>",
                );

                $message = str_replace($find, $change, $text);

                $chatModel = new Chat();

                $chatModel->username = $username;
                $chatModel->user_id = $userID;
                $chatModel->text = $message;
                $chatModel->is_blocked = 1;
                $chatModel->sex = $sex;
                $chatModel->link = $link;
                $chatModel->created_at = time();

                $chatModel->lang = Yii::$app->language;

                if(!$chatModel->save())
                {
                    var_dump($chatModel->getFirstErrors()) ;
                    die;
                }

                return array('status' => true);
            }

        }

        return $this->render('index', [
                'model' => $model,
                'chatList' => $chatList,
                'userList' => $userList,
            ]
        );

    }

    public function actionUpdate(){

        if (\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        if (Yii::$app->request->isAjax) {
            $user = User::findOne(['id'=>Yii::$app->user->id]);
            if($user->banned)
            {
                return $this->redirect(['site/banned']);
            }
            $data = Yii::$app->request->post();
            Yii::$app->response->format = 'json';

            $chat_msgs = Chat::find()
                ->where(['is_blocked' => 1])
                ->andWhere(['lang' => Yii::$app->language])
                ->orderBy(['id' => SORT_DESC])
                ->limit(50)
                ->asArray()
                ->all();

            $role = \Yii::$app->user->identity->role;

            if($chat_msgs){
                foreach($chat_msgs as $idx => $chat_msg)
                {
                    if($chat_msg["sex"] == 1) {

                        if($role == 1 || $role == 2){
                            $result['_'.$idx] = '<div style="margin-bottom: 5px" class="chat-div" id="'.$chat_msg['id'].'">'
                                .'<a href="' . Url::toRoute('/profile/view/' . $chat_msg['link']) . '" target="_blank"><img class="chat-sex" src="/img/wall3.png" alt=""></a>'
                                .'<span><img class="chat-sex" src="/img/man.png" alt=""></span>'
                                .'<span class="chat-username">'.$chat_msg['username'].'</span>'
                                .'<span class="chat-date">('.date('Y:m:d H:i:s', $chat_msg['created_at']).')</span><br>'
                                .'<span class="chat-message">'.$chat_msg['text'].'</span>'
                                .'<div class="chat-btn">'
                                .'<a class="remove-message" style="font-size: 12px" href="javascript:void(0);">' . Yii::t('app', 'Удалить') . '</a>'
                                .'</div>'
                                .'</div>';
                        }else{
                            $result['_'.$idx] = '<div style="margin-bottom: 5px" class="chat-div" id="'.$chat_msg['id'].'">'
                                .'<a href="' . Url::toRoute('/profile/view/' . $chat_msg['link']) . '" target="_blank"><img class="chat-sex" src="/img/wall3.png" alt=""></a>'
                                .'<span><img class="chat-sex" src="/img/man.png" alt=""></span>'
                                .'<span class="chat-username">'.$chat_msg['username'].'</span>'
                                .'<span class="chat-date">('.date('Y:m:d H:i:s', $chat_msg['created_at']).')</span><br>'
                                .'<span class="chat-message">'.$chat_msg['text'].'</span>'
                                .'<div class="chat-btn">'
                                .'</div>'
                                .'</div>';
                        }

                    }else{

                        if($role == 1 || $role == 2){
                            $result['_'.$idx] = '<div style="margin-bottom: 5px" class="chat-div" id="'.$chat_msg['id'].'">'
                                .'<a href="' . Url::toRoute('/profile/view/' . $chat_msg['link']) . '" target="_blank"><img class="chat-sex" src="/img/wall3.png" alt=""></a>'
                                .'<span><img class="chat-sex" src="/img/woman.png" alt=""></span>'
                                .'<span class="chat-username">'.$chat_msg['username'].'</span>'
                                .'<span class="chat-date">('.date('Y:m:d H:i:s', $chat_msg['created_at']).')</span><br>'
                                .'<span class="chat-message">'.$chat_msg['text'].'</span>'
                                .'<div class="chat-btn">'
                                .'<a class="remove-message" style="font-size: 12px" href="javascript:void(0);">' . Yii::t('app', 'Удалить') . '</a>'
                                .'</div>'
                                .'</div>';
                        }else{
                            $result['_'.$idx] = '<div style="margin-bottom: 5px" class="chat-div" id="'.$chat_msg['id'].'">'
                                .'<a href="' . Url::toRoute('/profile/view/' . $chat_msg['link']) . '" target="_blank"><img class="chat-sex" src="/img/wall3.png" alt=""></a>'
                                .'<span><img class="chat-sex" src="/img/woman.png" alt=""></span>'
                                .'<span class="chat-username">'.$chat_msg['username'].'</span>'
                                .'<span class="chat-date">('.date('Y:m:d H:i:s', $chat_msg['created_at']).')</span><br>'
                                .'<span class="chat-message">'.$chat_msg['text'].'</span>'
                                .'<div class="chat-btn">'
                                .'</div>'
                                .'</div>';
                        }

                    }

                }

                $defaultTime = Yii::$app->formatter->asTimestamp(date('Y-m-d'));

                $lastTime = Chat::find()
                    ->andWhere(['lang' => Yii::$app->language])
                    ->orderBy(['id' => SORT_DESC])
                    ->one();

                $time = ($defaultTime-$lastTime->created_at);

                if($time < 3){
                    $userID = Yii::$app->user->identity->id;

                    $lastUserId = Chat::find()
                        ->andWhere(['lang' => Yii::$app->language])
                        ->limit(1)
                        ->orderBy(['id' => SORT_DESC])
                        ->one();

                    if($lastUserId->user_id == $userID){
                        return ['status'=>true, 'result'=>$result];
                    }else{
                        if(Yii::$app->user->identity->chat_music == 1){
                            return ['status'=>true, 'result'=>$result, 'mp3' => true];
                        }else{
                            return ['status'=>true, 'result'=>$result];
                        }
                    }
                }else{
                    return ['status'=>true, 'result'=>$result];
                }

            }
            else
            {
                return ['status'=>false];
            }
        }
        else
        {
            throw new NotFoundHttpException;
        }

    }

    public function actionBlock(){

        if (Yii::$app->request->isAjax) {
            $user = User::findOne(['id'=>Yii::$app->user->id]);
            if($user->banned)
            {
                return $this->redirect(['site/banned']);
            }
            $data = Yii::$app->request->post();

            Yii::$app->response->format = 'json';

            Yii::$app->db->createCommand()->update('user', ['chat_status' => 2], ['id' => $data["user_ID"]])->execute();

            return array('status' => true);

        }

    }

    public function actionUnlock(){

        if (Yii::$app->request->isAjax) {
            $user = User::findOne(['id'=>Yii::$app->user->id]);
            if($user->banned)
            {
                return $this->redirect(['site/banned']);
            }
            $data = Yii::$app->request->post();

            Yii::$app->response->format = 'json';

            Yii::$app->db->createCommand()->update('user', ['chat_status' => 1], ['id' => $data["user_ID"]])->execute();

            return array('status' => true);

        }

    }

    public function actionDelete(){
        if (Yii::$app->request->isAjax) {
            $user = User::findOne(['id'=>Yii::$app->user->id]);
            if($user->banned)
            {
                return $this->redirect(['site/banned']);
            }
            $data = Yii::$app->request->post();

            Yii::$app->response->format = 'json';

            $chat = new Chat();

            Yii::$app->db->createCommand()->delete('chat', ['id' => $data['id']])->execute();

            return array('status' => true);
        }

    }

    public function actionOnline(){

        if (\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        if (Yii::$app->request->isAjax) {
            $user = User::findOne(['id'=>Yii::$app->user->id]);
            if($user->banned)
            {
                return $this->redirect(['site/banned']);
            }
            Yii::$app->response->format = 'json';
            $last15min = strtotime('-15 min');
            $chat_online = User::find()->where(['location' => 'Чат'])->andWhere(['>','last_visited',$last15min])->orderBy(['id' => SORT_ASC])->asArray()->all();
            if($chat_online){
                foreach($chat_online as $idx => $online) {
                    $statusControl = User::find()->where(['id' => $online["id"]])->one();
                    if ($statusControl->chat_status == 1){

                        if(Yii::$app->user->identity->role == 1 || Yii::$app->user->identity->role == 2){

                            $roleControl = $online["role"];
                            if ($roleControl == 1) {
                                $result['_' . $idx] = '<div class="online-user-list">'
                                    . '<span class="online-icon"></span>'
                                    . '<span class="online-username"><a href="javascript:void();" style="color: red" class="username" username="' . $online["username"] . '">' . $online["username"] . '</a></span>'
                                    . '<div style="clear: both"></div>'
                                    . '</div>';
                            } else if ($roleControl == 2) {
                                $result['_' . $idx] = '<div class="online-user-list">'
                                    . '<span class="online-icon"></span>'
                                    . '<span class="online-username"><a href="javascript:void();" style="color: green" class="username" username="' . $online["username"] . '">' . $online["username"] . '</a></span>'
                                    . '<a href="javascript:void(0);" user_ID="' . $online["id"] . '" class="block">' . Yii::t('app', 'Блокировать') . '</a>'
                                    . '<div style="clear: both"></div>'
                                    . '</div>';
                            } else {
                                $result['_' . $idx] = '<div class="online-user-list">'
                                    . '<span class="online-icon"></span>'
                                    . '<span class="online-username"><a href="javascript:void();" style="color: blue" class="username" username="' . $online["username"] . '">' . $online["username"] . '</a></span>'
                                    . '<a href="javascript:void(0);" user_ID="' . $online["id"] . '" class="block">' . Yii::t('app', 'Блокировать') . '</a>'
                                    . '<div style="clear: both"></div>'
                                    . '</div>';
                            }

                        }else{

                            $roleControl = $online["role"];
                            if ($roleControl == 1) {
                                $result['_' . $idx] = '<div class="online-user-list">'
                                    . '<span class="online-icon"></span>'
                                    . '<span class="online-username"><a href="javascript:void();" style="color: red" class="username" username="' . $online["username"] . '">' . $online["username"] . '</a></span>'
                                    . '<div style="clear: both"></div>'
                                    . '</div>';
                            } else if ($roleControl == 2) {
                                $result['_' . $idx] = '<div class="online-user-list">'
                                    . '<span class="online-icon"></span>'
                                    . '<span class="online-username"><a href="javascript:void();" style="color: green" class="username" username="' . $online["username"] . '">' . $online["username"] . '</a></span>'
                                    . '<div style="clear: both"></div>'
                                    . '</div>';
                            } else {
                                $result['_' . $idx] = '<div class="online-user-list">'
                                    . '<span class="online-icon"></span>'
                                    . '<span class="online-username"><a href="javascript:void();" style="color: blue" class="username" username="' . $online["username"] . '">' . $online["username"] . '</a></span>'
                                    . '<div style="clear: both"></div>'
                                    . '</div>';
                            }

                        }

                    }else{

                        if(Yii::$app->user->identity->role == 1 || Yii::$app->user->identity->role == 2){

                            $roleControl = $online["role"];
                            if ($roleControl == 1) {
                                $result['_' . $idx] = '<div class="online-user-list">'
                                    . '<span class="online-icon"></span>'
                                    . '<span class="online-username"><a href="javascript:void();" style="color: red" class="username" username="' . $online["username"] . '">' . $online["username"] . '</a></span>'
                                    . '<div style="clear: both"></div>'
                                    . '</div>';
                            } else if ($roleControl == 2) {
                                $result['_' . $idx] = '<div class="online-user-list">'
                                    . '<span class="online-icon"></span>'
                                    . '<span class="online-username"><a href="javascript:void();" style="color: green" class="username" username="' . $online["username"] . '">' . $online["username"] . '</a></span>'
                                    . '<a href="javascript:void(0);" user_ID="' . $online["id"] . '" class="unlock">' . Yii::t('app', 'Разблокировать') . '</a>'
                                    . '<div style="clear: both"></div>'
                                    . '</div>';
                            } else {
                                $result['_' . $idx] = '<div class="online-user-list">'
                                    . '<span class="online-icon"></span>'
                                    . '<span class="online-username"><a href="javascript:void();" style="color: blue" class="username" username="' . $online["username"] . '">' . $online["username"] . '</a></span>'
                                    . '<a href="javascript:void(0);" user_ID="' . $online["id"] . '" class="unlock">' . Yii::t('app', 'Разблокировать') . '</a>'
                                    . '<div style="clear: both"></div>'
                                    . '</div>';
                            }

                        }else{

                            $roleControl = $online["role"];
                            if ($roleControl == 1) {
                                $result['_' . $idx] = '<div class="online-user-list">'
                                    . '<span class="online-icon"></span>'
                                    . '<span class="online-username"><a href="javascript:void();" style="color: red" class="username" username="' . $online["username"] . '">' . $online["username"] . '</a></span>'
                                    . '<div style="clear: both"></div>'
                                    . '</div>';
                            } else if ($roleControl == 2) {
                                $result['_' . $idx] = '<div class="online-user-list">'
                                    . '<span class="online-icon"></span>'
                                    . '<span class="online-username"><a href="javascript:void();" style="color: green" class="username" username="' . $online["username"] . '">' . $online["username"] . '</a></span>'
                                    . '<div style="clear: both"></div>'
                                    . '</div>';
                            } else {
                                $result['_' . $idx] = '<div class="online-user-list">'
                                    . '<span class="online-icon"></span>'
                                    . '<span class="online-username"><a href="javascript:void();" style="color: blue" class="username" username="' . $online["username"] . '">' . $online["username"] . '</a></span>'
                                    . '<div style="clear: both"></div>'
                                    . '</div>';
                            }

                        }

                    }

                }

                return ['status'=>true, 'result'=>$result];
            }
            else
            {
                return ['status'=>false];
            }
        }
        else
        {
            throw new NotFoundHttpException;
        }

    }

    public function actionOffline(){

        if (\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        if (Yii::$app->request->isAjax) {

            $data = Yii::$app->request->post();

            Yii::$app->response->format = 'json';

            Yii::$app->db->createCommand()->update('user', ['!=', 'location', 'Чат'], ['username' => $data["username"]])->execute();

        }
        else
        {
            throw new NotFoundHttpException;
        }

    }

    public function actionDeleteall(){
        $user = User::findOne(['id'=>Yii::$app->user->id]);
        if($user->banned)
        {
            return $this->redirect(['site/banned']);
        }
        Chat::deleteAll();

    }

    public function actionMusicon(){

        if (\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        if (Yii::$app->request->isAjax) {

            $data = Yii::$app->request->post();

            Yii::$app->response->format = 'json';

            Yii::$app->db->createCommand()->update('user', ['chat_music' => 0], ['id' => $data["id"]])->execute();

            return array('status' => true);

        }
        else
        {
            throw new NotFoundHttpException;
        }

    }

    public function actionMusicoff(){

        if (\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        if (Yii::$app->request->isAjax) {

            $data = Yii::$app->request->post();

            Yii::$app->response->format = 'json';

            Yii::$app->db->createCommand()->update('user', ['chat_music' => 1], ['id' => $data["id"]])->execute();

            return array('status' => true);

        }
        else
        {
            throw new NotFoundHttpException;
        }

    }

}
