
<div class="container">

    <div class="card" >
        <div class="card-body">
            <a href="{{route('admin.Gasto.add')}}" class="small-box-footer">Registrar compra <i class="fa fa-arrow-circle-right"></i></a>             
            <table class="table table-striped " id="tbl_table">
                <thead>
                    <tr>
                        <th scope="col">Código</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Descripción</th>
                        <th scope="col">Cantidad</th>
                        <th scope="col">Precio unitario</th>
                        <th scope="col">Total</th>                    
                        <th scope="col">Fecha compra</th>                       
                        <th scope="col">Fecha registro</th>


                    </tr>
                </thead>
                <tbody>
                    @if(count($gastos)>0)
                    @foreach ($gastos as $c)
                    <tr>
                        <td>{{$c->cod_producto}}</td>
                        <td>{{$c->nombre}}</td>
                        <td>{{$c->descripcion}}</td>
                        <td>{{$c->cantidad}}</td>
                        <td>${{$c->valor_costo}}</td>
                        <td>${{$c->valor_total}}</td>
                         <td>{{$c->fecha_compra}}</td>
                        <td>{{$c->created_at}}</td>                     


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

$('#tbl_table').DataTable({
    "responsive": true,
    "ordering": false,
    "language": {
        "url": "{{ trans('admin::datatables.lang') }}"
    }
});

    </script>
</div>

