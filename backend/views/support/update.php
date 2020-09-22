<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Support */

$this->params['breadcrumbs'][] = ['label' => 'Тех. поддержка', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Редактирование';
?>
<?php $this->registerJsFile(Yii::$app->urlManager->baseUrl .'/js/jquery.min.js', ['depends' => [\yii\web\JqueryAsset::className()],'position'=>\yii\web\View::POS_HEAD]); ?>


<div class="support-update">
    <input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />
    <h1><?= Html::encode($this->title) ?></h1>

    <span class="id" style="display: none;"><?= Yii::$app->request->get("id"); ?></span>

    <p><b>Логин: </b><?= $supportControl->userreply->username; ?></p>
    <p><b>Название: </b><?= $supportControl->subject; ?></p>
    <p><b>Сообщение: </b><?= $supportControl->message; ?></p>
    <p><b>Дата: </b><?= date("Y-m-d H:i:s", $supportControl->date); ?></p>
    <hr>

    <p style="font-size: 18px; font-weight: bold;">Ответы</p>
    <?php
        if($replyList){

            foreach ($replyList as $list){ ?>
                <div style="border-bottom: 1px dashed #ddd; margin-bottom: 20px;">
                    <?php
                        if($list->from == 1){
                            if($list->user_viewed == 1){
                                echo '<p><b>Логин: </b>'.Yii::$app->user->identity->username.' <span style="font-weight:bold;">Пользователь прочитал ответ</span></p>';
                            }else{
                                echo '<p><b>Логин: </b>'.Yii::$app->user->identity->username.' <span style="font-weight:bold;">Пользователь еще не прочитал ответ</span></p>';
                            }
                        }else{
                            echo '<p><b>Логин: </b>'.$list->userreply->username.'</p>';
                        }
                    ?>
                    <p><b>Сообщение: </b><?= $list->message; ?></p>
                    <p><b>Дата: </b><?= date("Y-m-d H:i:s", $list->date); ?></p>
                </div>

    <?php   }

        }
    ?>

    <?php if($supportControl->status == 2){ ?>
        <a href="javascript:void(0);" class="open" style="float: right">Открыть</a>
    <?php }else{ ?>
        <a href="javascript:void(0);" class="closed" style="float: right">Закрыть</a>
    <?php } ?>

    <div class="form" style="display: <?php echo ($supportControl->status == 2 ? 'none' : 'block') ?>">
        <?php $form = \yii\widgets\ActiveForm::begin(); ?>

        <?= $form->field($model, 'message')->textArea(['rows' => '6', 'name' => 'message', 'maxlength' => 1500]) ?>

        <?= \yii\helpers\Html::submitButton('Отправить', ['class' => 'btn btn-success']) ?>

        <?php \yii\widgets\ActiveForm::end(); ?>
    </div>

</div>
    <script type="text/javascript">
        $(document).ready(function()
        {
            $("body").on('click','.closed', function(){

                var id = $(".id").text();
                var csrfToken = $('meta[name="csrf-token"]').attr("content");
                $(this).removeClass().addClass('open');
                $(this).text('Открыть');

                $.ajax({
                    url: "/raimin/support/closed",
                    type: "POST",
                    async: true,
                    data: {'id': id, '_csrf': csrfToken}
                }).done(function (result) {
                    if (result.status) {
                        $(".form").css({'display':'none'});
                    }
                });


            });

            $("body").on('click','.open', function(){

                var id = $(".id").text();
                var csrfToken = $('meta[name="csrf-token"]').attr("content");
                $(this).removeClass().addClass('closed');
                $(this).text('Закрыть');

                $.ajax({
                    url: "/raimin/support/open",
                    type: "POST",
                    async: true,
                    data: {'id': id, '_csrf': csrfToken}
                }).done(function (result) {
                    if (result.status) {
                        $(".form").css({'display':'block'});
                    }
                });


            });
        });

    </script>