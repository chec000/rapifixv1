<?php echo PageBuilder::section('head'); ?>


    <!-- Main slider ambassador markup-->
    <?php echo PageBuilder::block('main_slider', [
        'view' => PageBuilder::block('main_slider_view'),
        'gradient_theme' => PageBuilder::block('main_slider_gradient_theme')
    ]); ?>

    <!-- end Main slider ambassador markup-->

    <!-- Content body-->
    <div class="wrapper full-size-mobile">

        <!-- Testimonials markup-->
        <?php
            $ambassadorTitleVideo = PageBuilder::block('ambassador_title_video');
            $ambassadorDescriptionVideo = PageBuilder::block('ambassador_description_video');
            $ambassadorTestimonialsVideo = PageBuilder::block('ambassador_testimonials_video');
            $videoBlocks = BlockFormatter::validateBlocks([
                $ambassadorTitleVideo,
                $ambassadorDescriptionVideo,
                $ambassadorTestimonialsVideo
            ]);
        ?>
        <?php if($videoBlocks): ?>
            <div class="testimonials slider ambassador theme--cyan">
                <header class="testimonials__head">
                    <h1 class="testimonials__title ambassador">
                        <?php echo $ambassadorTitleVideo; ?></h1>
                    <h3 class="testimonials__subtitle ambassador"><?php echo $ambassadorDescriptionVideo; ?> </h3>
                </header>
                <figure class="ambassador--video">
                    <?php echo $ambassadorTestimonialsVideo; ?>

                </figure>
            </div>
        <?php endif; ?>
        <!-- end Testimonials markup-->

        <?php
            $ambassadorTittleTestimonials = PageBuilder::block('ambassador_title_testimonials');
            $ambassadorDescriptionTestimonials = PageBuilder::block('ambassador_description_testimonials');
            $ambassadorTestimonials = PageBuilder::block('ambassador_testimonials');
            $ambassadorTestimonialsLeft = BlockFormatter::validateBlocks([
                $ambassadorTittleTestimonials,
                $ambassadorDescriptionTestimonials
            ]);
        ?>
        <!-- product block-->
        <div class="products-block">
            <?php if($ambassadorTestimonialsLeft): ?>
                <div class="products-desc withbg mid wrapper theme--gray over-main-slider">
                    <h1 class="products-desc__title"><?php echo $ambassadorTittleTestimonials; ?></h1>
                    <div class="ambassador--description">
                        <?php echo $ambassadorDescriptionTestimonials; ?>

                    </div>
                </div>
            <?php endif; ?>
            <?php if($ambassadorTestimonials): ?>
                <div class="products slider over-main-slider">
                    <div class="grid">
                        <?php echo $ambassadorTestimonials; ?>

                    </div>
                </div>
            <?php endif; ?>
        </div>
        <!-- end product block-->

        <!-- faq block-->
        <div class="ambassador--faq">
            <?php
                $ambassadorFaqImage = PageBuilder::block('ambassador_faq_image', ['class' =>'ambassador--world']);
                $ambassadorFaqObjectives = PageBuilder::block('ambassador_faq_objectives');
                $ambassadorFaqs = BlockFormatter::validateBlocks([
                    $ambassadorFaqImage,
                    $ambassadorFaqObjectives
                ]);
            ?>
            <?php if($ambassadorFaqs): ?>
                <div class="ambassador--faq__objectives theme--green over-main-slider">
                    <?php echo PageBuilder::block('ambassador_faq_image', ['class' =>'ambassador--world']); ?>

                    <?php echo PageBuilder::block('ambassador_faq_objectives'); ?>

                </div>
            <?php endif; ?>
            <div class="ambassador--faq__benefits">
                <?php if(PageBuilder::block('ambassador_faq_benefits')): ?>
                    <div class="ambassador--benefits__container theme--gray">
                        <div class="ambassador--faq__content">
                            <?php echo PageBuilder::block('ambassador_faq_benefits'); ?>

                        </div>
                    </div>
                <?php endif; ?>
                <?php
                    $ambassadorConvocatoryTitle = PageBuilder::block('ambassador_convocatory_title');
                    $ambassadorConvocatoryText = PageBuilder::block('ambassador_convocatory_text');
                    $ambassadorConvocatoryLink = PageBuilder::block('ambassador_convocatory_link');
                    $ambassadorConvocatoryLinkLabel = PageBuilder::block('ambassador_convocatory_link_label');
                    $ambassadorConvocatory = BlockFormatter::validateBlocks([
                        $ambassadorConvocatoryTitle,
                        $ambassadorConvocatoryText,
                        $ambassadorConvocatoryLink,
                        $ambassadorConvocatoryLinkLabel
                    ]);
                ?>
                <?php if($ambassadorConvocatory): ?>
                    <div class="ambassador--benefits__convocatory theme--blue">
                        <h2><?php echo e($ambassadorConvocatoryTitle); ?></h2>
                        <p><?php echo $ambassadorConvocatoryText; ?></p>
                        <?php if($ambassadorConvocatoryLinkLabel != ''): ?>
                            <a <?php echo $ambassadorConvocatoryLink; ?>>
                                <?php echo e($ambassadorConvocatoryLinkLabel); ?>

                            </a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <!-- end faq block-->

    </div>
    <!-- end Content block-->

<?php echo PageBuilder::section('footer'); ?>

<script src="<?php echo e(PageBuilder::js('ambassadors')); ?>"></script>
