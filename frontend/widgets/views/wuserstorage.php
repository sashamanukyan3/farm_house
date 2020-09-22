<div class="modal fade bs-example-modal-lg" id="myStock" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modalp">
        <div class="modal_content bgmodal">
            <div class="modal-header">
                <div class="col-md-3">
                    <center><span class="gide"><i><?= Yii::t('app', 'Склад') ?></i></span></center>
                </div>
                <div class="col-md-8 col-mod-set">

                </div>
                <div class="col-md-1 col-mod-1">
                    <button type="button" class="close closes" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
            </div>
            <div class="modal-body modal_padding_top">
                <div class="col-md-3 col-mod-set edit" id="myStorage">
                    <ul class="nav nav-pills nav-stacked modal_button">
                        <li class="active"><a href="#1" data-toggle="tab" class="button_tabs"><?= Yii::t('app', 'Корм') ?></a></li>
                        <li><a href="#9" data-toggle="tab" class="button_tabs"><?= Yii::t('app', 'Семена') ?></a></li>
                        <li><a href="#2" data-toggle="tab" class="button_tabs product-for-sell"><?= Yii::t('app', 'Для продажи') ?></a></li>
                        <li><a href="#3" data-toggle="tab" class="button_tabs"><?= Yii::t('app', 'Для переработки') ?></a></li>
                        <li><a href="#4" data-toggle="tab" class="button_tabs"><?= Yii::t('app', 'Для употребления') ?></a></li>
                        <li><a href="#5" data-toggle="tab" class="button_tabs"><?= Yii::t('app', 'Животные') ?></a></li>
                        <li><a href="#6" data-toggle="tab" class="button_tabs"><?= Yii::t('app', 'Загоны') ?></a></li>
                        <li><a href="#7" data-toggle="tab" class="button_tabs"><?= Yii::t('app', 'Фабрики') ?></a></li>
                        <li><a href="#8" data-toggle="tab" class="button_tabs"><?= Yii::t('app', 'Пекарни') ?></a></li>
                    </ul>
                </div>
                <div class="col-md-8 col-mod-sat col-mod-1">
                    <div class="tab-content">
                        <!-- Корм -->
                        <div class="tab-pane pane active" style="margin-top: -13px;" id="1">
                            <?php foreach($results['plant'] as $plant): ?>
                            <div class="col-sm-6 col-mod-1">
                                <div class="thumbnail thymb-mi">
                                    <div class="captions">
                                        <div class="row raw">
                                            <div class="col-md-5 imag-stock">
                                                <img src="/img/product/<?=$plant->plant->img2;?>" class="wheat" />
                                            </div>
                                            <div class="col-md-7 col-mod-1 sette">
                                                <span class="font-style"><?=$plant->plant->name;?></span>
                                                <p class="price fs_style"><?= Yii::t('app', 'Кол-во') ?>: <span class="badge bmd-bg-success sette" id="<?=$plant->alias;?>"><?= $plant->count; ?></span></p>
                                            </div>
                                            <center>
                                                <div class="btn-group sette">
                                                    <button class="btn btn-success bmd-ripple bmd-flat-btn but-ton fs_style set dropdown-toggle" type="button" data-toggle="dropdown"><?= Yii::t('app', 'Продать') ?></button>
                                                    <ul class="dropdown-menu menu-style">
                                                        <div class="input-group">
                                                            <input type="number" class="in-put form-control product-count" min="100" value="<?=$plant->min_count;?>"
                                                                   data-id="<?=$plant->animal_food_id;?>" data-model="<?=$plant->plant->model_name;?>"
                                                                   data-price="<?=$plant->plant->price_for_sell;?>" data-min_count="<?=$plant->min_count;?>"
                                                                   data-alias="<?=$plant->alias;?>" data-current_count="<?=$plant->count;?>" data-price_for_sell="<?=$plant->plant->price_for_sell; ?>">
                                                                    <span class="input-group-btn">
                                                                        <button class="btn btn-success but-ton product-sell" type="button"><?= Yii::t('app', 'Продать') ?></button>
                                                                    </span>
                                                        </div>
                                                    </ul>
                                                </div>
                                            </center>
                                            <div class='col-md-12 col-mod-1 sette'>
                                                <span class='price fs_style'>
                                                    <span class='badge bmd-bg-success sette'><?= $plant->plant->price_for_sell ?> <?= mb_strtolower(Yii::t('app', 'Руб/ед')) ?></span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        <!-- Корм End -->
                        <!-- Семена -->
                        <div class="tab-pane fade pane" id="9">
                            <?php foreach($results['plant2'] as $plant): ?>
                                <div class="col-sm-6 col-mod-1">
                                    <div class="thumbnail thymb-mi">
                                        <div class="captions">
                                            <div class="row raw">
                                                <div class="col-md-5 imag-stock">
                                                    <img src="/img/product/<?=$plant->img1;?>" class="wheat" />
                                                </div>
                                                <div class="col-md-7 col-mod-1 sette">
                                                    <span class="font-style"><?=$plant->name;?></span>
                                                    <p class="price fs_style"><?= Yii::t('app', 'Кол-во') ?>: <span class="badge bmd-bg-success sette" id="<?=$plant->alias;?>"><?= $plant->count; ?></span></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <!-- Семена End -->
                        <!-- Для продажи -->
                        <div class="tab-pane fade pane" id="2">

                        </div>
                        <!-- Для продажи End -->
                        <!-- Для переработки -->
                        <div class="tab-pane fade pane" id="3">
                            <?php foreach($results['for_processing'] as $products): ?>
                                <?php foreach($products as $product) : ?>
                                    <div class="col-sm-4 col-mod-1">
                                        <div class="thumbnail thymb-mi">
                                            <div class="captions">
                                                <div class="row raw">
                                                    <div class="col-md-3 imag-stock-min">
                                                        <img src="/img/product/<?=$product->img;?>" class="sale-mod" />
                                                    </div>
                                                    <div class="col-md-7 col-mod-1 sette">
                                                        <span class="font-style"><?=$product->name;?></span>

                                                    </div>
                                                    <div class="col-md-12 col-mod-1 sette">
                                                        <span class="price fs_style"><?= Yii::t('app', 'Количество') ?>: <span class="badge bmd-bg-success sette" id="<?=$product->alias;?>"><?=$product->count;?></span></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php endforeach; ?>
                        </div>
                        <!-- Для переработки End -->
                        <!-- Для употребления -->
                        <div class="tab-pane fade pane" id="4">
                            <?php foreach($results['for_eat'] as $productForUse): ?>
                            <div class="col-sm-4 col-mod-1">
                                <div class="thumbnail thymb-mi">
                                    <div class="captions">
                                        <div class="row raw">
                                            <div class="col-md-3 imag-stock-min">
                                                <img src="/img/product/<?=$productForUse->img;?>" class="sale-mod-pm" />
                                            </div>
                                            <div class="col-md-7 col-mod-1 sette">
                                                <span class="font-style"><?=$productForUse->name;?></span>

                                            </div>
                                            <div class="col-md-12 col-mod-1 sette">
                                                <span class="price fs_style"><?= Yii::t('app', 'Количество') ?>: <span class="badge bmd-bg-success sette" id="<?=$productForUse->alias;?>2"><?=$productForUse->count;?></span></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        <!-- Для употребления End -->
                        <!-- Животные -->
                        <div class="tab-pane fade pane" id="5">
                            <?php foreach($results['animals'] as $animal): ?>
                            <div class="col-sm-6 col-mod-1">
                                <div class="thumbnail thymb-mi">
                                    <div class="captions">
                                        <div class="row raw">
                                            <div class="col-md-5 imag-stock">
                                                <img src="/img/animals/<?=$animal->img2;?>" class="thymb-img" />
                                            </div>
                                            <div class="col-md-7 col-mod-1 sette in-side">
                                                <span class="font-style"><?=$animal->name;?></span>
                                                <p class="price fs_style"><?= Yii::t('app', 'Количество') ?>: <span class="badge bmd-bg-success sette" id="<?=$animal->alias;?>"><?=$animal->count;?></span></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        <!-- Животные End -->
                        <!-- Загоны -->
                        <div class="tab-pane fade pane" id="6">
                            <?php foreach($results['animal_pens'] as $pens): ?>
                                <div class="col-sm-6 col-mod-1">
                                    <div class="thumbnail thymb-mi">
                                        <div class="captions">
                                            <div class="row raw">
                                                <div class="col-md-5 imag-stock">
                                                    <img src="/img/building/<?=$pens->img;?>"  class="zagr" />
                                                </div>
                                                <div class="col-md-7 col-mod-1 sette in-side">
                                                    <span class="font-style"><?=$pens->name;?></span>
                                                    <p class="price fs_style"><?= Yii::t('app', 'Количество') ?>: <span class="badge bmd-bg-success sette" id="<?=$pens->alias;?>"><?=$pens->count;?></span></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <!-- Загоны End -->
                        <!-- Фабрики -->
                        <div class="tab-pane fade pane" id="7">
                            <?php foreach($results['factories'] as $factory): ?>
                                <div class="col-sm-6 col-mod-1">
                                    <div class="thumbnail thymb-mi" style=" height: 95px;">
                                        <div class="captions">
                                            <div class="row raw">
                                                <div class="col-md-5 imag-stock">
                                                    <img src="/img/building/<?=$factory->img;?>" class="ftesta" />
                                                </div>
                                                <div class="col-md-7 col-mod-1 sette in-side">
                                                    <span class="font-style"><?=$factory->name;?></span>
                                                    <p class="price fs_style"><?= Yii::t('app', 'Количество') ?>: <span class="badge bmd-bg-success sette" id="<?=$factory->alias;?>"><?=$factory->count;?></span></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <!-- Фабрики End -->
                        <!-- Пекарный -->
                        <div class="tab-pane fade pane" id="8">
                            <?php foreach($results['bakeries'] as $bakery): ?>
                                <div class="col-sm-6 col-mod-1">
                                    <div class="thumbnail thymb-mi">
                                        <div class="captions">
                                            <div class="row raw">
                                                <div class="col-md-5 imag-stock">
                                                    <img src="/img/building/<?=$bakery->img;?>" class="ppt" />
                                                </div>
                                                <div class="col-md-7 col-mod-1 sette in-side">
                                                    <span class="font-style"><?=$bakery->name;?></span>
                                                    <p class="price fs_style"><?= Yii::t('app', 'Количество') ?>: <span class="badge bmd-bg-success sette" id="<?=$bakery->alias;?>"><?=$bakery->count;?></span></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <!-- Пекарный End -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
