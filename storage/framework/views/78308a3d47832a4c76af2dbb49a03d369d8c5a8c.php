<?php if($is_first): ?>
<?php endif; ?>
    <figure class="product--device">
        <figcaption>
            <span class="device--image"><?php echo e(PageBuilder::block('myomnibusiness_products_message')); ?></span>
        </figcaption>
        <?php echo PageBuilder::block('myomnibusiness_products_image'); ?>

    </figure>
<?php if($is_last): ?>
<?php endif; ?>
