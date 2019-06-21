
<div>
    <button class="btn btn-succcess" onclick="openNav()"> Carrito</button>
</div>

{!!$actividades!!}

{!!$venta_aside!!}

<script>
 function agregarDeportes(id, cantidad) {
                        var request = $.ajax({
                            url: route('admin.Cliente.add_membresia'),
                            data: {id_membresia: id, cantidad: cantidad,tipo_servicio:2},
                            type: 'POST',
                            dataType: 'json',
                        });
                        return request;
                    }
function detalleVenta(){   
 window.location.href="{!! route('admin.venta.cliente_checkout_actividad'); !!}";
}

             function agregarDeportes(id, nombre) {
                        saveDeporte(id, 1).done(function (data) {
                            openNav();
                            if (data.code == 100) {
                                var m = $("#list_membresias");
                                m.append(data.data);
                            }
                        });
                    }

      function saveDeporte(id, cantidad) {
                        var request = $.ajax({
                            url: route('admin.Cliente.add_membresia'),
                            data: {id_actividad: id, cantidad: cantidad,tipo_servicio:2},
                            type: 'POST',
                            dataType: 'json',
                        });
                        return request;
                    }

</script>