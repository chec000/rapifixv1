<?php echo PageBuilder::section('head'); ?>


    <!-- Main slider home markup-->
    <?php echo PageBuilder::block('main_slider', [
        'view' => PageBuilder::block('main_slider_view'),
        'gradient_theme' => PageBuilder::block('main_slider_gradient_theme')
    ]); ?>

    <!-- end Main slider home markup-->

    <!-- Main content markup-->
    <div class="wrapper full-size-mobile business__main">

        <!-- Title markup-->
        <div class="business__main-title col3-4">
            <div class="business__main-inner">
                <h3 class="products-maintitle">
                    <?php echo e(PageBuilder::block('jobs_title')); ?>

                    <span><?php echo e(PageBuilder::block('jobs_title_highligth')); ?></span>
                </h3>
            </div>
        </div>
        <!-- end Title markup-->

        <!-- Jobs markup-->
        <div class="jobs--container">
            <div class="jobs--description">
                <?php echo PageBuilder::block('jobs_description'); ?>

                <?php echo PageBuilder::block('jobs_thumbnails'); ?>


                <!-- Jobs Vision markup-->
                <div class="jobs--vision">
                    <div class="c-50">
                        <h2 class="jobs--vision__title">
                            <?php echo e(PageBuilder::block('jobs_vision_title')); ?>

                            <br>
                            <span><?php echo e(PageBuilder::block('jobs_vision_brand')); ?></span>
                        </h2>
                    </div>
                    <div class="c-50">
                        <div class="jobs--vision__description">
                            <?php echo PageBuilder::block('jobs_vision_description'); ?>

                        </div>
                    </div>
                </div>
                <!-- end Jobs Vision markup-->

                <!-- Vacancies markup-->
                <div class="jobs--vacancies flexbox">
                    <?php echo PageBuilder::block('jobs_vacancies'); ?>

                    <div class="c-100 text-center">
                        <h3 class="vacancies--message">
                            <?php echo e(PageBuilder::block('jobs_vacancies_message')); ?>

                        </h3>
                        <div class="vacancies--mail">
                            <a href="mailto:<?php echo e(PageBuilder::block('jobs_vacancies_email')); ?>">
                                <?php echo e(PageBuilder::block('jobs_vacancies_email')); ?>

                            </a>
                        </div>
                    </div>
                </div>
                <!-- end Vacancies markup-->

                <!-- Rewards markup-->
                <div class="jobs--rewards flexbox">
                    <h2 class="rewards--title"><?php echo e(PageBuilder::block('jobs_rewards_message')); ?></h2>
                    <?php echo PageBuilder::block('jobs_rewards'); ?>

                </div>
                <!-- end Rewards markup-->

            </div>
        </div>
        <!-- end Jobs markup-->

    </div>
    <!-- end Main content markup-->

<?php echo PageBuilder::section('footer'); ?>

