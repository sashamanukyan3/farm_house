<script>
$(document).ready(function() {
$('#yandex_form').submit();
});
</script>
<div class="bmd-page-container padd">
    <div class="container">
        <div class="col-md-12 pri">
            <div class="faq_page_title"><?= Yii::t('app', 'Перенаправляем на страницу Яндекс.Деньги') ?></div>
            <ul class="news_ul">
                <blockquote class="bmd-border-primary news-view-div">
    <form method="POST" id="yandex_form" action="https://money.yandex.ru/quickpay/confirm.xml">

        <!--Номер кошелька в системе Яндекс Денег-->
    <input type="hidden" name="receiver" value="">

        <!--Название платежа, я не нашел, где этот параметр используется, поэтому просто указал адрес своего сайта (длина 50 символов)-->
    <input type="hidden" name="formcomment" value="ferma">

        <!--Этот параметр передаёт ID плагина, для того, чтобы скрипту было понятно, что потом отсылать пользователю (длина 64 символа)-->
    <input type="hidden" name="label" value="<?=Yii::$app->user->id ?>">

        <!--Тип формы, может принимать значения shop (универсальное), donate (благотворительная), small (кнопка)-->
    <input type="hidden" name="quickpay-form" value="shop">

        <!--Назначение платежа, это покупатель видит на сайте Яндекс Денег при вводе платежного пароля (длина 150 символов)-->
    <input type="hidden" name="targets" value="Пополнение баланса на сайте ferma">

        <!--Сумма платежа, валюта - рубли по умолчанию-->
    <input type="hidden" name="sum" value="<?php echo ceil(($sum*1.005)*100)/100; ?>" data-type="number">

        <!--Должен ли Яндекс запрашивать ФИО покупателя-->
    <input type="hidden" name="need-fio" value="false">

        <!--Должен ли Яндекс запрашивать email покупателя-->
    <input type="hidden" name="need-email" value="true">

        <!--Должен ли Яндекс запрашивать телефон покупателя-->
    <input type="hidden" name="need-phone" value="false">

        <!--Должен ли Яндекс запрашивать адрес покупателя-->
    <input type="hidden" name="need-address" value="false">

        <!--Метод оплаты, PC - Яндекс Деньги, AC - банковская карта-->
    <input type="hidden" name="paymentType" value="PC" />

        <!--Куда перенаправлять пользователя после успешной оплаты платежа-->
    <input type="hidden" name="successURL" value="http://ferma/pay/list?msg='Пополнение успешно зваершено!'">
        <?= Yii::t('app', 'Автоматическое перенаправление. Для того, чтобы перейти вручную') ?> - <button class="btn btn-success"><?= mb_strtolower(Yii::t('app', 'Нажмите сюда')) ?></button>
</form>
                </blockquote>
            </ul>
        </div>
    </div>
</div>
