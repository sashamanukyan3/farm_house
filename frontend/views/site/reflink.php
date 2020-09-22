<div class="bmd-page-container padd">
    <div class="container">
        <div class="col-md-12 pri">
            <div class="faq_page_title"><?= Yii::t('app', 'Рекламные материалы') ?></div>
            <ul class="news_ul" style="padding-bottom: 50px;">
                <p class="contact-sub-title">
                    <?= Yii::t('app', 'Лучше получать по 1% от усилий 100 человек,<br>чем 100% только от своих собственных усилий.') ?>
                    <br>
                    <i>J. Paul Getty</i></p>

                <div class="input-div">
                    <p><?= Yii::t('app', 'Ваша ссылка для привлечения друзей (рефералов)') ?></p>
                    <input class="form-control reflink-input" onclick="this.focus();this.select()" readonly="readonly" type="text" value="https://farmhouse.pro/?ref-id=<?= \Yii::$app->user->identity->id; ?>">

                    <p><?= Yii::t('app', 'Ссылка для привлечения с odnoklassniki.ru') ?>:</p>
                    <input class="form-control reflink-input" onclick="this.focus();this.select()" readonly="readonly" type="text" value="https://farmhouse.pro/?ref-id=<?= \Yii::$app->user->identity->id; ?>">
                </div>

                <?php foreach($Banner as $list):?>
                    <?php
                        $userID = \Yii::$app->user->identity->id;
                        $link = '<a href="https://farmhouse.pro/?ref-id='.$userID.'"><img src="https://farmhouse.pro/uploads/banners/'.$list->img.'"></a>';
                    ?>
                    <div class="reflink-list">
                        <img class="reflink-img" src="/uploads/banners/<?php echo $list->img; ?>" alt="">
                        <p class="reflink-list-text"><?= Yii::t('app', 'Полный код баннера') ?>: </p>
                        <p><textarea onclick="this.focus();this.select()" readonly="readonly" class="form-control reflink-textarea"><?= $link; ?></textarea></p>
                    </div>

                <?php endforeach; ?>
            </ul>
        </div>
        <!--        <div class="col-md-4">-->
        <!--            --><?//=\frontend\widgets\WelcomeWidget::widget(); ?>
        <!--            --><?//=\frontend\widgets\StatisticWidget::widget();?>
        <!--        </div>-->
    </div>
</div>

<?= \frontend\widgets\ReviewsWidget::widget(); ?>