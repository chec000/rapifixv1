<h1><?php echo trans('admin::themes.labels.theme_title'); ?>- <?php echo e($theme->theme); ?></h1>

<?php if(!empty($themeErrors)): ?>

    <div class="table-responsive">
        <table id="themes-table" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th><?php echo trans('admin::themes.msg.theme_error'); ?>.</th>
                </tr>
            </thead>
            <tbody>
            <?php $__currentLoopData = $themeErrors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td>
                        <?php echo e($error); ?>

                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>

<?php elseif(isset($saved)): ?>

    <p class="text-success"><?php echo trans('admin::themes.msg.theme_updated'); ?></p>
    <p><a href="<?php echo e(route('admin.themes.update', ['themeId' => $theme->id])); ?>">&raquo; <?php echo trans('admin::themes.msg.theme_saved'); ?></a></p>

<?php else: ?>

    <h4><?php echo trans('admin::themes.labels.how_use'); ?></h4>
    <ul>
        <li><?php echo trans('admin::themes.labels.blocks_updated'); ?></li>
        <li><?php echo trans('admin::themes.labels.block_in_content'); ?></li>
        <li><?php echo trans('admin::themes.labels.block_general'); ?></li>
        <li><?php echo trans('admin::themes.labels.block_with_two_options'); ?></li>
    </ul>
    <div class="row">
        <div class="col-md-4 well-sm">
            <h4><?php echo trans('admin::themes.labels.summary'); ?>:</h4>
            <p><b><?php echo trans('admin::themes.labels.themplates_used'); ?>:</b> <?php echo e(implode(', ', $importBlocks->getTemplates())); ?></p>
            <p><b><?php echo trans('admin::themes.labels.blocks_count'); ?>:</b> <?php echo e(count($importBlocksList)); ?></p>
        </div>
        <div class="col-md-8 well-sm">
            <h4><?php echo trans('admin::themes.labels.key'); ?>:</h4>
            <ul>
                <li class="well-sm bg-success"><?php echo trans('admin::themes.labels.new_blocks'); ?></li>
                <li class="well-sm bg-warning"><?php echo trans('admin::themes.labels.exist_blocks'); ?></li>
                <li class="well-sm bg-danger"><?php echo trans('admin::themes.labels.delete_blocks'); ?></li>
                <li class="well-sm bg-info"><?php echo trans('admin::themes.labels.blocks_unknown'); ?></li>
                <li class="well well-sm"><?php echo trans('admin::themes.labels.blocks_without _changes'); ?></li>
            </ul>
        </div>
    </div>

    <?php echo Form::open(); ?>


    <div class="form-group">
        <?php echo Form::submit( trans('admin::themes.buttons.update_blocks'), ['class' => 'btn btn-primary']); ?>

    </div>

    <div class="table-responsive">
        <table id="themes-table" class="table table-striped table-bordered">

            <thead>
            <tr>
                <th><?php echo Form::checkbox('update_all', 1, false, ['id' => 'update-all']); ?> 
                    <i class="glyphicon glyphicon-info-sign header_note" data-note="<?php echo trans('admin::themes.labels.template_info'); ?>"></i> <?php echo trans('admin::themes.labels.update_templates'); ?></th>
                <th  class="with-th"><?php echo trans('admin::themes.labels.name'); ?></th>
                <th class="with-th"><?php echo trans('admin::themes.labels.label'); ?></th>
                <th class="with-th" ><?php echo trans('admin::themes.labels.block_category'); ?></th>
                <th class="with-th"><?php echo trans('admin::themes.labels.type'); ?></th>            
                <th><i class="glyphicon glyphicon-info-sign header_note" data-note="<?php echo trans('admin::themes.labels.template_show_in_site'); ?>">
                    
                    </i><?php echo trans('admin::themes.labels.show_in_site_wide'); ?></th>
                <th><i class="glyphicon glyphicon-info-sign header_note" data-note="<?php echo trans('admin::themes.labels.template_show_in_pages'); ?>">
                    
                    </i><?php echo trans('admin::themes.labels.show_in_pages'); ?></th>
                <th><?php echo trans('admin::themes.labels.order'); ?></th>
            </tr>
            </thead>

            <tbody>
            <?php
                ($rowClasses = ['new' => 'success', 'delete' => 'danger', 'update' => 'warning', 'info' => 'info', 'none' => ''])
            ?>
            <?php $__currentLoopData = $importBlocksList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $blockName => $listInfo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                $importBlock = $importBlocks->getAggregatedBlock($blockName);
                $currentBlock = $importBlocks->getBlock($blockName, 'db');
                $blockString=$importBlocks->getBlockName($blockName, $importBlock->blockData['category_id']);
                ?>             
                <tr class="<?php echo e($rowClasses[$listInfo['display_class']]); ?>">
                    <td><?php echo ($listInfo['update_templates'] >= 0)?Form::checkbox('block['.$blockName.'][update_templates]', 1, $listInfo['update_templates'], ['class' => 'form-control run-template-updates']):''; ?></td>
                    <td ><i class="glyphicon glyphicon-info-sign block_note" data-note="<?php echo e($blockName); ?>_note"></i> 
                        <span style="word-wrap: break-word"> <?php echo $blockName; ?></span>    
                    </td>
                    <td><?php echo Form::text('block['.$blockName.'][blockData][label]',($blockString!="")?$blockString:$importBlock->blockData['label'], ['class' => 'form-control','required' => 'required']); ?></td>
                    <td><?php echo ($listInfo['update_templates'] >= 0)?Form::select('block['.$blockName.'][blockData][category_id]', $categoryList, $importBlock->blockData['category_id'], ['class' => 'form-control']):''; ?></td>
                    <td><?php echo Form::select('block['.$blockName.'][blockData][type]', $typeList, $importBlock->blockData['type'], ['class' => 'form-control']); ?></td>
                    <td><?php echo ($listInfo['update_templates'] >= 0)?Form::checkbox('block['.$blockName.'][globalData][show_in_global]', 1, $importBlock->globalData['show_in_global'], ['class' => 'form-control based-on-template-updates']):''; ?></td>
                    <td><?php echo ($listInfo['update_templates'] >= 0)?Form::checkbox('block['.$blockName.'][globalData][show_in_pages]', 1, $importBlock->globalData['show_in_pages'], ['class' => 'form-control based-on-template-updates']):''; ?></td>
                    <td ><?php echo Form::text('block['.$blockName.'][blockData][order]', $importBlock->blockData['order'], ['class' => 'form-control width-td']); ?></td>
                </tr>
                <tr class="hidden" id="<?php echo e($blockName); ?>_note">
                    <td colspan="7" style="padding-bottom: 20px">
                        <div class="col-sm-6">
                            <h4><?php echo trans('admin::themes.labels.current_block_info'); ?></h4>
                            <?php if($listInfo['display_class'] == 'new'): ?>
                              <?php echo trans('admin::themes.labels.block_not_current'); ?> <br /><br />
                            <?php else: ?>
                                <?php if($globalData = array_filter($currentBlock->globalData)): ?>
                                    <?php echo trans('admin::themes.labels.block_show_in'); ?><?php echo e(implode(' and ', array_intersect_key(['show_in_pages' => 'pages', 'show_in_global' => 'site-wide content'], $globalData))); ?>.<br /><br />
                                <?php endif; ?>
                                <?php if($currentBlock->templates || $currentBlock->inRepeaterBlocks): ?>
                                    <?php if($currentBlock->templates): ?>
                                        <b>   <?php echo trans('admin::themes.labels.in_templates'); ?> </b> <?php echo implode(', ', $currentBlock->templates); ?><br />
                                    <?php endif; ?>
                                    <?php if($currentBlock->inRepeaterBlocks): ?>
                                        <b> <?php echo trans('admin::themes.labels.in_repiter_blocks'); ?>:</b> <?php echo implode(', ', $currentBlock->inRepeaterBlocks); ?><br />
                                    <?php endif; ?>
                                    <br />
                                <?php endif; ?>
                            <?php endif; ?>
                            <?php if($currentBlock->repeaterChildBlocks): ?>
                                <b><?php echo trans('admin::themes.labels.child_block'); ?></b> <?php echo implode(', ', $currentBlock->repeaterChildBlocks); ?><br /><br />
                            <?php endif; ?>
                            <?php if(count($currentBlock->blockData) > 1): ?>
                                <?php $__currentLoopData = $currentBlock->blockData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <b><?php echo trans('admin::themes.labels.'.$field); ?></b>: <i><?php echo e($value); ?></i><br />
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php else: ?>
                               <?php echo trans('admin::themes.labels.block_error'); ?>

                            <?php endif; ?>
                        </div>
                        <div class="col-sm-6">
                            <h4><?php echo trans('admin::themes.labels.updates_found'); ?></h4>
                            <?php if($importBlock->inCategoryTemplates || $importBlock->specifiedPageIds): ?>
                                <?php echo trans('admin::themes.labels.blocks_not_found_in_template'); ?>  <br />
                                <?php if($importBlock->inCategoryTemplates): ?>
                                    <b> <?php echo trans('admin::themes.labels.blocks_found_in_category'); ?>:</b> <?php echo implode(', ', $importBlock->inCategoryTemplates); ?><br />
                                <?php endif; ?>  
                                <?php if($importBlock->specifiedPageIds): ?>
                                    <b><?php echo trans('admin::themes.labels.use_pages_id'); ?>:</b> <?php echo implode(', ', $importBlock->specifiedPageIds); ?><br />
                                <?php endif; ?>
                                <br />
                            <?php endif; ?>
                            
                       
                            
                            <?php if($updatedGlobalValues = $importBlocks->updatedValues($importBlock, 'globalData')): ?>
                                <?php $__currentLoopData = $updatedGlobalValues; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field => $changedValues): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                
                                  
                                    <b><?php echo e(ucwords(str_replace('_', ' ', $field))); ?></b>: <i><?php echo e($changedValues['old']); ?></i> => <i><?php echo e($changedValues['new']); ?></i><br />
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                            <?php if($addedToTemplates = $importBlocks->newElements($importBlock, 'templates')): ?>
                                <b><?php echo trans('admin::themes.labels.add_to_template'); ?>:</b> <?php echo implode(', ', $addedToTemplates); ?><br />
                            <?php endif; ?>
                            <?php if($removedFromTemplates = $importBlocks->deletedElements($importBlock, 'templates')): ?>
                                <b><?php echo trans('admin::themes.labels.remove_from_template'); ?>:</b> <?php echo implode(', ', $removedFromTemplates); ?><br />
                            <?php endif; ?>
                            <?php if($addedRepeaterChildren = $importBlocks->newElements($importBlock, 'repeaterChildBlocks')): ?>
                                <b><?php echo trans('admin::themes.labels.repeter_child_add'); ?>:</b> <?php echo implode(', ', $addedRepeaterChildren); ?><br />
                            <?php endif; ?>
                            <?php if($removedRepeaterChildren = $importBlocks->deletedElements($importBlock, 'repeaterChildBlocks')): ?>
                                <b><?php echo trans('admin::themes.labels.repeter_child_removed'); ?>:</b> <?php echo implode(', ', $removedRepeaterChildren); ?><br />
                            <?php endif; ?>
                            <?php if($addedToRepeaterTemplates = $importBlocks->newElements($importBlock, 'inRepeaterBlocks')): ?>
                                <b><?php echo trans('admin::themes.labels.add_to_repeter_block'); ?></b>: <?php echo implode(', ', $addedToRepeaterTemplates); ?><br />
                            <?php endif; ?>
                            <?php if($removedFromRepeaterTemplates = $importBlocks->deletedElements($importBlock, 'inRepeaterBlocks')): ?>
                                <b><?php echo trans('admin::themes.labels.remove_from_repeter_block'); ?></b>: <?php echo implode(', ', $removedFromRepeaterTemplates); ?><br />
                            <?php endif; ?>
                            <?php if($listInfo['display_class'] == 'delete'): ?>
                                <?php if($listInfo['update_templates'] >= 0 || $removedFromTemplates || $removedFromRepeaterTemplates): ?>
                                   <?php echo trans('admin::themes.labels.update_on_template'); ?> <?php echo e(implode(' and ', array_keys(array_filter([
                                        'this block' => $currentBlock->templates,
                                        'the repeater blocks above' => $currentBlock->inRepeaterBlocks
                                    ])))); ?> <?php echo trans('admin::themes.labels.remove_from_this_template'); ?><br />
                                <?php else: ?>
                                  <?php echo trans('admin::themes.labels.block_lost'); ?><br />
                                     <?php echo trans('admin::themes.labels.block_in_csv'); ?>

                                <?php endif; ?>
                            <?php elseif($addedToTemplates || $removedFromTemplates || $addedToRepeaterTemplates || $removedFromRepeaterTemplates || $updatedGlobalValues): ?>
                                  <?php echo trans('admin::themes.labels.changes_will_save'); ?> <?php echo e(implode(' and ', array_keys(array_filter([
                                    'this block' => $addedToTemplates || $removedFromTemplates  || $updatedGlobalValues,
                                    'the repeater blocks above' => $addedToRepeaterTemplates || $removedFromRepeaterTemplates
                                ])))); ?>  <?php echo trans('admin::themes.labels.changes_are_saved'); ?><br />
                            <?php endif; ?>
                            <?php if($addedToTemplates || $removedFromTemplates || $addedRepeaterChildren || $removedRepeaterChildren || $addedToRepeaterTemplates || $removedFromRepeaterTemplates || $updatedGlobalValues): ?>
                                <br />
                            <?php endif; ?>
                            <?php if($listInfo['display_class'] != 'delete' && $updatedValues = $importBlocks->updatedValues($importBlock, 'blockData')): ?>
                               <?php echo trans('admin::themes.labels.data_changes_will_saved'); ?><br />                                                               
                               <?php $__currentLoopData = $updatedValues; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field => $changedValues): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>                                                                                          
                                    <b><?php echo trans('admin::themes.labels.'.$field); ?></b>: <i><?php echo e($changedValues['old']); ?></i> => <i><?php echo e($changedValues['new']); ?></i><br />
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>

        </table>
    </div>

    <div class="form-group">
        <?php echo Form::submit(trans('admin::themes.buttons.update_blocks'), ['class' => 'btn btn-primary']); ?>

    </div>

    <?php echo Form::close(); ?>


<?php $__env->startSection('scripts'); ?>

    <script type="text/javascript">
        function disable_template_settings() {
            $(this).parent().parent().find('.based-on-template-updates').attr('disabled', !$(this).is(':checked'));
        }
        $(document).ready(function () {
            headerNote();
            $('.block_note').click(function () {
                $('#'+$(this).data('note')).toggleClass('hidden');
            });
            $('.run-template-updates').each(disable_template_settings).click(disable_template_settings);
            $('#update-all').click(function () {
                $('.run-template-updates').prop('checked', $(this).is(':checked')).each(disable_template_settings);
            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php endif; ?>
