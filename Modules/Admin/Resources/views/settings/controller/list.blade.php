<div class="row textbox">
    <div class="col-sm-6">
        <h1>{{ trans('admin::control.controller_list') }}</h1>
    </div>
    @if(@can_add)   
    <div class="col-sm-6 text-right">     
        <a href="{{ route('admin.controller.add') }}" class="btn btn-warning addButton"><i class="fa fa-plus"></i> &nbsp;
            {{ trans('admin::control.add_controller') }}</a>
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
    <table class="table table-striped" id="tbl_menus">
        <thead>
            <tr>
                <th>{{ trans('admin::control.control_name') }}</th>
                <th>{{ trans('admin::control.rol_name') }}</th>
                <th>{{ trans('admin::control.section_controller') }}</th>
                <th>{{ trans('admin::brand.form_add.status') }}</th>
                @if ($can_edit || $can_delete)
                <th>{{ trans('admin::brand.form_add.actions') }}</th>

                @endif
            </tr>
        </thead>
        <tbody>
            @foreach ($controllers as $m)
            <tr id="menu_{!! $m->id !!}">
                <td>{!!$m->role_name!!}</td>
                <td>{!! $m->controller    !!}</td>
                <td>                  
                {!! $sections[$m->role_section-1]['section'] !!}
                   </td>              
                <!--<td><span class="label  label-success">{!! $m->role_section !!}</span></td>--> 
                <td><span id="status{{$m->id}}"  class="label  {{$m->active ? 'label-success' : 'label-default'}} ">{!! $m->active== 0 ?  trans('admin::menu.disabled')  : trans('admin::menu.active')  !!}</span></td>
                @if ($can_edit || $can_delete)
                <td data-lid="{!! $m->id !!}">
                    <span onclick="disable_controller({{$m->id}})" id='activeBrand{{$m->id}}' class="{{$m->active ? '' : 'hide'}}">
                        <i class="glyphicon glyphicon-play itemTooltip  " title="{{ trans('admin::menu.disable_controller') }}"></i>
                    </span>
                    <span onclick="disable_controller({{$m->id}})" id='inactiveBrand{{$m->id}}' class="{{$m->active ? 'hide' : ''}}">                                
                        <i class="glyphicon glyphicon-stop  itemTooltip " title="{{ trans('admin::menu.enable_controller') }}"></i>                            
                    </span>                                
                    <a class="glyphicon glyphicon-pencil itemTooltip" href="{{ route('admin.controller.update', ['controller_id' => $m->id]) }}" title="{{ trans('admin::control.update_controller') }}"></a>
                </td>
                @endif
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@section('scripts')
<script type="text/javascript">
    function disable_controller(id) {
    $.ajax({
    url: route('admin.controller.active'),
            type: 'POST',
            data: {id_controller: id},
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

    $('#tbl_menus').DataTable({
    "responsive": true,
            "ordering": false,
              "language": { 
                    "url": "{{ trans('admin::datatables.lang') }}"
               }  
    });

</script>
@stop