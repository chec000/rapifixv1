<?php echo PageBuilder::section('head'); ?>


    <!-- Main slider business markup-->
    <?php echo PageBuilder::block('main_slider', [
        'view' => PageBuilder::block('main_slider_view'),
        'gradient_theme' => PageBuilder::block('main_slider_gradient_theme')
    ]); ?>

    <!-- end Main slider business markup-->

    <!-- tools block-->
<div class="wrapper full-size-mobile business__main">
    <div class="business__main-title col3-4">
        <div class="business__main-inner">
            <h3 class="products-maintitle"><?php echo PageBuilder::block('bussines_title_tools'); ?> <span><?php echo PageBuilder::block('bussines_title_tools_highlight'); ?></span></h3>
        </div>
    </div>

    <?php echo PageBuilder::block('tools'); ?>


    <div class="col3-4 offset1-4 desk">
        <div class="business__main-inner"></div>
    </div>
</div>
    <!-- end tools block-->

    <!-- bottom banner-->
    <div class="bottom-banner align-left gradient business__banner" style="background-image: url('<?php echo e(PageBuilder::block('registration_background_image', ['view' => 'raw'])); ?>');">
        <div class="wrapper bottom-banner__content">
            <h2><?php echo e(PageBuilder::block('registration_title')); ?></h2>
            <p><?php echo e(PageBuilder::block('registration_text')); ?></p>
            <a <?php echo e(PageBuilder::block('registration_link')); ?>>
                <?php echo BlockFormatter::smallButton(PageBuilder::block('registration_button_text')); ?>

            </a>
        </div>
    </div>
    <!-- end bottom banner-->

<?php echo PageBuilder::section('footer'); ?>

