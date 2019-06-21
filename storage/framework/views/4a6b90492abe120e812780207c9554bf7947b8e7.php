<h4><?php echo e(trans('admin::pages.page_details.header')); ?></h4>

<?php echo CmsBlockInput::make('string', ['name' => 'page_info[code]', 'label' => trans('admin::pages.page_details.code'),
    'content' => $page->code, 'disabled' => !$can_publish ]); ?>


<?php if($parentPages && !$page->id): ?>
    <?php echo CmsBlockInput::make('select', ['name' => 'page_info[parent]', 'label' => trans('admin::pages.page_details.parent_page'),
        'content' => $page->parent, 'selectOptions' => $parentPages]); ?>

<?php else: ?>
    <?php echo Form::hidden('page_info[parent]', $page->parent, ['id' => 'page_info[parent]']); ?>

<?php endif; ?>

<?php if($publishing_on && $page->id && $page->link == 0): ?>
    <p class="col-sm-offset-2 col-sm-10">
        <?php echo e(trans('admin::pages.item')); ?> <?php echo e($beacon_select ? 'beacons, ' : ''); ?><?php echo e(trans('admin::pages.page_details.not_versioned')); ?>

    </p>
<?php endif; ?>

<?php if($beacon_select): ?>
    <?php echo CmsBlockInput::make('selectmultiple', array('name' => 'page_info_other[beacons]',
        'label' => trans('admin::pages.page_details.beacons'),
        'content' => $beacon_select->selected, 'selectOptions' => $beacon_select->options)); ?>

<?php endif; ?>

<?php echo CmsBlockInput::make('string', ['name' => 'page_info_lang[name]', 'label' => trans('admin::pages.page_details.name'),
    'content' => $page_lang->name, 'disabled' => !$can_publish && $page->id ]); ?>


<div class="form-group <?php echo FormMessage::getErrorClass('page_info_lang[url]'); ?>">
    <?php echo Form::label('page_info_lang[url]', trans('admin::pages.page_details.url'), ['class' => 'control-label col-sm-2']); ?>

    <div class="col-sm-10">
        <div id="url-group" class="input-group">
            <?php if(!$page->id || $page->link == 0): ?>
                <?php if(count($urlPrefixes) > 1): ?>
                    <div class="input-group-addon url-dropdown">
                        <select name="page_info[canonical_parent]" title="Canonical Parent">
                            <?php if($page->canonical_parent): ?>
                                <option value="0">Unset canonical: <?php echo e($urlArray[$page->canonical_parent]); ?></option>
                            <?php endif; ?>
                            <?php $__currentLoopData = $urlPrefixes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $urlPrefix => $priority): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($urlPrefix); ?>" <?php echo e($loop->first ? 'selected="selected"' : ''); ?>><?php echo e($urlArray[$urlPrefix]); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                <?php else: ?>
                    <span class="input-group-addon" id="url-prefix"><?php echo e($urlArray[key($urlPrefixes)]); ?></span>
                <?php endif; ?>
            <?php endif; ?>
            <?php $options = []; if (!$can_publish && $page->id): $options = ['disabled' => true]; endif; ?>
            <?php echo Form::text('page_info_lang[url]', urldecode($page_lang->url), ['class' => 'form-control', 'id' => 'page_info_url'] + $options); ?>

            <?php if(!$page->id || $page->link == 1): ?>
                <span class="input-group-addon link_show"><?php echo e(trans('admin::pages.page_details.or')); ?></span>
                <span class="input-group-btn link_show">
                    <a href="<?php echo URL::to(config('admin.config.public').'/filemanager/dialog.php?type=2&field_id=page_info_url'); ?>"
                       class="btn btn-default iframe-btn"><?php echo e(trans('admin::pages.page_details.select_doc')); ?></a>
                </span>
            <?php endif; ?>
        </div>
        <span class="help-block"><?php echo FormMessage::getErrorMessage('page_info_lang[url]'); ?></span>
        <?php if(!$page->id): ?>
            <div class="checkbox <?php echo FormMessage::getErrorClass('page_info[link]'); ?>">
                <label>
                    <?php echo Form::checkbox('page_info[link]', 1, 0, ['id' => 'page_info[link]']); ?>

                    <?php echo e(trans('admin::pages.page_details.link_or_doc')); ?>

                </label>
            </div>
        <?php else: ?>
            <?php echo \Form::hidden('page_info[link]', $page->link, ['id' => 'page_info[link]']); ?>

        <?php endif; ?>
    </div>
</div>

<script type="text/javascript">
    var urlArray = <?php echo json_encode($urlArray); ?>;
</script>
