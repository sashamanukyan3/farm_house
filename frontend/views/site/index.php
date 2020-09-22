<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\models\User;
use common\models\Session;
use yii\helpers\Url;

?>
<section class="slider">
    <div class="container">
        <div class="slider__header">
            <div class="slider__header-preview"
                 style="background-image: url(/img/content/slider/slider-preview-image.jpg)">
                <h1 class="slider__title"><?= Yii::t('app', 'Фермерский дом') ?></h1>
                <button data-fancybox data-src="#video" class="slider__btn" type="button">
                              <span class="slider__btn-icon">
                                 <svg class="svg-sprite-icon icon-play">
                                    <use xlink:href="/img/sprite/symbol/sprite.svg#play"></use>
                                 </svg>
                              </span>
                    <span class="slider__btn-text subtitle"><?= Yii::t('app', 'Смотреть <br> видео') ?></span>
                </button>
                <?php if (Yii::$app->user->isGuest): ?>
                    <a data-fancybox data-src="#login" href="#" class="slider__link btn"><?= Yii::t('app', 'Начать игру') ?></a>
                <?php else: ?>
                    <a href="<?= Url::toRoute('/game') ?>"
                       class="slider__link btn"><?= Yii::t('app', 'Начать игру') ?></a>
                <?php endif; ?>
            </div>
            <div class="info-user slider__info-user">
                <?php if (!Yii::$app->user->isGuest) { ?>
                    <div class="info-user__top">
                        <div class="info-user__userpic" data-level="<?= $user->level ?>"><img
                                    class="info-user__userpic-image" src="<?php if (!$user->photo) {
                                echo '/img/common/logo-user.png';
                            } else {
                                echo '/avatars/' . $user->photo . '';
                            } ?>" alt="пользователь"></div>
                        <div class="info-user__box">
                            <a class="info-user__name"
                               href="<?= Url::toRoute('/profile/index') ?>"><?= $user->username ?></a>
                            <span class="info-user__subtitle subtitle"><?= Yii::t('app', 'Добро пожаловать') ?></span>
                        </div>
                    </div>
                    <div class="info-user__statistics">
                        <div class="info-user__progress"
                             data-percentage="<?= (($user->experience) * 100) / ($user->need_experience) ?>%">
                            <div class="info-user__progress-holder">
                                <span class="info-user__statistics-title"><?= Yii::t('app', 'Опыт') ?></span>
                                <div class="info-user__statistics-count" data-count-after="<?= $user->experience; ?>"
                                     data-count-before=" / <?= $user->need_experience; ?>"></div>
                            </div>
                            <div class="info-user__progress-outer">
                                <span class="info-user__progress-content info-user__progress-content--color-blue"></span>
                            </div>
                        </div>
                        <div class="info-user__progress" data-percentage="<?php if (($user->energy) > 1000) {
                            echo 100;
                        } else {
                            echo ($user->energy) / 10;
                        } ?>%">
                            <div class="info-user__progress-holder">
                                <span class="info-user__statistics-title"><?= Yii::t('app', 'Энергия') ?></span>
                                <div class="info-user__statistics-count" data-count-after=""
                                     data-count-before="<?= $user->energy; ?>"></div>
                            </div>
                            <div class="info-user__progress-outer"><span
                                        class="info-user__progress-content info-user__progress-content--color-red"></span>
                            </div>
                        </div>
                    </div>
                    <div class="info-user__payment">
                        <div class="info-user__payment-row"><span
                                    class="info-user__payment-title"><?= Yii::t('app', 'Оплата') ?></span><span
                                    class="info-user__payment-price">
                            <?= number_format($user->for_pay, 0, '.', ' ') ?> <?= Yii::t('app', 'руб') ?>
                        </span>
                        </div>
                        <div class="info-user__payment-row"><span
                                    class="info-user__payment-title"><?= Yii::t('app', 'Вывод') ?></span><span
                                    class="info-user__payment-price">
                            <?= number_format($user->for_out, 0, '.', ' ') ?> <?= Yii::t('app', 'руб') ?>
                        </span>
                        </div>
                    </div>
                <?php } else { ?>
                    <h3 class="info-user__subtitle">
                        <?= Yii::t('app', 'Фермерский дом'); ?>
                    </h3>
                    <p class="info-user__text">
                        <?= Yii::t('app', 'gameDescription'); ?>
                    </p>
                <?php } ?>
            </div>
        </div>
        <div class="slider__body">
            <div class="slider__body-row">
                <div class="slider__body-col slider__body-col--color-orange"><span
                            class="slider__body-subtitle subtitle"><?= Yii::t('app', 'Старт игры') ?></span><span
                            class="slider__body-number">21.05.2018</span></div>
                <div class="slider__body-col slider__body-col--color-green"><span
                            class="slider__body-subtitle subtitle"><?= Yii::t('app', 'Резерв выплат') ?></span><span
                            class="slider__body-number"
                            data-prefix="₽"><?= number_format($allPayDiff, 0, '.', ' ') ?></span></div>
                <div class="slider__body-col slider__body-col--color-blue"><span
                            class="slider__body-subtitle subtitle"><?= Yii::t('app', 'Резерв ярмарки') ?></span><span
                            class="slider__body-number"
                            data-prefix="₽"><?= number_format($farmstorage->money_storage, 0, '.', ' ') ?></span></div>
                <div class="slider__body-col slider__body-col--color-yellow"><span
                            class="slider__body-subtitle subtitle"><?= Yii::t('app', 'Выплачено') ?></span><span
                            class="slider__body-number"
                            data-prefix="₽"><?= number_format($allPayOutSum, 0, '.', ' ') ?></span></div>
            </div>
        </div>
        <div class="slider__footer">
            <ul class="slider__footer-list">
                <li class="slider__footer-item slider__footer-item--current"><a class="slider__footer-link"
                                                                                href="javascript:void(0)"
                                                                                data-id="1"><?= Yii::t('app', 'Куплено сегодня') ?></a>
                </li>
                <li class="slider__footer-item"><a class="slider__footer-link" href="javascript:void(0)"
                                                   data-id="2"><?= Yii::t('app', 'Куплено') ?></a></li>
                <li class="slider__footer-item"><a class="slider__footer-link" href="javascript:void(0)"
                                                   data-id="3"><?= Yii::t('app', 'Статистика покупок') ?></a></li>
            </ul>
            <div class="slider__footer-content slider__footer-content--active" data-content-id="1">
                <div class="slider__footer-row">
                    <div class="slider__footer-col">
                        <span class="slider__footer-subtitle subtitle">
                            <?= Yii::t('app', 'Кур') ?></span><span
                                class="slider__footer-number"><?= number_format(explode(':', $statistics->today_bought_chickens)[0], 0, '.', ' ') ?></span>
                    </div>
                    <div class="slider__footer-col">
                        <span class="slider__footer-subtitle subtitle">
                            <?= Yii::t('app', 'Бычков') ?></span><span
                                class="slider__footer-number"><?= number_format(explode(':', $statistics->today_bought_bulls)[0], 0, '.', ' ') ?></span>
                    </div>
                    <div class="slider__footer-col">
                        <span class="slider__footer-subtitle subtitle">
                            <?= Yii::t('app', 'Коз') ?></span><span
                                class="slider__footer-number"><?= number_format(explode(':', $statistics->today_bought_goats)[0], 0, '.', ' ') ?></span>
                    </div>
                    <div class="slider__footer-col">
                        <span class="slider__footer-subtitle subtitle">
                             <?= Yii::t('app', 'Коров') ?></span><span
                                class="slider__footer-number"><?= number_format(explode(':', $statistics->today_bought_cows)[0], 0, '.', ' ') ?></span>
                    </div>
                </div>
            </div>
            <div class="slider__footer-content" data-content-id="2">
                <div class="slider__footer-row">
                    <div class="slider__footer-col">
                        <span class="slider__footer-subtitle subtitle">
                            <?= Yii::t('app', 'Полей') ?></span><span
                                class="slider__footer-number"><?= number_format(explode(':', $statistics->all_bought_lands)[0], 0, '.', ' ') ?></span>
                    </div>
                    <div class="slider__footer-col">
                        <span class="slider__footer-subtitle subtitle">
                            <?= Yii::t('app', 'Загонов кур') ?></span><span
                                class="slider__footer-number"><?= number_format(explode(':', $statistics->all_bought_paddock_chickens)[0], 0, '.', ' ') ?></span>
                    </div>
                    <div class="slider__footer-col">
                        <span class="slider__footer-subtitle subtitle">
                            <?= Yii::t('app', 'Загонов бычков') ?></span><span
                                class="slider__footer-number"><?= number_format(explode(':', $statistics->all_bought_paddock_bulls)[0], 0, '.', ' ') ?></span>
                    </div>
                    <div class="slider__footer-col">
                        <span class="slider__footer-subtitle subtitle">
                            <?= Yii::t('app', 'Загонов коз') ?></span><span
                                class="slider__footer-number"><?= number_format(explode(':', $statistics->all_bought_paddock_goats)[0], 0, '.', ' ') ?></span>
                    </div>
                    <div class="slider__footer-col">
                        <span class="slider__footer-subtitle subtitle">
                            <?= Yii::t('app', 'Загонов коров') ?></span><span
                                class="slider__footer-number"><?= number_format(explode(':', $statistics->all_bought_paddock_cows)[0], 0, '.', ' ') ?></span>
                    </div>
                    <div class="slider__footer-col">
                        <span class="slider__footer-subtitle subtitle">
                            <?= Yii::t('app', 'Фабрика теста') ?></span><span
                                class="slider__footer-number"><?= number_format(explode(':', $statistics->all_bought_factory_dough)[0], 0, '.', ' ') ?></span>
                    </div>
                    <div class="slider__footer-col">
                        <span class="slider__footer-subtitle subtitle">
                            <?= Yii::t('app', 'Фабрика фарша') ?></span><span
                                class="slider__footer-number"><?= number_format(explode(':', $statistics->all_bought_factory_mince)[0], 0, '.', ' ') ?></span>
                    </div>
                    <div class="slider__footer-col">
                        <span class="slider__footer-subtitle subtitle">
                            <?= Yii::t('app', 'Фабрика сыра') ?></span><span
                                class="slider__footer-number"><?= number_format(explode(':', $statistics->all_bought_factory_cheese)[0], 0, '.', ' ') ?></span>
                    </div>
                    <div class="slider__footer-col">
                        <span class="slider__footer-subtitle subtitle">
                            <?= Yii::t('app', 'Фабрика творога') ?></span><span
                                class="slider__footer-number"><?= number_format(explode(':', $statistics->all_bought_factory_curd)[0], 0, '.', ' ') ?></span>
                    </div>
                    <div class="slider__footer-col">
                        <span class="slider__footer-subtitle subtitle">
                            <?= Yii::t('app', 'Пекарней "с мясом') ?></span><span
                                class="slider__footer-number"><?= number_format(explode(':', $statistics->all_bought_meat_bakery)[0], 0, '.', ' ') ?></span>
                    </div>
                    <div class="slider__footer-col">
                        <span class="slider__footer-subtitle subtitle">
                            <?= Yii::t('app', 'Пекарней "с сыром') ?></span><span
                                class="slider__footer-number"><?= number_format(explode(':', $statistics->all_bought_cheese_bakery)[0], 0, '.', ' ') ?></span>
                    </div>
                    <div class="slider__footer-col">
                        <span class="slider__footer-subtitle subtitle">
                            <?= Yii::t('app', 'Пекарней "с творогом') ?></span><span
                                class="slider__footer-number"><?= number_format(explode(':', $statistics->all_bought_curd_bakery)[0], 0, '.', ' ') ?></span>
                    </div>
                </div>
            </div>
            <div class="slider__footer-content" data-content-id="3">
                <div class="slider__footer-row">
                    <div class="slider__footer-col">
                        <span class="slider__footer-subtitle subtitle">
                            <?= Yii::t('app', 'Кур') ?>
                        </span>
                        <span class="slider__footer-number"><?= number_format(explode(':', $statistics->all_bought_chickens)[0], 0, '.', ' ') ?>
                        </span>
                    </div>
                    <div class="slider__footer-col">
                        <span class="slider__footer-subtitle subtitle">
                            <?= Yii::t('app', 'Бычков') ?>
                        </span>
                        <span class="slider__footer-number"><?= number_format(explode(':', $statistics->all_bought_bulls)[0], 0, '.', ' ') ?>
                        </span>
                    </div>
                    <div class="slider__footer-col">
                        <span class="slider__footer-subtitle subtitle">
                            <?= Yii::t('app', 'Коз') ?>
                        </span>
                        <span class="slider__footer-number"><?= number_format(explode(':', $statistics->all_bought_goats)[0], 0, '.', ' ') ?>
                        </span>
                    </div>
                    <div class="slider__footer-col">
                        <span class="slider__footer-subtitle subtitle">
                            <?= Yii::t('app', 'Коров') ?>
                        </span>
                        <span class="slider__footer-number"><?= number_format(explode(':', $statistics->all_bought_cows)[0], 0, '.', ' ') ?>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div id="video" class="popup">
    <iframe width="100%" height="315" src="https://www.youtube.com/embed/ChcN5ua-CMc" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
</div>