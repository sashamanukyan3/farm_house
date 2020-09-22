<?php
use yii\widgets\ActiveForm;
use yii\helpers\Url;
?>
<script>
    $(document).ready(function(){
        $(".reviews:first").addClass("pull-right");

        $(".friendlist-remove").click(function(){

            var id = $(this).closest('.friendlist-text').find('.id').html();
            var remove_object = $(this);
            var validate = $('.msg_response').hide();

            $.ajax({
                url: "<?= Url::toRoute('/profile/list/') ?>",
                type: "POST",
                async:true,
                data: {'type': 2, 'id':id}
            }).done(function(result){
                if(result.removeFriends){
                    remove_object.closest('.lists').fadeOut();
                    var count = $(".friendlist-count").text()-1;
                    $(".friendlist-count").text(count);
                }else{
                    validate.css('color','red');
                    validate.append(removeFriends.msg);
                    validate.show();
                }
            });

        });

    });
</script>
<div class="bmd-page-container padd">
    <div class="container">
        <div class="col-md-12 pri">
            <div id="friendlist">

                <form id="search-form" action="<?= Url::toRoute('/profile/friendlist') ?>" method="get" role="form">
                    <input type="text" class="form-control search-input" id="search-query" name="Search[query]" maxlength="75" placeholder="<?= Yii::t('app', 'Поиск друзей') ?>">
                    <button type="submit" class="search-btn" name="search-button"><img src="/img/search-button.png" alt=""></button>
                </form>
                <?php if(!empty($userList) && empty($msg)){?>
                    <div style="margin-top:10px;"></div>
                <?php if($userList == "" or $query == ""){?>
                        <?= Yii::t('app', 'Не заполнена форма поиска') ?>
                <?php }else{?>
                    <?php foreach($userList as $user){?>
                        <div class="profile-list-friends">
                            <img class="profile-list-img" src="/avatars/<?php echo $user->photo; ?>" alt="">
                            <a href="<?= Url::toRoute('/profile/view/' . $user->username) ?>" class="profile-list-username"><?= $user->username?></a>
                            <span class="id" style="display: none;"><?= $user->id; ?></span>
                            <div style="clear:both;"></div>
                        </div>
                    <?php } ?>
                <?php }} elseif(!empty($msg)){
                    echo '<h4>'.$msg.'</h4>';
                } else{?>
                <?php if(isset($refQuery) && !empty($refQuery)){ ?>
                    <div class="friends-list-center">
                        <h4><?= Yii::t('app', 'Ваш друг-реферер') ?></h4>
                        <?php $form = ActiveForm::begin(['validateOnSubmit' => false]); ?>
                        <div class="profile-list-friends">
                            <div class="friendlist-image">
                                <img class="friendlist-ava" src="<?php if($refQuery->user->photo == null){
                                    echo '/avatars/noavatar.png';
                                }else{
                                    echo '/avatars/'.$refQuery->user->photo;
                                } ?>" alt="">
                            </div>
                            <div class="friendlist-text">
                                <span class="friendlist-login"><?= Yii::t('app', 'Логин') ?>: <a href="<?= Url::toRoute('/profile/view/' . $refQuery->user->username) ?>" class="friendlist-username"><?= $refQuery->user->username; ?></a></span>
                                <div class="clear"></div>
                                <span class="friendlist-level"><?= Yii::t('app', 'Уровень') ?>: <?= $refQuery->user->level; ?></span>
                                <div class="clear"></div>
                                <img src="/img/mail0.png" alt=""><a href="<?= Url::toRoute('/mails/send?username=' . $refQuery->user->username) ?>" class="friendlist-mail" title="<?= Yii::t('app', 'Отправить сообщение') ?>">
                                    <?= Yii::t('app', 'Отправить сообщение') ?>
                                </a>
                                <span class="id" style="display: none;"><?= $refQuery->id; ?></span>
                            </div>
                            <div style="clear:both;"></div>
                        </div>
                        <?php ActiveForm::end(); ?>
                    </div>
                <?php } ?>
                <?php if(isset($user_friends) && count($user_friends) > 0){ ?>
                    <h4><?= Yii::t('app', 'У вас друзей') ?>: <span class="friendlist-count"><?= $friend_count; ?></span></h4>
                    <div class="friends-list-center">

                        <?php foreach ($user_friends as $friend) { ?>
                            <div class="lists">
                                <div class="friendlist-image">
                                    <img class="friendlist-ava" src="<?php if($friend->user->photo == null){
                                        echo '/avatars/noavatar.png';
                                    }else{
                                        echo '/avatars/'.$friend->user->photo;
                                    } ?>" alt="">
                                </div>

                                <div class="friendlist-text">

                                    <span class="friendlist-login"><?= Yii::t('app', 'Логин') ?>: <a href="<?= Url::toRoute('/profile/view/' . $friend->user->username) ?>" class="friendlist-username"><?= $friend->user->username; ?></a></span>
                                    <div class="clear"></div>

                                    <span class="friendlist-level"><?= Yii::t('app', 'Уровень') ?>: <?= $friend->user->level; ?></span>
                                    <div class="clear"></div>

                                    <span class="friendlist-level"><?= Yii::t('app', 'Последний вход') ?>: <?=date('Y-m-d H:i:s', $friend->user->login_date); ?></span>
                                    <div class="clear"></div>

                                    <span class="friendlist-level"><?= Yii::t('app', 'Примерный доход') ?>: <?= $friend->user->ref_for_out; ?> руб') ?></span>
                                    <div class="clear"></div>

                                    <span class="friendlist-level"><?= Yii::t('app', 'Откуда пришел') ?>: <?php if($friend->refLink){ echo '<a href="' . Url::toRoute($friend->refLink) . '" target="_blank">'.mb_substr($friend->refLink, 0, 22, 'utf-8').'...</a>'; }else { echo Yii::t('app', 'Неизвестно'); } ?></span>
                                    <div class="clear"></div>

                                    <img src="/img/mail0.png" alt=""><a href="<?= Url::toRoute('/mails/send?username=' . $friend->user->username) ?>" class="friendlist-mail" title="<?= Yii::t('app', 'Отправить сообщение') ?>">
                                        <?= Yii::t('app', 'Отправить сообщение') ?>
                                    </a>

                                    <span class="id" style="display: none;"><?= $friend->id; ?></span>
                                </div>
                            </div>
                            <div class="clear"></div>
                            <br>
                        <?php } ?>

                    </div>

                    <?php
                    echo \yii\widgets\LinkPager::widget([
                        'pagination' => $pages,
                        'firstPageLabel' => true,
                        'lastPageLabel' => true,
                    ]);
                    ?>

                <?php }else{ ?>
                    У вас пока нет друзей
                <?php } }?>
                <div class="clear"></div>
            </div>
        </div>
        <div class="clear"></div>
        <!--        <div class="col-md-4">-->
        <!--            --><?//=\frontend\widgets\WelcomeWidget::widget(); ?>
        <!--            --><?//=\frontend\widgets\StatisticWidget::widget();?>
        <!--        </div>-->
    </div>
</div>

<?= \frontend\widgets\ReviewsWidget::widget(); ?>