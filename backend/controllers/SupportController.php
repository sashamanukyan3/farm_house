<?php

namespace backend\controllers;

use Yii;
use common\models\Support;
use common\models\search\SupportSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SupportController implements the CRUD actions for Support model.
 */
class SupportController extends Controller
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
     * Lists all Support models.
     * @return mixed
     */
    public function actionIndex()
    {

        if (\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $searchModel = new SupportSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Support model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {

        if (\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Support model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {

        if (\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new Support();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Support model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {

        if (\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        Yii::$app->controller->enableCsrfValidation = false;
        $supportControl = Support::findOne($id);
        if($supportControl){

            $model = new Support();
            $replyList = Support::find()->where(['reply' => $id])->all();

            if(Yii::$app->request->post()){

                Yii::$app->db->createCommand()->update('support', ['status' => Support::STATUS_REPLY], ['reply' => $id])->execute();
                $supportControl->status = Support::STATUS_REPLY;
                $supportControl->save();
                $data = Yii::$app->request->post();

                $model->reply = $id;
                $model->message = $data["message"];
                $model->to = $supportControl->from;
                $model->from = Yii::$app->user->identity->id;
                $model->date = time();
                $model->user_viewed = Support::STATUS_USER_UNVIEWED;
                $model->status = Support::STATUS_REPLY;

                if($model->save()){
                    return $this->redirect(['update', 'id' => $id]);
                }
            }

            return $this->render('update', [
                'model' => $model,
                'supportControl' => $supportControl,
                'replyList' => $replyList,
            ]);

        }else{
            return $this->redirect(['index']);
        }
    }

    public function actionClosed(){
        if (\Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        if (Yii::$app->request->isAjax) {

            $data = Yii::$app->request->post();
            if(!empty($data)) {
                Yii::$app->response->format = 'json';

                $id = $data['id'];
                $supportControl = Support::findOne($id);
                if($supportControl){
                    Yii::$app->db->createCommand()->update('support', ['status' => Support::STATUS_CLOSED], ['id' => $id])->execute();
                    return array('status' => true);
                }
            }
        }
    }

    public function actionOpen(){
        if (\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();
            if(!empty($data)) {
                Yii::$app->response->format = 'json';

                $id = $data['id'];
                $supportControl = Support::findOne($id);
                if($supportControl){
                    Yii::$app->db->createCommand()->update('support', ['status' => Support::STATUS_OPEN], ['id' => $id])->execute();
                    return array('status' => true);
                }
            }
        }
    }

    /**
     * Deletes an existing Support model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        Yii::$app->controller->enableCsrfValidation = false;
        if (\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Support model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Support the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Support::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
