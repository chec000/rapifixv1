{!!$actividades!!}

{!!$venta_aside!!}

<script>
 function saveMembresia(id, cantidad) {
                        var request = $.ajax({
                            url: route('admin.Cliente.add_membresia'),
                            data: {id_membresia: id, cantidad: cantidad},
                            type: 'POST',
                            dataType: 'json',
                        });
                        return request;
                    }


function detalleVenta(){   
 window.location.href="{!! route('admin.venta.cliente_checkout_membresia'); !!}";
}

             function agregarMembresia(id, nombre) {
                        saveMembresia(id, 1).done(function (data) {
                            openNav();
                            if (data.code == 100) {
                                var m = $("#list_membresias");
                                m.append(data.data);
                            }
                        });
                    }



</script>