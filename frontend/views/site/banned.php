<div class="bmd-page-container padd">
    <div class="container">
        <div class="col-md-12 pri">
            <div class="faq_page_title"></div>
            <ul class="news_ul">
                <?php if($user): ?>
                    <?= '<span style="color:red; font-size:16px;">' . Yii::t('app', 'Вы забанены') . ' </span><br/>' ?>
                    <?php if($user->banned_text): ?>
                        <?= Yii::t('app', 'Причина бана') . ': '.$user->banned_text; ?>
                    <?php endif; ?>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</div>