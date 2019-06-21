<div class="row textbox">
    <div class="col-sm-6">
        <h1>{{ trans('admin::action.action_list') }}</h1>
    </div>
   
    @if($can_add)   
    <div class="col-sm-6 text-right">     
        <a href="{{ route('admin.action.add') }}" class="btn btn-warning addButton"><i class="fa fa-plus"></i> &nbsp;
            {{ trans('admin::action.add_action') }}</a>
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
                  <th>{{ trans('admin::action.action') }}</th>
                <th>{{ trans('admin::action.alias_action') }}</th>
                <!--<th>{{ trans('admin::form_add.lang_list_name') }}</th>-->
                <!--<th>{{ trans('admin::action.about') }}</th>-->
                <th>{{ trans('admin::action.inherit') }}</th>
                <th>{{ trans('admin::brand.form_add.status') }}</th>
                @if ($can_edit || $can_delete)
                <th>{{ trans('admin::brand.form_add.actions') }}</th>

                @endif
            </tr>
        </thead>
        <tbody>
            @foreach ($actions as $m)
            <tr id="menu_{!! $m->id !!}">
                <td>{!! $m->name !!}</td>
                <td>{!! $m->action !!}</td>              
                <!--<td>{!! $m->about !!}</td>--> 
                  <td>{!! ($m->inherit==-1)?trans('admin::action.notinherit'):$m->inherit !!}</td>
                <td><span id="status{{$m->id}}"  class="label  {{$m->active ? 'label-success' : 'label-default'}} ">{!! $m->active== 0 ?  trans('admin::language.lang_list_st_inactive')  : trans('admin::language.lang_list_st_active')  !!}</span></td>
                @if ($can_edit || $can_delete)
                <td data-lid="{!! $m->id !!}">
                    <span onclick="disable_menu({{$m->id}})" id='activeBrand{{$m->id}}' class="{{$m->active ? '' : 'hide'}}">
                        <i class="glyphicon glyphicon-play itemTooltip  " title="{{ trans('admin::action.disable_action') }}" ></i>
                    </span>
                    <span onclick="disable_menu({{$m->id}})" id='inactiveBrand{{$m->id}}' class="{{$m->active ? 'hide' : ''}}">                                
                        <i class="glyphicon glyphicon-stop  itemTooltip "  title="{{ trans('admin::action.enable_action') }}"></i>                            
                    </span>                                
                    <a class="glyphicon glyphicon-pencil itemTooltip" href="{{ route('admin.action.update', ['id_menu' => $m->id]) }}" title="{{ trans('admin::action.edit_action') }}"></a>
                </td>
                @endif
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@section('scripts')
<script type="text/javascript">
    function disable_menu(id) {
    $.ajax({
    url: route('admin.action.active'),
            type: 'POST',
            data: {action_id: id},
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