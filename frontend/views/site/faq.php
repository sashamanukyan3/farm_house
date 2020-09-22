<section class="faq">
    <div class="container container--small">
        <h2 class="title faq__title">FAQ</h2>
        <ul class="c-accordion faq__accordion">
            <?php foreach($faqs as $faq):?>
                <?php

                $titleAttribute = 'title' . (Yii::$app->language == 'en' ? '_en' : '');

                if (!$faq->$titleAttribute) {
                    continue;
                }

                $contentAttribute = 'content' . (Yii::$app->language == 'en' ? '_en' : '');

                ?>
                <li class="c-accordion__item">
                    <a class="c-accordion__title js-accordion__toggle" href="javascript:void(0)">
                        <?php echo $faq->$titleAttribute ?>
                        <svg class="svg-sprite-icon icon-arrow-down c-accordion__icon">
                            <use xlink:href="static/images/sprite/symbol/sprite.svg#arrow-down"></use>
                        </svg>
                    </a>
                    <div class="c-accordion__content"><?php echo $faq->$contentAttribute ?></div>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</section>