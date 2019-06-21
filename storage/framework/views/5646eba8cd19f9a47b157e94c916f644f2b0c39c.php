<?php if($is_first): ?>
<?php endif; ?>

<?php
    $ambassador_name = BlockFormatter::ambassadorInfo(PageBuilder::block('ambassador_testimonial_name'),
        PageBuilder::block('ambassador_testimonial_position'));
    $ambassador_age = BlockFormatter::ambassadorInfo(PageBuilder::block('ambassador_testimonial_age'),
        trans('cms::ambassadors.testimonial.age'));
    $ambassador_cell_phone = BlockFormatter::ambassadorInfo(PageBuilder::block('ambassador_testimonial_cell_number'),
        trans('cms::ambassadors.testimonial.cell_phone'));
    $ambassador_monthly_check = BlockFormatter::ambassadorInfo(PageBuilder::block('ambassador_testimonial_monthly_check'),
        trans('cms::ambassadors.testimonial.monthly_check'));
    $ambassador_career_level = BlockFormatter::ambassadorInfo(PageBuilder::block('ambassador_testimonial_career_level'),
        trans('cms::ambassadors.testimonial.career_level'), 'span');

    $name_codistributor = BlockFormatter::ambassadorInfo(PageBuilder::block('ambassador_testimonial_name_codistributor'),
        PageBuilder::block('ambassador_testimonial_position_codistributor'));
    $age_codistributor = BlockFormatter::ambassadorInfo(PageBuilder::block('ambassador_testimonial_age_codistributor'),
        trans('cms::ambassadors.testimonial.age'));
    $monthly_check_codistributor = BlockFormatter::ambassadorInfo(
        PageBuilder::block('ambassador_testimonial_monthly_check_codistributor'),
        trans('cms::ambassadors.testimonial.monthly_check'));
    $social_codistributor = PageBuilder::block('social_ambassador_codistributor');
    $cell_number_codistributor = BlockFormatter::ambassadorInfo(
        PageBuilder::block('ambassador_testimonial_cell_number_codistributor'),
        trans('cms::ambassadors.testimonial.cell_phone'));
    $career_level_codistributor = BlockFormatter::ambassadorInfo(
        PageBuilder::block('ambassador_testimonial_career_level_codistributor'),
        trans('cms::ambassadors.testimonial.career_level'), 'span');
?>
        <div class="item ambassador">
            <div class="content">
                <?php echo PageBuilder::block('ambassador_testimonial_image'); ?>

                <div class="ambassador--info">
                    <h3 class="ambassador__name"><?php echo e(PageBuilder::block('ambassador_testimonial_user_name')); ?></h3>
                    <h4 class="ambassador__country"><?php echo e(PageBuilder::block('ambassador_testimonial_country')); ?></h4>
                </div>
                <div class="desc">
                    <div class="ambassador--description__quote">
                        <?php echo PageBuilder::block('ambassador_testimonial_text'); ?>

                    </div>
                    <!-- Ambassador titular data -->
                    <?php echo $ambassador_career_level; ?>

                    <?php echo $ambassador_name; ?>

                    <?php echo $ambassador_age; ?>

                    <?php echo $ambassador_monthly_check; ?>

                    <div class="ambassador--description__info">
                        <?php echo PageBuilder::block('social_ambassador'); ?>

                    </div>
                    <?php echo $ambassador_cell_phone; ?>


                    <?php if($name_codistributor != ''): ?>
                        <hr>
                        <!-- Ambassador codistributor data -->
                        <?php echo $career_level_codistributor; ?>

                        <?php echo $name_codistributor; ?>

                        <?php echo $age_codistributor; ?>

                        <?php echo $monthly_check_codistributor; ?>

                        <div class="ambassador--description__info">
                            <?php echo PageBuilder::block('social_ambassador_codistributor'); ?>

                        </div>
                        <?php echo $cell_number_codistributor; ?>

                    <?php endif; ?>
                </div>
            </div>
        </div>

<?php if($is_last): ?>
<?php endif; ?>
