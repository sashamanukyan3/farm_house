<?php

/* @var $this \yii\web\View */

/* @var $content string */

use frontend\widgets\BreadcrumbsMicrodata;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;
use yii\widgets\ActiveForm;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <?php $this->title = Yii::t('app', 'Фермерский дом'); ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="hidden">
<script>
    window.appLang = "<?= Yii::$app->language ?>";
</script>
<div class="preloader__wrapper">
    <div class="preloader">
        <div class="preloader__ring">
            <div class="preloader__sector">L</div>
            <div class="preloader__sector">o</div>
            <div class="preloader__sector">a</div>
            <div class="preloader__sector">d</div>
            <div class="preloader__sector">i</div>
            <div class="preloader__sector">n</div>
            <div class="preloader__sector">g</div>
            <div class="preloader__sector">.</div>
            <div class="preloader__sector">.</div>
            <div class="preloader__sector">.</div>
            <div class="preloader__sector"></div>
            <div class="preloader__sector"></div>
            <div class="preloader__sector"></div>
            <div class="preloader__sector"></div>
            <div class="preloader__sector"></div>
            <div class="preloader__sector"></div>
            <div class="preloader__sector"></div>
            <div class="preloader__sector"></div>
            <div class="preloader__sector"></div>
            <div class="preloader__sector"></div>
            <div class="preloader__sector"></div>
            <div class="preloader__sector"></div>
            <div class="preloader__sector"></div>
            <div class="preloader__sector"></div>
            <div class="preloader__sector"></div>
            <div class="preloader__sector"></div>
            <div class="preloader__sector"></div>
            <div class="preloader__sector"></div>
            <div class="preloader__sector"></div>
            <div class="preloader__sector"></div>
        </div>
        <div class="preloader__ring">
            <div class="preloader__sector">L</div>
            <div class="preloader__sector">o</div>
            <div class="preloader__sector">a</div>
            <div class="preloader__sector">d</div>
            <div class="preloader__sector">i</div>
            <div class="preloader__sector">n</div>
            <div class="preloader__sector">g</div>
            <div class="preloader__sector">.</div>
            <div class="preloader__sector">.</div>
            <div class="preloader__sector">.</div>
            <div class="preloader__sector"></div>
            <div class="preloader__sector"></div>
            <div class="preloader__sector"></div>
            <div class="preloader__sector"></div>
            <div class="preloader__sector"></div>
            <div class="preloader__sector"></div>
            <div class="preloader__sector"></div>
            <div class="preloader__sector"></div>
            <div class="preloader__sector"></div>
            <div class="preloader__sector"></div>
            <div class="preloader__sector"></div>
            <div class="preloader__sector"></div>
            <div class="preloader__sector"></div>
            <div class="preloader__sector"></div>
            <div class="preloader__sector"></div>
            <div class="preloader__sector"></div>
            <div class="preloader__sector"></div>
            <div class="preloader__sector"></div>
            <div class="preloader__sector"></div>
            <div class="preloader__sector"></div>
        </div>
    </div>
</div>
<?php $this->beginBody() ?>
<div class="wrapper">

    <header class="header <?php if(!Yii::$app->user->isGuest) echo 'header--big' ?>">
        <div class="container <?php if(!Yii::$app->user->isGuest) echo 'container--fluid' ?>">
            <div class="header__inner">
                <button class="hamburger hamburger--arrowalt" type="button"><span class="hamburger-box"><span
                                class="hamburger-inner"></span></span></button>
                <nav class="header__menu <?php if(!Yii::$app->user->isGuest) echo 'header__menu--center' ?>">
                    <ul class="header__menu-list">
