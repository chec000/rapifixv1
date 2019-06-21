<li id='list_{!! $page->id !!}'>
    <div class='{!! $li_info->type !!}'>
        <span class='disclose glyphicon'></span>
        {!! $li_info->altName ?: $page_lang->name !!} {{ $li_info->group ? ' &nbsp; (Group: ' . $li_info->group->name . ')' : '' }}
        <span class="pull-right">
            @if (!empty($li_info->blog) && $permissions['blog'])
                {!! HTML::link($li_info->blog, '', ['class' => 'glyphicon glyphicon-share itemTooltip', 'title' => 'WordPress Admin', 'target' => '_blank']) !!}
            @endif
            @if ($li_info->number_of_forms > 0 && $permissions['forms'])
                <a href="{{ route('admin.forms.list', ['pageId' => $page->id]) }}" class="glyphicon glyphicon-inbox itemTooltip" title="View Form Submissions"></a>
            @endif
            @if ($li_info->number_of_galleries > 0 && $permissions['galleries'])
                <a href="{{ route('admin.gallery.list', ['pageId' => $page->id]) }}" class="glyphicon glyphicon-picture itemTooltip" title="Edit Gallery"></a>
            @endif
            @if ($page->group_container && $permissions['group'])
                <a href="{{ route('admin.groups.pages', ['groupId' => $page->group_container,'brand_id'=>$page->brand_id,'country_id'=>$page->country_id,'language_id'=>\Request::get('language_id')]) }}" class="glyphicon glyphicon-list-alt itemTooltip" title="Manage Items"></a>
                
                
            @endif
            @if (Auth::action('pages.preview'))
                @php
                    if (!$page->is_live()) {
                        $viewTitle = trans('admin::pages.preview');
                    } else {
                        $viewTitle = ($page->link == 1) ? trans('admin::pages.document_page') : trans('admin::pages.live_page');
                    }
                @endphp
                <form id="preview-page-{{ $page->id }}" action="{{ route('admin.pages.preview') }}" method="POST" style="display: inline-block" target="_blank">
                    {{ csrf_field() }}
                    <input name="brand_id" type="hidden" value="{{ $page->brand_id }}">
                    <input name="country_id" type="hidden" value="{{ $page->country_id }}">
                    <input name="language_id" type="hidden" value="{{ \Request::get('language_id') }}">
                    <input name="url_page" type="hidden" value="{{ ($li_info->preview_link != '/') ? $li_info->preview_link : '' }}">
                    <a href="#" class="glyphicon glyphicon-eye-open itemTooltip"
                        onclick="$('#preview-page-{{ $page->id }}').submit(); return false;" title="{{ $viewTitle }}"></a>
                </form>
            @endif
            @if ($permissions['add'] == true && empty($page->link))
                <a href="{{ route('admin.pages.add', [
                        'pageId' => $page->group_container?0:$page->id,
                        'groupId' => $page->group_container?:null
                    ]).'?brand_id='.\Request::get('brand_id').'&country_id='.\Request::get('country_id').'&language_id='.\Request::get('language_id') }}"
                    class="glyphicon glyphicon-plus itemTooltip addPage"
                    title="{{ $page->group_container ? trans('admin::pages.group_page') : trans('admin::pages.sub_page') }}"></a>
            @endif
            @if ($permissions['edit'] == true)
                <a href="{{ route('admin.pages.edit', ['pageId' => $page->id, 'version' => 0,
                    'language' => \Request::get('language_id')]) }}" class="glyphicon glyphicon-pencil itemTooltip"
                    title="{{ trans('admin::pages.edit') }}"></a>
            @endif
            @if ($permissions['delete'] == true)
            <span onclick="watch_for_delete_page({{$page->id}},'{{$page_lang->name}}',{{$page_lang->language_id}})" ><i class="delete glyphicon glyphicon-trash itemTooltip"></i></span>
<!--                <a href="javascript:void(0)" class="delete glyphicon glyphicon-trash itemTooltip"
                   data-name="{!! $page_lang->name !!}" title="Delete Page">
                </a>-->
            @endif
        </span>
    </div>
    {!! $li_info->leaf !!}
</li>
