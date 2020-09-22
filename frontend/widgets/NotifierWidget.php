<?php

namespace frontend\widgets;
use common\components\Pusher\Pusher;
use Yii;
use yii\base\Widget;

class NotifierWidget extends Widget
{
//    const APP_KEY = '';
//    const APP_SECRET = '';
//    const APP_ID = '';
    public function run(){
//        $pusher = new Pusher(self::APP_KEY, self::APP_SECRET, self::APP_ID);
//        $message = sanitize( $_GET['message'] );
//        $data = array('message' => $message);
//        $pusher->trigger('my_notifications', 'notification', $data);
//        function sanitize($data) {
//            return htmlspecialchars($data);
//        }

        return $this->render('notifier');
    }
}