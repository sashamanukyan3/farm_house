<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => '<span class="glyphicon glyphicon-cog"></span> Административная панель',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar'
        ],
    ]);
    $menuItems = [
        ['label' => '<span class="glyphicon glyphicon-home"></span> Главная', 'url' => ['/site/index']],
    ];
    $menuItems[] = [
        'label' => '<span class="glyphicon glyphicon-eye-open"></span> Просмотр сайта',
        'url' => Yii::$app->urlManagerFrontend->baseUrl,
        'linkOptions' => ['target' => '_blank']
    ];

    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => '<span class="glyphicon glyphicon-log-in"></span> Войти', 'url' => ['/site/login']];
    } else {
        $menuItems[] = [
            'label' => '<span class="glyphicon glyphicon-log-out"></span> Выйти (' . Yii::$app->user->identity->username . ')',
            'url' => ['/site/logout'],
            'linkOptions' => ['data-method' => 'post']
        ];
    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
        'encodeLabels' => false,
    ]);
    NavBar::end();
    ?>
    <div class="container">
        <?= Breadcrumbs::widget([
            'homeLink' => ['label' => 'Главная', 'url' => ['/site/index']],
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?php if(!Yii::$app->user->isGuest): ?>
            <div class="col-md-3">
                <?php
                echo Nav::widget(
                    [
                        'encodeLabels' => false,
                        'options' => [
                            'class' => 'nav nav-tabs nav-stacked'
                        ],
                        'items' => [
                            [
                                'label' => '<span class="glyphicon glyphicon-home"></span> Главная',
                                'url' => ['/site/index']
                            ],
                            [
                                'label' => '<span class="glyphicon glyphicon-edit"></span> Семена/Поле',
                                'url' => ['/plant/index']
                            ],
                            [
                                'label' => '<span class="glyphicon glyphicon-edit"></span> Корм животных',
                                'url' => ['/animal-food/index']
                            ],
                            [
                                'label' => '<span class="glyphicon glyphicon-edit"></span> Животные',
                                'url' => ['/animals/index']
                            ],
                            [
                                'label' => '<span class="glyphicon glyphicon-edit"></span> Загоны',
                                'url' => ['/animal-pens/index']
                            ],
                            [
                                'label' => '<span class="glyphicon glyphicon-edit"></span> Фабрики',
                                'url' => ['/factories/index']
                            ],
                            [
                                'label' => '<span class="glyphicon glyphicon-edit"></span> Продукция для фабрик',
                                'url' => ['/fabric-product-type/index']
                            ],
                            [
                                'label' => '<span class="glyphicon glyphicon-edit"></span> Пекарни',
                                'url' => ['/bakeries/index']
                            ],
                            [
                                'label' => '<span class="glyphicon glyphicon-edit"></span> Продукция для пекарний',
                                'url' => ['/product-for-bakery/index']
                            ],
                            [
                                'label' => '<span class="glyphicon glyphicon-edit"></span> Пироги',
                                'url' => ['/shop-bakery/index']
                            ],
                            [
                                'label' => '<span class="glyphicon glyphicon-edit"></span> Инструкция',
                                'url' => ['/instruction/index']
                            ],
                            [
                                'label' => '<span class="glyphicon glyphicon-edit"></span> F.A.Q',
                                'url' => ['/faq/index']
                            ],
                            [
                                'label' => '<span class="glyphicon glyphicon-edit"></span> Новости',
                                'url' => ['/news/index']
                            ],
                            [
                                'label' => '<span class="glyphicon glyphicon-edit"></span> Комментарий к стене',
                                'url' => ['/wall-comments/index']
                            ],
                            [
                                'label' => '<span class="glyphicon glyphicon-edit"></span> Комментарий к новостям',
                                'url' => ['/news-comments/index']
                            ],
                            [
                                'label' => '<span class="glyphicon glyphicon-edit"></span> Подарки',
                                'url' => ['/gifts/index']
                            ],
                            [
                                'label' => '<span class="glyphicon glyphicon-edit"></span> Рекламные материалы',
                                'url' => ['/banner/index']
                            ],
                            [
                                'label' => '<span class="glyphicon glyphicon-edit"></span> Благотворительность',
                                'url' => ['/charity/index']
                            ],
                            [
                                'label' => '<span class="glyphicon glyphicon-edit"></span> Отзывы',
                                'url' => ['/reviews/index']
                            ],
                            [
                                'label' => '<span class="glyphicon glyphicon-edit"></span> Тех. поддержка',
                                'url' => ['/support/index']
                            ],
                            [
                                'label' => '<span class="glyphicon glyphicon-edit"></span> Биржа опыта',
                                'url' => ['/exchange/index']
                            ],
                            [
                                'label' => '<span class="glyphicon glyphicon-edit"></span> Пользователи',
                                'url' => ['/users/index']
                            ],
                            [
                                'label' => '<span class="glyphicon glyphicon-edit"></span> Запросы на вывод',
                                'url' => ['/pay-out/index']
                            ],
                            [
                                'label' => '<span class="glyphicon glyphicon-edit"></span> Список всех запросов',
                                'url' => ['/pay-out/list']
                            ],
                            [
                                'label' => '<span class="glyphicon glyphicon-edit"></span> Список всех выплат',
                                'url' => ['/pay-out/out-list']
                            ],
                            [
                                'label' => '<span class="glyphicon glyphicon-edit"></span> Список всех пополнений',
                                'url' => ['/pay-in/index']
                            ],
                            [
                                'label' => '<span class="glyphicon glyphicon-edit"></span> Статистика',
                                'url' => ['/pay-out/stat']
                            ],
                            [
                                'label' => '<span class="glyphicon glyphicon-edit"></span> Контакты',
                                'url' => ['/contact/update/1']
                            ],
                            [
                                'label' => '<span class="glyphicon glyphicon-edit"></span> Пользовательское соглашение',
                                'url' => ['/contact/tos']
                            ]
                        ]
                    ]
                );
                ?>
            </div>
        <?php endif; ?>
        <div class="col-md-9">
            <?= $content ?>
        </div>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; Название игры<?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
