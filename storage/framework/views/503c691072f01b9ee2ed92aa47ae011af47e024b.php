   <div class="container well">
             <button class="btn btn-success">
                        <a style="color:black" href="<?php echo e(route('admin.venta.venta')); ?>">
                            <i class="fa fa-undo"></i>
                            Regresar</a>
                    </button>
            <div class="row">
                <div class="receipt-main panel">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md6">
                                <div class="receipt-left">
                                    <img class="img-responsive" alt="iamgurdeeposahan" src="<?php echo e(URL::to(config('admin.config.public'))); ?>/app/img/logo.png" style="width: 71px; border-radius: 43px;">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="receipt-header receipt-header-mid">
                            <div class="col-xs-8 col-sm-8 col-md-8 text-left">
                                <div class="receipt-right">
                                    <h5>Nombre del cliente <small>  <?php echo e($venta->usuario->name.' '.$venta->usuario->apellido_paterno.' '.$venta->usuario->apellido_materno); ?></small></h5>
                                    <p><b>Telefono :</b> <?php echo e($venta->usuario->telefono); ?></p>
                                        <p><b>Telefono :</b> <?php echo e($venta->usuario->telefono_celular); ?></p>
                                    <p><b>Email :</b> <?php echo e($venta->usuario->email); ?></p>
                                    <p><b>Address :</b>  <?php echo e($venta->usuario->direccion); ?></p>
                                </div>
                            </div>
                            <div class="col-xs-4 col-sm-4 col-md-4">
                                <div class="receipt-left">
                                    <h1>Factura</h1>
                                </div>
                            </div>
                        </div>
                    </div>

           <table class="table table-striped table-bordered table-hover table-condensed">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Cantidad</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>                                
                            <?php $__currentLoopData = $venta->detalleVenta; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td ><?php echo e($m->producto); ?></td>
                                <td ><?php echo e($m->cantidad); ?></td>
                                <td > <?php echo e($m->subtotal); ?></td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>                                                                                    

                        </tbody>
                    </table>
                    

                    
                    
                    <div class="row">
                        <div class="col-md-6">
                            <h1>
                                 <strong>Total: </strong>  <strong>$<?php echo e($venta->total); ?></strong>
                            </h1>  
                        </div>
                  
                    </div>
                    
                    <div class="row">
                        <div class="">
                            <div class="col-xs-8 col-sm-8 col-md-8 text-left">
                                <div class="receipt-right">
                                    <p><b>Fecha :</b> <?php echo e($venta->fecha); ?> </p>
                                    <h5 style="color: rgb(140, 140, 140);">¡Gracias por su compra!</h5>
                                </div>
                            </div>
                            <div class="col-xs-4 col-sm-4 col-md-4">
                                <div class="receipt-left">
                             
                                </div>
                            </div>
                        </div>
                    </div>
                   
                    
                     <div class="row">
                         <div class="col-md-12">
                             <!--<iframe src="<?php echo e($venta->factura); ?>" style="width: 100%;height: 100%;border: none;"></iframe>-->
                                                     <embed src="<?php echo e($venta->factura); ?>"  type="application/pdf"   height="300px" width="100%" />
                         </div>                       
                      </div>

                </div>    
            </div>
        </div>