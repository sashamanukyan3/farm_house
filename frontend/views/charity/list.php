<div class="bmd-page-container padd">
    <div class="container">
        <div class="col-md-12 pri">
            <div class="faq_page_title">Благотворительность</div>
            <ul class="news_ul">
                <?php if($charity){ ?>
                    <?php foreach($charity as $list):?>
                        <blockquote class="bmd-border-primary">

                            <a class="faq_title" href="/charity/view?id=<?= $list->id; ?>"><?= $list->name ?></a>

                        </blockquote>
                    <?php endforeach; ?>
                <?php }else{ ?>

                    Статьи еще не опубликованы

                <?php } ?>
            </ul>
        </div>
<!--        <div class="col-md-4">-->
<!--            --><?//=\frontend\widgets\WelcomeWidget::widget(); ?>
<!--            --><?//=\frontend\widgets\StatisticWidget::widget();?>
<!--        </div>-->
    </div>
</div>

<?= \frontend\widgets\ReviewsWidget::widget(); ?>