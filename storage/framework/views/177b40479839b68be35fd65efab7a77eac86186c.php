<head>
  <title> Report</title>  
<style type="text/css">
  html {
  font-family:arial;
  font-size: 18px;
}
.bold{
  font-weight: bold;
}
td {
  border: 1px solid #726E6D;
  padding: 15px;
}

thead{
  font-weight:bold;
  text-align:center;
  background: #44b197;
  color:white;
  border: 1px solid #726E6D;
}

table {
  border-collapse: collapse;
}

footer {
position: absolute;
    bottom: 0;
    width: 100%;
    height: 100px;
    color: #060606;
}

  
</style>
</head>
<body>

  <div class="row">
    <div  style="max-width: 33%;display: inline-block;">
<img  src="<?php echo e(asset('cms/app/img/logo.png')); ?>"  style="height: 60px;">
    </div>
<div style="max-width: 33%;display: inline-block;background-color: #f2f5ff;;text-align: center;border-radius: 3px;">
    <h4><span style="text-align: center;">RAPIFIX</span>  </h4>
     Carretera Federico Basilis, Buena Vista. Jarabacoa, al lado de la Bomba Isla R. D  
</div>    
 <div style="max-width: 33%;display: inline-block;">
  <div><p style="font-weight: bold;text-decoration: underline;">Presupuesto</p>
    <p>Número: <span style="font-weight: bold;">P1-<?php echo date('Y'); ?></span></p>
    <p>Fecha: <span style="font-weight: bold;"><?php echo date('d-m-Y'); ?></span></p>
  </div>
</div>    
  </div>

<div id="cliente"  style="background-color: #dee7fd;">
  <div id="usuario">
   <span>Nombre:</span><span  class="bold"><?php echo e($data['nombre']); ?> </span>
  </div>
  <div id="Apellidos">
   <span>Apellidos: </span> <span  class="bold"><?php echo e($data['apellidos']); ?></span>
  </div>
  <div id="celular"><span>Teléfono celular:</span> <span class="bold">
    <?php echo e($data['celular']); ?>

  </span></div>
  <div id="telefono"><span>Telefono de casa:</span> <span  class="bold">
    <?php echo e($data['telefono']); ?>

  </span></div>
  <div id="ciudad"><span>Ciudad:</span> <span  class="bold"><?php echo e($data['ciudad']); ?></span></div>
  <div>
    <span>Comentario: </span><span  class="bold"><?php echo e($data['comentario']); ?></span>
  </div>  
</div>
<div>
  <p>Lista de productos</p>
</div>
<hr>

  <table>
    <thead>
        <tr>
                <th>#</th>
                <th>Código producto</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Precio</th>
                <th>Cantidad</th>
                <th>Subtotal</th>
              </tr>      
    </thead>
    <tbody>

 <?php $var =1 ?>
          <?php $__currentLoopData = $cart['items']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <tr>
                <td><?php echo e($var); ?></td>
                <td><?php echo e($p['sku']); ?></td>
                <td><?php echo e($p['name']); ?></td>
                <td><?php echo e($p['description']); ?></td>
                <td>$<?php echo e($p['price']); ?></td>
                <td><?php echo e($p['quantity']); ?></td>
                <td>$<?php echo e($p['price']*$p['quantity']); ?></td>
              </tr>
              <?php $var =$var+1 ?>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    </tbody>
    <tfoot>
      <tr>
        <td colspan="4" class="footer">Total</td>        
        <td colspan="3">$<?php echo e($subTotal); ?></td>
      </tr>
    </tfoot>
  </table>

<footer>
<hr style="border-top: 2px solid black;">     
        <div class="container">
          <p>Copyright &copy; 2019 Rapyfix</p>
          <p>Tel: 809-574-4343 y 809-574-7938 Cel: (Whtasapp): 829-931-0141</p>
        </div>          
</footer>

</body>