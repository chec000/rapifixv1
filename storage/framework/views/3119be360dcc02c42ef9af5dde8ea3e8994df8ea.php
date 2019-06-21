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

        <?php if(count($ventas)>0): ?>
        <?php $__currentLoopData = $ventas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>                     
        <?php if($v->usuario!=null): ?>
        <tr>
            <td>
                <?php echo e($v->usuario->name.' '.$v->usuario->apellido_paterno); ?>                                                      
            </td>
            <td><?php echo e($v->seller->name); ?></td>
            <td><?php echo e($v->concepto); ?></td>                         
             <td><?php echo e($v->fecha); ?></td>   
            <td><?php echo e($v->tipo_pago); ?></td>
            <td>$<?php echo e($v->total); ?></td>
             <td><strong><a href="<?php echo e($v-> factura); ?>" target="_BLANK"><?php echo e($v->codigo_factura); ?></a></strong></td>                            
            <td>                                                     
                <a class="fa fa-eye" href="<?php echo e(route('admin.venta.detalle', ['id' => $v->id])); ?>" title="<?php echo e(trans('admin::action.edit_action')); ?>"></a>
            </td>          
        </tr>  
        <?php endif; ?>

        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>                       
    </tbody>
</table>