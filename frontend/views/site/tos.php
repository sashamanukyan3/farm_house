<div class="bmd-page-container padd">
    <div class="container">
        <div class="col-md-12 pri">
        <div class="faq_page_title"><?= Yii::t('app', 'Пользовательское соглашение') ?></div>
            <ul class="news_ul">
                <?php

                if ($tos) {
                    $contentAttributes = [
                        'ru' => 'content',
                        'en' => 'content_en',
                    ];

                    $attribute = $contentAttributes[Yii::$app->language];
                    echo $tos->$attribute;
                }

                ?>
            </ul>
            </div>
        </div>
    </div>
</div>

<?= \frontend\widgets\ReviewsWidget::widget(); ?>
