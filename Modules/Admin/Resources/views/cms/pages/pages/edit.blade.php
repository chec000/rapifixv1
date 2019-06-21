<?php AssetBuilder::setStatus('cms-editor', true); ?>

<h1>{!! $item_name !!}: {!! $page_lang->name !!}</h1>

<div class="row textbox">
    <div class="col-sm-4">
        @foreach($page->groups as $group)
            <p><a href="{!! route('admin.groups.pages', ['groupId' => $group->id,'brand_id'=>$brand->id,'country_id'=>$country->id,'language_id'=>$language->id]) !!}">Back to {!! $group->name !!}</a></p>
        @endforeach
        @if ($publishingOn && $page->link == 0)
            <p id="version-well" class="well">
                Published Version: #<span class="live_version_id">{{ $version['live'] }}</span>
                @if ($page->is_live())
                    <?php $published = '<b>&nbsp;<span class="text-success version-p"> - latest version live</span></b>'; ?>
                    <?php $unPublished = '<b>&nbsp;<span class="text-danger version-up"> - latest version not published</span></b>'; ?>
                @else
                    <?php $published = '<b>&nbsp;<span class="text-warning version-p"> - latest version published (page not live)</span></b>'; ?>
                    <?php $unPublished = ' <b>&nbsp;<span class="text-danger version-up"> - latest version not published & page not live</span></b>'; ?>
                @endif
                @if ($version['live'] != $version['latest'])
                    {!! str_replace('version-p', 'version-p hidden', $published).$unPublished !!}
                @else
                    {!! $published.str_replace('version-up', 'version-up hidden', $unPublished) !!}
                @endif
                <br />
                Editing From Version: #{{ $version['editing'] }} &nbsp;&nbsp; (Latest Version: #{{ $version['latest'] }})
            </p>
        @endif
    </div>
    <div class="col-sm-8 text-right">
        @if ($auth['can_duplicate'])
            <button class="btn btn-danger" id="duplicate-btn">
                <i class="fa fa-files-o"></i> &nbsp; {{trans('admin::pages.duplicate_page')}}
            </button> &nbsp;
        @endif
        @if ($auth['can_preview'])
            <form action="{{ route('admin.pages.preview') }}" method="POST" style="display: inline-block" target="_blank">
                {{ csrf_field() }}
                <input name="brand_id" type="hidden" value="{{ $brand->id }}">
                <input name="country_id" type="hidden" value="{{ $country->id }}">
                <input name="language_id" type="hidden" value="{{ $language->id }}">
                <input name="extra" type="hidden" value="/">
                <input name="url_page" type="hidden" value="{{ ($page_lang->url != '/') ? $page_lang->url : '' }}">
                @if(!$page->is_live())
                    <input name="preview_key" type="hidden" value="{{ $frontendLink }}">
                @endif
                <button class="btn btn-warning btn_preview_page" type="submit">
                    <i class="fa fa-eye"></i> &nbsp;
                    @if(!$page->is_live())
                        {{trans('admin::pages.preview')}}
                    @else
                        {{ ($page->link == 1) ? trans('admin::pages.document_page') : trans('admin::pages.live_page') }}
                    @endif
                </button>
            </form>
        @endif
        <form action="{{ route('admin.pages.index') }}" method="get" style="display: inline-block">
            <input name="brand_id" type="hidden" value="{{$brand->id}}">
            <input name="country_id" type="hidden" value="{{$country->id}}">
            <input name="language_id" type="hidden" value="{{$language->id}}">
            <button class="btn btn-warning"  type="submit">
                {{trans('admin::brand.form_add.back_list')}}
                <i class="fa fa-reply"></i>
            </button>
        </form>
    </div>
</div>

<hr class="hr_bold_violet">

