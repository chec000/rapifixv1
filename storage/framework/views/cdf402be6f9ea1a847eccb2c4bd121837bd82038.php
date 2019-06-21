<div class="col-sm-12">
    <h3 class="clearfix post-title"><a href="<?php echo $page->url; ?>" class="pull-left"><?php echo $page->name; ?></a><span class="pull-right"><?php echo e(PageBuilder::block('post_date', ['format' => 'jS F Y'])); ?></span></h3>
    <p><?php echo e(PageBuilder::block('content', ['length' => 400])); ?></p>
    <div class="row">
        <div class="col-sm-3">
        <a href="<?php echo url($page->url); ?>" class="btn btn-default">Read More</a>
        </div>
    </div>
</div>