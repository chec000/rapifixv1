<div class="row textbox">
    <div class="col-sm-6">
        <h1>{{ trans('admin::cedis.general.list_cedis') }}</h1>
    </div>
    @if (Auth::action('cedis.add'))
        <div class="col-sm-6 text-right">
            <a href="{{ route('admin.cedis.add') }}" class="btn btn-warning addButton"><i class="fa fa-plus"></i> &nbsp;
                {{ trans('admin::cedis.general.add_cedis') }}</a>
        </div>
    @endif

</div>

<div class="table">
    @if (session()->exists('success'))
        <div class="alert alert-success alert-dismissible">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            {{ session()->get('success') }}
        </div>
    @endif

    <table class="table table-striped" id="tbl_cedis">
        <thead>
        <tr>
            <th>{{ trans('admin::shopping.products.index.thead-product-global_name') }}</th>
            <th>{{ trans('admin::cedis.general.country') }}</th>
            <th>{{ trans('admin::cedis.general.latitude') }}</th>
            <th>{{ trans('admin::cedis.general.longitude') }}</th>
            <th>{{ trans('admin::cedis.general.status') }}</th>
            @if (Auth::action('cedis.edit') || Auth::action('cedis.delete') || Auth::action('cedis.changeStatus'))
                <th>{{ trans('admin::cedis.general.actions') }}</th>
            @endif
        </tr>
        </thead>
        <tbody>
        @foreach ($allCedis as $cedis)
            <tr>
                <td>{{ $cedis->global_name }}</td>
                <td>{{ $cedis->country->name }}</td>
                <td>{{ $cedis->latitude }}</td>
                <td>{{ $cedis->longitude }}</td>
                <td><span id="cedis-tag-{{ $cedis->id }}"  class="label {{$cedis->status == 1 ? 'label-success' : 'label-default'}} ">{!! $cedis->status == 0 ?  trans('admin::language.lang_list_st_inactive')  : trans('admin::language.lang_list_st_active')  !!}</span></td>
                @if (Auth::action('cedis.edit') || Auth::action('cedis.delete') || Auth::action('cedis.changeStatus'))
                    <td>
                        @if (Auth::action('cedis.changeStatus'))
                        <a onclick="changestatus(this)" id="cedis-status-{{ $cedis->id }}" data-id="{{ $cedis->id }}" class="glyphicon {{ $cedis->status == 1 ? 'glyphicon-pause' : 'glyphicon-play' }} itemTooltip" href="#" title="{{ $cedis->status == 1 ? trans('admin::cedis.general.inactive') : trans('admin::cedis.general.active') }}"></a>
                        @endif
                        @if (Auth::action('cedis.edit'))
                            <a class="glyphicon glyphicon-pencil itemTooltip" href="{{ route('admin.cedis.edit', $cedis) }}" title="{{ trans('admin::cedis.general.edit') }}"></a>
                        @endif
                        @if (Auth::action('cedis.delete'))
                            <form id="delete-cedis-form-{{ $cedis->id }}" action="{{ route('admin.cedis.delete', $cedis) }}" method="POST" style="display: inline">
                                {{ csrf_field() }}
                                <a onclick="deleteElement(this)" data-id="{{ $cedis->id }}" data-element="{{ $cedis->global_name }}" class="glyphicon glyphicon-remove itemTooltip" href="javascript:{}" title="{{ trans('admin::cedis.general.delete') }}"></a>
                            </form>
                        @endif
                    </td>
                @endif
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

@section('scripts')
    <script type="text/javascript">
        $('#tbl_cedis').DataTable({
            "responsive": true,
            "ordering": false,
            "language": {
                "url": "{{ trans('admin::datatables.lang') }}"
            }
        });

        function deleteElement(element) {
            var id = $(element).data('id');
            var name = $(element).data('element');

            $('#confirm-modal .modal-body').text('{{trans('admin::shopping.products.index.confirm')}} ' + name + '?');

            $('#confirm-modal').modal({
                backdrop: 'static',
                keyboard: false
            }).one('click', '#delete', function(e) {
                document.getElementById('delete-cedis-form-'+id).submit();
            });
        }

        function changestatus(element) {
            var id       = $(element).data('id');
            var type     = $(element).hasClass('glyphicon-pause') ? 'deactivate' : 'activate';
            var activate = $(element).hasClass('glyphicon-pause') ? true : false;

            $.ajax({
                url: '{{ route('admin.cedis.changeStatus') }}',
                method: 'POST',
                dataType: 'JSON',
                data: {id: id, type:  type},
                statusCode: { 419: function() {window.location.href = '{{ route('admin.home') }}'} }
            }).done(function (response, textStatus, jqXHR) {
                if (response.status) {
                    if (activate) {
                        $('#cedis-status-'+id).removeClass('glyphicon-pause').addClass('glyphicon-play');
                        $('#cedis-tag-'+id).removeClass('label-success').addClass('label-default');
                        $('#cedis-tag-'+id).text('{{ trans('admin::language.lang_list_st_inactive') }}');
                        $('#cedis-status-'+id).attr('title', '{{ trans('admin::cedis.general.active') }}').tooltip('fixTitle').tooltip('show');
                    } else {
                        $('#cedis-status-'+id).removeClass('glyphicon-play').addClass('glyphicon-pause');
                        $('#cedis-tag-'+id).removeClass('label-default').addClass('label-success');
                        $('#cedis-tag-'+id).text('{{ trans('admin::language.lang_list_st_active') }}');
                        $('#cedis-status-'+id).attr('title', '{{ trans('admin::cedis.general.inactive') }}').tooltip('fixTitle').tooltip('show');
                    }
                }
            }).fail(function (response, textStatus, errorThrown) {
                console.log(response, textStatus, errorThrown);
            });
        }
    </script>
@stop