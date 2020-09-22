<?php
namespace frontend\controllers;

use common\models\Reviews;
use common\models\Settings;
use common\models\User;
use common\widgets\Alert;
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

/**
 * Site controller
 */
class ReviewsController extends Controller
{

    public function actionIndex()
    {
        Settings::setLocation('Отзывы');

        if (Yii::$app->user->isGuest) {
            $user = false;
        }else{
            $user = User::findOne(['id' => Yii::$app->user->identity->id]);
            if($user->banned)
            {
                return $this->redirect(['site/banned']);
            }
            Yii::$app->db->createCommand()->update('user', ['last_visited' => time()], ['id' => \Yii::$app->user->identity->id])->execute();
        }

        $query = Reviews::find();
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => Settings::$pagerReviews]);

        $pages->pageSizeParam = false;
        $reviews = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->orderBy(['id' => SORT_DESC])
            ->all();
        $model = new Reviews();

        return $this->render('index', [
                'reviews' => $reviews,
                'model' => $model,
                'pages'=>$pages,
                'user' => $user
            ]
        );
    }

    public function actionSend(){

        if (\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $user = User::findOne(['id' => Yii::$app->user->identity->id]);
        if($user->banned)
        {
            return $this->redirect(['site/banned']);
        }
        if (Yii::$app->request->isAjax) {

            Yii::$app->response->format = 'json';
            $level = $user->level;
            $data = Yii::$app->request->post();

            if($level >= Settings::$levelReviews){
                $model = new Reviews();
                $user_id = Yii::$app->user->id;

                $reviews_control = Reviews::findOne(['user_id' => $user_id]);

                if ($reviews_control) {
                    return array('result' => false, 'reviews' => Yii::t('app', 'Отзыв можно оставить только 1 раз'));
                } else {
                    $content = $data['content'];

                    $model->content = $content;
                    $model->user_id = $user_id;
                    $model->is_active = 1;
                    $model->date = time();
                    if ($model->save()) {
                        $reviewsControl = Reviews::find()->where(['user_id' => $user_id])->limit(1)->orderBy(['id' => SORT_DESC])->one();
                        return array('result' => true, 'date' => date('Y:m:d H:i:s',$reviewsControl->date), 'content' => $reviewsControl->content, 'msg'=>'Письмо отправлено!');
                    } else {
                        return array('result' => false, 'reviews'=>'Fatal Error!');
                    }
                }

            }else{
                return array('result' => false, 'reviews' => Yii::t('app', 'Недостаточно уровня'));
            }

        }else{

            throw new \yii\web\NotFoundHttpException();
        }

    }
}
