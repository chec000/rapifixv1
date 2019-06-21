<?php
    AssetBuilder::setStatus('jquery-sortable', true);
?>

<div class="row">
    <div class="col-sm-6">
        <h1><?php echo trans('admin::pages.pages'); ?></h1>
    </div>
    <div class="col-md-6">
        <button style="float: right;" type="button" onclick="listPages()" class="btn btn-primary addButton"><i class="fa fa-search"></i> &nbsp; <?php echo trans('admin::pages.history'); ?></button>
    </div>
</div>
<?php echo Form::open(['url' => route('admin.pages.get.pages'),'method' => 'post']); ?>

<div class="container-fluid">
    <fieldset class="fieldset_gray">
        <legend class="legend_gray"><?php echo trans('admin::siteWideContent.legend_search'); ?></legend>
        <div class="row">
            <div class="col-sm-4 <?php echo FormMessage::getErrorClass('brand_id'); ?>">
                <div class="col-sm-3">
                    <?php echo Form::label('brand_id', trans('admin::siteWideContent.brand').':', ['class' => 'control-label']); ?>

                </div>
                <div class="col-sm-9">
                    <?php echo Form::select('brand_id', $brands,$brand_filter, ['placeholder' => trans('admin::siteWideContent.select_option'), 'class' => 'form-control',
                        'id' => 'select_brand_id', 'data-select_change' => 'country']); ?>

                    <span class="help-block control-label"><?php echo FormMessage::getErrorMessage('brand_id'); ?></span>
                </div>
            </div>
            <div class="col-sm-4 <?php echo FormMessage::getErrorClass('country_id'); ?>">
                <div class="col-sm-3">
                    <?php echo Form::label('country_id',trans('admin::siteWideContent.country').':', ['class' => 'control-label']); ?>

                </div>
                <div class="col-sm-9">
                    <?php echo Form::select('country_id', $countries, null, ['placeholder' => trans('admin::siteWideContent.select_option'), 'class' => 'form-control',
                        'id' => 'select_country_id' ,'data-select_change' => 'language']); ?>

                    <span class="help-block control-label"><?php echo FormMessage::getErrorMessage('country_id'); ?></span>
                </div>
            </div>
            <div class="col-sm-4 <?php echo FormMessage::getErrorClass('role_copy'); ?>">
                <div class="col-sm-3">
                    <?php echo Form::label('language_id', trans('admin::siteWideContent.language').':', ['class' => 'control-label']); ?>

                </div>
                <div class="col-sm-9">
                    <?php echo Form::select('language_id', $languages, null, ['placeholder' => trans('admin::siteWideContent.select_option'), 'class' => 'form-control', 'id' => 'select_language_id']); ?>

                    <span class="help-block control-label"><?php echo FormMessage::getErrorMessage('language_id'); ?></span>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12" align="right">
                <button id="search-btn" type="button" onclick="getPages()" class="btn btn-primary addButton"><i class="fa fa-search"></i> &nbsp; <?php echo trans('admin::siteWideContent.buttons.search'); ?></button>
            </div>
        </div>
    </fieldset>
</div>

<br/>
<hr class="hr_bold_violet">
<?php echo Form::close(); ?>


<div class="row" style="display:none; margin: 4px;" id="add_page" >
    <div class="col-sm-6">
    </div>
    <div class="col-sm-6 text-right">
        <?php if($add_page): ?>
            <?php echo Form::open(array('url' => route('admin.pages.add') ,'id' => 'form-addPage', 'method' => 'get')); ?>

            <input id="brand_id" type="hidden" value="" name="brand_id">
            <input id="country_id" type="hidden" value="" name="country_id">
            <input id="language_id" type="hidden" value="" name="language_id">
            <button type="submit" class="btn btn-warning addButton" data-page="0"><i
                        class="fa fa-plus"></i> &nbsp; <?php echo trans('admin::pages.add_page'); ?></button>
            <?php echo Form::close(); ?>

        <?php endif; ?>
    </div>
</div>

