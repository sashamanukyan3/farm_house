<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\User;

/**
 * ContactForm is the model behind the contact form.
 */
class ChangePasswordForm extends Model
{
    public $oldPassword;
    public $password;
    public $repeatPassword;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['oldPassword','password', 'repeatPassword'], 'required'],
            ['password', 'string', 'min' => 6],
            ['repeatPassword', 'compare', 'compareAttribute' => 'password', 'message'=>Yii::t('app', 'Пароли не совпадают')],

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'oldPassword' => Yii::t('app', 'Старый пароль'),
            'password' => Yii::t('app', 'Новый пароль'),
            'repeatPassword' => Yii::t('app', 'Повторите пароль'),
        ];
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     *
     * @param  string  $email the target email address
     * @return boolean whether the email was sent
     */

    public function changePassword()
    {
        if ($this->validate()) {
            $user = User::findOne(Yii::$app->user->id);
            $user->setPassword($this->password);
            $user->generateAuthKey();
            $user = $user->save();
            return $user;
        }
        return null;
    }

}
