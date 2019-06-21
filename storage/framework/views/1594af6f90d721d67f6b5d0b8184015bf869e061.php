<!doctype html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link href="<?php echo asset('/themes/omnilife2018/css/reporte.css'); ?>" rel="stylesheet">
        <title>Factura</title>
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="receipt-main">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md6">
                                <div class="receipt-left">
                                    <img class="img-responsive" alt="iamgurdeeposahan" src="<?php echo e(URL::to(config('admin.config.public'))); ?>/app/img/logo.png" style="width: 71px; border-radius: 43px;">
                                </div>
                            </div>
                            <div class="col-md-6 text-right">
                                <div class="receipt-right">
                                    <h5>Gym v1</h5>
                                    <p>+91 12345-6789 <i class="fa fa-phone"></i></p>
                                    <p>gym@gmail.com <i class="fa fa-envelope-o"></i></p>
                                    <p>México <i class="fa fa-location-arrow"></i></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="receipt-header receipt-header-mid">
                            <div class="col-xs-8 col-sm-8 col-md-8 text-left">
                                <div class="receipt-right">
                                    <h5>Nombre del cliente <small>  |   Lucky Number : 156</small></h5>
                                    <p><b>Mobile :</b> +91 12345-6789</p>
                                    <p><b>Email :</b> info@gmail.com</p>
                                    <p><b>Address :</b> Australia</p>
                                </div>
                            </div>
                            <div class="col-xs-4 col-sm-4 col-md-4">
                                <div class="receipt-left">
                                    <h1>Factura</h1>
                                </div>
                            </div>
                        </div>
                    </div>

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Cantidad</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>                                
                            <?php $__currentLoopData = $membresias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td ><?php echo e($m->nombre); ?></td>
                                <td ><?php echo e($m->cantidad); ?></td>
                                <td ></i> <?php echo e($m->subtotal); ?></td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>                                                                                    
<!--                            <tr>
                                <td class="text-right"><h2><strong>Total: </strong></h2></td>
                                <td class="text-left text-danger" ROWSPAN="2"><h2><strong> <?php echo e($total); ?></strong></h2></td>
                            </tr>-->
                        </tbody>
                    </table>
                    <div class="row">
                        <div class="col-md-6">
                            <strong>Total: </strong>
                        </div>
                          <div class="col-md-6">
                            <strong><?php echo e($total); ?>< </strong>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="">
                            <div class="col-xs-8 col-sm-8 col-md-8 text-left">
                                <div class="receipt-right">
                                    <p><b>Fecha :</b> <?php echo e($date); ?> </p>
                                    <h5 style="color: rgb(140, 140, 140);">¡Gracias por su compra!</h5>
                                </div>
                            </div>
                            <div class="col-xs-4 col-sm-4 col-md-4">
                                <div class="receipt-left">
                                    <h1>Gym S.A  de C.V</h1>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>    
            </div>
        </div>

    </body>
</html>
