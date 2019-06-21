       <div class="panel panel-info">                 
                                <div class="panel-heading"> <h3 class="panel-title">{{ __('Register') }}</h3> </div>
                                <div class="panel-body">
                                    {!! Form::open(array('route' => 'admin.Cliente.save_cliente','id'=>'save_client')) !!}

                                    <input type="hidden" name="tipo_inscripcion" value="1">
                                    <input type="hidden" name="lat" value="0">
                                    <input type="hidden" name="lon" value="0">

                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Nombre') }}</label>                          
                                            <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{( $cliente!=null)?$cliente['name']:""}}" required autofocus>
                                            @if ($errors->has('name'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('name') }}</strong>
                                            </span>
                                            @endif                          
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="apellido_paterno" class="col-md-4 col-form-label text-md-right">{{ __('Apellidos') }}</label>                   
                                            <input id="apellido_paterno" type="text" class="form-control{{ $errors->has('apellido_paterno') ? ' is-invalid' : '' }}" name="apellido_paterno" value="{{( $cliente!=null)?$cliente['apellido_paterno']:""}}" required>                               
                                            @if ($errors->has('apellido_paterno'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('apellido_paterno') }}</strong>
                                            </span>
                                            @endif                            
                                        </div>
                                    </div>                                      
                                    <div class="row">

                        <div class="form-group col-md-6">
                                           <label for="clave_unica" class="col-form-label text-md-right">{{ __('Clave unica de identificación') }}</label>          
                                            <input id="clave_unica" type="text" class="form-control{{ $errors->has('clave_unica') ? ' is-invalid' : '' }}" name="clave_unica" value="{{( $cliente!=null)?$cliente['clave_unica']:""}}" required>
                                            @if ($errors->has('clave_unica'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('clave_unica') }}</strong>
                                            </span>
                                            @endif                          
                                        </div>  
                                   
                                        <div class="form-group col-md-6 ">
                                            <label for="telefono" class=" col-form-label text-md-right">{{ __('Teléfono') }}</label>                       
                                            <input id="telefono" type="tel" class="form-control{{ $errors->has('telefono') ? ' is-invalid' : '' }}" name="telefono" value="{{( $cliente!=null)?$cliente['telefono']:""}}" required >
                                            @if ($errors->has('telefono'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('telefono') }}</strong>
                                            </span>
                                            @endif                      
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="telefono_celular" class="col-md-4 col-form-label text-md-right">{{ __('Teléfono celular') }}</label>
                                            <input id="telefono_celular" type="tel" class="form-control{{ $errors->has('telefono_celular') ? ' is-invalid' : '' }}" name="telefono_celular" value="{{( $cliente!=null)?$cliente['telefono_celular']:""}}" required>
                                            @if ($errors->has('telefono_celular'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('telefono_celular') }}</strong>
                                            </span>
                                            @endif                        
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="fecha_nacimiento" class="col-md-4 col-form-label text-md-right">{{ __('Fecha nacimiento') }}</label>
                                            <input id="fecha_nacimiento" type="date" class="form-control{{ $errors->has('fecha_nacimiento') ? ' is-invalid' : '' }}" name="fecha_nacimiento" value="{{( $cliente!=null)?$cliente['fecha_nacimiento']:""}}" required>
                                            @if ($errors->has('fecha_nacimiento'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('fecha_nacimiento') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>               
                                    <div class="row">
                                                                                
                                        <div class="form-group col-md-6">
                                            <label for="estado_civil" class="col-md-4 col-form-label text-md-right">{{ __('Estado civil') }}</label>                                        
                                               <select value="{{( $cliente!=null)?$cliente['estado_civil']:""}}"  name="estado_civil" class="form-control{{ $errors->has('estado_civil') ? ' is-invalid' : '' }}">
                                          <option value="" selected>Selecciona una opción</option>
                                          <option value="Soltero">Soltero</option>
                                          <option value="Casado">Casado</option>
                                               </select>                                            
                                            @if ($errors->has('fecha_nacimiento'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('estado_civil') }}</strong>
                                            </span>
                                            @endif                           
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="pais" class="col-md-4 col-form-label text-md-right">{{ __('País') }}</label>
                                            <select name="pais"  class="form-control" id="pais" onchange="getEstadoPais(this);">
                                                @foreach ($paises as $p)
                                                <option  value="{{$p->id}}">{{$p->nombre}}</option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('pais'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('pais') }}</strong>
                                            </span>
                                            @endif
                                        </div>                            
                                    </div>                                    
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="estado" class="col-md-4 col-form-label text-md-right">{{ __('Estado') }}</label>
                                            <select name="estado"   class="form-control" id="estado">
                                                <option></option>
                                            </select>
                                            @if ($errors->has('estado'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('estado') }}</strong>
                                            </span>
                                            @endif                            
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="direccion" class="col-md-4 col-form-label text-md-right">{{ __('Dirección') }}</label>
                                            <input id="direccion" type="text" class="form-control{{ $errors->has('direccion') ? ' is-invalid' : '' }}" name="direccion" value="{{( $cliente!=null)?$cliente['direccion']:""}}" required>
                                            @if ($errors->has('direccion'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('direccion') }}</strong>
                                            </span>
                                            @endif                           
                                        </div>
                                    </div>    
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Correo electrónico') }}</label>

                                            <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{( $cliente!=null)?$cliente['email']:""}}" required >

                                            @if ($errors->has('email'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>{{ trans('admin::countries.add_flag') }}</label>
                                                <div class="input-group">
                                                    <input id="flag" class="img_src form-control" name="flag" value=''  type="text" value="{{( $cliente!=null)?$cliente['flag']:""}}">
                                                    <span class="input-group-btn">
                                                        <a href="{!! URL::to(config('admin.config.public').'/filemanager/dialog.php?type=1&field_id=flag') !!}" class="btn btn-default iframe-btn">{{ trans('admin::countries.add_btn_image') }}</a>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                                            <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required value="{{( $cliente!=null)?$cliente['password']:""}}">

                                            @if ($errors->has('password'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('password') }}</strong>
                                            </span>
                                            @endif

                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>                            
                                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required value="{{( $cliente!=null)?$cliente['password']:""}}">
                                        </div>                            
                                    </div>   

                                    <!--<button type="submit" class="btn btn-primary next-step">Save and continue</button>-->
                                    <input type="hidden" name="only_client" value="1" class="btn btn-primary" value="Guardar">

                                    <input type="submit" class="btn btn-primary" value="Guardar">

                                    {!! Form::close() !!}

                                </div>
       </div>
{!! Form::open(array('route' => 'admin.Estados.estados','id'=>'form_estado')) !!}
<input type="hidden" id="id_pais" name="id_pais">

{!! Form::close() !!}