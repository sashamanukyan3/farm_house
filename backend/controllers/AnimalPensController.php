<?php

namespace backend\controllers;

use Yii;
use common\models\AnimalPens;
use common\models\search\AnimalPensSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * AnimalPensController implements the CRUD actions for AnimalPens model.
 */
class AnimalPensController extends Controller
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
     * Lists all AnimalPens models.
     * @return mixed
     */
    public function actionIndex()
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $searchModel = new AnimalPensSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AnimalPens model.
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
     * Creates a new AnimalPens model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
 /*   public function actionCreate()
    {
        $model = new AnimalPens();

        if ($model->load(Yii::$app->request->post())) {
            $model->img = UploadedFile::getInstance($model, 'img');
            if ($model->img && $model->validate()){
                $model->img->saveAs(Yii::getAlias('@frontend').'/web/img/building/'.$model->img->baseName.'.'.$model->img->extension);
                $model->img = $model->img->baseName.'.'.$model->img->extension;
            }
            $model->save();
            return $this->redirect(['view', 'id' => $model->animal_pens_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }*/

    /**
     * Updates an existing AnimalPens model.
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
        $img = $model->img;

        if ($model->load(Yii::$app->request->post())) {
            //echo '<pre>'; var_dump(Yii::$app->urlManagerFrontend->baseUrl); die();
            if(!empty($_FILES['AnimalPens']['name']['img'])) {

                $model->img = UploadedFile::getInstance($model, 'img');
                if ($model->img && $model->validate()){
                    $model->img->saveAs(Yii::getAlias('@frontend').'/web/img/building/'.$model->img->baseName.'.'.$model->img->extension);
                    $model->img = $model->img->baseName.'.'.$model->img->extension;
                }
                $model->save();
                return $this->redirect(['view', 'id' => $model->animal_pens_id]);
            }else {
                $model->img = $img;
                $model->save();
                return $this->redirect(['view', 'id' => $model->animal_pens_id]);
            }
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing AnimalPens model.
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
     * Finds the AnimalPens model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AnimalPens the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AnimalPens::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
