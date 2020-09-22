<?php
use frontend\assets\AppAsset;
use vova07\fileapi\Widget as FileAPI;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\captcha\Captcha;
use yii\helpers\Url;
?>

<script>
    $(document).ready(function(){

        $("body").on('click','.support_close', function(){

            var validate = $('.msg_response').hide();

            var sup_id = $(this).attr("sup_id");

            $(this).removeClass().addClass('support_open');

            $("img#"+sup_id).attr("src","/img/message.png");

            $(this).text('Открыть тикет снова');

            $.ajax({
                url: "<?= Url::toRoute('/support/closed/') ?>",
                type: "POST",
                async:true,
                data: {'sup_id': sup_id}
            }).done(function(result){
                if(result.supClosed){
                    $(".img-closed").attr("src","/img/message.png");
                }
            });

        });

        $("body").on('click','.support_open', function(){

            var validate = $('.msg_response').hide();

            var sup_id = $(this).attr("sup_id");

            $(this).removeClass().addClass('support_close');

            $("img#"+sup_id).attr("src","/img/message1.png");

            var message = "<?= Yii::t('app', 'Закрыть тикет') ?>";
            $(this).text(message);

            $.ajax({
                url: "<?= Url::toRoute('/support/open/') ?>",
                type: "POST",
                async:true,
                data: {'sup_id': sup_id}
            }).done(function(result){
                if(result.supOpen){
                    $(".img-closed").attr("src","/img/message1.png");
                }
            });

        });

    });
</script>

<div class="bmd-page-container padd">
    <div class="container">

        <div class="col-md-12 pri">
            <div class="faq_page_title"><?= Yii::t('app', 'Тех. Поддержка') ?></div>
            <ul class="bonus_ul">
                <p><?= Yii::t('app', 'supportDescription') ?></p>
                <div class="col-md-7" style="padding-bottom: 20px">
                    <a href="<?= Url::toRoute('/support/send/') ?>" class="sup-add-menu"><?= Yii::t('app', 'Создать тикет') ?></a>
                    <a href="<?= Url::toRoute('/support/out/') ?>" class="sup-add-menu sup-add-menu-active"><?= Yii::t('app', 'Ваши тикеты') ?></a>
                    <div style="clear:both"></div>
                    <br>

                    <?php if($support){ ?>

                        <table class="mails-table">
                            <tr>
                                <td><?= Yii::t('app', 'Дата') ?></td>
                                <td><?= Yii::t('app', 'Тема') ?></td>
                                <td><?= Yii::t('app', 'Действия') ?></td>
                                <td><?= Yii::t('app', 'Статус') ?></td>
                            </tr>
                            <?php foreach($support as $sup){ ?>
                                <tr>
                                    <td class="mails-out-data"><?= date("Y-m-d H:i:s", $sup->date); ?></td>
                                    <td class="mails-out-subject"><?= $sup->subject; ?></td>
                                    <td>
                                        <a href="<?= Url::toRoute('/support/view?id=' . $sup->id) ?>"><?= Yii::t('app', 'Просмотр') ?></a>
                                    </td>
                                    <td class="mails-out-subject">
                                        <?php
                                        if ($sup->status == 1) {
                                            echo '<img class="img-closed" src="/img/message1.png" width="40px" id="' . $sup->id . '" height="40px" alt="">';
                                            echo '<a href="javascript:void(0);" style="margin-left: 10px" class="support_close" sup_id="' . $sup->id . '">' . Yii::t('app', 'Закрыть тикет') . '</a>';
                                        } else if ($sup->status == 2) {
                                            echo '<img class="img-closed" src="/img/message.png" width="40px" height="40px" alt="">';
                                            echo '<a href="javascript:void(0);" style="margin-left: 10px" class="support_open" sup_id="' . $sup->id . '">' . Yii::t('app', 'Открыть тикет снова') . '</a>';
                                        } elseif ($sup->status == 3) {
                                            echo '<img class="img-closed" src="/img/message3.png" width="40px" height="40px" alt="">';
                                            echo '<a href="javascript:void(0);" style="margin-left: 10px" class="support_close" sup_id="' . $sup->id . '">' . Yii::t('app', 'Закрыть тикет') . '</a>';
                                        } else {
                                            echo '<img class="img-closed" src="/img/message2.png" width="40px" height="40px" alt="">';
                                            echo '<a href="javascript:void(0);" style="margin-left: 10px" class="support_close" sup_id="' . $sup->id . '">' . Yii::t('app', 'Закрыть тикет') . '</a>';
                                        }
                                        ?>
                                    </td>
                                </tr>
                            <?php } ?>

                        </table>

                    <?php } ?>

                </div>

            </ul>
        </div>
    </div>
</div>

<?= \frontend\widgets\ReviewsWidget::widget(); ?>