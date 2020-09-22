<?php
use vova07\fileapi\Widget as FileAPI;
use common\models\WallPost;
use common\models\Friends;
use common\models\User;
use common\models\Settings;
use yii\helpers\Url;
?>

<link rel="stylesheet" href="/css/social.css">
<link rel="stylesheet" href="/css/comment.css">

<script>
    $(document).ready(function(){

        $(".js-like").on('click', function(){
            $('.msg_response').html('');

            var validate = $('.msg_response').hide();
            var wallID = $(this).data('wallid');
            var thisA = $(this);
            if(wallID){
                $.ajax({
                    url: "<?= Url::toRoute('/profile/like/') ?>",
                    type: "POST",
                    async:true,
                    data: {'wallID': wallID}
                }).done(function(response){
                    if(response.status){
                        response.like ? thisA.addClass('js-like-success') : thisA.removeClass('js-like-success');
                        thisA.parent('.rig').find(".js-like-count").empty();
                        thisA.parent('span').find(".js-like-count").append(response.like_count);
                    }else{
                        validate.css('color','red');
                        validate.append(response.msg);
                        validate.show();
                    }
                });
            }else{
                alert('error');
            }


        });


        $(".comment_post").click(function(){
            $('.msg_response').html('');
            var element = $(this);

            var text = element.closest('.input-group').find('.comment-text').val();
            text = $.trim(text);
            var wall_id = element.closest('.input-group').find('#wall_id').val();
            wall_id = $.trim(wall_id);
            var username = $(".username").text();
            var avatar = $(".avatar").html();
            var validate = $('.msg_response').hide();

            var findRU = text.indexOf(".ru");
            var findCOM = text.indexOf(".com");
            var findNET = text.indexOf(".net");
            var findORG = text.indexOf(".org");
            var findHTTP = text.indexOf("http://");
            var findHTTPS = text.indexOf("https://");
            var findWWW = text.indexOf("www.");

            if (findRU >= 0 || findCOM >= 0 || findNET >= 0 || findORG >= 0 || findHTTP >=0 || findHTTPS >=0 || findWWW >= 0){

//                alert('В тексты не должны быть ссылки!');

            }else {

                if (text == "" || wall_id == "") {
                    var message = "<?= Yii::t('app', 'Все поля должны быть заполнены') ?>";
                    validate.append(message);
                    validate.css('color', 'red');
                    validate.show();
                } else {

                    $.ajax({
                        url: "<?= Url::toRoute('/profile/comment/') ?>",
                        type: "POST",
                        async: true,
                        data: {'text': text, 'wall_id': wall_id, 'type': 1}
                    }).done(function (result) {
                        if (result.status) {
                            var count = element.closest('.wall_content').find('.comment_count').html();
                            count++;
                            element.closest('.wall_content').find(".comment_count").empty().html(count);
                            element.closest('.wall_content').find(".comment-text").val("");
                            var comment = element.closest('#comments').find('.comment-add');
                            comment.before('<div class="comment-list" style="position: relative">' +
                                '<div id="'+(result.commentID)+'">' +
                                '<img src="/avatars/' + avatar + '" class="comment-image" alt="">' +
                                '<a href="" class="comment-user">' + username + '</a>' +
                                '<p class="comment-content">' + text + '</p>' +
                                '<a href="javascript:void(0);" class="comment_delete" style="position: absolute; right: 10px; top: 10px;" comment_id="'+(result.commentID)+'">Удалить</a></div></div>'
                            );
                        } else {
                            validate.css('color', 'red');
                            validate.append(result.msg);
                            validate.show();
                        }
                    });

                }

            }

        });

        IS_ENABLED_SOW = true;

        $("body").on('click','.add-friends', function(){

            if(!IS_ENABLED_SOW)
            {
                return 1;
            }
            else
            {
                IS_ENABLED_SOW = false;
            }

            var to = $(".to").text();
            var from = $(".from").text();
            var validate = $('.msg_response').hide();
            $(".id").text('');

            if(to == "" || from == ""){
                var message = "<?= Yii::t('app', 'Ошибка') ?>";
                alert(message);
            }else{

                $.ajax({
                    url: "<?= Url::toRoute('/profile/friends/') ?>",
                    type: "POST",
                    async:true,
                    data: {'to': to, 'from': from, 'type': 1}
                }).done(function(result){
                    if(result.addfriends){
                        var message = "<?= Yii::t('app', 'Вы отправили заявку') ?>";
                        $(".friends-status").text(message);
                        $(".add-friends").removeClass("add-friends").addClass("remove-friends");
                    }else{
                        validate.css('color','red');
                        validate.append(result.msg);
                        validate.show();
                    }
                });

                IS_ENABLED_SOW = true;
                return 1;

            }

        });

        $("body").on('click','.remove-friends', function(){

            if(!IS_ENABLED_SOW)
            {
                return 1;
            }
            else
            {
                IS_ENABLED_SOW = false;
            }

            var to = $(".to").text();
            var from = $(".from").text();
            var id = $(".id").text();

            $.ajax({
                url: "<?= Url::toRoute('/profile/friends/') ?>",
                type: "POST",
                async:true,
                data: {'to': to, 'from': from, 'type': 2}
            }).done(function(result){
                if(result.removeFriends){
                    var message = "<?= Yii::t('app', 'Добавить в друзья') ?>";
                    $(".friends-status").text(message);
                    $(".remove-friends").removeClass("remove-friends").addClass("add-friends");
                }else{
                    alert('error');
                }
            });

            IS_ENABLED_SOW = true;
            return 1;

        });

        $(".wall_delete").click(function(){

            var wall_id = $(this).attr('wall_id');

            $.ajax({
                url: "<?= Url::toRoute('/profile/ajaxwalldelete/') ?>",
                type: "POST",
                async:true,
                data: {'wall_id':wall_id}
            }).done(function(result){
                if(result.removeWall){
                    $('#'+wall_id).remove();
                }else{
                    alert('error');
                }
            });

        });

        $("body").on('click','.comment_delete', function(){
            var element = $(this);
            var comment_id = $(this).attr('comment_id');
            var count = element.closest('.wall_content').find('.comment_count').html();
            count--;
            element.closest('.wall_content').find(".comment_count").empty().html(count);
            $.ajax({
                url: "<?= Url::toRoute('/profile/ajaxcommentdelete/') ?>",
                type: "POST",
                async:true,
                data: {'comment_id':comment_id}
            }).done(function(result){
                if(result.removeComment){
                    $('#'+comment_id).remove();
                }else{
                    alert('error');
                }
            });

        });

        $(".banned-btn").click(function(){

            $(".profile-banned-div").slideToggle();

        });

        $(".banned-post").click(function(){

            var banId = $(this).attr('id');
            var banText = $("#banned-text").val();

            $.ajax({
                url: "<?= Url::toRoute('/profile/banned/') ?>",
                type: "POST",
                async:true,
                data: {'banId':banId, 'banText':banText}
            }).done(function(result){
                if(result.banned){
                    $(".banned-ajax-text").append('<span style="font-size: 16px; color: red">Пользователь забанен</span>');
                    $(".pag").remove();
                }else{
                    alert('error');
                }
            });

        });

    });
