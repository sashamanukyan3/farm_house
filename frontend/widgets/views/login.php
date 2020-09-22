<?php

use yii\helpers\Url;
use yii\widgets\ActiveForm;

?>
<div class="popup popup-login" id="login">
    <h3 class="popup__title title title--size-small title--align-center"><?= Yii::t('app', 'Войти') ?></h3>
    <?php
        $form = ActiveForm::begin(['id' => 'login-form',
            'options' => ['class' => 'popup__form'],
        ]);
    ?>
    <div class="popup__label">
        <?php echo $form->field($login_model, 'username', ['options'=>['class'=>'input popup__group']])
            ->label(false)->textInput(['class' => 'popup__input input', 'placeholder' => 'Логин']); ?>
    </div>
    <div class="popup__label">
        <svg class="svg-sprite-icon icon-eye popup__label-icon js-toggle">
            <use xlink:href="/img/sprite/symbol/sprite.svg#eye"></use>
        </svg>
        <?php echo $form->field($login_model, 'password', ['options'=>['class'=>'input popup__group']])
            ->passwordInput()->label(false)->textInput(['class' => 'popup__input input', 'placeholder' => 'Пароль', 'type' => 'password']); ?>
    </div>
    <div class="popup__label popup__label--row">
        <div class="popup__label-col popup__label-col--flex">
            <input type="checkbox" class="switch__input remember_me" id="switch">
            <label class="switch__item" for="switch"></label>
            <span class="switch__text"><?= Yii::t('app', 'Запомнить меня') ?></span>
        </div>
        <div class="popup__label-col">
            <a class="popup__link subtitle" href="<?= Url::toRoute('/site/request-password-reset') ?>"><?= Yii::t('app', 'Забыли пароль?') ?></a>
        </div>
    </div>
    <span class="popup__error error"></span>
    <div class="popup__buttons">
        <button id="login-btn" class="popup__btn link link--color-white popup__btn--margin"><?= Yii::t('app', 'Войти') ?></button>
        <button class="popup__btn btn js-open-popup" onclick=""><?= Yii::t('app', 'Регистрация') ?></button>
    </div>
    <?php
        ActiveForm::end();
    ?>
</div>
    <div class="popup popup-login" id="registration">
        <h3 class="popup__title title title--size-small title--align-center"><?= Yii::t('app', 'Регистрация') ?></h3>
        <?php $form = ActiveForm::begin(['id' => 'form-signup',
            'options' => ['class' => 'popup__form'],
        ]); ?>
        <div class="popup__label">
            <?php echo $form->field($signup_model, 'username', ['options'=>['class'=>'input popup__group']])
                ->label(false)->textInput(['class' => 'popup__input input', 'placeholder' => 'Логин']); ?>
        </div>
        <div class="popup__label">
            <svg class="svg-sprite-icon icon-eye popup__label-icon js-toggle">
                <use xlink:href="/img/sprite/symbol/sprite.svg#eye"></use>
            </svg>
            <?php echo $form->field($signup_model, 'password', ['options'=>['class'=>'input popup__group']])
                ->passwordInput()->label(false)->textInput(['class' => 'popup__input input', 'placeholder' => 'Пароль', 'type' => 'password']); ?>
        </div>
        <div class="popup__label">
            <?php echo $form->field($signup_model, 'email', ['options'=>['class'=>'input popup__group']])->input('email')->label(false)
                ->textInput(['class' => 'popup__input input', 'placeholder' => 'Email']); ?>
        </div>
        <div class="popup__label popup__label--row">
            <?= $form->field($signup_model, 'sex')->radioList([
                '1' => Yii::t('app', 'Мужской'),
                '0' => Yii::t('app', 'Женский'),
            ],
                [
                    'item' => function($index, $label, $name, $checked, $value) {
                        $checked = ($index == 0) ? 'checked' : '';
                        $return = '<input id="' . Yii::t('app', $label) .'" class="box__list-radio" type="radio" name="' . $name . '" value="' . $value . '" tabindex="3"'. $checked.'>';
                        $return .= '<label for="' . Yii::t('app', $label) . '" data-text="' . mb_substr($label, 0, 1, 'UTF-8') . '" class="box__list-btn">';
                        $return .= '</label>';
                        return $return;
                    }
                ]); ?>
            <?= $form->field($signup_model, 'verifyCode', ['options'=>['class'=>'input popup__label-verify']])->label(false)->widget(\yii\captcha\Captcha::className(), [
                //'captchaAction' => '/frontend/components/MyCaptchaAction',
                'imageOptions' => [
                    'class' => 'box__main-image'
                ],
                'options' => [
                    'class' => 'box__input box__input--margin input',
                    'data-inputmask' => "'mask': '9999', 'placeholder': ' '"
                ],
                'template' => '<div class="popup__label-col">{image}</div><div class="popup__label-col">{input}</div>',
            ]) ?>
        </div>
        <div class="popup__label popup__label--margin">
            <input type="hidden" name="ref_id" value="<?= (isset($ref_user) ? $ref_user->id : 0 ) ?>">
            <span class="subtitle"><strong><?= Yii::t('app', 'Вас пригласил') ?></strong>: <?= (isset($ref_user) ? $ref_user->username : Yii::t('app', 'Сам(a) пришел(ла)')) ?></span>
        </div>
        <div class="popup__label-col popup__label-col--margin popup__label-col--flex">
            <input required type="checkbox" class="switch__input remember_me" id="agreement" name="confirm_signup">
            <label class="switch__item" for="agreement"></label>
            <span class="switch__text">
                <?= Yii::t('app', 'Я полностью принимаю условия <a href="{link}" target="_blank">пользовательского соглашения</a>', [
                    'link' => Url::toRoute('/tos'),
                ]) ?>
            </span>
        </div>
        <div class="popup__label-col popup__label-col--margin popup__label-col--flex">
            <input required type="checkbox" class="switch__input remember_me" id="newsletter">
            <label class="switch__item" for="newsletter"></label>
            <span class="switch__text">
                <?= Yii::t('app', 'Я согласен Получать новости на email') ?>
                <span class="refLink" style="display: none"><?= (isset($ref_user) ? Yii::$app->request->getReferrer() : '')?></span>
            </span>
        </div>
        <span class="popup__error error"></span>
        <div class="popup__label--row">
            <button class="popup__btn btn" id="signup"><?= Yii::t('app', 'Зарегистрироваться') ?></button>
            <button data-fancybox-close class="popup__btn link link--color-white"><?= Yii::t('app', 'Отмена') ?></button>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
