<?php

namespace frontend\controllers;

use common\models\FriendGifts;
use common\models\Friends;
use common\models\Gifts;
use common\models\Like;
use common\models\LoginHistory;
use common\models\Message;
use common\models\MyPurchaseHistory;
use common\models\PurchaseHistory;

use common\models\Settings;
use common\models\WallComments;
use common\models\WallPost;
use common\models\Search;
use Yii;
use common\models\User;
use frontend\models\Profile;
use vova07\fileapi\actions\UploadAction as FileAPIUpload;
use frontend\models\ChangePasswordForm;
use yii\authclient\AuthAction;
use yii\data\ActiveDataProvider;
use yii\filters\VerbFilter;
use yii\data\Pagination;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

class ProfileController extends \yii\web\Controller
{

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'fileapi-upload' => [
                'class' => FileAPIUpload::className(),
                'path' => '@frontend/web/avatars/',
                'unique' => true,
            ],
            'attach' => [
                'class' => AuthAction::className(),
                'successCallback' => [$this, 'successCallback'],
                'successUrl' => '/profile/index',
            ]

        ];
    }

    public function actionIndex()
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $user = User::findOne(['id' => Yii::$app->user->id]);
        if($user->banned)
        {
            return $this->redirect(['site/banned']);
        }
        Settings::setLocation('Стена фермера');

        Yii::$app->db->createCommand()->update('user', ['last_visited' => time()], ['id' => \Yii::$app->user->identity->id])->execute();

        $error_msg = false;
        $commentModel = new WallComments();
        $model = new WallPost();
        $query = WallPost::find()->where(['user_wall_id' => Yii::$app->user->identity->id])->orderBy(['id' => SORT_DESC]);
        $countQuery = clone $query;
        $wall_posts = $query->all();
        $wall_ids = [];
        foreach ($wall_posts as $i => $wall_post) {
            $wall_ids[] = $wall_post->id;
        }
        $comments = WallComments::find()->innerJoinWith('user', 'wall_comments.user_id = user.id')->where(['wall_comments.wall_id' => $wall_ids])->all();

        $giftCount = FriendGifts::find()->where(['to' => Yii::$app->user->identity->username])->count();

        $messageCount = Message::find()->where(['to_id' => Yii::$app->user->identity->id, 'viewed' => 0])->count();

        unset($wall_ids);

        $blogDataProvider = new ActiveDataProvider([
            'query' => $countQuery,
            'pagination' => ['pageSize' => '2'],
        ]);

        $friend_count = Friends::find()->where(['to' => Yii::$app->user->id, 'status' => 1])->orWhere(['from' => Yii::$app->user->id, 'friends.status' => 1])->count();
        $request_count = Friends::find()->where(['to' => Yii::$app->user->id, 'status' => 3])->count();

        //$wallAttachmentsModel = new WallAttachments();

        if ($model->load(Yii::$app->request->post())) {
            //print_r($wallAttachmentsModel);die;

            $level = $user->level;

            if ($level < Settings::$wallLevelControl) {
                $error_msg = Yii::t('app', 'Недостаточно уровня');
            } else {
                if(!$model->content){
                    $error_msg = Yii::t('app', 'Все поля должны быть заполнены');
                }else {
                    $energyControl = User::find()->where(['id' => Yii::$app->user->id])->one();
                    if ($energyControl->energy > Settings::$wallEnergyControl) {
                        $model->user_id = Yii::$app->user->id;
                        $energyControl->updateCounters(['energy' => Settings::$wallEnergyRemove]);
                        $model->file = UploadedFile::getInstance($model, 'file');

                        if ($model->file) {
                            $path = Yii::getAlias('@frontend') . '/web/uploads/wallpost/';
                            $file = md5(time() . '.' . $model->file->baseName . $model->file->extension);
                            $prePath = substr($file, 0, 5);
                            $tempPath = '';
                            for ($i = 0; $i < 5; $i++) {
                                $tempPath .= '/' . $prePath[$i];
                            }
                            mkdir($path . $tempPath, 0775, true);
                            $model->file->saveAs($path . $tempPath . '/' . $file . '.' . $model->file->extension);
                            $model->image = $tempPath . '/' . $file . '.' . $model->file->extension;
                        }
                        $model->save();
                        return $this->redirect(['profile/index']);
                    } else {
                        $error_msg = Yii::t('app', 'Недостаточно энергии');
                    }
                }
            }

        }

        return $this->render('index', [
            'user' => $user,
            'model' => $model,
            'commentModel' => $commentModel,
            'comments' => $comments,
            'blogDataProvider' => $blogDataProvider,
            'friend_count' => $friend_count,
            'requets_count' => $request_count,
            'error_msg' => $error_msg,
            'giftCount' => $giftCount,
            'messageCount' => $messageCount,
        ]);

    }

    public function actionUnbind($data)
    {

        $user = User::findOne(['id' => Yii::$app->user->id]);
        $user->$data = NULL;
        $user->save();

    }

    public function actionEdit()
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $user = User::findOne(['id' => Yii::$app->user->id]);

        if($user->banned)
        {
            return $this->redirect(['site/banned']);
        }
        Settings::setLocation('Стена фермера');

        Yii::$app->db->createCommand()->update('user', ['last_visited' => time()], ['id' => \Yii::$app->user->identity->id])->execute();

        $model = new Profile();

        $passwordModel = new ChangePasswordForm();

        $friend_count = Friends::find()->where(['to' => Yii::$app->user->id, 'status' => 1])->orWhere(['from' => Yii::$app->user->id])->count();
        $requets_count = Friends::find()->where(['to' => Yii::$app->user->id, 'status' => 3])->count();

        $giftCount = FriendGifts::find()->where(['to' => Yii::$app->user->identity->username])->count();
        $messageCount = Message::find()->where(['to_id' => Yii::$app->user->identity->id, 'viewed' => 0])->count();

        if ($model->load(Yii::$app->request->post())) {
            if ($model->changeProfile()) {
                //Yii::$app->getSession()->setFlash('success', 'Данные успешно изменены!');
                return $this->redirect(['profile/index']);
            } else {

            }
        }

        return $this->render('edit', [
            'model' => $model,
            'user' => $user,
            'passwordModel' => $passwordModel,
            'friend_count' => $friend_count,
            'requets_count' => $requets_count,
            'giftCount' => $giftCount,
            'messageCount' => $messageCount
        ]);
    }

    public function actionView($username = "")
    {

        if (\Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $username = addslashes(trim(Yii::$app->request->get('username')));
        if(!$username){
            throw new NotFoundHttpException;
        }

        $myUser = User::findOne(['id' => Yii::$app->user->identity->id]);
        if ($myUser->banned) {
            return $this->redirect(['site/banned']);
        }

        $user = User::findOne(['username' => $username]);

        if ($user){

            Settings::setLocation('Стена фермера');

            Yii::$app->db->createCommand()->update('user', ['last_visited' => time()], ['id' => \Yii::$app->user->identity->id])->execute();

            $error_msg = false;
            if ($user) {

                $model = new WallPost();

                $comment = new WallComments();
                $commentModel = new WallComments();

                $friend_count = Friends::find()->where(['to' => $user->id, 'status' => 1])->orWhere(['from' => $user->id, 'status' => 1])->count();
                $requets_count = Friends::find()->where(['to' => $user->id, 'status' => 3])->count();

                $giftCount = FriendGifts::find()->where(['to' => $user->username])->count();
                $messageCount = Message::find()->where(['to_id' => Yii::$app->user->identity->id, 'viewed' => 0])->count();

                if ($comment->load(Yii::$app->request->post())) {

                    $comment->user_id = Yii::$app->user->id;

                    $comment->save();

                    return $this->redirect(['profile/view/' . $username]);

                } elseif ($model->load(Yii::$app->request->post())) {

                    $level = $user->level;

                    $energyControl = User::find()->where(['id' => Yii::$app->user->id])->one();
                    if ($energyControl->energy > Settings::$wallEnergyControl) {
                        $model->user_id = Yii::$app->user->id;
                        $energyControl->updateCounters(['energy' => Settings::$wallEnergyRemove]);

                        $model->file = UploadedFile::getInstance($model, 'file');

                        if ($model->file) {

                            $path = Yii::getAlias('@frontend') . '/web/uploads/wallpost/';
                            $file = md5(time() . '.' . $model->file->baseName . $model->file->extension);
                            $prePath = substr($file, 0, 5);
                            $tempPath = '';
                            for ($i = 0; $i < 5; $i++) {
                                $tempPath .= '/' . $prePath[$i];
                            }
                            mkdir($path . $tempPath, 0775, true);
                            $model->file->saveAs($path . $tempPath . '/' . $file . '.' . $model->file->extension);
                            $model->image = $tempPath . '/' . $file . '.' . $model->file->extension;
                        }
                        $model->save();
                        return $this->redirect(['profile/view/' . $username]);
                    } else {
                        $error_msg = Yii::t('app', 'Недостаточно энергии');
                    }

                } else {

                    if ($user) {
                        return $this->render('view', [
                            'user' => $user,
                            'model' => $model,
                            'comment' => $comment,
                            'friend_count' => $friend_count,
                            'requets_count' => $requets_count,
                            'giftCount' => $giftCount,
                            'error_msg' => $error_msg,
                            'commentModel' => $commentModel,
                            'messageCount' => $messageCount,
                            'myUser' => $myUser
                        ]);
                    } else {

                        $user = User::findOne(['id' => Yii::$app->user->id]);

                        $friend_count = Friends::find()->where(['to' => Yii::$app->user->id, 'status' => 1])->orWhere(['from' => Yii::$app->user->id, 'status' => 1])->count();
                        $requets_count = Friends::find()->where(['to' => Yii::$app->user->id, 'status' => 3])->count();

                        return $this->render('error', [
                            'user' => $user,
                            'friend_count' => $friend_count,
                            'requets_count' => $requets_count,
                            'giftCount' => $giftCount,
                            'error_msg' => $error_msg,
                            'commentModel' => $commentModel,
                            'messageCount' => $messageCount,
                            'myUser' => $myUser
                        ]);
                    }

                }

            } else {
                return $this->goHome();
            }
        }else{
            throw new NotFoundHttpException;
        }
    }

    public function actionChangePassword()
    {

        if (\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $user = User::findOne(['id' => Yii::$app->user->id]);
        if($user->banned)
        {
            return $this->redirect(['site/banned']);
        }
        $model = new Profile();

        $passwordModel = new ChangePasswordForm();
        if ($passwordModel->load(Yii::$app->request->post())) {
            if ($passwordModel->changePassword()) {
                Yii::$app->getSession()->setFlash('success', Yii::t('app', 'Пароль успешно изменен'));
                $this->goBack("/profile/edit/");
            } else {
                Yii::$app->getSession()->setFlash('danger', Yii::t('app', 'Возникла ошибка'));
            }
        }

        return $this->render('index', [
                'user' => $user,
                'model' => $model,
                'passwordModel' => $passwordModel
            ]
        );

    }

    public function actionLike()
    {
        Yii::$app->response->format = 'json';

        $user = User::findOne(['id' => Yii::$app->user->id]);
        if($user->banned)
        {
            return $this->redirect(['site/banned']);
        }
        $data = Yii::$app->request->post();
        $wallID = $data['wallID'];
        $user_id = Yii::$app->user->id;

        $like = Like::find()->where(['wall_id' => $wallID, 'user_id' => $user_id])->one();

        if ($like) {

            Yii::$app->db->createCommand()->delete('like', ['id' => $like->id])->execute();

            $energyControl = User::find()->where(['id' => $user_id])->one();
            if ($energyControl->energy > Settings::$wallLikeEnergyControl) {
                $energyControl->updateCounters(['energy' => Settings::$wallLikeEnergyRemove]);
                $wall = WallPost::findOne($wallID);
                $wall->updateCounters(['like_count' => -1]);
            } else {
                return array('status' => false, 'msg' => Yii::t('app', 'Недостаточно энергии'));
            }

            return array('status' => true, 'msg' => '', 'like_count' => $wall->like_count, 'like' => false);

        } else {

            $level = $user->level;
            $user_id = \Yii::$app->user->identity->id;

            if ($level < Settings::$newsViewLevel) {
                return array('status' => false, 'msg' => Yii::t('app', 'Недостаточно уровня'));
            } else {

                $like = new Like();
                $like->wall_id = $wallID;
                $like->user_id = $user_id;

                $energyControl = User::find()->where(['id' => $user_id])->one();
                if ($energyControl->energy > 9) {
                    $like->save();
                    $energyControl->updateCounters(['energy' => -10]);
                    $wall = WallPost::findOne($wallID);
                    $wall->updateCounters(['like_count' => 1]);
                } else {
                    return array('status' => false, 'msg' => Yii::t('app', 'Недостаточно энергии'));
                }

            }

            return array('status' => true, 'msg' => '', 'like_count' => $wall->like_count, 'like' => true);

        }
    }

    public function actionRequests()
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $user = User::findOne(['id' => Yii::$app->user->id]);
        if($user->banned)
        {
            return $this->redirect(['site/banned']);
        }
        Settings::setLocation('Стена фермера');

        Yii::$app->db->createCommand()->update('user', ['last_visited' => time()], ['id' => \Yii::$app->user->identity->id])->execute();

        $id = Yii::$app->user->id;


        $friends = Friends::find()->innerJoinWith('user')->where(['friends.to' => $id, 'friends.status' => 3])->all();

        $friend_count = Friends::find()->where(['to' => $id, 'status' => 1])->orWhere(['from' => $id, 'status' => 1])->count();
        $requets_count = Friends::find()->where(['to' => $id, 'status' => 3])->count();

        $giftCount = FriendGifts::find()->where(['to' => Yii::$app->user->identity->username])->count();
        $messageCount = Message::find()->where(['to_id' => Yii::$app->user->identity->id, 'viewed' => 0])->count();

        return $this->render('requests', [
                'user' => $user,
                'friends' => $friends,
                'friend_count' => $friend_count,
                'requets_count' => $requets_count,
                'giftCount' => $giftCount,
                'messageCount' => $messageCount
            ]
        );

    }

    public function actionList()
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $id = Yii::$app->user->id;
        $user = User::findOne(['id' => $id]);
        if($user->banned)
        {
            return $this->redirect(['site/banned']);
        }
        Settings::setLocation('Стена фермера');

        Yii::$app->db->createCommand()->update('user', ['last_visited' => time()], ['id' => \Yii::$app->user->identity->id])->execute();

        if (Yii::$app->request->isAjax) {

            $data = Yii::$app->request->post();

            Yii::$app->response->format = 'json';

            $user_id = \Yii::$app->user->identity->id;
            $dataId = (int)$data['id'];
            if(!$dataId || $dataId === 0){
                throw new NotFoundHttpException();
            }

            $friends = new Friends();

            $removeFriend = Friends::find()
                ->where(['to' => $dataId, 'from' => $user_id])
                ->orWhere(['from' => $dataId, 'to' => $user_id])->one();

            if($removeFriend){

                Yii::$app->db->createCommand()->delete('friends', ['id' => $removeFriend->id])->execute();

                return array('removeFriends' => true);

            }else{
                return array('removeFriends' => false, 'msg' => Yii::t('app', 'Ошибка'));
            }

        }

        $friends = Friends::find()->where(['friends.to' => $id, 'friends.status' => 1])->orWhere(['friends.from' => $id, 'friends.status' => 1])->all();

        $ids = [];
        if ($friends) {
            foreach ($friends as $f) {
                if ($f['to'] == $user->id) {
                    $ids[] = $f['from'];
                }
                if ($f['from'] == $user->id) {
                    $ids[] = $f['to'];
                }
            }
        }

        $user_friends = [];
        $friend_count = 0;
        $requets_count = Friends::find()->where(['to' => $id, 'status' => 3])->count();
        $giftCount = FriendGifts::find()->where(['to' => Yii::$app->user->identity->username])->count();
        $messageCount = Message::find()->where(['to_id' => Yii::$app->user->identity->id, 'viewed' => 0])->count();
        if (!empty($ids)) {
            $user_friends = User::find()->where(['id' => $ids])->all();
            $friend_count = Friends::find()->where(['to' => $id, 'status' => 1])->orWhere(['from' => $id, 'status' => 1])->count();
        }

        return $this->render('list', [
                'user' => $user,
                'user_friends' => $user_friends,
                'friend_count' => $friend_count,
                'requets_count' => $requets_count,
                'giftCount' => $giftCount,
                'messageCount' => $messageCount
            ]
        );

    }

    public function actionGift(){

        if (\Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $id = Yii::$app->user->id;

        $user = User::findOne(['id' => $id]);
        if($user->banned)
        {
            return $this->redirect(['site/banned']);
        }
        Settings::setLocation('Стена фермера');

        Yii::$app->db->createCommand()->update('user', ['last_visited' => time()], ['id' => \Yii::$app->user->identity->id])->execute();

        $requets_count = Friends::find()->where(['to' => $id, 'status' => 3])->count();

        $model = new FriendGifts;

        $friend_count = Friends::find()->where(['to' => $id, 'status' => 1])->orWhere(['from' => $id, 'status' => 1])->count();

        $giftCount = FriendGifts::find()->where(['to' => Yii::$app->user->identity->username])->count();
        $messageCount = Message::find()->where(['to_id' => Yii::$app->user->identity->id, 'viewed' => 0])->count();

        $gifts = Gifts::find()->all();

        if (Yii::$app->request->isAjax) {

            $data = Yii::$app->request->post();

            Yii::$app->response->format = 'json';

            $gifts_id = $data['gifts_id'];
            $from = $data['from'];
            $to = $data['to'];
            $comment = $data['comment'];

            $level = $user->level;
            $user_id = \Yii::$app->user->identity->id;

            if(!$to || !$from || !$gifts_id){
                return array('gift' => false, 'msg' => Yii::t('app', 'Все поля должны быть заполнены'));
            }else{
                if ($level < Settings::$giftLevel) {
                    return array('gift' => false, 'msg' => Yii::t('app', 'Недостаточно уровня'));
                } else {

                    $model->gifts_id = $gifts_id;
                    $model->from = $from;
                    $model->to = $to;
                    $model->comment = $comment;
                    $model->status = 1;

                    $userControl = User::find()->where(['username' => $to])->one();
                    if($userControl) {
                        $energyControl = User::find()->where(['id' => $user_id])->one();
                        if ($energyControl->energy > Settings::$giftEnergyControl) {
                            $model->save();
                            $energyControl->updateCounters(['energy' => Settings::$giftEnergyRemove]);
                            return array('gift' => true, 'msg' => Yii::t('app', 'Подарок отправлен'));
                        } else {
                            return array('gift' => false, 'msg' => Yii::t('app', 'Недостаточно энергии'));
                        }
                    }else{
                        return array('gift' => false, 'msg' => Yii::t('app', 'Такого пользователя не существует'));
                    }
                }

            }

        }

        return $this->render('gift', [
                'user' => $user,
                'friend_count' => $friend_count,
                'requets_count' => $requets_count,
                'gifts' => $gifts,
                'model' => $model,
                'giftCount' => $giftCount,
                'messageCount' => $messageCount
            ]
        );
    }

    public function actionGiftlist(){

        if (\Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $id = Yii::$app->user->id;
        $user = User::findOne(['id' => $id]);
        if($user->banned)
        {
            return $this->redirect(['site/banned']);
        }
        Settings::setLocation('Стена фермера');

        Yii::$app->db->createCommand()->update('user', ['last_visited' => time()], ['id' => \Yii::$app->user->identity->id])->execute();


        $requets_count = Friends::find()->where(['to' => $id, 'status' => 3])->count();
        $friend_count = Friends::find()->where(['to' => $id, 'status' => 1])->orWhere(['from' => $id, 'status' => 1])->count();
        $giftCount = FriendGifts::find()->where(['to' => Yii::$app->user->identity->username])->count();
        $messageCount = Message::find()->where(['to_id' => Yii::$app->user->identity->id, 'viewed' => 0])->count();
        $username = \Yii::$app->user->identity->username;

        // status => 1
        $approvedGifts = FriendGifts::find()
            ->innerJoinWith('gifts', 'friend_gifts.gifts_id = gifts.id')
            ->where(['to' => $username, 'status' => 1])
            ->orderBy(['id' => SORT_DESC])
            ->all();

        $sendGifts = FriendGifts::find()
            ->innerJoinWith('gifts', 'friend_gifts.gifts_id = gifts.id')
            ->where(['from' => $username])
            ->orderBy(['id' => SORT_DESC])
            ->all();

        return $this->render('giftlist', [
                'user' => $user,
                'friend_count' => $friend_count,
                'requets_count' => $requets_count,
                'approvedGifts' => $approvedGifts,
                'sendGifts' => $sendGifts,
                'giftCount' => $giftCount,
                'messageCount' => $messageCount
            ]
        );

    }

    public function actionAjaxgift(){

        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();
            $user = User::findOne(['id' => Yii::$app->user->id]);
            if($user->banned)
            {
                return $this->redirect(['site/banned']);
            }
            Yii::$app->response->format = 'json';

            if ($data["type"] == 1) {

                Yii::$app->response->format = 'json';

                $friends = new Friends();

                Yii::$app->db->createCommand()->update('friend_gifts', ['status' => 1], ['id' => $data["id"]])->execute();

                return array('addGift' => true);

            } elseif ($data["type"] == 2) {

                Yii::$app->response->format = 'json';

                $friends = new Friends();

                Yii::$app->db->createCommand()->update('friend_gifts', ['status' => 3], ['id' => $data["id"]])->execute();

                return array('addGift' => true);

            }

        }

    }

    public function actionComment()
    {
        $user = User::findOne(['id' => Yii::$app->user->id]);
        if($user->banned)
        {
            return $this->redirect(['site/banned']);
        }
        if (Yii::$app->request->isAjax) {

            $data = Yii::$app->request->post();
            if (isset($data['type'])) {
                if ($data["type"] == 1) {

                    Yii::$app->response->format = 'json';

                    $text = $data['text'];
                    $wall_id = $data['wall_id'];


                    $level = $user->level;
                    $user_id = \Yii::$app->user->identity->id;

                    if ($level < Settings::$commentLevelControl) {
                        return array('status' => false, 'msg' => Yii::t('app', 'Недостаточно уровня'));
                    } else {

                        $comments = new WallComments();

                        $comments->wall_id = $wall_id;
                        $comments->text = $text;
                        $comments->user_id = $user_id;

                        $energyControl = User::find()->where(['id' => $user_id])->one();
                        if ($energyControl->energy > Settings::$commentEnergyControl) {
                            $comments->save();
                            $energyControl->updateCounters(['energy' => Settings::$commentEnergyRemove]);
                            return array('status' => true, 'commentID' => $comments->id);
                        } else {
                            return array('status' => false, 'msg' => Yii::t('app', 'Недостаточно энергии'));
                        }

                    }

                }
            }
        } else {
            throw new \yii\web\NotFoundHttpException();
        }
    }

    public function actionFriends()
    {

        if (\Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $user = User::findOne(['id' => Yii::$app->user->id]);
        if($user->banned)
        {
            return $this->redirect(['site/banned']);
        }
        Yii::$app->db->createCommand()->update('user', ['last_visited' => time()], ['id' => \Yii::$app->user->identity->id])->execute();

        // type = 1 -> add    Friends
        // type = 2 -> remove Friends
        // type = 3 -> update Friends (friends.status = 3 to friends.status = 1)

        if (Yii::$app->request->isAjax) {

            $data = Yii::$app->request->post();

            Yii::$app->response->format = 'json';

            if ($data["type"] == 1) {

                $to = $data['to'];
                $from = $data['from'];

                $friendControl = Friends::find()->where(['to' => $to, 'from' => $from])->orWhere(['to' => $from, 'from' => $to])->all();
                if($friendControl){
                    return 1;
                }

                $friends = new Friends();

                $friends->to = $to;
                $friends->from = $from;
                $friends->status = 3;
                $friends->save();

                if($friends->save()){
                    $friends->save();
                    return array('addfriends' => true, 'id' => $friends->id);
                }else{
                    return array('addfriends' => false, 'msg'=>'Ошибка...');
                }

            } elseif ($data["type"] == 2) {

                Yii::$app->response->format = 'json';

                $to = $data['to'];
                $from = $data['from'];

                $friendControl = Friends::find()->where(['to' => $to, 'from' => $from, 'status' => 1])->orWhere(['to' => $from, 'from' => $to, 'status' => 1])->all();
                if($friendControl){
                    return array('addfriends' => false);
                }

                $friends = new Friends();

                Yii::$app->db->createCommand()->delete('friends', ['or', 'to' => $data['from'], 'from' => $data["to"], ['to' => $data["to"], 'from' => $data["from"]]])->execute();

                return array('removeFriends' => true);

            } elseif ($data["type"] == 3) {

                Yii::$app->response->format = 'json';

                $friends = new Friends();

                Yii::$app->db->createCommand()->update('friends', ['status' => 1], ['id' => $data["id"]])->execute();

                return array('addFriends' => true);

            }

        }

    }

    public function actionSearch()
    {

        if (\Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $id = Yii::$app->user->id;
        $user = User::findOne(['id' => $id]);
        if($user->banned)
        {
            return $this->redirect(['site/banned']);
        }

        Settings::setLocation('Стена фермера');

        Yii::$app->db->createCommand()->update('user', ['last_visited' => time()], ['id' => \Yii::$app->user->identity->id])->execute();

        $query = '';
        $userList = '';
        $giftCount = 0;
        $queryWithTags = false;
        $model = new Search();
        $requets_count = Friends::find()->where(['to' => $id, 'status' => 3])->count();
        $friend_count = Friends::find()->where(['to' => Yii::$app->user->id, 'status' => 1])->orWhere(['from' => Yii::$app->user->id, 'status' => 1])->count();
        $giftCount = FriendGifts::find()->where(['to' => Yii::$app->user->identity->username])->count();
        $messageCount = Message::find()->where(['to_id' => Yii::$app->user->identity->id, 'viewed' => 0])->count();
        if ($model->load(Yii::$app->request->get())) {

            $query = strip_tags($model->query);

            if(strlen($query) < strlen($model->query)) {
                $queryWithTags = true;
                return $this->render('list', [
                    'query' => $query,
                    'model' => $model,
                    'userList' => $userList,
                    'queryWithTags' => $queryWithTags,
                    'friend_count' => $friend_count,
                    'requets_count' => $requets_count,
                    'giftCount' => $giftCount,
                    'messageCount' => $messageCount,
                    'user' => $user
                ]);
            }

            if($query != ''){
                $userModel = new User();
                $userList = $userModel::find()->andFilterWhere(['like', 'username', $query])->all();

                $resulCount = count($userList);
                if($resulCount) {
                    return $this->render('search', [
                        'query' => $query,
                        'model' => $model,
                        'resulCount' => $resulCount,
                        'queryWithTags' => $queryWithTags,
                        'userList' => $userList,
                        'friend_count' => $friend_count,
                        'requets_count' => $requets_count,
                        'giftCount' => $giftCount,
                        'messageCount' => $messageCount,
                        'user' => $user,
                        'msg' => '',
                    ]);
                }else{
                    return $this->render('search', [
                        'query' => $query,
                        'model' => $model,
                        'resulCount' => $resulCount,
                        'queryWithTags' => $queryWithTags,
                        'userList' => $userList,
                        'friend_count' => $friend_count,
                        'requets_count' => $requets_count,
                        'giftCount' => $giftCount,
                        'messageCount' => $messageCount,
                        'user' => $user,
                        'msg' => Yii::t('app', 'Такого пользователя не существует'),
                    ]);
                }
            }
            else {
                return $this->render('search', [
                    'query' => $query,
                    'model' => $model,
                    'queryWithTags' => $queryWithTags,
                    'userList' => $userList,
                    'friend_count' => $friend_count,
                    'requets_count' => $requets_count,
                    'giftCount' => $giftCount,
                    'messageCount' => $messageCount,
                    'user' => $user,
                    'msg' => '',
                ]);
            }
        }

        else {
            return $this->render('search', [
                'query' => $query,
                'model' => $model,
                'queryWithTags' => $queryWithTags,
                'userList' => $userList,
                'friend_count' => $friend_count,
                'requets_count' => $requets_count,
                'giftCount' => $giftCount,
                'messageCount' => $messageCount,
                'user' => $user
            ]);
        }

    }

    public function actionFriendlist(){

        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $id = Yii::$app->user->id;
        $user = User::findOne(['id' => $id]);
        if($user->banned)
        {
            return $this->redirect(['site/banned']);
        }
        Settings::setLocation('Стена фермера');
        //Yii::$app->db->createCommand()->update('user', ['location' => 'Стена', 'last_visited' => time()], ['id' => \Yii::$app->user->identity->id])->execute();

        // delete friend
        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();
            Yii::$app->response->format = 'json';
            $user_id = \Yii::$app->user->identity->id;
            $dataId = (int)$data['id'];
            if(!$dataId || $dataId === 0){
                throw new NotFoundHttpException();
            }
            $friends = new Friends();
            $removeFriend = Friends::find()
                ->where(['to' => $dataId, 'from' => $user_id])
                ->orWhere(['from' => $dataId, 'to' => $user_id])->one();
            if($removeFriend){
                Yii::$app->db->createCommand()->delete('friends', ['id' => $removeFriend->id])->execute();
                return array('removeFriends' => true);
            }else{
                return array('removeFriends' => false, 'msg' => Yii::t('app', 'Ошибка'));
            }
        }
        /*$friends = Friends::find()->where(['friends.to' => $id, 'friends.status' => 1])->orWhere(['friends.from' => $id, 'friends.status' => 1])->all();
        $ids = [];
        if ($friends) {
            foreach ($friends as $f) {
                if ($f['to'] == $user->id) {
                    if($f['from'] == $user->ref_id)
                    {
                        continue;
                    }
                    else
                    {
                        $ids[] = $f['from'];
                    }
                }
                if ($f['from'] == $user->id) {
                    if($f['to'] == $user->ref_id)
                    {
                        continue;
                    }
                    else
                    {
                        $ids[] = $f['to'];
                    }
                }
            }
        }*/

        $fRefIds = User::find()->select('id')->where(['ref_id' => Yii::$app->user->identity->id])->all();
        $fIds = [];
        foreach($fRefIds as $fRefId)
        {
            $fIds[] = $fRefId->id;
        }
        $user_friends = [];
        $friend_count = 0;
        $pages = 0;
        if (!empty($ids)) {
            foreach($fIds as $fI => $fId) {
                if(!in_array($fId, $ids))
                {
                    $ids[] = $fId;
                }
            }
            $query  = User::find()->where(['id' => $ids])->orderBy(['login_date' => SORT_DESC]);
            $countQuery = clone $query;
            $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => 20]);
            $pages->pageSizeParam = false;
            $user_friends = $query->offset($pages->offset)
                ->limit($pages->limit)
                ->all();
            $friend_count = count(User::find()->where(['id' => $ids])->all());
        }
        else
        {
            if(!empty($fIds))
            {
                $query  = User::find()->where(['id' => $fIds])->orderBy(['login_date' => SORT_DESC]);
                $countQuery = clone $query;
                $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => 20]);
                $pages->pageSizeParam = false;
                $user_friends = $query->offset($pages->offset)
                    ->limit($pages->limit)
                    ->all();
                $friend_count = count(User::find()->where(['id' => $fIds])->all());
            }
        }
        if(Yii::$app->user->identity->ref_id > 0){
            $refQuery = User::find()->where(['id' => Yii::$app->user->identity->ref_id])->one();
        }else{
            $refQuery = null;
        }
        ////////////////
        $query = '';
        $userList = '';
        $queryWithTags = false;
        $model = new Search();
        $id = Yii::$app->user->id;
        $user = User::findOne(['id' => $id]);

        if ($model->load(Yii::$app->request->get()) ){
            //echo '<pre>'; var_dump($userList); die();
            $query = trim(htmlentities(strip_tags($model->query)));
            if(strlen($query) < strlen($model->query)) {
                $queryWithTags = true;
                return $this->render('friendlist', [
                    'query' => $query,
                    'model' => $model,
                    'userList' => $userList,
                    'queryWithTags' => $queryWithTags,
                    'user' => $user
                ]);
            }
            if($query != ''){
                $userModel = new User();
                $userList = $userModel::find()->where(['ref_id'=>$id])->andFilterWhere(['like', 'username', $query])->all();
                $resulCount = count($userList);
                if($resulCount) {
                    return $this->render('friendlist', [
                        'query' => $query,
                        'model' => $model,
                        'resulCount' => $resulCount,
                        'queryWithTags' => $queryWithTags,
                        'userList' => $userList,
                        'user' => $user,
                        'msg' => '',
                    ]);
                }else{
                    return $this->render('friendlist', [
                        'query' => $query,
                        'model' => $model,
                        'resulCount' => $resulCount,
                        'queryWithTags' => $queryWithTags,
                        'userList' => $userList,
                        'user' => $user,
                        'msg' => Yii::t('app', 'У вас нет друга с таким именем'),
                    ]);
                }
            }
        }

        return $this->render('friendlist', [
                'user' => $user,
                'user_friends' => $user_friends,
                'pages' => $pages,
                'friend_count' => $friend_count,
                'refQuery' => $refQuery,
                'friends' => ''
            ]
        );

    }

    public function actionAjaxwalldelete(){

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

            $id = $data['wall_id'];

            $wall = new WallPost();

            WallComments::deleteAll(['wall_id' => $id]);

            Yii::$app->db->createCommand()->delete('wall_post', ['id' => $id])->execute();

            return array('removeWall' => true);

        }

    }

    public function actionAjaxcommentdelete(){

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

            $id = $data['comment_id'];

            $comment = new WallComments();

            Yii::$app->db->createCommand()->delete('wall_comments', ['id' => $id])->execute();

            return array('removeComment' => true);

        }

    }

    public function actionViewlist($id){

        if (Yii::$app->user->isGuest) {
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

        Settings::setLocation('Стена фермера');

        Yii::$app->db->createCommand()->update('user', ['last_visited' => time()], ['id' => \Yii::$app->user->identity->id])->execute();

        $friends = Friends::find()->where(['friends.to' => $id, 'friends.status' => 1])->orWhere(['friends.from' => $id, 'friends.status' => 1])->all();

        $ids = [];
        if ($friends) {
            foreach ($friends as $f) {
                if ($f['to'] == $id) {
                    $ids[] = $f['from'];
                }
                if ($f['from'] == $id) {
                    $ids[] = $f['to'];
                }
            }
        }


        $user_friends = [];
        $friend_count = 0;
        $requets_count = Friends::find()->where(['to' => $id, 'status' => 3])->count();
        $giftCount = FriendGifts::find()->where(['to' => $user->username])->count();
        if (!empty($ids)) {
            $user_friends = User::find()->where(['id' => $ids])->all();
            $friend_count = Friends::find()->where(['to' => $id, 'status' => 1])->orWhere(['from' => $id, 'status' => 1])->count();
        }

        $userView = User::findOne($id);

        return $this->render('viewlist', [
                'user' => $user,
                'user_friends' => $user_friends,
                'friend_count' => $friend_count,
                'requets_count' => $requets_count,
                'giftCount' => $giftCount,
                'userView' => $userView
            ]
        );

    }

    public function actionViewrequests($id){

        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $user = User::findOne(['id' => $id]);
        if($user->banned)
        {
            return $this->redirect(['site/banned']);
        }

        $id = (int)$id;
        if(!$id || $id==0)
        {
            throw new NotFoundHttpException;
        }

        Settings::setLocation('Стена фермера');

        Yii::$app->db->createCommand()->update('user', ['last_visited' => time()], ['id' => \Yii::$app->user->identity->id])->execute();

        $friends = Friends::find()->innerJoinWith('user')->where(['friends.to' => $id, 'friends.status' => 3])->all();

        $friend_count = Friends::find()->where(['to' => $id, 'status' => 1])->orWhere(['from' => $id, 'status' => 1])->count();
        $requets_count = Friends::find()->where(['to' => $id, 'status' => 3])->count();

        $giftCount = FriendGifts::find()->where(['to' => Yii::$app->user->identity->username])->count();

        $userView = User::findOne($id);

        return $this->render('viewrequests', [
                'user' => $user,
                'friends' => $friends,
                'friend_count' => $friend_count,
                'requets_count' => $requets_count,
                'giftCount' => $giftCount,
                'userView' => $userView
            ]
        );

    }

    public function actionViewgiftlist($id){

        if (\Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $user = User::findOne(['id' => $id]);
        if($user->banned)
        {
            return $this->redirect(['site/banned']);
        }

        $id = (int)$id;
        if(!$id || $id==0)
        {
            throw new NotFoundHttpException;
        }

        Settings::setLocation('Стена фермера');

        Yii::$app->db->createCommand()->update('user', ['last_visited' => time()], ['id' => \Yii::$app->user->identity->id])->execute();

        $requets_count = Friends::find()->where(['to' => $id, 'status' => 3])->count();
        $friend_count = Friends::find()->where(['to' => $id, 'status' => 1])->orWhere(['from' => $id, 'status' => 1])->count();
        $giftCount = FriendGifts::find()->where(['to' => $user->username])->count();
        $username = $user->username;

        // status => 1
        $approvedGifts = FriendGifts::find()
            ->innerJoinWith('gifts', 'friend_gifts.gifts_id = gifts.id')
            ->where(['to' => $username, 'status' => 1])
            ->orderBy(['id' => SORT_DESC])
            ->all();

        $sendGifts = FriendGifts::find()
            ->innerJoinWith('gifts', 'friend_gifts.gifts_id = gifts.id')
            ->where(['from' => $username])
            ->orderBy(['id' => SORT_DESC])
            ->all();

        $userView = User::findOne($id);

        return $this->render('viewgiftlist', [
                'user' => $user,
                'friend_count' => $friend_count,
                'requets_count' => $requets_count,
                'approvedGifts' => $approvedGifts,
                'sendGifts' => $sendGifts,
                'giftCount' => $giftCount,
                'userView' => $userView
            ]
        );

    }


    public function actionBanned()
    {
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

            Yii::$app->db->createCommand()->update('user', ['banned' => 1, 'banned_text' => $data["banText"]], ['id' => $data["banId"]])->execute();

            return array('banned' => true);

        }

    }

    public function actionHistory(){
        $user = User::findOne(['id' => Yii::$app->user->id]);
        if($user->banned)
        {
            return $this->redirect(['site/banned']);
        }
        Settings::setLocation('История');
        Yii::$app->db->createCommand()->update('user', ['last_visited' => time()], ['id' => Yii::$app->user->id])->execute();

        $referers = User::find()->select(['id', 'username'])->where(['ref_id' => Yii::$app->user->id])->asArray()->all();//чуваки которых я пригласил

        $myReferers = [];
        $myRefs = '';
        for($i = 0; $i< count($referers); $i++){
            $myReferers[] = $referers[$i]['username'];
            $myRefs .= "'".$referers[$i]['username']."'".',';
        }
        $purchaseHistory = PurchaseHistory::find()->select(['username', 'count_price', 'count_product', 'comment', 'time_buy'])->where(['username'=>$myReferers])->groupBy('username');
        $countQuery = clone $purchaseHistory;
        $allSum = PurchaseHistory::find()->where(['username'=>$myReferers])->sum('count_price');
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => 30]);
        $pages->pageSizeParam = false;
        $items = $purchaseHistory->offset($pages->offset)
            ->orderBy(['time_buy' => SORT_DESC])
            ->limit($pages->limit)
            ->all();

        return $this->render('history', compact('items', 'pages','allSum'));
    }
    public function actionMyHistory(){
        $user = User::findOne(['id' => Yii::$app->user->id]);
        if($user->banned)
        {
            return $this->redirect(['site/banned']);
        }
        $myPurchaseHistory = MyPurchaseHistory::find()->select(['count_price', 'count_product', 'comment'])->where(['user_id'=>Yii::$app->user->id])->all();
        $allSum = Yii::$app->db->createCommand("SELECT sum(count_price) FROM my_purchase_history WHERE user_id = ".Yii::$app->user->id)->queryScalar();
        return $this->render('myhistory', compact('myPurchaseHistory','allSum'));
    }
    public function actionLoginHistory(){
        $user = User::findOne(['id' => Yii::$app->user->id]);
        if($user->banned)
        {
            return $this->redirect(['site/banned']);
        }
        $loginHistory = LoginHistory::find()->where(['user_id'=>Yii::$app->user->id])->orderBy(['login_date' => SORT_DESC])->all();

        return $this->render('loginhistory', compact('loginHistory'));
    }
}
