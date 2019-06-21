<div class="row textbox">
    <div class="col-sm-6">
        <h1>{{ trans('admin::shopping.blacklist.index.list_estatus') }}</h1>
    </div>
    @if ($can_add)
    <div class="col-sm-6 text-right">     
        <a href="{{ route('admin.blacklist.add') }}" class="btn btn-warning addButton"><i class="fa fa-plus"></i> &nbsp;
            {{ trans('admin::shopping.blacklist.index.add_new_blacklist') }}</a>
    </div>
    @endif

</div>
@if(Session::has('info'))

    <p class="alert {{ Session::get('info')['alertclass'] }}" role="alert">
        {{ Session::get('info')['message'] }}
    </p>

@endif
<div class="table">


    <table class="table table-striped" id="tbl_blacklist">
        <thead>
            <tr>
                <th>{{ trans('admin::shopping.blacklist.index.country') }}</th>
                <th>{{ trans('admin::shopping.blacklist.index.eo_number') }}</th>
               
                <th>{{ trans('admin::shopping.blacklist.index.status') }}</th>
                @if ($can_edit || $can_delete)
                <th>{{ trans('admin::shopping.blacklist.index.actions') }}</th>
                @endif
            </tr>
        </thead>
        <tbody>
        @foreach ($blacklist as $bl)

            <tr id="lang_{!! $bl->id !!}">
                <td>{!! $bl->country->name !!}</td>
                <td>{{$bl->eo_number}}</td>
                <td><span id="status{{$bl->id}}"  class="label  {{$bl->active ? 'label-success' : 'label-default'}} ">{!! $bl->active == 0 ?  trans('admin::language.lang_list_st_inactive')  : trans('admin::language.lang_list_st_active')  !!}</span></td>
                @if ($can_edit || $can_delete)
                    <td data-lid="{!! $bl->id !!}">
                    <span onclick="disableBlacklist({{$bl->id}})" id='activeBlacklist{{$bl->id}}' class="{{$bl->active ? 'hide' : ''}}">
                        <i class="glyphicon glyphicon-stop itemTooltip  " title="{{ trans('admin::shopping.blacklist.index.enable') }}"></i>
                    </span>
                    <span onclick="disableBlacklist({{$bl->id}})" id='inactiveBlacklist{{$bl->id}}' class="{{$bl->active ? '' : 'hide'}}">
                        <i class="glyphicon glyphicon-play itemTooltip " title="{{ trans('admin::shopping.blacklist.index.disable') }}"></i>
                     </span>
                     <a class="glyphicon glyphicon-pencil itemTooltip" href="{{ route('admin.blacklist.edit', ['oe_id' => $bl->id]) }}" title="{{ trans('admin::language.lang_list_edit') }}"></a>

                        <span onclick="deleteBlacklist({{$bl->id}})" id='deleteBlacklist{{$bl->id}}'>
                        <i class="glyphicon glyphicon-trash itemTooltip " title="{{ trans('admin::shopping.blacklist.index.delete') }}"></i>
                     </span>
                    </td>
                @endif

            </tr>
        @endforeach

        </tbody>
    </table>
</div>
@section('scripts')
<script type="text/javascript">

    $('#tbl_blacklist').DataTable({
    "responsive": true,
            "ordering": false,
             "language": { 
                    "url": "{{ trans('admin::datatables.lang') }}"
               }  
    });
    function disableBlacklist(blacklist_id) {
        $.ajax({
            url: route('admin.blacklist.active'),
            type: 'POST',
            data: {blacklist_id: blacklist_id},
            success: function (data) {
                var label = $("#status" + blacklist_id);
                var iconActive = $("#activeBlacklist" + blacklist_id);
                var iconInactive = $("#inactiveBlacklist" + blacklist_id);
                if (data.status === 0) {
                    iconActive.removeClass('hide');
                    iconInactive.addClass('hide');
                    label.removeClass('label-success').addClass('label-default');
                    label.text(data.message);
                }
                else {
                    iconActive.addClass('hide');
                    iconInactive.removeClass('hide');
                    label.removeClass('label-default').addClass('label-success');
                    label.text(data.message);
                }
            }
        });
    }

    function deleteBlacklist(blacklist_id) {
        $.ajax({
            url: route('admin.blacklist.delete'),
            type: 'POST',
            data: {blacklist_id: blacklist_id},
            success: function (data) {

                if (data.status) {
                    location.reload();
                }
                else {

                }
            }
        });
    }

</script>
@stop