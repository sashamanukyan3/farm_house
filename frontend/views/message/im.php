<?php
use frontend\assets\AppAsset;
use vova07\fileapi\Widget as FileAPI;
use yii\helpers\Url;

?>
<link rel="stylesheet" href="/css/social.css">
<link rel="stylesheet" href="/css/comment.css">

<script>
    $(document).ready(function(){

        var from_id = $(".id").text();
        var to_id = $(".to_id").text();
        var csrfToken = $('meta[name="csrf-token"]').attr("content");

        $.ajax({
            url: "<?= Url::toRoute('/message/viewed/') ?>",
            type: "POST",
            async: true,
            data: {'from_id': from_id, 'to_id': to_id, '_csrf': csrfToken}
        }).done(function(result){

        });

        $("textarea[id=imTextarea]").focus();

        $(".im_post").click(function(){

            var element = $(this);

            var content = $("textarea[id=imTextarea]").val();
                content = $.trim(content);
            var image = $(".imgsize").attr("src");
            var username = $(".username").text();
            var date = $(".date").text();
            var id = $(".id").text();
            var validate = $('.msg_response').hide();
            var csrfToken = $('meta[name="csrf-token"]').attr("content");

            if(content == ""){
                $('.msg_response').html('');
                var message = "<?= Yii::t('app', 'Все поля должны быть заполнены') ?>";
                validate.append(message);
                validate.css('color','red');
                validate.show();
            }else {
                var findRU = content.indexOf(".ru");
                var findCOM = content.indexOf(".com");
                var findNET = content.indexOf(".net");
                var findORG = content.indexOf(".org");
                var findHTTP = content.indexOf("http://");
                var findHTTPS = content.indexOf("https://");
                var findWWW = content.indexOf("www.");

                if (findRU >= 0 || findCOM >= 0 || findNET >= 0 || findORG >= 0 || findHTTP >=0 || findHTTPS >=0 || findWWW >= 0){

//                    alert('В тексты не должны быть ссылки!');

                }else {

                    $.ajax({
                        url: "<?= Url::toRoute('/message/send/') ?>",
                        type: "POST",
                        async: true,
                        data: {'content': content, 'id': id, 'date': date, '_csrf': csrfToken}
                    }).done(function (result) {
                        $("textarea[id=imTextarea]").removeAttr('disabled');
                        $("textarea[id=imTextarea]").val('');
                        $("textarea[id=imTextarea]").focus();

                        var msg_content = element.closest('.msg-left-div').find('.msg-left-list');
                        msg_content.append('<div class="msg-user">' +
                            '<img src="' + image + '" alt="" class="msg-avatar">' +
                            '<span class="msg-text" style="margin-left: 5px">' + content + '</span>' +
                            '</div>'
                        );
                    });

                }
            }

        });

        function msgUpdate(){
            var csrfToken = $('meta[name="csrf-token"]').attr("content");
            var from_id = $(".id").text();
            var avatar = $(".imgsize").attr("src");
            $.ajax({
                url: "<?= Url::toRoute('/message/update/') ?>",
                type: "POST",
                async:true,
                data: {'from_id': from_id, 'avatar': avatar, '_csrf': csrfToken},
            }).done(function(result){

                if(result.status == true){
                    $(".msg-left-list").html('');
                    $(".msg-left-list").html(result.results);
                }

            });
        }

        setInterval(msgUpdate,3000);

    });
</script>
<div class="to_id" style="display: none;"><?= Yii::$app->user->identity->id; ?></div>
<!-- CONTENT -->
<div class="bmd-page-container padd">
    <div class="container">
        <div class="col-md-7 col-md-offset-3 boxshow">

            <div class="col-md-3 pag">
                <div class="">
                    <a href="<?= Url::toRoute('/profile/index/') ?>">
                        <img src="<?php
                        if($user->photo == null){
                            echo '/avatars/noavatar.png';
                        }else{
                            echo '/avatars/'.$user->photo;
                        }
                        ?>" alt="Картинка" type="button" class="imgsize btn btn-primary bmd-ripple" data-bmd-state="primary" data-toggle="tooltip" data-placement="bottom" title=""/>
                    </a>
                    <span class="username" style="display: none"><?= $user->username; ?></span>
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
                        <div class="botto"><span class="curs"><a href="<?= Url::toRoute('/message/index/') ?>"><span style="color: #000"><?= Yii::t('app', 'Мои Сообщения') ?></span><span class="badge bmd-bg-info rig"><?php echo $messageCount; ?></span></a></span></div>
                        <div class="botto"><span class="curs"><a href="<?= Url::toRoute('/profile/giftlist/') ?>"><span style="color: #000"><?= Yii::t('app', 'Мои подарки') ?></span><span class="badge bmd-bg-info rig"><?php echo $giftCount; ?></span></a></span></div>
                        <form id="search-form" action="<?= Url::toRoute('/profile/search/') ?>" method="get" role="form">
                            <input type="text" class="form-control search-input" id="search-query" name="Search[query]" maxlength="75" placeholder="<?= Yii::t('app', 'Поиск пользователей') ?>">
                            <button type="submit" class="search-btn" name="search-button"><img src="/img/search-button.png" alt=""></button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-9 pag">


                <div class="col-md-12 msg-left-div">

                    <span class="username" style="display: none"><?=\Yii::$app->user->identity->username; ?></span>
                    <span class="date" style="display: none"><?= date("Y-m-j H:i:s"); ?></span>
                    <span class="id" style="display: none"><?php echo trim($_GET["id"]); ?></span>

                    <div class="msg-left-list">
                        <?php foreach($message_list as $list){ ?>
                            <div class="msg-user">

                                <img src="<?php if( $list->user->photo == null){ echo '/avatars/noavatar.png'; }else{ echo '/avatars/'. $list->user->photo; } ?>" alt="" class="msg-avatar">

                                <span class="msg-text"><?= $list->message ?></span>

                            </div>
                        <?php } ?>
                    </div>

                    <div class="msg-textarea">
                        <span class="msg_response" style="color:red; display:none;"></span>
                        <input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />

                        <?php $form = \yii\widgets\ActiveForm::begin(['validateOnSubmit' => false]); ?>

                            <textarea name="" id="imTextarea"></textarea>

                            <div style="clear:both"></div>
                            <?= \yii\helpers\Html::button(Yii::t('app', 'Отправить'), [ 'class' => 'im_post_btn im_post']); ?>

                        <?php \yii\widgets\ActiveForm::end(); ?>

                    </div>
                </div>


            </div>

        </div>
    </div>
</div>
<?= \frontend\widgets\ReviewsWidget::widget(); ?>
