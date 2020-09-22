<?php
use vova07\fileapi\Widget as FileAPI;
use common\models\Settings;
use yii\helpers\Url;
?>

<link rel="stylesheet" href="/css/social.css">
<link rel="stylesheet" href="/css/comment.css">

<script>
    //empty function for infinitive scroll
    function fook()
    {

    }
    $(document).ready(function(){

        $("body").on('click', '.js-like', function(){

            var wallID = $(this).data('wallid');
            var thisA = $(this);
            var validate = $('.msg_response').hide();

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
                validate.css('color','red');
                validate.append(response.msg);
                validate.show();
            }

        });

        $("body").on('click', '.comment_post', function(){

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

                    var findRU = text.indexOf(".ru");
                    var findCOM = text.indexOf(".com");
                    var findNET = text.indexOf(".net");
                    var findORG = text.indexOf(".org");
                    var findHTTP = text.indexOf("http://");
                    var findHTTPS = text.indexOf("https://");
                    var findWWW = text.indexOf("www.");

                    if (findRU >= 0 || findCOM >= 0 || findNET >= 0 || findORG >= 0 || findHTTP >= 0 || findHTTPS >= 0 || findWWW >= 0) {

                        alert('Ошибка!');

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
                                comment.before('<div class="comment-list">' +
                                    '<div class="'+(result.commentID)+'">' +
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
            }
        });

        $("body").on('click','.wall_delete', function(){

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
                    $('.'+comment_id).remove();
                }else{
                    alert('error');
                }
            });

        });

        $("body").on('click','.toggleCommentText', function(){
            var ids = $(this).attr("id");
            $("#toggleComment"+ids).slideToggle();
        });

        $("#toggleDetailText").click(function(){
            $("#toggleDetail").slideToggle();
        });

        $("button[name=wall_button]").click(function(e){

            var text = $("#wall_post_text").val();

            var findRU = text.indexOf(".ru");
            var findCOM = text.indexOf(".com");
            var findNET = text.indexOf(".net");
            var findORG = text.indexOf(".org");
            var findHTTP = text.indexOf("http://");
            var findHTTPS = text.indexOf("https://");
            var findWWW = text.indexOf("www.");

            if (findRU >= 0 || findCOM >= 0 || findNET >= 0 || findORG >= 0 || findHTTP >= 0 || findHTTPS >= 0 || findWWW >= 0) {

                e.preventDefault();
//                alert('В тексты не должны быть ссылки!');
//                return false;

            }

        });

    });
</script>

<span class="msg_response alert alert-danger" style="color:red; display: none; position: fixed; z-index: 9999999; right: 0px; top: 52px">

