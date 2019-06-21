<li id="list_{!! $item->id !!}" data-id="{!! $item->id !!}">
    <div>
        <span class='disclose glyphicon'></span>
        {!! $name !!} &nbsp; <span class="custom-name">{{ ($customName = $item->getCustomNameV2()) ? '('.trans('admin::menusCMS.custom_name').': ' . $customName . ')' : '' }}</span>
        <span class='pull-right'>
            @if ($permissions['subpage'] == true)
                <span class='sl_numb'>{!! $item->sub_levels !!}</span> {!! trans('admin::menusCMS.sublevels') !!}  &nbsp;
                <i class="sub-levels fa fa-sort-amount-desc itemTooltip" data-name="{!! $name!!}"
                   title="{!! trans('admin::menusCMS.edit_subpage_level') !!}"></i> &nbsp;
            @else
                <span class='sl_numb'>{!! $item->sub_levels !!}</span> {!! trans('admin::menusCMS.sublevels') !!}  &nbsp;
            @endif
            @if ($permissions['rename'] == true)
                <i class="rename glyphicon glyphicon-pencil itemTooltip" data-name="{!! $name !!}"
                   title="{!! trans('admin::menusCMS.rename_menu_item') !!}"></i>&nbsp;
            @endif
            @if ($permissions['delete'] == true)
                <i class="delete glyphicon glyphicon-trash itemTooltip" data-name="{!! $name !!}"
                   title="{!! trans('admin::menusCMS.delete_menu_item') !!}"></i>&nbsp;
            @endif
        </span>
    </div>
    {!! $leaf !!}
</li>