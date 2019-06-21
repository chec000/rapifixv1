<?php if($is_first): ?>
    <div class="jobs--thumbnails">
<?php endif; ?>
        <figure class="jobs--thumbnails__item">
            <?php echo PageBuilder::block('jobs_thumbnails_image'); ?>

            <figcaption>
                <?php echo e(PageBuilder::block('jobs_thumbnails_message')); ?>

            </figcaption>
        </figure>
<?php if($is_last): ?>
    </div>
<?php endif; ?>
