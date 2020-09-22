<?php

namespace backend\controllers;

use Yii;


class FileUploadController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function beforeAction($action) {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    public function actionUpload()
    {
        $path = Yii::getAlias('@frontend') .'/web/uploads';
        $file = md5(date('YmdHis')).'.'.pathinfo(@$_FILES['file']['name'], PATHINFO_EXTENSION);
        $prePath =  substr($file, 0, 5);
        $uploadDir = 'https://ferma.ru/uploads';
        $tempPath = '';
        for($i=0; $i<5; $i++)
        {
            $tempPath .=  '/'.$prePath[$i];
        }

        if (!file_exists($path.$tempPath)) {
            mkdir($path.$tempPath, 0775, true);
        }

        if (move_uploaded_file(@$_FILES['file']['tmp_name'], $path.$tempPath.$file)) {
            $array = array(
                'filelink' => $uploadDir.$tempPath.$file

            );
        }
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $array;
    }
}
