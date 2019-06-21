<div class="container">
    <div class="panel panel-info">
  <div class="panel-heading">{{'Lista de membresias'}}
      
          <button class="btn btn-success">
              <a style="color:black" href="{{route('admin.Membresia.addMembresia')}}"><i class="fa fa-plus-circle"></i>Agregar membresia</a>
              </button>
      
  </div>
  <div class="panel-body">
   
    <table class="table table-hover" id="tbl_table">
  <thead>
    <tr>
      <!--<th scope="col">id</th>-->
       <th scope="col">Imágen</th>
      <th scope="col">Nombre</th>
      <th scope="col">Tipo</th>
      <th scope="col">Precio</th>
       <th> Requisitos</th>
      <th scope="col">Estatus</th>
        <th scope="col">Acciones</th>
    </tr>
  </thead>
  <tbody>
      
      @foreach ($membresias as $m)      
      <tr id="columna-{{$m->id}}}">
      <!--<th scope="row">{{$m->id}}</th>-->
          <td><img height="100px" src="{{$m->imagen}}"></td>

      <td>{{$m->nombre}}</td>
      <td>{{$m->tipo->nombre}}</td>
      <td>{{$m->precio}}</td>
       <td>{{$m->descripcion}}</td>
      
              <td><span id="status{{$m->id}}"  class="label  {{$m->activo ? 'label-success' : 'label-default'}} ">{!! $m->activo== 0 ?  trans('admin::language.lang_list_st_inactive')  : trans('admin::language.lang_list_st_active')  !!}</span></td>
                @if ($can_edit || $can_delete)
                <td data-lid="{!! $m->id !!}">
                    <span onclick="activeMembresia({{$m->id}})" id='activeBrand{{$m->id}}' class="{{$m->activo ? '' : 'hide'}}">
                        <i class="glyphicon glyphicon-play itemTooltip  " title="{{ trans('admin::action.disable_action') }}" ></i>
                    </span>
                    <span onclick="activeMembresia({{$m->id}})" id='inactiveBrand{{$m->id}}' class="{{$m->activo ? 'hide' : ''}}">                                
                        <i class="glyphicon glyphicon-stop  itemTooltip "  title="{{ trans('admin::action.enable_action') }}"></i>                            
                    </span>                                                
                    <a class="glyphicon glyphicon-pencil itemTooltip" href="{{ route('admin.Membresia.getMembresia', ['id' => $m->id]) }}" title="{{ trans('admin::action.edit_action') }}"></a>
                 <span onclick="activeDesactiveCliente({{$m->id}})" >                                
                               <i class="glyphicon glyphicon-trash  itemTooltip "  title="{{ trans('admin::action.enable_action') }}"></i>                            
                            </span>            
                </td>
                @endif
    </tr>
  @endforeach
  </tbody>
</table>  
  </div>
</div>

</div>

    <script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
    <script src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>

<script type="text/javascript">
    function activeMembresia(id) {         
    $.ajax({
    url: route('admin.Membresia.activeInactive_membresia'),
            type: 'POST',
            data: {id: id},
            success: function (data) {
        console.log(data);
        let label = $("#status" + id);
            let iconActive = $("#activeBrand" + id);
            let iconInactive = $("#inactiveBrand" + id);
            if (data === "0") {
            iconActive.addClass('hide');
            iconInactive.removeClass('hide');
            label.removeClass('label-success').addClass('label-default');
            label.text("Inactivo");
            }
            else {
            iconActive.removeClass('hide');
            iconInactive.addClass('hide');
            label.removeClass('label-default').addClass('label-success');
            label.text("Activo");
            }
            },
      error: function(data) { 
    console.log(data);          
    }

    });
    }

                        $('#tbl_table').DataTable({
                        "responsive": true,
                                "ordering": false,
                                "language": {
                                "url": "{{ trans('admin::datatables.lang') }}"
                                }
                        });

</script>