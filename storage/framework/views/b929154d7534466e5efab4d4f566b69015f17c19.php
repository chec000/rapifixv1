<?php if($is_first || $count % 6 == 1): ?>
    <ul class="main-f__list contact-icons list-nostyle">
        <li class="contact-icon title"><?php echo app('translator')->getFromJson('cms::footer.contact_us'); ?>:</li>
<?php endif; ?>
        <li class="contact-icon">
            <a <?php echo PageBuilder::block('social_link'); ?>>
                <figure class="">
                <?php echo PageBuilder::block('social_icon_image'); ?>

                </figure>
            </a>
        </li>
<?php if($is_last || $count % 6 == 0): ?>
    </ul>
<?php endif; ?>