<div class="panel" id="panel" style="display: none">
<div class="row textbox">
    <div class="col-sm-8 pages_key">
        <span class="label type_normal_dark"><?php echo trans('admin::pages.normal_page'); ?></span>
        <span class="label type_link"><?php echo trans('admin::pages.link_document'); ?></span>
        <?php if($groups_exist): ?>
        <span class="label type_group"><?php echo trans('admin::pages.group_page'); ?></span>
        <?php endif; ?>
        <span class="label type_hidden"><?php echo trans('admin::pages.not_live'); ?></span>
    </div>
  <div class="col-sm-12 col-md-4">
      <?php echo Form::open(array('url' => 'support/pages/search','id' => 'form-search')); ?>

        <?php echo Form::hidden('search_entity', Modules\CMS\Entities\Page::class); ?>

        <?php echo Form::text('name', '', array('id'=>'name', 'placeholder' =>  trans('admin::pages.search_pages'), 'class' => 'form-control search-box')); ?>

      <?php echo Form::close(); ?>

    </div>
</div>
</div>


<div id="sort-wrap">

</div>
<div id="deleteModalCustom" class="modal fade" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h3><?php echo trans('admin::pages.remove'); ?>   <span class="itemTypeC"></span>: <span class="itemName"></span></h3>
            </div>
            <div class="modal-body">
                <p><?php echo trans('admin::pages.delete_confirm'); ?> <span class="itemType"></span> '<span class="itemName"></span>' <?php echo trans('admin::pages.for_all_languages'); ?>?
                </p>
            </div>
            <div class="modal-footer">
                <button class="btn no" data-dismiss="modal"><i class="fa fa-times"></i> &nbsp; <?php echo trans('admin::pages.no'); ?> </button>
                <button class="btn btn-primary yes" data-dismiss="modal"><i class="fa fa-check"></i> &nbsp; <?php echo trans('admin::pages.yes'); ?> </button>
            </div>
        </div>
    </div>
</div>
 <?php echo Form::open(array('url' => 'support/pages/delete','id' => 'form-delete')); ?>

 <?php echo Form::close(); ?>

