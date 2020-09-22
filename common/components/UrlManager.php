<?php

namespace common\components;

use Yii;

class UrlManager extends \yii\web\UrlManager
{
    public function createUrl($params)
    {
        $url = parent::createUrl($params);

        if (empty($params['lang'])) {
            $currentLang = Yii::$app->language;

            if ($url == '/') {
                return "/$currentLang";
            } else {
                return "/$currentLang$url";
            }
        };

        return $url;
    }
}
