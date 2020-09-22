<?php

namespace frontend\widgets;

use yii\base\Widget;

class WelcomeWidget extends Widget{

    public function run(){
        return $this->render('wwelcome');
    }
}


