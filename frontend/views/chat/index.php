<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use common\models\User;
use yii\helpers\Url;

?>
<script type="text/javascript" src="/js/urlControl.js"></script>
<script>
    $(document).ready(function(){

        $(".chat-smile a img").click(function(){
            var smiley = $(this).attr('smiley');
            var message = $("#chatTextarea").val();
            $("#chatTextarea").val(message + ' ' + smiley + ' ');
            $("textarea[id=chatTextarea]").focus();
        });

        $(".bold-open").click(function(){
            var bold = $(this).attr('bold-open');
            var boldClose = $('.bold-close').attr('bold-close');
            var message = $("#chatTextarea").val();
            $("#chatTextarea").val(bold + ' ' +message + ' ' + boldClose + ' ');
            $("textarea[id=chatTextarea]").focus();
        });

        $(".italic-open").click(function(){
            var italic = $(this).attr('italic-open');
            var italicClose = $('.italic-close').attr('italic-close');
            var message = $("#chatTextarea").val();
            $("#chatTextarea").val(italic + ' ' +message + ' ' + italicClose + ' ');
            $("textarea[id=chatTextarea]").focus();
        });

        $(".underline-open").click(function(){
            var underline = $(this).attr('underline-open');
            var underlineClose = $('.underline-close').attr('underline-close');
            var message = $("#chatTextarea").val();
            $("#chatTextarea").val(underline + ' ' +message + ' ' + underlineClose + ' ');
            $("textarea[id=chatTextarea]").focus();
        });

        $("body").on('click','.username', function(){
            var username = $(this).attr('username');
            var message = $("#chatTextarea").val();
            $("#chatTextarea").val(message + ' ' + '<b><i>'+ username +'</i></b>' + ' ');
            $("textarea[id=chatTextarea]").focus();
        });

        $("textarea[id=chatTextarea]").focus();
        var validate = $('.msg_response').hide();

        document.onkeydown = postMsg;
        function postMsg(x){

            var key;
            key = x.which;
            if(key == 13){

                $('.msg_response').html('');

                var username = $(".identity-username").html();

                var element = $(this);

                var csrfToken = $('meta[name="csrf-token"]').attr("content");
                var text = $("#chatTextarea").val();
                text = $.trim(text);

                var findRU = text.indexOf(".ru");
                var findCOM = text.indexOf(".com");
                var findNET = text.indexOf(".net");
                var findORG = text.indexOf(".org");
                var findHTTP = text.indexOf("http://");
                var findHTTPS = text.indexOf("https://");
                var findWWW = text.indexOf("www.");

                if (findRU >= 0 || findCOM >= 0 || findNET >= 0 || findORG >= 0 || findHTTP >=0 || findHTTPS >=0 || findWWW >= 0){

//                    alert('В тексты не должны быть ссылки!');

                }else {

                    if (text == "") {
                        var message = "<?= Yii::t('app', 'Все поля должны быть заполнены') ?>";
                        validate.append(message);
                        validate.css('color', 'red');
                        validate.show();
                    } else {

                        $("#chatTextarea").attr("disabled", "disabled");

                        $.ajax({
                            url: "<?= Url::toRoute('/chat/index/') ?>",
                            type: "POST",
                            async: true,
                            data: {'username': username, 'text': text, '_csrf': csrfToken}
                        }).done(function (result) {
                            if (result.status) {
                                $("#chatTextarea").val('');
                                $("#chatTextarea").removeAttr("disabled");
                                $("textarea[id=chatTextarea]").focus();
                            } else {
                                validate.css('color', 'red');
                                validate.append(result.msg);
                                validate.show();
                            }
                        });

                    }

                }

            }

        }

        $(".chat_post_btn").click(function(){
            $(".msg_response").html('');

            var username = $(".identity-username").html();

            var element = $(this);

            var csrfToken = $('meta[name="csrf-token"]').attr("content");
            var text = $("#chatTextarea").val();
            text = $.trim(text);

            var findRU = text.indexOf(".ru");
            var findCOM = text.indexOf(".com");
            var findNET = text.indexOf(".net");
            var findORG = text.indexOf(".org");
            var findHTTP = text.indexOf("http://");
            var findHTTPS = text.indexOf("https://");
            var findWWW = text.indexOf("www.");

            if (findRU >= 0 || findCOM >= 0 || findNET >= 0 || findORG >= 0 || findHTTP >=0 || findHTTPS >=0 || findWWW >= 0){

                var message = "<?= Yii::t('app', 'В тексты не должны быть ссылки') ?>";
                alert(message);

            }else {
                if (text == "") {
                    var message = "<?= Yii::t('app', 'Все поля должны быть заполнены') ?>";
                    validate.append(message);
                    validate.css('color', 'red');
                    validate.show();
                } else {
                    $.ajax({
                        url: "<?= Url::toRoute('/chat/index/') ?>",
                        type: "POST",
                        async: true,
                        data: {'username': username, 'text': text, '_csrf': csrfToken}
                    }).done(function (result) {
                        if (result.status) {
                            $("#chatTextarea").val('');
                            $("textarea[id=chatTextarea]").focus();
                        } else {
                            validate.css('color', 'red');
                            validate.append(result.msg);
                            validate.show();
                        }
                    });

                }

            }

        });

        $("body").on('click','.block', function(){

            $(this).text('Разблокировать');
            $(this).removeClass("block");
            $(this).addClass("unlock");
            var user_ID = $(this).attr("user_ID");

            var csrfToken = $('meta[name="csrf-token"]').attr("content");
            $.ajax({
                url: "<?= Url::toRoute('/chat/block/') ?>",
                type: "POST",
                async:true,
                data: {'user_ID': user_ID, '_csrf': csrfToken},
            }).done(function(response){
                if(response.status)
                {

                }
                else
                {

                }
            });

        });

        $("body").on('click','.unlock', function(){

            var message = "<?= Yii::t('app', 'Блокировать') ?>";
            $(this).text(message);
            $(this).removeClass("unlock");
            $(this).addClass("block");
            var user_ID = $(this).attr("user_ID");

            var csrfToken = $('meta[name="csrf-token"]').attr("content");
            $.ajax({
                url: "<?= Url::toRoute('/chat/unlock/') ?>",
                type: "POST",
                async:true,
                data: {'user_ID': user_ID, '_csrf': csrfToken},
            }).done(function(response){
                if(response.status)
                {

                }
                else
                {

                }
            });

        });

        $("body").on('click','.remove-message', function(){

            var id = $(this).closest('.chat-div').attr("id");
            $(this).closest('.chat-div').remove();
            var csrfToken = $('meta[name="csrf-token"]').attr("content");
            $.ajax({
                url: "<?= Url::toRoute('/chat/delete/') ?>",
                type: "POST",
                async:true,
                data: {'id': id, '_csrf': csrfToken},
            }).done(function(response){
                if(response.status)
                {

                }
                else
                {

                }
            });

        });

        function chatUpdate(){
            var username = $(".identity-username").text();
            var text = $("#chatTextarea").val();
            text = $.trim(text);
            var audio = $('audio');
            var csrfToken = $('meta[name="csrf-token"]').attr("content");
            $.ajax({
                url: "<?= Url::toRoute('/chat/update/') ?>",
                type: "POST",
                async:true,
                data: {'text': text, 'username': username,'_csrf': csrfToken},
            }).done(function(response){
                if(response.status)
                {
                    var htmlContent = '';
                    if(response.mp3)
                    {
                        $.each(response.result, function( key, value ) {
                            htmlContent =  htmlContent + value;
                        });
                        $(".chat-content").html(htmlContent);
                        audio[0].play();
                    }else{
                        $.each(response.result, function( key, value ) {
                            htmlContent =  htmlContent + value;
                        });
                        $(".chat-content").html(htmlContent);
                    }

                }
                else
                {
                    $(".chat-div").remove();
                }
            });

        }

        function chatOnline(){
            var csrfToken = $('meta[name="csrf-token"]').attr("content");
            $.ajax({
                url: "<?= Url::toRoute('/chat/online/') ?>",
                type: "POST",
                async:true,
                data: {'_csrf': csrfToken},
            }).done(function(response){
                if(response.status)
                {
                    var htmlContent = '';
                    $.each(response.result, function( key, value ) {
                        htmlContent =  htmlContent + value;
                    });
                    $(".online-users").html(htmlContent);
                }
                else
                {
                    var htmlContent = '';
                    $.each(response.result, function( key, value ) {
                        htmlContent =  htmlContent + value;
                    });
                    $(".online-users").html(htmlContent);
                }
            });

        }

        chatUpdate();
        setInterval(chatUpdate,3000);
        setInterval(chatOnline,3000);

        $( window ).unload(function() {
            var username = $(".identity-username").html();
            var csrfToken = $('meta[name="csrf-token"]').attr("content");
            $.ajax({
                url: "<?= Url::toRoute('/chat/offline/') ?>",
                type: "POST",
                async:true,
                data: {'_csrf': csrfToken, 'username': username},
            }).done(function(response){
                if(response.status)
                {

                }
                else
                {

                }
            });
        });

        $("body").on('click','.clear-chat', function(){

            var csrfToken = $('meta[name="csrf-token"]').attr("content");
            $.ajax({
                url: "<?= Url::toRoute('/chat/deleteall/') ?>",
                type: "POST",
                async:true,
                data: {'_csrf': csrfToken},
            }).done(function(response){
                if(response.status)
                {

                }
                else
                {

                }
            });

        });

        $("body").on('click','.music-on', function(){

            var csrfToken = $('meta[name="csrf-token"]').attr("content");
            var id = $(".chatmusic-userid").text();
            $.ajax({
                url: "<?= Url::toRoute('/chat/musicon/') ?>",
                type: "POST",
                async:true,
                data: {'id':id, '_csrf': csrfToken},
            }).done(function(response){
                if(response.status)
                {
                    $(".music-on").attr("src", "/img/sound-off.png");
                    $(".music-on").attr("class", "music-off");
                }
                else
                {

                }
            });

        });

        $("body").on('click','.music-off', function(){

            var csrfToken = $('meta[name="csrf-token"]').attr("content");
            var id = $(".chatmusic-userid").text();
            $.ajax({
                url: "<?= Url::toRoute('/chat/musicoff/') ?>",
                type: "POST",
                async:true,
                data: {'id':id, '_csrf': csrfToken},
            }).done(function(response){
                if(response.status)
                {
                    $(".music-off").attr("src", "/img/sound.png");
                    $(".music-off").attr("class", "music-on");
                }
                else
                {

                }
            });

        });

    });

