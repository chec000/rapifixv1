<div class="brand-logo-slider mb-50">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-sm-12">
                <div class="brand-logo-list">
                    <!-- ======  single brand logo block  ======= -->
                    @for($i = 0; $i <= 10; $i++)
                    <div class="single-brand-logo">
                        <a href="#">

                            <img src="{{ asset('cms/inicio/images/brand-logos/'.$i.'.jpg') }}" alt="">
                        </a>
                    </div>
                    @endfor


                    <!-- ====  End of single brand logo block  ==== -->

                </div>
            </div>
        </div>
    </div>
</div>

<!--====  End of brand logo slider  ====-->

<!--========================================
=            newsletter section            =
=========================================-->

<section class="newsletter-section">
    <div class="container">
        <div class="newsletter-container dark-bg">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 col-md-12 col-sm-12">

                        <!-- ======  Newsletter input box  ======= -->

                        <div class="newsletter-wrapper d-md-flex">
                            <!-- newsletter text -->
                            <div class="newsletter-text">
                                <h2>Boletin <span> Ingresa tu correo para recibir las mejores ofertas</span></h2>
                            </div>
                            <!-- end of newsletter text -->

                            <!-- newsletter input -->
                            <div class="newsletter-input">
                                <div class="input-group">
                                    <div class="input-group-append">
                                        <form id="mc-form" class="mc-form subscribe-form" method="post" action="{{route('complement.sendEmail')}}">
                                            <input type="email" id="mc-email" type="email" autocomplete="on" placeholder="Ingresa tu correo"
                                                   required>
                                            <button id="mc-submit" type="submit">Subscribirse</button>
                                        </form>

                                    </div>
                                </div>

                                <div class="mailchimp-alerts">
                                    <div class="mailchimp-submitting"></div><!-- mailchimp-submitting end -->
                                    <div class="mailchimp-success"></div><!-- mailchimp-success end -->
                                    <div class="mailchimp-error"></div><!-- mailchimp-error end -->
                                </div><!-- mailchimp-alerts end -->
                            </div>
                            <!-- end of newsletter input -->
                        </div>

                        <!-- ====  End of Newsletter input box  ==== -->

                    </div>
                    <div class="col-lg-4 col-md-12 col-sm-12">
                        <!-- ======  Social icon list  ======= -->

                        <div class="social-icons text-right mt-5">
                            <ul>
                                <li><a class="facebook-link" href="//www.facebook.com"><i class="fa fa-facebook"></i></a>
                                    <span class="popup">facebook</span>
                                </li>
                                <li><a class="rss-link" href="//rss.com"><i class="fa fa-rss"></i></a>
                                    <span class="popup">rss</span>
                                </li>
                                <li><a class="twitter-link" href="//www.twitter.com"><i class="fa fa-twitter"></i></a>
                                    <span class="popup">twitter</span>
                                </li>
                                <li><a class="skype-link" href="//www.skype.com"><i class="fa fa-skype"></i></a>
                                    <span class="popup">Skype</span>
                                </li>
                                <li><a class="dribbble-link" href="//www.dribbble.com"><i class="fa fa-dribbble"></i></a>
                                    <span class="popup">Dribbble</span>
                                </li>
                            </ul>
                        </div>

                        <!-- ====  End of Social icon list  ==== -->

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!--====  End of newsletter section  ====-->

<!--============================
=            footer            =
=============================-->