<!--                        --><?php //var_dump(Yii::$app->controller->action->uniqueId ); ?>
                        <li class="header__menu-item" data-da="menu__list, 0, 1051"><a class="header__menu-link"
                                                                                       href="<?= Url::toRoute('/') ?>"><?= Yii::t('app', 'Главная') ?></a>
                        </li>
                        <li class="header__menu-item" data-da="menu__list, 1, 1051"><a class="header__menu-link"
                                                                                       href="<?= Url::toRoute('/news') ?>"><?= Yii::t('app', 'Новости') ?></a>
                        </li>
                        <li class="header__menu-item" data-da="menu__list, 2, 1051"><a class="header__menu-link"
                                                                                       href="<?= Url::toRoute('/instruction') ?>"><?= Yii::t('app', 'Инструкция') ?></a>
                        </li>
                        <li class="header__menu-item" data-da="menu__list, 3, 1051"><a class="header__menu-link"
                                                                                       href="<?= Url::toRoute('/faq') ?>">FAQ</a>
                        </li>
                        <li class="header__menu-item" data-da="menu__list, 4, 1051"><a class="header__menu-link"
                                                                                       href="<?= Url::toRoute('/reviews/index') ?>">Отзывы</a>
                        </li>
                        <?php if(!Yii::$app->user->isGuest) { ?>
                            <li class="header__menu-item" data-da="menu__list, 5, 1051"><a class="header__menu-link"
                                                                                           href="<?= Url::toRoute('/reviews') ?>">Об игре</a></li>
                            <li class="header__menu-item" data-da="menu__list, 6, 1051"><a class="header__menu-link"
                                                                                           href="<?=Url::toRoute('/site/statistics')?>">Статистика</a></li>
                        <?php } ?>
                        <li class="header__menu-item header__menu-item--color-grayish-purple"><a
                                    class="header__menu-link header__menu-link--size-small"
                                    href="#">Благотворительность</a></li>
                    </ul>
                </nav>
                <?php if (Yii::$app->user->isGuest) : ?>
                    <div class="header__group">
                        <a data-fancybox data-src="#login" href="javascript:void(0);"
                           class="header__group-link"><?= Yii::t('app', 'Войти') ?></a>
                        <a data-fancybox data-src="#registration" href="javascript:void(0);" class="header__group-link"><?= Yii::t('app', 'Регистрация') ?></a>
                    </div>
                <?php else: ?>
                    <div class="header__auth">
                        <a class="header__auth-link" href="#" data-count="18">
                            <svg class="svg-sprite-icon icon-envelope header__auth-link-icon">
                                <use xlink:href="/img/sprite/symbol/sprite.svg#envelope"></use>
                            </svg>
                        </a>
                        <div class="header__auth-box">
                            <a class="header__auth-user" href="/profile.html">
                                <img class="header__auth-userpic" src="/img/common/logo-user.png">
                                <svg class="svg-sprite-icon icon-arrow-down header__auth-icon">
                                    <use xlink:href="/img/sprite/symbol/sprite.svg#arrow-down"></use>
                                </svg>
                            </a>
                            <div class="header__dropdown">
                                <?= common\modules\languages\widgets\ListWidget::widget() ?>
                                <a href="<?=Url::toRoute('/site/logout')?>" class="header__dropdown-link">Выход</a>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </header>
    <nav class="menu" data-simplebar>

        <div class="menu__top">
            <svg class="svg-sprite-icon icon-arrow-left menu__icon">
                <use xlink:href="/img/sprite/symbol/sprite.svg#arrow-left"></use>
            </svg>
            <?php if(Yii::$app->user->isGuest): ?>
                <a data-fancybox data-src="#login" class="menu__link btn" href="#"><?= Yii::t('app', 'Играть') ?></a>
            <?php else : ?>
                <a class="menu__link btn" href="<?= Url::toRoute('/game') ?>"><?= Yii::t('app', 'Играть') ?></a>
            <?php endif; ?>
        </div>

        <ul class="menu__list">
            <?php if(Yii::$app->user->isGuest) : ?>
            <li class="menu__list-item"><a class="menu__list-link" href="#">Пользовательское соглашение</a></li>
            <li class="menu__list-item"><a class="menu__list-link" href="<?= Url::toRoute('/top') ?>">Топ 100</a></li>
            <li class="menu__list-item"><a class="menu__list-link" href="<?= Url::toRoute('/pay/last') ?>">Последние выплаты</a>
            </li>
            <li class="menu__list-item">
                <?= common\modules\languages\widgets\ListWidget::widget() ?>
            </li>
            <li class="menu__list-item">
                <a class="menu__list-link" href="<?= Url::toRoute('/contact') ?>">
                    Контакты
                </a>
            </li>
            <?php else: ?>
                <li class="menu__list-item"><a class="menu__list-link" href="/profile.html">Профиль</a></li>
                <li class="menu__list-item"><a class="menu__list-link" href="/balance.html">Баланс</a></li>
                <li class="menu__list-item"><a class="menu__list-link" href="/feed.html">Стена</a></li>
                <li class="menu__list-item"><a class="menu__list-link" href="/friends.html">Друзья</a></li>
                <li class="menu__list-item"><a class="menu__list-link menu__list-link--count" href="/messages.html"
                                               data-count="18">Сообщения</a></li>
                <li class="menu__list-item"><a class="menu__list-link" href="/gifts.html">Подарки</a></li>
                <li class="menu__list-item"><a class="menu__list-link" href="/experience.html">Биржа опыта</a></li>
                <li class="menu__list-item"><a class="menu__list-link" href="/bonus.html">Бонус</a></li>
                <li class="menu__list-item"><a class="menu__list-link" href="/top-100.html">Топ 100</a></li>
                <li class="menu__list-item"><a class="menu__list-link" href="/history.html">История</a></li>
                <li class="menu__list-item"><a class="menu__list-link" href="/support.html">Тех.Поддержка</a></li>
                <li class="menu__list-item"> <?= Html::a(Yii::t('app', 'Выход'), ['site/logout'], ['class' => 'menu__list-link', 'data' => ['method' => 'POST']]) ?></li>
            <?php endif; ?>
        </ul>
    </nav>
    <div class="content">
        <main class="main">
            <?php if(Yii::$app->request->url !== Yii::$app->homeUrl): ?>
                <div class="breadcrumbs">
                    <div class="container">
                        <?php
                        echo BreadcrumbsMicrodata::widget([
                            'options' => [
                                'class' => 'breadcrumbs__list'
                            ],
                            'itemTemplate' => "<li class='breadcrumbs__list-item'>{link}</li>\n",
                            'activeItemTemplate' => '<li class="breadcrumbs__list-item">{link}</li>',
                            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                        ]);
                        ?>
                    </div>
                </div>

            <?php endif; ?>
            <?= $content ?>
        </main>
    </div>
</div>
<script type="text/javascript"><!--
    new Image().src = "//counter.yadro.ru/hit?r" +
        escape(document.referrer) + ((typeof (screen) == "undefined") ? "" :
            ";s" + screen.width + "*" + screen.height + "*" + (screen.colorDepth ?
            screen.colorDepth : screen.pixelDepth)) + ";u" + escape(document.URL) +
        ";" + Math.random();//--></script>

<?=\frontend\widgets\LoginWidget::widget(); ?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
