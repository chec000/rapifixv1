<li class="dropdrown<?php echo e($active?' active':''); ?>">
    <a class="dropdrown-toggle" href="<?php echo $url; ?>" <?php echo e(!empty($sub_menu)?'data-toggle=dropdown':''); ?>>
        <i class="<?php echo $item->icon; ?>"></i> <?php echo $item->item_name; ?> <?php echo !empty($sub_menu)?'<span class="caret"></span>':null; ?>

    </a>
    <?php echo $sub_menu; ?>

</li>