{!! Form::open(['class' => 'form-horizontal', 'id' => 'editForm', 'enctype' => 'multipart/form-data']) !!}
    <div class="tabbable full-width-tabs" id="contentTabs">
        <h4>{!! trans('admin::pages.global_details') !!}</h4>
        <div class="form-group">
            <div class="row" >
                <label for="brand_id" class="control-label col-md-2">{!! trans('admin::pages.brand') !!}: </label>
                <div class="col-sm-10">
                    <span class="form-control">{{$brand->name}}</span>
                    <input name="brand_id" type="hidden" value="{{$brand->id}}">
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <label for="country_id" class="control-label col-md-2">{!! trans('admin::pages.country') !!}:</label>
                <div class="col-sm-10">
                    <span class="form-control">{{$country->name}}</span>
                    <input name="country_id" type="hidden" value="{{$country->id}}">
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <label for="language_id" class="control-label col-md-2">{!! trans('admin::pages.language') !!}:</label>
                <div class="col-sm-10">
                    <span class="form-control">{{$language->language}}</span>
                    <input name="language_id" type="hidden" value="{{$language->id}}">
                    <input name="language_id" id="language_id_repeater" type="hidden" value="{{$language->id}}">
                </div>
            </div>
        </div>
        <ul class="nav nav-tabs">
            {!! $tab['headers'] !!}
        </ul>
        <div class="tab-content">
            {!! $tab['contents'] !!}
        </div>
    </div>

    <input type="hidden" name="versionFrom" value="{{ $version['editing'] }}">
    <input type="hidden" name="duplicate" value="0" id="duplicate_set">
    <input type="hidden" name="duplicate_brand" value="0" id="duplicate_brand">
    <input type="hidden" name="duplicate_country" value="0" id="duplicate_country">
    <input type="hidden" name="duplicate_language" value="0" id="duplicate_language">
    <input type="hidden" name="duplicate_url" value="{{ $page_lang->url ?: '/' }}">
{!! Form::close() !!}

<div id="duplicate-modal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">{{ trans('admin::pages.duplicate_modal_header') }}</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-4 {!! FormMessage::getErrorClass('brand_id') !!}">
                        <div class="form-group">
                            <label for="brand_id">{!! Form::label('brand_id', trans('admin::pages.brand').':', ['class' => 'control-label']) !!}</label>
                            {!! Form::select('brand_id', $brands, null, ['placeholder' => trans('admin::pages.select_option'),
                                'class' => 'form-control', 'id' => 'select_brand_id', 'data-select_change' => 'country']) !!}
                                <span class="help-block control-label">{!! FormMessage::getErrorMessage('brand_id') !!}</span>
                        </div>
                    </div>
                    <div class="col-sm-4 {!! FormMessage::getErrorClass('country_id') !!}">
                        <div class="form-group">
                            <label for="country_id">{!! Form::label('country_id', trans('admin::pages.country').':', ['class' => 'control-label']) !!}</label>
                            {!! Form::select('country_id', $countries, null, ['placeholder' => trans('admin::pages.select_option'),
                                'class' => 'form-control', 'id' => 'select_country_id', 'data-select_change' => 'language']) !!}
                                <span class="help-block control-label">{!! FormMessage::getErrorMessage('country_id') !!}</span>
                        </div>
                    </div>
                    <div class="col-sm-4 {!! FormMessage::getErrorClass('role_copy') !!}">
                        <div class="form-group">
                            <label for="language_id">{!! Form::label('language_id', trans('admin::pages.language').':', ['class' => 'control-label']) !!}</label>
                            {!! Form::select('language_id', $languages, null, ['placeholder' => trans('admin::pages.select_option'),
                                'class' => 'form-control', 'id' => 'select_language_id']) !!}
                                <span class="help-block control-label">{!! FormMessage::getErrorMessage('language_id') !!}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">
                    {{ trans('admin::pages.duplicate_modal_close') }}
                </button>
                <button id="confirm-duplicate" type="button" class="btn btn-primary">
                    {{ trans('admin::pages.duplicate_modal_confirm') }}
                </button>
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
            selected_tab('#editForm', parseInt({{ $page->link ? 0 : 1 }}));
            updateListenPageUrl(true);
            updateListenLiveOptions();
            updateListenGroupFields();
            load_editor_js();
            headerNote();
            $('#duplicate-btn').click(function () {
                duplicatePage();
            });

            page_id = parseInt({{ $page->id }});
            latest_version = '{{ $version['latest'] }}';
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
                var optionDefault = "{{ trans('admin::menusCMS.select_option') }}";
                update_selects_country_language(select, search_id, optionDefault);
            });

            $('#select_country_id').change(function () {
                var select = $(this).data('select_change');
                var search_id = $(this).val();
                $('#duplicate_country').val(search_id);
                var optionDefault = "{{ trans('admin::menusCMS.select_option') }}";
                update_selects_country_language(select, search_id, optionDefault);
            });

            $('#select_language_id').change(function () {
                var id = $(this).val();
                $('#duplicate_language').val(id);
            });

            initFilters(filters, $('#confirm-duplicate'));
        });
    </script>
@append
