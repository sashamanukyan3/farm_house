<?php $this->registerJsFile(Yii::$app->getUrlManager()->baseUrl .'/js/notify/bootstrap-notify.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]); ?>
<?php ?>
<script>
    $(document).ready(function()
    {
        $.notify(
            {
                icon: 'glyphicon glyphicon-warning-sign',
                title: 'Bootstrap notify',
                message: "Enter: Fade In and RightExit: Fade Out and Right",
            },
            {
            animate: {
                enter: 'animated fadeInRight',
                exit: 'animated fadeOutRight'
            }
        });
    })
</script>