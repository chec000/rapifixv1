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
                                <button class="category-toggle">Categorias <i class="ti-menu"></i></button>
                            </div>
                            <!-- Category Menu -->
                            <nav class="category-menu mb-40">
                                <ul>
                                    @foreach ($categories as $c)
                                    <li class="{{(count($c['children'])>0)?'menu-item-has-children':''}}"><a href="{{route('category.products', ['id' => $c->id])}}">{{$c->name}}</a>
                                     @if((count($c['children'])>0))   
                                     <ul class="category-mega-menu">
                                        @foreach ($c['children'] as $h)
                                        <li class="menu-item-has-children">

                                          <a class="megamenu-head" href="{{route('category.products', ['id' => $h->id])}}"

                                              >
                                              {{$h->name}}
                                          </a>
                                          @if(count($h->products))
                                          <ul>
                                             @foreach ($h->products as $p)
                                             <li><a href="{{route('products.detail', ['product_slug' => $p->slug])}}">
                                                 {{$p->name}}
                                             </a>
                                         </li>
                                         @endforeach


                                     </ul>
                                     @endif

                                     @endforeach
                                 </ul>
                                 @endif
                             </li>

                             @endforeach

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
                                <h1></h1>
                                <h2><span></span></h2>
                                <p>
                                    
                                </p>
                                <a ></a>
                            </div>
                        </div>
                    </div><!-- Hero Item End -->

                    <!-- Hero Item Start -->
                    <div class="hero-item hero-bg-2">
                        <div class="row align-items-center justify-content-between">
                            <!-- Hero Content -->
                            <div class="hero-content col-md-8 offset-md-4 col-sm-12 offset-sm-0">
                                <h1></h1>
                                <h2><span></span></h2>
                                <p></p>
                                <a ></a>
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
                                    <h3></h3>
                                    <p> </p>
                                    <a ></a>
                                </div>
                            </div>
                            <!-- end of single feature -->
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <!-- single-feature -->
                            <div class="single-featured-service featured-service-bg-2">
                                <div class="single-featured-service-content">
                                    <h3></h3>
                                    <p> </p>
                                    <a ></a>
                                </div>
                            </div>
                            <!-- end of single feature -->
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <!-- single-feature -->
                            <div class="single-featured-service featured-service-bg-3">
                                <div class="single-featured-service-content">
                                    <h3></h3>
                                    <p> </p>
                                    <a ></a>
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
                                    @if(count($c->products))
                    <div class="sidebar">
                        <h2 class="block-title">{{$c->name}}</h2>
                        <div class="vertical-product-slider-container">
                            <div class="single-vertical-slider">
                                <div class="vertical-auto-slider-product-list">
                                    <!-- single vertical product -->

                                    @foreach ($c->products as $p)

                                    <div class="single-auto-vertical-product d-flex">
                                        <div class="product-image">


                                            <a href="{{route('products.detail', ['product_slug' => $p->slug])}}">
                                                <img src="{{$p->image}}" class="img-fluid" alt=""></a>
                                            </div>
                                            <div class="product-description">
                                                <h5 class="product-name">
                                                    <a href="{{route('products.detail', ['product_slug' => $p->slug])}}">
                                                        {{$p->name}}
                                                    </a></h5>
                                                    <div class="price-box">
                                                        <h4>{{$p->price}}</h4>
                                                    </div>

                                                </div>
                                            </div>
                                            @endforeach   
                                
                                        </div>
                                    </div>
                                </div>
                            </div>
                                    @endif
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
                                <h2 class="block-title">Productos nuevos</h2>
                                <div class="vertical-product-slider-container">
                                    <div class="single-vertical-slider">
                                        <div class="vertical-auto-slider-product-list">
                                             @if(count($latest))
                                            @foreach($latest as $lp)
                                            <div class="single-auto-vertical-product d-flex">
                                                <div class="product-image">
                                                    <a href="{{route('products.detail', ['product_slug' => $lp->slug])}}"><img src="{{asset($lp->image)}}" class="img-fluid" alt=""></a>
                                                </div>
                                                <div class="product-description">
                                                    <h5 class="product-name"><a href="{{route('products.detail', ['product_slug' => $lp->slug])}}">
                                                        {{$lp->name}}
                                                    </a></h5>
                                                    <div class="price-box">
                                                        <h4>$ {{$lp->price}}</h4>
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                                @endif
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
                                          @if(count($c->products))
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
                                                        <a href="{{route('products.detail', ['product_slug' => $p->slug])}}">
                                                            <img src="{{$p->image}}" class="img-fluid" alt="">

                                                        </a>
                                                        <div class="image-btn">


                                                            <a href="#" data-toggle="modal" data-target="#quick-view-modal-container"><i class="fa fa-search"></i></a>
                                                            <a href="#"><i class="fa fa-heart-o"></i></a>

                                                        </div>
                                                    </div>
                                                    <h5 class="product-name"><a href="{{route('products.detail', ['product_slug' => $p->slug])}}">{{$p->name}}</a></h5>
                                                    <div class="price-box">
                                                        <h4>{{$p->price}}</h4>
                                                    </div>
                                                    <span onclick="ShoppingCart.add('{{ $p->id }}', 1)" class="add-to-cart-btn">    
                                                        Agregar al carrito
                                                        <i class="fa fa-shopping-cart"></i>
                                                    </span>

                                                </div>
                                            </div>
                                            @endforeach


                                            <!-- end of single product -->


                                        </div>
                                        <!-- end of horizontal product slider container -->
                                    </div>
                                </div>
                            </div>
                                          @endif
                          
                            <!-- end of horizontal product slider -->

                            <!-- homepage double banner section -->
                            <div class="homepage-banners mb-50" style="display: none">
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
                                    
                                  @if(count($c->products))
                                    <div class="col-lg-4">
                                        <!-- ======  single vertical product slider  ======= -->

                                        <div class="single-vertical-slider">
                                            <h2 class="block-title vertical-slider-block-title">{{$c->name}}</h2>
                                            <div class="vertical-product-list">
                                                <!-- single vertical product -->

                                                @foreach ($c->products as $p)
                                                <div class="single-vertical-product d-flex">
                                                    <div class="product-image">
                                                        <a href="{{route('products.detail', ['product_slug' => $p->slug])}}"><img src="{{$p->image}}" class="img-fluid" alt=""></a>
                                                    </div>
                                                    <div class="product-description">
                                                        <h5 class="product-name">
                                                            <a href="{{route('products.detail', ['product_slug' => $p->slug])}}">{{$p->name}} </a></h5>
                                                            <div class="price-box">
                                                                <h4>{{$p->price}}</h4>
                                                            </div>
                                                            <span onclick="ShoppingCart.add('{{ $p->id }}', 1)" class="add-to-cart-btn">   
                                                                Agregar al carrito
                                                                <i class="fa fa-shopping-cart"></i>
                                                            </span>
                                                            </div>
                                                        </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                       
                                                      @endif
                               
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
                                <img src="{{ asset('cms/inicio/images/banners/banner-wide.jpg') }}" alt="">
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
                                <h2>Productos recientes</h2>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        @foreach($latest as $lp)

                        <div class="col-lg-2 col-md-4 col-sm-6">
                            <!-- single latest product -->

                            <div class="single-latest-product">
                                <div class="product-image">
                                    <a href="{{route('products.detail', ['product_slug' => $lp->slug])}}">
                                        <img src="{{asset($lp->image)}}" class="img-fluid" alt="">
                                        <img src="{{asset($lp->image)}}" class="img-fluid" alt="">
                                    </a>
                                </div>
                                <div class="product-description">
                                    <h5 class="product-name"><a href="#">{{$lp->name}}</a></h5>
                                    <div class="price-box">
                                        <h4>$ {{$lp->price}}</h4>
                                    </div>
                                </div>

                                <div class="latest-product-hover-content">
                                    <span onclick="ShoppingCart.add('{{ $lp->id }}', 1)">
                                        
                                        <i class="fa fa-shopping-cart"></i>
                                        Agregar al carrito
                                    </span>
                                    <p style="display: none;">
                                        <a href="#" data-toggle="modal" data-target="#quick-view-modal-container">Quick View</a> | <a href="#">Wishlist</a>
                                    </p>
                                </div>
                            </div>
                            <!-- end of single latest product -->
                        </div>
                        @endforeach
                        
                        
                    </div>
                </div>
            </div>
        </div>

{!! PageBuilder::section('footer',['categories'=>$categories]) !!}
