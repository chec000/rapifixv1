<?php if(count($membresias)>0): ?>
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


        <?php $__currentLoopData = $membresias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>      
        <tr>
            <?php if($m->nombre_membresia!="Inscripción"): ?>
            <th scope="row"><?php echo e($m->id); ?></th>
            <td><?php echo e($m->nombre_membresia); ?></td>
            <td>$<?php echo e($m->precio); ?></td>

            <td><?php echo e($m->fecha_compra); ?></td>
            <td><?php echo e($m->fecha_proximo_pago); ?></td>
            <td><?php echo e(($m->fecha_proximo_pago>$m->fecha_compra)?'Al dia':'Atrasado'); ?></td>

            <td data-lid="<?php echo $m->id; ?>">
                <span id="renovar(<?php echo e($m->id); ?>)" >
                    <button class="btn btn-success" onclick="removarMembresia('<?php echo e($m->nombre_membresia); ?>',<?php echo e($m->precio); ?>,<?php echo e($m->membresia_id); ?>,<?php echo e($m->id); ?>)">
                        <i class="glyphicon glyphicon-play itemTooltip  " title="Renovar membresia" ></i>
                    </button>
                </span>

            </td>

            <?php endif; ?>

        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


    </tbody>
</table>  
<?php endif; ?>

