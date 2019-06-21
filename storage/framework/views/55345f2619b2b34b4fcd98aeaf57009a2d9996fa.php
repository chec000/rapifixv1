<?php echo PageBuilder::section('head'); ?>


    <!-- Main slider home markup-->
    <?php echo PageBuilder::block('main_slider', [
        'view' => PageBuilder::block('main_slider_view'),
        'gradient_theme' => PageBuilder::block('main_slider_gradient_theme'),
        'signal_title' => PageBuilder::block('signal_title'),
        'signal_title_highlight' => PageBuilder::block('signal_title_highlight')
    ]); ?>

    <!-- end Main slider home markup-->

    <!-- Main content markup-->
    <div class="wrapper full-size-mobile">

        <!-- Title markup-->
        <div class="myomnibusiness-header">
            <div class="myomnibusiness">
                <div class="myomnibusiness__about">
                    <h1 class="myomnibusiness__title"><?php echo e(PageBuilder::block('myomnibusiness_title')); ?></h1>
                    <p class="myomnibusiness__subtitle"><?php echo PageBuilder::block('myomnibusiness_description'); ?></p>
                </div>
                <blockquote class="testimonial__frase">
                    <?php echo PageBuilder::block('myomnibusiness_image'); ?>

                </blockquote>
            </div>
        </div>
        <!-- end Title markup-->

        <!-- Product markup-->
        <div class="products-block home has-dropdown">
            <div class="products-desc myomnibusiness-menu withbg mid wrapper">
                <h1 class="myomnibusiness__title"><?php echo e(PageBuilder::block('myomnibusiness_product_title')); ?></h1>
                <p class="products-desc__description"><?php echo PageBuilder::block('myomnibusiness_product_description'); ?></p>
                <div class="col3-4 offset1-4 cases__load myomnibusiness-menu--subtitle">
                    <p><?php echo e(PageBuilder::block('myomnibusiness_product_subtitle')); ?></p>
                </div>
            </div>
            <div class="products slider" id="home-products">
                <div class="products__wrap slider__wrap">
                    <div class="product myomnibusiness slider__item">
                        <a class="product__link" <?php echo PageBuilder::block('myomnibusiness_product_link'); ?>>
                            <?php echo PageBuilder::block('myomnibusiness_products'); ?>

                        </a>
                    </div>
                </div>
            </div>
        </div>
        <!-- end Product markup-->
    </div>

    <!-- Business items markup-->
    <div class="wrapper full-size-mobile business__main">
        <div class="business__main-title col4-4 myomnibusiness-instructions">
            <div class="business__main-inner myomnibusiness--steps">
                <h3 class="products-maintitle"><?php echo e(PageBuilder::block('business_tools_title')); ?></h3>
            </div>
        </div>
        <?php echo PageBuilder::block('tools'); ?>

    </div>
    <!-- end Business items markup-->

    <!-- Banner markup-->
    <div class="wrapper full-size-mobile business__main">
        <div class="business__main col4-4 banner">
            <div class="myomnibusiness__banner"
                style="background-image:url(<?php echo e(PageBuilder::block('myomnibusiness_banner_image', ['view' => 'raw'])); ?>);">
                <?php echo PageBuilder::block('myomnibusiness_banner_logo', ['class' => 'myomnibusiness__banner--brand']); ?>

                <h2 class="myomnibusiness__banner--title"><?php echo e(PageBuilder::block('myomnibusiness_banner_title')); ?></h2>
                <h3 class="myomnibusiness__banner--subtitle"><?php echo e(PageBuilder::block('myomnibusiness_banner_subtitle')); ?></h3>
                <div class="myomnibusiness__buttons">
                    <a <?php echo PageBuilder::block('myomnibusiness_banner_playstore_link'); ?>>
                        <?php echo PageBuilder::block('myomnibusiness_banner_playstore_image'); ?>

                    </a>
                    <a <?php echo PageBuilder::block('myomnibusiness_banner_appstore_link'); ?>>
                        <?php echo PageBuilder::block('myomnibusiness_banner_appstore_image'); ?>

                    </a>
                </div>
            </div>
        </div>
        <p class="myomnibusiness--banner__description"><?php echo e(PageBuilder::block('myomnibusiness_banner_description')); ?></p>
    </div>
    <!-- end Banner markup-->

    <!-- end Main content markup-->

<?php echo PageBuilder::section('footer'); ?>

