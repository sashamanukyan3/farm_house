<?php

use yii\widgets\Pjax;
use yii\widgets\ListView;

?>
<section class="news">
    <div class="container">
        <h2 class="title news__title"><?= Yii::t('app', 'Новости') ?></h2>
            <?=  ListView::widget([
                'id' => 'block_news',
                'options'  => ['class' => 'news__inner'],
                'itemOptions' => ['class' => 'news__preview', 'tag' => 'article'],
                'dataProvider' => $blogDataProvider,
                'itemView' => '_list',
                'viewParams'=> [],
                'summary'=>'',
                'pager' => [
                    'class' => \nirvana\infinitescroll\InfiniteScrollPager::className(),
                    'widgetId' => 'block_news',
                    'itemsCssClass' => 'news__inner',
                    'contentLoadedCallback' => 'fook',
                    'nextPageLabel' => Yii::t('app', 'Загрузить еще'),
                    'registerLinkTags' => true,
                    'linkOptions' => [
                        'class' => 'btn',
                    ],
                    'pluginOptions' => [
                        'contentSelector' => '.news__inner',
                        'loading' => [
                            'msgText' => '<em>' . Yii::t('app', 'Новые новости подгружаются') . '...</em>',
                            'finishedMsg' => '<em>' . Yii::t('app', 'Извините, но вы прочитали все') . '!</em>',
                        ],
                        'behavior' => \nirvana\infinitescroll\InfiniteScrollPager::BEHAVIOR_MASONRY,
                    ],
                ],
            ]);
            ?>
        <a class="news__more link link--size-small" href="#">Показать больше</a>
    </div>
</section>
<script type="text/javascript"><!--
    new Image().src = "//counter.yadro.ru/hit?r" +
        escape(document.referrer) + ((typeof (screen) == "undefined") ? "" :
            ";s" + screen.width + "*" + screen.height + "*" + (screen.colorDepth ?
            screen.colorDepth : screen.pixelDepth)) + ";u" + escape(document.URL) +
        ";" + Math.random();//-->
</script>