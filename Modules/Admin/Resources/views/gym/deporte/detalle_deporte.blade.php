<div class="col-sm-12 col-md-12 col-lg-12">
    <!-- product -->
    <div class="product-content product-wrap clearfix product-deatil">
        <div class="row">
            <div class="col-md-5 col-sm-12 col-xs-12 ">
                <div class="product-image"> 
                    <div id="myCarousel-2" class="carousel slide">
                        <ol class="carousel-indicators">
                            <li data-target="#myCarousel-2" data-slide-to="0" class=""></li>
                            <li data-target="#myCarousel-2" data-slide-to="1" class="active"></li>
                            <li data-target="#myCarousel-2" data-slide-to="2" class=""></li>
                        </ol>
                        <div class="carousel-inner">
                            <!-- Slide 1 -->
                            <div class="item active">
                                <img src="{{$deporte->foto}}" alt="">
                            </div>
                            <!-- Slide 2 -->
                            <div class="item">
                                <img src="https://lorempixel.com/300/300/technics/1/" alt="">
                            </div>
                            <!-- Slide 3 -->
                            <div class="item">
                                <img src="https://lorempixel.com/300/300/technics/1/" alt="">
                            </div>
                        </div>
                        <a class="left carousel-control" href="#myCarousel-2" data-slide="prev"> <span class="glyphicon glyphicon-chevron-left"></span> </a>
                        <a class="right carousel-control" href="#myCarousel-2" data-slide="next"> <span class="glyphicon glyphicon-chevron-right"></span> </a>
                    </div>
                </div>
            </div>
            <div class="col-md-7 col-sm-12 col-xs-12">

                <h2 class="name">
               Nombre:  {{$deporte->nombre}}
                </h2>
                <hr>
                <h3 class="price-container">
                                  ${{$deporte->precio}}

                    <small>*MN</small>
                </h3>
<!--                <div class="certified">
                    <ul>
                        <li><a href="javascript:void(0);">Delivery time<span>7 Working Days</span></a></li>
                        <li><a href="javascript:void(0);">Certified<span>Quality Assured</span></a></li>
                    </ul>
                </div>-->
                <hr>
                <div class="description description-tabs">
                    <ul id="myTab" class="nav nav-pills">
                        <li class="active"><a href="#more-information" data-toggle="tab" class="no-margin">Descripción </a></li>
                        <li class=""><a href="#specifications" data-toggle="tab">Beneficios</a></li>
                        <!--<li class=""><a href="#reviews" data-toggle="tab">Reviews</a></li>-->
                    </ul>
                    <div id="myTabContent" class="tab-content">
                        <div class="tab-pane fade active in" id="more-information">
                            <br>
                            <strong>{{$deporte->nombre}}</strong>
                            <p>{{$deporte->descripcion}} </p>
                        </div>
                        <div class="tab-pane fade" id="specifications">
                            <br>
                            <dl class="">
                                @foreach($deporte->objetivos as $o)
                                <dt>{{$o->nombre}}</dt>
                                    <dd>{{$o->descripcion}}</dd>
                                    
                                    @endforeach
                            </dl>
                        </div>
<!--                        <div class="tab-pane fade" id="reviews">
                            <br>
                            <form method="post" class="well padding-bottom-10" onsubmit="return false;">
                                <textarea rows="2" class="form-control" placeholder="Write a review"></textarea>
                                <div class="margin-top-10">
                                    <button type="submit" class="btn btn-sm btn-primary pull-right">
                                        Submit Review
                                    </button>
                                    <a href="javascript:void(0);" class="btn btn-link profile-link-btn" rel="tooltip" data-placement="bottom" title="" data-original-title="Add Location"><i class="fa fa-location-arrow"></i></a>
                                    <a href="javascript:void(0);" class="btn btn-link profile-link-btn" rel="tooltip" data-placement="bottom" title="" data-original-title="Add Voice"><i class="fa fa-microphone"></i></a>
                                    <a href="javascript:void(0);" class="btn btn-link profile-link-btn" rel="tooltip" data-placement="bottom" title="" data-original-title="Add Photo"><i class="fa fa-camera"></i></a>
                                    <a href="javascript:void(0);" class="btn btn-link profile-link-btn" rel="tooltip" data-placement="bottom" title="" data-original-title="Add File"><i class="fa fa-file"></i></a>
                                </div>
                            </form>

                            <div class="chat-body no-padding profile-message">
                                <ul>
                                    <li class="message">
                                        <img src="https://bootdey.com/img/Content/avatar/avatar1.png" class="online">
                                        <span class="message-text"> 
                                            <a href="javascript:void(0);" class="username">
                                                Alisha Molly 
                                                <span class="badge">Purchase Verified</span> 
                                                <span class="pull-right">
                                                    <i class="fa fa-star fa-2x text-primary"></i>
                                                    <i class="fa fa-star fa-2x text-primary"></i>
                                                    <i class="fa fa-star fa-2x text-primary"></i>
                                                    <i class="fa fa-star fa-2x text-primary"></i>
                                                    <i class="fa fa-star fa-2x text-muted"></i>
                                                </span>
                                            </a> 
                                            Can't divide were divide fish forth fish to. Was can't form the, living life grass darkness very image let unto fowl isn't in blessed fill life yielding above all moved 
                                        </span>
                                        <ul class="list-inline font-xs">
                                            <li>
                                                <a href="javascript:void(0);" class="text-info"><i class="fa fa-thumbs-up"></i> This was helpful (22)</a>
                                            </li>
                                            <li class="pull-right">
                                                <small class="text-muted pull-right ultra-light"> Posted 1 year ago </small>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="message">
                                        <img src="https://bootdey.com/img/Content/avatar/avatar2.png" class="online">
                                        <span class="message-text"> 
                                            <a href="javascript:void(0);" class="username">
                                                Aragon Zarko 
                                                <span class="badge">Purchase Verified</span> 
                                                <span class="pull-right">
                                                    <i class="fa fa-star fa-2x text-primary"></i>
                                                    <i class="fa fa-star fa-2x text-primary"></i>
                                                    <i class="fa fa-star fa-2x text-primary"></i>
                                                    <i class="fa fa-star fa-2x text-primary"></i>
                                                    <i class="fa fa-star fa-2x text-primary"></i>
                                                </span>
                                            </a> 
                                            Excellent product, love it!
                                        </span>
                                        <ul class="list-inline font-xs">
                                            <li>
                                                <a href="javascript:void(0);" class="text-info"><i class="fa fa-thumbs-up"></i> This was helpful (22)</a>
                                            </li>
                                            <li class="pull-right">
                                                <small class="text-muted pull-right ultra-light"> Posted 1 year ago </small>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                        </div>-->
                    </div>
                </div>
                <hr>
                <div class="row" style="display: none">
                    <div class="col-sm-12 col-md-6 col-lg-6">
                        <a href="javascript:void(0);" class="btn btn-success btn-lg">Add to cart ($129.54)</a>
                    </div>
                    <div class="col-sm-12 col-md-6 col-lg-6">
                        <div class="btn-group pull-right">
                            <button class="btn btn-white btn-default"><i class="fa fa-star"></i> Add to wishlist </button>
                            <button class="btn btn-white btn-default"><i class="fa fa-envelope"></i> Contact Seller</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end product -->
</div>