<footer>
    <div class="container">
        <!-- footer navigation -->
        <div class="footer-navigation section-padding">
            <div class="row">
                <div class="col-lg-4 col-md-4">
                    <!-- footer description -->
                    <div class="footer-description">
                        <div class="footer-logo">
                            <!--
                            <img src="{{asset('cms/app/img/logo.png')}}" alt="">
                        -->
                            </div>
                        <p>
                            Desarrollado por GM software SA de CV
                        </p>
                    </div>
                    <!-- end of footer description -->
                </div>
                <div class="col-lg-8 col-md-8">
                    <!-- footer nav links -->
                    <div class="row">
                        <div class="col-lg-3 col-md-6">
                            <!-- single footer nav block -->
                            <div class="single-footer-nav-block">
                                <h2 class="block-title">INFORMACION</h2>
                                <ul class="footer-nav-links">
                                    <li><a href="{{route('complement.contact')}}">Contacto</a></li>
                                    <li><a href="{{route('complement.about')}}">Acerca de nosotros</a></li>
                                </ul>
                            </div>
                            <!-- end of single footer nav block -->
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <!-- single footer nav block -->
                            <div class="single-footer-nav-block">
                                <h2 class="block-title"><a href="my-account.html">MI CUENTA</a></h2>
                                <ul class="footer-nav-links">
                                    <li><a href="#">Mis ordenes</a></li>
                                    
                                    <li><a href="my-account.html">Mi dirección</a></li>
                                    <li><a href="my-account.html">
                                        Mi información personal
                                    </a></li>
                                </ul>
                            </div>
                            <!-- end of single footer nav block -->
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <!-- single footer nav block -->
                            <div class="single-footer-nav-block">
                                <h2 class="block-title">
                                    CATEGORIAS
                                </h2>
                                <ul class="footer-nav-links">
                                    @foreach($categories as $c)

                                <li><a href="{{route('category.products', ['id' => $c->id])}}">
            {{$c->name}}</a></li>
                                    @endforeach

                                    
                                </ul>
                            </div>
                            <!-- end of single footer nav block -->
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <!-- single footer nav block -->
                            <div class="single-footer-nav-block">
                                <h2 class="block-title">NUESTROS SERVICIOS</h2>
                                <ul class="footer-nav-links" style="display: none">
                                    <li><a href="store.html">Our Stores</a></li>
                                    <li><a href="about.html">Information</a></li>
                                    <li><a href="#">Privacy Policy</a></li>
                                    <li><a href="#">Terms & Condition</a></li>
                                </ul>
                            </div>
                            <!-- end of single footer nav block -->
                        </div>
                    </div>
                    <!-- end of footer nav links -->

                </div>
            </div>
        </div>
        <!-- end of footer navigation -->

        <!-- copyright section -->
        <div class="copyright-section">
            <div class="copyright-container">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <p class="copyright-text text-center text-md-left"> Copyright © 2019  <a href="/">Rapyfix</a>. All Rights Reserved</p>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <div class="payment-logos text-md-right text-center">
                            <img src="assets/images/payment.png" alt="payment logo" style="display:none">
                        </div>
                    </div>
                </div>
            </div>
            <!-- end of copyright section -->
        </div>
    </div>
</footer>

