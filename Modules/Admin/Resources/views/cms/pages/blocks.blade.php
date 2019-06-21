<?php AssetBuilder::setStatus('cms-editor', true); ?>

<div class="row">
    <div class="col-sm-8">
        <h1>{!! trans('admin::siteWideContent.title_swc') !!}</h1>
    </div>
    <div class="col-sm-4" align="right">
        <button id="btnShowStatsBlocks" type="button" class="btn btn-primary">
            <i class="fa fa-search"></i> &nbsp {!! trans('admin::siteWideContent.records_history') !!}
        </button>
    </div>
</div>

{!! Form::open(['url' => route('admin.blocks.index.filters')]) !!}
    <div class="container-fluid">
        <fieldset class="fieldset_gray">
            <legend class="legend_gray">{!! trans('admin::siteWideContent.legend_search') !!}</legend>
            <div class="row">
                <div class="col-sm-4 {!! FormMessage::getErrorClass('brand_id') !!}">
                    <div class="col-sm-3">
                        {!! Form::label('brand_id', trans('admin::siteWideContent.brand').':', ['class' => 'control-label']) !!}
                    </div>
                    <div class="col-sm-9">
                        {!! Form::select('brand_id', $brands, null, ['placeholder' => trans('admin::siteWideContent.select_option'),
                            'class' => 'form-control', 'id' => 'select_brand_id', 'data-select_change' => 'country']) !!}
                        <span class="help-block control-label">{!! FormMessage::getErrorMessage('brand_id') !!}</span>
                    </div>
                </div>
                <div class="col-sm-4 {!! FormMessage::getErrorClass('country_id') !!}">
                    <div class="col-sm-3">
                        {!! Form::label('country_id',trans('admin::siteWideContent.country').':', ['class' => 'control-label']) !!}
                    </div>
                    <div class="col-sm-9">
                        {!! Form::select('country_id', $countries, null, ['placeholder' => trans('admin::siteWideContent.select_option'),
                            'class' => 'form-control', 'id' => 'select_country_id' ,'data-select_change' => 'language']) !!}
                        <span class="help-block control-label">{!! FormMessage::getErrorMessage('country_id') !!}</span>
                    </div>
                </div>
                <div class="col-sm-4 {!! FormMessage::getErrorClass('role_copy') !!}">
                    <div class="col-sm-3">
                        {!! Form::label('language_id', trans('admin::siteWideContent.language').':', ['class' => 'control-label']) !!}
                    </div>
                    <div class="col-sm-9">
                        {!! Form::select('language_id', $languages, null, ['placeholder' => trans('admin::siteWideContent.select_option'),
                            'class' => 'form-control', 'id' => 'select_language_id']) !!}
                        <span class="help-block control-label">{!! FormMessage::getErrorMessage('language_id') !!}</span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12" align="right">
                    <button id="search-btn" type="submit" class="btn btn-primary addButton">
                        <i class="fa fa-search"></i> &nbsp; {!! trans('admin::siteWideContent.buttons.search') !!}
                    </button>
                </div>
            </div>
        </fieldset>
    </div>
{!! Form::close() !!}

<hr class="hr_bold_violet">

{!! Form::open(['url' => route('admin.blocks.index.post'), 'id' => 'blocksForm', 'class' => 'form-horizontal', 'enctype' => 'multipart/form-data']) !!}
<div class="tabbable full-width-tabs" id="contentTabs">

    <ul id="idNavBlocks" class="nav nav-tabs">
        {!! $tab['headers'] !!}
    </ul>

    <div class="tab-content">
        {!! $tab['contents'] !!}

        <input type="hidden" id="id_brand_id" name="brand_id" value="1">
        <input type="hidden" id="id_country_id" name="country_id" value="1">
        <input type="hidden" id="id_language_id" name="language_id" value="1">
    </div>
</div>
{!! Form::close() !!}

<div id="statsBlockModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h3>{!! trans('admin::siteWideContent.records_history_swc') !!}</h3>
            </div>
            <div class="modal-body form-horizontal">
                <div class="table">
                    <table class="table table-striped" id="statsBlocksTable">
                        <thead>
                        <tr>
                            <th>{!! trans('admin::siteWideContent.brand') !!}</th>
                            <th>{!! trans('admin::siteWideContent.country') !!}</th>
                            <th>{!! trans('admin::siteWideContent.language') !!}</th>
                            <th>{!! trans('admin::siteWideContent.category') !!}</th>
                            <th>{!! trans('admin::siteWideContent.block') !!}</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($statsBlocks as $statCategory)
                                @foreach($statCategory as $statBlock)
                            <tr>
                                <td>{!! $statBlock['brand'] !!}</td>
                                <td>{!! $statBlock['country'] !!}</td>
                                <td>{!! $statBlock['language'] !!}</td>
                                <td>{!! $statBlock['category'] !!}</td>
                                <td><i class="fa fa-check-circle success"></i> &nbsp;{!! $statBlock['block_name'] !!}</td>
                            </tr>
                                @endforeach
                           @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
            <div class="modal-footer">
                <button class="btn cancel" data-dismiss="modal"><i class="fa fa-times"></i> &nbsp; {!! trans('admin::siteWideContent.buttons.close') !!}</button>
            </div>
        </div>
    </div>
</div>


@section('scripts')
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
                "url": "{{ trans('admin::datatables.lang') }}"
            }
        });

        $(document).ready(function () {
            selected_tab('#blocksForm', 0);
            load_editor_js();
            update_inputs_blocks_hide();

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
@stop
