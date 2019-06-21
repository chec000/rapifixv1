<?php if($is_first): ?>
<div class="row">

    <div class="col-sm-12">
        <h3>Comments:</h3>
    </div>

<?php endif; ?>

        <div class="col-sm-12 well">

            <h4><?php echo PageBuilder::block('comment_author'); ?></h4>

            <p><?php echo e(PageBuilder::block('comment_content')); ?></p>

            <p><i><?php echo PageBuilder::block('comment_date', ['format' => 'jS F Y']); ?></i></p>

        </div>

<?php if($is_last): ?>
</div>
<?php endif; ?>