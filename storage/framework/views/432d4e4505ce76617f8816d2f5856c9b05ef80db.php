<li id='list_<?php echo $page->id; ?>'>
    <div class='<?php echo $li_info->type; ?>'>
        <span class='disclose glyphicon'></span>
        <?php echo $li_info->altName ?: $page_lang->name; ?> <?php echo e($li_info->group ? ' &nbsp; (Group: ' . $li_info->group->name . ')' : ''); ?>

        <span class="pull-right">
            <?php if(!empty($li_info->blog) && $permissions['blog']): ?>
                <?php echo HTML::link($li_info->blog, '', ['class' => 'glyphicon glyphicon-share itemTooltip', 'title' => 'WordPress Admin', 'target' => '_blank']); ?>

            <?php endif; ?>
            <?php if($li_info->number_of_forms > 0 && $permissions['forms']): ?>
                <a href="<?php echo e(route('admin.forms.list', ['pageId' => $page->id])); ?>" class="glyphicon glyphicon-inbox itemTooltip" title="View Form Submissions"></a>
            <?php endif; ?>
            <?php if($li_info->number_of_galleries > 0 && $permissions['galleries']): ?>
                <a href="<?php echo e(route('admin.gallery.list', ['pageId' => $page->id])); ?>" class="glyphicon glyphicon-picture itemTooltip" title="Edit Gallery"></a>
            <?php endif; ?>
            <?php if($page->group_container && $permissions['group']): ?>
                <a href="<?php echo e(route('admin.groups.pages', ['groupId' => $page->group_container,'brand_id'=>$page->brand_id,'country_id'=>$page->country_id,'language_id'=>\Request::get('language_id')])); ?>" class="glyphicon glyphicon-list-alt itemTooltip" title="Manage Items"></a>
                
                
            <?php endif; ?>
            <?php if(Auth::action('pages.preview')): ?>
                <?php
                    if (!$page->is_live()) {
                        $viewTitle = trans('admin::pages.preview');
                    } else {
                        $viewTitle = ($page->link == 1) ? trans('admin::pages.document_page') : trans('admin::pages.live_page');
                    }
                ?>
                <form id="preview-page-<?php echo e($page->id); ?>" action="<?php echo e(route('admin.pages.preview')); ?>" method="POST" style="display: inline-block" target="_blank">
                    <?php echo e(csrf_field()); ?>

                    <input name="brand_id" type="hidden" value="<?php echo e($page->brand_id); ?>">
                    <input name="country_id" type="hidden" value="<?php echo e($page->country_id); ?>">
                    <input name="language_id" type="hidden" value="<?php echo e(\Request::get('language_id')); ?>">
                    <input name="url_page" type="hidden" value="<?php echo e(($li_info->preview_link != '/') ? $li_info->preview_link : ''); ?>">
                    <a href="#" class="glyphicon glyphicon-eye-open itemTooltip"
                        onclick="$('#preview-page-<?php echo e($page->id); ?>').submit(); return false;" title="<?php echo e($viewTitle); ?>"></a>
                </form>
            <?php endif; ?>
            <?php if($permissions['add'] == true && empty($page->link)): ?>
                <a href="<?php echo e(route('admin.pages.add', [
                        'pageId' => $page->group_container?0:$page->id,
                        'groupId' => $page->group_container?:null
                    ]).'?brand_id='.\Request::get('brand_id').'&country_id='.\Request::get('country_id').'&language_id='.\Request::get('language_id')); ?>"
                    class="glyphicon glyphicon-plus itemTooltip addPage"
                    title="<?php echo e($page->group_container ? trans('admin::pages.group_page') : trans('admin::pages.sub_page')); ?>"></a>
            <?php endif; ?>
            <?php if($permissions['edit'] == true): ?>
                <a href="<?php echo e(route('admin.pages.edit', ['pageId' => $page->id, 'version' => 0,
                    'language' => \Request::get('language_id')])); ?>" class="glyphicon glyphicon-pencil itemTooltip"
                    title="<?php echo e(trans('admin::pages.edit')); ?>"></a>
            <?php endif; ?>
            <?php if($permissions['delete'] == true): ?>
            <span onclick="watch_for_delete_page(<?php echo e($page->id); ?>,'<?php echo e($page_lang->name); ?>',<?php echo e($page_lang->language_id); ?>)" ><i class="delete glyphicon glyphicon-trash itemTooltip"></i></span>
<!--                <a href="javascript:void(0)" class="delete glyphicon glyphicon-trash itemTooltip"
                   data-name="<?php echo $page_lang->name; ?>" title="Delete Page">
                </a>-->
            <?php endif; ?>
        </span>
    </div>
    <?php echo $li_info->leaf; ?>

</li>
