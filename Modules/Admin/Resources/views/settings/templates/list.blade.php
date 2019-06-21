<div class="row textbox">
    <div class="col-sm-6">
        <h1>{{ trans('admin::template.list_template') }}</h1>
    </div>
    @if(@can_add)   
    <div class="col-sm-6 text-right">     
        <a href="{{ route('admin.template.add') }}" class="btn btn-warning addButton"><i class="fa fa-plus"></i> &nbsp;
            {{ trans('admin::template.new_template') }}
        
        </a>
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
    <table class="table table-striped" id="tbl_templates">
        <thead>
            <tr>
                <th>{{ trans('admin::brand.form_add.name_brand') }}</th>
                <!--<th>{{ trans('admin::form_add.lang_list_name') }}</th>-->
                <th>{{ trans('admin::template.label') }}</th>
                <th>{{ trans('admin::brand.form_add.status') }}</th>
                @if ($can_edit || $can_delete)
                <th>{{ trans('admin::brand.form_add.actions') }}</th>

                @endif
            </tr>
        </thead>
        <tbody>
            @foreach ($templates as $m)
            <tr id="menu_{!! $m->id !!}">
                <td>{!! $m->template !!}</td>
                <td>{!! $m->label !!}</td>
                <td><span id="status{{$m->id}}"  class="label  {{$m->active ? 'label-success' : 'label-default'}} ">{!! $m->active== 0 ?  trans('admin::language.lang_list_st_inactive')  : trans('admin::language.lang_list_st_active')  !!}</span></td>
                @if ($can_edit || $can_delete)
                <td data-lid="{!! $m->id !!}">
                    <span onclick="disable_template({{$m->id}})" id='activeBrand{{$m->id}}' class="{{$m->active ? '' : 'hide'}}">
                        <i class="glyphicon glyphicon-play itemTooltip  " title="{{ trans('admin::template.disable_template') }}"></i>
                    </span>
                    <span onclick="disable_template({{$m->id}})" id='inactiveBrand{{$m->id}}' class="{{$m->active ? 'hide' : ''}}">                                
                        <i class="glyphicon glyphicon-stop  itemTooltip " title="{{ trans('admin::template.enable_template') }}"></i>                            
                    </span>                                
                    <a class="glyphicon glyphicon-pencil itemTooltip" href="{{ route('admin.template.update', ['id_template' => $m->id]) }}" title="{{ trans('admin::template.update_label') }}"></a>
                </td>
                @endif
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@section('scripts')
<script type="text/javascript">
    function disable_template(id) {
    $.ajax({
    url: route('admin.template.active'),
            type: 'POST',
            data: {template_id: id},
            success: function (data) {
            let label = $("#status" + id);
            let iconActive = $("#activeBrand" + id);
            let iconInactive = $("#inactiveBrand" + id);
            if (data.status === 0) {
            iconActive.addClass('hide');
            iconInactive.removeClass('hide');
            label.removeClass('label-success').addClass('label-default');
            label.text(data.message);
            }
            else {
            iconActive.removeClass('hide');
            iconInactive.addClass('hide');
            label.removeClass('label-default').addClass('label-success');
            label.text(data.message);
            }
            }

    });
    }

    $('#tbl_templates').DataTable({
    "responsive": true,
            "ordering": false,
              "language": { 
                    "url": "{{ trans('admin::datatables.lang') }}"
               }  
    });

</script>
@stop