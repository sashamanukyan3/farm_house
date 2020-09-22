<?php

use yii\helpers\Url;

?>

<div id="bottom-sheet-default" class="bmd-bottom-sheet pe">
    <div class="col-md-12">

        <?php foreach($reviews as $review){ ?>

            <div class="col-md-6">
                <blockquote class="bmd-border-primary reviews">
                    <p><?php if(!empty($review->content)){ echo mb_strimwidth($review->content, 0, 127, "...");  } ?></p>
                    <small><?php if(!empty($review->user->username)) { echo  $review->user->username; } ?><cite title="Source Title"></cite></small>
                </blockquote>
            </div>

        <?php } ?>

    </div>
    <center><a href="<?= Url::toRoute('/reviews/index') ?>" class="btn btn-primary bmd-ripple btn-xs otz"><?= Yii::t('app', 'Все отзывы') ?></a></center>
</div>

<script>
    function fook(){};
    $(document).ready(function(){
        $(".reviews:first").addClass("pull-right");
    });
</script>