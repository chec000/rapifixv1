<?php AssetBuilder::setStatus('cms-editor', true); ?>

<div class="row">
    <div class="col-sm-8">
        <h1><?php echo trans('admin::siteWideContent.title_swc'); ?></h1>
    </div>
    <div class="col-sm-4" align="right">
        <button id="btnShowStatsBlocks" type="button" class="btn btn-primary">
            <i class="fa fa-search"></i> &nbsp <?php echo trans('admin::siteWideContent.records_history'); ?>

        </button>
    </div>
</div>

<?php echo Form::open(['url' => route('admin.blocks.index.filters')]); ?>

    <div class="container-fluid">
        <fieldset class="fieldset_gray">
            <legend class="legend_gray"><?php echo trans('admin::siteWideContent.legend_search'); ?></legend>
            <div class="row">
                <div class="col-sm-4 <?php echo FormMessage::getErrorClass('brand_id'); ?>">
                    <div class="col-sm-3">
                        <?php echo Form::label('brand_id', trans('admin::siteWideContent.brand').':', ['class' => 'control-label']); ?>

                    </div>
                    <div class="col-sm-9">
                        <?php echo Form::select('brand_id', $brands, null, ['placeholder' => trans('admin::siteWideContent.select_option'),
                            'class' => 'form-control', 'id' => 'select_brand_id', 'data-select_change' => 'country']); ?>

                        <span class="help-block control-label"><?php echo FormMessage::getErrorMessage('brand_id'); ?></span>
                    </div>
                </div>
                <div class="col-sm-4 <?php echo FormMessage::getErrorClass('country_id'); ?>">
                    <div class="col-sm-3">
                        <?php echo Form::label('country_id',trans('admin::siteWideContent.country').':', ['class' => 'control-label']); ?>

                    </div>
                    <div class="col-sm-9">
                        <?php echo Form::select('country_id', $countries, null, ['placeholder' => trans('admin::siteWideContent.select_option'),
                            'class' => 'form-control', 'id' => 'select_country_id' ,'data-select_change' => 'language']); ?>

                        <span class="help-block control-label"><?php echo FormMessage::getErrorMessage('country_id'); ?></span>
                    </div>
                </div>
                <div class="col-sm-4 <?php echo FormMessage::getErrorClass('role_copy'); ?>">
                    <div class="col-sm-3">
                        <?php echo Form::label('language_id', trans('admin::siteWideContent.language').':', ['class' => 'control-label']); ?>

                    </div>
                    <div class="col-sm-9">
                        <?php echo Form::select('language_id', $languages, null, ['placeholder' => trans('admin::siteWideContent.select_option'),
                            'class' => 'form-control', 'id' => 'select_language_id']); ?>

                        <span class="help-block control-label"><?php echo FormMessage::getErrorMessage('language_id'); ?></span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12" align="right">
                    <button id="search-btn" type="submit" class="btn btn-primary addButton">
                        <i class="fa fa-search"></i> &nbsp; <?php echo trans('admin::siteWideContent.buttons.search'); ?>

                    </button>
                </div>
            </div>
        </fieldset>
    </div>
<?php echo Form::close(); ?>


<hr class="hr_bold_violet">

<?php echo Form::open(['url' => route('admin.blocks.index.post'), 'id' => 'blocksForm', 'class' => 'form-horizontal', 'enctype' => 'multipart/form-data']); ?>

<div class="tabbable full-width-tabs" id="contentTabs">

    <ul id="idNavBlocks" class="nav nav-tabs">
        <?php echo $tab['headers']; ?>

    </ul>

    <div class="tab-content">
        <?php echo $tab['contents']; ?>


        <input type="hidden" id="id_brand_id" name="brand_id" value="1">
        <input type="hidden" id="id_country_id" name="country_id" value="1">
        <input type="hidden" id="id_language_id" name="language_id" value="1">
    </div>
</div>
<?php echo Form::close(); ?>


<div id="statsBlockModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h3><?php echo trans('admin::siteWideContent.records_history_swc'); ?></h3>
            </div>
            <div class="modal-body form-horizontal">
                <div class="table">
                    <table class="table table-striped" id="statsBlocksTable">
                        <thead>
                        <tr>
                            <th><?php echo trans('admin::siteWideContent.brand'); ?></th>
                            <th><?php echo trans('admin::siteWideContent.country'); ?></th>
                            <th><?php echo trans('admin::siteWideContent.language'); ?></th>
                            <th><?php echo trans('admin::siteWideContent.category'); ?></th>
                            <th><?php echo trans('admin::siteWideContent.block'); ?></th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $statsBlocks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $statCategory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php $__currentLoopData = $statCategory; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $statBlock): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo $statBlock['brand']; ?></td>
                                <td><?php echo $statBlock['country']; ?></td>
                                <td><?php echo $statBlock['language']; ?></td>
                                <td><?php echo $statBlock['category']; ?></td>
                                <td><i class="fa fa-check-circle success"></i> &nbsp;<?php echo $statBlock['block_name']; ?></td>
                            </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                           <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>

                </div>
            </div>
            <div class="modal-footer">
                <button class="btn cancel" data-dismiss="modal"><i class="fa fa-times"></i> &nbsp; <?php echo trans('admin::siteWideContent.buttons.close'); ?></button>
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

        function backgroundTabs(){
            $("#idNavBlocks li").removeClass("tab_background_violet_active");
            $("#idNavBlocks li").addClass( "tab_background_violet" );
            $.each($("#idNavBlocks li"), function () {
                if($(this).hasClass("active")) {
                    $(this).removeClass("tab_background_violet");
                    $(this).addClass( "tab_background_violet_active" );
                }
            });
        }

        $('#statsBlocksTable').DataTable({
            "responsive": true,
            "ordering": false,
            "language": {
                "url": "<?php echo e(trans('admin::datatables.lang')); ?>"
            }
        });

        $(document).ready(function () {
            selected_tab('#blocksForm', 0);
            load_editor_js();
            update_inputs_blocks_hide();

            $('#select_brand_id').change(function () {
                var select = $(this).data('select_change');
                var search_id = $(this).val();
                var optionDefault =  "<?php echo e(trans('admin::siteWideContent.select_option')); ?>";
                update_selects_country_language(select, search_id, optionDefault);
            });

            $('#select_country_id').change(function () {
                var select = $(this).data('select_change');
                var search_id = $(this).val();
                var optionDefault =  "<?php echo e(trans('admin::siteWideContent.select_option')); ?>";
                update_selects_country_language(select, search_id, optionDefault);
            });

            initFilters(filters, $('#search-btn'));

            $('#btnShowStatsBlocks').on('click',function () {
                $('#statsBlockModal').modal('show');
            });

            backgroundTabs();

            $("#idNavBlocks li").click(function(){
                $("#idNavBlocks li").removeClass("tab_background_violet_active");
                $("#idNavBlocks li").addClass( "tab_background_violet" );
                $(this).removeClass("tab_background_violet");
                $(this).addClass( "tab_background_violet_active" );
            });
        });
    </script>
<?php $__env->stopSection(); ?>
