<?php

namespace frontend\widgets;

use yii\base\Widget;
use yii\helpers\Html;
use common\models\Reviews;

class ReviewsWidget extends Widget
{

    public function init()
    {

        $reviews = Reviews::find()->limit(2)->orderBy(["id" => SORT_DESC])->all();

        echo $this->render('reviews', [
            'reviews' => $reviews,
        ]);

    }

}
