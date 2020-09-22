<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 19.02.2016
 * Time: 18:58
 */
namespace frontend\widgets;

use yii\base\Widget;

class GamemenuWidget extends Widget{

    public function run(){
        return $this->render('wgamemenu');
    }
}