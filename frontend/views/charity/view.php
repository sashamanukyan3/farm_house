<?php if($charity){ ?>
<!-- CONTENT -->
<div class="col-md-12">
    <div class="col-md-12 ferma-bg">
        <div class="col-md-12 ferma-bg-1">
            <center>
                <h4>Описания</h4>
                <p>Благотворительность — оказание бескорыстной (безвозмездной или на льготных условиях) помощи тем, кто в этом нуждается. Основной чертой благотворительности является добровольный выбор вида, времени и места, а также содержания помощи.Благотворительная деятельность в России регулируется Федеральным законом № 135 от 11 августа 1995 г. «О благотворительной деятельности и благотворительных организациях». Кроме названного закона, благотворительная деятельность регулируется соответствующими положениями Конституции (ст. 39) и Гражданского кодекса.</p>
            </center>
        </div>
        <div class="col-md-3 col-mod-7">
            <div class="thumbnail thum">
                <img src="/charity/<?= $charity->img; ?>" class="ferma-img">
                <div class="captiones">
                    <div class="progress progress-striped active progresses">
                        <div class="progress-bar"  role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                            <span class="ferma-color">Собрано:  <?=$charity->summ;?></span>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-md-6 col-mod-7">
            <span>Имя:</span><span class="f-r"><?= $charity->name; ?></span></br>
            <span>Возраст:</span><span class="f-r"><?= $charity->age; ?></span></br>
            <span>Адрес:</span><span class="f-r"><?= $charity->address; ?></span></br>
            <span>Необходимо:</span><span class="f-r"><?= $charity->need; ?></span></br></br>
            <center>
                <p>
                    <?= $charity->content; ?>
                </p>
            </center>
        </div>
        <div class="col-md-3 col-mod-7">
            <div class="thumbnail thumer">
                <center>
                    <p>Топ пожертвования</p>
                </center>
                <?php if($charityTop){ ?>
                    <?php foreach($charityTop as $top): ?>
                        <span><?= $top->user->username; ?><span class="badge bmd-bg-info f-r"><?= $top->summ; ?></span></span></br>
                    <?php endforeach; ?>
                <?php }else{ ?>
                    Ничего не найдено.
                <?php } ?>
            </div>
            <div class="captiones">
                <div class="progress progress-bar-info progresses">
                    <div class="progress-bar"  role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                        <span class="ferma-color">Общая сумма: <?=$charity->summ;?></span>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<div class="col-md-6 col-md-offset-3 ferma-bg f-pad">
    <center>
        <span>
            <a href="#" data-toggle="dropdown" aria-expanded="false"><img src="/img/free-kassa.png" class="money"></a>
            <ul class="dropdown-menu f-style">
                <input type="number" class="in-put form-control char-ferma">
                    <span class="input-group-btn">
                     <button class="btn btn-success but-ton" type="button">Пожертвовать</button>
                    </span>
            </ul>
        </span>
        <span>
            <a href="#" data-toggle="dropdown" aria-expanded="false"><img src="/img/yandex.png" class="money"></a>
            <ul class="dropdown-menu f-style">
                <input type="number" class="in-put form-control char-ferma">
                    <span class="input-group-btn">
                     <button class="btn btn-success but-ton" type="button">Пожертвовать</button>
                    </span>
            </ul>
        </span>
        <span>
            <a href="#" data-toggle="dropdown" aria-expanded="false"><img src="/img/mykassa.png" class="money"></a>
            <ul class="dropdown-menu f-style">
                <input type="number" class="in-put form-control char-ferma">
                    <span class="input-group-btn">
                     <button class="btn btn-success but-ton" type="button">Пожертвовать</button>
                    </span>
            </ul>
        </span>
        <span>
            <a href="#" data-toggle="dropdown" aria-expanded="false"><img src="/img/qiwi.png" class="money"></a>
            <ul class="dropdown-menu f-style">
                <input type="number" class="in-put form-control char-ferma">
                    <span class="input-group-btn">
                     <button class="btn btn-success but-ton" type="button">Пожертвовать</button>
                    </span>
            </ul>
        </span>
        <span>
            <a href="#" data-toggle="dropdown" aria-expanded="false"><img src="/img/payeer.jpg" class="money"></a>
            <ul class="dropdown-menu f-style">
                <input type="number" class="in-put form-control char-ferma">
                    <span class="input-group-btn">
                     <button class="btn btn-success but-ton" type="button">Пожертвовать</button>
                    </span>
            </ul>
        </span>
    </center>
</div>
<div class="col-md-12">
    <div class="col-md-12 ferma-bg-3">
        <div class="panels panel-default">
            <!-- Default panel contents -->
            <div class="panel-heading panel-dead"><center>Все пожертвования</center></div>

            <!-- Table -->
            <div class="ferma-scroll">
                <?php if($charityUsers){ ?>

                    <table class="table">
                        <thead>
                        <tr>
                            <th>№</th>
                            <th>Логин</th>
                            <th>Сумма</th>
                            <th>Число и дата</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($charityUsers as $users): ?>
                            <tr>
                                <td><?= $users->id ?></td>
                                <td><?= $users->user->username ?></td>
                                <td><?= $users->summ ?></td>
                                <td><?= $users->date ?></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>

                <?php }else{ ?>
                    Ничего не найдено.
                <?php } ?>
            </div>
        </div>
    </div>
</div>
    <div style="clear: both;"></div><br>
<!-- CONTENT END -->
<?php }else{ ?>


<?php } ?>
<?= \frontend\widgets\ReviewsWidget::widget(); ?>