</span>
<span class="username" style="display: none"><?=\Yii::$app->user->identity->username; ?></span>
<!-- CONTENT -->
<div class="bmd-page-container padd">
    <div class="container">
        <div class="col-md-7 col-md-offset-3 boxshow">
            <div class="col-md-3 pag">
                <div class="">
                    <a href="#">
                        <img src="<?php
                        if(!$user->photo){
                            echo '/avatars/noavatar.png';
                        }else{
                            echo '/avatars/'.$user->photo;
                        }
                        ?>" alt="Картинка" type="button" class="imgsize btn btn-primary bmd-ripple" data-bmd-state="primary"  data-placement="bottom" title=""/>
                    </a>
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
                        <form id="search-form" action="<?= Url::toRoute('/profile/search') ?>" method="get" role="form">
                            <input type="text" class="form-control search-input" id="search-query" name="Search[query]" maxlength="75" placeholder="<?= Yii::t('app', 'Поиск пользователей') ?>">
                            <button type="submit" class="search-btn" name="search-button"><img src="/img/search-button.png" alt=""></button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-9 pag">
                <h4>
                    <b>
                        <?= $user->first_name ?> <?= $user->last_name ?>
                        <a href="<?= Url::toRoute('/profile/edit') ?>"><i class="material-icons editb" type="button" class="btn btn-primary bmd-ripple" data-bmd-state="primary"  data-placement="right" title="" data-original-title="Редактировать стену">&#xe150;</i></a>
                    </b>

                    <p class="line">
                        <?php if($user->sex == \common\models\User::SEX_MALE): ?>
                            <img class="wm" src="/img/man.png"/>
                        <?php else: ?>
                            <img class="wm" src="/img/woman.png"/>
                        <?php endif; ?>
                    </p>
                </h4>
                <span><?= Yii::t('app', 'День рождения') ?>:<span class="rig">
                        <?php if($user->birthday){
                            echo $user->getBirthday($user->birthday);
                        } ?>
                    </span></span><br/>

                <div class="bmd-list-group-primary le">
                    <a href="" class="dinfo" data-toggle="collapse" id="toggleDetailText" aria-expanded="true">
                        <?= Yii::t('app', 'Показать подробную информацию') ?>
                    </a>
                    <div id="toggleDetail" class="collapse" aria-expanded="true">
                        <span><?= Yii::t('app', 'Телефон') ?>:<span class="rig"><?= $user->phone ?></span></span><br/>
                        <span><?= Yii::t('app', 'Страна') ?>:<span class="rig"><?= $user->country ?></span></span><br/>
                        <span><?= Yii::t('app', 'Город') ?>:<span class="rig"><?= $user->city ?></span></span><br/>
                        <span><?= Yii::t('app', 'О себе') ?>:<span class="rig" style="word-break: break-all;"><?= html_entity_decode($user->about) ?></span></span><br/>
                    </div>
                </div>

                <?php
                    if(\Yii::$app->user->identity->photo == null){
                        echo '<span class="avatar" style="display: none">noavatar.png</span>';
                    }else{
                        echo '<span class="avatar" style="display: none">'.\Yii::$app->user->identity->photo.'</span>';
                    }
                ?>

                <?php if($user->level > Settings::$wallLevel){ ?>

                    <div class="form-group">

                        <?php if($error_msg): ?>
                            <span style="color:red"><?= $error_msg ?></span>
                        <?php endif; ?>
                        <?php $form = \yii\widgets\ActiveForm::begin(['validateOnSubmit' => true,'options' => ['enctype' => 'multipart/form-data']]); ?>
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
                              <?= \yii\helpers\Html::submitButton(Yii::t('app', 'Добавить'), ['class' => 'btn btn-success wall_post_btn', 'name' => 'wall_button']) ?>
                            </span>
                            <span class="bmd-field-feedback"></span>
                        </div>
                        <?php \yii\widgets\ActiveForm::end(); ?>

                    </div>

                <?php }else{ ?>
                    <br>
                    <span style="color:red; font-size: 16px; margin-top: 10px"><?= Yii::t('app', 'Оставлять записи, вы сможете только после 3-го уровня') ?></span>
                <?php } ?>

            </div>

            <!-- Social Content -->

            <?= \yii\widgets\ListView::widget([

                'id' => 'block_news',
                'options'  => ['class' => 'block_news'],
                'itemOptions' => ['class' => 'news'],

                'dataProvider' => $blogDataProvider,
                'layout' => "{items} <div class='clearfix'> </div>{pager}",
                'itemView' => '_view',
                'viewParams'=> ['user'=>$user, 'commentModel'=>$commentModel, 'comments'=>$comments],
                'pager' => [
                    'class' => \nirvana\infinitescroll\InfiniteScrollPager::className(),
                    'widgetId' => 'block_news',
                    'itemsCssClass' => 'block_news',
                    'contentLoadedCallback' => 'fook',
                    'nextPageLabel' => 'Загрузить еще',
                    'registerLinkTags' => true,
                    'linkOptions' => [
                        'class' => 'btn',
                    ],
                    'pluginOptions' => [
                        'contentSelector' => '.block_news',
                        'loading' => [
                            'msgText' => "<em>" . Yii::t('app', 'Новые посты подгружаются') . "...</em>",
                            'finishedMsg' => "<em>" . Yii::t('app', 'Извините, но вы прочитали все') . "!</em>",
                        ],
                        'behavior' => \nirvana\infinitescroll\InfiniteScrollPager::BEHAVIOR_MASONRY,
                    ],
                ],
            ]);
            ?>

            <!-- Social Content End -->

        </div>
    </div>
</div>
<?= \frontend\widgets\ReviewsWidget::widget(); ?>
