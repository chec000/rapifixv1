<?php echo PageBuilder::section('head'); ?>

  
      <!-- Main slider home markup-->
      <?php echo PageBuilder::block('main_slider', ['view' => PageBuilder::block('main_slider_view')]); ?>


      <!-- end Main slider home markup-->
      <!-- Content body-->
      <div class="wrapper full-size-mobile">
        <div class="tools--container">
          <div class="tools--description">
            <h2 class="history--title">
                <?php echo PageBuilder::block('title'); ?>

            </h2>
              <?php echo PageBuilder::block('content'); ?>     
          </div>
        </div>  

        <div class="tools--grid">
          <div class="tools--grid__container">
             <h2>  <?php echo e(PageBuilder::block('tools_title')); ?></h2>
           
            <?php echo PageBuilder::block('tools_item'); ?>

          </div>
        </div>
      </div>

<?php echo PageBuilder::section('footer'); ?>