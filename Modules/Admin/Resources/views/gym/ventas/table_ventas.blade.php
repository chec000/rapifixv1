<table class="table table-hover" id="tbl_table">
    <thead>
        <tr>
            <th>Cliente</th>
            <th>Vendedor</th>
            <th>Concepto</th>
            <th>Fecha</th>
            <th>Tipo pago</th>
            <th>Total</th>
              <th>Factura</th>
            <th>Detalle</th>
        </tr>
    </thead>
    <tbody>

        @if(count($ventas)>0)
        @foreach($ventas as $v)                     
        @if($v->usuario!=null)
        <tr>
            <td>
                {{$v->usuario->name.' '.$v->usuario->apellido_paterno}}                                                      
            </td>
            <td>{{$v->seller->name}}</td>
            <td>{{$v->concepto}}</td>                         
             <td>{{$v->fecha}}</td>   
            <td>{{$v->tipo_pago}}</td>
            <td>${{$v->total}}</td>
             <td><strong><a href="{{$v-> factura}}" target="_BLANK">{{$v->codigo_factura}}</a></strong></td>                            
            <td>                                                     
                <a class="fa fa-eye" href="{{ route('admin.venta.detalle', ['id' => $v->id]) }}" title="{{ trans('admin::action.edit_action') }}"></a>
            </td>          
        </tr>  
        @endif

        @endforeach
        @endif                       
    </tbody>
</table>