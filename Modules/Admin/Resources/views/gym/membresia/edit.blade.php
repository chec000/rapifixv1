<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="panel panel-info">
                <div class="panel-heading">{{ __('Edit') }}
                    <button class="btn btn-success">
                        <a style="color:black" href="{{route('admin.Membresia.list_membresia')}}">
                            <i class="fa fa-undo"></i>
                            Regresar</a>
                    </button>
                </div>
                <div class="card-body">

                    {!! Form::open(array('route' => 'admin.Membresia.editMembresia')) !!}

                    <input type="hidden" name="id" value="{{$membresia->id}}">
                    <div class="row">

                        <div class="form-group col-md-6">
                            <label for="tipo" >{{ __('Tipo') }}</label>
                            <select name="tipo" class="form-control">
                                @foreach ($tipos as $t)                                             
                                @if($t->id==$membresia->tipo_id)
                                <option selected value="{{$t->id}}">{{$t->nombre}}</option>
                                @else
                                <option  value="{{$t->id}}">{{$t->nombre}}</option>
                                @endif
                                @endforeach                                  
                            </select>

                        </div>
                        <div class="form-group col-md-6">
                            <label for="name" class=" col-form-label">{{ __('Nombre') }}</label>

                            <input id="nombre" value="{{$membresia->nombre}}"  type="text" class="form-control{{ $errors->has('nombre') ? ' is-invalid' : '' }}" name="nombre" value="{{ old('nombre') }}" required autofocus>

                            @if ($errors->has('nombre'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('nombre') }}</strong>
                            </span>
                            @endif

                        </div>                   
                    </div>

                    <div class="row">

                        <div class="form-group col-md-6">
                            <label for="precio" class="col-md-4 col-form-label text-md-right">{{ __('Precio') }}</label>

                            <input id="precio" value="{{$membresia->precio}}" type="number" class="form-control{{ $errors->has('precio') ? ' is-invalid' : '' }}" name="precio" value="{{ old('precio') }}" required>

                            @if ($errors->has('precio'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('precio') }}</strong>
                            </span>
                            @endif
                        </div>                        

                        <div class="form-group col-md-6">
                            <label for="requisitos" class="col-md-4 col-form-label text-md-right">{{ __('Requisitos') }}</label>
                            <textarea id="requisitos"   type="" class="form-control{{ $errors->has('requisitos') ? ' is-invalid' : '' }}" name="requisitos" value="{{ old('requisitos') }}" required >                                   
                                    {{trim($membresia->requisitos)}}
                            </textarea>
                            @if ($errors->has('requisitos'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('requisitos') }}</strong>
                            </span>
                            @endif

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ trans('admin::countries.add_flag') }}</label>
                                <div class="input-group">
                                    <input id="flag" class="img_src form-control" name="flag" value='{{$membresia->imagen}}'  type="text" required>
                                    <span class="input-group-btn">
                                        <a href="{!! URL::to(config('admin.config.public').'/filemanager/dialog.php?type=1&field_id=flag') !!}" class="btn btn-default iframe-btn">{{ trans('admin::countries.add_btn_image') }}</a>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="duracion" class="col-md-4 col-form-label text-md-right">{{ __('Periodiciad') }} </label>                           

                            <select name="duracion" class="form-control">  
                                @for ($i = 1; $i <= 12; $i++)      
                                
                                @if($i==1)                                        
                                @if($membresia->duracion_meses==$i)
                                <option value="{{$i}}" selected=""> {{$i}} Mes</option> 
                                @else
                                <option value="{{$i}}" > {{$i}} Mes</option> 
                                @endif
                                 
                                @else
                                 @if($membresia->duracion_meses==$i)
                                <option value="{{$i}}" selected=""> {{$i}} Meses</option> 
                                @else
                                <option value="{{$i}}"> {{$i}} Meses</option> 
                                @endif
                                
                                @endif

                                @endfor                             
                            </select>    

                            @if ($errors->has('duracion'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('duracion') }}</strong>
                            </span>
                            @endif
                        </div>                            

                    </div>

                    <div class="row">                                                 
                        <div class="card col-md-6">
                            <div class="card-header">Actividades/deportes</div>
                            <div class="card-body">
                                @foreach ($deportes_existentes as $d)                              
                                <div class="form-check" style="display: inline-block">
                                    <label class="form-check-label">                                   
                                        <input name="deportes[]"    {{($d->selected)?'checked':''}}     type="checkbox" class="form-check-input" value="{{$d->id}}">{{$d->nombre}}
                                    </label>
                                </div>
                                @endforeach                               
                            </div> 
                        </div> 

                        <div class="card col-md-6">
                            <div class="card-header">Beneficios</div>
                            <div class="card-body">

                                @foreach ($beneficios_existestes as $b)                              
                                <div class="form-check" style="display: inline-block">
                                    <label class="form-check-label">
                                        <input {{($b->selected)?'checked':''}}  name="beneficio[]"  type="checkbox" class="form-check-input" value="{{$b->id}}">{{$b->nombre}}
                                    </label>
                                </div>
                                @endforeach                               
                            </div> 
                        </div>                                                                                     
                    </div>                                                                                                        
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Actualizar') }}
                            </button>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
