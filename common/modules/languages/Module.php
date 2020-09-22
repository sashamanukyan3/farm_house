<?php

namespace common\modules\languages;

use common\modules\languages\models\LanguageKsl;
use yii\base\BootstrapInterface;

class Module extends \yii\base\Module implements BootstrapInterface
{
    public $controllerNamespace = 'common\modules\languages\controllers';

    public $languages;

    public $defaultLanguage;

    public $showDefault;

    public function bootstrap($app)
    {
        if (YII_ENV == 'test') {
            return;
        }

        $url = $app->request->url;
        $languagesList = LanguageKsl::getLanguagesList();
        preg_match("#^/($languagesList)(.*)#", $url, $matches);

        if (isset($matches[1]) && $matches[1] != '/' && $matches[1] != '') {
            if (!$this->showDefault && $matches[1] == $this->defaultLanguage) {
                $url = $app->request->absoluteUrl;
                $lang = $this->defaultLanguage;
                $app->response->redirect(['languages/default/index', 'lang' => $lang, 'url' => $url]);
            }

            $app->language = $matches[1];
            $app->formatter->locale = $matches[1];
            $app->homeUrl = '/' . $matches[1];
        } elseif (!$this->showDefault) {
            $lang = LanguageKsl::getLangFromCookies($this->defaultLanguage);
            $app->language = $lang;
            $app->formatter->locale = $lang;
        } else {
            $url = $app->request->absoluteUrl;
            $lang = LanguageKsl::getLangFromCookies($this->defaultLanguage);
            $app->response->redirect(['languages/default/index', 'lang' => $lang, 'url' => $url], 301);
        }

        LanguageKsl::addCookie($app->language);
    }
}
