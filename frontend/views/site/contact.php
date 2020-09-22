<section class="contacts">
    <div class="container">
        <h2 class="title contacts__title"><?= Yii::t('app', 'Контакты') ?></h2>
        <div class="contacts__inner">
            <div class="contacts__content">
                <?php if ($contact) {
                    $contentAttribute = 'content' . (Yii::$app->language == 'en' ? '_en' : '');
                    echo $contact->$contentAttribute;
                } ?>
            </div>
            <div class="contacts__map">
                <iframe class="contacts__map-iframe"
                        src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d425.06797228234433!2d-118.33165842921805!3d34.10187936368344!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x80c2bf3b78405957%3A0xbe95f3c4bb7c28dd!2zNjUxOSBIb2xseXdvb2QgQmx2ZCwgTG9zIEFuZ2VsZXMsIENBIDkwMDI4LCDVhNWr1aHWgdW11aHVrCDVhtWh1bDVodW21aPVttWl1oA!5e0!3m2!1shy!2s!4v1599400281851!5m2!1shy!2s"
                        width="100%" height="100%" frameborder="0" style="border:0;" allowfullscreen=""
                        aria-hidden="false"
                        tabindex="0"></iframe>
            </div>
        </div>
    </div>
</section>