<?php
use yii\helpers\Html;
use common\models\WallPost;
use yii\widgets\ActiveForm;
use common\models\Settings;

?>

<div class="col-md-12">
    <div class="post_table">
        <div class="wall_delete_div" id="<?php echo $model->id ?>">
            <div class="wall_text">
                <a href="#">
                    <?php
                        $users = WallPost::find()->innerJoinWith('user', 'wall_post.user_id = user.id')->where(['wall_post.id' => $model->id])->one();
                        echo $users->user->username;
                    ?>

                    <a href="javascript:void(0);" wall_id="<?= $model->id; ?>" class="wall_delete"><?= Yii::t('app', 'Удалить') ?></a>

                    <span class="riger"><?= strtotime($model->created_at); ?></span>
                </a>
            </div>
            <div class="wall_content">

                <div class="wall_all">
                    <div class="wall_dialog">
                        <?php if($model->image): ?>
                            <img src="/uploads/wallpost<?= $model->image; ?>" alt="" class="wall-post-img">
                        <?php endif; ?>
                        <p><?= $model->content; ?></p>
                    </div>
                </div>

                <div class="wall_info">
                    <?php $comments_count = \common\models\WallComments::find()->where(['wall_id' => $model->id])->count(); ?>
                    <span class="wi">
                        <a href="javascript:void(0);" id="<?= $model->id; ?>" class="toggleCommentText">
                            <i class="icsoc material-icons">&#xe0b9;</i> <?= Yii::t('app', 'Комментарий') ?> (<span class="comment_count"><?php echo $comments_count; ?></span>)
                        </a>
                    </span>
                    <span class="rig wi">
                        <?php if($user->level > \common\models\Settings::$wallLevel){ ?>
                            <a class="js-like"  data-wallid="<?=$model->id?>" data-userid="" href="javascript:void(0);">
                                <?= Yii::t('app', 'Мне нравится') ?> <i class="icsoc material-icons">&#xe87d;</i>
                            </a>
                            <span class="js-like-count"><?= $model->like_count ?></span>
                        <?php }else{ ?>
                            <span style="color: red"><?= Yii::t('app', 'Вы сможете только после 3-го уровня') ?></span>
                        <?php } ?>
                    </span>
                </div>

                <div class="collapse" id="toggleComment<?= $model->id; ?>">
                    <div class="">
                        <div id="comments">

                            <?php foreach ($comments as $comment) : ?>
                                <?php if($comment->wall_id == $model->id) : ?>
                                    <div class="comment-list">
                                        <div class="<?= $comment->id; ?>">
                                            <img src="<?php if(!$comment->user->photo){ echo '/avatars/noavatar.png'; }else{ echo '/avatars/'.$comment->user->photo; } ?>" class="comment-image" alt="">

                                            <a href="" class="comment-user"><?= $comment->user->username; ?></a>

                                            <p class="comment-content"><?= $comment->text; ?></p>

                                            <a href="javascript:void(0);" comment_id="<?= $comment->id; ?>" class="comment_delete"><?= Yii::t('app', 'Удалить') ?></a>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                            <div class="comment-add"></div>

                            <div class="comment-form">
                                <?php if($user->level > Settings::$wallLevel){ ?>
                                    <?php $form = ActiveForm::begin(['validateOnSubmit' => false]); ?>
                                    <div class="input-group">

                                        <div class="bmd-field-group">
                                            <?= $form->field($commentModel, 'text')->textArea(['class' => 'bmd-input inp comment-text','id' => 'text', 'rows' => 4, 'value' => '', 'maxlength' => 150])->label(false); ?>
                                            <span class="bmd-bar"></span>
                                        </div>

                                        <?= $form->field($commentModel, 'wall_id')->hiddenInput(['value' => $model->id, 'id' => 'wall_id'])->label(false); ?>

                                        <span class="input-group-btn" style="float: left">
                                        <?= Html::button('Добавить', [ 'class' => 'btn btn-success comment_post', 'name' => 'well_button']); ?>
                                    </span>
                                        <span class="bmd-field-feedback"></span>
                                    </div>
                                    <?php ActiveForm::end(); ?>
                                <?php }else{ ?>
                                    <span style="color: red"><?= Yii::t('app', 'Вы сможете только после 3-го уровня') ?></span>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>