</script>
<span class="username" style="display: none"><?= \Yii::$app->user->identity->username;?></span>
<span class="msg_response alert alert-danger" style="color:red; display: none; position: fixed; z-index: 9999999; right: 0px; top: 52px"></span>
<span class="id"></span>
<!-- CONTENT -->
<div class="bmd-page-container padd">
    <div class="container">
        <div class="col-md-7 col-md-offset-3 boxshow">
            <div class="banned-ajax-text"></div>
            <?php if($user->banned == 1):
                    echo '<span style="font-size: 16px; color: red">Пользователь забанен</span>';
                else: ?>
            <div class="col-md-3 pag">
                <div class="">
                        <img src="<?php
                        if($user->photo == null):
                            echo '/avatars/noavatar.png';
                        else:
                            echo '/avatars/'.$user->photo;
                        endif;
                        ?>" alt="Картинка" type="button" class="imgsize btn btn-primary bmd-ripple" data-bmd-state="primary" data-placement="bottom" title=""/>

                    <div class="mag botto">
                        <span class="curs"> <?= $user->username; ?></span>
                    </div>
                    <div class="mag botto">
                    <span class="curs"> <?= Yii::t('app', 'Уровень') ?>:
                        <span class="badge bmd-bg-primary rig"><?= $user->level ?></span>
                    </span>
                    </div>
                    <div class="frend">
                        <div class="botto"><span class="curs"><a href="<?= Url::toRoute('/profile/viewlist?id=' . $user->id) ?>"><span style="color: #000"><?= Yii::t('app', 'Друзья') ?></span><span class="badge bmd-bg-info rig"><?php echo $friend_count; ?></span></a></span></div>
                        <div class="botto"><span class="curs"><a href="<?= Url::toRoute('/profile/viewrequests?id=' . $user->id) ?>"><span style="color: #000"><?= Yii::t('app', 'Заявки') ?></span><span class="badge bmd-bg-info rig"><?php echo $requets_count; ?></span></a></span></div>
                        <div class="botto"><span class="curs"><a href="<?= Url::toRoute('/profile/viewgiftlist?id=' . $user->id) ?>"><span style="color: #000"><?= Yii::t('app', 'Подарки') ?></span><span class="badge bmd-bg-info rig"><?php echo $giftCount; ?></span></a></span></div>
                        <form id="search-form" action="<?= Url::toRoute('/profile/search') ?>" method="get" role="form">
                            <input type="text" class="form-control search-input" id="search-query" name="Search[query]" maxlength="75" placeholder="<?= Yii::t('app', 'Поиск пользователей') ?>">
                            <button type="submit" class="search-btn" name="search-button"><img src="/img/search-button.png" alt=""></button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-9 pag">
                <h4> <b style="float:left"> <?= $user->first_name ?> <?= $user->last_name ?> </b> </h4>

                <?php if($user->sex == User::SEX_MALE): ?>
                    <img class="wm" src="/img/man.png"/>
                <?php else: ?>
                    <img class="wm" src="/img/woman.png"/>
                <?php endif; ?>

                <?php

                    $to = $user->id;
                    $from = Yii::$app->user->id;

                    $friendsControl = Friends::find()->innerJoinWith('user', 'friends.to' == 'user.id')
                        ->where(['friends.to' => $to, 'friends.from' => $from])
                        ->orWhere(['friends.from' => $to, 'friends.to' => $from])->one();

                    if($friendsControl): ?>

                        <a href="<?= Url::toRoute('/profile/gift?username=' . $user->username) ?>" title="<?= Yii::t('app', 'Сделать подарок') ?>">
                            <img src="/img/gift.png" class="gift-icon-gift" alt="">
                        </a>
                        <a href="<?= Url::toRoute('/mails/send?username=' . $user->username) ?>" class="list-send-mail" title="<?= Yii::t('app', 'Написать письмо') ?>">
                            <img src="/img/mails-icon.png" class="list-mails-icon" alt="">
                        </a>

                <?php endif; ?>

                <a href="<?= Url::toRoute('/profile/index') ?>" style="float: right"><?= Yii::t('app', 'Вернуться на свою стену') ?></a>
                <?php if(Yii::$app->user->identity->role == User::ROLE_ADMIN and Yii::$app->user->identity->id != $user->id): ?>
                    <a href="javascript:void(0);" class="banned-btn" style="float: right; margin-right: 10px; color: red"><?= Yii::t('app', 'Забанить') ?></a>
                    <div class="profile-banned-div">
                        <textarea class="form-control" id="banned-text"></textarea>
                        <a href="javascript:void(0);" id="<?= $user->id; ?>" class="btn btn-default banned-post"><?= Yii::t('app', 'Забанен') ?></a>
                    </div>
                <?php endif; ?>

                <span class="to" style="display: none"><?= $user->id ?></span>
                <span class="from" style="display: none"><?= Yii::$app->user->id; ?></span><br>
                <?php $form = \yii\widgets\ActiveForm::begin(); ?>
                <?php

                $to = $user->id;
                $from = Yii::$app->user->id;

                if($to != $from):

                    $friends = Friends::find()->innerJoinWith('user', 'friends.to' == 'user.id')
                        ->where(['friends.to' => $to, 'friends.from' => $from])
                        ->orWhere(['friends.from' => $to, 'friends.to' => $from])->one();

                    if ($friends):

                            if (($friends->to == $to and $friends->from == $from) or ($friends->from == $to and $friends->to == $from)) :
                                if ($friends->status == 1) :
                                    echo '<a class="remove-friends" href="javascript:void(0);"><span class="friends-status">' . Yii::t('app', 'у Вас в друзьях') . '</span></a>';
                                    echo '<span class="id" style="display: none;">' . $friends->id . '</span>';
                                 elseif ($friends->status == 3):
                                    echo '<a class="remove-friends" href="javascript:void(0);"><span class="friends-status">' . Yii::t('app', 'Вы отправили заявку') . '</span></a>';
                                    echo '<span class="id" style="display: none;">' . $friends->id . '</span>';
                                endif;
                            endif;

                    else:
                        echo '<a class="add-friends"  href="javascript:void(0);"><span class="friends-status">' . Yii::t('app', 'Добавить в друзья') . '</span></a>';
                    endif;
                endif;

                ?>
                <?php \yii\widgets\ActiveForm::end(); ?>

                <span><?= Yii::t('app', 'День рождения') ?>:<span class="rig"><?= $user->getBirthday($user->birthday); ?></span></span><br/>
                <span><?= Yii::t('app', 'Телефон') ?>:<span class="rig"><?= $user->phone ?></span></span><br/>
                <span><?= Yii::t('app', 'Страна') ?>:<span class="rig"><?= $user->country ?></span></span><br/>
                <span><?= Yii::t('app', 'Город') ?>:<span class="rig"><?= $user->city ?></span></span><br/>
                <span><?= Yii::t('app', 'О себе') ?>:<span class="rig" style="word-break: break-all;"><?= html_entity_decode($user->about) ?></span></span><br/>

                <?php if($myUser->level > Settings::$wallLevel): ?>

                    <div class="form-group">

                        <?php

                        $fri = Friends::find()->innerJoinWith('user', 'friends.to' == 'user.id')
                            ->where(['friends.to' => $to, 'friends.from' => $from, 'friends.status' => 1])
                            ->orWhere(['friends.from' => $to, 'friends.to' => $from, 'friends.status' => 1])->one();

                        if($fri):

                            ?>

                            <?php if($error_msg): ?>
                                <span style="color:red"><?= $error_msg ?></span>
                            <?php endif; ?>

                            <?php $form = \yii\widgets\ActiveForm::begin(['validateOnSubmit' => false]); ?>
                            <div class="input-group">
                                <div class="bmd-field-group">
                                    <div class="bmd-field-group">
                                        <?= $form->field($model, 'content')->textArea(['class' => 'bmd-input inp', 'id' => 'wall_post_text', 'rows' => 6, 'resize' => 'none', 'maxlength'=>150, 'placeholder' => Yii::t('app', 'Что вы думаете?')])->label(false); ?>
                                        <span class="bmd-bar"></span>
                                    </div>
                                </div>

                                <span style="display: none"><?= $form->field($model, 'user_wall_id')->textInput(['value' => $user->id])->label(false); ?></span>

                                <?= $form->field($model, 'file')->fileInput(['class' => 'file']); ?>

                                <br>
                                <span class="input-group-btn">
                                  <?= \yii\helpers\Html::submitButton(Yii::t('app', 'Добавить'), ['class' => 'btn btn-success wall_post_btn', 'name' => 'well_button']) ?>
                                </span>
                                <span class="bmd-field-feedback"></span>
                            </div>
                            <?php \yii\widgets\ActiveForm::end(); ?>

                        <?php endif; ?>

                    </div>

                <?php else: ?>
                    <br>
                    <span style="color:red; font-size: 16px; margin-top: 10px"><?= Yii::t('app', 'Оставлять записи, вы сможете только после 3-го уровня') ?></span>
                <?php endif; ?>

            </div>

            <!-- Social Content -->
            <div class="col-md-12">
                <?php $wall_post = \common\models\WallPost::find()->where(['user_wall_id' => $user->id])->orderBy(['id' => SORT_DESC])->all(); ?>
                <div class="post_table">
                    <?php foreach($wall_post as $wall): ?>
                        <div class="wall_delete_div" id="<?php echo $wall->id ?>">
                            <div class="wall_text">
                                <a href="#">

                                    <?php
                                    $users = WallPost::find()->innerJoinWith('user', 'wall_post.user_id = user.id')->where(['wall_post.id' => $wall->id])->one();
                                    echo $users->user->username;
                                    ?>

                                </a>

                                <?php
                                if($wall->user_id == Yii::$app->user->identity->id || $wall->user_wall_id == $myUser->level):
                                    echo '<a href="javascript:void(0);" wall_id="'.$wall->id.'" class="wall_delete">' . Yii::t('app', 'Удалить') . '</a>';
                                endif;
                                ?>
                            </div>
                            <div class="wall_content">
                                <div class="wall_all">
                                    <div class="wall_dialog">
                                        <p><?= $wall->content; ?></p>
                                    </div>
                                </div>
                                <div class="wall_info">
                                    <?php $comments_count = \common\models\WallComments::find()->where(['wall_id' => $wall->id])->count(); ?>
                                    <span class="wi"><a role="button" data-toggle="collapse" href="#collapseExample<?= $wall->id; ?>" aria-expanded="false" aria-controls="collapseExample">
                                            <i class="icsoc material-icons">&#xe0b9;</i> <?= Yii::t('app', 'Комментарий') ?> (<span class="comment_count"><?php echo $comments_count; ?></span>)</a></span>
                                    <span class="rig wi">
                                        <a class="js-like"  data-wallid="<?=$wall->id?>" data-userid="<?=$user->id?>" href="javascript:void(0);"><?= Yii::t('app', 'Мне нравится') ?> <i class="icsoc material-icons">&#xe87d;</i></a>
                                        <span class="js-like-count"><?= $wall->like_count ?></span>
                                    </span>
                                </div>

                                <div class="collapse" id="collapseExample<?= $wall->id; ?>">
                                    <div class="">
                                        <div id="comments">

                                            <?php

                                            $comments = \common\models\WallComments::find()->innerJoinWith('user', 'wall_comments.user_id = user.id')->where(['wall_comments.wall_id' => $wall->id])->orderBy(['id' => SORT_ASC])->all();

                                            foreach ($comments as $comment) { ?>
                                                <div class="comment-list">
                                                    <div id="<?= $comment->id; ?>">
                                                        <?php if($comment->user->photo == null):
                                                            echo '<img src="/avatars/noavatar.png" class="comment-image" alt="">';
                                                        else:
                                                            echo '<img src="/avatars/'.$comment->user->photo.'" class="comment-image" alt="">';
                                                        endif; ?>

                                                        <a href="" class="comment-user"><?= $comment->user->username; ?> </a>

                                                        <p class="comment-content"><?= $comment->text; ?></p>

                                                        <?php if($comment->user_id == Yii::$app->user->identity->id):
                                                            echo '<a href="javascript:void(0);" comment_id="'.$comment->id.'" class="comment_delete">' . Yii::t('app', 'Удалить') . '</a>';
                                                        endif; ?>
                                                    </div>
                                                </div>

                                                <?php
                                                if(!Yii::$app->user->identity->photo):
                                                    echo '<span class="avatar" style="display: none">noavatar.png</span>';
                                                else:
                                                    echo '<span class="avatar" style="display: none">'.Yii::$app->user->identity->photo.'</span>';
                                                endif;
                                                ?>


                                            <?php } ?>

                                            <div class="comment-add"></div>

                                            <div class="comment-form">

                                                <div class="input-group">

                                                    <?php if (Yii::$app->user->isGuest) :
                                                        echo '<a href="' . Url::toRoute('/site/login/') . '">Login</a>';
                                                    else: ?>

                                                        <div class="comment-form">
                                                            <?php $form = \yii\widgets\ActiveForm::begin(['validateOnSubmit' => false]); ?>
                                                            <div class="input-group">

                                                                <div class="bmd-field-group">
                                                                    <?= $form->field($commentModel, 'text')->textArea(['class' => 'bmd-input inp comment-text','id' => 'text', 'rows' => 4, 'value' => '', 'maxlength' => 150])->label(false); ?>
                                                                    <span class="bmd-bar"></span>
                                                                </div>

                                                                <?= $form->field($commentModel, 'wall_id')->hiddenInput(['value' => $wall->id, 'id' => 'wall_id'])->label(false); ?>

                                                                <span class="input-group-btn" style="float: left">
                                                      <?= \yii\helpers\Html::button(Yii::t('app', 'Добавить'), [ 'class' => 'btn btn-success comment_post', 'name' => 'well_button']); ?>
                                                    </span>
                                                                <span class="bmd-field-feedback"></span>
                                                            </div>
                                                            <?php \yii\widgets\ActiveForm::end(); ?>
                                                        </div>

                                                    <?php endif; ?>
                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <!-- Social Content End -->

            <?php endif; ?>

        </div>
    </div>
</div>
<?= \frontend\widgets\ReviewsWidget::widget(); ?>