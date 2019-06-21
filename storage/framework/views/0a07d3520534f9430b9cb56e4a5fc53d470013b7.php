<?php if($is_first): ?>
<?php endif; ?>
    <div class="c-33">
        <figure class="vacant--item <?php echo e(PageBuilder::block('jobs_vacancies_theme')); ?>">
            <?php echo PageBuilder::block('jobs_vacancies_icon'); ?>

            <figcaption>
                <div class="vacant--title">
                    <?php echo e(PageBuilder::block('jobs_vacancies_title')); ?>

                </div>
                <div class="vacant--description">
                    <?php echo PageBuilder::block('jobs_vacancies_list'); ?>

                    <?php echo PageBuilder::images('icons/icon-arrow.png'); ?>

                </div>
            </figcaption>
        </figure>
    </div>
<?php if($is_last): ?>
<?php endif; ?>
