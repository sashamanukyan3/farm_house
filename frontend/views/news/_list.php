<?php

use yii\helpers\Url;

$titleAttribute = 'title' . (Yii::$app->language == 'en' ? '_en' : '');
$teaserAttribute = 'teaser' . (Yii::$app->language == 'en' ? '_en' : '');
$text = mb_substr($model->$titleAttribute, 0, 31, 'UTF-8');
$desc = mb_substr($model->$teaserAttribute, 0, 135, 'UTF-8');
$textLength = strlen($text);
$descLength = strlen($desc);
?>
    <img class="news__preview-thumbnail" src="/img/content/news/news-image-1.jpg">
    <div class="news__preview-box">
        <div class="news__preview-head">
<!--            <div class="news__preview-subtitle">-->
<!--                baseline test-->
<!--            </div>-->
            <a class="news__preview-title" title="<?= $model->$titleAttribute ?>" href="<?= Url::toRoute('/news/view/' . $model->id) ?>"><?= $text ?><?= $textLength >= 31 ? '...' : '' ?></a>
        </div>
        <div class="news__preview-main">
                     <span class="news__preview-desc">
                         <?php echo $desc ?> <?= $descLength >= 135 ? '...' : '' ?>
                     </span>
        </div>
        <div class="news__preview-footer">
            <a class="news__preview-link link" href="<?= Url::toRoute('/news/view/' . $model->id) ?>"><?= Yii::t('app', 'Читать') ?></a>
            <time class="news__preview-day" datetime="2020-06-19 14:54:39">
                <?= date('M j', $model->created_at)  ?>
            </time>
        </div>
    </div>

