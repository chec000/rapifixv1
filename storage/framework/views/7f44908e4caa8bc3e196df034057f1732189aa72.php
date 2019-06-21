<div class="container">
    <div class="row ">
        <div class="col-md-12">
            <h2>Buscar cliente</h2>
            <div class="row">
                <div class="col-md-6">
                    <div id="custom-search-input">
                        <div class="input-group">
                            <!--<input type="text" class="  search-query form-control" placeholder="Buscar" id="cliente"  onkeyup = "if(event.keyCode == 13) searchCustomer()" />-->
                                                       <input type="text" class="  search-query form-control" placeholder="Buscar" id="cliente" />
                                                               <div id="clienteList">
                                                                </div> 
                            <span class="input-group-btn">
                                <button class="btn btn-danger" type="button" onclick="searchCustomer()">
                                    <span class=" glyphicon glyphicon-search"></span>
                                </button>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <button class="btn btn-success" type="button">
                        <a style="color:white" href="<?php echo e(route('admin.Cliente.add_cliente')); ?>">
                            <i class="fa fa-undo"></i>
                            Nuevo cliente</a>
                    </button>
                </div>
            </div>

            <br>
            <div class="panel panel-info ">
                <div class="panel-heading"><?php echo e(__('Registrar venta')); ?>

                    <button class="btn btn-success">
                        <a style="color:white" href="<?php echo e(route('admin.Deporte.list_deportes')); ?>">
                            <i class="fa fa-undo"></i>
                            Regresar</a>
                    </button>
                </div>
                <div class="panel-body">
                    <div id="productos_venta" style="display: none">
                    <a class="btn btn-success" id="add_membresia_cliente"  href="<?php echo e(route('admin.Cliente.edit_cliente', ['id' => 1])); ?>" title="<?php echo e(trans('admin::action.edit_action')); ?>">Membresia</a>
                    <a class="btn btn-success" id="add_actividad_cliente" href="<?php echo e(route('admin.Cliente.edit_cliente', ['id' => 3])); ?>" title="<?php echo e(trans('admin::action.edit_action')); ?>">Actividad</a>                                                       
                                           
                    </div>

                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                                             <div class="form-group row">
                        <label for="name" class="col-md-4 col-form-label text-md-right"><?php echo e(__('Cliente')); ?></label>
                        <input type="hidden" name="id_cliente" id="id_cliente">
                        <div class="col-md-6">
                            <input id="name"  disabled type="text" class="form-control<?php echo e($errors->has('name') ? ' is-invalid' : ''); ?>" name="name" value="<?php echo e(old('name')); ?>" required autofocus>
                            <?php if($errors->has('name')): ?>
                            <span class="invalid-feedback" role="alert">
                                <strong><?php echo e($errors->first('name')); ?></strong>
                            </span>
                            <?php endif; ?>
                        </div>
                    </div>

                </div>
                         
                        <div class="col-md-6">
                        <div id="membresias-compradas"></div>
                        
                        
                    </div>       
                            
                        </div>
            

                    </div>
   

            </div>
        </div>
    </div>


</div>
<?php echo $modal; ?>



<div class="modal fade" id="success" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal-header-success">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h1 style="color: white!important;"><i  style="color: white!important;" class="glyphicon glyphicon-thumbs-up"></i> Mensaje</h1>
            </div>
            <div class="modal-body">
                <div id="mensaje_final"></div>

                <h1 id="pago_realizado"><span id="mensaje">Su pago fue de: $</span> <span id="cantidad_pagar"></span></h1>
                <h1 id="restante"><span >Restante: $</span> <span id="cantidad_restante"></span></h1>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal" onclick="reload()">Cerrar</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
 <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
 $(document).ready(function(){

 $('#cliente').keyup(function(){ 
        var query = $(this).val();
        if(query != '')
        {
         var _token = $('input[name="_token"]').val();
         $.ajax({
          url:"<?php echo e(route('admin.Cliente.getListClientes')); ?>",
          method:"POST",
          data:{campo:query, _token:_token},
          success:function(data){
           $('#clienteList').fadeIn();  
                    $('#clienteList').html(data);
          }
         });
        }
    });

    $(document).on('click', 'li', function(){  
        $('#cliente').val($(this).text());     
        var cliente=$(this);
       $('#clienteList').fadeOut();
        searchCustomer( cliente[0].dataset.key);
    });  

});
 

     var tipo_pago = "";
     var id_membresia;
     var id_cliente_membresia;
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
    
    
function removarMembresia(nombre,precio,membresia_id,cliente_membresia){    
    $("#nombre_membresia").text(nombre);
    $("#precio_membresia").text(precio);
        id_membresia=membresia_id;
        id_cliente_membresia=cliente_membresia;
    $("#primary").modal("show");
}

function actualizarMembresia(){
    $('.loader').addClass("show");
    let id_cliente=$("#id_cliente").val();
    let pago_cliente=$("#pago_cliente").val();
    if(id_membresia>0){
         $.ajax({
                url: route('admin.venta.addPago'),
                type: 'POST',
                data: {cliente_id: id_cliente,membresia_id:id_membresia,cliente_membresia:id_cliente_membresia,tipo_pago:tipo_pago,pago_cliente:pago_cliente},
                success: function (data) {
                $("#primary").modal("hide");
                $('.loader').removeClass("show");
                                    $("#cantidad_pagar").text(data.total);
                                    $("#cantidad_restante").text(data.diferencia);                                  
                                    $("#mensaje_final").append("<span class='label label-success'>" + data.data + "</span>");                                                             
                                 $("#success").modal('show');
                                    
                }
                
            });        
    }
}



    function searchCustomer(id=0) {
     var isId=false;
        if(id===0){
                var cliente = $('#cliente').val();
                isId=true;
    }else{
        cliente=id;
    }
        if (cliente !== "") {
            $.ajax({
                url: route('admin.Cliente.getClienteByName'),
                type: 'POST',
                data: {cliente: cliente,isId:isId},
                success: function (data) {
             if(data.code===200){
                 $("#productos_venta").css('display','block');
                 $("#add_membresia_cliente").attr('href',data.url_membresia);
                  $("#add_actividad_cliente").attr('href',data.url_add_actividad);
                 $("#id_cliente").val(data.data.id);
                 $("#name").val(data.data.name+" "+data.data.apellido_paterno);
                 $("#membresias-compradas").empty();  
                 $("#membresias-compradas").append(data.membresias_actuales);
        }
                }

            });
        }

    }
</script>









