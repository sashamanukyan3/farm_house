<section class="payments">
    <div class="container">
        <div class="payments__wrapper">
            <div class="main-holder">
                <h2 class="title payments__title"><?= Yii::t('app', 'Последние выплаты') ?></h2>
            </div>
            <div class="payments__inner">
                <div class="payments__wrapper">
                    <div class="payments__main">
                        <div class="payments__box">
                            <?php $i=1; foreach($payOutList as $history) : ?>
                                <?php $class = ($i%2==0) ? 'info' : 'active'; ?>

                                <div class="payments__row">
                                    <div class="payments__col"><span class="payments__text payments__text--id">#<?= $i ?></span></div>
                                    <div class="payments__col"><span class="payments__text payments__text--name"><?= $history->username ?></span></div>
                                    <div class="payments__col"><span class="payments__text payments__text--subject"><?=$history->amount; ?></span></div>
                                    <div class="payments__col"><span class="payments__text payments__text--desc"><?=date('Y-m-d H:i:s', $history->created_at); ?></span></div>
                                    <div class="payments__col"><span class="payments__text payments__text--day"><?=date('Y-m-d H:i:s', $history->created_at); ?>Сен 9</span></div>
                                </div>
                                <?php $i++ ?>
                            <?php endforeach; ?>


                        </div>
                    </div>
                </div>
                <div class="pagination payments__pagination"><a class="pagination__link" href="#"><svg
                                class="svg-sprite-icon icon-arrow-right pagination__icon pagination__icon--left">
                            <use xlink:href="static/images/sprite/symbol/sprite.svg#arrow-right"></use>
                        </svg></a><a class="pagination__link pagination__link--current" href="#">1</a><a
                            class="pagination__link" href="#">2</a><a class="pagination__link" href="#">3</a><a
                            class="pagination__link" href="#">4</a><a class="pagination__link" href="#">5</a><a
                            class="pagination__link" href="#"><svg
                                class="svg-sprite-icon icon-arrow-right pagination__icon pagination__icon--right">
                            <use xlink:href="static/images/sprite/symbol/sprite.svg#arrow-right"></use>
                        </svg></a></div>
            </div>
        </div>
    </div>
</section>