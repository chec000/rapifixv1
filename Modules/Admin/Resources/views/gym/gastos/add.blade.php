<div class="container">
    <div class="row ">
        <div class="col-md-12">
            <div class="panel panel-info">
                <div class="panel-heading">{{ __('Registrar actividad') }}

                    <button class="btn btn-success">
                        <a style="color:black" href="{{route('admin.Gasto.index')}}">
                            <i class="fa fa-undo"></i>
                            Regresar</a>
                    </button>
                </div>

                <div class="panel-body">
                    {!! Form::open(array('route' => 'admin.Gasto.addCosto')) !!}
                    <div class="row">


                        <div class="form-group col-md-6 ">
                            <label for="code_product" class="col-md-4 col-form-label text-md-right">{{ __('Codigo de producto') }}</label>

                            <input id="code_product" name="code_product" type="text" class="form-control{{ $errors->has('code_product') ? ' is-invalid' : '' }}" value="{{ old('code_product') }}" required autofocus>

                            @if ($errors->has('code_product'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('code_product') }}</strong>
                            </span>
                            @endif
                        </div>

                        <div class="form-group  col-md-6">
                            <label for="nombre" class="col-md-4 col-form-label text-md-right">{{ __('Nombre de producto') }}</label>

                            <input id="nombre" name="nombre" type="text" class="form-control{{ $errors->has('nombre') ? ' is-invalid' : '' }}" value="{{ old('name') }}" required autofocus>

                            @if ($errors->has('nombre'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('nombre') }}</strong>
                            </span>
                            @endif

                        </div>

                    </div>

                    <div class="row ">
                        <div class="form-group col-md-6">
                            <label for="descripcion" class="col-md-4 col-form-label text-md-right">{{ __('Descripción') }}</label>

                            <textarea id="descripcion" type="text" class="form-control{{ $errors->has('descripcion') ? ' is-invalid' : '' }}" name="descripcion" value="{{ old('descripcion') }}" required></textarea>

                            @if ($errors->has('apellido_paterno'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('descripcion') }}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="form-group col-md-6">
                            <label for="valor_costo" class="col-md-4 col-form-label text-md-right">{{ __('Costo unitario') }}</label>

                            <input  type="number" min="1" name="valor_costo" class="form-control{{ $errors->has('valor_costo') ? ' is-invalid' : '' }}" >                            
                            @if ($errors->has('valo_costo'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('valor_costo') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="row ">
                        <div class="form-group col-md-6">
                            <label for="cantidad" class="col-md-4 col-form-label text-md-right">{{ __('Cantidad') }}</label>

                            <input type="number" min="1" name="cantidad" class="form-control{{ $errors->has('nombre') ? ' is-invalid' : '' }}" >                            
                            @if ($errors->has('cantidad'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('cantidad') }}</strong>
                            </span>
                            @endif
                        </div>
                        
                        <div class="form-group col-md-6">
                            <label for="valor_total" class="col-md-4 col-form-label text-md-right">{{ __('Costo total') }}</label>
                            <input type="number" min="1" name="valor_total" class="form-control{{ $errors->has('valor_total') ? ' is-invalid' : '' }}" >                            
                            @if ($errors->has('valor_total'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('valor_total') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>

                    <div class="row">
                            <div class="form-group col-md-6">
                            <label for="fecha_compra" class="col-md-4 col-form-label text-md-right">{{ __('Fecha compra') }}</label>

                            <input type="date" min="1" name="fecha_compra" class="form-control{{ $errors->has('fecha_compra') ? ' is-invalid' : '' }}" >                            
                            @if ($errors->has('fecha_compra'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('fecha_compra') }}</strong>
                            </span>
                            @endif
                        </div>
                    
                    </div>

                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <button ype="submit" class="btn btn-primary">
                                {{ __('Register') }}
                            </button>                                 

                        </div>
                    </div>

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>








