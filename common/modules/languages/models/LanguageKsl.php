<?php

namespace common\modules\languages\models;

use Yii;
use yii\web\Cookie;

class LanguageKsl
{
    static $list;

    public static function getLanguagesList()
    {
        if(!self::$list) {
            $languages = Yii::$app->getModule('languages')->languages;
            $list = '';

            array_walk($languages, function ($value) use (&$list) {
                $list .= $value . '|';
            });

            self::$list = $list;
        }

        return self::$list;
    }

    public static function parsingUrl($language, $urlReferrer)
    {
        $languagesList = self::getLanguagesList();
        $host = Yii::$app->request->hostInfo;

        preg_match("#^($host)/($languagesList)(.*)#", $urlReferrer, $matches);

        if (isset($matches[3]) && !empty($matches[3]) && !preg_match('#^\/#', $matches[3])){
            $separator = '/';
        } else {
            $separator = '';
        }

        $defaultLanguage = Yii::$app->getModule('languages')->defaultLanguage;
        $showDefault = Yii::$app->getModule('languages')->showDefault;

        if($language == $defaultLanguage && !$showDefault){
            $matches[2] = null;
        } else {
            $matches[2] = '/'.$language.$separator;
        }

        $url = $matches[1].$matches[2].$matches[3];

        return $url;
    }

    public static function getLangFromCookies($defaultLang)
    {
        return Yii::$app->request->cookies->getValue('language', $defaultLang);
    }

    public static function addCookie($lang)
    {
        Yii::$app->response->cookies->add(new Cookie([
            'name' => 'language',
            'value' => $lang,
        ]));
    }
}
