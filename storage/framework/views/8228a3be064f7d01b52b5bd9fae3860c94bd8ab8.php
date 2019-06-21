
<div class="container">

    <div class="card" >
        <div class="card-body">
            <a href="<?php echo e(route('admin.client.add_cliente')); ?>" class="small-box-footer">Agregar cliente <i class="fa fa-arrow-circle-right"></i></a>             
            <table class="table table-striped " id="tbl_table">
                <thead>
                    <tr>
                      <th scope="col">Codigo de usuario</th>
                        <th scope="col">Foto</th>       
                         <th scope="col">Clave unica</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Apellidos</th>
                        <th scope="col">Telefono</th>
                        <th scope="col">Dirección</th>
                        <th scope="col">Fecha inscripción</th>
                        <th scope="col">Estado</th>
                        <th scope="col">Activo</th>
                        <th scope="col">Acciones</th>

                    </tr>
                </thead>
                <tbody>
                    <?php if(count($clientes)>0): ?>
                    <?php $__currentLoopData = $clientes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                      <td><?php echo e($c->codigo_cliente); ?></td>
                        <?php if($c->usuario!=null): ?>            
                        <td><img style="height: 100px" src="<?php echo e($c->usuario->foto); ?>"></td>
                        <td><?php echo e($c->usuario->clave_unica); ?></td>
                        <td><?php echo e($c->usuario->name); ?></td>                        
                        <td><?php echo e($c->usuario->apellido_paterno); ?></td>
                        <td><?php echo e($c->usuario->telefono); ?></td>
                        <td><?php echo e($c->usuario->direccion); ?></td>
                        <?php else: ?>
                        <td>NA</td>
                        <td>NA</td>
                        <td>NA</td>
                        <td>NA</td>
                        <td>NA</td>
                        <td>NA</td>
                        <td>NA</td>           
                        <?php endif; ?>
                        <td><?php echo e($c->fecha_inscripcion); ?></td>
                        <td><?php echo e($c->estado_cliente); ?></td>                     


                        <td><span id="status<?php echo e($c->id); ?>"  class="label  <?php echo e($c->activo ? 'label-success' : 'label-default'); ?> "><?php echo $c->activo== 0 ?  trans('admin::language.lang_list_st_inactive')  : trans('admin::language.lang_list_st_active'); ?></span></td>
                        <?php if($can_edit || $can_delete): ?>
                        <td data-lid="<?php echo $c->id; ?>">
                            <span onclick="activeDesactiveCliente(<?php echo e($c->id); ?>)" id='activeBrand<?php echo e($c->id); ?>' class="<?php echo e($c->activo ? '' : 'hide'); ?>">
                                <i class="glyphicon glyphicon-play itemTooltip  " title="<?php echo e(trans('admin::action.disable_action')); ?>" ></i>
                            </span>
                            <span onclick="activeDesactiveCliente(<?php echo e($c->id); ?>)" id='inactiveBrand<?php echo e($c->id); ?>' class="<?php echo e($c->activo ? 'hide' : ''); ?>">                                
                                <i class="glyphicon glyphicon-stop  itemTooltip "  title="<?php echo e(trans('admin::action.enable_action')); ?>"></i>                            
                            </span>                                              
                            <a class="glyphicon glyphicon-trash itemTooltip" href="<?php echo e(route('admin.client.delete_cliente', ['id' => $c->id])); ?>" title="<?php echo e(trans('admin::action.edit_action')); ?>"></a>
                            <a class="glyphicon glyphicon-pencil itemTooltip" href="<?php echo e(route('admin.client.edit_cliente', ['id' => $c->id])); ?>" title="<?php echo e(trans('admin::action.edit_action')); ?>"></a>
                        </td>
                        <?php endif; ?>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>  
                </tbody>
            </table>     
        </div>

    </div>
    <script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>

    <!--<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css" />-->
    <script src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
    <!--    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>-->
    <script type="text/javascript">
                                function activeDesactiveCliente (id){
                                $.ajax({
                                url: route('admin.client.activeInactive_cliente'),
                                        type: 'POST',
                                        data: {id: id},
                                        success: function (data) {
                                        console.log(data);
                                        let label = $("#status" + id);
                                        let iconActive = $("#activeBrand" + id);
                                        let iconInactive = $("#inactiveBrand" + id);
                                        if (data === "0") {
                                        iconActive.addClass('hide');
                                        iconInactive.removeClass('hide');
                                        label.removeClass('label-success').addClass('label-default');
                                        label.text("Inactivo");
                                        }
                                        else {
                                        iconActive.removeClass('hide');
                                        iconInactive.addClass('hide');
                                        label.removeClass('label-default').addClass('label-success');
                                        label.text("Activo");
                                        }
                                        }

                                });
                                }

                                $('#tbl_table').DataTable({
                                "responsive": true,
                                        "ordering": false,
                                        "language": {
                                        "url": "<?php echo e(trans('admin::datatables.lang')); ?>"
                                        }
                                });

    </script>
</div>

