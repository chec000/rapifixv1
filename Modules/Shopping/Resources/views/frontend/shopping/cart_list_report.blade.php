<!DOCTYPE html>
<html>
<head>
  <title> </title>
    <link href="{{asset('cms/inicio/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">

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
          @foreach($cart['items'] as $p)
              <tr>
                <td>1</td>
                <td>{{$p['sku']}}</td>
                <td>{{$p['name']}}</td>
                <td>{{$p['description']}}</td>
                <td>{{$p['price']}}</td>
                <td>{{$p['quantity']}}</td>
                <td>${{$p['price']*$p['quantity']}}</td>
              </tr>
          @endforeach


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
            <span>${{$subTotal}}</span>
              
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

