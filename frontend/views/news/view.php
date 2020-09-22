<?php
use yii\helpers\Url;
?>
<section class="blog">
    <?php foreach($news as $new):?>
        <input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />
        <div class="container">
            <h2 class="title blog__title"><?= $new->title ?></h2>
            <div class="blog__info"><span class="blog__info-subtitle subtitle subtitle--transform-uppercase">baseline
                test</span><time class="blog__info-day" datetime="Jun 19">Jun 19</time></div>
        </div>
        <?php echo $new->content ?>
    <?php endforeach; ?>
</section>
<script>
    $(document).ready(function() {

        $("#news-comment-button").click(function(){
            var element = $(this);
            var issetUrl = false;
            var username = $(".name").html();
            var validate = $('.msg_response').hide();
            var avatar = $(".avatar").html();
            var userID = $('.usersID').text();
            var csrfToken = $('meta[name="csrf-token"]').attr("content");

            var text = element.closest('#news-comment-post').find('#news-comment-textarea').val();
            text = $.trim(text);

            var news_id = element.closest('#news-comment-post').find('.id').text();
            news_id = $.trim(news_id);

            if(text == "" || news_id == ""){
                $('.msg_response').html('');
                var message = "<?= Yii::t('app', 'Все поля должны быть заполнены') ?>";
                validate.append(message);
                validate.css('color','red');
                validate.show();
            }else{

                var findRU = text.indexOf(".ru");
                var findCOM = text.indexOf(".com");
                var findNET = text.indexOf(".net");
                var findORG = text.indexOf(".org");
                var findHTTP = text.indexOf("http://");
                var findHTTPS = text.indexOf("https://");
                var findWWW = text.indexOf("www.");

                if (findRU >= 0 || findCOM >= 0 || findNET >= 0 || findORG >= 0 || findHTTP >=0 || findHTTPS >=0 || findWWW >= 0){

                }else {

                    issetUrl = findUrls(text);
                    if (issetUrl.length > 0) {
                        console.log(issetUrl);
                        return 1;
                    }
                    $.ajax({
                        url: "<?= Url::toRoute('/news/viewajax/') ?>",
                        type: "POSt",
                        async: true,
                        data: {'text': text, 'news_id': news_id, 'type': 1, 'id': news_id, 'userID':userID, '_csrf': csrfToken}
                    }).done(function (result) {
                        if (result.newsComment) {
                            var comment = element.parents('div.pri').find('#news-comment-add');
                            var userID = element.closest('.news-comment-list').find('.userID').text();
                            var commentID = result.commentID;
                            comment.before('<div class="news-comment-list">' +

                                '<img src="/avatars/' + avatar + '" class="news-comment-image" alt="">' +

                                '<a href="" class="news-comment-user">' + username + '</a>' +
                                '<span>&nbsp;&nbsp;' + result.date + '</span>' +
                                '&nbsp;&nbsp;<a href="javascript:void(0);" class="reply_comment" data-username="' + username + '"> <?= Yii::t('app', 'Ответить') ?></a>' +

                                '<div class="comment-text-div"><p class="news-comment-content">' + text + '</p>' +
                                '<div class="news-like">' +
                                '<span class="commentID" style="display: none">' + commentID + '</span>' +
                                '<span class="userID" style="display: none">' + userID + '</span>' +
                                '<div class="news-comment-dislike"><span class="news-comment-dislike-count">0</span><a href="javascript:void(0);" class="dislike"><img src="/img/dislike.png" alt=""></a></div>' +
                                '<div class="news-comment-like"><span class="news-comment-like-count">0</span><a href="javascript:void(0);" class="like"><img src="/img/like.png" alt=""></a></div>' +
                                '</div>' +
                                '</div><div style="clear:both"></div>'+
                                '</div>'
                            );
                            $('#news-comment-textarea').val('');
                            $('span.comment_count').text(result.comment_count);

                        } else {
                            $('.msg_response').html('');
                            validate.css('color', 'red');
                            validate.append(result.msg);
                            validate.show();
                        }
                    });

                }

            }

        });

        $("body").on('click','.like', function(){
            var element = $(this);
            var userID = $('.usersID').html();
            var commentID = element.closest('.news-comment-list').find('.commentID').text();
            var validate = $('.msg_response_like').hide();
            var thisA = $(this);
            var csrfToken = $('meta[name="csrf-token"]').attr("content");

            $.ajax({
                url: "/news/ajax/",
                type: "POST",
                async:true,
                data: {'userID': userID, 'commentID': commentID, '_csrf': csrfToken, 'type':1}
            }).done(function(result){
                if(result.newsLike){

                    if(result.dislike_count > result.like_count){
                        element.closest('.news-comment-list').find('.news-comment-content').css({"color":"#777777","cursor":"text"});
                    }else{
                        element.closest('.news-comment-list').find('.news-comment-content').css({"color":"#fff","cursor":"text"});
                    }

                    thisA.parent('.news-comment-like').find(".news-comment-like-count").empty();
                    thisA.parent('div').find(".news-comment-like-count").append(result.like_count);

                    element.closest('.news-like').find('.news-comment-dislike-count').empty();
                    element.closest('.news-like').find(".news-comment-dislike-count").append(result.dislike_count);

                }else{
                    $('.msg_response_like').html('');
                    validate.css('color','red');
                    validate.append(result.msg);
                    validate.show();
                }
            });

        });

        $("body").on('click','.dislike', function(){
            var element = $(this);
            var userID = $('.usersID').html();
            var commentID = element.closest('.news-comment-list').find('.commentID').text();
            var validate = $('.msg_response_like').hide();
            var thisA = $(this);
            var csrfToken = $('meta[name="csrf-token"]').attr("content");

            $.ajax({
                url: "/news/ajax/",
                type: "POST",
                async:true,
                data: {'userID': userID, 'commentID': commentID, '_csrf': csrfToken, 'type':2}
            }).done(function(result){
                if(result.newsDisLike){

                    if(result.dislike_count > result.like_count){
                        element.closest('.news-comment-list').find('.news-comment-content').css({"color":"#777777","cursor":"text"});
                    }else{
                        element.closest('.news-comment-list').find('.news-comment-content').css({"color":"#fff","cursor":"text"});
                    }

                    thisA.parent('.news-comment-dislike').find(".news-comment-dislike-count").empty();
                    thisA.parent('div').find(".news-comment-dislike-count").append(result.dislike_count);
                    element.closest('.news-like').find('.news-comment-like-count').empty();
                    element.closest('.news-like').find(".news-comment-like-count").append(result.like_count);

                }else{
                    $('.msg_response_like').html('');
                    validate.css('color','red');
                    validate.append(result.msg);
                    validate.show();
                }
            });

        });

        $("body").on('click','.news-like-btn', function(){
            var element = $(this);
            var userID = $('.usersID').html();
            var newsID = $('.newsID').html();
            var validate = $('.msg_response_like').hide();
            var csrfToken = $('meta[name="csrf-token"]').attr("content");

            $.ajax({
                url: "/news/ajaxlike/",
                type: "POST",
                async:true,
                data: {'userID': userID, 'newsID': newsID, '_csrf': csrfToken, 'type':10}
            }).done(function(result){
                if(result.newsLike){

                    element.closest('.news-view-div').find(".news-like-count").empty();
                    element.closest('.news-view-div').find(".news-like-count").append(result.news_like_count);

                    element.closest('.news-view-div').find('.news-dislike-count').empty();
                    element.closest('.news-view-div').find(".news-dislike-count").append(result.news_dislike_count);

                }else{
                    $('.msg_response_like').html('');
                    validate.css('color','red');
                    validate.append(result.msg);
                    validate.show();
                }
            });

        });

        $("body").on('click','.news-dislike-btn', function(){
            var element = $(this);
            var userID = $('.usersID').html();
            var newsID = $('.newsID').html();
            var validate = $('.msg_response_like').hide();
            var csrfToken = $('meta[name="csrf-token"]').attr("content");

            $.ajax({
                url: "<?= Url::toRoute('/news/ajaxlike/') ?>",
                type: "POST",
                async:true,
                data: {'userID': userID, 'newsID': newsID, '_csrf': csrfToken, 'type':11}
            }).done(function(result){
                if(result.newsDisLike){

                    element.closest('.news-view-div').find(".news-dislike-count").empty();
                    element.closest('.news-view-div').find(".news-dislike-count").append(result.news_dislike_count);

                    element.closest('.news-view-div').find('.news-like-count').empty();
                    element.closest('.news-view-div').find(".news-like-count").append(result.news_like_count);

                }else{
                    $('.msg_response_like').html('');
                    validate.css('color','red');
                    validate.append(result.msg);
                    validate.show();
                }
            });

        });

        var i = $("#news-comment .news-comment-list").length;
        var a = i-3;

        if(i > 3){
            $("#news-comment .news-comment-list:gt(2)").hide();
            var showAllStr = "<?= Yii::t('app', 'Показать все') ?>";
            var commentsStr = "<?= Yii::t('app', 'комментария') ?>";
            $("#news-comment").append('<a id="show-comment" class="show-comment-btn" href="javascript:void(0);">' + showAllStr + ' ('+(i-3)+') ' + commentsStr + '</a>');
        }

        $("#show-comment").click(function(){
            var time = 0;
            $("#news-comment .news-comment-list:hidden").each(function(){
                time = time + 150;
                $(this).delay(time).fadeIn(300);
            });
            $(this).fadeOut(300);
            return false;
        });

        /* Reply Comment */
        $("body").on('click','.reply_comment', function(){
            var username = $(this).data('username');
            $('textarea#news-comment-textarea').val("<b>"+username+"</b>" + ", ");
            $('textarea#news-comment-textarea').focus();
        });

    });
</script>