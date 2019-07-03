{!! PageBuilder::section('head', [
    'categories' => $categories,
    'cart'=>$cart
]) !!}

<div class="homepage-content">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 mb-50">
                <div class="row">
                    <div class="col-lg-3 col-md-4">
                        <!-- Header category list -->
                        <div class="hero-side-category">
                            <!-- Category Toggle Wrap -->
                            <div class="category-toggle-wrap">
                                <!-- Category Toggle -->
                                <button class="category-toggle">Categories <i class="ti-menu"></i></button>
                            </div>
                            <!-- Category Menu -->
                            <nav class="category-menu mb-40">
                                <ul>
                                    @foreach ($categories as $c)
                                        <li><a href="{{route('category.products', ['id' => $c->id])}}">{{$c->name}}</a></li>

                                @endforeach
                                <!--
                                                        <li class="menu-item-has-children"><a href="shop-left-sidebar.html">Tennis</a>

                                                            <ul class="category-mega-menu">
                                                                <li class="menu-item-has-children">
                                                                    <a class="megamenu-head" href="shop-left-sidebar.html">Dresses</a>
                                                                    <ul>
                                                                        <li><a href="shop-left-sidebar.html">Coctail</a></li>
                                                                        <li><a href="shop-left-sidebar.html">Day</a></li>
                                                                        <li><a href="shop-left-sidebar.html">Evening</a></li>
                                                                        <li><a href="shop-left-sidebar.html">Sports</a></li>
                                                                    </ul>
                                                                </li>
                                                                <li class="menu-item-has-children">
                                                                    <a class="megamenu-head" href="shop-left-sidebar.html">Shoes</a>
                                                                    <ul>
                                                                        <li><a href="shop-left-sidebar.html">Coctail</a></li>
                                                                        <li><a href="shop-left-sidebar.html">Day</a></li>
                                                                        <li><a href="shop-left-sidebar.html">Evening</a></li>
                                                                        <li><a href="shop-left-sidebar.html">Sports</a></li>
                                                                    </ul>
                                                                </li>
                                                                <li class="menu-item-has-children">
                                                                    <a class="megamenu-head" href="shop-left-sidebar.html">Handbags</a>
                                                                    <ul>
                                                                        <li><a href="shop-left-sidebar.html">Coctail</a></li>
                                                                        <li><a href="shop-left-sidebar.html">Day</a></li>
                                                                        <li><a href="shop-left-sidebar.html">Evening</a></li>
                                                                        <li><a href="shop-left-sidebar.html">Sports</a></li>
                                                                    </ul>
                                                                </li>
                                                            </ul>


                                                        </li>
                                                        <li class="menu-item-has-children"><a href="shop-left-sidebar.html">Basketball</a>

                                                            <ul class="category-mega-menu">
                                                                <li class="menu-item-has-children">
                                                                    <a class="megamenu-head" href="shop-left-sidebar.html">Dresses</a>
                                                                    <ul>
                                                                        <li><a href="shop-left-sidebar.html">Coctail</a></li>
                                                                        <li><a href="shop-left-sidebar.html">Day</a></li>
                                                                        <li><a href="shop-left-sidebar.html">Evening</a></li>
                                                                        <li><a href="shop-left-sidebar.html">Sports</a></li>
                                                                    </ul>
                                                                </li>
                                                                <li class="menu-item-has-children">
                                                                    <a class="megamenu-head" href="shop-left-sidebar.html">Shoes</a>
                                                                    <ul>
                                                                        <li><a href="shop-left-sidebar.html">Coctail</a></li>
                                                                        <li><a href="shop-left-sidebar.html">Day</a></li>
                                                                        <li><a href="shop-left-sidebar.html">Evening</a></li>
                                                                        <li><a href="shop-left-sidebar.html">Sports</a></li>
                                                                    </ul>
                                                                </li>
                                                                <li class="menu-item-has-children">
                                                                    <a class="megamenu-head" href="shop-left-sidebar.html">Handbags</a>
                                                                    <ul>
                                                                        <li><a href="shop-left-sidebar.html">Coctail</a></li>
                                                                        <li><a href="shop-left-sidebar.html">Day</a></li>
                                                                        <li><a href="shop-left-sidebar.html">Evening</a></li>
                                                                        <li><a href="shop-left-sidebar.html">Sports</a></li>
                                                                    </ul>
                                                                </li>
                                                            </ul>

                                                        </li>
                                                        <li><a href="shop-left-sidebar.html">Cricket</a></li>
                                                        <li><a href="shop-left-sidebar.html">Baseball</a></li>
                                                        <li><a href="shop-left-sidebar.html">Skateboarding</a></li>
                                                        <li><a href="shop-left-sidebar.html">Accessories</a></li>
                                                        <li><a href="shop-left-sidebar.html">Footwear</a></li>
                                                        <li><a href="shop-left-sidebar.html">Badminton</a></li>
                            -->
                                </ul>
                            </nav>
                        </div>
                        <!-- end of Header category list -->
                    </div>
                    <div class="col-lg-9 col-md-8">
                        <!-- ======  Hero slider content  ======= -->

                        <div class="hero-slider hero-slider-one">
                            <!-- Hero Item Start -->
                            <div class="hero-item hero-bg-1">
                                <div class="row align-items-center justify-content-between">
                                    <!-- Hero Content -->
                                    <div class="hero-content col-md-8 offset-md-4 col-sm-12 offset-sm-0">
                                        <h1>THE WINTER</h1>
                                        <h2><span>SPORT WINTER</span></h2>
                                        <p>This is Photoshops version of Lorem Ipsum. Proin gravida nibh vel velit auctor aliquet. Aenean
                                            sollicitudin, lorem quis</p>
                                        <a href="shop-left-sidebar.html">shop now</a>
                                    </div>
                                </div>
                            </div><!-- Hero Item End -->

                            <!-- Hero Item Start -->
                            <div class="hero-item hero-bg-2">
                                <div class="row align-items-center justify-content-between">
                                    <!-- Hero Content -->
                                    <div class="hero-content col-md-8 offset-md-4 col-sm-12 offset-sm-0">
                                        <h1>THE WINTER</h1>
                                        <h2><span>SPORT WINTER</span></h2>
                                        <p>This is Photoshops version of Lorem Ipsum. Proin gravida nibh vel velit auctor aliquet. Aenean
                                            sollicitudin, lorem quis</p>
                                        <a href="shop-left-sidebar.html">shop now</a>
                                    </div>
                                </div>
                            </div><!-- Hero Item End -->
                        </div>

                        <!-- ====  End of Hero slider content  ==== -->

                        <!-- ======  Featured service content  ======= -->

                        <div class="featured-service-container">
                            <div class="row">
                                <div class="col-lg-4 col-md-6">
                                    <!-- single-feature -->
                                    <div class="single-featured-service featured-service-bg-1">
                                        <div class="single-featured-service-content">
                                            <h3>Lorem ipsum dolor.</h3>
                                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing </p>
                                            <a href="shop-left-sidebar.html">View Collection</a>
                                        </div>
                                    </div>
                                    <!-- end of single feature -->
                                </div>
                                <div class="col-lg-4 col-md-6">
                                    <!-- single-feature -->
                                    <div class="single-featured-service featured-service-bg-2">
                                        <div class="single-featured-service-content">
                                            <h3>Lorem ipsum dolor.</h3>
                                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing </p>
                                            <a href="shop-left-sidebar.html">View Collection</a>
                                        </div>
                                    </div>
                                    <!-- end of single feature -->
                                </div>
                                <div class="col-lg-4 col-md-6">
                                    <!-- single-feature -->
                                    <div class="single-featured-service featured-service-bg-3">
                                        <div class="single-featured-service-content">
                                            <h3>Lorem ipsum dolor.</h3>
                                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing </p>
                                            <a href="shop-left-sidebar.html">View Collection</a>
                                        </div>
                                    </div>
                                    <!-- end of single feature -->
                                </div>
                            </div>

                        </div>

                        <!-- ====  End of Featured service content  ==== -->

                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="row">
                    <div class="col-lg-3 col-md-4 mb-50">

                        <!-- ======  Homepage sidebar  ======= -->

                        <div class="homepage-sidebar">
                            <!-- vertical auto slider container -->
                            @foreach ($categories as $c)
                                <div class="sidebar">
                                    <h2 class="block-title">{{$c->name}}</h2>
                                    <div class="vertical-product-slider-container">
                                        <div class="single-vertical-slider">
                                            <div class="vertical-auto-slider-product-list">
                                                <!-- single vertical product -->


                                                @foreach ($c->products as $p)

                                                    <div class="single-auto-vertical-product d-flex">
                                                        <div class="product-image">
                                                            <a href="single-product-variable.html">
                                                                <img src="{{$p->image}}" class="img-fluid" alt=""></a>
                                                        </div>
                                                        <div class="product-description">
                                                            <h5 class="product-name">
                                                                <a href="single-product-variable.html">
                                                                    {{$p->name}}
                                                                </a></h5>
                                                            <div class="price-box">
                                                                <h4>{{$p->price}}</h4>
                                                            </div>

                                                        </div>
                                                    </div>
                                            @endforeach

                                            <!-- end of single vertical product -->
                                                <!-- single vertical product -->

                                                <!-- end of single vertical product -->

                                            </div>
                                        </div>
                                    </div>
                                </div>
                        @endforeach


                        <!-- end of vertical auto slider container -->

                            <!-- homepage sidebar banner -->
                            <div class="sidebar">
                                <div class="homepage-sidebar-banner-container">
                                    <a href="shop-left-sidebar.html">
                                        <img src="assets/images/banners/banner-left.jpg" class="img-fluid" alt="">
                                    </a>
                                </div>
                            </div>
                            <!-- end of homepage sidebar banner -->

                            <!-- vertical auto slider container -->
                            <div class="sidebar">
                                <h2 class="block-title">LATEST PRODUCTS</h2>
                                <div class="vertical-product-slider-container">
                                    <div class="single-vertical-slider">
                                        <div class="vertical-auto-slider-product-list">
                                            <!-- single vertical product -->
                                            <div class="single-auto-vertical-product d-flex">
                                                <div class="product-image">
                                                    <a href="single-product-variable.html"><img src="assets/images/products/1.jpg" class="img-fluid" alt=""></a>
                                                </div>
                                                <div class="product-description">
                                                    <h5 class="product-name"><a href="single-product-variable.html">Faded
                                                            Short Sleeve</a></h5>
                                                    <div class="price-box">
                                                        <h4>$ 12.00</h4>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- end of single vertical product -->
                                            <!-- single vertical product -->
                                            <div class="single-auto-vertical-product d-flex">
                                                <div class="product-image">
                                                    <a href="single-product-variable.html"><img src="assets/images/products/2.jpg" class="img-fluid" alt=""></a>
                                                </div>
                                                <div class="product-description">
                                                    <h5 class="product-name"><a href="single-product-variable.html">Printed
                                                            Dress</a></h5>
                                                    <div class="price-box">
                                                        <h4>$ 12.00</h4>
                                                    </div>

                                                </div>
                                            </div>
                                            <!-- end of single vertical product -->
                                            <!-- single vertical product -->
                                            <div class="single-auto-vertical-product d-flex">
                                                <div class="product-image">
                                                    <a href="single-product-variable.html"><img src="assets/images/products/3.jpg" class="img-fluid" alt=""></a>
                                                </div>
                                                <div class="product-description">
                                                    <h5 class="product-name"><a href="single-product-variable.html">Faded
                                                            Short Sleeve</a></h5>
                                                    <div class="price-box">
                                                        <h4>$ 12.00</h4>
                                                    </div>

                                                </div>
                                            </div>
                                            <!-- end of single vertical product -->
                                            <!-- single vertical product -->
                                            <div class="single-auto-vertical-product d-flex">
                                                <div class="product-image">
                                                    <a href="single-product-variable.html"><img src="assets/images/products/4.jpg" class="img-fluid" alt=""></a>
                                                </div>
                                                <div class="product-description">
                                                    <h5 class="product-name"><a href="single-product-variable.html">Printed
                                                            Dress</a></h5>
                                                    <div class="price-box">
                                                        <h4>$ 12.00</h4>
                                                    </div>

                                                </div>
                                            </div>
                                            <!-- end of single vertical product -->
                                            <!-- single vertical product -->
                                            <div class="single-auto-vertical-product d-flex">
                                                <div class="product-image">
                                                    <a href="single-product-variable.html"><img src="assets/images/products/5.jpg" class="img-fluid" alt=""></a>
                                                </div>
                                                <div class="product-description">
                                                    <h5 class="product-name"><a href="single-product-variable.html">Faded
                                                            Short Sleeve</a></h5>
                                                    <div class="price-box">
                                                        <h4>$ 12.00</h4>
                                                    </div>

                                                </div>
                                            </div>
                                            <!-- end of single vertical product -->
                                            <!-- single vertical product -->
                                            <div class="single-auto-vertical-product d-flex">
                                                <div class="product-image">
                                                    <a href="single-product-variable.html"><img src="assets/images/products/6.jpg" class="img-fluid" alt=""></a>
                                                </div>
                                                <div class="product-description">
                                                    <h5 class="product-name"><a href="single-product-variable.html">Printed
                                                            Dress</a></h5>
                                                    <div class="price-box">
                                                        <h4>$ 12.00</h4>
                                                    </div>

                                                </div>
                                            </div>
                                            <!-- end of single vertical product -->
                                            <!-- single vertical product -->
                                            <div class="single-auto-vertical-product d-flex">
                                                <div class="product-image">
                                                    <a href="single-product-variable.html"><img src="assets/images/products/7.jpg" class="img-fluid" alt=""></a>
                                                </div>
                                                <div class="product-description">
                                                    <h5 class="product-name"><a href="single-product-variable.html">Faded
                                                            Short Sleeve</a></h5>
                                                    <div class="price-box">
                                                        <h4>$ 12.00</h4>
                                                    </div>

                                                </div>
                                            </div>
                                            <!-- end of single vertical product -->

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end of vertical auto slider container -->
                        </div>

                        <!-- ====  End of Homepage sidebar  ==== -->

                    </div>
                    <div class="col-lg-9 col-md-8 mb-50">

                        <div class="homepage-main-content">
                            <!-- horizontal product slider -->

                            @foreach ($categories as $c)

                                <div class="horizontal-product-slider">

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <!-- Block title -->
                                            <div class="block-title">
                                                <h2><a href="#">{{$c->name}}</a></h2>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <!-- horizontal product slider container -->
                                            <div class="horizontal-product-list">
                                                <!-- single product -->

                                                @foreach ($c->products as $p)
                                                    <div class="single-product">
                                                        <div class="single-product-content">
                                                            <div class="product-image new-badge">
                                                                <a href="single-product-variable.html">
                                                                    <img src="{{$p->image}}" class="img-fluid" alt="">

                                                                </a>
                                                                <div class="image-btn">


                                                                    <a href="#" data-toggle="modal" data-target="#quick-view-modal-container"><i class="fa fa-search"></i></a>
                                                                    <a href="#"><i class="fa fa-heart-o"></i></a>

                                                                </div>
                                                            </div>
                                                            <h5 class="product-name"><a href="single-product-variable.html">{{$p->name}}</a></h5>
                                                            <div class="price-box">
                                                                <h4>{{$p->price}}</h4>
                                                            </div>
                                                            <span onclick="ShoppingCart.add('{{ $p->id }}', 1)" class="add-to-cart-btn">                                                                    add to car
                                                                    <i class="fa fa-shopping-cart"></i>
                                                                </span>
                                                            <!--
                                                            <a href="#" class="add-to-cart-btn" data-toggle="modal" data-target="#add-to-cart-modal-container"><i
                                                                        class="fa fa-shopping-cart"></i> Add to cart</a>
                                                        -->
                                                        </div>
                                                    </div>
                                            @endforeach


                                            <!-- end of single product -->


                                            </div>
                                            <!-- end of horizontal product slider container -->
                                        </div>
                                    </div>
                                </div>
                                <!-- end of horizontal product slider -->

                                <!-- homepage double banner section -->
                                <div class="homepage-banners mb-50">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-12 mb-20 mb-lg-0">
                                            <!-- ======  Homepage single split banner  ======= -->

                                            <div class="single-banner-container">
                                                <a href="shop-left-sidebar.html">
                                                    <img src="assets/images/banners/banner1.png" class="img-fluid" alt="">
                                                </a>
                                            </div>

                                            <!-- ====  End of Homepage single split banner  ==== -->

                                        </div>
                                        <div class="col-lg-6 col-md-12">
                                            <!-- ======  Homepage single split banner  ======= -->

                                            <div class="single-banner-container">
                                                <a href="shop-left-sidebar.html">
                                                    <img src="assets/images/banners/banner2.png" class="img-fluid" alt="">
                                                </a>
                                            </div>

                                            <!-- ====  End of Homepage single split banner  ==== -->

                                        </div>

                                    </div>
                                </div>
                        @endforeach

                        <!-- end of homepage double banner section -->

                            <!-- horizontal product slider -->

                            <!-- end of horizontal product slider -->

                            <!-- vertical slider container -->
                            <div class="vertical-product-slider-container">
                                <div class="row">
                                    @foreach ($categories as $c)
                                        <div class="col-lg-4">
                                            <!-- ======  single vertical product slider  ======= -->

                                            <div class="single-vertical-slider">
                                                <h2 class="block-title vertical-slider-block-title">{{$c->name}}</h2>
                                                <div class="vertical-product-list">
                                                    <!-- single vertical product -->

                                                    @foreach ($c->products as $p)
                                                        <div class="single-vertical-product d-flex">
                                                            <div class="product-image">
                                                                <a href="#"><img src="{{$p->image}}" class="img-fluid" alt=""></a>
                                                            </div>
                                                            <div class="product-description">
                                                                <h5 class="product-name">
                                                                    <a href="single-product-variable.html">{{$p->name}} </a></h5>
                                                                <div class="price-box">
                                                                    <h4>{{$p->price}}</h4>
                                                                </div>
                                                                <span onclick="ShoppingCart.add('{{ $p->id }}', 1)" class="add-to-cart-btn">                                                                    add to car
                                                                    <i class="fa fa-shopping-cart"></i>
                                                                </span>

                                                                <!-- end of single vertical product
                                                                    <a href="#" class="add-to-cart-btn" data-toggle="modal" data-target="#add-to-cart-modal-container">
                                                                    Add to cart</a>


                                                                -->

                                                            </div>
                                                        </div>
                                                @endforeach
                                                <!-- end of single vertical product -->
                                                    <!-- single vertical product -->

                                                    <!-- end of single vertical product -->
                                                </div>
                                            </div>

                                            <!-- ====  End of single vertical product slider  ==== -->

                                        </div>

                                    @endforeach
                                </div>
                            </div>
                            <!-- end of vertical slider container -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <!-- homepage wide banner section -->

                <div class="home-wide-bg-container mb-50">
                    <a class="banner-width-bg-link" href="#">
                        <img src="assets/images/banners/banner-wide.jpg" alt="">
                    </a>
                </div>

                <!-- end of homepage wide banner section -->
            </div>
        </div>

        <!-- latest product section -->

        <div class="latest-product-section  mb-50">
            <div class="row">
                <div class="col-lg-12">
                    <!-- Block title -->
                    <div class="block-title">
                        <h2>LATEST PRODUCTS</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-2 col-md-4 col-sm-6">
                    <!-- single latest product -->
                    <div class="single-latest-product">
                        <div class="product-image">
                            <a href="single-product-variable.html">
                                <img src="assets/images/products/1.jpg" class="img-fluid" alt="">
                                <img src="assets/images/products/2.jpg" class="img-fluid" alt="">
                            </a>
                        </div>
                        <div class="product-description">
                            <h5 class="product-name"><a href="#">Faded Short Sleeve</a></h5>
                            <div class="price-box">
                                <h4>$ 12.00</h4>
                            </div>
                        </div>

                        <div class="latest-product-hover-content">
                            <a href="#" data-toggle="modal" data-target="#add-to-cart-modal-container"><i class="fa fa-shopping-cart"></i>
                                Add to cart</a>
                            <p>
                                <a href="#" data-toggle="modal" data-target="#quick-view-modal-container">Quick View</a> | <a href="#">Wishlist</a>
                            </p>
                        </div>
                    </div>
                    <!-- end of single latest product -->
                </div>
                <div class="col-lg-2 col-md-4 col-sm-6">
                    <!-- single latest product -->
                    <div class="single-latest-product">
                        <div class="product-image">
                            <a href="single-product-variable.html">
                                <img src="assets/images/products/3.jpg" class="img-fluid" alt="">
                                <img src="assets/images/products/4.jpg" class="img-fluid" alt="">
                            </a>
                        </div>
                        <div class="product-description">
                            <h5 class="product-name"><a href="#">Faded Short Sleeve</a></h5>
                            <div class="price-box">
                                <h4>$ 12.00</h4>
                            </div>
                        </div>

                        <div class="latest-product-hover-content">
                            <a href="#" data-toggle="modal" data-target="#add-to-cart-modal-container"><i class="fa fa-shopping-cart"></i>
                                Add to cart</a>
                            <p>
                                <a href="#" data-toggle="modal" data-target="#quick-view-modal-container">Quick View</a> | <a href="#">Wishlist</a>
                            </p>
                        </div>
                    </div>
                    <!-- end of single latest product -->
                </div>
                <div class="col-lg-2 col-md-4 col-sm-6">
                    <!-- single latest product -->
                    <div class="single-latest-product">
                        <div class="product-image">
                            <a href="single-product-variable.html">
                                <img src="assets/images/products/5.jpg" class="img-fluid" alt="">
                                <img src="assets/images/products/6.jpg" class="img-fluid" alt="">
                            </a>
                        </div>
                        <div class="product-description">
                            <h5 class="product-name"><a href="#">Faded Short Sleeve</a></h5>
                            <div class="price-box">
                                <h4>$ 12.00</h4>
                            </div>
                        </div>

                        <div class="latest-product-hover-content">
                            <a href="#" data-toggle="modal" data-target="#add-to-cart-modal-container"><i class="fa fa-shopping-cart"></i>
                                Add to cart</a>
                            <p>
                                <a href="#" data-toggle="modal" data-target="#quick-view-modal-container">Quick View</a> | <a href="#">Wishlist</a>
                            </p>
                        </div>
                    </div>
                    <!-- end of single latest product -->
                </div>
                <div class="col-lg-2 col-md-4 col-sm-6">
                    <!-- single latest product -->
                    <div class="single-latest-product">
                        <div class="product-image">
                            <a href="single-product-variable.html">
                                <img src="assets/images/products/7.jpg" class="img-fluid" alt="">
                                <img src="assets/images/products/8.jpg" class="img-fluid" alt="">
                            </a>
                        </div>
                        <div class="product-description">
                            <h5 class="product-name"><a href="#">Faded Short Sleeve</a></h5>
                            <div class="price-box">
                                <h4>$ 12.00</h4>
                            </div>
                        </div>

                        <div class="latest-product-hover-content">
                            <a href="#" data-toggle="modal" data-target="#add-to-cart-modal-container"><i class="fa fa-shopping-cart"></i>
                                Add to cart</a>
                            <p>
                                <a href="#" data-toggle="modal" data-target="#quick-view-modal-container">Quick View</a> | <a href="#">Wishlist</a>
                            </p>
                        </div>
                    </div>
                    <!-- end of single latest product -->
                </div>
                <div class="col-lg-2 col-md-4 col-sm-6">
                    <!-- single latest product -->
                    <div class="single-latest-product">
                        <div class="product-image">
                            <a href="single-product-variable.html">
                                <img src="assets/images/products/9.jpg" class="img-fluid" alt="">
                                <img src="assets/images/products/10.jpg" class="img-fluid" alt="">
                            </a>
                        </div>
                        <div class="product-description">
                            <h5 class="product-name"><a href="#">Faded Short Sleeve</a></h5>
                            <div class="price-box">
                                <h4>$ 12.00</h4>
                            </div>
                        </div>

                        <div class="latest-product-hover-content">
                            <a href="#" data-toggle="modal" data-target="#add-to-cart-modal-container"><i class="fa fa-shopping-cart"></i>
                                Add to cart</a>
                            <p>
                                <a href="#" data-toggle="modal" data-target="#quick-view-modal-container">Quick View</a> | <a href="#">Wishlist</a>
                            </p>
                        </div>
                    </div>
                    <!-- end of single latest product -->
                </div>
                <div class="col-lg-2 col-md-4 col-sm-6">
                    <!-- single latest product -->
                    <div class="single-latest-product">
                        <div class="product-image">
                            <a href="single-product-variable.html">
                                <img src="assets/images/products/1.jpg" class="img-fluid" alt="">
                                <img src="assets/images/products/2.jpg" class="img-fluid" alt="">
                            </a>
                        </div>
                        <div class="product-description">
                            <h5 class="product-name"><a href="#">Faded Short Sleeve</a></h5>
                            <div class="price-box">
                                <h4>$ 12.00</h4>
                            </div>
                        </div>

                        <div class="latest-product-hover-content">
                            <a href="#" data-toggle="modal" data-target="#add-to-cart-modal-container"><i class="fa fa-shopping-cart"></i>
                                Add to cart</a>
                            <p>
                                <a href="#" data-toggle="modal" data-target="#quick-view-modal-container">Quick View</a> | <a href="#">Wishlist</a>
                            </p>
                        </div>
                    </div>
                    <!-- end of single latest product -->
                </div>
            </div>
        </div>

        <!-- end of latest product section -->
    </div>
</div>

<!--====  End of homepage content section  ====-->

<!--=======================================
=            brand logo slider            =
========================================-->







{!! PageBuilder::section('footer',['categories'=>$categories]) !!}
