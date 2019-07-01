<!DOCTYPE html>
<html>
<head>
  <title> </title>
    <link href="<?php echo e(asset('cms/inicio/css/bootstrap.min.css')); ?>" rel="stylesheet" type="text/css">

</head>
<body>
<div class="container">
    <h1>Lista de productos </h1>
      <div class="row">    
      <div class="col-md-12">
        <div class="card">
          <div class="card-header bg-success">
            <h3 class="card-title">Productos agregados al carrito
            </h3>
          </div>
          <div class="card-body">          
          <table class="table table-bordered" id="task-table">
            <thead>
              <tr>
                <th>#</th>
                <th>Código producto</th>
                <th>Nombre</th>
                <th>Descripcion</th>
                <th>Precio</th>
                <th>Cantidad</th>
                <th>Subtotal</th>
              </tr>
            </thead>
            <tbody>
          <?php $__currentLoopData = $cart['items']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <tr>
                <td>1</td>
                <td><?php echo e($p['sku']); ?></td>
                <td><?php echo e($p['name']); ?></td>
                <td><?php echo e($p['description']); ?></td>
                <td><?php echo e($p['price']); ?></td>
                <td><?php echo e($p['quantity']); ?></td>
                <td>$<?php echo e($p['price']*$p['quantity']); ?></td>
              </tr>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


            </tbody>
         
          </table>
        <div class="row">
          
          <div class="col-md-4"></div>
          <div class="col-md-4"></div>
          <div class="col-md-4">
           <div class="row">
            <div class="col-md-6">
              <span>Total</span>
            </div>
            <div class="col-md-6">
            <span>$<?php echo e($subTotal); ?></span>
              
            </div> 
           </div>
          </div>
        </div>

          </div>

        </div>
      </div>
    </div>
  </div>
</body>
</html>

