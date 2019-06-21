<div class="menuLayout">

    <div class="row textbox">

        <h3 class="col-sm-6"><?php echo $menu->label; ?></h3>

        <div class="col-sm-6 text-right">
            <span class="hide btn btn-success disabled" id="menu_<?php echo $menu->id; ?>_saved"><?php echo trans('admin::menusCMS.order_saved'); ?></span>
            <span class="hide btn btn-danger disabled" id="menu_<?php echo $menu->id; ?>_failed"><?php echo trans('admin::menusCMS.sort_failed'); ?></span>
            <?php if($permissions['can_add_item']): ?>
                <button class="btn btn-warning" id="menu_<?php echo $menu->id; ?>_add" onclick="add_item(<?php echo $menu->id; ?>)"><i
                            class="fa fa-plus"></i> &nbsp; <?php echo trans('admin::menusCMS.buttons.add_menu_item'); ?>

                </button>
            <?php endif; ?>
        </div>

    </div>

    <ol id="menu_<?php echo $menu->id; ?>" class="sortable">
        <?php echo $renderedItems; ?>

    </ol>

</div>