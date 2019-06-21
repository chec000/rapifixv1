<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Update') }}
                    <button class="btn btn-success">
                        <a style="color:black" href="{{route('admin.client.list_clientes')}}">
                            <i class="fa fa-undo"></i>
                            Regresar</a>
                    </button>

                </div>
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" href="#cliente" role="tab" data-toggle="tab">Cliente</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#buzz" role="tab" data-toggle="tab">Membresia</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#references" role="tab" data-toggle="tab">Facturas</a>
                    </li>

                </ul>

                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane fade in active" id="cliente">
                        <div class="card-body">
                            {!! Form::open(array('route' => 'admin.Cliente.update_cliente')) !!}  

                            <input type="hidden" name="cliente_id" value="{{$cliente->id}}">
                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Nombre') }}</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ $cliente->usuario->name}}" required autofocus>

                                    @if ($errors->has('name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>


                            <div class="form-group row">
                                <label for="apellido_paterno" class="col-md-4 col-form-label text-md-right">{{ __('Apellido paterno') }}</label>

                                <div class="col-md-6">
                                    <input id="apellido_paterno" type="text" class="form-control{{ $errors->has('apellido_paterno') ? ' is-invalid' : '' }}" name="apellido_paterno" value="{{ $cliente->usuario->apellido_paterno }}" required>

                                    @if ($errors->has('apellido_paterno'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('apellido_paterno') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>



                            <div class="form-group row">
                               <label for="clave_unica" class="col-md-4 col-form-label text-md-right">{{ __('Clave unica de identificación') }}</label>          
                            <div class="col-md-6">
                                            <input id="clave_unica" type="text" class="form-control{{ $errors->has('clave_unica') ? ' is-invalid' : '' }}" name="clave_unica" value="{{ $cliente->usuario->clave_unica }}"  required>
                                            @if ($errors->has('clave_unica'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('clave_unica') }}</strong>
                                            </span>
                                            @endif                          
                                        </div>                                     
                            </div>
                            
                            <div class="form-group row">
                                <label for="telefono" class="col-md-4 col-form-label text-md-right">{{ __('Teléfono') }}</label>

                                <div class="col-md-6">
                                    <input id="telefono" type="tel" class="form-control{{ $errors->has('telefono') ? ' is-invalid' : '' }}" name="telefono" value="{{ $cliente->usuario->telefono }}" required>

                                    @if ($errors->has('telefono'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('telefono') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="telefono_celular" class="col-md-4 col-form-label text-md-right">{{ __('Teléfono celular') }}</label>

                                <div class="col-md-6">
                                    <input id="telefono_celular" type="tel" class="form-control{{ $errors->has('telefono_celular') ? ' is-invalid' : '' }}" name="telefono_celular" value="{{ $cliente->usuario->telefono_celular }}" required>

                                    @if ($errors->has('telefono_celular'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('telefono_celular') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>


                            <div class="form-group row">
                                <label for="fecha_nacimiento" class="col-md-4 col-form-label text-md-right">{{ __('Fecha nacimiento') }}</label>

                                <div class="col-md-6">
                                    <input id="fecha_nacimiento" type="date" class="form-control{{ $errors->has('fecha_nacimiento') ? ' is-invalid' : '' }}" name="fecha_nacimiento" value="{{ $cliente->usuario->fecha_nacimiento }}" disabled>

                                    @if ($errors->has('fecha_nacimiento'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('fecha_nacimiento') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="estado_civil" class="col-md-4 col-form-label text-md-right">{{ __('Estado civil') }}</label>

                                <div class="col-md-6">
                                    <input id="estado_civil" type="text" class="form-control{{ $errors->has('estado_civil') ? ' is-invalid' : '' }}" name="estado_civil" value="{{ $cliente->usuario->estado_civil }}" required>

                                    @if ($errors->has('fecha_nacimiento'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('estado_civil') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>


                            <div class="form-group row">
                                <label for="pais" class="col-md-4 col-form-label text-md-right">{{ __('País') }}</label>

                                <div class="col-md-6">
                                    <input id="pais" type="text" class="form-control{{ $errors->has('pais') ? ' is-invalid' : '' }}" name="pais" value="{{ $pais->nombre }}" disabled>


                                    @if ($errors->has('pais'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('pais') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="estado" class="col-md-4 col-form-label text-md-right">{{ __('Estado') }}</label>

                                <div class="col-md-6">
                                    <input id="estado" type="text" class="form-control{{ $errors->has('pais') ? ' is-invalid' : '' }}" name="estado" value="{{ $estado->nombre }}" disabled>

                                    @if ($errors->has('estado'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('estado') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>


                            <div class="form-group row">
                                <label for="direccion" class="col-md-4 col-form-label text-md-right">{{ __('Dirección') }}</label>

                                <div class="col-md-6">
                                    <input id="direccion" type="text" class="form-control{{ $errors->has('direccion') ? ' is-invalid' : '' }}" name="direccion" value="{{$cliente->usuario->direccion }}" required>

                                    @if ($errors->has('direccion'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('direccion') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            
                            <div class="form-group row">
                               <label class="col-md-4 col-form-label text-md-right">{{ trans('admin::countries.add_flag') }}</label>
                                <div class="col-md-6">
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <input id="flag" class="img_src form-control" name="flag"  type="text"  value="{{$cliente->usuario->foto}}">                                            
                                                    <span class="input-group-btn">
                                                        <a href="{!! URL::to(config('admin.config.public').'/filemanager/dialog.php?type=1&field_id=flag') !!}" class="btn btn-default iframe-btn">{{ trans('admin::countries.add_btn_image') }}</a>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>                                
                            </div>
                            
                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Correo electrónico') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ $cliente->usuario->email }}" required>

                                    @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Estatus') }}</label>

                                <div class="col-md-2">
                                    <input id="activo" value="1" type="checkbox" class="form-control{{ $errors->has('activo') ? ' is-invalid' : '' }}" name="activo"  {{ ($cliente->activo)==1?'checked':'' }}>

                                    @if ($errors->has('activo'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('activo') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required >

                                    @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Register') }}
                                    </button>
                                </div>
                            </div>
                            {!! Form::close() !!}

                        </div>



                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="buzz">
                        <div class="row">
                            <div class="col-md-6">
                                   @if(count($cliente->membresias)>0)
                        <div class="table-responsive">
                            <table class="table">
                                <caption>List of users</caption>
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Nombre</th>
                                        <th scope="col">Tipo</th>
                                        <th scope="col">Duración</th>
                                        <th scope="col">Precio</th>
                                        <th scope="col">Estatus</th>
                                        <th scope="col">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach( $cliente->membresias as $m )

                                    <tr>
                                        <td>{{$m->id}}</td>
                                        <td>{{$m->nombre}}</td>
                                        <td>{{$m->tipo_id}}</td>
                                        <td>{{$m->duracion}}</td>
                                        <td>{{$m->precio}}</td>

                                        <td><span id="status{{$m->id}}"  class="label  {{$m->activo ? 'label-success' : 'label-default'}} ">{!! $m->activo== 0 ?  trans('admin::language.lang_list_st_inactive')  : trans('admin::language.lang_list_st_active')  !!}</span></td>
                                        @if ($can_edit || $can_delete)
                                        <td data-lid="{!! $m->id !!}">
                                            <span onclick="activeDesactiveCliente({{$m->id}})" id='activeBrand{{$m->id}}' class="{{$m->activo ? '' : 'hide'}}">
                                                <i class="glyphicon glyphicon-play itemTooltip  " title="{{ trans('admin::action.disable_action') }}" ></i>
                                            </span>
                                            <span onclick="activeDesactiveCliente({{$m->id}})" id='inactiveBrand{{$m->id}}' class="{{$m->activo ? 'hide' : ''}}">                                
                                                <i class="glyphicon glyphicon-stop  itemTooltip "  title="{{ trans('admin::action.enable_action') }}"></i>                            
                                            </span>
                                        </td>
                                        @endif
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>

                        </div>
                        @else
                        <span>No existen membresias agregadas</span>
                        @endif                                                               
                            </div>
                            <div class="col-md-6" id="list_membresias"></div>

                        </div>    
   
                        <button class="btn btn-success"  onclick="getMembresias(2)">Agregar membresia</button>
                     
                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="references">


                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Fecha pago</th>
                                        <th>Tipo pago</th>
                                        <th>Total</th>
                                        <th>Descuento</th>    
                                        <th>Usuario</th>
                                        <th>Factura</th>

                                    </tr>
                                <tbody>
                                    @if(count($cliente->ventas))
                                    @foreach($cliente->ventas as $v)
                                    <tr>
                                        <td >{{$v->fecha}}</td>
                                        <td >{{$v->tipo_pago}}</td>
                                        <td >{{$v->total}}</td>
                                        <td >{{$v->descuento_id}}</td>
                                        <td >{{$v->id_empleado}}</td>
                                        <td >
                                            <a href="{{$v->factura}}"
                                               title="imagen GIF del bosque encantado" target="_blank">Factura</a>                                            
                                        </td>                                       
                                    </tr>
                                    @endforeach
                                    @endif
                                </tbody>

                            </table>


                        </div>
                    </div>
                </div> 


            </div>
        </div>
    </div>
</div>
{!!$venta_aside!!}


<script>
   function  getMembresias(tipo){
             
    $.ajax({
         url : route('admin.Membresia.list_view'),
            data :{tipo:tipo},
            type :'POST',
            dataType : 'json',
            success: function (data) {
           $('#list_membresias').html(data.responseText)
            },            
                error: function(data) { 
                 $('#list_membresias').html(data.responseText)

    } 
    });    
    }
    
    function agregarMembresia (id, nombre){
        console.log('asasas',nombre);
        saveMembresia(id,1).done(function (data) {
                openNav();
        if(data.code==100){
                  console.log(data);
        }                                                 
     });        
    }
function saveMembresia(id,cantidad){ 
    var request = $.ajax({
    url : route('admin.Cliente.add_membresia'),
            data :{id_membresia:id,cantidad:cantidad},
            type : 'POST',
            dataType : 'json',
            });
    return request;
    }
</script>