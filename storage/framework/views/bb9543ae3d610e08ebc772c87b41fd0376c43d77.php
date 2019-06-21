<?php echo PageBuilder::section('head'); ?>


    <!-- Main slider home markup-->

    
  <div class="business">
    <!-- Main slider home markup-->
    <?php echo PageBuilder::block('main_slider', [
        'view' => PageBuilder::block('main_slider_view'),
        'gradient_theme' => PageBuilder::block('main_slider_gradient_theme')
    ]); ?>

    <!-- end Main slider home markup-->
    <!-- Content body-->
    <div class="wrapper full-size-mobile">
      <!-- Testimonials markup-->
      <div class="myomnibusiness-header omnilife">
        <div class="myomnibusiness">
          <div class="myomnibusiness__about">
            <h1 class="myomnibusiness__title omnilife"><?php echo e(PageBuilder::block('promotions_title')); ?></h1>
            <p class="myomnibusiness__subtitle omnilife">
                <?php echo PageBuilder::block('promotions_description'); ?>

            </p>
          </div>
            <figure class="testimonial__frase">
           <?php echo PageBuilder::block('testimonial_image_promotion'); ?>

            </figure>
        </div>
      </div>
      <!-- end Testimonials markup-->
    </div>
    <?php echo PageBuilder::block('promotions_items'); ?>

    <!-- end Content Body-->
  </div>
  <!-- bottom banner-->

          <?php
    $sliderImage = PageBuilder::block('promotion_image_banner', ['view' => 'raw']);
    ?>
    <div class="bottom-banner align-left gradient business__banner" style="background-image:url(<?php echo e($sliderImage); ?>);">
        <div class="wrapper bottom-banner__content">
            <h2><?php echo PageBuilder::block('title_banner_promotion'); ?> </h2>
            <p><?php echo PageBuilder::block('subtitle_banner_promotion'); ?></p>
            <a <?php echo PageBuilder::block('link_promotion'); ?>>
                <?php echo BlockFormatter::smallButton(PageBuilder::block('title_banner_button_promotion')); ?>

            </a>
        </div>
    </div>
<?php echo PageBuilder::section('footer'); ?>

