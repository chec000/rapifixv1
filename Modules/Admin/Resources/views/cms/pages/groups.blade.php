<div class="row">
    <div class="col-sm-6">
        <h1>{!! $group->name !!}</h1>
    </div>
    <div class="col-sm-6 text-right">
        @if ($can_edit)
            <a href="{{ route('admin.groups.edit', ['groupId' => $group->id,'brand_id'=>$brand_id,'country_id'=>$country_id,'language_id'=>$language_id]) }}" class="btn btn-warning addButton">
                <i class="fa fa-pencil"></i> &nbsp; Edit Group Settings</a> &nbsp;
                 
        @endif
        @if ($can_add)
   
  {!! Form::open(array('url' => route('admin.pages.add') ,'id' => 'form-addPage', 'method' => 'get')) !!}
            <input id="brand_id" type="hidden" value="{{$brand_id}}" name="brand_id">
            <input id="country_id" type="hidden" value="{{$country_id}}" name="country_id">
            <input id="language_id" type="hidden" value="{{$language_id}}" name="language_id">
            <input type="hidden" name="groupId" value="{{$group->id}}">
            <button type="submit" class="btn btn-warning addButton" data-page="0"><i
                        class="fa fa-plus"></i> &nbsp; Add {!! $group->item_name !!}</button>
            {!! Form::close() !!}
            
        @endif
    </div>
</div>

{!! $pages !!}

@section('scripts')
    <script type='text/javascript'>

        $(document).ready(function () {

            watch_for_delete('.delete', 'page', function (el) {
                return el.closest('tr').attr('id');
            }, route('admin.pages.delete', {pageId : ''}));

        });
    </script>
@stop