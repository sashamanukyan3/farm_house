<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 16.02.2016
 * Time: 12:47
 */

namespace frontend\widgets;

use common\models\News;
use common\models\UsersNews;
use yii\base\Widget;
use Yii;

class NotifyWidget extends Widget
{
    public function run(){
        $newsIds = UsersNews::find()->select('news_Id')->where(['user_id'])->all();
        $newsCount = 0;
        if($newsIds)
        {
            $news_count = News::find()->where(['id'=>$newsIds])->count();
        }
        return $this->render('wnotify',compact('newsCount'));
    }
}