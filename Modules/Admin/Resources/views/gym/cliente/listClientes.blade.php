
<div class="container">

    <div class="card" >
        <div class="card-body">
            <a href="{{route('admin.client.add_cliente')}}" class="small-box-footer">Agregar cliente <i class="fa fa-arrow-circle-right"></i></a>             
            <table class="table table-striped " id="tbl_table">
                <thead>
                    <tr>
                      <th scope="col">Codigo de usuario</th>
                        <th scope="col">Foto</th>       
                         <th scope="col">Clave unica</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Apellidos</th>
                        <th scope="col">Telefono</th>
                        <th scope="col">Dirección</th>
                        <th scope="col">Fecha inscripción</th>
                        <th scope="col">Estado</th>
                        <th scope="col">Activo</th>
                        <th scope="col">Acciones</th>

                    </tr>
                </thead>
                <tbody>
                    @if(count($clientes)>0)
                    @foreach ($clientes as $c)
                    <tr>
                      <td>{{$c->codigo_cliente}}</td>
                        @if($c->usuario!=null)            
                        <td><img style="height: 100px" src="{{$c->usuario->foto}}"></td>
                        <td>{{$c->usuario->clave_unica}}</td>
                        <td>{{$c->usuario->name}}</td>                        
                        <td>{{$c->usuario->apellido_paterno}}</td>
                        <td>{{$c->usuario->telefono}}</td>
                        <td>{{$c->usuario->direccion}}</td>
                        @else
                        <td>NA</td>
                        <td>NA</td>
                        <td>NA</td>
                        <td>NA</td>
                        <td>NA</td>
                        <td>NA</td>
                        <td>NA</td>           
                        @endif
                        <td>{{$c->fecha_inscripcion}}</td>
                        <td>{{$c->estado_cliente}}</td>                     


                        <td><span id="status{{$c->id}}"  class="label  {{$c->activo ? 'label-success' : 'label-default'}} ">{!! $c->activo== 0 ?  trans('admin::language.lang_list_st_inactive')  : trans('admin::language.lang_list_st_active')  !!}</span></td>
                        @if ($can_edit || $can_delete)
                        <td data-lid="{!! $c->id !!}">
                            <span onclick="activeDesactiveCliente({{$c->id}})" id='activeBrand{{$c->id}}' class="{{$c->activo ? '' : 'hide'}}">
                                <i class="glyphicon glyphicon-play itemTooltip  " title="{{ trans('admin::action.disable_action') }}" ></i>
                            </span>
                            <span onclick="activeDesactiveCliente({{$c->id}})" id='inactiveBrand{{$c->id}}' class="{{$c->activo ? 'hide' : ''}}">                                
                                <i class="glyphicon glyphicon-stop  itemTooltip "  title="{{ trans('admin::action.enable_action') }}"></i>                            
                            </span>                                              
                            <a class="glyphicon glyphicon-trash itemTooltip" href="{{ route('admin.client.delete_cliente', ['id' => $c->id]) }}" title="{{ trans('admin::action.edit_action') }}"></a>
                            <a class="glyphicon glyphicon-pencil itemTooltip" href="{{ route('admin.client.edit_cliente', ['id' => $c->id]) }}" title="{{ trans('admin::action.edit_action') }}"></a>
                        </td>
                        @endif
                    </tr>
                    @endforeach
                    @endif  
                </tbody>
            </table>     
        </div>

    </div>
    <script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>

    <!--<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css" />-->
    <script src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
    <!--    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>-->
    <script type="text/javascript">
                                function activeDesactiveCliente (id){
                                $.ajax({
                                url: route('admin.client.activeInactive_cliente'),
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
</div>

