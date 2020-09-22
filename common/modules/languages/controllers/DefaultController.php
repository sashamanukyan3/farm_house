<?php

namespace common\modules\languages\controllers;

use Yii;
use yii\web\Controller;
use common\modules\languages\models\LanguageKsl;

class DefaultController extends Controller
{
    public function actionIndex()
    {
        $language = Yii::$app->request->get('lang');

        $urlReferrer = Yii::$app->request->get('url');

        if(!$urlReferrer) {
            $urlReferrer = Yii::$app->request->referrer;
        }

        if (!$urlReferrer) {
            $urlReferrer = Yii::$app->request->hostInfo . '/'. $language;
        }

        $url = LanguageKsl::parsingUrl($language, $urlReferrer);
        Yii::$app->response->redirect($url);
    }
}
