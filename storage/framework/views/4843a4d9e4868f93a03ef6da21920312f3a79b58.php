<?php if($is_first || $count % 6 == 1): ?>
    <span><?php echo app('translator')->getFromJson('cms::ambassadors.testimonial.social_networks'); ?>:</span>
    <div class="ambassador--description__socialmedia">
<?php endif; ?>
        <a <?php echo e(PageBuilder::block('ambassador_social_link')); ?>>
            <figure class="">
            <?php echo PageBuilder::block('ambassador_social_icon'); ?>

            </figure>
        </a>
<?php if($is_last || $count % 6 == 0): ?>
    </div>
<?php endif; ?>
