<?php
namespace frontend\controllers;

use common\models\Attachments;
use common\models\Charity;
use common\models\CharityUsers;
use common\models\Faq;
use common\models\Instruction;
use common\models\News;
use common\models\NewsCommentLike;
use common\models\NewsComments;
use common\models\Reviews;
use common\models\Settings;
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

/**
 * Site controller
 */
class CharityController extends Controller
{

    public function actionList()
    {

        Settings::setLocation('Благотворительность');

        if (!Yii::$app->user->isGuest) {
            Yii::$app->db->createCommand()->update('user', ['location' => 'Благотворительность', 'last_visited' => time()], ['id' => \Yii::$app->user->identity->id])->execute();
        }

        $charity = Charity::find()->orderBy(["id" => SORT_DESC])->all();

        return $this->render('list', [
            'charity' => $charity,
        ]);
    }

    public function actionView($id)
    {

        $id = (int)$id;
        if(!$id || $id==0)
        {
            throw new NotFoundHttpException;
        }

        Settings::setLocation('Благотворительность');

        Yii::$app->db->createCommand()->update('user', ['location' => 'Благотворительность', 'last_visited' => time()], ['id' => \Yii::$app->user->identity->id])->execute();

        $charity = Charity::find()->where(['id' => $id])->one();
        if(!$charity)
        {
            throw new NotFoundHttpException(Yii::t('app', 'Данная страница удалена или временно отключена. Приносим свои извенения'));
        }
        $charityUsers = CharityUsers::find()->where(['charity_id' => $id])->orderBy(['date' => SORT_DESC])->all();
        $charityTop = CharityUsers::find()->where(['charity_id' => $id])->orderBy(['summ' => SORT_DESC])->limit(10)->all();

        return $this->render('view', [
            'charity' => $charity,
            'charityUsers' => $charityUsers,
            'charityTop' => $charityTop
        ]);
    }

}
