<?php
use yii\widgets\LinkPager;
use yii\helpers\Url;
?>
<script type="text/javascript" src="/js/urlControl.js"></script>
<script>
    $(document).ready(function() {
        $(".reviews-post").click(function(){

            var element = $(this);
            var issetUrl = false;
            var content = element.closest('.reviews-form').find('#reviews-textarea').val();
                content = $.trim(content);
            var validate = $('.msg_response').hide();

            var level = $(".level").html();

            if(content == ""){
                $('.msg_response').text('');
                var message = "<?= Yii::t('app', 'Все поля должны быть заполнены') ?>";
                validate.append(message);
                validate.css('color','red');
                validate.show();
            }else{

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

                    var username = $(".username").html();
                    var avatar = $(".avatar").html();
                        avatar = $.trim(avatar);
                    var sex = $(".sex").html();
                        sex = $.trim(sex);

                    issetUrl = findUrls(content);
                    if (issetUrl.length > 0) {
                        console.log(issetUrl);
                        return 1;
                    }
                    $.ajax({
                        url: "<?= Url::toRoute('/reviews/send/') ?>",
                        type: "POST",
                        async: true,
                        data: {'content': content, 'level': level, 'type': 1}
                    }).done(function (result) {
                        if (result.reviews) {
                            $('.msg_response').html('');
                            validate.append(result.reviews);
                            validate.css('color', 'red');
                            validate.show();
                        } else {
                            $('#reviews-textarea').val('');
                            var content = result.content;
                            var date = result.date;
                            var link = "<?= Url::toRoute('/profile/view') ?>";
                            $(".reviews-div").before('<div class="news-comment-list">'+
                                '<a href="' + link + '/' +username+'" target="_blank" class="reviews-username">'+username+'</a>'+

                                '<img class="wm" src="/img/'+ $.trim(sex)+'">'+

                                '<span>('+date+')</span>'+
                                '<div style="clear: both"></div>'+

                                '<img src="/avatars/'+ $.trim(avatar)+'" class="reviews-image" alt="">'+

                                '<span class="reviews-content">'+content+'</span>'+

                                '<div style="clear: both"></div>'+
                            '</div>');
                        }
                    });

                }

            }

        });
    });

</script>

<div class="bmd-page-container padd">
    <div class="container">
        <span class="level" style="display: none"><?= (!Yii::$app->user->isGuest) ? $user->level : '' ?></span>
        <span class="username" style="display: none"><?= (!Yii::$app->user->isGuest) ? \Yii::$app->user->identity->username : '' ?></span>
        <span class="avatar" style="display: none">
            <?php
                if(!Yii::$app->user->isGuest){
                    if(!Yii::$app->user->identity->photo){
                        echo 'noavatar.png';
                    }else{
                        echo trim(Yii::$app->user->identity->photo);
                    }
                }
            ?>
        </span>
        <span class="sex" style="display: none">
            <?php
            if(!Yii::$app->user->isGuest){
                if(Yii::$app->user->identity->sex == 1){
                    echo 'man.png';
                }else{
                    echo 'woman.png';
                }
            }
            ?>
        </span>
        <div class="col-md-12 pri">
            <div class="faq_page_title"><?= Yii::t('app', 'Отзывы о игре') ?></div>

            <?php
                if (!Yii::$app->user->isGuest) : ?>

                <div class="reviews-form col-md-4">
                    <span class="msg_response" style="font-weight: bold;"></span>
                    <br>
                    <span class="reviews-form-text"><?= Yii::t('app', 'В этом разделе фермеры оставили свои отзывы о игре') ?></span>
                    <br>
                    <span class="reviews-form-text"><?= Yii::t('app', 'Оставить отзыв (Можно оставить только 1 раз)') ?></span>

                    <?php $form = \yii\widgets\ActiveForm::begin(['validateOnSubmit' => false]); ?>

                    <?= $form->field($model, 'content')->textArea(['id' => 'reviews-textarea', 'rows' => 4, 'resize' => 'none', 'placeholder' => ''])->label(false); ?>
                    <span class="bmd-bar"></span>

                    <div style="clear:both"></div>

                    <?= \yii\helpers\Html::button('Отправить', ['class' => 'btn btn-success reviews-post']); ?>

                    <?php \yii\widgets\ActiveForm::end(); ?>
                </div>
            <?php endif ?>

            <div style="clear: both"></div>
            <br>
            <div class="reviews-div"></div>
            <?php foreach($reviews as $review) : ?>
                <div class="news-comment-list">
                    <?php $r_username = $review->user->username; ?>
                    <a href="<?= Url::toRoute('/profile/view/' . $r_username) ?>" class="reviews-username"><?= $r_username ?></a>

                    <?php if($review->user->sex == \common\models\User::SEX_MALE): ?>
                        <img class="wm" src="/img/man.png"/>
                    <?php else: ?>
                        <img class="wm" src="/img/woman.png"/>
                    <?php endif; ?>

                    <span>(<?= date('Y-m-d H:i:s', $review->date); ?>)</span>
                    <div style="clear: both"></div>

                    <img src="/avatars/<?= $review->user->photo ?>" class="reviews-image" alt="">

                    <span class="reviews-content"><?= $review->content; ?></span>

                <div style="clear: both"></div>
                </div>
            <?php endforeach ?>
            <div class="col-md-3 review-pager btn-mod-2">
                <?= \yii\widgets\LinkPager::widget([
                    'pagination' => $pages,
                    'maxButtonCount' => 5,
                    'options' => [
                        'class' => 'btn-group btn-group-justified',
                    ],
                ]);
                ?>
            </div>

        </div>
    </div>
</div>

<?= \frontend\widgets\ReviewsWidget::widget(); ?>