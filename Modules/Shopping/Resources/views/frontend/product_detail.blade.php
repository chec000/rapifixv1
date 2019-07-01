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

                        <div class="single-product-page-image-gallery">
                            <!-- product quickview image gallery -->
                            <!--Modal Tab Content Start-->
                            <div class="tab-content product-details-large  sale-badge new-badge">
                                <div class="tab-pane fade show active" id="single-slide1" role="tabpanel" aria-labelledby="single-slide-tab-1">
                                    <!--Single Product Image Start-->
                                    <div class="single-product-img img-full sale-badge new-badge">
                                        <img src="{{$countryProduct->name}}" class="img-fluid" alt="">
                                        <a href="assets/images/product-slider-images/image1.jpg" class="big-image-popup"><i class="fa fa-search-plus"></i></a>
                                    </div>
                                    <!--Single Product Image End-->
                                </div>
                                <div class="tab-pane fade" id="single-slide2" role="tabpanel" aria-labelledby="single-slide-tab-2">
                                    <!--Single Product Image Start-->
                                    <div class="single-product-img img-full">
                                        <img src="assets/images/product-slider-images/image2.jpg" class="img-fluid" alt="">
                                        <a href="assets/images/product-slider-images/image2.jpg" class="big-image-popup"><i class="fa fa-search-plus"></i></a>
                                    </div>
                                    <!--Single Product Image End-->
                                </div>
                                <div class="tab-pane fade" id="single-slide3" role="tabpanel" aria-labelledby="single-slide-tab-3">
                                    <!--Single Product Image Start-->
                                    <div class="single-product-img img-full">
                                        <img src="assets/images/product-slider-images/image3.jpg" class="img-fluid" alt="">
                                        <a href="assets/images/product-slider-images/image3.jpg" class="big-image-popup"><i class="fa fa-search-plus"></i></a>
                                    </div>
                                    <!--Single Product Image End-->
                                </div>
                                <div class="tab-pane fade" id="single-slide4" role="tabpanel" aria-labelledby="single-slide-tab-4">
                                    <!--Single Product Image Start-->
                                    <div class="single-product-img img-full">
                                        <img src="assets/images/product-slider-images/image4.jpg" class="img-fluid" alt="">
                                        <a href="assets/images/product-slider-images/image4.jpg" class="big-image-popup"><i class="fa fa-search-plus"></i></a>
                                    </div>
                                    <!--Single Product Image End-->
                                </div>
                            </div>
                            <!--Modal Content End-->
                            <!--Modal Tab Menu Start-->

                            <div class="single-product-menu">
                                <div class="nav single-slide-menu slick-initialized slick-slider" role="tablist"><i class="fa fa-angle-left slick-arrow" style=""></i>
                                    <div class="slick-list draggable"><div class="slick-track" style="opacity: 1; width: 979px; transform: translate3d(-267px, 0px, 0px);"><div class="single-tab-menu img-full slick-slide slick-cloned" data-slick-index="-3" aria-hidden="true" tabindex="-1" style="width: 89px;">
                                                <a data-toggle="tab" id="" href="#single-slide2" tabindex="-1"><img src="assets/images/product-slider-images/image2.jpg" class="img-fluid" alt=""></a>
                                            </div><div class="single-tab-menu img-full slick-slide slick-cloned" data-slick-index="-2" aria-hidden="true" tabindex="-1" style="width: 89px;">
                                                <a data-toggle="tab" id="" href="#single-slide3" tabindex="-1"><img src="assets/images/product-slider-images/image3.jpg" class="img-fluid" alt=""></a>
                                            </div><div class="single-tab-menu img-full slick-slide slick-cloned" data-slick-index="-1" aria-hidden="true" tabindex="-1" style="width: 89px;">
                                                <a data-toggle="tab" id="" href="#single-slide4" tabindex="-1"><img src="assets/images/product-slider-images/image4.jpg" alt=""></a>
                                            </div><div class="single-tab-menu img-full slick-slide slick-current slick-active" data-slick-index="0" aria-hidden="false" tabindex="0" style="width: 89px;">
                                                <a data-toggle="tab" id="single-slide-tab-1" href="#single-slide1" tabindex="0"><img src="assets/images/product-slider-images/image1.jpg" class="img-fluid" alt=""></a>
                                            </div><div class="single-tab-menu img-full slick-slide slick-active" data-slick-index="1" aria-hidden="false" tabindex="0" style="width: 89px;">
                                                <a data-toggle="tab" id="single-slide-tab-2" href="#single-slide2" tabindex="0"><img src="assets/images/product-slider-images/image2.jpg" class="img-fluid" alt=""></a>
                                            </div><div class="single-tab-menu img-full slick-slide slick-active" data-slick-index="2" aria-hidden="false" tabindex="0" style="width: 89px;">
                                                <a data-toggle="tab" id="single-slide-tab-3" href="#single-slide3" tabindex="0"><img src="assets/images/product-slider-images/image3.jpg" class="img-fluid" alt=""></a>
                                            </div><div class="single-tab-menu img-full slick-slide" data-slick-index="3" aria-hidden="true" tabindex="-1" style="width: 89px;">
                                                <a data-toggle="tab" id="single-slide-tab-4" href="#single-slide4" tabindex="-1"><img src="assets/images/product-slider-images/image4.jpg" alt=""></a>
                                            </div><div class="single-tab-menu img-full slick-slide slick-cloned" data-slick-index="4" aria-hidden="true" tabindex="-1" style="width: 89px;">
                                                <a data-toggle="tab" id="" href="#single-slide1" tabindex="-1"><img src="assets/images/product-slider-images/image1.jpg" class="img-fluid" alt=""></a>
                                            </div><div class="single-tab-menu img-full slick-slide slick-cloned" data-slick-index="5" aria-hidden="true" tabindex="-1" style="width: 89px;">
                                                <a data-toggle="tab" id="" href="#single-slide2" tabindex="-1"><img src="assets/images/product-slider-images/image2.jpg" class="img-fluid" alt=""></a>
                                            </div><div class="single-tab-menu img-full slick-slide slick-cloned" data-slick-index="6" aria-hidden="true" tabindex="-1" style="width: 89px;">
                                                <a data-toggle="tab" id="" href="#single-slide3" tabindex="-1"><img src="assets/images/product-slider-images/image3.jpg" class="img-fluid" alt=""></a>
                                            </div><div class="single-tab-menu img-full slick-slide slick-cloned" data-slick-index="7" aria-hidden="true" tabindex="-1" style="width: 89px;">
                                                <a data-toggle="tab" id="" href="#single-slide4" tabindex="-1"><img src="assets/images/product-slider-images/image4.jpg" alt=""></a>
                                            </div></div></div>



                                    <i class="fa fa-angle-right slick-next-btn slick-arrow" style=""></i></div>
                            </div>
                            <!--Modal Tab Menu End-->
                            <!-- end of product quickview image gallery -->
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

                            <div class="single-product-user-action">
                                <ul>
                                    <li><a href="#"> <i class="fa fa-envelope-o"></i> Send to a
                                            friend</a></li>
                                    <li><a href="#"> <i class="fa fa-print"></i> Print</a></li>
                                    <li><a href="#"> <i class="fa fa-heart-o"></i> Add to wishlist</a></li>
                                </ul>
                            </div>
                            <div class="social-share-buttons">
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
                            <p class="quantity">Quantity:

                                <span class="pro-qty counter"><input type="text" value="1" class="mr-5"><a href="#" class="inc qty-btn mr-5"><i class="fa fa-plus"></i></a><a href="#" class="dec qty-btn"><i class="fa fa-minus"></i></a></span>

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
                <div class="horizontal-product-slider">
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
                            <div class="horizontal-product-list slick-initialized slick-slider"><i class="fa fa-angle-left slick-prev-btn slick-arrow" style=""></i>
                                <!-- single product -->
                                <div class="slick-list draggable"><div class="slick-track" style="opacity: 1; width: 2814px; transform: translate3d(-804px, 0px, 0px);"><div class="single-product slick-slide slick-cloned" data-slick-index="-4" aria-hidden="true" tabindex="-1" style="width: 201px;">
                                            <div class="single-product-content single-related-product-content">
                                                <div class="product-image">
                                                    <a href="single-product-variable.html" tabindex="-1">
                                                        <img src="assets/images/products/3.jpg" class="img-fluid" alt="">
                                                        <img src="assets/images/products/4.jpg" class="img-fluid" alt="">
                                                    </a>
                                                    <div class="image-btn">
                                                        <a href="#" tabindex="-1"><i class="fa fa-search"></i></a>
                                                        <a href="#" tabindex="-1"><i class="fa fa-heart-o"></i></a>
                                                    </div>
                                                </div>
                                                <h5 class="product-name"><a href="single-product-variable.html" tabindex="-1">Printed
                                                        Dress</a></h5>
                                                <div class="price-box">
                                                    <h4>$ 12.00</h4>
                                                </div>

                                                <span onclick="ShoppingCart.add('{{ $countryProduct->id }}', 1)" class="add-to-cart-btn">
                                <i class="fa fa-shopping-cart"></i>
                                Add to Cart
                            </span>
                                            </div>
                                        </div><div class="single-product slick-slide slick-cloned" data-slick-index="-3" aria-hidden="true" tabindex="-1" style="width: 201px;">
                                            <div class="single-product-content single-related-product-content">
                                                <div class="product-image">
                                                    <a href="single-product-variable.html" tabindex="-1">
                                                        <img src="assets/images/products/5.jpg" class="img-fluid" alt="">
                                                        <img src="assets/images/products/6.jpg" class="img-fluid" alt="">
                                                    </a>
                                                    <div class="image-btn">
                                                        <a href="#" tabindex="-1"><i class="fa fa-search"></i></a>
                                                        <a href="#" tabindex="-1"><i class="fa fa-heart-o"></i></a>
                                                    </div>
                                                </div>
                                                <h5 class="product-name"><a href="single-product-variable.html" tabindex="-1">Faded
                                                        Short Sleeve</a></h5>
                                                <div class="price-box">
                                                    <h4>$ 12.00</h4>
                                                </div>
                                                <span onclick="ShoppingCart.add('{{ $countryProduct->id }}', 1)" class="add-to-cart-btn">
                                <i class="fa fa-shopping-cart"></i>
                                Add to Cart
                            </span>
                                            </div>
                                        </div><div class="single-product slick-slide slick-cloned" data-slick-index="-2" aria-hidden="true" tabindex="-1" style="width: 201px;">
                                            <div class="single-product-content single-related-product-content">
                                                <div class="product-image">
                                                    <a href="single-product-variable.html" tabindex="-1">
                                                        <img src="assets/images/products/7.jpg" class="img-fluid" alt="">
                                                        <img src="assets/images/products/8.jpg" class="img-fluid" alt="">
                                                    </a>
                                                    <div class="image-btn">
                                                        <a href="#" tabindex="-1"><i class="fa fa-search"></i></a>
                                                        <a href="#" tabindex="-1"><i class="fa fa-heart-o"></i></a>
                                                    </div>
                                                </div>
                                                <h5 class="product-name"><a href="single-product-variable.html" tabindex="-1">Printed
                                                        Dress</a></h5>
                                                <div class="price-box">
                                                    <h4>$ 12.00</h4>
                                                </div>

                                                <a href="#" class="add-to-cart-btn" tabindex="-1"><i class="fa fa-shopping-cart"></i>
                                                    Add to cart</a>
                                            </div>
                                        </div><div class="single-product slick-slide slick-cloned" data-slick-index="-1" aria-hidden="true" tabindex="-1" style="width: 201px;">
                                            <div class="single-product-content single-related-product-content">
                                                <div class="product-image">
                                                    <a href="single-product-variable.html" tabindex="-1">
                                                        <img src="assets/images/products/9.jpg" class="img-fluid" alt="">
                                                        <img src="assets/images/products/10.jpg" class="img-fluid" alt="">
                                                    </a>
                                                    <div class="image-btn">
                                                        <a href="#" tabindex="-1"><i class="fa fa-search"></i></a>
                                                        <a href="#" tabindex="-1"><i class="fa fa-heart-o"></i></a>
                                                    </div>
                                                </div>
                                                <h5 class="product-name"><a href="single-product-variable.html" tabindex="-1">Faded
                                                        Short Sleeve</a></h5>
                                                <div class="price-box">
                                                    <h4>$ 12.00</h4>
                                                </div>

                                                <a href="#" class="add-to-cart-btn" tabindex="-1"><i class="fa fa-shopping-cart"></i>
                                                    Add to cart</a>
                                            </div>
                                        </div><div class="single-product slick-slide slick-current slick-active" data-slick-index="0" aria-hidden="false" tabindex="0" style="width: 201px;">
                                            <div class="single-product-content single-related-product-content">
                                                <div class="product-image">
                                                    <a href="single-product-variable.html" tabindex="0">
                                                        <img src="assets/images/products/1.jpg" class="img-fluid" alt="">
                                                        <img src="assets/images/products/2.jpg" class="img-fluid" alt="">
                                                    </a>
                                                    <div class="image-btn">
                                                        <a href="#" tabindex="0"><i class="fa fa-search"></i></a>
                                                        <a href="#" tabindex="0"><i class="fa fa-heart-o"></i></a>
                                                    </div>
                                                </div>
                                                <h5 class="product-name"><a href="single-product-variable.html" tabindex="0">Faded
                                                        Short Sleeve</a></h5>
                                                <div class="price-box">
                                                    <h4>$ 12.00</h4>
                                                </div>

                                                <a href="#" class="add-to-cart-btn" tabindex="0"><i class="fa fa-shopping-cart"></i>
                                                    Add to cart</a>
                                            </div>
                                        </div><div class="single-product slick-slide slick-active" data-slick-index="1" aria-hidden="false" tabindex="0" style="width: 201px;">
                                            <div class="single-product-content single-related-product-content">
                                                <div class="product-image">
                                                    <a href="single-product-variable.html" tabindex="0">
                                                        <img src="assets/images/products/3.jpg" class="img-fluid" alt="">
                                                        <img src="assets/images/products/4.jpg" class="img-fluid" alt="">
                                                    </a>
                                                    <div class="image-btn">
                                                        <a href="#" tabindex="0"><i class="fa fa-search"></i></a>
                                                        <a href="#" tabindex="0"><i class="fa fa-heart-o"></i></a>
                                                    </div>
                                                </div>
                                                <h5 class="product-name"><a href="single-product-variable.html" tabindex="0">Printed
                                                        Dress</a></h5>
                                                <div class="price-box">
                                                    <h4>$ 12.00</h4>
                                                </div>

                                                <a href="#" class="add-to-cart-btn" tabindex="0"><i class="fa fa-shopping-cart"></i>
                                                    Add to cart</a>
                                            </div>
                                        </div><div class="single-product slick-slide slick-active" data-slick-index="2" aria-hidden="false" tabindex="0" style="width: 201px;">
                                            <div class="single-product-content single-related-product-content">
                                                <div class="product-image">
                                                    <a href="single-product-variable.html" tabindex="0">
                                                        <img src="assets/images/products/5.jpg" class="img-fluid" alt="">
                                                        <img src="assets/images/products/6.jpg" class="img-fluid" alt="">
                                                    </a>
                                                    <div class="image-btn">
                                                        <a href="#" tabindex="0"><i class="fa fa-search"></i></a>
                                                        <a href="#" tabindex="0"><i class="fa fa-heart-o"></i></a>
                                                    </div>
                                                </div>
                                                <h5 class="product-name"><a href="single-product-variable.html" tabindex="0">Faded
                                                        Short Sleeve</a></h5>
                                                <div class="price-box">
                                                    <h4>$ 12.00</h4>
                                                </div>

                                                <a href="#" class="add-to-cart-btn" tabindex="0"><i class="fa fa-shopping-cart"></i>
                                                    Add to cart</a>
                                            </div>
                                        </div><div class="single-product slick-slide slick-active" data-slick-index="3" aria-hidden="false" tabindex="0" style="width: 201px;">
                                            <div class="single-product-content single-related-product-content">
                                                <div class="product-image">
                                                    <a href="single-product-variable.html" tabindex="0">
                                                        <img src="assets/images/products/7.jpg" class="img-fluid" alt="">
                                                        <img src="assets/images/products/8.jpg" class="img-fluid" alt="">
                                                    </a>
                                                    <div class="image-btn">
                                                        <a href="#" tabindex="0"><i class="fa fa-search"></i></a>
                                                        <a href="#" tabindex="0"><i class="fa fa-heart-o"></i></a>
                                                    </div>
                                                </div>
                                                <h5 class="product-name"><a href="single-product-variable.html" tabindex="0">Printed
                                                        Dress</a></h5>
                                                <div class="price-box">
                                                    <h4>$ 12.00</h4>
                                                </div>

                                                <a href="#" class="add-to-cart-btn" tabindex="0"><i class="fa fa-shopping-cart"></i>
                                                    Add to cart</a>
                                            </div>
                                        </div><div class="single-product slick-slide" data-slick-index="4" aria-hidden="true" tabindex="-1" style="width: 201px;">
                                            <div class="single-product-content single-related-product-content">
                                                <div class="product-image">
                                                    <a href="single-product-variable.html" tabindex="-1">
                                                        <img src="assets/images/products/9.jpg" class="img-fluid" alt="">
                                                        <img src="assets/images/products/10.jpg" class="img-fluid" alt="">
                                                    </a>
                                                    <div class="image-btn">
                                                        <a href="#" tabindex="-1"><i class="fa fa-search"></i></a>
                                                        <a href="#" tabindex="-1"><i class="fa fa-heart-o"></i></a>
                                                    </div>
                                                </div>
                                                <h5 class="product-name"><a href="single-product-variable.html" tabindex="-1">Faded
                                                        Short Sleeve</a></h5>
                                                <div class="price-box">
                                                    <h4>$ 12.00</h4>
                                                </div>

                                                <a href="#" class="add-to-cart-btn" tabindex="-1"><i class="fa fa-shopping-cart"></i>
                                                    Add to cart</a>
                                            </div>
                                        </div><div class="single-product slick-slide slick-cloned" data-slick-index="5" aria-hidden="true" tabindex="-1" style="width: 201px;">
                                            <div class="single-product-content single-related-product-content">
                                                <div class="product-image">
                                                    <a href="single-product-variable.html" tabindex="-1">
                                                        <img src="assets/images/products/1.jpg" class="img-fluid" alt="">
                                                        <img src="assets/images/products/2.jpg" class="img-fluid" alt="">
                                                    </a>
                                                    <div class="image-btn">
                                                        <a href="#" tabindex="-1"><i class="fa fa-search"></i></a>
                                                        <a href="#" tabindex="-1"><i class="fa fa-heart-o"></i></a>
                                                    </div>
                                                </div>
                                                <h5 class="product-name"><a href="single-product-variable.html" tabindex="-1">Faded
                                                        Short Sleeve</a></h5>
                                                <div class="price-box">
                                                    <h4>$ 12.00</h4>
                                                </div>

                                                <a href="#" class="add-to-cart-btn" tabindex="-1"><i class="fa fa-shopping-cart"></i>
                                                    Add to cart</a>
                                            </div>
                                        </div><div class="single-product slick-slide slick-cloned" data-slick-index="6" aria-hidden="true" tabindex="-1" style="width: 201px;">
                                            <div class="single-product-content single-related-product-content">
                                                <div class="product-image">
                                                    <a href="single-product-variable.html" tabindex="-1">
                                                        <img src="assets/images/products/3.jpg" class="img-fluid" alt="">
                                                        <img src="assets/images/products/4.jpg" class="img-fluid" alt="">
                                                    </a>
                                                    <div class="image-btn">
                                                        <a href="#" tabindex="-1"><i class="fa fa-search"></i></a>
                                                        <a href="#" tabindex="-1"><i class="fa fa-heart-o"></i></a>
                                                    </div>
                                                </div>
                                                <h5 class="product-name"><a href="single-product-variable.html" tabindex="-1">Printed
                                                        Dress</a></h5>
                                                <div class="price-box">
                                                    <h4>$ 12.00</h4>
                                                </div>

                                                <a href="#" class="add-to-cart-btn" tabindex="-1"><i class="fa fa-shopping-cart"></i>
                                                    Add to cart</a>
                                            </div>
                                        </div><div class="single-product slick-slide slick-cloned" data-slick-index="7" aria-hidden="true" tabindex="-1" style="width: 201px;">
                                            <div class="single-product-content single-related-product-content">
                                                <div class="product-image">
                                                    <a href="single-product-variable.html" tabindex="-1">
                                                        <img src="assets/images/products/5.jpg" class="img-fluid" alt="">
                                                        <img src="assets/images/products/6.jpg" class="img-fluid" alt="">
                                                    </a>
                                                    <div class="image-btn">
                                                        <a href="#" tabindex="-1"><i class="fa fa-search"></i></a>
                                                        <a href="#" tabindex="-1"><i class="fa fa-heart-o"></i></a>
                                                    </div>
                                                </div>
                                                <h5 class="product-name"><a href="single-product-variable.html" tabindex="-1">Faded
                                                        Short Sleeve</a></h5>
                                                <div class="price-box">
                                                    <h4>$ 12.00</h4>
                                                </div>

                                                <a href="#" class="add-to-cart-btn" tabindex="-1"><i class="fa fa-shopping-cart"></i>
                                                    Add to cart</a>
                                            </div>
                                        </div><div class="single-product slick-slide slick-cloned" data-slick-index="8" aria-hidden="true" tabindex="-1" style="width: 201px;">
                                            <div class="single-product-content single-related-product-content">
                                                <div class="product-image">
                                                    <a href="single-product-variable.html" tabindex="-1">
                                                        <img src="assets/images/products/7.jpg" class="img-fluid" alt="">
                                                        <img src="assets/images/products/8.jpg" class="img-fluid" alt="">
                                                    </a>
                                                    <div class="image-btn">
                                                        <a href="#" tabindex="-1"><i class="fa fa-search"></i></a>
                                                        <a href="#" tabindex="-1"><i class="fa fa-heart-o"></i></a>
                                                    </div>
                                                </div>
                                                <h5 class="product-name"><a href="single-product-variable.html" tabindex="-1">Printed
                                                        Dress</a></h5>
                                                <div class="price-box">
                                                    <h4>$ 12.00</h4>
                                                </div>

                                                <a href="#" class="add-to-cart-btn" tabindex="-1"><i class="fa fa-shopping-cart"></i>
                                                    Add to cart</a>
                                            </div>
                                        </div><div class="single-product slick-slide slick-cloned" data-slick-index="9" aria-hidden="true" tabindex="-1" style="width: 201px;">
                                            <div class="single-product-content single-related-product-content">
                                                <div class="product-image">
                                                    <a href="single-product-variable.html" tabindex="-1">
                                                        <img src="assets/images/products/9.jpg" class="img-fluid" alt="">
                                                        <img src="assets/images/products/10.jpg" class="img-fluid" alt="">
                                                    </a>
                                                    <div class="image-btn">
                                                        <a href="#" tabindex="-1"><i class="fa fa-search"></i></a>
                                                        <a href="#" tabindex="-1"><i class="fa fa-heart-o"></i></a>
                                                    </div>
                                                </div>
                                                <h5 class="product-name"><a href="single-product-variable.html" tabindex="-1">Faded
                                                        Short Sleeve</a></h5>
                                                <div class="price-box">
                                                    <h4>$ 12.00</h4>
                                                </div>

                                                <a href="#" class="add-to-cart-btn" tabindex="-1"><i class="fa fa-shopping-cart"></i>
                                                    Add to cart</a>
                                            </div>
                                        </div></div></div>
                                <!-- end of single product -->
                                <!-- single product -->

                                <!-- end of single product -->
                                <!-- single product -->

                                <!-- end of single product -->
                                <!-- single product -->

                                <!-- end of single product -->
                                <!-- single product -->

                                <!-- end of single product -->


                                <i class="fa fa-angle-right slick-next-btn slick-arrow" style=""></i></div>
                            <!-- end of horizontal product slider container -->
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
                        <h2 class="block-title">BESTSELLER</h2>
                        <div class="vertical-product-slider-container mb-50">

                            <div class="single-vertical-slider">

                                <div class="vertical-auto-slider-product-list slick-initialized slick-slider slick-vertical">
                                    <!-- single vertical product -->
                                    <div class="slick-list draggable" style="height: 330px;"><div class="slick-track" style="opacity: 1; height: 1870px; transform: translate3d(0px, -770px, 0px); transition: transform 500ms ease 0s;"><div class="single-auto-vertical-product d-flex slick-slide slick-cloned" data-slick-index="-3" aria-hidden="true" tabindex="-1" style="width: 248px;">
                                                <div class="product-image">
                                                    <a href="single-product-variable.html" tabindex="-1"><img src="assets/images/products/5.jpg" class="img-fluid" alt=""></a>
                                                </div>
                                                <div class="product-description">
                                                    <h5 class="product-name"><a href="single-product-variable.html" tabindex="-1">Faded
                                                            Short Sleeve</a></h5>
                                                    <div class="price-box">
                                                        <h4>$ 12.00</h4>
                                                    </div>

                                                </div>
                                            </div><div class="single-auto-vertical-product d-flex slick-slide slick-cloned" data-slick-index="-2" aria-hidden="true" tabindex="-1" style="width: 248px;">
                                                <div class="product-image">
                                                    <a href="single-product-variable.html" tabindex="-1"><img src="assets/images/products/6.jpg" class="img-fluid" alt=""></a>
                                                </div>
                                                <div class="product-description">
                                                    <h5 class="product-name"><a href="single-product-variable.html" tabindex="-1">Printed
                                                            Dress</a></h5>
                                                    <div class="price-box">
                                                        <h4>$ 12.00</h4>
                                                    </div>

                                                </div>
                                            </div><div class="single-auto-vertical-product d-flex slick-slide slick-cloned" data-slick-index="-1" aria-hidden="true" tabindex="-1" style="width: 248px;">
                                                <div class="product-image">
                                                    <a href="single-product-variable.html" tabindex="-1"><img src="assets/images/products/7.jpg" class="img-fluid" alt=""></a>
                                                </div>
                                                <div class="product-description">
                                                    <h5 class="product-name"><a href="single-product-variable.html" tabindex="-1">Faded
                                                            Short Sleeve</a></h5>
                                                    <div class="price-box">
                                                        <h4>$ 12.00</h4>
                                                    </div>

                                                </div>
                                            </div><div class="single-auto-vertical-product d-flex slick-slide" data-slick-index="0" aria-hidden="true" tabindex="-1" style="width: 248px;">
                                                <div class="product-image">
                                                    <a href="single-product-variable.html" tabindex="-1"><img src="assets/images/products/1.jpg" class="img-fluid" alt=""></a>
                                                </div>
                                                <div class="product-description">
                                                    <h5 class="product-name"><a href="single-product-variable.html" tabindex="-1">Faded
                                                            Short Sleeve</a></h5>
                                                    <div class="price-box">
                                                        <h4>$ 12.00</h4>
                                                    </div>

                                                </div>
                                            </div><div class="single-auto-vertical-product d-flex slick-slide" data-slick-index="1" aria-hidden="true" tabindex="-1" style="width: 248px;">
                                                <div class="product-image">
                                                    <a href="single-product-variable.html" tabindex="-1"><img src="assets/images/products/2.jpg" class="img-fluid" alt=""></a>
                                                </div>
                                                <div class="product-description">
                                                    <h5 class="product-name"><a href="single-product-variable.html" tabindex="-1">Printed
                                                            Dress</a></h5>
                                                    <div class="price-box">
                                                        <h4>$ 12.00</h4>
                                                    </div>

                                                </div>
                                            </div><div class="single-auto-vertical-product d-flex slick-slide" data-slick-index="2" aria-hidden="true" tabindex="-1" style="width: 248px;">
                                                <div class="product-image">
                                                    <a href="single-product-variable.html" tabindex="-1"><img src="assets/images/products/3.jpg" class="img-fluid" alt=""></a>
                                                </div>
                                                <div class="product-description">
                                                    <h5 class="product-name"><a href="single-product-variable.html" tabindex="-1">Faded
                                                            Short Sleeve</a></h5>
                                                    <div class="price-box">
                                                        <h4>$ 12.00</h4>
                                                    </div>

                                                </div>
                                            </div><div class="single-auto-vertical-product d-flex slick-slide" data-slick-index="3" aria-hidden="true" tabindex="0" style="width: 248px;">
                                                <div class="product-image">
                                                    <a href="single-product-variable.html" tabindex="0"><img src="assets/images/products/4.jpg" class="img-fluid" alt=""></a>
                                                </div>
                                                <div class="product-description">
                                                    <h5 class="product-name"><a href="single-product-variable.html" tabindex="0">Printed
                                                            Dress</a></h5>
                                                    <div class="price-box">
                                                        <h4>$ 12.00</h4>
                                                    </div>

                                                </div>
                                            </div><div class="single-auto-vertical-product d-flex slick-slide slick-active" data-slick-index="4" aria-hidden="false" tabindex="0" style="width: 248px;">
                                                <div class="product-image">
                                                    <a href="single-product-variable.html" tabindex="0"><img src="assets/images/products/5.jpg" class="img-fluid" alt=""></a>
                                                </div>
                                                <div class="product-description">
                                                    <h5 class="product-name"><a href="single-product-variable.html" tabindex="0">Faded
                                                            Short Sleeve</a></h5>
                                                    <div class="price-box">
                                                        <h4>$ 12.00</h4>
                                                    </div>

                                                </div>
                                            </div><div class="single-auto-vertical-product d-flex slick-slide slick-active" data-slick-index="5" aria-hidden="false" tabindex="0" style="width: 248px;">
                                                <div class="product-image">
                                                    <a href="single-product-variable.html" tabindex="0"><img src="assets/images/products/6.jpg" class="img-fluid" alt=""></a>
                                                </div>
                                                <div class="product-description">
                                                    <h5 class="product-name"><a href="single-product-variable.html" tabindex="0">Printed
                                                            Dress</a></h5>
                                                    <div class="price-box">
                                                        <h4>$ 12.00</h4>
                                                    </div>

                                                </div>
                                            </div><div class="single-auto-vertical-product d-flex slick-slide slick-current slick-active" data-slick-index="6" aria-hidden="false" tabindex="-1" style="width: 248px;">
                                                <div class="product-image">
                                                    <a href="single-product-variable.html" tabindex="-1"><img src="assets/images/products/7.jpg" class="img-fluid" alt=""></a>
                                                </div>
                                                <div class="product-description">
                                                    <h5 class="product-name"><a href="single-product-variable.html" tabindex="-1">Faded
                                                            Short Sleeve</a></h5>
                                                    <div class="price-box">
                                                        <h4>$ 12.00</h4>
                                                    </div>

                                                </div>
                                            </div><div class="single-auto-vertical-product d-flex slick-slide slick-cloned" data-slick-index="7" aria-hidden="true" tabindex="-1" style="width: 248px;">
                                                <div class="product-image">
                                                    <a href="single-product-variable.html" tabindex="-1"><img src="assets/images/products/1.jpg" class="img-fluid" alt=""></a>
                                                </div>
                                                <div class="product-description">
                                                    <h5 class="product-name"><a href="single-product-variable.html" tabindex="-1">Faded
                                                            Short Sleeve</a></h5>
                                                    <div class="price-box">
                                                        <h4>$ 12.00</h4>
                                                    </div>

                                                </div>
                                            </div><div class="single-auto-vertical-product d-flex slick-slide slick-cloned" data-slick-index="8" aria-hidden="true" tabindex="-1" style="width: 248px;">
                                                <div class="product-image">
                                                    <a href="single-product-variable.html" tabindex="-1"><img src="assets/images/products/2.jpg" class="img-fluid" alt=""></a>
                                                </div>
                                                <div class="product-description">
                                                    <h5 class="product-name"><a href="single-product-variable.html" tabindex="-1">Printed
                                                            Dress</a></h5>
                                                    <div class="price-box">
                                                        <h4>$ 12.00</h4>
                                                    </div>

                                                </div>
                                            </div><div class="single-auto-vertical-product d-flex slick-slide slick-cloned" data-slick-index="9" aria-hidden="true" tabindex="-1" style="width: 248px;">
                                                <div class="product-image">
                                                    <a href="single-product-variable.html" tabindex="-1"><img src="assets/images/products/3.jpg" class="img-fluid" alt=""></a>
                                                </div>
                                                <div class="product-description">
                                                    <h5 class="product-name"><a href="single-product-variable.html" tabindex="-1">Faded
                                                            Short Sleeve</a></h5>
                                                    <div class="price-box">
                                                        <h4>$ 12.00</h4>
                                                    </div>

                                                </div>
                                            </div><div class="single-auto-vertical-product d-flex slick-slide slick-cloned" data-slick-index="10" aria-hidden="true" tabindex="-1" style="width: 248px;">
                                                <div class="product-image">
                                                    <a href="single-product-variable.html" tabindex="-1"><img src="assets/images/products/4.jpg" class="img-fluid" alt=""></a>
                                                </div>
                                                <div class="product-description">
                                                    <h5 class="product-name"><a href="single-product-variable.html" tabindex="-1">Printed
                                                            Dress</a></h5>
                                                    <div class="price-box">
                                                        <h4>$ 12.00</h4>
                                                    </div>

                                                </div>
                                            </div><div class="single-auto-vertical-product d-flex slick-slide slick-cloned" data-slick-index="11" aria-hidden="true" tabindex="-1" style="width: 248px;">
                                                <div class="product-image">
                                                    <a href="single-product-variable.html" tabindex="-1"><img src="assets/images/products/5.jpg" class="img-fluid" alt=""></a>
                                                </div>
                                                <div class="product-description">
                                                    <h5 class="product-name"><a href="single-product-variable.html" tabindex="-1">Faded
                                                            Short Sleeve</a></h5>
                                                    <div class="price-box">
                                                        <h4>$ 12.00</h4>
                                                    </div>

                                                </div>
                                            </div><div class="single-auto-vertical-product d-flex slick-slide slick-cloned" data-slick-index="12" aria-hidden="true" tabindex="-1" style="width: 248px;">
                                                <div class="product-image">
                                                    <a href="single-product-variable.html" tabindex="-1"><img src="assets/images/products/6.jpg" class="img-fluid" alt=""></a>
                                                </div>
                                                <div class="product-description">
                                                    <h5 class="product-name"><a href="single-product-variable.html" tabindex="-1">Printed
                                                            Dress</a></h5>
                                                    <div class="price-box">
                                                        <h4>$ 12.00</h4>
                                                    </div>

                                                </div>
                                            </div><div class="single-auto-vertical-product d-flex slick-slide slick-cloned" data-slick-index="13" aria-hidden="true" tabindex="-1" style="width: 248px;">
                                                <div class="product-image">
                                                    <a href="single-product-variable.html" tabindex="-1"><img src="assets/images/products/7.jpg" class="img-fluid" alt=""></a>
                                                </div>
                                                <div class="product-description">
                                                    <h5 class="product-name"><a href="single-product-variable.html" tabindex="-1">Faded
                                                            Short Sleeve</a></h5>
                                                    <div class="price-box">
                                                        <h4>$ 12.00</h4>
                                                    </div>

                                                </div>
                                            </div></div></div>
                                    <!-- end of single vertical product -->
                                    <!-- single vertical product -->

                                    <!-- end of single vertical product -->
                                    <!-- single vertical product -->

                                    <!-- end of single vertical product -->
                                    <!-- single vertical product -->

                                    <!-- end of single vertical product -->
                                    <!-- single vertical product -->

                                    <!-- end of single vertical product -->
                                    <!-- single vertical product -->

                                    <!-- end of single vertical product -->
                                    <!-- single vertical product -->

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


