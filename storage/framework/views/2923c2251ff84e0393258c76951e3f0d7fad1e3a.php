<div class="shopping-cart float-lg-right d-flex justify-content-start" id="shopping-cart">
    <div class="cart-icon">
        <a href="cart.html"><img src="assets/images/icon-topcart.png" class="img-fluid" alt=""></a>
    </div>
    <div class="cart-content" id="shopping-cart">
        <h2><span class="fa fa-shopping-cart" onmouseover="showCart()"> <span>
                <?php if($cart['items']!=null): ?>
            <span id="cartStatus" style="display: none;">
                (Empty)

                <?php endif; ?>
        </span>
    </span>
                </a>
</h2>
    </div>


    <div class="cart-floating-box" id="cart-floating-box">
        <div class="cart-items">
            <?php if($cart['items']!=null): ?>
                <?php $__currentLoopData = $cart['items']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div data-id="<?php echo e($p['id']); ?>" class="cart-float-single-item d-flex">
                        <span class="remove-item" onclick="ShoppingCart.remove_all_from_item(<?php echo e($p['id']); ?>)"><i class="fa fa-trash"></i></span>
                        <div class="cart-float-single-item-image">
                            <img src="<?php echo e($p['image']); ?>" class="img-fluid" alt="">

                        </div>
                        <div class="cart-float-single-item-desc item-id-<?php echo e($p['id']); ?>">
                            <span class="product-title">
                                <span class="count"><?php echo e($p['quantity']); ?>

                                X
                                 <?php echo e($p['name']); ?>   
                            </span>
                            </span>
                            <input class="form-control" style="width: 34px" type="text" value="<?php echo e($p['quantity']); ?>" name="product-<?php echo e($p['id']); ?>"onkeypress="return isNumeric(event)" 
                            >

                            <p class="size"> <a href="shop-left-sidebar.html"></a></p>
                            <p class="price" ><?php echo e($p['price']); ?></p>
                        </div>
                    </div>


                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            <?php endif; ?>

        </div>

            <div class="cart-calculation d-flex">
                <div class="calculation-details">
                   <!--
                    <p class="shipping">Shipping <span>$2</span></p>
                   -->
                    <p class="total">Total <span id="subtotal">$<?php echo e($cart['subtotal']); ?></span></p>
                </div>
                <div class="checkout-button">
                    <a href="checkout.html">Checkout</a>
                </div>
            </div>
        </div>

        <!-- end of shopping cart -->
    </div>
</div>