<?php
$actionLogin = Url::toRoute('site/login');
$actionSignup = Url::toRoute('site/signup');
$agreementText = Yii::t("app", "Условия пользовательского соглашения должны быть приняты");
$loginText = Yii::t('app', 'Логин не должен содержать кириллицу');
$registerText = Yii::t('app', 'Регистрация прошла успешно');
$script = <<<JS
    $(function () {
            document.onkeydown = enterLogin;
            function enterLogin(x) {
                var key;
                key = x.which;
                if (key == 13) {
                    $('#login-btn').click()
                }
            }
            $('#login-btn').on('click', function(e){
                e.preventDefault();
                var err_msg = $('.popup__error');
                err_msg.hide();
                err_msg.empty();
                var username = $('#login-form #loginform-username').val();
                var password = $('#login-form #loginform-password').val();
                var token    = $("#login-form input[name=_csrf]").val();
                var rememberMe = $('#login-form .remember_me').is(':checked');
                if ($('#login-form').find('.has-error').length) {
                    return true;
                }
                $.ajax({
                    url: '$actionLogin',
                    type: "POST",
                    async:true,
                    data: {'username': username, 'password' : password, '_csrf' : token,'rememberMe':rememberMe },
                    beforeSend: function () {
                        $(".preloader__wrapper").show();
                    },
                    complete: function () {
                        $(".preloader__wrapper").hide();
                    }
                }).done(function(response){
                    console.log(response)
                    if(response.status)
                    {
                        err_msg.hide();
                        if(response.is_first)
                        {
                            $.fancybox.close();
                            $('.response-answer').html(response.msg);
                        }
                        else
                        {
                            location.reload();
                        }
                    }
                    else
                    {
                        err_msg.empty();
                        err_msg.append(response.msg);
                        err_msg.show();
                        e.preventDefault();
                    }
                });
            });
        });

        $('#signup').on('click', function(e){
            e.preventDefault();
            var err_msg   = $('#form-signup .popup__error');
            err_msg.hide();
            var sucs_msg  = $('#form-signup .popup__error');
            sucs_msg.hide();
            sucs_msg.empty();
            err_msg.empty();
            var username  = $('#signupform-username').val();
            var patt = /[а-яА-Я]/g;
            if(patt.test(username))
            {
                err_msg.append('$loginText');
                err_msg.show();
                return 1;
            }
            var password  = $('#form-signup #signupform-password').val();
            var token     = $("#form-signup input[name=_csrf]").val();
            var email     = $('#form-signup #signupform-email').val();
            var verifyCode = $('#form-signup #signupform-verifycode').val();
            var male       = $('#form-signup input[name="SignupForm[sex]"]:checked').val();
            var is_subscribed = $('#form-signup #newsletter').is(':checked');
            var is_confirmed = $('#form-signup #agreement').is(':checked');
            is_subscribed    = (is_subscribed == true ? 1 : 0);
            var ref_id       = $("input[name=ref_id]").val();
            var refLink       = $(".refLink").text();
            if ($('#signup-form').find('.has-error').length) {
                return true;
            }
            if(is_confirmed)
            {
                $.ajax({
                    url: '$actionSignup',
                    type: "POST",
                    async: true,
                    data: { 'username': username,
                        'password' : password,
                        '_csrf' : token,
                        'is_subscribed':is_subscribed,
                        'verifyCode':verifyCode,
                        'male': male,
                        'email': email,
                        'is_confirmed' :is_confirmed,
                        'ref_id' : ref_id,
                        'refLink' : refLink
                    },
                    beforeSend: function () {
                        $(".preloader__wrapper").show();
                    },
                    complete: function () {
                        $(".preloader__wrapper").hide();
                    }
                }).done(function(msg){
                    if(msg.status)
                    {
                        sucs_msg.append('$registerText');
                        sucs_msg.show();
                        $('#form-signup #signupform-username').val('');
                        $('#form-signup #signupform-password').val('');
                        $('#form-signup #signupform-email').val('');
                        $('#form-signup #signupform-verifycode').val('');
                        setTimeout(function(){
                            $.fancybox.close();
                              setTimeout(function () {
                                $.fancybox.open({
                                  src  : '#login',
                                  type : 'inline',
                                });
                              }, 1);
                            $('.response-answer').html(response.msg);
                            location.reload();
                        }, 3000);
                    }
                    else
                    {
                        err_msg.append(msg.msg);
                        err_msg.show();
                        $("img[id$='signupform-verifycode-image']").trigger('click');
                    }
                });
            }
            else
            {
                err_msg.append('$agreementText');
                err_msg.show();
            }
        })
JS;
    if (Yii::$app->user->isGuest) {
        $this->registerJs($script);
    }
?>