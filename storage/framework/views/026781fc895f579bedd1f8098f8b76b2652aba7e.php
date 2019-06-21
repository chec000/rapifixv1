<?php if($is_first): ?>
    <ul class="ezone__grid-list list-nostyle">
<?php endif; ?>
        <?php
            $link = PageBuilder::block('galleries_link');
            $message = PageBuilder::block('galleries_link_message');
        ?>
        <li class="ezone__grid-item">
            <figure class="ezone__grid-img">
                <?php echo PageBuilder::block('galleries_image', ['view' => 'fancybox']); ?>

            </figure>
            <?php if($link != '' && $message != ''): ?>
                <a <?php echo $link; ?>>
                    <?php echo e($message); ?>

                </a>
            <?php endif; ?>
        </li>
<?php if($is_last): ?>
    </ul>
<?php endif; ?>