<div class="brand-logo-slider mb-50">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-sm-12">
                <div class="brand-logo-list slick-initialized slick-slider"><i class="fa fa-angle-left slick-arrow" style=""></i>
                    <!-- ======  single brand logo block  ====== -->

                    <div class="slick-list draggable"><div class="slick-track" style="opacity: 1; width: 3600px; transform: translate3d(-2160px, 0px, 0px); transition: transform 500ms ease 0s;"><div class="single-brand-logo slick-slide slick-cloned" data-slick-index="-6" aria-hidden="true" tabindex="-1" style="width: 180px;">
                                <a href="#" tabindex="-1">
                                    <img src="assets/images/brand-logos/2.jpg" alt="">
                                </a>
                            </div><div class="single-brand-logo slick-slide slick-cloned" data-slick-index="-5" aria-hidden="true" tabindex="-1" style="width: 180px;">
                                <a href="#" tabindex="-1">
                                    <img src="assets/images/brand-logos/3.jpg" alt="">
                                </a>
                            </div><div class="single-brand-logo slick-slide slick-cloned" data-slick-index="-4" aria-hidden="true" tabindex="-1" style="width: 180px;">
                                <a href="#" tabindex="-1">
                                    <img src="assets/images/brand-logos/4.jpg" alt="">
                                </a>
                            </div><div class="single-brand-logo slick-slide slick-cloned" data-slick-index="-3" aria-hidden="true" tabindex="-1" style="width: 180px;">
                                <a href="#" tabindex="-1">
                                    <img src="assets/images/brand-logos/5.jpg" alt="">
                                </a>
                            </div><div class="single-brand-logo slick-slide slick-cloned" data-slick-index="-2" aria-hidden="true" tabindex="-1" style="width: 180px;">
                                <a href="#" tabindex="-1">
                                    <img src="assets/images/brand-logos/6.jpg" alt="">
                                </a>
                            </div><div class="single-brand-logo slick-slide slick-cloned" data-slick-index="-1" aria-hidden="true" tabindex="-1" style="width: 180px;">
                                <a href="#" tabindex="-1">
                                    <img src="assets/images/brand-logos/7.jpg" alt="">
                                </a>
                            </div><div class="single-brand-logo slick-slide" data-slick-index="0" aria-hidden="true" tabindex="-1" style="width: 180px;">
                                <a href="#" tabindex="-1">
                                    <img src="assets/images/brand-logos/1.jpg" alt="">
                                </a>
                            </div><div class="single-brand-logo slick-slide" data-slick-index="1" aria-hidden="true" tabindex="-1" style="width: 180px;">
                                <a href="#" tabindex="-1">
                                    <img src="assets/images/brand-logos/2.jpg" alt="">
                                </a>
                            </div><div class="single-brand-logo slick-slide" data-slick-index="2" aria-hidden="true" tabindex="-1" style="width: 180px;">
                                <a href="#" tabindex="-1">
                                    <img src="assets/images/brand-logos/3.jpg" alt="">
                                </a>
                            </div><div class="single-brand-logo slick-slide" data-slick-index="3" aria-hidden="true" tabindex="-1" style="width: 180px;">
                                <a href="#" tabindex="-1">
                                    <img src="assets/images/brand-logos/4.jpg" alt="">
                                </a>
                            </div><div class="single-brand-logo slick-slide" data-slick-index="4" aria-hidden="true" tabindex="-1" style="width: 180px;">
                                <a href="#" tabindex="-1">
                                    <img src="assets/images/brand-logos/5.jpg" alt="">
                                </a>
                            </div><div class="single-brand-logo slick-slide" data-slick-index="5" aria-hidden="true" tabindex="0" style="width: 180px;">
                                <a href="#" tabindex="0">
                                    <img src="assets/images/brand-logos/6.jpg" alt="">
                                </a>
                            </div><div class="single-brand-logo slick-slide slick-current slick-active" data-slick-index="6" aria-hidden="false" tabindex="0" style="width: 180px;">
                                <a href="#" tabindex="0">
                                    <img src="assets/images/brand-logos/7.jpg" alt="">
                                </a>
                            </div><div class="single-brand-logo slick-slide slick-cloned slick-active" data-slick-index="7" aria-hidden="false" tabindex="-1" style="width: 180px;">
                                <a href="#" tabindex="0">
                                    <img src="assets/images/brand-logos/1.jpg" alt="">
                                </a>
                            </div><div class="single-brand-logo slick-slide slick-cloned slick-active" data-slick-index="8" aria-hidden="false" tabindex="-1" style="width: 180px;">
                                <a href="#" tabindex="0">
                                    <img src="assets/images/brand-logos/2.jpg" alt="">
                                </a>
                            </div><div class="single-brand-logo slick-slide slick-cloned slick-active" data-slick-index="9" aria-hidden="false" tabindex="-1" style="width: 180px;">
                                <a href="#" tabindex="0">
                                    <img src="assets/images/brand-logos/3.jpg" alt="">
                                </a>
                            </div><div class="single-brand-logo slick-slide slick-cloned slick-active" data-slick-index="10" aria-hidden="false" tabindex="-1" style="width: 180px;">
                                <a href="#" tabindex="0">
                                    <img src="assets/images/brand-logos/4.jpg" alt="">
                                </a>
                            </div><div class="single-brand-logo slick-slide slick-cloned slick-active" data-slick-index="11" aria-hidden="false" tabindex="-1" style="width: 180px;">
                                <a href="#" tabindex="-1">
                                    <img src="assets/images/brand-logos/5.jpg" alt="">
                                </a>
                            </div><div class="single-brand-logo slick-slide slick-cloned" data-slick-index="12" aria-hidden="true" tabindex="-1" style="width: 180px;">
                                <a href="#" tabindex="-1">
                                    <img src="assets/images/brand-logos/6.jpg" alt="">
                                </a>
                            </div><div class="single-brand-logo slick-slide slick-cloned" data-slick-index="13" aria-hidden="true" tabindex="-1" style="width: 180px;">
                                <a href="#" tabindex="-1">
                                    <img src="assets/images/brand-logos/7.jpg" alt="">
                                </a>
                            </div></div></div>

                    <!-- ====  End of single brand logo block  ==== -->
                    <!-- ======  single brand logo block  ====== -->



                    <!-- ====  End of single brand logo block  ==== -->
                    <!-- ======  single brand logo block  ====== -->



                    <!-- ====  End of single brand logo block  ==== -->
                    <!-- ======  single brand logo block  ====== -->



                    <!-- ====  End of single brand logo block  ==== -->
                    <!-- ======  single brand logo block  ====== -->



                    <!-- ====  End of single brand logo block  ==== -->
                    <!-- ======  single brand logo block  ====== -->



                    <!-- ====  End of single brand logo block  ==== -->
                    <!-- ======  single brand logo block  ====== -->



                    <!-- ====  End of single brand logo block  ==== -->

                    <i class="fa fa-angle-right slick-next-btn slick-arrow" style=""></i></div>
            </div>
        </div>
    </div>
</div>

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
                                        <form id="mc-form" class="mc-form subscribe-form" novalidate="true">
                                            <input type="email" id="mc-email" autocomplete="off" placeholder="Enter your e-mail" required="" name="EMAIL">
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


<a href="#" class="scroll-top" style="display: inline;"></a>


{!! PageBuilder::section('footer',['categories'=>$categories]) !!}
