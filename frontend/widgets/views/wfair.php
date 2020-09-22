<div class="modal fade bs-example-modal-lg" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modalp">
        <div class="modal_content bgmodal">
            <div class="modal-header">
                <div class="col-md-3">
                    <center><span class="gide"><i><?= Yii::t('app', 'Ярмарка') ?></i></span></center>
                </div>
                <div class="col-md-8 col-mod-set">

                </div>
                <div class="col-md-1 col-mod-1">
                    <button type="button" class="close closes" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
            </div>
            <div class="modal-body modal_padding_top">
                <div class="col-md-3 col-mod-set edit">
                    <ul class="nav nav-pills nav-stacked modal_button">
                        <li class="active"><a href="#score1" data-toggle="tab" class="button_tabs"><?= Yii::t('app', 'Семена') ?></a></li>
                        <li><a href="#score2" data-toggle="tab" class="button_tabs "><?= Yii::t('app', 'Животные') ?></a></li>
                        <li><a href="#score3" data-toggle="tab" class="button_tabs "><?= Yii::t('app', 'Корм') ?></a></li>
                        <li><a href="#score4" data-toggle="tab" class="button_tabs "><?= Yii::t('app', 'Продукция') ?></a></li>
                        <li><a href="#score5" data-toggle="tab" class="button_tabs "><?= Yii::t('app', 'Загоны') ?></a></li>
                        <li><a href="#score6" data-toggle="tab" class="button_tabs "><?= Yii::t('app', 'Фабрики') ?></a></li>
                        <li><a href="#score7" data-toggle="tab" class="button_tabs "><?= Yii::t('app', 'Пекарни') ?></a></li>
                        <li><a href="#score8" data-toggle="tab" class="button_tabs queuelist-fair"><?= Yii::t('app', 'Пироговая') ?></a></li>
                        <li><a href="#score9" data-toggle="tab" class="button_tabs  statistics-fair"><?= Yii::t('app', 'Статистика') ?></a></li>
                    </ul>
                </div>
                <div class="col-md-8 col-mod-sat col-mod-1">
                    <div class="tab-content">
                        <!-- Семена -->
                        <div class="tab-pane active pane" id="score1">
                            <?php foreach($plants as $plant): ?>
                                <div class="col-sm-6 col-mod-1">
                                    <div class="thumbnail thymb-mi">
                                        <div class="captions">
                                            <div class="row raw">
                                                <div class="col-md-5 imag-stock">
                                                    <img src="/img/product/<?=$plant->img1;?>" class="sem-mod" />
                                                </div>
                                                <div class="col-md-7 col-mod-1 sette">
                                                    <span class="font-style"><?=$plant->name;?></span>
                                                    <p class="prices"><?= Yii::t('app', 'Уровень') ?>: <span class="badge bmd-bg-info sette"><?=$plant->level;?></span></p>
                                                    <p class="price"><?= Yii::t('app', 'Цена') ?>: <span class="badge bmd-bg-success sette"><?=$plant->price_to_buy;?> <?= mb_strtolower(Yii::t('app', 'Руб')) ?></span></p>
                                                </div>
                                                <div class="col-md-5 col-mod-1 col">
                                                    <span class="price"><?= Yii::t('app', 'Количество') ?>:</span>
                                                </div>
                                                <div class="col-md-7 col-mod-1 sette">
                                                    <div class="input-group">
                                                        <input type="number" class="in-put form-control product-count" min="1"
                                                          data-id="<?=$plant->plant_id;?>" data-alias="<?=$plant->alias;?>"
                                                          data-energy="<?=$plant->energy;?>" data-experience="<?=$plant->experience;?>" >
                                                          <span class="input-group-btn">
                                                                <button class="btn btn-success but-ton product-buy" type="button"><?= Yii::t('app', 'Купить') ?></button>
                                                          </span>
                                                    </div><!-- /input-group -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <!-- Семена End -->
                        <!-- Животные -->
                        <div class="tab-pane fade pane" id="score2">
                            <?php foreach($animals as $animal): ?>
                                <div class="col-sm-6 col-mod-1">
                                    <div class="thumbnail thymb-mi">
                                        <div class="captions">
                                            <div class="row raw">
                                                <div class="col-md-5 imag">
                                                    <img src="/img/animals/<?= $animal->img2; ?>" class="thymb-img" />
                                                </div>
                                                <div class="col-md-7 col-mod-1 sette">
                                                    <span class="font-style"><?= $animal->name ?></span>
                                                    <p class="prices"><?= Yii::t('app', 'Уровень') ?>: <span class="badge bmd-bg-info sette"><?= $animal->level ?></span></p>
                                                    <p class="price"><?= Yii::t('app', 'Цена') ?>: <span class="badge bmd-bg-success sette"><?= $animal->price_to_buy; ?></span></p>
                                                </div>
                                                <div class="col-md-5 col-mod-1 col">
                                                    <span class="price"><?= Yii::t('app', 'Количество') ?>:</span>
                                                </div>
                                                <div class="col-md-7 col-mod-1 sette">
                                                    <div class="input-group">
                                                        <input type="number" class="in-put form-control product-count" min="1"
                                                               data-id="<?= $animal->animal_id;?>" data-alias="<?=$animal->alias;?>"
                                                               data-energy="<?=$animal->energy;?>" data-experience="<?=$animal->experience;?>" >
                                                          <span class="input-group-btn">
                                                                <button class="btn btn-success but-ton product-buy" type="button"><?= Yii::t('app', 'Купить') ?></button>
                                                          </span>
                                                    </div><!-- /input-group -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <!-- Животные End -->
                        <!-- Корм -->
                        <div class="tab-pane fade pane" id="score3">
                            <?php foreach($animalfoods as $animalfood): ?>
                                <div class="col-sm-6 col-mod-1">
                                    <div class="thumbnail thymb-mi">
                                        <div class="captions">
                                            <div class="row raw">
                                                <div class="col-md-5 imag-stock">
                                                    <img src="/img/product/<?=$animalfood->plant->img2;?>" class="wheat" />
                                                </div>
                                                <div class="col-md-7 col-mod-1 sette">
                                                    <span class="font-style"><?=$animalfood->plant->second_name;?></span>
                                                    <p class="price"><?= Yii::t('app', 'Цена') ?>: <span class="badge bmd-bg-success sette"><?=$animalfood->price_to_buy;?> руб</span></p>
                                                </div>
                                                <div class="col-md-7 col-mod-1 sette">
                                                    <div class="input-group">
                                                        <input type="number" class="in-put form-control product-count"  min="100" data-id="<?= $animalfood->animal_food_id;?>"
                                                               data-alias="<?=$animalfood->alias;?>" value="<?=$animalfood->min_count;?>"
                                                               data-energy="<?=$animalfood->energy;?>" data-experience="<?=$animalfood->experience;?>">
                                                        <span class="input-group-btn">
                                                            <button class="btn btn-success but-ton product-buy" type="button">Купить</button>
                                                        </span>
                                                    </div><!-- /input-group -->
                                                </div>
                                                <div class="col-md-12 col-mod-1 sette mod-margin">
                                                    <span class="price fs_style"><?= Yii::t('app', 'Доступно') ?>: <span class="badge bmd-bg-success sette" id="<?=$animalfood->alias;?>_count"><?=$animalfood->count;?></span></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <!-- Корм End -->
                        <!-- Продукция -->
                        <div class="tab-pane fade pane" id="score4">
                            <div class="menu">
                                <ul class="new_tags">
                                    <li class="active"><a href="#factory" data-toggle="tab" class="bmd-ripple new_tag_color" aria-expanded="true">Фабрика</a></li>
                                    <li class="new_tag"><a href="#pie" data-toggle="tab" class="bmd-ripple new_tag_color" aria-expanded="false">Пекарня</a></li>
                                </ul>
                            </div>
                            <div id="myTabContent" class="tab-content tab_con">
                                <div class="tab-pane fade active in" id="factory">
                                    <?php foreach($productTypes as $productType): ?>
                                        <div class="col-sm-6 col-mod-1">
                                            <div class="thumbnail thymb-mi">
                                                <div class="captions">
                                                    <div class="row raw">
                                                        <div class="col-md-5 imag-stock">
                                                            <img src="/img/product/<?=$productType->img;?>" class="egg" />
                                                        </div>
                                                        <div class="col-md-7 col-mod-1 sette">
                                                            <span class="font-style"><?=$productType->name;?></span>
                                                            <p class="price"><?= Yii::t('app', 'Цена') ?>: <span class="badge bmd-bg-success sette"><?=$productType->price_to_buy;?><?= mb_strtolower(Yii::t('app', 'Руб')) ?></span></p>
                                                        </div>
                                                        <div class="col-md-7 col-mod-1 sette">
                                                            <div class="input-group">
                                                                <input type="number" class="in-put form-control product-count" min="<?=$productType->min_count;?>" data-id="<?= $productType->id;?>"
                                                                       data-alias="<?=$productType->alias;?>" value="<?=$productType->min_count;?>"
                                                                       data-energy="<?=$productType->energy;?>" data-experience="<?=$productType->experience;?>" >
                                                                  <span class="input-group-btn">
                                                                        <button class="btn btn-success but-ton product-buy" type="button"><?= Yii::t('app', 'Купить') ?></button>
                                                                  </span>
                                                            </div><!-- /input-group -->
                                                        </div>
                                                        <div class="col-md-12 col-mod-1 sette mod-margin">
                                                            <span class="price fs_style"><?= Yii::t('app', 'Доступно') ?>: <span class="badge bmd-bg-success sette" id="<?=$productType->alias;?>_count"><?=$productType->count;?></span></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                                <div class="tab-pane fade" id="pie">
                                    <?php foreach($productBakery as $productforbakery): ?>
                                        <div class="col-sm-6 col-mod-1">
                                            <div class="thumbnail thymb-mi">
                                                <div class="captions">
                                                    <div class="row raw">
                                                        <div class="col-md-5 imag-stock">
                                                            <img src="/img/product/<?=$productforbakery->img;?>" class="test" />
                                                        </div>
                                                        <div class="col-md-7 col-mod-1 sette">
                                                            <span class="font-style"><?=$productforbakery->name;?></span>
                                                            <p class="price"><?= Yii::t('app', 'Цена') ?>: <span class="badge bmd-bg-success sette"><?=$productforbakery->price_to_buy;?> <?= mb_strtolower(Yii::t('app', 'Руб')) ?></span></p>
                                                        </div>
                                                        <div class="col-md-7 col-mod-1 sette">
                                                            <div class="input-group">
                                                                <input type="number" class="in-put form-control product-count" min="<?=$productforbakery->min_count?>" data-id="<?= $productforbakery->id;?>"
                                                                       data-alias="<?=$productforbakery->alias;?>" value="<?=$productforbakery->min_count?>"
                                                                       data-energy="<?=$productforbakery->energy;?>" data-experience="<?=$productforbakery->experience;?>" >
                                                                  <span class="input-group-btn">
                                                                      <button class="btn btn-success but-ton product-buy" type="button"><?= Yii::t('app', 'Купить') ?></button>
                                                                  </span>
                                                            </div><!-- /input-group -->
                                                        </div>
                                                        <div class="col-md-12 col-mod-1 sette mod-margin">
                                                            <span class="price fs_style"><?= Yii::t('app', 'Доступно') ?>: <span class="badge bmd-bg-success sette" id="<?=$productforbakery->alias;?>_count"><?=$productforbakery->count;?></span></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                        <!-- Продукций End -->
                        <!-- Загоны -->
                        <div class="tab-pane fade pane" id="score5">
                            <?php foreach($animalpens as $pens): ?>
                                <div class="col-sm-6 col-mod-1">
                                    <div class="thumbnail thymb-mi">
                                        <div class="captions">
                                            <div class="row raw">
                                                <div class="col-md-5 imag">
                                                    <img src="/img/building/<?=$pens->img;?>" class="zagr" />
                                                </div>
                                                <div class="col-md-7 col-mod-1 sette">
                                                    <span class="font-style"><?=$pens->name;?></span>
                                                    <p class="prices"><?= Yii::t('app', 'Уровень') ?>: <span class="badge bmd-bg-info sette"><?=$pens->level;?></span></p>
                                                    <p class="price"><?= Yii::t('app', 'Цена') ?>: <span class="badge bmd-bg-success sette"><?=$pens->price_to_buy;?> <?= mb_strtolower(Yii::t('app', 'Руб')) ?></span></p>
                                                </div>
                                                <div class="col-md-5 col-mod-1 col">
                                                    <span class="price"><?= Yii::t('app', 'Количество') ?>:</span>
                                                </div>
                                                <div class="col-md-7 col-mod-1 sette">
                                                    <div class="input-group">
                                                        <input type="number" class="in-put form-control product-count" min="1" data-id="<?= $pens->animal_pens_id;?>" data-alias="<?=$pens->alias;?>"
                                                               data-energy="<?=$pens->energy;?>" data-experience="<?=$pens->experience;?>">
                                                        <span class="input-group-btn">
                                                            <button class="btn btn-success but-ton product-buy" type="button">Купить</button>
                                                        </span>
                                                    </div><!-- /input-group -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <!-- Загоны End -->
                        <!-- Фабрики -->
                        <div class="tab-pane fade pane" id="score6">
                            <?php foreach($factories as $factory): ?>
                                <div class="col-sm-6 col-mod-1">
                                    <div class="thumbnail thymb-mi" style="height:125px;">
                                        <div class="captions">
                                            <div class="row raw">
                                                <div class="col-md-5 imag-stock">
                                                    <img src="/img/building/<?=$factory->img;?>" class="ftesta" />
                                                </div>
                                                <div class="col-md-7 col-mod-1 sette">
                                                    <span class="font-style"><?=$factory->name;?></span>
                                                    <p class="prices"><?= Yii::t('app', 'Уровень') ?>: <span class="badge bmd-bg-info sette"><?=$factory->level;?></span></p>
                                                    <p class="price"><?= Yii::t('app', 'Цена') ?>: <span class="badge bmd-bg-success sette"><?=$factory->price_to_buy;?> <?= mb_strtolower(Yii::t('app', 'Руб')) ?></span></p>
                                                </div>
                                                <div class="clear" style="clear:both;"></div>
                                                <div class="col-md-5 col-mod-1 col">
                                                    <span class="price"><?= Yii::t('app', 'Количество') ?>:</span>
                                                </div>
                                                <div class="col-md-7 col-mod-1 sette">
                                                    <div class="input-group">
                                                        <input type="number" class="in-put form-control product-count" min="1" data-id="<?= $factory->factory_id;?>" data-alias="<?=$factory->alias;?>"
                                                               data-energy="<?=$factory->energy;?>" data-experience="<?=$factory->experience;?>">
                                                          <span class="input-group-btn">
                                                                <button class="btn btn-success but-ton product-buy" type="button">Купить</button>
                                                          </span>
                                                    </div><!-- /input-group -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <!-- Фабрики End -->
                        <!-- Пекарни -->
                        <div class="tab-pane fade pane" id="score7">
                            <?php foreach($bakeries as $bakery): ?>
                                <div class="col-sm-6 col-mod-1">
                                    <div class="thumbnail thymb-mi">
                                        <div class="captions">
                                            <div class="row raw">
                                                <div class="col-md-5 imag-stock">
                                                    <img src="/img/building/<?=$bakery->img;?>" class="ppt" />
                                                </div>
                                                <div class="col-md-7 col-mod-1 sette">
                                                    <span class="font-style"><?=$bakery->name;?></span>
                                                    <p class="prices"><?= Yii::t('app', 'Уровень') ?>: <span class="badge bmd-bg-info sette"><?=$bakery->level;?></span></p>
                                                    <p class="price"><?= Yii::t('app', 'Цена') ?>: <span class="badge bmd-bg-success sette"><?=$bakery->price_to_buy;?> <?= mb_strtolower(Yii::t('app', 'Руб')) ?></span></p>
                                                </div>
                                                <div style="clear:both;"></div>
                                                <div class="col-md-5 col-mod-1 col">
                                                    <span class="price"><?= Yii::t('app', 'Количество') ?>:</span>
                                                </div>
                                                <div class="col-md-7 col-mod-1 sette">
                                                    <div class="input-group">
                                                        <input type="number" class="in-put form-control product-count" min="1" data-id="<?= $bakery->bakery_id;?>" data-alias="<?=$bakery->alias;?>"
                                                               data-energy="<?=$bakery->energy;?>" data-experience="<?=$bakery->experience;?>">
                                                          <span class="input-group-btn">
                                                                <button class="btn btn-success but-ton product-buy" type="button">Купить</button>
                                                          </span>
                                                    </div><!-- /input-group -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <!-- Пекарни End -->
                        <!-- Пироговые -->
                        <div class="tab-pane fade pane" id="score8">
                            <?php foreach($bakeryproduct as $cake): ?>
                                <div class="col-sm-4 col-mod-1">
                                    <div class="thumbnail thymb-mi">
                                        <div class="captions">
                                            <div class="row raw fair">
                                                <div class="col-md-3 imag-stock-min">
                                                    <img src="/img/product/<?=$cake->img;?>" class="sale-mod-pm" />
                                                </div>
                                                <div class="col-md-7 col-mod-1 sette">
                                                    <span class="price"><?=$cake->name;?></span>

                                                </div>
                                                <div class="col-md-12 col-mod-1 sette">
                                                    <span class="price fs_style"><?= Yii::t('app', 'Количество') ?>: <span class="badge bmd-bg-success sette" id="<?=$cake->alias?>"><?=$cake->count;?></span></span>
                                                    <button class="btn btn-success bmd-ripple bmd-flat-btn but-ton fs_style eat" type="button" data-id="<?=$cake->id;?>" data-alias="<?=$cake->alias;?>" data-type="1">Кушать</button>
                                                    <button class="btn btn-success bmd-ripple bmd-flat-btn but-ton fs_style set eat" type="button" data-id="<?=$cake->id;?>" data-alias="<?=$cake->alias;?>" data-type="2">Съесть всё</button>
                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                            <div class="col-md-12 col-mod-1 sale">
                                <center><h4 class="price-mod"><?= Yii::t('app', 'Покупка пирогов') ?></h4></center>
                                <div class="col-md-12 col-mod-1 sale">
                                    <div class="col-md-2 col-mod-1 col mr">
                                        <span class="price"><?= Yii::t('app', 'Количество') ?>:</span>
                                    </div><?/*=var_dump($queueList)*/?>
                                    <div class="col-md-4 col-mod-1 sette">
                                        <div class="input-group">
                                            <input type="number" class="in-put form-control cake-count" min="1">
                                                <span class="input-group-btn">
                                                    <button class="btn btn-success but-ton buy-cake" type="button"><?= Yii::t('app', 'Купить') ?></button>
                                                </span>
                                        </div><!-- /input-group -->
                                    </div>
                                    <div class="scroll-ferma-1">
                                        <table class="table" id="queueList">
                                            <thead>
                                            <tr>
                                                <th><?= Yii::t('app', 'Пирог') ?></th>
                                                <th><?= Yii::t('app', 'Кол-во') ?></th>
                                                <th><?= Yii::t('app', 'Цена(руб/ед.)') ?></th>
                                                <th><?= Yii::t('app', 'Дата добавл.') ?></th>
                                            </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Пироговые End -->
                        <!-- Статистика -->
                        <div class="tab-pane fade pane scroll-ferma" id="score9">

                        </div>
                        <!-- Статистика End -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
