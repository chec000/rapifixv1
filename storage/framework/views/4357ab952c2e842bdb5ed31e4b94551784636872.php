<?php AssetBuilder::setStatus('jquery-sortable', true); ?>

<div class="row">
    <div class="col-sm-8">
        <h1><?php echo trans('admin::menusCMS.title_menus'); ?></h1>
    </div>
    <div class="col-sm-4 v-center" align="right">
        <button id="btnShowStatsMenus" type="button" class="btn btn-primary">
            <i class="fa fa-search"></i> &nbsp <?php echo trans('admin::menusCMS.records_history'); ?>

        </button>
    </div>
</div>

<?php echo Form::open(['url' => route('admin.menus.index.filters'), 'method' => 'GET']); ?>

    <div class="container-fluid">
        <fieldset class="fieldset_gray">
            <legend class="legend_gray"><?php echo trans('admin::menusCMS.legend_search'); ?></legend>
            <div class="row">
                <div class=" col-sm-4 <?php echo FormMessage::getErrorClass('brand_id'); ?>">
                    <div class="col-sm-3">
                        <?php echo Form::label('brand_id', trans('admin::menusCMS.brand').':', ['class' => 'control-label']); ?>

                    </div>
                    <div class="col-sm-9">
                        <?php echo Form::select('brand_id', $brands, null, ['placeholder' => trans('admin::menusCMS.select_option'),
                            'class' => 'form-control', 'id' => 'select_brand_id', 'data-select_change' => 'country']); ?>

                        <span class="help-block control-label"><?php echo FormMessage::getErrorMessage('brand_id'); ?></span>
                    </div>
                </div>
                <div class=" col-sm-4 <?php echo FormMessage::getErrorClass('country_id'); ?>">
                    <div class="col-sm-3">
                        <?php echo Form::label('country_id', trans('admin::menusCMS.country').':', ['class' => 'control-label']); ?>

                    </div>
                    <div class="col-sm-9">
                        <?php echo Form::select('country_id', $countries, null, ['placeholder' => trans('admin::menusCMS.select_option'),
                            'class' => 'form-control', 'id' => 'select_country_id', 'data-select_change' => 'language']); ?>

                        <span class="help-block control-label"><?php echo FormMessage::getErrorMessage('country_id'); ?></span>
                    </div>
                </div>
                <div class="col-sm-4 <?php echo FormMessage::getErrorClass('role_copy'); ?>">
                    <div class="col-sm-3">
                        <?php echo Form::label('language_id', trans('admin::menusCMS.language').':', ['class' => 'control-label']); ?>

                    </div>
                    <div class="col-sm-9">
                        <?php echo Form::select('language_id', $languages, null, ['placeholder' => trans('admin::menusCMS.select_option'),
                            'class' => 'form-control', 'id' => 'select_language_id']); ?>

                        <span class="help-block control-label"><?php echo FormMessage::getErrorMessage('language_id'); ?></span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class=" col-sm-12 " align="right">
                    <button id="search-btn" type="submit" class="btn btn-primary addButton">
                        <i class="fa fa-search"></i> &nbsp; <?php echo trans('admin::menusCMS.buttons.search'); ?>

                    </button>
                </div>
            </div>
        </fieldset>
    </div>
<?php echo Form::close(); ?>

<hr class="hr_bold_violet">
<div id="show_menus_content">
    <?php echo $menus; ?>

</div>

