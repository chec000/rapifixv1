@php
    AssetBuilder::setStatus('jquery-sortable', true);
@endphp

<div class="row">
    <div class="col-sm-6">
        <h1>{!! trans('admin::pages.pages') !!}</h1>
    </div>
    <div class="col-md-6">
        <button style="float: right;" type="button" onclick="listPages()" class="btn btn-primary addButton"><i class="fa fa-search"></i> &nbsp; {!! trans('admin::pages.history') !!}</button>
    </div>
</div>
{!! Form::open(['url' => route('admin.pages.get.pages'),'method' => 'post']) !!}
<div class="container-fluid">
    <fieldset class="fieldset_gray">
        <legend class="legend_gray">{!! trans('admin::siteWideContent.legend_search') !!}</legend>
        <div class="row">
            <div class="col-sm-4 {!! FormMessage::getErrorClass('brand_id') !!}">
                <div class="col-sm-3">
                    {!! Form::label('brand_id', trans('admin::siteWideContent.brand').':', ['class' => 'control-label']) !!}
                </div>
                <div class="col-sm-9">
                    {!! Form::select('brand_id', $brands,$brand_filter, ['placeholder' => trans('admin::siteWideContent.select_option'), 'class' => 'form-control',
                        'id' => 'select_brand_id', 'data-select_change' => 'country']) !!}
                    <span class="help-block control-label">{!! FormMessage::getErrorMessage('brand_id') !!}</span>
                </div>
            </div>
            <div class="col-sm-4 {!! FormMessage::getErrorClass('country_id') !!}">
                <div class="col-sm-3">
                    {!! Form::label('country_id',trans('admin::siteWideContent.country').':', ['class' => 'control-label']) !!}
                </div>
                <div class="col-sm-9">
                    {!! Form::select('country_id', $countries, null, ['placeholder' => trans('admin::siteWideContent.select_option'), 'class' => 'form-control',
                        'id' => 'select_country_id' ,'data-select_change' => 'language']) !!}
                    <span class="help-block control-label">{!! FormMessage::getErrorMessage('country_id') !!}</span>
                </div>
            </div>
            <div class="col-sm-4 {!! FormMessage::getErrorClass('role_copy') !!}">
                <div class="col-sm-3">
                    {!! Form::label('language_id', trans('admin::siteWideContent.language').':', ['class' => 'control-label']) !!}
                </div>
                <div class="col-sm-9">
                    {!! Form::select('language_id', $languages, null, ['placeholder' => trans('admin::siteWideContent.select_option'), 'class' => 'form-control', 'id' => 'select_language_id']) !!}
                    <span class="help-block control-label">{!! FormMessage::getErrorMessage('language_id') !!}</span>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12" align="right">
                <button id="search-btn" type="button" onclick="getPages()" class="btn btn-primary addButton"><i class="fa fa-search"></i> &nbsp; {!! trans('admin::siteWideContent.buttons.search') !!}</button>
            </div>
        </div>
    </fieldset>
</div>

<br/>
<hr class="hr_bold_violet">
{!! Form::close() !!}

<div class="row" style="display:none; margin: 4px;" id="add_page" >
    <div class="col-sm-6">
    </div>
    <div class="col-sm-6 text-right">
        @if ($add_page)
            {!! Form::open(array('url' => route('admin.pages.add') ,'id' => 'form-addPage', 'method' => 'get')) !!}
            <input id="brand_id" type="hidden" value="" name="brand_id">
            <input id="country_id" type="hidden" value="" name="country_id">
            <input id="language_id" type="hidden" value="" name="language_id">
            <button type="submit" class="btn btn-warning addButton" data-page="0"><i
                        class="fa fa-plus"></i> &nbsp; {!! trans('admin::pages.add_page') !!}</button>
            {!! Form::close() !!}
        @endif
    </div>
</div>

