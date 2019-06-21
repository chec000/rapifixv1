<?php if($is_first): ?>
<?php endif; ?>
    <div class="c-33">
        <figure class="rewards--item">
            <?php echo PageBuilder::block('jobs_rewards_icon'); ?>

            <figcaption>
                <?php echo e(PageBuilder::block('jobs_rewards_title')); ?><br>
                <?php echo e(PageBuilder::block('jobs_rewards_description')); ?><br>
                <?php echo e(PageBuilder::block('jobs_rewards_year')); ?>

            </figcaption>
        </figure>
    </div>
<?php if($is_last): ?>
<?php endif; ?>
