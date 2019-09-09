{!! PageBuilder::section('head', [
'categories' => $categories,
'cart'=>$cart
]) !!}
<section class="page-content mt-50 mb-50">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="page-title">
                                        <h2>Atencion al cliente</h2>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="contact-form-container">
                                        <h2>Enviar mensaje</h2>
                                        <form id="contact-form" action="{{route('complement.send_mail.contact')}}" method="get" class="contact-form">
                                            <div class="row">
                                                <div class="col-lg-3">
                                                    <div class="form-group">
                                                        <label>Nombre</label>
                                                        <input type="text" required="required" name="name">
                                                    </div>

                                                    <div class="form-group">
                                                        <label>Correo electronico</label>
                                                        <input type="email" required="required" name="email_address">
                                                    </div>

                                                    <div class="form-group">
                                                        <label>Asunto</label>
                                                        <input type="text" required="required" name="contact_subject">
                                                    </div>

                                                </div>
                                                <div class="col-lg-9">
                                                    <div class="form-group">
                                                        <label>Mensaje</label>
                                                        <textarea  required="required" name="message" cols="30" rows="10"></textarea>
                                                    </div>
                                                </div>

                                                <div class="col-lg-5">
                                                    <div class="form-group">
                                                        <button type="submit" name="submit"> Enviar <i class="fa fa-chevron-right"></i></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                        <p class="form-messege pt-10 pb-10 mt-10 mb-10"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>


{!! PageBuilder::section('footer',[
'categories' => $categories
]) !!}