<div class="modal fade quick-view-modal-container" id="quick-view-modal-container" tabindex="-1" role="dialog"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-5 col-md-7">
                        <!-- product quickview image gallery -->
                        <!--Modal Tab Content Start-->
                        <div class="tab-content product-details-large" id="myTabContent">
                            <div class="tab-pane fade show active" id="single-slide1" role="tabpanel" aria-labelledby="single-slide-tab-1">
                                <!--Single Product Image Start-->
                                <div class="single-product-img img-full">
                                    <img src="assets/images/product-slider-images/image1.jpg" class="img-fluid" alt="">
                                </div>
                                <!--Single Product Image End-->
                            </div>
                            <div class="tab-pane fade" id="single-slide2" role="tabpanel" aria-labelledby="single-slide-tab-2">
                                <!--Single Product Image Start-->
                                <div class="single-product-img img-full">
                                    <img src="assets/images/product-slider-images/image2.jpg" class="img-fluid" alt="">
                                </div>
                                <!--Single Product Image End-->
                            </div>
                            <div class="tab-pane fade" id="single-slide3" role="tabpanel" aria-labelledby="single-slide-tab-3">
                                <!--Single Product Image Start-->
                                <div class="single-product-img img-full">
                                    <img src="assets/images/product-slider-images/image3.jpg" class="img-fluid" alt="">
                                </div>
                                <!--Single Product Image End-->
                            </div>
                            <div class="tab-pane fade" id="single-slide4" role="tabpanel" aria-labelledby="single-slide-tab-4">
                                <!--Single Product Image Start-->
                                <div class="single-product-img img-full">
                                    <img src="assets/images/product-slider-images/image4.jpg" class="img-fluid" alt="">
                                </div>
                                <!--Single Product Image End-->
                            </div>
                        </div>
                        <!--Modal Content End-->
                        <!--Modal Tab Menu Start-->
                        <div class="single-product-menu">
                            <div class="nav single-slide-menu" role="tablist">
                                <div class="single-tab-menu img-full">
                                    <a data-toggle="tab" id="single-slide-tab-1" href="#single-slide1"><img src="assets/images/product-slider-images/image1.jpg"
                                                                                                            class="img-fluid" alt=""></a>
                                </div>
                                <div class="single-tab-menu img-full">
                                    <a data-toggle="tab" id="single-slide-tab-2" href="#single-slide2"><img src="assets/images/product-slider-images/image2.jpg"
                                                                                                            class="img-fluid" alt=""></a>
                                </div>
                                <div class="single-tab-menu img-full">
                                    <a data-toggle="tab" id="single-slide-tab-3" href="#single-slide3"><img src="assets/images/product-slider-images/image3.jpg"
                                                                                                            class="img-fluid" alt=""></a>
                                </div>
                                <div class="single-tab-menu img-full">
                                    <a data-toggle="tab" id="single-slide-tab-4" href="#single-slide4"><img src="assets/images/product-slider-images/image4.jpg"
                                                                                                            alt=""></a>
                                </div>
                            </div>
                        </div>
                        <!--Modal Tab Menu End-->
                        <!-- end of product quickview image gallery -->
                    </div>
                    <div class="col-lg-7 col-md-5">
                        <!-- product quick view description -->
                        <div class="product-options">
                            <h2 class="product-title">FADED SHORT SLEEVE</h2>
                            <p class="condition"><span>Condition:</span> New</p>
                            <h2 class="product-price">$12.90</h2>
                            <p class="product-description">Faded short sleeve t-shirt with high neckline. Soft and stretchy material for a
                                comfortable fit. Accessorize with a straw hat and you're ready for summer!</p>
                            <div class="social-share-buttons">
                                <ul>
                                    <li><a class="twitter" href="#"><i class="fa fa-twitter"></i> Tweet</a></li>
                                    <li><a class="facebook" href="#"><i class="fa fa-facebook"></i> Share</a></li>
                                    <li><a class="google-plus" href="#"><i class="fa fa-google-plus"></i> Google+</a></li>
                                    <li><a class="pinterest" href="#"><i class="fa fa-pinterest"></i> Pinterest</a></li>
                                </ul>
                            </div>
                            <p class="stock-details">288 items <span class="stock-status in-stock">In Stock</span></p>
                            <p class="quantity">Quantity:
                                <span class="pro-qty counter"><input type="text" value="1" class="mr-5"></span>

                            </p>
                            <p class="size">
                                Size: <br>
                                <select name="chooseSize" id="chooseSize">
                                    <option value="0">XXL</option>
                                    <option value="0">L</option>
                                    <option value="0">M</option>
                                    <option value="0">S</option>
                                </select>
                            </p>
                            <p class="color">
                                Color: <br>
                                <a href="#"><span class="color-block color-choice-1"></span></a>
                                <a href="#"><span class="color-block color-choice-2"></span></a>
                                <a href="#"><span class="color-block color-choice-3 active"></span></a>
                            </p>

                            <a href="#" class="add-to-cart-btn" data-toggle="modal" data-target="#add-to-cart-modal-container"><i class="fa fa-shopping-cart"></i>
                                Add to Cart</a>
                        </div>
                        <!-- end of product quick view description -->
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<!-- end of quick view modal -->