<div class="panel" id="panel" style="display: none">
<div class="row textbox">
    <div class="col-sm-8 pages_key">
        <span class="label type_normal_dark">{!! trans('admin::pages.normal_page') !!}</span>
        <span class="label type_link">{!! trans('admin::pages.link_document') !!}</span>
        @if ($groups_exist)
        <span class="label type_group">{!! trans('admin::pages.group_page') !!}</span>
        @endif
        <span class="label type_hidden">{!! trans('admin::pages.not_live') !!}</span>
    </div>
  <div class="col-sm-12 col-md-4">
      {!! Form::open(array('url' => 'support/pages/search','id' => 'form-search')) !!}
        {!! Form::hidden('search_entity', Modules\CMS\Entities\Page::class) !!}
        {!! Form::text('name', '', array('id'=>'name', 'placeholder' =>  trans('admin::pages.search_pages'), 'class' => 'form-control search-box')) !!}
      {!! Form::close() !!}
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
                <h3>{!! trans('admin::pages.remove') !!}   <span class="itemTypeC"></span>: <span class="itemName"></span></h3>
            </div>
            <div class="modal-body">
                <p>{!! trans('admin::pages.delete_confirm') !!} <span class="itemType"></span> '<span class="itemName"></span>' {!! trans('admin::pages.for_all_languages') !!}?
                </p>
            </div>
            <div class="modal-footer">
                <button class="btn no" data-dismiss="modal"><i class="fa fa-times"></i> &nbsp; {!! trans('admin::pages.no') !!} </button>
                <button class="btn btn-primary yes" data-dismiss="modal"><i class="fa fa-check"></i> &nbsp; {!! trans('admin::pages.yes') !!} </button>
            </div>
        </div>
    </div>
</div>
 {!! Form::open(array('url' => 'support/pages/delete','id' => 'form-delete')) !!}
 {!! Form::close() !!}
@section('scripts')
    <script type='text/javascript'>
        var expanded = {!! json_encode($page_states) !!};
        var rootPages = {!! json_encode($rootPageIds) !!};
        var filters = [
            $('#select_brand_id'),
            $('#select_country_id'),
            $('#select_language_id')
        ];

        $(document).ready(function () {
            @if ($max)
                $('.addPage').click(function () {
                    event.preventDefault();
                    cms_alert('danger', 'Max Pages Reached');
                });
            @endif

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

            var filter={!!$brand_filter!!};
            if(filter!==-1){
                select_country_combo("{{ trans('admin::siteWideContent.select_option') }}", {!!$brand_filter!!},
                    {!!$country_filter!!} ,{!!$language_filter!!});
            }


        });

        $('#select_brand_id').change(function () {
            var select = $(this).data('select_change');
            var search_id = $(this).val();
            var optionDefault =  "{{ trans('admin::siteWideContent.select_option') }}";
            update_selects_country_language(select, search_id, optionDefault);
        });

        $('#select_country_id').change(function () {
            var select = $(this).data('select_change');
            var search_id = $(this).val();
            var optionDefault =  "{{ trans('admin::siteWideContent.select_option') }}";
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
                "url": "{{ trans('admin::datatables.lang') }}"
            }
        });

        var page_name_delete;
        var deletedItems = {};
        function watch_for_delete_page(page_id,page_name,page_lang) {
            page_name_delete=page_name;
            var delete_modal_el = $('#deleteModalCustom');
            selector=$("#list_"+page_id);
            delete_modal_el.find('.itemName').html(page_name);
            delete_modal_el.find('.itemType').html( '{!! trans('admin::pages.page') !!}');
            delete_modal_el.find('.itemTypeC').html('{!! trans('admin::pages.page') !!}');
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
                        cms_alert_pages('warning', '{!! trans('admin::pages.the') !!} ' + '{!! trans('admin::pages.page') !!}' +
                            ' \'' + page_name + '\' {!! trans('admin::pages.has_delete') !!}.<a href="#" onclick="undo_log_pages('+logIds+' )"> {!! trans('admin::pages.undo') !!}</a>'); getPages();
                    },
                    error: function() {
                        cms_alert_pages('danger', '{!! trans('admin::pages.the') !!} ' + page_name + ' {!! trans('admin::pages.no_delete') !!})');
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
                deletedItem = {item: '{!! trans('admin::pages.page') !!}', name:page_name_delete};
            }
            $.ajax({
                url: route('admin.backups.undo'),
                data: {'log_ids': logIds},
                type: 'POST',
                success: function () {
                    $('#' + deletedItem.id).show();
                    cms_alert('info', '{!! trans('admin::pages.the') !!} ' + deletedItem.item +
                        ' \'' + deletedItem.name + '\' {!! trans('admin::pages.page_restored') !!}');
                    getPages();
                },
                error: function () {
                    cms_alert('danger', '{!! trans('admin::pages.the') !!} ' + deletedItem.item +
                    '{!!trans('admin.pages.page_no_restored')!!}');
                }
            });
        }
    </script>
@stop
