<?php echo PageBuilder::section('head', [
'categories' => $categories,
'cart'=>$cart
]); ?>


<div class="page-content mt-50 mb-10">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="page-title">
                    <h2>Cart</h2>
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
                            <h4>Calculate Shipping</h4>
                            <form action="#">
                                <div class="row">
                                    <div class="col-md-6 col-12 mb-25">
                                        <select class="nice-select">
                                            <option>Bangladesh</option>
                                            <option>China</option>
                                            <option>country</option>
                                            <option>India</option>
                                            <option>Japan</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 col-12 mb-25">
                                        <select class="nice-select">
                                            <option>Dhaka</option>
                                            <option>Barisal</option>
                                            <option>Khulna</option>
                                            <option>Comilla</option>
                                            <option>Chittagong</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 col-12 mb-25">
                                        <input type="text" placeholder="Postcode / Zip">
                                    </div>
                                    <div class="col-md-6 col-12 mb-25">
                                        <input type="submit" value="Estimate">
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- Discount Coupon -->
                        <div class="discount-coupon">
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
                                <h4>Cart Summary</h4>
                                <p>Sub Total <span>$1250.00</span></p>
                                <p>Shipping Cost <span>$00.00</span></p>
                                <h2>Total <span>$<?php echo e($cart['subtotal']); ?></span></h2>
                            </div>
                            <div class="cart-summary-button">
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

