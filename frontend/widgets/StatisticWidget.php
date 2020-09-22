<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 18.01.2016
 * Time: 15:26
 */

namespace frontend\widgets;

use yii\base\Widget;

class StatisticWidget extends Widget{

    public function run(){
        return $this->render('wstatistic');
    }
}

