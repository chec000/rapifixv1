<head>
  <title> Report</title>  
<link href="{{asset('cms/inicio/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
<style type="text/css">
  footer {
  width: 100%;
  height: 200px;
  border-top: 2px solid #000;
  position: absolute;
  bottom: 0;
}
</style>
</head>
<body>
<br>
<div class="container">
  <div class="row">
    <div class="col-md-4">
    <img src="{{asset('cms/app/img/logo.png')}}" class="img-fluid" />
    </div>
<div class="col-md-4">
    <h5><span style="text-align: center;">RAPIFIX</span>  </h5>
    <p> Carretera Federico Basilis, Buena Vista. Jarabacoa, al lado de la Bomba Isla R. D</p>  
</div>    
 <div class="col-md-4">
  <p style="font-weight: bold;font-size: 20px">Presupuesto</p>
    <p>Número: <span style="font-weight: bold;">P1-<?php echo date('Y'); ?></span></p>
    <p>Fecha: <span style="font-weight: bold;"><?php echo date('d-m-Y'); ?></span></p>
  </div>
</div>    
<div class="row alert-success">
  <div class="alert" role="alert">
  <h5>Productos agregados a la cesta</h5>
</div>
</div>
<hr style="border-color: black;">
  <div class="row">
    <div class="col-md-12">
        <table class="table table-striped table-bordered">
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

 <?php $var =1 ?>
          @foreach($cart['items'] as $p)
              <tr>
                <td>{{$var}}</td>
                <td>{{$p['sku']}}</td>
                <td>{{$p['name']}}</td>
                <td>{{$p['description']}}</td>
                <td>${{$p['price']}}</td>
                <td>{{$p['quantity']}}</td>
                <td>${{$p['price']*$p['quantity']}}</td>
              </tr>
              <?php $var =$var+1 ?>
          @endforeach

    </tbody>
      
    
  </table>
   <div class="row">
     <div class="col-md-4"></div>
         <div class="col-md-4"></div>
         <div class="col-md-4">
            <span style="font-size: 21px;font-weight: bold;">Total:</span><span style="font-size: 21px;" class="badge badge-success">  ${{$subTotal}}</span>                      
         </div>    
      
    
   </div>
    </div>
  </div>


</div>
  

<footer>

        <div class="container">
          <p>Copyright &copy; 2019 Rapyfix</p>
          <p>Tel: 809-574-4343 y 809-574-7938 Cel: (Whtasapp): 829-931-0141</p>
        </div>          
</footer>

</body>

</html>