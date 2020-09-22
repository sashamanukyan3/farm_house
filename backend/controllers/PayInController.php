<?php

namespace backend\controllers;

use common\models\PurchaseHistory;
use common\models\User;
use Yii;
use common\models\PayIn;
use common\models\search\PayInSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PayInController implements the CRUD actions for PayIn model.
 */
class PayInController extends Controller
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
     * Lists all PayIn models.
     * @return mixed
     */
    public function actionIndex()
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $searchModel = new PayInSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PayIn model.
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
     * Creates a new PayIn model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $model = new PayIn();

        if ($model->load(Yii::$app->request->post())) {
            $username = Yii::$app->request->post('PayIn')['username'];
            $refAmount = (Yii::$app->request->post('PayIn')['amount']) * 0.1;
            $user = User::find()->where(['username'=>$username])->one();
            if(is_object($user)){
                $user->for_pay += Yii::$app->request->post('PayIn')['amount'];
                $user->ref_for_out += $refAmount;
                if($user->ref_id){ // если есть реферал то рисуем 10% от введенной суммы
                    $ref = User::find()->where(['id' => $user->ref_id])->one();
                    $ref->for_out += $refAmount;
                    $ref->save();

                    $purchase = PurchaseHistory::find()->where(['username' => $username])->andWhere(['alias' => 'chicken'])->one();
                    $purchase->time_buy = time();
                    $purchase->count_price += $refAmount;
                    $purchase->save();
                }
                $user->save();
                $model->created = time();
                $model->complete = 1;
                $model->save();
                return $this->redirect(['view', 'id' => $model->id]);
            }else {
                return $this->render('create', [
                    'model' => $model,
                    'msg' => 'Пользователь с таким логином не найден!'
                ]);
            }
        } else {
            return $this->render('create', [
                'model' => $model,
                'msg' => '',
            ]);
        }
    }

    /**
     * Updates an existing PayIn model.
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

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing PayIn model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the PayIn model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PayIn the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PayIn::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
