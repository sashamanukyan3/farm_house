<?php

namespace frontend\models;

class ReCaptchaValidator
{
  public $reCaptcha;

  public function rules()
  {
    return [
      // ...
        [['reCaptcha'], \himiklab\yii2\recaptcha\ReCaptchaValidator::className(), 'secret' => '��� secret key']
    ];
  }
}
