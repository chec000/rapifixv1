<?php if($is_first): ?>
    <div class="slider mainslider" id="main-slider">
        <div class="slider__wrap">
<?php endif; ?>
            <?php
                $sliderType = PageBuilder::block('main_slider_type');
                $loginRequire = PageBuilder::block('main_slider_login_require');
                $userLevel = PageBuilder::block('main_slider_user_level');
                $sliderImage = PageBuilder::block('main_slider_image', ['view' => 'raw']);
                //$videoSrc = PageBuilder::block('main_slider_video');
                $videoYoutube = PageBuilder::block('main_slider_video_youtube',
                    ['view' => 'background', 'index' => $count]);
                $videoCloudFlare = PageBuilder::block('main_slider_video_cloudflare',
                    ['view' => 'background', 'index' => $count]);
                $titleHighlight = PageBuilder::block('main_slider_title_highligth');
                $title = PageBuilder::block('main_slider_title');
                $description = PageBuilder::block('main_slider_description');
                $link = PageBuilder::block('main_slider_link');
                $webServices = !config('settings::frontend.webservices');
            ?>
            <?php if($webServices || !($loginRequire && !Auth::check())): ?>
                <?php if($webServices || ($userLevel == '-' || $userLevel == '0')): ?>
                    <a <?php echo $link; ?>>
                        <div class="slider__item" style="background-image:url(<?php echo e($sliderImage); ?>);">
                            <div class="mainslider__gradient <?php echo e($gradientTheme); ?>"></div>
                            <?php if($sliderType == 'video'): ?>
                                
                                <?php if($videoCloudFlare != ''): ?>
                                    <?php echo $videoCloudFlare; ?>

                                <?php else: ?>
                                    <?php echo $videoYoutube; ?>

                                <?php endif; ?>
                            <?php endif; ?>
                            <div class="mainslider__wrap wrapper">
                                <div class="mainslider__content">
                                    <h1 class="mainslider__title">
                                        <?php echo $title; ?>

                                    </h1>
                                    <div class="hidden">
                                        <?php echo $titleHighlight; ?>

                                        <?php echo $description; ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                <?php endif; ?>
            <?php endif; ?>
<?php if($is_last): ?>
        </div>
        <div class="mainslider__signals signals">
            <p class="signals__note">
                <span><?php echo e($signalTitle); ?></span>
                <span><?php echo e($signalTitleHighlight); ?></span>
            </p>
            <span class="signals__scroll"><?php echo app('translator')->getFromJson('cms::main_slider.signal_scroll'); ?></span>
        </div>
    </div>
<?php endif; ?>
