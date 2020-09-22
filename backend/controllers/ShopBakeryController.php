<?php

namespace backend\controllers;

use Yii;
use common\models\ShopBakery;
use common\models\search\ShopBakerySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * ShopBakeryController implements the CRUD actions for ShopBakery model.
 */
class ShopBakeryController extends Controller
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
     * Lists all ShopBakery models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ShopBakerySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ShopBakery model.
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
     * Creates a new ShopBakery model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ShopBakery();

        if ($model->load(Yii::$app->request->post())) {
            $model->img = UploadedFile::getInstance($model, 'img');
            if ($model->img && $model->validate()){
                $model->img->saveAs(Yii::getAlias('@frontend').'/web/img/product/'.$model->img->baseName.'.'.$model->img->extension);
                $model->img = $model->img->baseName.'.'.$model->img->extension;
            }
            $model->save();
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing ShopBakery model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $img = $model->img;

        if ($model->load(Yii::$app->request->post())) {
            if(!empty($_FILES['ShopBakery']['name']['img'])) {

                $model->img = UploadedFile::getInstance($model, 'img');
                if ($model->img && $model->validate()){
                    $model->img->saveAs(Yii::getAlias('@frontend').'/web/img/product/'.$model->img->baseName.'.'.$model->img->extension);
                    $model->img = $model->img->baseName.'.'.$model->img->extension;
                }
                $model->save();
                return $this->redirect(['view', 'id' => $model->id]);
            }else {
                $model->img = $img;
                $model->save();
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing ShopBakery model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the ShopBakery model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ShopBakery the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ShopBakery::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
