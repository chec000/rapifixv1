<?php echo PageBuilder::section('head'); ?>


<div class="jumbotron" style="background: url(<?php echo e(PageBuilder::block('internal_banner', ['view' => 'raw'])); ?>) no-repeat center"></div>

<section id="sec1">
    <div class="container">

    
      
        <div class="row">

            <div class="col-sm-9">

                <h1><?php echo PageBuilder::block('title'); ?></h1>
                <h2 class="sub-header">Posted on <?php echo e(PageBuilder::block('post_date', ['format' => 'jS F Y'])); ?> by <?php echo e(PageBuilder::block('post_author')); ?></h2>
                <p class="lead"><?php echo PageBuilder::block('lead_text'); ?></p>
                <?php echo PageBuilder::block('content'); ?>

                <?php echo PageBuilder::block('video'); ?>



                <?php echo PageBuilder::block('comments'); ?>

                <?php echo PageBuilder::block('comments', ['form' => true]); ?>


            </div>

            <div class="col-sm-3">
                <?php echo PageBuilder::section('blog-bar'); ?>

            </div>

        </div>

    </div>
</section>

<?php echo PageBuilder::section('footer'); ?>