{!! PageBuilder::section('head', [
'categories' => $categories,
'cart'=>$cart,

]) !!}


<section class="single-product-page-content">
    <div class="container">
        <div class="row">

            <div class="col-lg-9 col-md-12">
                <div class="row">
                    <div class="col-lg-5 col-md-7">
                     <div class="single-product-img img-full">
                        <img src="{{$countryProduct->image}}" class="img-fluid" alt="">
                        <a href="{{$countryProduct->image}}" class="big-image-popup"><i class="fa fa-search-plus"></i></a>
                    </div>

                </div>
                <div class="col-lg-7 col-md-5">
                    <!-- product quick view description -->
                    <div class="product-options">
                        <h2 class="product-title">{{$countryProduct->name}}</h2>
                        <p class="condition"><span>Condition:</span> New</p>
                        <h2 class="product-price">${{$countryProduct->price}}</h2>
                        <p class="product-description">
                            {{$countryProduct->description}}
                        </p>

                        <div class="single-product-user-action" style="display: none;">
                            <ul>
                                <li><a href="#"> <i class="fa fa-envelope-o"></i> Send to a
                                friend</a></li>
                                <li><a href="#"> <i class="fa fa-print"></i> Print</a></li>
                                <li><a href="#"> <i class="fa fa-heart-o"></i> Add to wishlist</a></li>
                            </ul>
                        </div>
                        <div class="social-share-buttons" style="display: none;">
                            <ul>
                                <li><a class="twitter" href="#"><i class="fa fa-twitter"></i>
                                Tweet</a></li>
                                <li><a class="facebook" href="#"><i class="fa fa-facebook"></i>
                                Share</a></li>
                                <li><a class="google-plus" href="#"><i class="fa fa-google-plus"></i>
                                Google+</a></li>
                                <li><a class="pinterest" href="#"><i class="fa fa-pinterest"></i>
                                Pinterest</a></li>
                            </ul>
                        </div>
                        <p class="stock-details">288 items <span class="stock-status in-stock">In
                        Stock</span></p>
                        <p style="display: none"  class="quantity">Quantity:

                            <span class="pro-qty counter">
                                <input type="text" value="" class="mr-5">

                            </span>

                        </p>
                        <p class="size" style="display: none;">
                            Size: <br>
                            <select name="chooseSize" id="chooseSize">
                                <option value="0">XXL</option>
                                <option value="0">L</option>
                                <option value="0">M</option>
                                <option value="0">S</option>
                            </select>
                        </p>
                        <p class="color" style="display: none;">
                            Color: <br>
                            <a href="#"><span class="color-block color-choice-1"></span></a>
                            <a href="#"><span class="color-block color-choice-2"></span></a>
                            <a href="#"><span class="color-block color-choice-3 active"></span></a>
                        </p>
                        
                        <span onclick="ShoppingCart.add('{{ $countryProduct->id }}', 1)" class="add-to-cart-btn">
                            <i class="fa fa-shopping-cart"></i>
                            Add to Cart
                        </span>

                    </div>
                    <!-- end ofproduct quick view description -->
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="product-description-tab-container section-padding">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#more-info" role="tab" aria-selected="true">MORE
                                INFO</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#data-sheet" role="tab" aria-selected="false">DATASHEET</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="contact-tab" data-toggle="tab" href="#reviews" role="tab" aria-selected="false">REVIEWS</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="more-info" role="tabpanel" aria-labelledby="home-tab">
                                <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit.
                                    Aliquam alias libero temporibus sit repellat delectus eos
                                    velit odit natus fugiat porro tempora, dignissimos ex quo
                                    laborum explicabo consequatur aperiam doloribus nostrum
                                    quae? Eos, adipisci quisquam iusto ex quasi odit mollitia,
                                    pariatur expedita eligendi necessitatibus hic voluptatum.
                                Nobis a dolor temporibus.</p>
                            </div>
                            <div class="tab-pane fade" id="data-sheet" role="tabpanel" aria-labelledby="profile-tab">
                                <table class="table-data-sheet">
                                    <tbody>
                                        <tr class="odd">

                                            <td>Compositions</td>
                                            <td>Polyester</td>
                                        </tr>
                                        <tr class="even">

                                            <td>Styles</td>
                                            <td>Girly</td>
                                        </tr>
                                        <tr class="odd">

                                            <td>Properties</td>
                                            <td>Midi Dress</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="tab-pane fade" id="reviews" role="tabpanel" aria-labelledby="contact-tab">
                                <div class="product-ratting-wrap">
                                    <div class="pro-avg-ratting">
                                        <h4>4.5 <span>(Overall)</span></h4>
                                        <span>Based on 9 Comments</span>
                                    </div>
                                    <div class="ratting-list">
                                        <div class="sin-list float-left">
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <span>(5)</span>
                                        </div>
                                        <div class="sin-list float-left">
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star-o"></i>
                                            <span>(3)</span>
                                        </div>
                                        <div class="sin-list float-left">
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star-o"></i>
                                            <i class="fa fa-star-o"></i>
                                            <span>(1)</span>
                                        </div>
                                        <div class="sin-list float-left">
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star-o"></i>
                                            <i class="fa fa-star-o"></i>
                                            <i class="fa fa-star-o"></i>
                                            <span>(0)</span>
                                        </div>
                                        <div class="sin-list float-left">
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star-o"></i>
                                            <i class="fa fa-star-o"></i>
                                            <i class="fa fa-star-o"></i>
                                            <i class="fa fa-star-o"></i>
                                            <span>(0)</span>
                                        </div>
                                    </div>
                                    <div class="rattings-wrapper">

                                        <div class="sin-rattings">
                                            <div class="ratting-author">
                                                <h3>Cristopher Lee</h3>
                                                <div class="ratting-star">
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <span>(5)</span>
                                                </div>
                                            </div>
                                            <p>enim ipsam voluptatem quia voluptas sit
                                                aspernatur aut odit aut fugit, sed quia res eos
                                                qui ratione voluptatem sequi Neque porro
                                                quisquam est, qui dolorem ipsum quia dolor sit
                                            amet, consectetur, adipisci veli</p>
                                        </div>

                                        <div class="sin-rattings">
                                            <div class="ratting-author">
                                                <h3>Nirob Khan</h3>
                                                <div class="ratting-star">
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <span>(5)</span>
                                                </div>
                                            </div>
                                            <p>enim ipsam voluptatem quia voluptas sit
                                                aspernatur aut odit aut fugit, sed quia res eos
                                                qui ratione voluptatem sequi Neque porro
                                                quisquam est, qui dolorem ipsum quia dolor sit
                                            amet, consectetur, adipisci veli</p>
                                        </div>

                                        <div class="sin-rattings">
                                            <div class="ratting-author">
                                                <h3>MD.ZENAUL ISLAM</h3>
                                                <div class="ratting-star">
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <span>(5)</span>
                                                </div>
                                            </div>
                                            <p>enim ipsam voluptatem quia voluptas sit
                                                aspernatur aut odit aut fugit, sed quia res eos
                                                qui ratione voluptatem sequi Neque porro
                                                quisquam est, qui dolorem ipsum quia dolor sit
                                            amet, consectetur, adipisci veli</p>
                                        </div>

                                    </div>
                                    <div class="ratting-form-wrapper fix">
                                        <h3>Add your Comments</h3>
                                        <form action="#">
                                            <div class="ratting-form row">
                                                <div class="col-12 mb-15">
                                                    <h5>Rating:</h5>
                                                    <div class="ratting-star fix">
                                                        <i class="fa fa-star-o"></i>
                                                        <i class="fa fa-star-o"></i>
                                                        <i class="fa fa-star-o"></i>
                                                        <i class="fa fa-star-o"></i>
                                                        <i class="fa fa-star-o"></i>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-12 mb-15">
                                                    <label for="name">Name:</label>
                                                    <input id="name" placeholder="Name" type="text">
                                                </div>
                                                <div class="col-md-6 col-12 mb-15">
                                                    <label for="email">Email:</label>
                                                    <input id="email" placeholder="Email" type="text">
                                                </div>
                                                <div class="col-12 mb-15">
                                                    <label for="your-review">Your Review:</label>
                                                    <textarea name="review" id="your-review" placeholder="Write a review"></textarea>
                                                </div>
                                                <div class="col-12">
                                                    <input value="add review" type="submit">
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- related horizontal product slider -->
            <div class="horizontal-product-slider" >
                <div class="row">
                    <div class="col-lg-12">
                        <div class="block-title">
                            <h2><a href="#">RELATED PRODUCTS</a></h2>
                        </div>
                    </div>
                </div>
                <div class="row">

                   <div class="col-lg-12">
                    <!-- horizontal product slider container -->
                    <div class="horizontal-product-list">
                        @foreach ($relatedProducts as $pr)
                        <div class="single-product">
                            <div class="single-product-content">
                                <div class="product-image">
                                    <a href="{{route('products.detail', ['product_slug' => $pr->relatedProduct->slug])}}">
                                        <img src="{{$pr->relatedProduct->image}}" class="img-fluid" alt="">

                                    </a>
                                    <div class="image-btn">


                                        <a href="#" data-toggle="modal" data-target="#quick-view-modal-container"><i class="fa fa-search"></i></a>
                                        <a href="#"><i class="fa fa-heart-o"></i></a>

                                    </div>
                                </div>
                                <h5 class="product-name"><a href="{{route('products.detail', ['product_slug' => $pr->relatedProduct->slug])}}">{{$pr->relatedProduct->name}}</a></h5>
                                <div class="price-box">
                                    <h4>{{$pr->relatedProduct->price}}</h4>
                                </div>
                                <span onclick="ShoppingCart.add('{{ $pr->relatedProduct->id }}', 1)" class="add-to-cart-btn">                                Agregar al carrito
                                    <i class="fa fa-shopping-cart"></i>
                                </span>

                            </div>
                        </div>
                        @endforeach

                    </div>
                </div>

            </div>
        </div>
        <!-- end of related horizontal product slider -->
    </div>

    <div class="col-lg-3 col-md-4">
        <!-- ======  Single product sidebar  ====== -->

        <div class="single-product-page-sidebar">
            <!-- vertical auto slider container -->
             <div class="sidebar">
                            <h2 class="block-title">LATEST PRODUCTS</h2>
                            <div class="vertical-product-slider-container">
                                <div class="single-vertical-slider">
                                    <div class="vertical-auto-slider-product-list">
                                        <!-- single vertical product -->
                                        @foreach($latest as $lp)
                                        <div class="single-auto-vertical-product d-flex">
                                            <div class="product-image">
                                                <a href="{{route('products.detail', ['product_slug' => $lp->slug])}}"><img src="{{asset($lp->image)}}" class="img-fluid" alt=""></a>
                                            </div>
                                            <div class="product-description">
                                                <h5 class="product-name"><a href="single-product-variable.html">
                                                    {{$lp->name}}
                                                </a></h5>
                                                <div class="price-box">
                                                    <h4>$ {{$lp->price}}</h4>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                        
                                        <!-- end of single vertical product -->

                                    </div>
                                </div>
                            </div>
                        </div>
           
            <!-- end of vertical auto slider container -->


            <!-- homepage sidebar banner -->
            <div class="sidebar">
                <div class="homepage-sidebar-banner-container mb-50">
                    <a href="shop-left-sidebar.html">
                        <img src="assets/images/banners/banner-left.jpg" class="img-fluid" alt="">
                    </a>
                </div>
            </div>
            <!-- end of homepage sidebar banner -->

            <!-- tag container -->
            <div class="sidebar">
                <h2 class="block-title">TAGS</h2>
                <div class="tag-container">
                    <ul>
                        <li><a href="shop-left-sidebar-wide.html">new</a> </li>
                        <li><a href="shop-left-sidebar-wide.html">bags</a> </li>
                        <li><a href="shop-left-sidebar-wide.html">new</a> </li>
                        <li><a href="shop-left-sidebar-wide.html">kids</a> </li>
                        <li><a href="shop-left-sidebar-wide.html">fashion</a> </li>
                        <li><a href="shop-left-sidebar-wide.html">Accessories</a> </li>
                    </ul>
                </div>
            </div>
            <!-- end of tag container -->


        </div>

        <!-- ====  End of Single product sidebar  ==== -->

    </div>
</div>
</div>
</section>





<a href="#" class="scroll-top" style="display: inline;"></a>


{!! PageBuilder::section('footer',['categories'=>$categories]) !!}
