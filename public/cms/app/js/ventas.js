   var tipo_pago = "";
                    
function addMembresia(id_membresia, tipo) {
    $.ajax({
    url: route('admin.Cliente.add_less_membresia'),
            type: 'POST',
            data: {id_membresia: id_membresia, tipo:tipo},
            success: function (data) {
            $("#total_membresia").text(data.total_pagar);
            $("#cantidad-membresia-" + id_membresia).text(data.cantidad);
            $("#subtotal-membresia-" + id_membresia).text(data.subtotal);
            }

    });
    }
            function showModalPago() {
                        var total_cliente = $("#total_membresia").text();
                        $("#total_pagar_cliente").text(total_cliente);
                        $("#primary").modal('show');
                    }
                    
         function  realizarPago(tipo) {
                        var concepto=$("#concepto").val();
                        var tipo_transaccion=2;
                        $('.loader').addClass("show");
                        if (tipo_pago === "efectivo") {
                            var pago_cliente = $("#pago_cliente").val();
                        } else {
                            pago_cliente = 0;
                        }

                        if (tipo_pago === "efectivo") {
                            if (pago_cliente > 0) {
                                finalizarCheckout(tipo_pago, pago_cliente,tipo_transaccion,concepto);
                            }
                        } else {
                            finalizarCheckout(tipo_pago, pago_cliente,tipo_transaccion,concepto);
                        }
                    }
                     
    
    function tipoPago(tipo, element) {
                        tipo_pago = tipo;
                        var tarjetas = $('.searchable-container').find('label');
                        if (element.id === "pago_efectivo") {
                            $("#pago_con_efectivo").css('display', 'block');
                        } else {
                            $("#pago_con_efectivo").css('display', 'none');
                        }
                        $.each(tarjetas, function (index, value) {
                            if (value.id !== element.id) {
                                value.classList.remove('active');
                            }
                        });
                    }
                    
                    
               function finalizarCheckout(tipo_pago, pago_cliente,transaccion,concepto){
                   var tipo_producto=$("#tipo_producto").val();       
                   $.ajax({
                            url: route('admin.Cliente.finalizar_compra'),
                            data: {tipo_producto:tipo_producto,tipo_pago: tipo_pago, pago_cliente: pago_cliente,tipo_venta:transaccion,concepto:concepto},                 
                            type: 'POST',
                            dataType: 'json',
                            success: function (data) {
                                   var mensajes = $("#cmsDefaultNotification");
                                $('.loader').removeClass("show");
                                $('#primary').modal('hide');
                                if(data.tipo_venta==2){
                                     mensajes.css('display', 'block');
                                    mensajes.addClass('panel panel-success');
                                      $("#success").modal('show');
                                    $("#cantidad_pagar").text(data.total);
                                    $("#cantidad_restante").text(data.diferencia);                                  
                                    $("#mensaje_final").append("<span class='label label-success'>" + data.data + "</span>");
                                    mensajes.append("  <h1>" + data.data + "</h1>");
                                }else{
                             
                                if (data.code == 200) {
                                    mensajes.css('display', 'block');
                                    mensajes.addClass('panel panel-success');
                                      $("#success").modal('show');
                                    $("#cantidad_pagar").text(data.total);
                                    $("#cantidad_restante").text(data.diferencia);                                  
                                    $("#mensaje_final").append("<span class='label label-success'>" + data.data + "</span>");
                                    mensajes.append("  <h1>" + data.data + "</h1>");

                                } else {
                                    mensajes.append("  <span class='label label-success'>" + data.data + "</span>");
                                } 
                                }
                            
       
                            },
                            error: function (data) {
                                $('.loader').removeClass("show");
                                $('#primary').modal('hide');

                                scrollTop();
                            }
                        });
                    }
                    
                    function scrollTop() {
                        $('html, body').animate({scrollTop: 0}, 800);
                    }
                    function reload(){
                    location.reload();
                    }