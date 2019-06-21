<tr id='list_{!! $page_lang->page_id !!}' data-name='{!! $page_lang->name !!}'>
    <td>
        {!! $page_lang->name !!}
    </td>
    @foreach ($showBlocks as $showBlock)
        <td>
            {{ $showBlock }}
        </td>
    @endforeach
    <td>
        @if ($can_edit)
            <a href="{{ route('admin.pages.edit', ['pageId' => $page_lang->page_id,'version' => 0,
                    'language' => \Request::get('language_id')]) }}" class="glyphicon glyphicon-pencil itemTooltip" title=" {{ trans('admin::pages.edit') }}.{{$item_name }}"></a>
             
            
            @endif
        @if ($can_delete)
            <i class="delete glyphicon glyphicon-trash itemTooltip" data-name="{!! $page_lang->name !!}"
               title="Delete {{ $item_name }}"></i>
        @endif
    </td>
</tr>