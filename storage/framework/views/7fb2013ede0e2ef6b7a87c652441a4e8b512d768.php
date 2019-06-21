<?php if($is_first): ?>
    <ul class="business__grid list-nostyle slider__wrap">
<?php endif; ?>
<?php
    $country = PageBuilder::block('contact_country_name');
    $creo = PageBuilder::block('contact_creo_data');
    $contact2 = PageBuilder::block('contact_2_data');
?>
        <?php if($country != ''): ?>
            <li class="business__item slider__item contact">
                <h3 class="business__title business__item-title"><?php echo $country; ?> </h3>
                <p class="business__item-description contact">
                    <?php echo BlockFormatter::contactCREO($creo, trans('cms::contact.creo')); ?>

                    <br>
                    <?php echo $contact2; ?>

                </p>
            </li>
        <?php endif; ?>
<?php if($is_last): ?>
    </ul>
<?php endif; ?>
