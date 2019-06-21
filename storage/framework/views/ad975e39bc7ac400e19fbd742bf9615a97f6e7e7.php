<?php if($is_first): ?>
<?php endif; ?>
    <div class="wrapper full-size-mobile business__main ">
        <div class="business__main-title col4-4">
            <div class="business__main-inner myomnibusiness--steps">
                <h3 class="products-maintitle"> <?php echo e(PageBuilder::block('promotions_item_title')); ?></h3>
            </div>
        </div>
        <div class="business__slider slider" id="business-slider">
            <ul class="business__grid list-nostyle slider__wrap">
                <?php echo PageBuilder::block('promotion_item'); ?>

            </ul>
        </div>
    </div>
<?php if($is_last): ?>
<?php endif; ?>
