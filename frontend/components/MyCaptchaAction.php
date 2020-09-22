<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 22.02.2016
 * Time: 16:09
 */

namespace frontend\components;


use yii\captcha\CaptchaAction;

class MyCaptchaAction extends CaptchaAction
{
    /**
     * @var integer the minimum length for randomly generated word. Defaults to 6.
     */
    public $minLength = 4;
    /**
     * @var integer the maximum length for randomly generated word. Defaults to 7.
     */
    public $maxLength = 4;
    /**
     * Generates a new verification code.
     * @return string the generated verification code
     */
    protected function generateVerifyCode()
    {
        if ($this->minLength > $this->maxLength) {
            $this->maxLength = $this->minLength;
        }
        if ($this->minLength < 3) {
            $this->minLength = 3;
        }
        if ($this->maxLength > 20) {
            $this->maxLength = 20;
        }
        $length = mt_rand($this->minLength, $this->maxLength);

        $letters = '0123456789';
        $vowels = '6789';
        $code = '';
        for ($i = 0; $i < $length; ++$i) {
            if ($i % 2 && mt_rand(0, 10) > 2 || !($i % 2) && mt_rand(0, 10) > 9) {
                $code .= $vowels[mt_rand(0, 3)];
            } else {
                $code .= $letters[mt_rand(0, 9)];
            }
        }

        return $code;
    }
}