</script>
<script>
    $(document).ready(function(){
        $(".reviews:first").addClass("pull-right");
    });
</script>
<span class="chatmusic-userid" style="display:none;"><?= Yii::$app->user->identity->id; ?></span>
<input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />
<?php

    $roleControl = \Yii::$app->user->identity->role;
    if($roleControl == 1){
        echo '<span style="display: none"><div class="identity-username"><span style="color: red;">'.\Yii::$app->user->identity->username.'</span></div></span>';
    }else if($roleControl == 2){
        echo '<span style="display: none"><div class="identity-username"><span style="color: green;">'.\Yii::$app->user->identity->username.'</span></div></span>';
    }else{
        echo '<span style="display: none"><div class="identity-username"><span style="color: blue;">'.\Yii::$app->user->identity->username.'</span></div></span>';
    }

?>
<audio controls style="display:none;">
    <source src="/img/Kalimba.mp3" type="audio/mpeg">
</audio>

<div class="bmd-page-container padd">
    <div class="container">
        <div class="col-md-8 pri" style="margin-top: 7px;">
            <div class="chat-page-title"><?= Yii::t('app', 'Чат') ?></div>
            <div id="chat">
                <p>
                    <span><?= Yii::t('app', 'Пользователь, с <span style="color: red">красным</span> цветом ника - Администратор') ?></span><br>
                    <span><?= Yii::t('app', 'Пользователь, с <span style="color: #00ff65">зеленым</span> цветом ника - Модератор') ?></span>
                </p>
                <input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />
                <div style="clear: both"></div>
                <div class="chat-content">

                    <?php if($chatList){ ?>

                        <?php foreach($chatList as $list){ ?>
                            <div class="chat-div" id="<?= $list->id; ?>">
                                <a href=""><span><img class="chat-sex" src="/img/wall3.png" alt=""></span></a>
                                <?php if($list->sex == 1){ ?>
                                    <span><img class="chat-sex" src="/img/man.png" alt=""></span>
                                <?php }else{ ?>
                                    <span><img class="chat-sex" src="/img/woman.png" alt=""></span>
                                <?php } ?>
                                <span class="chat-username"><?= $list->username; ?></span>
                                <span class="chat-date">(<?= date('Y:m:d H:i:s', $list->created_at); ?>)</span><br>
                                <span class="chat-message"><?= $list->text; ?></span>
                                <?php $role = \Yii::$app->user->identity->role; ?>
                                <?php if($role == \common\models\User::ROLE_ADMIN or $role == \common\models\User::ROLE_MANAGER){ ?>
                                    <div class="chat-btn">

                                        <a class="remove-message" style="font-size: 12px" href="javascript:void(0);"><?= Yii::t('app', 'Удалить') ?></a>

                                    </div>
                                <?php } ?>
                            </div>
                            <br>

                        <?php } ?>

                    <?php }else{ ?>

                    <?php } ?>

                </div>

                <div class="online-users">
                    <?php foreach($userList as $list){ ?>
                        <div class="online-user-list">
                            <?php
                            $role = $list->role;
                            $username = \Yii::$app->user->identity->username;
                            if($list->chat_status == 1) {
                                if(Yii::$app->user->identity->role == 1 || Yii::$app->user->identity->role == 2){
                                    if ($role == 1) {
                                        echo '<span class="online-icon"></span>
                                          <span class="online-username"><a style="color: red" href="javascript:void();" class="username" username="' . $list->username . '">' . $list->username . '</a></span>
                                          <div style="clear: both"></div>';
                                    } else if ($role == 2) {
                                        echo '<span class="online-icon"></span>
                                          <span class="online-username"><a style="color: green" href="javascript:void();" class="username" username="' . $list->username . '">' . $list->username . '</a></span>
                                          <a href="javascript:void(0);" user_ID="' . $list->id . '" class="block">' . Yii::t('app', 'Блокировать') . '</a>
                                          <div style="clear: both"></div>';
                                    } else {
                                        echo '<span class="online-icon"></span>
                                          <span class="online-username"><a style="color: blue" href="javascript:void();" class="username" username="' . $list->username . '">' . $list->username . '</a></span>
                                          <a href="javascript:void(0);" user_ID="' . $list->id . '" class="block">' . Yii::t('app', 'Блокировать') . '</a>
                                          <div style="clear: both"></div>';
                                    }
                                }else{
                                    if ($role == 1) {
                                        echo '<span class="online-icon"></span>
                                          <span class="online-username"><a style="color: red" href="javascript:void();" class="username" username="' . $list->username . '">' . $list->username . '</a></span>
                                          <div style="clear: both"></div>';
                                    } else if ($role == 2) {
                                        echo '<span class="online-icon"></span>
                                          <span class="online-username"><a style="color: green" href="javascript:void();" class="username" username="' . $list->username . '">' . $list->username . '</a></span>
                                          <div style="clear: both"></div>';
                                    } else {
                                        echo '<span class="online-icon"></span>
                                          <span class="online-username"><a style="color: blue" href="javascript:void();" class="username" username="' . $list->username . '">' . $list->username . '</a></span>
                                          <div style="clear: both"></div>';
                                    }
                                }

                            }else{
                                if(Yii::$app->user->identity->role == 1 || Yii::$app->user->identity->role == 2){
                                    if ($role == 1) {
                                        echo '<span class="online-icon"></span>
                                          <span class="online-username"><a style="color: red" href="javascript:void();" class="username" username="' . $list->username . '">' . $list->username . '</a></span>
                                          <div style="clear: both"></div>';
                                    } else if ($role == 2) {
                                        echo '<span class="online-icon"></span>
                                          <span class="online-username"><a style="color: green" href="javascript:void();" class="username" username="' . $list->username . '">' . $list->username . '</a></span>
                                          <a href="javascript:void(0);" user_ID="' . $list->id . '" class="unblock">' . Yii::t('app', 'Разблокировать') . '</a>
                                          <div style="clear: both"></div>';
                                    } else {
                                        echo '<span class="online-icon"></span>
                                          <span class="online-username"><a style="color: blue" href="javascript:void();" class="username" username="' . $list->username . '">' . $list->username . '</a></span>
                                          <a href="javascript:void(0);" user_ID="' . $list->id . '" class="unblock">' . Yii::t('app', 'Разблокировать') . '</a>
                                          <div style="clear: both"></div>';
                                    }
                                }else{
                                    if ($role == 1) {
                                        echo '<span class="online-icon"></span>
                                          <span class="online-username"><a style="color: red" href="javascript:void();" class="username" username="' . $list->username . '">' . $list->username . '</a></span>
                                          <div style="clear: both"></div>';
                                    } else if ($role == 2) {
                                        echo '<span class="online-icon"></span>
                                          <span class="online-username"><a style="color: green" href="javascript:void();" class="username" username="' . $list->username . '">' . $list->username . '</a></span>
                                          <div style="clear: both"></div>';
                                    } else {
                                        echo '<span class="online-icon"></span>
                                          <span class="online-username"><a style="color: blue" href="javascript:void();" class="username" username="' . $list->username . '">' . $list->username . '</a></span>
                                          <div style="clear: both"></div>';
                                    }
                                }
                            }
                            ?>
                        </div>
                    <?php } ?>

                </div>

                <?php if(\Yii::$app->user->identity->chat_status == 1){ ?>

                    <p class="msg_response" style="color:red; display: none; font-weight: bold;"></p>
                    <div style="clear: both"></div>
                    <div class="chat-smile">
                        <div class="smiles">
                            <a href="javascript:void(0);"><img src="/img/smile/1.gif" smiley="*1*" alt=""></a>
                            <a href="javascript:void(0);"><img src="/img/smile/2.gif" smiley="*2*" alt=""></a>
                            <a href="javascript:void(0);"><img src="/img/smile/3.gif" smiley="*3*" alt=""></a>
                            <a href="javascript:void(0);"><img src="/img/smile/4.gif" smiley="*4*" alt=""></a>
                            <a href="javascript:void(0);"><img src="/img/smile/5.gif" smiley="*5*" alt=""></a>
                            <a href="javascript:void(0);"><img src="/img/smile/6.gif" smiley="*6*" alt=""></a>
                            <a href="javascript:void(0);"><img src="/img/smile/7.gif" smiley="*7*" alt=""></a>
                            <a href="javascript:void(0);"><img src="/img/smile/8.gif" smiley="*8*" alt=""></a>
                            <a href="javascript:void(0);"><img src="/img/smile/9.gif" smiley="*9*" alt=""></a>
                            <a href="javascript:void(0);"><img src="/img/smile/10.gif" smiley="*10*" alt=""></a>
                            <a href="javascript:void(0);"><img src="/img/smile/11.gif" smiley="*11*" alt=""></a>
                            <a href="javascript:void(0);"><img src="/img/smile/12.gif" smiley="*12*" alt=""></a>
                            <a href="javascript:void(0);"><img src="/img/smile/13.gif" smiley="*13*" alt=""></a>
                            <a href="javascript:void(0);"><img src="/img/smile/14.gif" smiley="*14*" alt=""></a>
                            <a href="javascript:void(0);"><img src="/img/smile/15.gif" smiley="*15*" alt=""></a>
                            <a href="javascript:void(0);"><img src="/img/smile/16.gif" smiley="*16*" alt=""></a>
                            <a href="javascript:void(0);"><img src="/img/smile/17.gif" smiley="*17*" alt=""></a>
                            <a href="javascript:void(0);"><img src="/img/smile/18.gif" smiley="*18*" alt=""></a>
                            <a href="javascript:void(0);"><img src="/img/smile/19.gif" smiley="*19*" alt=""></a>
                            <a href="javascript:void(0);"><img src="/img/smile/20.gif" smiley="*20*" alt=""></a>
                            <a href="javascript:void(0);"><img src="/img/smile/21.gif" smiley="*21*" alt=""></a>
                            <a href="javascript:void(0);"><img src="/img/smile/22.gif" smiley="*22*" alt=""></a>
                            <a href="javascript:void(0);"><img src="/img/smile/23.gif" smiley="*23*" alt=""></a>
                            <a href="javascript:void(0);"><img src="/img/smile/24.gif" smiley="*24*" alt=""></a>
                            <a href="javascript:void(0);"><img src="/img/smile/25.gif" smiley="*25*" alt=""></a>
                            <a href="javascript:void(0);"><img src="/img/smile/26.gif" smiley="*26*" alt=""></a>
                            <a href="javascript:void(0);"><img src="/img/smile/27.gif" smiley="*27*" alt=""></a>
                            <a href="javascript:void(0);"><img src="/img/smile/28.gif" smiley="*28*" alt=""></a>
                            <a href="javascript:void(0);"><img src="/img/smile/29.gif" smiley="*29*" alt=""></a>
                            <a href="javascript:void(0);"><img src="/img/smile/30.gif" smiley="*30*" alt=""></a>
                            <a href="javascript:void(0);"><img src="/img/smile/31.gif" smiley="*31*" alt=""></a>
                            <a href="javascript:void(0);"><img src="/img/smile/32.gif" smiley="*32*" alt=""></a>
                            <a href="javascript:void(0);"><img src="/img/smile/33.gif" smiley="*33*" alt=""></a>
                            <a href="javascript:void(0);"><img src="/img/smile/34.gif" smiley="*34*" alt=""></a>
                            <a href="javascript:void(0);"><img src="/img/smile/35.gif" smiley="*35*" alt=""></a>
                            <a href="javascript:void(0);"><img src="/img/smile/36.gif" smiley="*36*" alt=""></a>
                            <a href="javascript:void(0);"><img src="/img/smile/37.gif" smiley="*37*" alt=""></a>
                            <a href="javascript:void(0);"><img src="/img/smile/38.gif" smiley="*38*" alt=""></a>
                            <a href="javascript:void(0);"><img src="/img/smile/39.gif" smiley="*39*" alt=""></a>
                            <a href="javascript:void(0);"><img src="/img/smile/40.gif" smiley="*40*" alt=""></a>
                            <a href="javascript:void(0);"><img src="/img/smile/41.gif" smiley="*41*" alt=""></a>
                            <a href="javascript:void(0);"><img src="/img/smile/42.gif" smiley="*42*" alt=""></a>
                            <a href="javascript:void(0);"><img src="/img/smile/43.gif" smiley="*43*" alt=""></a>
                        </div>
                    </div>

                    <textarea id="chatTextarea" rows="4"></textarea>

                    <div style="clear:both"></div>

                    <a href="javascript:void(0);" class="btn btn-success chat_post_btn"><?= Yii::t('app', 'Отправить') ?></a>

                    <?php if(\Yii::$app->user->identity->role == User::ROLE_ADMIN){
                        echo '<a href="javascript:void(0);" class="clear-chat btn btn-danger">' . Yii::t('app', 'Очистить чат') . '</a>';
                    } ?>

                    <?php

                        if(Yii::$app->user->identity->chat_music == 1){
                            echo '<a href="javascript:void(0);"><img src="/img/sound.png" class="music-on" alt=""></a>';
                        }else{
                            echo '<a href="javascript:void(0);"><img src="/img/sound-off.png" class="music-off" width="35px" alt=""></a>';
                        }

                    ?>

                    <?php
                    $role = \Yii::$app->user->identity->role;
                    $username = \Yii::$app->user->identity->username;
                    if($role == 1){
                        echo '<span class="username" style="display: none"><span style="color: red"><a href="' . Url::toRoute('/profile/view/' . $username) . '">'.$username.'</a></span></span>';
                    }else if($role == 2){
                        echo '<span class="username" style="display: none"><span style="color: green"><a href="' . Url::toRoute('/profile/view/' . $username) . '">'.$username.'</a></span></span>';
                    }else{
                        echo '<span class="username" style="display: none"><span style="color: black"><a href="' . Url::toRoute('/profile/view/' . $username) . '">'.$username.'</a></span></span>';
                    }
                    ?>
                    <span class="role" style="display: none"><?=\Yii::$app->user->identity->role; ?></span>
                    <div style="clear: both"></div>

                <?php }else{ ?>



                <?php } ?>

            </div>

        </div>

        <div class="col-md-4">
            <!--        <div class="col-md-4" >-->
            <!--            --><?//=\frontend\widgets\WelcomeWidget::widget(); ?>
            <!--            --><?//=\frontend\widgets\StatisticWidget::widget();?>
            <!--        </div>-->

            <ul class="chat-regulations">

                <p class="chat-regulations-title"><?= Yii::t('app', 'В ЧАТе запрещено') ?></p>

                <?= \common\models\Settings::chatRules(); ?>
            </ul>

        </div>
    </div>
</div>
<?= \frontend\widgets\ReviewsWidget::widget(); ?>

