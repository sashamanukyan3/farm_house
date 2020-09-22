<?php

namespace backend\controllers;

use common\models\PayIn;
use Yii;
use common\models\PayOut;
use common\models\PayOutSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\User;

/**
 * PayOutController implements the CRUD actions for PayOut model.
 */
class PayOutController extends Controller
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

    public function beforeAction($action) {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    /**
     * Lists all PayOut models.
     * @return mixed
     */
    public function actionIndex()
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $searchModel = new PayOutSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionList()
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $searchModel = new PayOutSearch();
        $dataProvider = $searchModel->searchList(Yii::$app->request->queryParams);

        return $this->render('list', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PayOut model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Updates an existing PayOut model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            Yii::$app->controller->enableCsrfValidation = false;
            //echo '<pre>'; var_dump($model); die();
            $user = User::findOne(['username'=>$model->username]);
            $user->for_pay += $model->amount;
            $model->created_at = time();
            $user->save();
            $model->save();
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Finds the PayOut model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PayOut the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        if (($model = PayOut::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionCancel($id)
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $model = $this->findModel($id);
        $model->status_id = PayOut::STATUS_CANCELED;
        $user = User::findOne(['username'=>$model->username]);
        $user->for_pay += $model->amount;
        $user->save();
        $model->created_at = time();
        $model->save();
        Yii::$app->getSession()->setFlash('pay_out_cancel', 'Запрос отклонен');
        return $this->redirect(['index']);
    }

    public function actionAccept($id)
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $model = $this->findModel($id);
        $model->status_id = PayOut::STATUS_CONFIRMED;
        $model->created_at = time();
        $model->save();
        Yii::$app->getSession()->setFlash('pay_out_ok', 'Запрос принят');
        return $this->redirect(['index']);
    }

    public function actionStat()
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $payIn = PayIn::find()->select('created,amount')
            ->where(['>', 'created', strtotime('last month')])
            ->andWhere(['complete'=>1])
            ->orderBy(['created' => SORT_ASC])
            ->asArray()
            ->all();

        $payOut = PayOut::find()->select('amount, created_at')
            ->where(['>', 'created_at', strtotime('last month')])
            ->andWhere(['status_id'=>PayOut::STATUS_CONFIRMED])
            ->orderBy(['created_at' => SORT_ASC])
            ->asArray()
            ->all();

        return $this->render('stat',compact('payIn','payOut'));
    }

    public function actionOutList()
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $searchModel = new PayOutSearch();
        $dataProvider = $searchModel->searchOutedList(Yii::$app->request->queryParams);

        return $this->render('out-list', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
}
