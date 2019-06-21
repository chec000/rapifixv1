@if($tipo_servicio==2)
<div id="membresia-{{$actividad->id}}" style="    min-height: 217px;" class="row">
    <div class="col-xs-6" >    
        <h4 class="product-name"><strong>{{$actividad->nombre}}</strong></h4><h4><small>{{$actividad->nombre}}</small></h4>
        <div class="col-sm-12">
            <div class="thumbnail">
                <img class="img-responsive" src="{{$actividad->foto}}">  
                <div class="caption">
                    <h6>Precio: {{$actividad->precio}}</h6>                                              
                </div>
            </div>
        </div>
    </div>
    <div class="col-xs-6">                                                                                                                                                         
        <h4 class="product-name">                                                                        
            <strong>Subtotal: $<span id="subtotal-membresia-{{$actividad->id}}">{{$actividad->subtotal}}</span><span class="text-muted">x</span></strong></h4>                                    
        <div class="col-xs-12">
            <button type="button" onclick="addMembresia({{$actividad->id}}, 0)" class="btn btn-default" style="padding: 5px 15px;border-radius: 5px;
                    font-size: 10px;">-</button>
            <span  id="cantidad-membresia-{{$actividad->id}}">{{$actividad->cantidad}}</span>
            <button type="button"   onclick="addMembresia({{$actividad->id}}, 1)" class="btn btn-default" style="padding: 5px 15px;border-radius: 5px;
                    font-size: 10px;">+</button>
        </div>
    </div>

</div>

@else
<div id="membresia-{{$membresia->id}}" style="    min-height: 217px;" class="row">
    <div class="col-xs-6" >    
        <h4 class="product-name"><strong>{{$membresia->nombre}}</strong></h4><h4><small>{{$membresia->nombre}}</small></h4>
        <div class="col-sm-12">
            <div class="thumbnail">
                <img class="img-responsive" src="{{$membresia->imagen}}">  
                <div class="caption">
                    <h6>Precio: {{$membresia->precio}}</h6>                                              
                </div>
            </div>
        </div>
    </div>
    <div class="col-xs-6">                                                                                                                                                         
        <h4 class="product-name">                                                                        
            <strong>Subtotal: $<span id="subtotal-membresia-{{$membresia->id}}">{{$membresia->subtotal}}</span><span class="text-muted">x</span></strong></h4>                                    
        <div class="col-xs-12">
            <button type="button" onclick="addMembresia({{$membresia->id}}, 0)" class="btn btn-default" style="padding: 5px 15px;border-radius: 5px;
                    font-size: 10px;">-</button>
            <span  id="cantidad-membresia-{{$membresia->id}}">{{$membresia->cantidad}}</span>
            <button type="button"   onclick="addMembresia({{$membresia->id}}, 1)" class="btn btn-default" style="padding: 5px 15px;border-radius: 5px;
                    font-size: 10px;">+</button>
        </div>
    </div>
</div>

@endif