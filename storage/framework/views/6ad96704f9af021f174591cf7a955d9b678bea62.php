
<?php if($is_first): ?>
 
        <ul class="tools--grid__list list-nostyle slider__wrap">
<?php endif; ?>

            <li class="tools--grid__item slider__item">
      
                <figure>
                    <?php echo PageBuilder::block('business_icon', ['class' => 'business__item-icon']); ?>

                </figure>
            </a>
            <h3 class="business__title business__item-title"><?php echo (PageBuilder::block('text_title_tool')); ?></h3>
            <p class="business__item-description"><?php echo (PageBuilder::block('text_body_tool')); ?></p>
        </li>

<?php if($is_last): ?>
        </ul>
    </div>
<?php endif; ?>
