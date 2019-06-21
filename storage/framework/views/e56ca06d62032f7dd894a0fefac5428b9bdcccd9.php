<?php echo PageBuilder::section('head'); ?>


<div class="jumbotron" style="background: url(<?php echo e(PageBuilder::block('internal_banner', ['view' => 'raw'])); ?>) no-repeat center"></div>

<?php $searchQuery = PageBuilder::getData('searchQuery'); ?>

<section id="sec1">
    <div class="container">

      
 
        <div class="row">

            <div class="col-sm-9">

                <h1><?php echo PageBuilder::block('title'); ?>: <?php echo e($searchQuery ?: 'None'); ?></h1>
                <p class="lead"><?php echo PageBuilder::block('lead_text'); ?></p>
                <?php echo PageBuilder::block('content'); ?>


                <?php $pages = PageBuilder::search(['view' => PageBuilder::block('category_view'), 'groups' => [1, 2, 4], 'renderIfEmpty' => false]); ?>
                <?php if($pages): ?>
                    <?php echo $pages; ?>

                <?php else: ?>
                    <div class="row">
                        <div class="col-sm-12">
                            <p>&nbsp;</p>
                            <p>No posts found.</p>
                        </div>
                    </div>
                <?php endif; ?>

            </div>

            <div class="col-sm-3">
                <?php echo PageBuilder::section('blog-bar'); ?>

            </div>

        </div>

    </div>
    <!-- /.container -->
</section>

<?php echo PageBuilder::section('footer'); ?>