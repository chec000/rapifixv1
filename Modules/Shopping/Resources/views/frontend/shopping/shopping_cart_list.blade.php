{!! PageBuilder::section('head', [
'categories' => $categories,
'cart'=>$cart
]) !!}

<div class="page-content mt-50 mb-10">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="page-title">
                    <h2>Carrito de compras</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <form action="#">
                    <!-- Cart Table -->
                    <div class="cart-table table-responsive mb-40">
                        <table class="table">
                            <thead>
                            <tr>
                                <th class="pro-thumbnail">Imagen</th>
                                <th class="pro-title">Producto</th>
                                <th class="pro-price">Precio</th>
                                <th class="pro-quantity">Cantidad</th>
                                <th class="pro-subtotal">Total</th>
                                <th class="pro-remove">Eliminar</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($products as $p)

                            <tr id="product-checkout-{{$p['id']}}">
                                <td class="pro-thumbnail"><a href="#">
                                        <img class="img-fluid" src="{{$p['image']}}" alt="Product"></a></td>
                                <td class="pro-title"><a 
                                href="#"
                                    >
                                        {{$p['name']}}
                                    </a></td>
                                <td class="pro-price"><span>${{$p['price']}}</span></td>
                                <td class="pro-quantity">
                                    <span class="pro-qty-cart counter">
                                        <input type="text" value="{{$p['quantity']}}" id="{{$p['id']}}" class="mr-5">
                                </td>
                                <td class="pro-subtotal">
                                    <span id="subtotal-{{$p['id']}}">${{$p['quantity']*$p['price']}}</span></td>
                                <td class="pro-remove">
                                    <span style="cursor: pointer;" onclick="ShoppingCart.remove_all_from_item({{$p['id']}})">
                                        <i class="fa fa-trash-o"></i>
                                    </span>
                                    
                                </td>
                            </tr>
                            @endforeach


                            </tbody>
                        </table>
                    </div>

                </form>

                <div class="row">

                    <div class="col-lg-6 col-12 mb-15">
                        <!-- Calculate Shipping -->
                        <div class="calculate-shipping">
                            <h4>Mis datos</h4>
                            <form action="{{route('cart.send_mail')}}" method="GET" id="cart-form">
                                <div class="row" >
                                    <div class="col-md-6 col-12 mb-25">
                                        <div class="form-group">
                                            <label>Nombre(s):</label>
                                               <input name="nombre" type="text" class="form-control" placeholder="Nombre(s)" required="required">

                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12 mb-25">
                                        <div  class="form-group">
                                            <label>
                                                Apellidos:
                                            </label>
                                            <input class="form-control" name="apellidos" type="text" placeholder="Apellidos" required="required">

                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12 mb-25">
                                        <div class="form-group">
                                            <label>Telefono de casa:</label>
                                        <input  class="form-control"name="telefono" type="tel" placeholder="Telefono celular" required="required">
                                            
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12 mb-25">
                                        <div class="form-group">
                                            <label>Numero celular:</label>
                                            <input type="tel"  class="form-control"name="celular" placeholder="celular" required="required">
                                        </div>
                                    </div>         
                                <div class="col-md-6 col-12 mb-25">
                                        <div class="form-group">
                                            <label  for="address">Direccion:</label>
                                            <input  id="address"type="text"  class="form-control"name="direccion" placeholder="Direccion" required="required">
                                        </div>
                                    </div>    
                                    <div class="col-md-6 col-12 mb-25">
                                     <div class="form-group">
                               <label for="email">Correo:</label>
                               <input  class="form-control" type="email" name="email" class="form-control" id="email"  placeholder="Ingresa tu email ">

                               </div>
                
                                    </div>
                                    <div class="col-md-6 col-12 mb-25">
                                           <div class="form-group">
                                              <label >Ciudad:</label>
                                        <select class="form-control" required="required" name="ciudad">
                                    <option value="">Selecciona una opcion</option>
                                            <option value="Azua">Azua</option>
                                             <option value="Bahoruco">Bahoruco</option>
                                              <option value="Barahona">  Barahona</option>
                                               <option value="Dajabón">Dajabón</option>
                                                <option value="Distrito Nacional">Distrito Nacional</option>

                                                 <option value="Elías Piña">Elías Piña</option>
                                                 <option value="Duarte">Duarte</option>
                                                 <option value="El Seibo">El Seibo</option>
                                                 <option value="Espaillat">Espaillat</option>
                                                 <option value="Hato Mayor">Hato Mayor</option>
                                                 <option value="Hermanas Mirabal">Hermanas Mirabal</option>
                                                 <option value="Independencia">Independencia</option>
                                                 <option value="La Altagracia">La Altagracia</option>
                                                 <option value="La Romana">   La Romana</option>
                                                 <option value="La Vega">La Vega</option> 
                                                 <option value="María Trinidad Sánchez">María Trinidad Sánchez</option>  
                                                 <option value="Monseñor Nouel">Monseñor Nouel</option>
                                                 <option value="Monte Cristi">Monte Cristi</option>
                                                 <option value="Monte Plata">Monte Plata</option>
                                                 <option value="Pedernales">Pedernales</option>
                                                 <option value="Peravia">Peravia</option>
                                                 <option value="Puerto Plata">Puerto Plata</option>
                                                 <option value="Samaná">   Samaná</option>
                                                 <option value="San Cristóbal">   San Cristóbal</option>
                                                 <option value="San José de Ocoa">San José de Ocoa</option>
                                                 <option value="San Juan">San Juan</option>
                                                 <option value="San Pedro de Macorís">San Pedro de Macorís</option>
                                                 <option value="Sánchez Ramírez">Sánchez Ramírez</option>
                                                 <option value="Santiago">   Santiago</option>
                                                 <option value="Santiago Rodríguez">Santiago Rodríguez</option>
                                                 <option value="Santo Domingo">Santo Domingo</option>
                                                 <option value="Valverde">Valverde</option>                                                 
                                             </select>
                                           </div>                                                                                                                  
                                    </div>
                                    <div class="col-md-6 col-12 mb-25">
                        <div class="form-group">
                               <label for="email">Comentario:</label>
                               <textarea class="form-control" name="comentario" placeholder="Si tienes un comentrio, ingresalo aqui "></textarea>
                              
                               </div>                
                                    </div>
                        
                                    <div class="col-md-6 col-12 mb-25">
                                        <div class="form-group" >
                                            <input class="form-control" type="submit" value="Enviar">

                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- Discount Coupon -->
                        <div class="discount-coupon" style="display: none;">
                            <h4>Discount Coupon Code</h4>
                            <form action="#">
                                <div class="row">
                                    <div class="col-md-6 col-12 mb-25">
                                        <input type="text" placeholder="Coupon Code">
                                    </div>
                                    <div class="col-md-6 col-12 mb-25">
                                        <input type="submit" value="Apply Code">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Cart Summary -->
                    <div class="col-lg-6 col-12 mb-40 d-flex">
                        <div class="cart-summary">
                            <div class="cart-summary-wrap">
                                <h4>Resumen de compra</h4>
                                <p>Sub Total <span id="subtotal-cart">${{$cart['subtotal']}}</span></p>
                                <p style="display: none;"><span>$00.00</span></p>
                                <h2>Total <span id="total-cart">${{$cart['subtotal']}}</span></h2>
                            </div>
                            <div class="cart-summary-button" style="display: none;">
                                <button class="checkout-btn">Checkout</button>
                                <button class="update-btn">Update Cart</button>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>


{!! PageBuilder::section('footer',[
'categories' => $categories
]) !!}
