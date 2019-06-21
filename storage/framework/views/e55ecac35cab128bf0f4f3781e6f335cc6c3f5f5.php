<?php if($tipo_servicio==2): ?>
<div id="membresia-<?php echo e($actividad->id); ?>" style="    min-height: 217px;" class="row">
    <div class="col-xs-6" >    
        <h4 class="product-name"><strong><?php echo e($actividad->nombre); ?></strong></h4><h4><small><?php echo e($actividad->nombre); ?></small></h4>
        <div class="col-sm-12">
            <div class="thumbnail">
                <img class="img-responsive" src="<?php echo e($actividad->foto); ?>">  
                <div class="caption">
                    <h6>Precio: <?php echo e($actividad->precio); ?></h6>                                              
                </div>
            </div>
        </div>
    </div>
    <div class="col-xs-6">                                                                                                                                                         
        <h4 class="product-name">                                                                        
            <strong>Subtotal: $<span id="subtotal-membresia-<?php echo e($actividad->id); ?>"><?php echo e($actividad->subtotal); ?></span><span class="text-muted">x</span></strong></h4>                                    
        <div class="col-xs-12">
            <button type="button" onclick="addMembresia(<?php echo e($actividad->id); ?>, 0)" class="btn btn-default" style="padding: 5px 15px;border-radius: 5px;
                    font-size: 10px;">-</button>
            <span  id="cantidad-membresia-<?php echo e($actividad->id); ?>"><?php echo e($actividad->cantidad); ?></span>
            <button type="button"   onclick="addMembresia(<?php echo e($actividad->id); ?>, 1)" class="btn btn-default" style="padding: 5px 15px;border-radius: 5px;
                    font-size: 10px;">+</button>
        </div>
    </div>

</div>

<?php else: ?>
<div id="membresia-<?php echo e($membresia->id); ?>" style="    min-height: 217px;" class="row">
    <div class="col-xs-6" >    
        <h4 class="product-name"><strong><?php echo e($membresia->nombre); ?></strong></h4><h4><small><?php echo e($membresia->nombre); ?></small></h4>
        <div class="col-sm-12">
            <div class="thumbnail">
                <img class="img-responsive" src="<?php echo e($membresia->imagen); ?>">  
                <div class="caption">
                    <h6>Precio: <?php echo e($membresia->precio); ?></h6>                                              
                </div>
            </div>
        </div>
    </div>
    <div class="col-xs-6">                                                                                                                                                         
        <h4 class="product-name">                                                                        
            <strong>Subtotal: $<span id="subtotal-membresia-<?php echo e($membresia->id); ?>"><?php echo e($membresia->subtotal); ?></span><span class="text-muted">x</span></strong></h4>                                    
        <div class="col-xs-12">
            <button type="button" onclick="addMembresia(<?php echo e($membresia->id); ?>, 0)" class="btn btn-default" style="padding: 5px 15px;border-radius: 5px;
                    font-size: 10px;">-</button>
            <span  id="cantidad-membresia-<?php echo e($membresia->id); ?>"><?php echo e($membresia->cantidad); ?></span>
            <button type="button"   onclick="addMembresia(<?php echo e($membresia->id); ?>, 1)" class="btn btn-default" style="padding: 5px 15px;border-radius: 5px;
                    font-size: 10px;">+</button>
        </div>
    </div>
</div>

<?php endif; ?>