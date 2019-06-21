<li id="list_p{{ $page->id }}" data-id="{{ $item->id }}" data-page-id="{{ $page->id }}" class="{{ $item->isHiddenPage($page->id) ? 'hidden-page ' : '' }}{!! $leaf ? 'mjs-nestedSortable-branch mjs-nestedSortable-collapsed' : '' !!}">
    <div>
        <span class='disclose glyphicon'></span>
        {!! $name !!} &nbsp; <span class="custom-name">{{ ($customName = $item->getCustomName($page->id)) ? '(Custom Name: ' . $customName . ')' : '' }}</span>
        <span class='pull-right'>
            @if ($permissions['rename'])
                <i class="rename glyphicon glyphicon-pencil itemTooltip" data-name="{!! $name !!}" title="{!! trans('admin::menusCMS.rename_menu_item') !!}"></i>&nbsp;
                <i class="hide-page fa {{ $item->isHiddenPage($page->id) ? 'fa-eye' : 'fa-eye-slash' }} itemTooltip" data-name="{!! $name !!}" title="{!! trans('admin::menusCMS.hide_show_menu') !!}"></i>&nbsp;
            @endif
        </span>
    </div>
    {!! $leaf !!}
</li>