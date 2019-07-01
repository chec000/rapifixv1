<div class="cart-floating-box" id="cart-floating-box">
    <div class="cart-items">
        <?php if($cart['items']!=null): ?>
            <?php $__currentLoopData = $cart['items']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="cart-float-single-item d-flex">
                    <span class="remove-item"><a href="#"><i class="fa fa-trash"></i></a></span>
                    <div class="cart-float-single-item-image">
                        <img src="<?php echo e($p['image']); ?>" class="img-fluid" alt="">

                    </div>
                    <div class="cart-float-single-item-desc">
                        <p class="product-title"><span class="count"><?php echo e($p['quantity']); ?>X</span>
                            <a href="single-product-variable.html">
                                <?php echo e($p['name']); ?>

                            </a></p>
                        <p class="size"> <a href="shop-left-sidebar.html">Yellow, S</a></p>
                        <p class="price" id="subtotal"><?php echo e($p['price']); ?></p>
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
            <p class="total">Total <span>$<?php echo e($cart['subtotal']); ?></span></p>
        </div>
        <div class="checkout-button">
            <a href="checkout.html">Checkout</a>
        </div>
    </div>
</div>
