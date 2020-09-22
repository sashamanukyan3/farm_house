<section class="instruction">
    <div class="container container--small">
        <h2 class="title instruction__title"><?= Yii::t('app', 'Инструкция') ?></h2>
        <ul class="instruction__list">
            <?php foreach($instructions as $instruction){ ?>
                <li class="instruction__list-item <?= $instruction->id == 1 ? 'instruction__list-item--current' : ''; ?>">
                    <a data-id="<?php echo $instruction->id; ?>" href="javascript:void(0)" class="instruction__list-link link link--size-small link--color-transparent">
                        <?= Yii::t('app', $instruction->title) ?>
                    </a>
                </li>
            <?php } ?>
        </ul>
        <div class="prejudice instruction__prejudice"><svg class="svg-sprite-icon icon-warning prejudice__icon">
                <use xlink:href="/img/sprite/symbol/sprite.svg#warning"></use>
            </svg><span class="prejudice__text"><?= Yii::t('app', 'Внимание! В нашей игре, вы можете делать сбор в любое удобное для вас время. <br> У нас нет жёсткой привязки по времени!') ?></span></div>
        <?php foreach($instructions as $instruction): ?>
            <div class="instruction__content <?= $instruction->id == 1 ? 'instruction__content--active' : ''; ?>" data-content-id="<?= $instruction->id; ?>">
                <?php
                $contentAttribute = 'content' . (Yii::$app->language == 'en' ? '_en' : '');
                echo $instruction->$contentAttribute;
                ?>
            </div>
        <?php endforeach; ?>
    </div>
</section>