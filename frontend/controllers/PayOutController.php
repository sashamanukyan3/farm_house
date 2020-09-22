<?php

namespace backend\controllers;

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

    /**
     * Lists all PayOut models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PayOutSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionList()
    {
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
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
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
        if (($model = PayOut::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionCancel($id)
    {
        $model = $this->findModel($id);
        $model->status_id = PayOut::STATUS_CANCELED;
        $user = User::findOne(['username'=>$model->username]);
        $user->for_pay += $model->amount;
        $user->save();
        $model->created_at = time();
        $model->save();
        Yii::$app->getSession()->setFlash('pay_out_cancel', Yii::t('app', 'Запрос отклонен'));
        return $this->redirect(['index']);
    }

    public function actionAccept($id)
    {
        $model = $this->findModel($id);
        $model->status_id = PayOut::STATUS_CONFIRMED;
        $model->save();
        Yii::$app->getSession()->setFlash('pay_out_ok', Yii::t('app', 'Запрос принят'));
        return $this->redirect(['index']);
    }
}
