<?php if($is_first): ?>
    <ul class="business__grid list-nostyle slider__wrap">
<?php endif; ?>
        <li class="brand__item slider__item">
            <a <?php echo PageBuilder::block('omnilife_brand_link'); ?>>
                <figure>
                    <?php echo PageBuilder::block('omnilife_brand_logo'); ?>

                </figure>
            </a>
            <p class="business__item-description"><?php echo PageBuilder::block('omnilife_brand_description'); ?></p>
        </li>
<?php if($is_last): ?>
    </ul>
<?php endif; ?>
