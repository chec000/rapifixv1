<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <div class="panel-title">
                        <div class="row">
                            <div class="col-xs-6">
                                <h5><span class="glyphicon glyphicon-shopping-cart"></span> Shopping Cart</h5>
                            </div>
                            <div class="col-xs-6">
                                <button type="button" class="btn btn-default prev-step">
                                    <span class="glyphicon glyphicon-share-alt"></span> Continue shopping
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel-body">                    
                    @foreach($membresias as $m)
                    <div class="row list-group-item">
                        <div class="col-xs-2"><img class="img-responsive" src="{{$m->imagen}}">
                        </div>
                        <div class="col-xs-4">
                            <h4 class="product-name"><strong>{{$m->nombre}}</strong></h4><h4><small>{{$m->descripcion}}</small></h4>
                        </div>
                        <div class="col-xs-6">
                            <div class="col-xs-4 text-right">
                                <h6>Precio: <strong>${{$m->precio}} </strong></h6>
                            </div>
                            <div class="col-xs-8">       
                                <div class="col-xs-4">
                                    <h4 class="product-name">                                                                        
                                        <strong>Subtotal: $<span id="subtotal-membresia-{{$m->id}}">{{$m->subtotal}}</span></strong></h4>  

                                </div>     

                                <div class="col-xs-8">

                                    @if($m->id!=0)
                                    <button type="button" onclick="addMembresia({{$m->id}}, 0)" class="btn btn-default" style="padding: 5px 15px;border-radius: 5px;
                                            font-size: 10px;">-</button>
                                    <span  id="cantidad-membresia-{{$m->id}}">{{$m->cantidad}}</span>
                                    <button type="button"   onclick="addMembresia({{$m->id}}, 1)" class="btn btn-default" style="padding: 5px 15px;border-radius: 5px;
                                            font-size: 10px;">+</button>
                                    @endif

                                </div>

                            </div>
                        </div>
                    </div>
                    @endforeach

                    <hr>

                    <hr>
                </div>
                <div class="panel-footer">
                    <div class="row text-center">
                        <div class="col-xs-6">
                            <h4 class="text-right">Total $<strong id="total_membresia">{{$total}}</strong></h4>
                        </div>
                        <div class="col-xs-6">
                            <button type="button"  onclick="showModalPago()"class="btn btn-success btn-block next-step">
                                Pagar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{!!$modal!!}

<input type="hidden" name="tipo_producto" id="tipo_producto" value="{{$tipo_producto}}">
@if($tipo_producto==1)
<input type="hidden" name="concepto" id="concepto" value="Compra actividad">

@else
<input type="hidden" name="concepto" id="concepto" value="Compra membresia">
@endif

@if(isset($script))
<script src="{{ URL::to(config('admin.config.public')).'/app/js/ventas.js' }}"></script>
@endif

