{!! PageBuilder::section('head', [
'categories' => $categories,
'cart'=>$cart
]) !!}

<section class="page-content about-page-content mt-50 mb-50">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="page-title">
                                        <h2>Acerca de nosotros</h2>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="about-single-block">
                                        <h2>Nueestra empresa</h2>
                                        <p class="bold-text">Lorem ipsum dolor sit amet conse ctetur adipisicing elit,
                                            sed do eiusmod tempor incididun.</p>
                                        <p>Lorem ipsum dolor sit amet conse ctetur adipisicing elit, sed do eiusmod
                                            tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim
                                            veniam. Lorem ipsum dolor sit amet conse ctetur adipisicing elit.</p>

                                        <div class="featured-points">
                                            <ul>
                                                <li>Los mejores productos.</li>
                                                <li>Atención personalizada</li>
                                                <li>3 mese de garantia</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="about-single-block">
                                        <h2>Nuestro equipo</h2>

                                        <div class="about-team-image">
                                            <img src="assets/images/about-us.jpg" class="img-fluid" alt="">
                                        </div>
                                        <p class="bold-text">Lorem set sint occaecat cupidatat non </p>
                                        <p>Lorem ipsum dolor sit amet conse ctetur adipisicing elit, sed do eiusmod
                                            tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim
                                            veniam. Lorem ipsum dolor sit amet conse ctetur adipisicing elit. </p>

                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="about-single-block">
                                        <h2>Testimonios</h2>

                                        <div class="testimonial-container">
                                            <div class="single-testimonial">
                                                <p> <i class="fa fa-quote-left"></i> Lorem ipsum dolor sit amet conse
                                                    ctetur adipisicing elit, sed do
                                                    eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim
                                                    et dolore magna aliqua. Ut enim ad minim
                                                    veniam. Lorem ipsum dolor sit amet conse ctetur adipisicing elit.
                                                    ad minim. <i class="fa fa-quote-right"></i></p>
                                                <p class="customer-name">Lorem ipsum dolor sit</p>
                                            </div>

                                            <div class="single-testimonial">
                                                <p><i class="fa fa-quote-left"></i> Lorem ipsum dolor sit amet conse
                                                    ctetur adipisicing elit, sed do
                                                    eiusmod tempor incididunt ut labore et dolore et dolore magna
                                                    aliqua. Ut enim ad minim
                                                    veniam. Lorem ipsum dolor sit amet conse ctetur adipisicing elit.
                                                    magna aliqua. Ut enim
                                                    ad minim.<i class="fa fa-quote-right"></i> </p>
                                                <p class="customer-name">Lorem ipsum dolor sit</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

{!! PageBuilder::section('footer',[
'categories' => $categories
]) !!}