<?php $__env->startSection('scripts'); ?>
    <script type='text/javascript'>
        var expanded = <?php echo json_encode($page_states); ?>;
        var rootPages = <?php echo json_encode($rootPageIds); ?>;
        var filters = [
            $('#select_brand_id'),
            $('#select_country_id'),
            $('#select_language_id')
        ];

        $(document).ready(function () {
            <?php if($max): ?>
                $('.addPage').click(function () {
                    event.preventDefault();
                    cms_alert('danger', 'Max Pages Reached');
                });
            <?php endif; ?>

            var initList = function() {
                $('#sortablePages').nestedSortable({
                    forcePlaceholderSize: true,
                    handle: 'div',
                    helper: 'clone',
                    items: 'li',
                    opacity: .6,
                    placeholder: 'placeholder',
                    revert: 250,
                    tabSize: 25,
                    tolerance: 'pointer',
                    toleranceElement: '> div',
                    maxLevels: 10,
                    isTree: true,
                    expandOnHover: 700,
                    startCollapsed: true,
                    isAllowed: function canMovePage(placeholder, placeholderParent, currentItem) {
                        return !(placeholderParent && (rootPages.indexOf(placeholderParent.attr('id')) != -1
                            || rootPages.indexOf(currentItem.attr('id')) != -1));
                    }
                });

                $('.disclose').on('click', function (e) {
                    var li = $(this).closest('li');
                    li.toggleClass('mjs-nestedSortable-collapsed').toggleClass('mjs-nestedSortable-expanded');
                    if (!e.isTrigger) {
                        $.ajax({
                            url:  route('admin.account.page-state'),
                            type: 'POST',
                            data: {
                                page_id: li.attr('id').replace('list_', ''),
                                expanded: li.hasClass('mjs-nestedSortable-expanded')
                            }
                        });
                    }
                });

                initialize_sort('nestedSortable', window.location.href + '/sort');
                watch_for_delete('.delete', 'page', function (el) {
                    return el.closest('li').attr('id');
                });

            };

            initList();
            $.each(expanded, function(index, value) {
                $('#list_'+value+ '.mjs-nestedSortable-branch > .ui-sortable-handle > .disclose').trigger('click');
            });

            var filter=<?php echo $brand_filter; ?>;
            if(filter!==-1){
                select_country_combo("<?php echo e(trans('admin::siteWideContent.select_option')); ?>", <?php echo $brand_filter; ?>,
                    <?php echo $country_filter; ?> ,<?php echo $language_filter; ?>);
            }


        });

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

        function getPages() {
            var brand=$("#select_brand_id").val();
            var country=$("#select_country_id").val();
            var language=$("#select_language_id").val();
            if (brand!==""&&country!==""&&language!=="") {
                $.ajax({
                    type: 'POST',
                    url: route('admin.pages.get.pages'),
                    data: {brand_id:brand,country_id:country,language_id:language},
                    success: function(r) {
                        $('#form-addPage #brand_id').val(brand);
                        $('#form-addPage #country_id').val(country);
                        $('#form-addPage #language_id').val(language);
                        $("#add_page").css('display','block');
                        if(r.code===200){
                            $("#panel").css('display','block');
                            $('#sort-wrap').html(r.data);
                        }else{
                            $("#panel").css('display','none');
                            $('#sort-wrap').html(r.data);
                            watch_for_delete('.delete', 'page', function (el) {
                                return el.closest('li').attr('id');
                            });
                        }
                    }
                });
            }
        }

        function listPages(){
            $('#listpages').modal('show');
        }

        $('#list_table_pages').DataTable({
            "responsive": true,
            "ordering": false,
            "language": {
                "url": "<?php echo e(trans('admin::datatables.lang')); ?>"
            }
        });

        var page_name_delete;
        var deletedItems = {};
        function watch_for_delete_page(page_id,page_name,page_lang) {
            page_name_delete=page_name;
            var delete_modal_el = $('#deleteModalCustom');
            selector=$("#list_"+page_id);
            delete_modal_el.find('.itemName').html(page_name);
            delete_modal_el.find('.itemType').html( '<?php echo trans('admin::pages.page'); ?>');
            delete_modal_el.find('.itemTypeC').html('<?php echo trans('admin::pages.page'); ?>');
            delete_modal_el.modal('show');
            custom_url = window.location.href.split('#')[0]+'/delete';
            delete_modal_el.find('.yes').click(function() {
                var  url=   $("#form-delete").attr('action');
                $.ajax({
                    dataType: 'json',
                    url: url+'/'+page_id,
                    type: 'POST',
                    success: function(r) {
                        var logIds = r.join(',');
                        cms_alert_pages('warning', '<?php echo trans('admin::pages.the'); ?> ' + '<?php echo trans('admin::pages.page'); ?>' +
                            ' \'' + page_name + '\' <?php echo trans('admin::pages.has_delete'); ?>.<a href="#" onclick="undo_log_pages('+logIds+' )"> <?php echo trans('admin::pages.undo'); ?></a>'); getPages();
                    },
                    error: function() {
                        cms_alert_pages('danger', '<?php echo trans('admin::pages.the'); ?> ' + page_name + ' <?php echo trans('admin::pages.no_delete'); ?>)');
                    }
                });
            });
        }

        var alertTitle = {danger:'Error',info:'Notice',success:'Success',warning:'Warning'};
        function cms_alert_pages(alertClass, alertContent) {
            var newNotification = $('#cmsDefaultNotification').clone();
            newNotification.append('<b>'+alertTitle[alertClass].capitalize()+':</b> '+alertContent).addClass('alert-'+alertClass).show();
            $('#cmsNotifications').append(newNotification);
            setTimeout(function() {
                newNotification.fadeOut(2500, function () {$(this).remove();});
            }, 7500);
            $('html, body').animate({scrollTop: 0}, 500);
        }

        function undo_log_pages(logIds) {
            if ($.type(logIds) === 'string') {
                logIds = logIds.split(',');
            }
            var deletedItem;
            if (!(deletedItem = deletedItems[logIds.toString()])) {
                deletedItem = {item: '<?php echo trans('admin::pages.page'); ?>', name:page_name_delete};
            }
            $.ajax({
                url: route('admin.backups.undo'),
                data: {'log_ids': logIds},
                type: 'POST',
                success: function () {
                    $('#' + deletedItem.id).show();
                    cms_alert('info', '<?php echo trans('admin::pages.the'); ?> ' + deletedItem.item +
                        ' \'' + deletedItem.name + '\' <?php echo trans('admin::pages.page_restored'); ?>');
                    getPages();
                },
                error: function () {
                    cms_alert('danger', '<?php echo trans('admin::pages.the'); ?> ' + deletedItem.item +
                    '<?php echo trans('admin.pages.page_no_restored'); ?>');
                }
            });
        }
    </script>
<?php $__env->stopSection(); ?>
