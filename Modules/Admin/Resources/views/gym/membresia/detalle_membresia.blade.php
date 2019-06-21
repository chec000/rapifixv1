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
                                <img src="{{$membresia->imagen}}" alt="">
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
               Nombre:  {{$membresia->nombre}}
                </h2>
                <hr>
                <h3 class="price-container">
                                  ${{$membresia->precio}}

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
                            <strong>{{$membresia->nombre}}</strong>
                            <p>{{$membresia->descripcion}} </p>
                        </div>
                        <div class="tab-pane fade" id="specifications">
                            <br>
                            <dl class="">
                                @foreach($membresia->beneficios as $o)
                                <dt>{{$o->nombre}}</dt>
                                    <dd>{{$o->descripcion}}</dd>
                                    
                                    @endforeach
                            </dl>
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