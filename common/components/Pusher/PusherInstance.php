<?php
/**
 * Created by PhpStorm.
 * User: Бекарыс
 * Date: 21.01.2016
 * Time: 15:56
 */

namespace common\components\Pusher;


class PusherInstance
{
    private static $instance = null;
    private static $app_id	= '';
    private static $secret	= '';
    private static $api_key = '';

    private function __construct() { }
    private function __clone() { }

    public static function get_pusher()
    {
        if (self::$instance !== null) return self::$instance;

        self::$instance = new Pusher(
            self::$api_key,
            self::$secret,
            self::$app_id
        );

        return self::$instance;
    }
}