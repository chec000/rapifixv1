<div class="row textbox">
    <div class="col-sm-6">
        <h1>{{ trans('admin::brand.form_add.list_brands') }}</h1>
    </div>
    @if ($can_add)
    <div class="col-sm-6 text-right">     
        <a href="{{ route('admin.brand.add') }}" class="btn btn-warning addButton"><i class="fa fa-plus"></i> &nbsp;
            {{ trans('admin::brand.form_add.add_new_brand') }}</a>
    </div>
    @endif

</div>

<div class="table-responsive">
    @if (isset($success))
    <div class="alert alert-success alert-dismissible">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        {{ $action == 'edit' ? trans('admin::language.lang_edit_success', array('lang' => $lang)) : trans('admin::language.lang_add_success', array('lang' => $lang)) }}
    </div>
    @endif
    <table class="table table-striped" id="tbl_brands">
        <thead>
            <tr>
                <th>{{ trans('admin::brand.form_add.name_brand') }}</th>
                <!--<th>{{ trans('admin::form_add.lang_list_name') }}</th>-->
                <th>{{ trans('admin::brand.form_add.key_brand') }}</th>
                <th>{{ trans('admin::brand.form_add.url') }}</th>
                <th style="width: 336px">{{ trans('admin::brand.form_add.countries') }}</th>
                <th>{{ trans('admin::brand.form_add.status') }}</th>
                @if ($can_edit || $can_delete)
                <th>{{ trans('admin::brand.form_add.actions') }}</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach ($brands as $brand)
                @if ($brand->delete == 0)
                    <tr id="lang_{!! $brand->id !!}">
                        <td>{!! $brand->name !!}</td>
                        <td>{!! $brand->alias !!}</td>
                        <td>{!! $brand->domain !!}</td>
                        <td>
                            @foreach($brand->brandCountry as $bcountry)

                                <span class="label label-default">{!! $bcountry->country->name !!}</span>
                            @endforeach

                        </td>
                        <td><span id="status{{$brand->id}}"  class="label  {{$brand->active ? 'label-success' : 'label-default'}} ">{!! $brand->active == 0 ?  trans('admin::language.lang_list_st_inactive')  : trans('admin::language.lang_list_st_active')  !!}</span></td>
                        @if ($can_edit || $can_delete || $can_remove)
                            <td data-lid="{!! $brand->id !!}">
                    <span onclick="disableBrand({{$brand->id}})" id='activeBrand{{$brand->id}}' class="{{$brand->active ? 'hide' : ''}}">
                        <i class="glyphicon glyphicon-stop itemTooltip  " title="{{ trans('admin::brand.form_add.enable') }}"></i>
                    </span>
                                <span onclick="disableBrand({{$brand->id}})" id='inactiveBrand{{$brand->id}}' class="{{$brand->active ? '' : 'hide'}}">
                        <i class="glyphicon glyphicon-play itemTooltip " title="{{ trans('admin::brand.form_add.disable') }}"></i>
                    </span>
                                <a class="glyphicon glyphicon-pencil itemTooltip" href="{{ route('admin.brand.editBrand', ['bread_id' => $brand->id]) }}" title="{{ trans('admin::language.lang_list_edit') }}"></a>
                                @if ($can_remove)
                                    <form id="delete-brand-form-{{ $brand->id }}" action="{{ route('admin.brand.delete', $brand->id) }}", method="POST" style="display: inline">
                                        {{ csrf_field() }}
                                        <a onclick="deleteElement(this)" data-code="{{ $brand->id }}" data-element="{{ $brand->name }}" id="delete-{{ $brand->id }}" class="glyphicon glyphicon-trash itemTooltip" href="#" title="{{ trans('admin::brand.delete_brand') }}"></a>
                                    </form>
                                @endif
                            </td>
                        @endif

                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>
</div>
@section('scripts')
<script type="text/javascript">

    $('#tbl_brands').DataTable({
    "responsive": true,
            "ordering": false,
              "language": { 
                    "url": "{{ trans('admin::datatables.lang') }}"
               }  
    });
    function deleteElement(element) {
        var code = $(element).data('code');
        var name = $(element).data('element');

        $('#confirm-modal .modal-body').text('{{trans('admin::shopping.products.index.confirm')}} ' + name + '?');

        $('#confirm-modal').modal({
            backdrop: 'static',
            keyboard: false
        }).one('click', '#delete', function(e) {
            $('#delete-brand-form-'+code).submit();
        });
    }
    function disableBrand(brand_id) {
    $.ajax({
    url: route('admin.bread.activeBrand'),
            type: 'POST',
            data: {brand_id: brand_id},
            success: function (data) {
            let label = $("#status" + brand_id);
            let iconActive = $("#activeBrand" + brand_id);
            let iconInactive = $("#inactiveBrand" + brand_id);
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
</script>
@stop