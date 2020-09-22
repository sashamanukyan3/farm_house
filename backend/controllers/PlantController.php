<?php

namespace backend\controllers;

use Yii;
use common\models\Plant;
use common\models\search\PlantSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
/**
 * PlantController implements the CRUD actions for Plant model.
 */
class PlantController extends Controller
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
     * Lists all Plant models.
     * @return mixed
     */
    public function actionIndex()
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $searchModel = new PlantSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Plant model.
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

    protected function saveImage($img)
    {
        $file_name = md5(time().$img->baseName);
        $img->saveAs($this->getImagePath().$file_name.'.'.$img->extension);
        return $file_name.'.'.$img->extension;
    }

    protected function getImagePath()
    {
        return Yii::getAlias('@frontend').'/web/uploads/plant/';
    }

    /**
     * Updates an existing Plant model.
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

        $img1  = $model->img1;
        $img2  = $model->img2;
        $img3  = $model->img3;
        $img4  = $model->img4;

        if ($model->load(Yii::$app->request->post())) {
            $path = $this->getImagePath();
            if(!empty($_FILES['Plant']['name']['img1'])){
                $model->img1 = UploadedFile::getInstance($model,'img1');
                if ($model->img1 && $model->validate()){
                    $file_name1 = md5(time().$model->img1->baseName);
                    $model->img1 -> saveAs($path.$file_name1.'.'.$model->img1->extension);
                    $model->img1 = $file_name1.'.'.$model->img1->extension;
                }
            }
            else{
                $model->img1 = $img1;
            }
            if(!empty($_FILES['Plant']['name']['img2'])){
                $model->img2 = UploadedFile::getInstance($model,'img2');
                if ($model->img2 && $model->validate()){
                    $file_name1 = md5(time().$model->img2->baseName);
                    $model->img2 -> saveAs($path.$file_name1.'.'.$model->img2->extension);
                    $model->img2 = $file_name1.'.'.$model->img2->extension;
                }
            }
            else{
                $model->img2 = $img2;
            }
            if(!empty($_FILES['Plant']['name']['img3'])){
                $model->img3 = UploadedFile::getInstance($model,'img3');
                if ($model->img3 && $model->validate()){
                    $file_name1 = md5(time().$model->img3->baseName);
                    $model->img3 -> saveAs($path.$file_name1.'.'.$model->img3->extension);
                    $model->img3 = $file_name1.'.'.$model->img3->extension;
                }
            }
            else{
                $model->img3 = $img3;
            }
            if(!empty($_FILES['Plant']['name']['img4'])){
                $model->img4 = UploadedFile::getInstance($model,'img4');
                if ($model->img4 && $model->validate()){
                    $file_name1 = md5(time().$model->img4->baseName);
                    $model->img4 -> saveAs($path.$file_name1.'.'.$model->img4->extension);
                    $model->img4 = $file_name1.'.'.$model->img4->extension;
                }
            }
            else{
                $model->img4 = $img4;
            }

            $model->save();

            return $this->redirect(['view', 'id' => $model->plant_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Plant model.
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
     * Finds the Plant model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Plant the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Plant::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
