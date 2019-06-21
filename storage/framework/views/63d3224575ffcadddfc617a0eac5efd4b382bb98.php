<?php echo PageBuilder::section('head'); ?>


    <!-- Main slider home markup-->
    <?php echo PageBuilder::block('main_slider', [
        'view' => PageBuilder::block('main_slider_view'),
        'gradient_theme' => PageBuilder::block('main_slider_gradient_theme')
    ]); ?>


<div class="wrapper full-size-mobile">
      <div class="history--container">
        <div class="history--description">
          <h2 class="history--title omnilife">
          <?php echo PageBuilder::block('title'); ?>

          </h2>
          <p class="contact--subtitle">
          <?php echo PageBuilder::block('content'); ?>

          </p>
          <br>
        </div>
      </div>
    </div>
    

    <!-- end Main slider home markup-->
<?php echo PageBuilder::section('footer'); ?>

