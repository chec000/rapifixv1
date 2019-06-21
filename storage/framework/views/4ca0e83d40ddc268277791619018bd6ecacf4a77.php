<div class="row">
    <h4 class="col-sm-12"><?php echo e($label); ?></h4>

    <div class="col-sm-12 <?php echo $renderedRows ? '' : ' hide'; ?>">
        <table id="repeater_<?php echo $content; ?>" class="table repeater-table">
            <tbody>
                <?php echo $renderedRows; ?>

            </tbody>
        </table>
    </div>

    <div class="col-sm-10">
        <div class="form-group">
            <div class="row">
                <div class="col-sm-12">
                    <?php echo Form::hidden($name . '[repeater_id]', $content); ?>

                    <?php echo Form::hidden($name . '[parent_repeater_id]', $_block->getRepeaterId()); ?>

                    <?php echo Form::hidden($name . '[parent_repeater_row_id]', $_block->getRepeaterRowId()); ?>

                    <button type="button" class="btn repeater_button" data-repeater="<?php echo e($content); ?>" data-block="<?php echo e($_block->id); ?>" data-page="<?php echo e($_block->getPageId()); ?>">
                        <?php echo e(trans('admin::blocks.repeater.button_add') . ' ' . ($label ?: trans('admin::blocks.repeater.button_default'))); ?>

                    </button>
                </div>
            </div>
        </div>
    </div>

</div>