<!-- add to cart modal -->
<div class="modal fade add-to-cart-modal-container" id="add-to-cart-modal-container" tabindex="-1" role="dialog"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-6 col-md-6">
                        <!-- cart product short details -->

                        <div class="cart-product-short-desc">
                            <h2 class="cart-success-message">Producto agregado correctamente</h2>
                            <div class="cart-product-short-desc-content d-flex">
                                <div class="product-image">
                                    <img src="" id="img-product-cart" class="img-fluid" alt="">
                                </div>
                                <div class="product-desc">
                                    <h4 class="product-title" id="name-product-cart"></h4>
                                    <p id="description-product-cart"></p>
                                    <p class="quantity"><span>Cantidad:</span> <span id="quantity-product-cart"></span></p>
                                    <p class="total-amount"><span >Total:</span> 
                                    <span id="price-product-cart"></span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <!-- end of cart product short details -->
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <!-- cart product calculation -->
                        <div class="cart-product-calculation">
                            <h2 class="cart-info-message">Carrito</h2>
                            <div class="product-calculations">
                                <!--
                                <p><span id="total-product-cart"></span> $20.50</p>
                                -->
                                <p><span style="display: none;">Total envio: </span> <span id="shopping-product-cart" style="display: none;">$0</span></p>
                                <p><span >Total: </span> <span id="total-cart">$0</span></p>
                            </div>
                        </div>
                        <!-- end of cart product calculation -->

                        <!-- cart modal buttons -->
                        <div class="cart-modal-buttons">
                            <a href="#" class="continue-shopping-btn" data-dismiss="modal" aria-hidden="true">
                                <i class="fa fa-chevron-left"></i> 
                                Continuar comprando

                            </a>
                           
                            
                            <a class="proceed-checkout-btn" href="{{route('cart.list')}}">
                                ir a checkout
                             <i class="fa fa-chevron-right"></i>
                            </a>
                        </div>
                        <!-- end of cart modal buttons -->

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<!-- end of add to cart modal -->
<div class="animatedDiv" id="bloqueo" style="display: none">
	<div class="ring" >
            <span id="mensajeBloqueo"></span>
                <span class="span-m"></span>
	</div>
</div>

<!-- scroll to top  -->
<a href="#" class="scroll-top"></a>

<script type="text/javascript"  src="{{asset('cms/inicio/js/vendor/jquery.min.js')}}"></script>

<script type="text/javascript" src="{{asset('cms/inicio/js/popper.min.js')}}"></script>
<script type="text/javascript" src="{{asset('cms/inicio/js/vendor/modernizr-2.8.3.min.js')}}"></script>
<script type="text/javascript" src="{{asset('cms/inicio/js/bootstrap.min.js')}}"></script>
<script type="text/javascript" src="{{asset('cms/inicio/js/plugins.js')}}"></script>
<script type="text/javascript" src="{{asset('cms/inicio/js/main.js')}}"></script>
<script type="text/javascript" src="{{asset('cms/inicio/js/cart.js')}}"></script>
<script src="{{ PageBuilder::js('shopping_cart_old_browsers') }}"></script>
<input type="hidden" id="shop_secret" value="{{ csrf_token() }}">
<script  src="{{asset('cms/inicio/js/sweetalert2@8.js')}}"></script>
<script  src="{{asset('cms/inicio/js/sweetalert.min.js')}}"></script>
<script type="application/javascript">
    $(document).ready(function () {
        var products;
        document.products = {};

        var shopping_cart = {!! ShoppingCart::sessionToJson(3) !!};
        if (shopping_cart.constructor === Array && shopping_cart.length == 0) {
            shopping_cart = {};
        }
        document.shopping_cart = shopping_cart;


        @foreach ($categories as $category)
            products = {!! ShoppingCart::productsToJson($category->groupProducts->where('active', 1)->where('delete', 0)) !!};
        $.each(products, function (i, product) {
            document.products[i] = product;
        });
        @endforeach


    });


</script>
