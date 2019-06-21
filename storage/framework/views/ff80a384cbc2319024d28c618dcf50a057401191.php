<?php AssetBuilder::setStatus('cms-editor', true); ?>

<h1><?php echo $item_name; ?>: <?php echo $page_lang->name; ?></h1>

<div class="row textbox">
    <div class="col-sm-4">
        <?php $__currentLoopData = $page->groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <p><a href="<?php echo route('admin.groups.pages', ['groupId' => $group->id,'brand_id'=>$brand->id,'country_id'=>$country->id,'language_id'=>$language->id]); ?>">Back to <?php echo $group->name; ?></a></p>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php if($publishingOn && $page->link == 0): ?>
            <p id="version-well" class="well">
                Published Version: #<span class="live_version_id"><?php echo e($version['live']); ?></span>
                <?php if($page->is_live()): ?>
                    <?php $published = '<b>&nbsp;<span class="text-success version-p"> - latest version live</span></b>'; ?>
                    <?php $unPublished = '<b>&nbsp;<span class="text-danger version-up"> - latest version not published</span></b>'; ?>
                <?php else: ?>
                    <?php $published = '<b>&nbsp;<span class="text-warning version-p"> - latest version published (page not live)</span></b>'; ?>
                    <?php $unPublished = ' <b>&nbsp;<span class="text-danger version-up"> - latest version not published & page not live</span></b>'; ?>
                <?php endif; ?>
                <?php if($version['live'] != $version['latest']): ?>
                    <?php echo str_replace('version-p', 'version-p hidden', $published).$unPublished; ?>

                <?php else: ?>
                    <?php echo $published.str_replace('version-up', 'version-up hidden', $unPublished); ?>

                <?php endif; ?>
                <br />
                Editing From Version: #<?php echo e($version['editing']); ?> &nbsp;&nbsp; (Latest Version: #<?php echo e($version['latest']); ?>)
            </p>
        <?php endif; ?>
    </div>
    <div class="col-sm-8 text-right">
        <?php if($auth['can_duplicate']): ?>
            <button class="btn btn-danger" id="duplicate-btn">
                <i class="fa fa-files-o"></i> &nbsp; <?php echo e(trans('admin::pages.duplicate_page')); ?>

            </button> &nbsp;
        <?php endif; ?>
        <?php if($auth['can_preview']): ?>
            <form action="<?php echo e(route('admin.pages.preview')); ?>" method="POST" style="display: inline-block" target="_blank">
                <?php echo e(csrf_field()); ?>

                <input name="brand_id" type="hidden" value="<?php echo e($brand->id); ?>">
                <input name="country_id" type="hidden" value="<?php echo e($country->id); ?>">
                <input name="language_id" type="hidden" value="<?php echo e($language->id); ?>">
                <input name="extra" type="hidden" value="/">
                <input name="url_page" type="hidden" value="<?php echo e(($page_lang->url != '/') ? $page_lang->url : ''); ?>">
                <?php if(!$page->is_live()): ?>
                    <input name="preview_key" type="hidden" value="<?php echo e($frontendLink); ?>">
                <?php endif; ?>
                <button class="btn btn-warning btn_preview_page" type="submit">
                    <i class="fa fa-eye"></i> &nbsp;
                    <?php if(!$page->is_live()): ?>
                        <?php echo e(trans('admin::pages.preview')); ?>

                    <?php else: ?>
                        <?php echo e(($page->link == 1) ? trans('admin::pages.document_page') : trans('admin::pages.live_page')); ?>

                    <?php endif; ?>
                </button>
            </form>
        <?php endif; ?>
        <form action="<?php echo e(route('admin.pages.index')); ?>" method="get" style="display: inline-block">
            <input name="brand_id" type="hidden" value="<?php echo e($brand->id); ?>">
            <input name="country_id" type="hidden" value="<?php echo e($country->id); ?>">
            <input name="language_id" type="hidden" value="<?php echo e($language->id); ?>">
            <button class="btn btn-warning"  type="submit">
                <?php echo e(trans('admin::brand.form_add.back_list')); ?>

                <i class="fa fa-reply"></i>
            </button>
        </form>
    </div>
</div>

<hr class="hr_bold_violet">

<?php echo Form::open(['class' => 'form-horizontal', 'id' => 'editForm', 'enctype' => 'multipart/form-data']); ?>

    <div class="tabbable full-width-tabs" id="contentTabs">
        <h4><?php echo trans('admin::pages.global_details'); ?></h4>
        <div class="form-group">
            <div class="row" >
                <label for="brand_id" class="control-label col-md-2"><?php echo trans('admin::pages.brand'); ?>: </label>
                <div class="col-sm-10">
                    <span class="form-control"><?php echo e($brand->name); ?></span>
                    <input name="brand_id" type="hidden" value="<?php echo e($brand->id); ?>">
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <label for="country_id" class="control-label col-md-2"><?php echo trans('admin::pages.country'); ?>:</label>
                <div class="col-sm-10">
                    <span class="form-control"><?php echo e($country->name); ?></span>
                    <input name="country_id" type="hidden" value="<?php echo e($country->id); ?>">
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <label for="language_id" class="control-label col-md-2"><?php echo trans('admin::pages.language'); ?>:</label>
                <div class="col-sm-10">
                    <span class="form-control"><?php echo e($language->language); ?></span>
                    <input name="language_id" type="hidden" value="<?php echo e($language->id); ?>">
                    <input name="language_id" id="language_id_repeater" type="hidden" value="<?php echo e($language->id); ?>">
                </div>
            </div>
        </div>
        <ul class="nav nav-tabs">
            <?php echo $tab['headers']; ?>

        </ul>
        <div class="tab-content">
            <?php echo $tab['contents']; ?>

        </div>
    </div>

    <input type="hidden" name="versionFrom" value="<?php echo e($version['editing']); ?>">
    <input type="hidden" name="duplicate" value="0" id="duplicate_set">
    <input type="hidden" name="duplicate_brand" value="0" id="duplicate_brand">
    <input type="hidden" name="duplicate_country" value="0" id="duplicate_country">
    <input type="hidden" name="duplicate_language" value="0" id="duplicate_language">
    <input type="hidden" name="duplicate_url" value="<?php echo e($page_lang->url ?: '/'); ?>">