<?php $__env->startSection('scripts'); ?>
    <script type="text/javascript">
        var _SORT_MENU_URL = '<?php echo e(url('support/menus/sort')); ?>';
    </script>
    <script type="text/javascript">
        var selected_menu;
        var selected_item;
        var filters = [
            $('#select_brand_id'),
            $('#select_country_id'),
            $('#select_language_id')
        ];

        $('.sub-levels').click(function () {
            var spModal = $('#subLevelMIModal');
            spModal.find('.page-name').html($(this).data('name'));
            selected_item = $(this).closest('li');
            $.ajax({
                url: route('admin.menus.get-levels'),
                type: 'POST',
                dataType: 'json',
                data: {id: selected_item.data('id')},
                success: function (r) {
                    $('#subLevelMIModal').modal('show');
                    $('#sublevels').val(r.sub_levels);
                    spModal.find('.page-levels').html(r.max_levels);
                    spModal.find('.menu-max-levels').html(r.menu_max_levels);
                    spModal.find('option:gt(0)').hide();
                    spModal.find('option:lt(' + (r.menu_max_levels + 1) + ')').show();
                },
                error: function () {
                    cms_alert('danger', 'Error receiving data');
                }
            });
        });

        $('#subLevelMIModal .change').click(function () {
            var sl = $('#sublevels').val();
            $.ajax({
                url: route('admin.menus.save-levels'),
                type: 'POST',
                dataType: 'json',
                data: {id: selected_item.data('id'), sub_level: sl},
                success: function (r) {
                    selected_item.find('> ol').remove();
                    selected_item.find('.sl_numb').html(sl);
                    selected_item.removeClass().append(r.children);
                    if (r.children) {
                        selected_item.addClass('mjs-nestedSortable-branch mjs-nestedSortable-collapsed');
                    } else {
                        selected_item.addClass('mjs-nestedSortable-leaf');
                    }
                    initList();
                }, error: function() {
                    cms_alert('danger', 'Error updating menu item');
                }
            });
        });

        $('#renameMIModal .change').click(function () {
            var custom_name = $('#custom_name').val();
            var langId = $('#select_language_id').val();
            $.ajax({
                url: route('admin.menus.renamev2'),
                type: 'POST',
                data: {id: selected_item.data('id'), pageId: selected_item.data('page-id'), customName: custom_name, langId: langId},
                success: function () {
                    if (custom_name != '') {
                        selected_item.find('> div > .custom-name').html("&nbsp;(Custom Name: " + custom_name + ")");
                    } else {
                        selected_item.find('> div > .custom-name').html('');
                    }
                }, error: function() {
                    cms_alert('danger', 'Error updating menu item');
                }
            });
        });

        $('#addMIModal .add').click(function () {
            $.ajax({
                url: route('admin.menus.add'),
                type: 'POST',
                data: {id: $('#menu_item').val(), menu: selected_menu},
                success: function (r) {
                    if (r % 1 === 0) {
                        location.reload();
                    }
                    else {
                        cms_alert('danger', 'The menu item was not added');
                    }
                }
            });
        });

        function add_item(menu) {
            selected_menu = menu;
            $('#addMIModal').modal('show');
        }

        function sort_items_s(menu) {
            $('#' + menu + '_saved').removeClass('hide');
            $('#' + menu + '_add').addClass('hide');
            setTimeout(function () {
                $('#' + menu + '_saved').addClass('hide');
                $('#' + menu + '_add').removeClass('hide');
            }, 2000);
        }

        function sort_items_f(menu) {
            $('#' + menu + '_failed').removeClass('hide');
            $('#' + menu + '_add').addClass('hide');
            setTimeout(function () {
                $('#' + menu + '_failed').addClass('hide');
                $('#' + menu + '_add').removeClass('hide');
            }, 2000);
        }

        function hidePage(liItem, hide) {
            $.ajax({
                url: route('admin.menus.hide-page'),
                type: 'POST',
                dataType: 'json',
                data: {hide: hide ? 1 : 0, itemId: liItem.data('id'), pageId: liItem.data('page-id')},
                success: function () {
                    if (hide) {
                        liItem.addClass('hidden-page');
                        liItem.find('.hide-page').addClass('fa-eye').removeClass('fa-eye-slash');
                    } else {
                        liItem.removeClass('hidden-page');
                        liItem.find('.hide-page').addClass('fa-eye-slash').removeClass('fa-eye');
                    }
                }, error: function() {
                    cms_alert('danger', 'Error updating menu item');
                }
            });
        }

        var initList = function() {
            $('.sortable').nestedSortable({
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
                disableParentChange: true,
            });

            $('.disclose').unbind('click').on('click', function () {
                $(this).closest('li').toggleClass('mjs-nestedSortable-collapsed').toggleClass('mjs-nestedSortable-expanded');
            });

            initialize_sort('nestedSortable', _SORT_MENU_URL, sort_items_s, sort_items_f);
            watch_for_delete('.delete', 'menu item', function (el) {
                return el.closest('li').attr('id');
            }, route('admin.menus.delete', {itemId: ''}));

            $('.rename').unbind('click').click(function () {
                selected_item = $(this).closest('li');
                $('#renameMIModal').modal('show');
            });

            $('.hide-page').unbind('click').click(function () {
                hidePage($(this).closest('li'), $(this).hasClass('fa-eye-slash'));
            });
        };

        function showMenusContent() {
           if($('#select_brand_id').val() !== "" && $('#select_country_id').val() !== "" && $('#select_language_id').val() !== ""){
               $('div #show_menus_content').show();
           } else {
               $('div #show_menus_content').hide();
           }
        }

        $('#statsMenusTable').DataTable({
            "responsive": true,
            "ordering": false,
            "language": {
                "url": "<?php echo e(trans('admin::datatables.lang')); ?>"
            }
        });

        $(document).ready(function () {
            initList();
            showMenusContent();
            update_inputs_blocks_hide();

            $('#select_brand_id').change(function () {
                var select = $(this).data('select_change');
                var search_id = $(this).val();
                var optionDefault =  "<?php echo e(trans('admin::menusCMS.select_option')); ?>";
                update_selects_country_language(select, search_id, optionDefault);
                showMenusContent();
            });

            $('#select_country_id').change(function () {
                var select = $(this).data('select_change');
                var search_id = $(this).val();
                var optionDefault =  "<?php echo e(trans('admin::menusCMS.select_option')); ?>";
                update_selects_country_language(select, search_id, optionDefault);
                showMenusContent();
            });

            initFilters(filters, $('#search-btn'));

            $('#btnShowStatsMenus').on('click',function () {
                $('#statsMenusModal').modal('show');
            });

        });
    </script>
<?php $__env->stopSection(); ?>
