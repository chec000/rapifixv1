@if(count($membresias)>0)
<table class="table table-hover" id="tbl_membresia">
    <thead>
        <tr>
            <th scope="col">id</th>
            <th scope="col">Nombre</th>
            <th scope="col">Precio</th>
            <th scope="col">Fecha compra</th>
            <th scope="col">Fecha limite membresia</th>
            <th scope="col">Estatus</th>

            <th scope="col">Renovar</th>
        </tr>
    </thead>
    <tbody>   


        @foreach ($membresias as $m)      
        <tr>
            @if($m->nombre_membresia!="Inscripción")
            <th scope="row">{{$m->id}}</th>
            <td>{{$m->nombre_membresia}}</td>
            <td>${{$m->precio}}</td>

            <td>{{$m->fecha_compra}}</td>
            <td>{{$m->fecha_proximo_pago}}</td>
            <td>{{($m->fecha_proximo_pago>$m->fecha_compra)?'Al dia':'Atrasado'}}</td>

            <td data-lid="{!! $m->id !!}">
                <span id="renovar({{$m->id}})" >
                    <button class="btn btn-success" onclick="removarMembresia('{{$m->nombre_membresia}}',{{$m->precio}},{{$m->membresia_id}},{{$m->id}})">
                        <i class="glyphicon glyphicon-play itemTooltip  " title="Renovar membresia" ></i>
                    </button>
                </span>

            </td>

            @endif

        </tr>
        @endforeach


    </tbody>
</table>  
@endif

