<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <div class="panel-title">
                        <div class="row">
                            <div class="col-xs-6">
                                <h5><span class="glyphicon glyphicon-shopping-cart"></span> Shopping Cart</h5>
                            </div>
                            <div class="col-xs-6">
                                <button type="button" class="btn btn-default prev-step">
                                    <span class="glyphicon glyphicon-share-alt"></span> Continue shopping
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel-body">                    
                    <?php $__currentLoopData = $membresias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="row list-group-item">
                        <div class="col-xs-2"><img class="img-responsive" src="<?php echo e($m->imagen); ?>">
                        </div>
                        <div class="col-xs-4">
                            <h4 class="product-name"><strong><?php echo e($m->nombre); ?></strong></h4><h4><small><?php echo e($m->descripcion); ?></small></h4>
                        </div>
                        <div class="col-xs-6">
                            <div class="col-xs-4 text-right">
                                <h6>Precio: <strong>$<?php echo e($m->precio); ?> </strong></h6>
                            </div>
                            <div class="col-xs-8">       
                                <div class="col-xs-4">
                                    <h4 class="product-name">                                                                        
                                        <strong>Subtotal: $<span id="subtotal-membresia-<?php echo e($m->id); ?>"><?php echo e($m->subtotal); ?></span></strong></h4>  

                                </div>     

                                <div class="col-xs-8">

                                    <?php if($m->id!=0): ?>
                                    <button type="button" onclick="addMembresia(<?php echo e($m->id); ?>, 0)" class="btn btn-default" style="padding: 5px 15px;border-radius: 5px;
                                            font-size: 10px;">-</button>
                                    <span  id="cantidad-membresia-<?php echo e($m->id); ?>"><?php echo e($m->cantidad); ?></span>
                                    <button type="button"   onclick="addMembresia(<?php echo e($m->id); ?>, 1)" class="btn btn-default" style="padding: 5px 15px;border-radius: 5px;
                                            font-size: 10px;">+</button>
                                    <?php endif; ?>

                                </div>

                            </div>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    <hr>

                    <hr>
                </div>
                <div class="panel-footer">
                    <div class="row text-center">
                        <div class="col-xs-6">
                            <h4 class="text-right">Total $<strong id="total_membresia"><?php echo e($total); ?></strong></h4>
                        </div>
                        <div class="col-xs-6">
                            <button type="button"  onclick="showModalPago()"class="btn btn-success btn-block next-step">
                                Pagar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php echo $modal; ?>


<input type="hidden" name="tipo_producto" id="tipo_producto" value="<?php echo e($tipo_producto); ?>">
<?php if($tipo_producto==1): ?>
<input type="hidden" name="concepto" id="concepto" value="Compra actividad">

<?php else: ?>
<input type="hidden" name="concepto" id="concepto" value="Compra membresia">
<?php endif; ?>

<?php if(isset($script)): ?>
<script src="<?php echo e(URL::to(config('admin.config.public')).'/app/js/ventas.js'); ?>"></script>
<?php endif; ?>

