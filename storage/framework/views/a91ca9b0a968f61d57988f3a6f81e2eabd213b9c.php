<?php echo PageBuilder::section('head'); ?>


<div class="jumbotron" style="background: url(<?php echo e(PageBuilder::block('internal_banner', ['view' => 'raw'])); ?>) no-repeat center"></div>

<section id="sec1">
    <div class="container">

   
        <div class="row">
            <div class="col-sm-12">
                <h1><?php echo PageBuilder::block('title'); ?></h1>
                <p class="lead"><?php echo PageBuilder::block('lead_text'); ?></p>
                <?php echo PageBuilder::block('content'); ?>

            </div>
        </div>

        <?php $view = PageBuilder::block('category_view'); $pages = PageBuilder::category(['view' => PageBuilder::block('category_view'), 'per_page' => (!$view||$view=='default')?50:20]); ?>
        <?php if($pages): ?>
            <?php echo $pages; ?>

        <?php else: ?>
            <div class="row">
                <div class="col-sm-12">
                    <p>&nbsp;</p>
                    <p>No pages found</p>
                </div>
            </div>
        <?php endif; ?>

    </div>
    <!-- /.container -->
</section>

<?php echo PageBuilder::section('footer'); ?>

