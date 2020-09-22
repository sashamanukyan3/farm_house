<?php
namespace frontend\controllers;

use common\models\Attachments;
use common\models\Faq;
use common\models\Instruction;
use common\models\Mails;
use common\models\Message;
use common\models\News;
use common\models\NewsCommentLike;
use common\models\NewsComments;
use common\models\NewsLike;
use common\models\Reviews;
use common\models\search\PayInSearch;
use common\models\Session;
use common\models\Settings;
use common\models\Support;
use common\models\User;
use common\models\WallComments;
use vova07\imperavi\actions\GetAction;
use Yii;
use yii\base\InvalidParamException;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use common\models\UsersNews;
use yii\helpers\Url;
/**
 * Site controller
 */
class NewsController extends Controller
{

    public function actionIndex()
    {
        $this->view->params['breadcrumbs'] = [
            ['label' => Yii::t('app', 'Новости'), 'url' => null],
        ];
        Settings::setLocation('Список новостей');
        $query = News::find()
            ->select('news.id, news.title, news.teaser, news.title_en, news.teaser_en, news.created_at, COUNT(news_comments.id) as comments_count')
            ->leftJoin('news_comments','news.id = news_comments.news_id')
            ->groupBy('news.id')
            ->where(['news.is_active'=> 1])
            ->orderBy(['news.created_at'=>SORT_DESC]);
        UsersNews::deleteAll(['user_id'=>Yii::$app->user->id]);
        $blogDataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 8,
            ],
        ]);

        return $this->render('index', [
            'blogDataProvider' => $blogDataProvider,
        ]);

    }

    public function actionView($id)
    {
        $id = (int)$id;
        if(!$id || $id==0)
        {
            throw new NotFoundHttpException;
        }

        Settings::setLocation('Новости');

        if (\Yii::$app->user->isGuest) {

        }
        else
        {
            UsersNews::deleteAll(['news_id'=>$id, 'user_id'=>Yii::$app->user->id]);
            Yii::$app->db->createCommand()->update('user', ['last_visited' => time()], ['id' => \Yii::$app->user->identity->id])->execute();
        }

        $user = User::findOne(['id' => Yii::$app->user->id]);

        $news = News::find()->where(['is_active' => 1, 'id' => $id])->all();

        $model = new NewsComments();

        $comment_list = NewsComments::find()->where(['news_id' => $id])->orderBy(['id' => SORT_ASC])->all();
        $this->view->params['breadcrumbs'] = [
            ['label' => Yii::t('app', 'Новости'), 'url' => Url::toRoute('/news')],
            ['label' => $news[0]->title, 'url' => null],
        ];

        return $this->render('view', [
            'news' => $news,
            'model' => $model,
            'comment_list' => $comment_list,
            'user' => $user,
        ]);

    }

    public function actionViewajax()
    {
        if (Yii::$app->request->isAjax) {

            $data = Yii::$app->request->post();
            $user = User::findOne(['id' => Yii::$app->user->id]);
            if($user->banned)
            {
                return $this->redirect(['site/banned']);
            }
            if($data["type"] == 1){

                Yii::$app->response->format = 'json';

                $text = $data['text'];
                $news_id = $data['news_id'];
                $level = $user->level;
                $user_id = Yii::$app->user->id;

                if($level < Settings::$newsViewLevel){
                    return array('newsComment' => false, 'msg' => Yii::t('app', 'Недостаточно уровня') . '!');
                }else{
                    $comments = new NewsComments();
                    $comments->news_id = $news_id;
                    $comments->text = $text;
                    $comments->user_id = $user_id;
                    $comments->date = time();

                    $energyControl = $user;
                    if($energyControl->energy > 9){
                        $comments->save();
                        $comment_count = NewsComments::find()->where(['news_id' => $news_id])->count();
                        $energyControl->updateCounters(['energy' => -(Settings::$energyCommentForNews)]);
                        return array('newsComment' => true, 'msg'=>Yii::t('app', 'Письмо отправлено') . '!', 'commentID' => $comments->id, 'comment_count' => $comment_count, 'date' => date("Y-m-d H:i:s", $comments->date));
                    }else{
                        return array('newsComment' => false, 'msg' => Yii::t('app', 'Недостаточно энергии') . '!');
                    }
                }

            }

        }

    }

    public function actionAjax()
    {
        if (Yii::$app->request->isAjax) {

            $data = Yii::$app->request->post();
            $user = User::findOne(['id'=>Yii::$app->user->id]);
            if($user->banned)
            {
                return $this->redirect(['site/banned']);
            }
            if($data["type"] == 1){

                Yii::$app->response->format = 'json';

                $userID = $data['userID'];
                $commentID = $data['commentID'];
                $level = $user->level;

                $like = new NewsCommentLike();

                $like->user_id = $userID;
                $like->comment_id = $commentID;
                $like->type = 1;

                $comment = NewsComments::findOne($commentID);

                $energyControl = User::find()->where(['id' => $userID])->one();

                $LikeControl = NewsCommentLike::find()->where(['user_id' => $userID, 'comment_id' => $commentID, 'type' => 1])->all();
                if($LikeControl) {

                    $comment->updateCounters(['like_count' => -1]);

                    $likeDelete = NewsCommentLike::find()->where(['user_id' => $userID, 'comment_id' => $commentID, 'type' => 1])->one();
                    Yii::$app->db->createCommand()->delete('news_comment_like', ['id' => $likeDelete->id])->execute();

                    return array('newsLike' => true, 'like_count' => $comment->like_count, 'dislike_count' => $comment->dislike_count);

                }else{

                    if($level < Settings::$newsViewLevel){
                        return array('newsLike' => false, 'msg'=>Yii::t('app', 'Недостаточно уровня'));
                    }else{

                        $energyControl = User::find()->where(['id' => $userID])->one();
                        if($energyControl->energy > 9){

                            $DisLikeControl = NewsCommentLike::find()->where(['user_id' => $userID, 'comment_id' => $commentID, 'type' => 2])->one();
                            $like->save();
                            $energyControl->updateCounters(['energy' => -(Settings::$likeDislike)]);
                            $comment->updateCounters(['like_count' => 1]);
                            if($DisLikeControl){
                                Yii::$app->db->createCommand()->delete('news_comment_like', ['id' => $DisLikeControl->id])->execute();
                                $comment->updateCounters(['dislike_count' => -1]);
                                return array('newsLike' => true, 'dislike_count' => $comment->dislike_count, 'like_count' => $comment->like_count);
                            }
                            return array('newsLike' => true, 'like_count' => $comment->like_count, 'dislike_count' => $comment->dislike_count);

                        }else{
                            return array('newsLike' => false, 'msg'=>Yii::t('app', 'Недостаточно энергии'));
                        }

                    }

                }

            }elseif($data["type"] == 2){

                Yii::$app->response->format = 'json';

                $userID = $data['userID'];
                $commentID = $data['commentID'];
                $level = $user->level;

                $like = new NewsCommentLike();

                $like->user_id = $userID;
                $like->comment_id = $commentID;
                $like->type = 2;

                $energyControl = $user;

                $comment = NewsComments::findOne($commentID);

                $DisLikeControl = NewsCommentLike::find()->where(['user_id' => $userID, 'comment_id' => $commentID, 'type' => 2])->all();
                if($DisLikeControl) {

                    $comment->updateCounters(['dislike_count' => -1]);

                    $dislikeDelete = NewsCommentLike::find()->where(['user_id' => $userID, 'comment_id' => $commentID, 'type' => 2])->one();
                    Yii::$app->db->createCommand()->delete('news_comment_like', ['id' => $dislikeDelete->id])->execute();

                    return array('newsDisLike' => true, 'like_count' => $comment->like_count, 'dislike_count' => $comment->dislike_count);

                }else{

                    if($level < Settings::$newsViewLevel){
                        return array('newsDisLike' => false, 'msg'=>Yii::t('app', 'Недостаточно уровня'));
                    }else{

                        if($energyControl->energy > 9){
                            $LikeControl = NewsCommentLike::find()->where(['user_id' => $userID, 'comment_id' => $commentID, 'type' => 1])->one();
                            $like->save();
                            $energyControl->updateCounters(['energy' => -(Settings::$likeDislike)]);
                            $comment->updateCounters(['dislike_count' => 1]);
                            if($LikeControl){
                                Yii::$app->db->createCommand()->delete('news_comment_like', ['id' => $LikeControl->id])->execute();
                                $comment->updateCounters(['like_count' => -1]);
                                return array('newsDisLike' => true, 'like_count' => $comment->like_count, 'dislike_count' => $comment->dislike_count);
                            }
                            return array('newsDisLike' => true, 'dislike_count' => $comment->dislike_count, 'like_count' => $comment->like_count,);
                        }else{
                            return array('newsDisLike' => false, 'msg'=>Yii::t('app', 'Недостаточно энергии'));
                        }
                    }

                }

            }

        }

    }

    public function actionAjaxlike()
    {
        if (Yii::$app->request->isAjax) {

            $data = Yii::$app->request->post();
            $user = User::findOne(['id'=>Yii::$app->user->id]);
            if($user->banned)
            {
                return $this->redirect(['site/banned']);
            }
            if($data["type"] == 10){

                Yii::$app->response->format = 'json';

                $userID = $data['userID'];
                $newsID = $data['newsID'];
                $level = $user->level;

                $like = new NewsLike();

                $like->user_id = $userID;
                $like->news_id = $newsID;
                $like->type = 1;

                $news = News::findOne($newsID);

                $energyControl = $user;

                $LikeControl = NewsLike::find()->where(['user_id' => $userID, 'news_id' => $newsID, 'type' => 1])->all();
                if($LikeControl) {

                    $news->updateCounters(['news_like_count' => -1]);

                    $likeDelete = NewsLike::find()->where(['user_id' => $userID, 'news_id' => $newsID, 'type' => 1])->one();
                    Yii::$app->db->createCommand()->delete('news_like', ['id' => $likeDelete->id])->execute();

                    return array('newsLike' => true, 'news_like_count' => $news->news_like_count, 'news_dislike_count' => $news->news_dislike_count);

                }else{

                    if($level < Settings::$newsViewLevel){
                        return array('newsLike' => false, 'msg'=>Yii::t('app', 'Недостаточно уровня'));
                    }else{

                        $energyControl = $user;
                        if($energyControl->energy > 9){

                            $DisLikeControl = NewsLike::find()->where(['user_id' => $userID, 'news_id' => $newsID, 'type' => 2])->one();
                            $like->save();
                            $energyControl->updateCounters(['energy' => -(Settings::$likeDislike)]);
                            $news->updateCounters(['news_like_count' => 1]);
                            if($DisLikeControl){
                                Yii::$app->db->createCommand()->delete('news_like', ['id' => $DisLikeControl->id])->execute();
                                $news->updateCounters(['news_dislike_count' => -1]);
                                return array('newsLike' => true, 'news_dislike_count' => $news->news_dislike_count, 'news_like_count' => $news->news_like_count);
                            }
                            return array('newsLike' => true, 'news_like_count' => $news->news_like_count, 'news_dislike_count' => $news->news_dislike_count);

                        }else{
                            return array('newsLike' => false, 'msg'=>Yii::t('app', 'Недостаточно энергии'));
                        }
                    }
                }

            }elseif($data["type"] == 11){

                Yii::$app->response->format = 'json';

                $userID = $data['userID'];
                $newsID = $data['newsID'];
                $level = $user->level;

                $like = new NewsLike();

                $like->user_id = $userID;
                $like->news_id = $newsID;
                $like->type = 2;

                $energyControl = $user;

                $news = News::findOne($newsID);

                $DisLikeControl = NewsLike::find()->where(['user_id' => $userID, 'news_id' => $newsID, 'type' => 2])->all();
                if($DisLikeControl) {

                    $news->updateCounters(['news_dislike_count' => -1]);

                    $dislikeDelete = NewsLike::find()->where(['user_id' => $userID, 'news_id' => $newsID, 'type' => 2])->one();
                    Yii::$app->db->createCommand()->delete('news_like', ['id' => $dislikeDelete->id])->execute();

                    return array('newsDisLike' => true, 'news_like_count' => $news->news_like_count, 'news_dislike_count' => $news->news_dislike_count);

                }else{

                    if($level < Settings::$newsViewLevel){
                        return array('newsDisLike' => false, 'msg'=>Yii::t('app', 'Недостаточно уровня'));
                    }else{

                        if($energyControl->energy > 9){
                            $LikeControl = NewsLike::find()->where(['user_id' => $userID, 'news_id' => $newsID, 'type' => 1])->one();
                            $like->save();
                            $energyControl->updateCounters(['energy' => -(Settings::$likeDislike)]);
                            $news->updateCounters(['news_dislike_count' => 1]);
                            if($LikeControl){
                                Yii::$app->db->createCommand()->delete('news_like', ['id' => $LikeControl->id])->execute();
                                $news->updateCounters(['news_like_count' => -1]);
                                return array('newsDisLike' => true, 'news_like_count' => $news->news_like_count, 'news_dislike_count' => $news->news_dislike_count);
                            }
                            return array('newsDisLike' => true, 'news_dislike_count' => $news->news_dislike_count, 'news_like_count' => $news->news_like_count);
                        }else{
                            return array('newsDisLike' => false, 'msg'=>Yii::t('app', 'Недостаточно энергии'));
                        }
                    }

                }

            }

        }

    }

    public function actionGetNotify()
    {
        if (Yii::$app->user->isGuest) {
            Yii::$app->response->format = 'json';
            return ['status'=>false];
        }
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = 'json';
            $newsIds = UsersNews::find()->select('news_id')->where(['user_id'=>Yii::$app->user->id])->all();
            if($newsIds)
            {
                $ids = [];
                foreach($newsIds as $nIds)
                {
                    $ids[] = $nIds->news_id;
                }
                $news_count = News::find()->where(['id'=>$ids])->count();
                return ['status'=>true, 'title'=>Yii::t('app', 'Новости') . ': ', 'url'=>Url::toRoute('/news/index'), 'msg'=>Yii::t('app', 'Количество непрочитанных новостей').': '.$news_count];
            }
            return ['status'=>false];
        }
        else
        {
            throw new NotFoundHttpException;
        }
    }

    public function actionNotifyMail()
    {
        if (Yii::$app->user->isGuest) {
            Yii::$app->response->format = 'json';
            return ['status'=>false];
        }
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = 'json';
            $unreadedMails = Mails::find()->select('mail_id')->where(['to'=>Yii::$app->user->identity->username,'status'=>0])->count();
            if($unreadedMails)
            {
                return ['status'=>true, 'title'=>Yii::t('app', 'Почта') . ': ', 'url'=>Url::toRoute('/mails/in/'), 'msg'=>Yii::t('app', 'Количество непрочитанных писем').': '.$unreadedMails];
            }
            return ['status'=>false];
        }
        else
        {
            throw new NotFoundHttpException;
        }
    }

    public function actionNotifyMessage()
    {
        if (Yii::$app->user->isGuest) {
            Yii::$app->response->format = 'json';
            return ['status'=>false];
        }
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = 'json';
            $unreadedMsgs = Message::find()->select('id')->where(['to_id'=>Yii::$app->user->id,'viewed'=>0])->count();
            if($unreadedMsgs)
            {
                return ['status'=>true, 'title'=>Yii::t('app', 'Чат') . ': ', 'url'=>Url::toRoute('/message/index'), 'msg'=>Yii::t('app', 'Количество непрочитанных смс').': '.$unreadedMsgs];
            }
            return ['status'=>false];
        }
        else
        {
            throw new NotFoundHttpException;
        }
    }

    public function actionNotifySupport()
    {
        if (Yii::$app->user->isGuest) {
            Yii::$app->response->format = 'json';
            return ['status'=>false];
        }

        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = 'json';
            //if user is admin

            $unreadedMsgs = false;
            if(Yii::$app->user->identity->role == 1)
            {
                $unreadedMsgs = Support::find()->select('id')->where(['status'=>1,'to'=>1,'reply'=>0])->count();
                if($unreadedMsgs)
                {
                    return ['status'=>true, 'title'=>Yii::t('app', 'Тех. Поддержка') . ': ', 'url'=>Url::toRoute('/raimin/support'), 'msg'=>Yii::t('app', 'Количество открытых тикетов').': '.$unreadedMsgs];
                }
            }
            else
            {
                $unreadedMsgs = Support::find()->select('id')->where(['from'=>Yii::$app->user->id,'status'=>3,'user_viewed'=>0,'reply'=>0])->count();
                if($unreadedMsgs)
                {
                    return ['status'=>true, 'title'=>Yii::t('app', 'Тех. Поддержка') . ': ', 'url'=>Url::toRoute('/support/out'), 'msg'=>Yii::t('app', 'Количество новых отвеченных тикетов').': '.$unreadedMsgs];
                }
            }
            return ['status'=>false];
        }
        else
        {
            throw new NotFoundHttpException;
        }
    }
}
