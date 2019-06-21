<?php if($is_first): ?>
    <div class="cases__body">
<?php endif; ?>
        <?php
            $filters = PageBuilder::blockData('success_stories_filters');
        ?>
        <div class="testimonial cases__item story-item
            <?php if(!empty($filters)): ?>
                <?php $__currentLoopData = $filters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php echo e('story-filter-'.$value); ?>

                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
            ">
            <div class="cases__about">
                <div class="testimonial__headline">
                    <div class="testimonial__avatar">
                        <figure class="avatar smallx">
                            <?php echo PageBuilder::block('success_stories_avatar'); ?>

                        </figure>
                    </div>
                    <div class="testimonial__about">
                        <h1 class="testimonial__name"><?php echo e(PageBuilder::block('success_stories_name')); ?></h1>
                        <div class="testimonial__metas">
                            <span><?php echo e(PageBuilder::block('success_stories_age')); ?></span>
                            <span><?php echo e(PageBuilder::block('success_stories_city')); ?></span>
                        </div>
                    </div>
                </div>
                <p class="testimonial__extract">
                    <?php echo \Illuminate\Support\Str::words(PageBuilder::block('success_stories_text'), 22, '...'); ?>

                </p>
                <blockquote class="testimonial__frase"><?php echo e(PageBuilder::block('success_stories_phrase')); ?></blockquote>
                <div class="cases__video">
                    <?php
                        $storyMedia = PageBuilder::block('success_stories_media');
                        $videoYoutube = PageBuilder::block('success_stories_video');
                        $videoCloudFlare = PageBuilder::block('success_stories_video_cloudflare', ['width' => '100%']);
                        //$videoUploaded = PageBuilder::block('success_stories_video_uploaded');
                        $image = PageBuilder::block('success_stories_image');
                    ?>
                    
                    <?php if($storyMedia == 'video'): ?>
                        <?php if($videoCloudFlare != ''): ?>
                            <?php echo $videoCloudFlare; ?>

                        <?php else: ?>
                            <?php echo $videoYoutube; ?>

                        <?php endif; ?>
                    <?php else: ?>
                        <?php echo $image; ?>

                    <?php endif; ?>
                </div>
                <button class="cases__open testimonial__readmore button small"><?php echo app('translator')->getFromJson('cms::get-inspired.read_more'); ?></button>
            </div>
            <div class="cases__testimonial">
                <div class="cases__testimonial-inner">
                    <div class="cases__testimonial-body ps-container desk-only ps ps--active-y">
                        <?php echo PageBuilder::block('success_stories_text'); ?>

                        <div class="ps__rail-x" style="left: 0px; bottom: 0px;">
                            <div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div>
                        </div>
                        <div class="ps__rail-y" style="top: 0px; height: 369px; right: 0px;">
                            <div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 276px;"></div>
                        </div>
                    </div>
                    <button class="cases__close button small secondary"><?php echo app('translator')->getFromJson('cms::get-inspired.close'); ?></button>
                </div>
            </div>
        </div>
<?php if($is_last): ?>
    </div>
<?php endif; ?>
