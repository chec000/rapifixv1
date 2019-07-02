<!DOCTYPE html>
<html>
<head>
  <title>Compras </title>    
<style type="text/css">
body{
      margin: 0;
    font-family: -apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol","Noto Color Emoji";
    font-size: 1rem;
    font-weight: 400;
    line-height: 1.5;
    color: #212529;
    text-align: left;
    background-color: #fff;
}
@media (min-width: 768px)
{
.col-md-12 {
    -ms-flex: 0 0 100%;
    flex: 0 0 100%;
    max-width: 100%;
}
}
@media (min-width: 992px){
.container {
    max-width: 960px;
}  
}
.table-bordered td, .table-bordered th {
    border: 1px solid #dee2e6;
}
.table td, .table th {
    padding: .75rem;
    vertical-align: top;
    border-top: 1px solid #dee2e6;
}

  .row {
    display: -ms-flexbox;
    display: flex;
    -ms-flex-wrap: wrap;
    flex-wrap: wrap;
    margin-right: -15px;
    margin-left: -15px;
    }
    .container {
    width: 100%;
    padding-right: 15px;
    padding-left: 15px;
    margin-right: auto;
    margin-left: auto;
}
.bg-success {
    background-color: #28a745!important;
}
.card {
    position: relative;
    display: -ms-flexbox;
    display: flex;
    -ms-flex-direction: column;
    flex-direction: column;
    min-width: 0;
    word-wrap: break-word;
    background-color: #fff;
    background-clip: border-box;
    border: 1px solid rgba(0,0,0,.125);
    border-radius: .25rem;
}
.card-header {
    padding: .75rem 1.25rem;
    margin-bottom: 0;
    background-color: rgba(0,0,0,.03);
    border-bottom: 1px solid rgba(0,0,0,.125);
}
.card-body {
    -ms-flex: 1 1 auto;
    flex: 1 1 auto;
    padding: 1.25rem;
}
.table-bordered {
    border: 1px solid #dee2e6;
}
.table {
    width: 100%;
    margin-bottom: 1rem;
    background-color: transparent;
}
.col-md-12{
      position: relative;
    width: 100%;
    min-height: 1px;
    padding-right: 15px;
    padding-left: 15px;
}
</style>

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
          <br>
          <br>
          <br>
          <br>
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
              <?php $var =1 ?>
          @foreach($cart['items'] as $p)
              <tr>
                <td>{{$var}}</td>
                <td>{{$p['sku']}}</td>
                <td>{{$p['name']}}</td>
                <td>{{$p['description']}}</td>
                <td>{{$p['price']}}</td>
                <td>{{$p['quantity']}}</td>
                <td>${{$p['price']*$p['quantity']}}</td>
              </tr>
              <?php $var =$var+1 ?>
          @endforeach


            </tbody>
         
          </table>
        <div>
          <span>Total: </span><span>${{$subTotal}}</span>
        </div>        
        </div>

        </div>
      </div>
    </div>
  </div>
</body>
</html>

