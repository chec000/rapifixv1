                 <div class="panel panel-info">
                            <div class="panel-heading"><?php echo e(__('Asignar  Membresias')); ?></div>
                            <div class="panel-body">                                   
                                <div class="row">
                                    <?php $__currentLoopData = $membresias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>        
                                    <div class="col-sm-6 col-md-4">
                                        <div class="thumbnail">
                                            <a href="<?php echo e(route('admin.Membresia.detail-membresia',['id'=>$m->id])); ?>">
                                                                                        <img src="<?php echo e($m->imagen); ?>" alt="<?php echo e($m->nombre); ?>">
    
                                                </a>
                                            
                                            <div class="caption">
                                                <h1>Precio $ <?php echo e($m->precio); ?></h1>
                                                <h3><?php echo e($m->nombre); ?></h3>
                                                <p><a href="<?php echo e(route('admin.Membresia.detail-membresia',['id'=>$m->id])); ?>"><?php echo e(str_limit($m->descripcion, $limit = 30, $end = '...')); ?></a></p>
                                                <!--<button type="button" onclick="openNav()" class="btn btn-lg btn-block btn-outline-primary">Seleccionar</button>-->
                                                <button type="button" onclick="agregarMembresia(<?php echo e($m->id); ?>,'<?php echo e($m->nombre); ?>',<?php echo e($m->precio); ?>)" class="btn btn-lg btn-block btn-outline-primary">Seleccionar</button>
                                            </div>
                                        </div>
                                    </div>                     
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>         
                                </div>                           
                            </div>
                        </div>   