<?php echo Form::close(); ?>


<div id="duplicate-modal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><?php echo e(trans('admin::pages.duplicate_modal_header')); ?></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-4 <?php echo FormMessage::getErrorClass('brand_id'); ?>">
                        <div class="form-group">
                            <label for="brand_id"><?php echo Form::label('brand_id', trans('admin::pages.brand').':', ['class' => 'control-label']); ?></label>
                            <?php echo Form::select('brand_id', $brands, null, ['placeholder' => trans('admin::pages.select_option'),
                                'class' => 'form-control', 'id' => 'select_brand_id', 'data-select_change' => 'country']); ?>

                                <span class="help-block control-label"><?php echo FormMessage::getErrorMessage('brand_id'); ?></span>
                        </div>
                    </div>
                    <div class="col-sm-4 <?php echo FormMessage::getErrorClass('country_id'); ?>">
                        <div class="form-group">
                            <label for="country_id"><?php echo Form::label('country_id', trans('admin::pages.country').':', ['class' => 'control-label']); ?></label>
                            <?php echo Form::select('country_id', $countries, null, ['placeholder' => trans('admin::pages.select_option'),
                                'class' => 'form-control', 'id' => 'select_country_id', 'data-select_change' => 'language']); ?>

                                <span class="help-block control-label"><?php echo FormMessage::getErrorMessage('country_id'); ?></span>
                        </div>
                    </div>
                    <div class="col-sm-4 <?php echo FormMessage::getErrorClass('role_copy'); ?>">
                        <div class="form-group">
                            <label for="language_id"><?php echo Form::label('language_id', trans('admin::pages.language').':', ['class' => 'control-label']); ?></label>
                            <?php echo Form::select('language_id', $languages, null, ['placeholder' => trans('admin::pages.select_option'),
                                'class' => 'form-control', 'id' => 'select_language_id']); ?>

                                <span class="help-block control-label"><?php echo FormMessage::getErrorMessage('language_id'); ?></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">
                    <?php echo e(trans('admin::pages.duplicate_modal_close')); ?>

                </button>
                <button id="confirm-duplicate" type="button" class="btn btn-primary">
                    <?php echo e(trans('admin::pages.duplicate_modal_confirm')); ?>

                </button>
            </div>
        </div>
    </div>
</div>

<?php $__env->startSection('scripts'); ?>
    <script type='text/javascript'>
        var filters = [
            $('#select_brand_id'),
            $('#select_country_id'),
            $('#select_language_id')
        ];

        function duplicatePage() {
            $('#select_brand_id').val('');
            $('#select_country_id').val('');
            $('#select_language_id').val('');
            validateFilters(filters, $('#confirm-duplicate'));
            $('#duplicate-modal').modal('show');
        }

        function duplicateConfirm() {
            $('#duplicate_set').val(1);
            $('#editForm').trigger('submit');
        }

        function backgroundTabs() {
            $(".take-all-space-you-can")
                .removeClass("tab_background_violet_active")
                .addClass( "tab_background_violet" );
        }

        $(document).ready(function () {
            console.log(route('admin.pages.showPreviewPage'));
            selected_tab('#editForm', parseInt(<?php echo e($page->link ? 0 : 1); ?>));
            updateListenPageUrl(true);
            updateListenLiveOptions();
            updateListenGroupFields();
            load_editor_js();
            headerNote();
            $('#duplicate-btn').click(function () {
                duplicatePage();
            });

            page_id = parseInt(<?php echo e($page->id); ?>);
            latest_version = '<?php echo e($version['latest']); ?>';
            $(".take-all-space-you-can").click(function () {
                backgroundTabs();
                $(this).removeClass("tab_background_violet").addClass( "tab_background_violet_active");
            });

            $(".take-all-space-you-can.active")
                .removeClass("tab_background_violet")
                .addClass( "tab_background_violet_active" );

            $('#confirm-duplicate').click(function () {
                duplicateConfirm();
            });

            $('#select_brand_id').change(function () {
                var select = $(this).data('select_change');
                var search_id = $(this).val();
                $('#duplicate_brand').val(search_id);
                var optionDefault = "<?php echo e(trans('admin::menusCMS.select_option')); ?>";
                update_selects_country_language(select, search_id, optionDefault);
            });

            $('#select_country_id').change(function () {
                var select = $(this).data('select_change');
                var search_id = $(this).val();
                $('#duplicate_country').val(search_id);
                var optionDefault = "<?php echo e(trans('admin::menusCMS.select_option')); ?>";
                update_selects_country_language(select, search_id, optionDefault);
            });

            $('#select_language_id').change(function () {
                var id = $(this).val();
                $('#duplicate_language').val(id);
            });

            initFilters(filters, $('#confirm-duplicate'));
        });
    </script>
<?php $__env->appendSection(); ?>
