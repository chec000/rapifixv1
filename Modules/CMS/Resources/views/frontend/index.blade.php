<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="format-detection" content="telephone=yes">

     <!-- Custom fonts for this template
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Merriweather:400,300,300italic,400italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>
    -->
        <!-- Plugin CSS -->
    <!-- Custom fonts for this template -->
         <link href="{{asset('cms/inicio/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
          <link href="{{asset('cms/inicio/css/font-awesome.min.css')}}" rel="stylesheet" type="text/css">
          <link href="{{asset('cms/inicio/css/icon-font.min.css')}}" rel="stylesheet" type="text/css">
          <link href="{{asset('cms/inicio/css/plugins.css')}}" rel="stylesheet" type="text/css">
          <link href="{{asset('cms/inicio/css/plugins.css')}}" rel="stylesheet" type="text/css">
          <link href="{{asset('cms/inicio/css/main.css')}}" rel="stylesheet" type="text/css">


        <script type="text/javascript" src="{{asset('cms/inicio/js/vendor/modernizr-2.8.3.min.js')}}"></script>
        <!-- Modernizer JS -->


    </head>

    <body>
    <div id="page">
        <div class="container">
            <div class="outer-row row">
                <div class="col-md-12">
                    <!--===================================
                    =            Header            		   =
                    =====================================-->

                    <header>
                        <!-- header top nav -->
                        <div class="header-top-nav">
                            <div class="container">
                                <div class="row">
                                    <div class="col-lg-3 offset-lg-3 col-md-6 col-sm-12">
                                        <!-- language and currency changer -->
                                        <div class="language-currency-changer d-flex justify-content-center justify-content-md-start justify-content-lg-center">
                                            <div class="language-changer">
                                                <img src="assets/images/flags/1.jpg" alt="">
                                                <a href="#" id="changeLanguage"><span id="languageName">English <i class="fa fa-caret-down"></i></span></a>
                                                <div class="language-currency-list hidden" id="languageList">
                                                    <ul>
                                                        <li><a href="#"><img src="assets/images/flags/1.jpg" alt=""> English</a></li>
                                                        <li><a href="#"><img src="assets/images/flags/2.jpg" alt=""> Français</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="currency-changer">
                                                <a href="#" id="changeCurrency"><span id="currencyName">USD <i class="fa fa-caret-down"></i></span></a>
                                                <div class="language-currency-list hidden" id="currencyList">
                                                    <ul>
                                                        <li><a href="#">USD</a></li>
                                                        <li><a href="#">EURO</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- end of language and currency changer -->
                                    </div>


                                    <div class="col-md-6 col-sm-12">
                                        <!-- user information menu -->
                                        <div class="user-information-menu">
                                            <ul>
                                                <li><a href="wishlist.html">My Wishlist</a> <span class="separator">|</span></li>
                                                <li><a href="checkout.html">Check Out</a> <span class="separator">|</span></li>
                                                <li><a href="cart.html">Cart (<span id="cart-status">Empty</span>)</a> <span class="separator">|</span></li>
                                                <li><a href="login-register.html">Sign In</a></li>
                                            </ul>
                                        </div>
                                        <!-- end of user information menu -->
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- end of header top nav -->

                        <!-- header bottom -->

                        <!-- header content -->
                        <div class="header-content">
                            <div class="container">
                                <div class="row">
                                    <div class="col-lg-3 col-md-4 offset-lg-0 text-md-left text-sm-center">
                                        <!-- logo -->
                                        <div class="logo">
                                            <a href="index.html"><img src="assets/images/logo.png" class="img-fluid" alt="logo"></a>
                                        </div>
                                        <!-- end of logo -->
                                    </div>
                                    <div class="col-lg-6 col-md-8">
                                        <!-- header search bar -->
                                        <div class="header-search-bar">
                                            <div class="input-group">
                                                <select name="categoryName" id="categoryName">
                                                    <option value="">Categories</option>
                                                    @foreach ($categories as $c)
                                                        <option value="{{$c->id}}}">{{$c->name}}</option>
                                                    @endforeach
                                                </select>
                                                <div class="input-group-append">
                                                    <input type="search" name="search">
                                                    <button type="submit"><i class="fa fa-search"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- end of header search bar -->
                                    </div>
                                    <div class="col-lg-3 col-md-4">
                                        <!-- shopping cart -->
                                        <div class="shopping-cart float-lg-right d-flex justify-content-start" id="shopping-cart">
                                            <div class="cart-icon">
                                                <a href="cart.html"><img src="assets/images/icon-topcart.png" class="img-fluid" alt=""></a>
                                            </div>
                                            <div class="cart-content">
                                                <h2><a href="cart.html">Shopping Cart <span><span id="cartStatus">(Empty)</span></span></a></h2>
                                            </div>

                                            <div class="cart-floating-box" id="cart-floating-box">
                                                <div class="cart-items">
                                                    <div class="cart-float-single-item d-flex">
                                                        <span class="remove-item"><a href="#"><i class="fa fa-trash"></i></a></span>
                                                        <div class="cart-float-single-item-image">
                                                            <img src="assets/images/products/faded-short-sleeve-tshirts.jpg" class="img-fluid" alt="">
                                                        </div>
                                                        <div class="cart-float-single-item-desc">
                                                            <p class="product-title"><span class="count">1x</span> <a href="single-product-variable.html">Printed
                                                                    Dress</a></p>
                                                            <p class="size"> <a href="shop-left-sidebar.html">Yellow, S</a></p>
                                                            <p class="price">$20.50</p>
                                                        </div>
                                                    </div>
                                                    <div class="cart-float-single-item d-flex">
                                                        <span class="remove-item"><a href="#"><i class="fa fa-trash"></i></a></span>
                                                        <div class="cart-float-single-item-image">
                                                            <img src="assets/images/products/faded-short-sleeve-tshirts.jpg" class="img-fluid" alt="">
                                                        </div>
                                                        <div class="cart-float-single-item-desc">
                                                            <p class="product-title"><span class="count">1x</span> <a href="single-product-variable.html">Printed
                                                                    Dress</a></p>
                                                            <p class="size"> <a href="shop-left-sidebar.html">Yellow, S</a></p>
                                                            <p class="price">$20.50</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="cart-calculation d-flex">
                                                    <div class="calculation-details">
                                                        <p class="shipping">Shipping <span>$2</span></p>
                                                        <p class="total">Total <span>$22</span></p>
                                                    </div>
                                                    <div class="checkout-button">
                                                        <a href="checkout.html">Checkout</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- end of shopping cart -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end of header content -->

                        <!-- header navigation section -->
                        <div class="header-navigation">
                            <div class="container">
                                <div class="navigation-container">
                                    <div class="row">
                                        <div class="col-lg-3 d-none d-lg-block">
                                            <!-- ======  Header menu left text  ======= -->
                                            <p class="call-us-text">Call us 24/7: (+66) 123-456-789</p>
                                        </div>
                                        <div class="col-lg-9 col-md-12">

                                            <!-- Header navigation right side-->

                                            <!-- main menu start -->
                                            <div class="main-menu">
                                                <nav>
                                                    <ul>
                                                        <li class="active menu-item-has-children"><a href="#">Home</a>

                                                            <!-- ======  Submenu block  ======= -->

                                                            <ul class="sub-menu">
                                                                <li class="active"><a href="index.html">Home One</a></li>
                                                                <li><a href="index-2.html">Home Two</a></li>
                                                                <li><a href="index-3.html">Home Three</a></li>
                                                            </ul>

                                                            <!-- ====  End of Submenu block  ==== -->

                                                        </li>
                                                        <li class="menu-item-has-children"><a href="#">Shop</a>

                                                            <!-- ======  Submenu block  ======= -->

                                                            <ul class="sub-menu">
                                                                <li class="menu-item-has-children"><a href="#">shop grid</a>
                                                                    <ul class="sub-menu">
                                                                        <li class="active"><a href="shop-left-sidebar.html">shop left sidebar</a></li>
                                                                        <li><a href="shop-left-sidebar-wide.html">shop left sidebar wide</a></li>
                                                                        <li><a href="shop-right-sidebar.html">shop right sidebar</a></li>
                                                                        <li><a href="shop-right-sidebar-wide.html">shop right sidebar wide</a></li>
                                                                        <li><a href="shop-no-sidebar-3.html">shop no sidebar 3 column</a></li>
                                                                        <li><a href="shop-no-sidebar-3-wide.html">shop no sidebar 3 column wide</a></li>
                                                                        <li><a href="shop-no-sidebar-4.html">shop no sidebar 4 column</a></li>
                                                                        <li><a href="shop-no-sidebar-4-wide.html">shop no sidebar 4 column wide</a></li>
                                                                        <li><a href="shop-no-sidebar-5.html">shop no sidebar 5 column</a></li>
                                                                        <li><a href="shop-no-sidebar-5-wide.html">shop no sidebar 5 column wide</a></li>
                                                                    </ul>
                                                                </li>
                                                                <li class="menu-item-has-children"><a href="#">shop List</a>
                                                                    <ul class="sub-menu">
                                                                        <li><a href="shop-list.html">shop list</a></li>
                                                                        <li><a href="shop-list-wide.html">shop list wide</a></li>
                                                                        <li><a href="shop-left-sidebar-list.html">shop left sidebar List</a></li>
                                                                        <li><a href="shop-left-sidebar-list-wide.html">shop left sidebar List wide</a></li>
                                                                        <li><a href="shop-right-sidebar-list.html">shop right sidebar List</a></li>
                                                                        <li><a href="shop-right-sidebar-list-wide.html">shop right sidebar List wide</a></li>
                                                                    </ul>
                                                                </li>
                                                                <li class="menu-item-has-children"><a href="#">Shop product</a>
                                                                    <ul class="sub-menu">
                                                                        <li><a href="single-product.html">shop product</a></li>
                                                                        <li><a href="single-product-wide.html">shop product wide</a></li>
                                                                        <li><a href="single-product-external.html">shop product external</a></li>
                                                                        <li><a href="single-product-external-wide.html">shop product external wide</a></li>
                                                                        <li><a href="single-product-variable.html">shop product variable</a></li>
                                                                        <li><a href="single-product-variable-wide.html">shop product variable wide</a></li>
                                                                        <li><a href="single-product-group.html">shop product group</a></li>
                                                                        <li><a href="single-product-group-wide.html">shop product group wide</a></li>
                                                                    </ul>
                                                                </li>
                                                            </ul>
                                                            <!-- ====  End of Submenu block  ==== -->

                                                        </li>
                                                        <li class="menu-item-has-children"><a href="#">Blog</a>
                                                            <!-- ======  Mega menu block  ======= -->
                                                            <ul class="mega-menu three-column">
                                                                <li><a href="#" class="d-none">Blog Box</a>
                                                                    <ul>
                                                                        <li><a href="blog-1-column-left-sidebar.html">Blog 1 column left sidebar</a></li>
                                                                        <li><a href="blog-1-column-right-sidebar.html">Blog 1 column right sidebar</a></li>
                                                                        <li><a href="blog-2-column-left-sidebar.html">Blog 2 column left sidebar</a></li>
                                                                        <li><a href="blog-2-column-right-sidebar.html">Blog 2 column right sidebar</a></li>
                                                                        <li><a href="blog-3-column.html">Blog 3 column</a></li>
                                                                    </ul>
                                                                </li>
                                                                <li><a href="#" class="d-none">Blog Wide</a>
                                                                    <ul>
                                                                        <li><a href="blog-1-column-left-sidebar-wide.html">Blog 1 column left sidebar wide</a></li>
                                                                        <li><a href="blog-1-column-right-sidebar-wide.html">Blog 1 column right sidebar wide</a></li>
                                                                        <li><a href="blog-2-column-left-sidebar-wide.html">Blog 2 column left sidebar wide</a></li>
                                                                        <li><a href="blog-2-column-right-sidebar-wide.html">Blog 2 column right sidebar wide</a></li>
                                                                        <li><a href="blog-3-column-wide.html">Blog 3 column wide</a></li>
                                                                    </ul>
                                                                </li>
                                                                <li><a href="#" class="d-none">Single Blog</a>
                                                                    <ul>
                                                                        <li><a href="single-blog-left-sidebar.html">Single blog left sidebar</a></li>
                                                                        <li><a href="single-blog-left-sidebar-wide.html">Single blog left sidebar wide</a></li>
                                                                        <li><a href="single-blog-right-sidebar.html">Single blog right sidebar</a></li>
                                                                        <li><a href="single-blog-right-sidebar-wide.html">Single blog right sidebar wide</a></li>
                                                                    </ul>
                                                                </li>
                                                            </ul>
                                                            <!-- ====  End of Mega menu block  ==== -->
                                                        </li>

                                                        <li class="menu-item-has-children"><a href="#">Pages</a>
                                                            <!-- ======  Submenu block  ======= -->

                                                            <ul class="sub-menu">
                                                                <li><a href="cart.html">cart</a></li>
                                                                <li><a href="cart-wide.html">cart wide</a></li>
                                                                <li><a href="checkout.html">checkout</a></li>
                                                                <li><a href="checkout-wide.html">checkout wide</a></li>
                                                                <li><a href="compare.html">compare</a></li>
                                                                <li><a href="compare-wide.html">compare wide</a></li>
                                                                <li><a href="store.html">store</a></li>
                                                                <li><a href="store-wide.html">store wide</a></li>
                                                                <li><a href="wishlist.html">wishlist</a></li>
                                                                <li><a href="wishlist-wide.html">wishlist wide</a></li>
                                                                <li><a href="my-account.html">My account</a></li>
                                                                <li><a href="my-account-wide.html">My account wide</a></li>
                                                                <li><a href="login-register.html">Login register</a></li>
                                                                <li><a href="login-register-wide.html">Login register wide</a></li>
                                                            </ul>

                                                            <!-- ====  End of Submenu block  ==== -->
                                                        </li>
                                                        <li><a href="about.html">About</a></li>
                                                        <li><a href="contact.html">Contact</a></li>
                                                    </ul>
                                                </nav>

                                                <!-- Mobile Menu -->
                                                <div class="mobile-menu order-12 d-block d-lg-none"></div>

                                            </div>

                                            <!-- end of Header navigation right side-->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end of header navigation section -->

                        <!-- end of header bottom -->
                    </header>

                    <!--=====  End of Header  ======-->

                    <!--===========================================
                    =            homepage content section            =
                    ============================================-->

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
                                                            <li><a href="shop-left-sidebar.html">{{$c->name}}</a></li>

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

                                                                                <a href="#" class="add-to-cart-btn" data-toggle="modal" data-target="#add-to-cart-modal-container"><i
                                                                                            class="fa fa-shopping-cart"></i> Add to cart</a>
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
                                                                                    <a href="#" class="add-to-cart-btn" data-toggle="modal" data-target="#add-to-cart-modal-container"><i
                                                                                                class="fa fa-shopping-cart"></i> Add to cart</a>
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

                    <div class="brand-logo-slider mb-50">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-12 col-sm-12">
                                    <div class="brand-logo-list">
                                        <!-- ======  single brand logo block  ======= -->

                                        <div class="single-brand-logo">
                                            <a href="#">
                                                <img src="assets/images/brand-logos/1.jpg" alt="">
                                            </a>
                                        </div>

                                        <!-- ====  End of single brand logo block  ==== -->
                                        <!-- ======  single brand logo block  ======= -->

                                        <div class="single-brand-logo">
                                            <a href="#">
                                                <img src="assets/images/brand-logos/2.jpg" alt="">
                                            </a>
                                        </div>

                                        <!-- ====  End of single brand logo block  ==== -->
                                        <!-- ======  single brand logo block  ======= -->

                                        <div class="single-brand-logo">
                                            <a href="#">
                                                <img src="assets/images/brand-logos/3.jpg" alt="">
                                            </a>
                                        </div>

                                        <!-- ====  End of single brand logo block  ==== -->
                                        <!-- ======  single brand logo block  ======= -->

                                        <div class="single-brand-logo">
                                            <a href="#">
                                                <img src="assets/images/brand-logos/4.jpg" alt="">
                                            </a>
                                        </div>

                                        <!-- ====  End of single brand logo block  ==== -->
                                        <!-- ======  single brand logo block  ======= -->

                                        <div class="single-brand-logo">
                                            <a href="#">
                                                <img src="assets/images/brand-logos/5.jpg" alt="">
                                            </a>
                                        </div>

                                        <!-- ====  End of single brand logo block  ==== -->
                                        <!-- ======  single brand logo block  ======= -->

                                        <div class="single-brand-logo">
                                            <a href="#">
                                                <img src="assets/images/brand-logos/6.jpg" alt="">
                                            </a>
                                        </div>

                                        <!-- ====  End of single brand logo block  ==== -->
                                        <!-- ======  single brand logo block  ======= -->

                                        <div class="single-brand-logo">
                                            <a href="#">
                                                <img src="assets/images/brand-logos/7.jpg" alt="">
                                            </a>
                                        </div>

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
                                                    <h2>newsletter <span>Sign up for our newsletter</span></h2>
                                                </div>
                                                <!-- end of newsletter text -->

                                                <!-- newsletter input -->
                                                <div class="newsletter-input">
                                                    <div class="input-group">
                                                        <div class="input-group-append">
                                                            <form id="mc-form" class="mc-form subscribe-form">
                                                                <input type="email" id="mc-email" type="email" autocomplete="off" placeholder="Enter your e-mail"
                                                                       required>
                                                                <button id="mc-submit" type="submit">Subscribe</button>
                                                            </form>

                                                        </div>
                                                    </div>
                                                    <!-- mailchimp-alerts Start -->
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
                                                <img src="assets/images/logo.png" alt="">
                                            </div>
                                            <p>This is Photoshop's version of Lorem Ipsum. Proin gravida nibh vel velit auctor aliquet. Aenean
                                                sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis sem nibh id elit...</p>
                                        </div>
                                        <!-- end of footer description -->
                                    </div>
                                    <div class="col-lg-8 col-md-8">
                                        <!-- footer nav links -->
                                        <div class="row">
                                            <div class="col-lg-3 col-md-6">
                                                <!-- single footer nav block -->
                                                <div class="single-footer-nav-block">
                                                    <h2 class="block-title">INFORMATION</h2>
                                                    <ul class="footer-nav-links">
                                                        <li><a href="shop-left-sidebar.html">Specials</a></li>
                                                        <li><a href="shop-left-sidebar.html">New Products</a></li>
                                                        <li><a href="shop-left-sidebar.html">Best Sellers</a></li>
                                                        <li><a href="contact.html">Contact Us</a></li>
                                                        <li><a href="about.html">About Us</a></li>
                                                    </ul>
                                                </div>
                                                <!-- end of single footer nav block -->
                                            </div>
                                            <div class="col-lg-3 col-md-6">
                                                <!-- single footer nav block -->
                                                <div class="single-footer-nav-block">
                                                    <h2 class="block-title"><a href="my-account.html">MY ACCOUNT</a></h2>
                                                    <ul class="footer-nav-links">
                                                        <li><a href="#">My Orders</a></li>
                                                        <li><a href="#">My Credit Slips</a></li>
                                                        <li><a href="my-account.html">My Addresses</a></li>
                                                        <li><a href="my-account.html">My Personal Info</a></li>
                                                    </ul>
                                                </div>
                                                <!-- end of single footer nav block -->
                                            </div>
                                            <div class="col-lg-3 col-md-6">
                                                <!-- single footer nav block -->
                                                <div class="single-footer-nav-block">
                                                    <h2 class="block-title">CATEGORIES</h2>
                                                    <ul class="footer-nav-links">
                                                        <li><a href="shop-left-sidebar.html">Football</a></li>
                                                        <li><a href="shop-left-sidebar.html">Tennis</a></li>
                                                        <li><a href="shop-left-sidebar.html">Formula</a></li>
                                                        <li><a href="shop-left-sidebar.html">Cricket</a></li>
                                                        <li><a href="shop-left-sidebar.html">Baseball</a></li>
                                                    </ul>
                                                </div>
                                                <!-- end of single footer nav block -->
                                            </div>
                                            <div class="col-lg-3 col-md-6">
                                                <!-- single footer nav block -->
                                                <div class="single-footer-nav-block">
                                                    <h2 class="block-title">OUR SERVICES</h2>
                                                    <ul class="footer-nav-links">
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
                                            <p class="copyright-text text-center text-md-left">Copyright © 2018 <a href="#">Rossi</a>. All Rights Reserved</p>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <div class="payment-logos text-md-right text-center">
                                                <img src="assets/images/payment.png" alt="payment logo">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end of copyright section -->
                            </div>
                        </div>
                    </footer>

                    <!--====  End of footer  ====-->
                </div>
            </div>
        </div>
    </div>


    <!-- quick view modal -->
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
                                <h2 class="cart-success-message"> Product successfully added to your shopping cart</h2>
                                <div class="cart-product-short-desc-content d-flex">
                                    <div class="product-image">
                                        <img src="assets/images/products/faded-short-sleeve-tshirts.jpg" class="img-fluid" alt="">
                                    </div>
                                    <div class="product-desc">
                                        <h4 class="product-title">Printed Dress</h4>
                                        <p class="color-size">Yellow, S</p>
                                        <p class="quantity"><span>Quantity</span> 1</p>
                                        <p class="total-amount"><span>Total:</span> $20.40</p>
                                    </div>
                                </div>
                            </div>
                            <!-- end of cart product short details -->
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <!-- cart product calculation -->
                            <div class="cart-product-calculation">
                                <h2 class="cart-info-message">There is 1 item in your cart.</h2>
                                <div class="product-calculations">
                                    <p><span>Total products</span> $20.50</p>
                                    <p><span>Total shipping</span> $2</p>
                                    <p><span>Total</span> $22.50</p>
                                </div>
                            </div>
                            <!-- end of cart product calculation -->

                            <!-- cart modal buttons -->
                            <div class="cart-modal-buttons">
                                <a class="continue-shopping-btn" href="shop-left-sidebar.html"><i class="fa fa-chevron-left"></i> Continue
                                    shopping</a>
                                <a class="proceed-checkout-btn" href="checkout.html">Proceed to checkout <i class="fa fa-chevron-right"></i>
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


    <!-- scroll to top  -->
    <a href="#" class="scroll-top"></a>
    <!-- end of scroll to top -->



    <!-- ************************* JS ************************* -->
    <!-- jQuery JS -->

        <script type="text/javascript"  src="{{asset('cms/inicio/js/vendor/jquery.min.js')}}"></script>
        <script type="text/javascript" src="{{asset('cms/inicio/js/vendor/modernizr-2.8.3.min.js')}}"></script>
        <script type="text/javascript" src="{{asset('cms/inicio/js/popper.min.js')}}"></script>
        <script type="text/javascript" src="{{asset('cms/inicio/js/vendor/modernizr-2.8.3.min.js')}}"></script>
        <script type="text/javascript" src="{{asset('cms/inicio/js/bootstrap.min.js')}}"></script>
        <script type="text/javascript" src="{{asset('cms/inicio/js/plugins.js')}}"></script>
        <script type="text/javascript" src="{{asset('cms/inicio/js/main.js')}}"></script>

    </body>

</html>


