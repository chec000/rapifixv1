<header>
    <!-- header top nav -->
    <div class="header-top-nav">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 offset-lg-3 col-md-6 col-sm-12" >
                    <!-- language and currency changer -->
                    <div class="language-currency-changer d-flex justify-content-center justify-content-md-start justify-content-lg-center" style="display: none;">
                        <div class="language-changer" ">
                            <img src="" alt="">
                            <a href="#" id="changeLanguage"><span id="languageName">English <i class="fa fa-caret-down"></i></span></a>
                            <div class="language-currency-list hidden" id="languageList" >
                                <ul style="display: none;">
                                    <li><a href="#"><img src="assets/images/flags/1.jpg" alt=""> English</a></li>
                                    <li><a href="#"><img src="assets/images/flags/2.jpg" alt=""> Français</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="currency-changer" style="display: none;">
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
                            <li><a href="wishlist.html">Lista de deseos</a> <span class="separator">|</span></li>
                            <li><a href="{{route('cart.list')}}" >Check Out</a> <span class="separator">|</span></li>
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
                        <a href="/"><img src="{{asset('cms/app/img/logo.png')}}" class="img-fluid" alt="logo"></a>
                    </div>
                    <!-- end of logo -->
                </div>
                <div class="col-lg-6 col-md-8">
                    <!-- header search bar -->
                    <div class="header-search-bar">
                        <form action="{{route('products.search')}}" method="GET">
                        <div class="input-group">
                            <select name="category" id="categoryName" required="required">
                                <option value="">Categorias</option>
                                @foreach ($categories as $c)
                                    <option value="{{$c->id}}}"><a href="{{route('category.products', ['id' => $c->id])}}">{{$c->name}}</a></option>
                                @endforeach
                            </select>
                            <div class="input-group-append">
                                <input type="search" name="search" required="required">
                                <button type="submit"><i class="fa fa-search"></i></button>
                            </div>
                        </div>                      
                        </form>

                    </div>
                    <!-- end of header search bar -->
                </div>
                <div class="col-lg-3 col-md-4">
                    <!-- shopping cart -->
                    {!! PageBuilder::section('cart',['cart'=>$cart]) !!}

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
                        <p class="call-us-text" style="display: none;">Call us 24/7: (+66) 123-456-789</p>
                    </div>
                    <div class="col-lg-9 col-md-12">

                        <!-- Header navigation right side-->

                        <!-- main menu start -->
                        <div class="main-menu">
                            <nav>
                                <ul>
                                    <li class="active menu-item-has-children"><a href="{{url('/')}}">Home</a>

                                        <!-- ======  Submenu block  ======= -->

                                        <ul style="display: none;" class="sub-menu">
                                            <li class="active"><a href="/">Home One</a></li>
                                            <li><a href="index-2.html">Home Two</a></li>
                                            <li><a href="index-3.html">Home Three</a></li>
                                        </ul>

                                        <!-- ====  End of Submenu block  ==== -->

                                    </li>
                                    <li class="menu-item-has-children" style="display:none"><a href="#">Shop</a>

                                        <!-- ======  Submenu block  ======= -->

                                        <ul style="display: none;" class="sub-menu">
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
                                    <li style="display: none"  class="menu-item-has-children"><a href="#">Blog</a>
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

                                    <li class="menu-item-has-children" style="display: none" ><a href="#">Pages</a>
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
                                    <li><a href="about.html">Acerca de </a></li>
                                    <li><a href="contact.html">Contacto</a></li>
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
