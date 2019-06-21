<?php if($is_first): ?>
    <div class="business__slider slider" id="business-slider">
        <ul class="business__grid list-nostyle slider__wrap">
<?php endif; ?>
            <li class="business__item slider__item">
                <a <?php echo PageBuilder::block('tools_icon_link'); ?>>
                    <figure>
                        <?php echo PageBuilder::block('tools_icon', ['class' => 'business__item-icon']); ?>

                    </figure>
                </a>
                <h3 class="business__title business__item-title"><?php echo (PageBuilder::block('text_title_tool')); ?></h3>
                <p class="business__item-description"><?php echo (PageBuilder::block('text_body_tool')); ?></p>
            </li>
<?php if($is_last): ?>
        </ul>
    </div>
<?php endif; ?>
