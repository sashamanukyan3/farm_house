<?php
use vova07\fileapi\Widget as FileAPI;
use yii\helpers\Url;
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <?php $this->title = Yii::t('app', 'Редактирование профиля'); ?>

    <link rel="stylesheet" href="/css/social.css">

</head>
<body>
<script>
    $(document).ready(function(){
        $("#toggleTitle").click(function(){
            $("#toggleContent").slideToggle();
        });
    });
</script>

<script type="text/javascript">
    function numbersonly(myfield, e, dec) {
        var key;
        var keychar;

        if (window.event)
            key = window.event.keyCode;
        else if (e)
            key = e.which;
        else
            return true;
        keychar = String.fromCharCode(key);

        // control keys
        if ((key == null) || (key == 0) || (key == 8) ||
            (key == 9) || (key == 13) || (key == 27))
            return true;

        // numbers
        else if ((("0123456789-+").indexOf(keychar) > -1))
            return true;

        // decimal point jump
        else if (dec && (keychar == ".")) {
            myfield.form.elements[dec].focus();
            return false;
        }
        else
            return false;
    }
</script>
<!-- CONTENT -->
<div class="bmd-page-container padd">

    <div class="container">
        <div class="col-md-7 col-md-offset-3 boxshow">
            <div class="col-md-3 pag">
                <div class="">

                    <div class="col-xs-12 col-md-4 col-sm-4">
                        <?php $form = \yii\widgets\ActiveForm::begin(['id' => 'profile-form', 'action' => \yii\helpers\Url::toRoute('/profile/edit')]); ?>
                    </div>

                    <a href="javascript:void(0);"><img src="<?php
                        if($user->photo == null){
                            echo '/avatars/noavatar.png';
                        }else{
                            echo '/avatars/'.$user->photo;
                        }
                        ?>" alt="Картинка" type="button" class="imgsize btn btn-primary bmd-ripple" data-bmd-state="primary" data-placement="bottom" title=""/>

                    <?= $form->field($model, 'photo')->widget(
                        FileAPI::className(),
                        [
                            'settings' => [
                                'url' => ['fileapi-upload'],
                            ],
                            'preview' =>true,
                            'crop' =>true,

                        ])->label(false);
                    ?>
                    <div class="mag botto">
                        <span class="curs"> <?= Yii::$app->user->identity->username; ?></span>
                    </div>
                    <div class="mag botto">
                        <span class="curs"> <?= Yii::t('app', 'Уровень') ?>:
                        <span class="badge bmd-bg-primary rig"><?= $user->level ?></span>
                        </span>
                    </div>
                    <div class="frend">
                        <div class="botto"><span class="curs"><a href="<?= Url::toRoute('/profile/list/') ?>"><span style="color: #000"><?= Yii::t('app', 'Друзья') ?></span><span class="badge bmd-bg-info rig"><?php echo $friend_count; ?></span></a></span></div>
                        <div class="botto"><span class="curs"><a href="<?= Url::toRoute('/profile/requests/') ?>"><span style="color: #000"><?= Yii::t('app', 'Заявки') ?></span><span class="badge bmd-bg-info rig"><?php echo $requets_count; ?></span></a></span></div>
                        <div class="botto"><span class="curs"><a href="<?= Url::toRoute('/message/index/') ?>"><span style="color: #000"><?= Yii::t('app', 'Мои Сообщения') ?></span><span class="badge bmd-bg-info rig"><?php echo $messageCount; ?></span></a></span></div></div>
                        <div class="botto"><span class="curs"><a href="<?= Url::toRoute('/profile/giftlist/') ?>"><span style="color: #000"><?= Yii::t('app', 'Мои подарки') ?></span><span class="badge bmd-bg-info rig"><?php echo $giftCount; ?></span></a></span></div>
                    </div>
            </div>

            <div class="col-md-9 pag">
                <h4><b><?= $user->first_name ?> <?= $user->last_name ?></b></h4>

                <p class="line">
                    <?php if($user->sex == \common\models\User::SEX_MALE): ?>
                        <img class="wm" src="/img/man.png"/>
                    <?php else: ?>
                        <img class="wm" src="/img/woman.png"/>
                    <?php endif; ?>
                </p>

                <div class="form-group">

                        <div class="input-group">
                            <div class="bmd-field-group">
                                <?= $form->field($model, 'first_name')->textInput(['value' => $user->first_name, 'class' => 'bmd-input inp', 'placeholder' => Yii::t('app', 'Имя')])->label(false); ?>
                                <span class="bmd-bar"></span>
                            </div>

                            <div class="bmd-field-group">
                                <?= $form->field($model, 'last_name')->textInput(['value' => $user->last_name, 'class' => 'bmd-input inp', 'placeholder' => Yii::t('app', 'Фамилия')])->label(false); ?>
                                <span class="bmd-bar"></span>
                            </div>

                            <div class="bmd-field-group">
                                <?= $form->field($model, 'phone')->textInput(['value' => $user->phone, 'class' => 'bmd-input inp', 'placeholder' => Yii::t('app', 'Телефон'), 'onkeypress' => "return numbersonly(this, event)"])->label(false); ?>
                                <span class="bmd-bar"></span>
                            </div>

                            <div class="bmd-field-group">
                                <?= $form->field($model, 'email')->textInput(['value' => $user->email, 'class' => 'bmd-input inp', 'placeholder' => 'E-Mail'])->label(false); ?>
                                <span class="bmd-bar"></span>
                            </div>

                            <div class="bmd-field-group">
                                <?=
                                $form->field($model, 'sex')
                                    ->dropDownList(
                                        [
                                            '1'=>Yii::t('app', 'М'),
                                            '0'=>Yii::t('app', 'Ж'),
                                        ]
                                    )->label(false);
                                ?>
                                <span class="bmd-bar"></span>
                            </div>

                            <div class="bmd-field-group">
                                <?= $form->field($model, 'country')->textInput(['value' => $user->country, 'class' => 'bmd-input inp', 'placeholder' => Yii::t('app', 'Страна')])->label(false); ?>
                                <span class="bmd-bar"></span>
                            </div>

                            <div class="bmd-field-group">
                                <?= $form->field($model, 'city')->textInput(['value' => $user->city, 'class' => 'bmd-input inp', 'placeholder' => Yii::t('app', 'Город')])->label(false); ?>
                                <span class="bmd-bar"></span>
                            </div>

                            <div class="bmd-field-group" style="margin-bottom: 20px;">
                                <?= $form->field($model, 'about')->textArea(['value' => $user->about, 'class' => 'form-control', 'rows' => 6, 'resize' => 'none', 'maxlength' => 500, 'placeholder' => Yii::t('app', 'О себе')])->label(false); ?>
                                <span class="bmd-bar"></span>
                            </div>

                            <span style="color: #6599FE"><?= Yii::t('app', 'День рождения') ?></span>

                            <?=
                            $form->field($model, 'birthday')->widget(\kartik\date\DatePicker::classname(), [
                            'options' => ['value' => $user->birthday, 'placeholder' => 'День рождения'],
                            'pluginOptions' => [
                                'format' => 'yyyy-mm-dd',
                                'autoclose' => true,
                                'todayHighlight' => true,
                            ]
                            ])->label(false); ?>

                            <div style="clear:both"></div>

                            <div class="edit-btn-group">
                                <a href="<?= Url::toRoute('/profile/index/') ?>" class="btn btn-danger edit-danger" style="">Отмена</a>
                                <?= \yii\helpers\Html::submitButton(Yii::t('app', 'Сохранить'), ['class' => 'btn btn-success edit-success', 'name' => 'login-button']) ?>
                            </div>
                            <span class="bmd-field-feedback"></span>
                        </div>
                    <?php \yii\widgets\ActiveForm::end(); ?>
                </div>

            </div>

        </div>
    </div>

</div>

<script>
    $(function () {

        $("#uploader-profile-photo input[name=file]").on("change", function (e) {

            var allowedExtensions = ["jpg", "jpeg", "gif", "png", "bmp"];
            var fileName = e.target.files[0].name.toLowerCase();
            var fileNameExtension = fileName.substring(fileName.lastIndexOf(".") + 1);

            if (allowedExtensions.indexOf(fileNameExtension) === -1) {
                e.preventDefault();

                var message = "<?= Yii::t('app', 'Неверный формат изображения') ?>";
                alert(message);

                return false;
            }
        });
    });
</script>

<!-- Script -->
<script type="text/javascript" src="/js/jquery.min.js"></script>
<script type="text/javascript" src="/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/js/jquery.easing.min.js"></script>
<script type="text/javascript" src="/js/prettify.js"></script>
<script type="text/javascript" src="/js/main.min.js"></script>
<script type="text/javascript" src="/js/number.js"></script>
<!-- Script End -->
<?= \frontend\widgets\ReviewsWidget::widget(); ?>
</body>
</html>
