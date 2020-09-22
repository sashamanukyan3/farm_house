<div class="bmd-page-container padd">
    <div class="container">
        <div class="col-md-12 pri">
            <ul class="news_ul" style="padding-top: 20px; padding-bottom: 20px">

                <h4><?= Yii::t('app', 'Пользователей онлайн') ?>: <?= $online_users_count; ?></h4>

                <?php $i=1; if($online_users): ?>

                        <table class="mails-table">
                            <tr>
                                <td style="width: 50px; text-align: center"><?= Yii::t('app', '№') ?></td>
                                <td style="width: 400px; text-align: center;"><?= Yii::t('app', 'Пользователь') ?></td>
                                <td style="width: 300px; text-align: center;"><?= Yii::t('app', 'Страница') ?></td>
                            </tr>
                            <?php foreach ($online_users as $users): ?>
                                <tr>
                                    <td class="mails-out-data" style="text-align: center"><?= $i++; ?></td>
                                    <td class="mails-out-data" style="text-align: center"><?php
                                            if($users->username){
                                                echo $users->user->username;
                                            }else{
                                                echo Yii::t('app', 'Гость');
                                            }
                                        ?></td>
                                    <td class="mails-out-username" style="text-align: center"><?= Yii::t('app', $users->location) ?></td>
                                </tr>
                            <?php endforeach; ?>

                        </table>

                <?php endif; ?>

            </ul>
        </div>
    </div>
</div>

<?= \frontend\widgets\ReviewsWidget::widget(); ?>