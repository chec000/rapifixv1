<?php echo PageBuilder::section('head', [
'categories' => $categories,
'cart'=>$cart
]); ?>


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
                                <th class="pro-thumbnail">Image</th>
                                <th class="pro-title">Product</th>
                                <th class="pro-price">Price</th>
                                <th class="pro-quantity">Quantity</th>
                                <th class="pro-subtotal">Total</th>
                                <th class="pro-remove">Remove</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>:

                            <tr>
                                <td class="pro-thumbnail"><a href="single-product-variable-wide.html">
                                        <img class="img-fluid" src="<?php echo e($p['image']); ?>" alt="Product"></a></td>
                                <td class="pro-title"><a href="single-product-variable-wide.html">
                                        <?php echo e($p['name']); ?>

                                    </a></td>
                                <td class="pro-price"><span>$<?php echo e($p['price']); ?></span></td>
                                <td class="pro-quantity">
                                    <span class="pro-qty-cart counter">
                                        <input type="text" value="<?php echo e($p['quantity']); ?>" class="mr-5">
                                </td>
                                <td class="pro-subtotal"><span>$<?php echo e($p['quantity']*$p['price']); ?></span></td>
                                <td class="pro-remove"><a href="#"><i class="fa fa-trash-o"></i></a></td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                            </tbody>
                        </table>
                    </div>

                </form>

                <div class="row">

                    <div class="col-lg-6 col-12 mb-15">
                        <!-- Calculate Shipping -->
                        <div class="calculate-shipping">
                            <h4>Mis datos</h4>
                            <form action="<?php echo e(route('cart.send_mail')); ?>" method="GET">
                                <div class="row" >
                                    <div class="col-md-6 col-12 mb-25">
                                        <input name="nombre" type="text" placeholder="Nombre(s)">
                                    </div>
                                    <div class="col-md-6 col-12 mb-25">
                                        <input name="apellidos" type="text" placeholder="apellidos">
                                    </div>
                                    <div class="col-md-6 col-12 mb-25">
                                        <input name="telefono" type="number" placeholder="Telefono celular">
                                    </div>
                                    <div class="col-md-6 col-12 mb-25">
                                        <input type="number" name="celular" placeholder="celular">
                                    </div>
                                    <div class="col-md-6 col-12 mb-25">
                                        <input name="otro_telefono" type="number"  placeholder="Otro télefono">
                                    </div>
                                      <div class="col-md-6 col-12 mb-25">

                                        <textarea name="comentario" placeholder="Comentario"></textarea>
                                    </div>
                                    <div class="col-md-6 col-12 mb-25">
                                        <select class="form-control" required="required" name="ciudad">

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

                                        </select>
                                        
                                    </div>
                                    <div class="col-md-6 col-12 mb-25">
                                        <input type="submit" value="Enviar">
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
                                <p>Sub Total <span>$<?php echo e($cart['subtotal']); ?></span></p>
                                <p style="display: none;"><span>$00.00</span></p>
                                <h2>Total <span>$<?php echo e($cart['subtotal']); ?></span></h2>
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


<?php echo PageBuilder::section('footer',[
'categories' => $categories
]); ?>

