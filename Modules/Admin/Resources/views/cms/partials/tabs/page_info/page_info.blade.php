<h4>{{ trans('admin::pages.page_details.header') }}</h4>

{!! CmsBlockInput::make('string', ['name' => 'page_info[code]', 'label' => trans('admin::pages.page_details.code'),
    'content' => $page->code, 'disabled' => !$can_publish ]) !!}

@if ($parentPages && !$page->id)
    {!! CmsBlockInput::make('select', ['name' => 'page_info[parent]', 'label' => trans('admin::pages.page_details.parent_page'),
        'content' => $page->parent, 'selectOptions' => $parentPages]) !!}
@else
    {!! Form::hidden('page_info[parent]', $page->parent, ['id' => 'page_info[parent]']) !!}
@endif

@if ($publishing_on && $page->id && $page->link == 0)
    <p class="col-sm-offset-2 col-sm-10">
        {{ trans('admin::pages.item') }} {{ $beacon_select ? 'beacons, ' : '' }}{{ trans('admin::pages.page_details.not_versioned') }}
    </p>
@endif

@if ($beacon_select)
    {!! CmsBlockInput::make('selectmultiple', array('name' => 'page_info_other[beacons]',
        'label' => trans('admin::pages.page_details.beacons'),
        'content' => $beacon_select->selected, 'selectOptions' => $beacon_select->options)) !!}
@endif

{!! CmsBlockInput::make('string', ['name' => 'page_info_lang[name]', 'label' => trans('admin::pages.page_details.name'),
    'content' => $page_lang->name, 'disabled' => !$can_publish && $page->id ]) !!}

<div class="form-group {!! FormMessage::getErrorClass('page_info_lang[url]') !!}">
    {!! Form::label('page_info_lang[url]', trans('admin::pages.page_details.url'), ['class' => 'control-label col-sm-2']) !!}
    <div class="col-sm-10">
        <div id="url-group" class="input-group">
            @if (!$page->id || $page->link == 0)
                @if (count($urlPrefixes) > 1)
                    <div class="input-group-addon url-dropdown">
                        <select name="page_info[canonical_parent]" title="Canonical Parent">
                            @if ($page->canonical_parent)
                                <option value="0">Unset canonical: {{ $urlArray[$page->canonical_parent] }}</option>
                            @endif
                            @foreach($urlPrefixes as $urlPrefix => $priority)
                                <option value="{{ $urlPrefix }}" {{ $loop->first ? 'selected="selected"' : '' }}>{{ $urlArray[$urlPrefix] }}</option>
                            @endforeach
                        </select>
                    </div>
                @else
                    <span class="input-group-addon" id="url-prefix">{{ $urlArray[key($urlPrefixes)] }}</span>
                @endif
            @endif
            <?php $options = []; if (!$can_publish && $page->id): $options = ['disabled' => true]; endif; ?>
            {!! Form::text('page_info_lang[url]', urldecode($page_lang->url), ['class' => 'form-control', 'id' => 'page_info_url'] + $options) !!}
            @if (!$page->id || $page->link == 1)
                <span class="input-group-addon link_show">{{ trans('admin::pages.page_details.or') }}</span>
                <span class="input-group-btn link_show">
                    <a href="{!! URL::to(config('admin.config.public').'/filemanager/dialog.php?type=2&field_id=page_info_url') !!}"
                       class="btn btn-default iframe-btn">{{ trans('admin::pages.page_details.select_doc') }}</a>
                </span>
            @endif
        </div>
        <span class="help-block">{!! FormMessage::getErrorMessage('page_info_lang[url]') !!}</span>
        @if (!$page->id)
            <div class="checkbox {!! FormMessage::getErrorClass('page_info[link]') !!}">
                <label>
                    {!! Form::checkbox('page_info[link]', 1, 0, ['id' => 'page_info[link]']) !!}
                    {{ trans('admin::pages.page_details.link_or_doc') }}
                </label>
            </div>
        @else
            {!! \Form::hidden('page_info[link]', $page->link, ['id' => 'page_info[link]']) !!}
        @endif
    </div>
</div>

<script type="text/javascript">
    var urlArray = {!! json_encode($urlArray) !!};
</script>
