<?php echo PageBuilder::section('head'); ?>


    <!-- Main slider home markup-->
    <?php echo PageBuilder::block('main_slider', [
        'view' => PageBuilder::block('main_slider_view'),
        'gradient_theme' => PageBuilder::block('main_slider_gradient_theme')
    ]); ?>

    <!-- end Main slider home markup-->
    <div class="business">
         <div class=" wrapper full-size-mobile business__main">
        <!-- History markup-->
             <div class="business__main-title col3-4">
        <div class="business__main-inner">
          <h3 class="products-maintitle"> <?php echo e(PageBuilder::block('template_title')); ?> <span><?php echo e(PageBuilder::block('template_title_complement')); ?></span></h3>
        </div>
      </div>
        <div class="history--container">
            <div class="history--description">
                <h2 class="history--title omnilife">
                    <?php echo e(PageBuilder::block('history_header')); ?>

                </h2>
                <?php echo PageBuilder::block('history'); ?>

            </div>
        </div>
        <!-- end History markup-->
        <!-- end Video markup-->
        <div class="products-block home has-dropdown">
            <div class="products-desc myomnibusiness-menu withbg omnilife mid wrapper">
                <h1 class="myomnibusiness__title"><?php echo e(PageBuilder::block('about_us_video_title')); ?></h1>
                <p class="products-desc__description"><?php echo PageBuilder::block('about_us_video_description'); ?></p>
            </div>
            <div class="products slider" id="home-products">
                <div class="products__wrap slider__wrap">
                    <div class="product myomnibusiness omnilife slider__item">
                        <?php
                            $videoYoutube = PageBuilder::block('about_us_video_youtube', ['width' => '80%']);
                            $videoCloudFlare = PageBuilder::block('about_us_video_cloudflare');
                            //$video = PageBuilder::block('about_us_video');
                        ?>
                        
                        <?php if($videoCloudFlare != ''): ?>
                            <?php echo $videoCloudFlare; ?>

                        <?php else: ?>
                            <?php if($videoYoutube != ''): ?>
                                <?php echo $videoYoutube; ?>

                            <?php endif; ?>
                        <?php endif; ?>
                        <p><?php echo e(PageBuilder::block('about_us_video_label')); ?></p>
                    </div>
                </div>
            </div>
        </div>
        <!-- end Video markup-->
    </div>
        <?php
    $sliderImage = PageBuilder::block('template_image', ['view' => 'raw']);
    ?>
    <div class="bottom-banner align-left gradient business__banner" style="background-image:url(<?php echo e($sliderImage); ?>);">
        <div class="wrapper bottom-banner__content">
            <h2><?php echo PageBuilder::block('title_banner_template'); ?> </h2>
            <p><?php echo PageBuilder::block('subtitle_banner_template'); ?></p>
            <a <?php echo PageBuilder::block('link_template'); ?>>
                <?php echo BlockFormatter::smallButton(PageBuilder::block('title_banner_button_template')); ?>

            </a>
        </div>
    </div>
    </div>
    <!-- Main content markup-->

    <!-- end Main content markup-->

<?php echo PageBuilder::section('footer'); ?>

