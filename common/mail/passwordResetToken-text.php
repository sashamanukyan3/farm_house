<?php

/* @var $this yii\web\View */
/* @var $user common\models\User */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['site/reset-password', 'token' => $user->password_reset_token]);
?>
Здравствуйте, <?= $user->username ?>!

Воспользуйтесь ссылкой ниже, чтобы сбросить пароль:

<?= $resetLink ?> <!--ссылка с ключом, перейдя по которой пользователь перейдет в
		действие ResetPassword контроллера Site и через $_GET передаст секретный ключ
		$token. -->
