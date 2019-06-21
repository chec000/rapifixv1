@extends('cms::layouts.master')

@section('content')
  <div class="cart fullsteps">
    <nav class="tabs-static">
      <div class="wrapper">
        <!--registro barra pasos-->
        <ul class="list-nostyle tabs-static__list">
          <li class="tabs-static__item active">
            <span class="desk">@lang('shopping::shopping_cart.tabs.address.desktop')</span>
            <span class="mov">@lang('shopping::shopping_cart.tabs.address.mobile')</span>
          </li>
          <li class="tabs-static__item">
            <span class="desk">@lang('shopping::shopping_cart.tabs.payment.desktop')</span>
            <span class="mov">@lang('shopping::shopping_cart.tabs.payment.mobile')</span>
          </li>
          <li class="tabs-static__item">
            <span class="desk">@lang('shopping::shopping_cart.tabs.confirm.desktop')</span>
            <span class="mov">@lang('shopping::shopping_cart.tabs.confirm.mobile')</span>
          </li>
        </ul>
      </div>
    </nav>
    <div class="cart__main">
      <div class="wrapper">
        <div class="cart__content">
          <div class="cart__left">
            <div class="cart__main-title">@lang('shopping::shopping_cart.header.title')</div>
            <div class="step step1 fade-in-down active" id="step1">
              <div class="cart__main-subtitle">@lang('shopping::shopping_cart.header.subtitles.step1')</div>
              <div class="form-group">
                <div class="form-radio card stack">
                  <input type="radio" id="address1" name="address" value="0">
                  <label class="card__content-wrap" for="address1">
                    <div class="card__content">
                      <label class="radio-fake" for="address1"></label><span class="radio-label">
                         Casa<span class="small">Luis B, Valdes #10, Colonia las Américas, Morelia Mich.</span></span>
                    </div>
                  </label>
                </div>
                <div class="form-radio card stack">
                  <input type="radio" id="address2" name="address" value="1">
                  <label class="card__content-wrap" for="address2">
                    <div class="card__content">
                      <label class="radio-fake" for="address2"></label>
                      <span class="radio-label">
                        @lang('shopping::shopping_cart.new_address.header')
                        <span class="small">@lang('shopping::shopping_cart.new_address.subheader1')</span>
                        <span class="small">*@lang('shopping::shopping_cart.new_address.subheader2')</span>
                      </span>
                      <div class="card__extra">
                        <div class="form-row">
                          <div class="form-group medium">
                            <input class="form-control" type="text" id="name" name="name" placeholder="@lang('shopping::shopping_cart.new_address.placeholders.name')*">
                          </div>
                          <div class="form-group medium">
                            <input class="form-control" type="text" id="lastname" name="lastname" placeholder="@lang('shopping::shopping_cart.new_address.placeholders.last_name')*">
                          </div>
                          <div class="form-group medium">
                            <input class="form-control" type="text" id="lastname2" name="lastname2" placeholder="@lang('shopping::shopping_cart.new_address.placeholders.last_name2')*">
                          </div>
                        </div>
                        <div class="form-row">
                          <div class="form-group medium">
                            <input class="form-control" type="text" id="street" name="street" placeholder="@lang('shopping::shopping_cart.new_address.placeholders.street')*">
                          </div>
                          <div class="form-group medium">
                            <input class="form-control" type="text" id="ext_num" name="ext_num" placeholder="@lang('shopping::shopping_cart.new_address.placeholders.ext_num')*">
                          </div>
                          <div class="form-group medium">
                            <input class="form-control" type="text" id="int_num" name="int_num" placeholder="@lang('shopping::shopping_cart.new_address.placeholders.int_num')*">
                          </div>
                        </div>
                        <div class="form-row">
                          <div class="form-group mediumx">
                            <input class="form-control" type="text" id="betweem_streets" name="betweem_streets" placeholder="@lang('shopping::shopping_cart.new_address.placeholders.streets')">
                          </div>
                          <div class="form-group mediumx">
                            <input class="form-control" type="text" id="colony" name="colony" placeholder="@lang('shopping::shopping_cart.new_address.placeholders.colony')">
                          </div>
                        </div>
                        <div class="form-row">
                          <div class="form-group select medium">
                            <select class="form-control" name="state">
                              <option value="">@lang('shopping::shopping_cart.new_address.placeholders.state')</option>
                            </select>
                          </div>
                          <div class="form-group medium">
                            <input class="form-control" type="text" id="city" name="city" placeholder="@lang('shopping::shopping_cart.new_address.placeholders.city')">
                          </div>
                          <div class="form-group medium">
                            <input class="form-control" type="text" id="zip" name="zip" placeholder="@lang('shopping::shopping_cart.new_address.placeholders.zip')">
                          </div>
                        </div>
                        <div class="form-row left">
                          <div class="form-group mediumx">
                            <input class="form-control" type="text" id="tel" name="tel" placeholder="@lang('shopping::shopping_cart.new_address.placeholders.streets')">
                          </div>
                        </div>
                        <div class="form-row">
                          <div class="form-group form-checkbox">
                            <input type="checkbox" id="save_address" name="save_address">
                            <label class="checkbox-fake" for="save_address"></label><span class="checkbox-label">@lang('shopping::shopping_cart.new_address.save_button')</span>
                          </div>
                          <div class="form-group form-checkbox">
                            <input type="checkbox" id="default_address" name="default_address">
                            <label class="checkbox-fake" for="default_address"></label><span class="checkbox-label">@lang('shopping::shopping_cart.new_address.save_fav_button')</span>
                          </div>
                        </div>
                      </div>
                    </div>
                  </label>
                </div>
              </div>
              <div class="buttons-container">
                <button class="button secondary small" type="button">@lang('shopping::shopping_cart.continue_buying')</button>
                <button class="button small" type="button" data-to="step2">@lang('shopping::shopping_cart.continue_payment')</button>
              </div>
            </div>
            <div class="step step2 fade-in-down" id="step2">
              <div class="cart__main-subtitle">@lang('shopping::shopping_cart.header.subtitles.step2')</div>
              <div class="form-group">
                <div class="form-radio card stack">
                  <input type="radio" id="payment1" name="payment" value="1">
                  <label class="card__content-wrap" for="payment1">
                    <div class="card__content">
                      <label class="radio-fake" for="payment1"></label><span class="radio-label">
                         OXXO<span class="small">Paga en cualquiera de las tiendas OXXO de toda la república.</span></span>
                    </div>
                  </label>
                </div>
                <div class="form-radio card stack">
                  <input type="radio" id="payment2" name="payment" value="0">
                  <label class="card__content-wrap" for="payment2">
                    <div class="card__content">
                      <label class="radio-fake" for="payment2"></label><span class="radio-label">
                         PayPal<span class="small">Paga con tu cuenta PayPal o tu cuenta PayPal asociada a tu tarjeta bancaria.</span></span>
                    </div>
                  </label>
                </div>
                <div class="form-radio card stack">
                  <input type="radio" id="payment3" name="payment" value="3">
                  <label class="card__content-wrap" for="payment3">
                    <div class="card__content">
                      <label class="radio-fake" for="payment3"></label><span class="radio-label">
                         Tarjeta bancaria<span class="small">Paga con tu tarjeta bancaria, sólo ingresa tu número de tarjeta y CSC para pagar de forma rápida y fácil.</span></span>
                      <div class="card__extra">
                        <div class="form-row">
                          <div class="form-group mediumx">
                            <input class="form-control" type="text" id="cardnum" name="cardnum" placeholder="Número de tarjeta">
                          </div>
                          <div class="form-group mediumx">
                            <input class="form-control" type="text" id="cardname" name="cardname" placeholder="Nombre en la tarjeta">
                          </div>
                        </div>
                        <div class="form-row">
                          <div class="form-label">Fecha de vencimiento</div>
                          <div class="form-group left mediumx">
                            <div class="form-group select small">
                              <select class="form-control" name="cardmonth">
                                <option value="">Mes*</option>
                                <option value="1">01</option>
                                <option value="2">02</option>
                                <option value="3">03</option>
                                <option value="4">04</option>
                              </select>
                            </div>
                            <div class="form-group select small">
                              <select class="form-control" name="cardyear">
                                <option value="">Año*</option>
                                <option value="1920">1920</option>
                                <option value="1921">1921</option>
                                <option value="1922">1922</option>
                                <option value="1923">1923</option>
                              </select>
                            </div>
                          </div>
                          <div class="form-group mediumx">
                            <input class="form-control" type="text" id="cardcsc" name="cardcsc" placeholder="CVV">
                          </div>
                        </div>
                      </div>
                    </div>
                  </label>
                </div>
              </div>
              <div class="form-row">
                {{--
                <div class="form-group form-checkbox">
                  <input type="checkbox" id="save_card" name="save_card">
                  <label class="checkbox-fake" for="save_card"></label><span class="checkbox-label">Guardar mi número de tarjeta para la próxima compra en este sitio web.</span>
                </div>
                --}}
                <div class="form-group form-checkbox">
                  <input type="checkbox" id="terms_cond" name="terms_cond">
                  <label class="checkbox-fake" for="terms_cond"></label><span class="checkbox-label">@lang('shopping::shopping_cart.accept_conditions.text') <a href="#">@lang('shopping::shopping_cart.accept_conditions.link')</a></span>
                </div>
              </div>
              <div class="buttons-container">
                <button class="button secondary small" type="button">@lang('shopping::shopping_cart.continue_buying')</button>
                <button class="button small" type="button" data-to="step3">@lang('shopping::shopping_cart.checkout')</button>
              </div>
            </div>
          </div>
          <div class="cart-preview fade-in-down cart__right">
            <div class="cart-preview__head">
              <p>@lang('shopping::shopping_cart.cart.header')</p>
              <button class="icon-btn icon-cross close" type="button"></button>
            </div>
            <div class="cart-preview__content">
              <ul class="cart-product__list list-nostyle">
                <li class="cart-product__item">
                  <figure class="cart-product__img"><img src="{{ asset('themes/omnilife2018/images/omnilife/products/002.jpg') }}" alt=""></figure>
                  <div class="cart-product__content">
                    <div class="cart-product__top">
                      <div class="cart-product__title">Omnlife probiotic</div>
                      <div class="cart-product__code">@lang('shopping::shopping_cart.cart.product_code'): 12312312</div>
                      <div class="bin">
                        <figure class="icon-bin"><img src="{{ asset('themes/omnilife2018/images/icons/bin.svg') }}" alt="OMNILIFE - eliminar"></figure>
                      </div>
                    </div>
                    <div class="cart-product__bottom">
                      <div class="form-group numeric"><span class="minus">
                          <svg height="14" width="14">
                            <line x1="0" y1="8" x2="14" y2="8"></line>
                          </svg></span>
                        <input class="form-control" type="numeric" name="qty#{val}" value="1"><span class="plus">
                          <svg height="14" width="14">
                            <line x1="0" y1="7" x2="14" y2="7"></line>
                            <line x1="7" y1="0" x2="7" y2="14"></line>
                          </svg></span>
                      </div>
                      <div class="cart-product__nums">
                        <div class="cart-product__pts">00 @lang('shopping::shopping_cart.cart.points')</div>
                        <div class="cart-product__price">x $0.00</div>
                      </div>
                    </div>
                  </div>
                </li>
                <li class="cart-product__item">
                  <figure class="cart-product__img"><img src="{{ asset('themes/omnilife2018/images/omnilife/products/002.jpg') }}" alt=""></figure>
                  <div class="cart-product__content">
                    <div class="cart-product__top">
                      <div class="cart-product__title">Omnlife probiotic</div>
                      <div class="cart-product__code">@lang('shopping::shopping_cart.cart.product_code'): 12312312</div>
                      <div class="bin">
                        <figure class="icon-bin"><img src="{{ asset('themes/omnilife2018/images/icons/bin.svg') }}" alt="OMNILIFE - eliminar"></figure>
                      </div>
                    </div>
                    <div class="cart-product__bottom">
                      <div class="form-group numeric"><span class="minus">
                          <svg height="14" width="14">
                            <line x1="0" y1="8" x2="14" y2="8"></line>
                          </svg></span>
                        <input class="form-control" type="numeric" name="qty#{val}" value="1"><span class="plus">
                          <svg height="14" width="14">
                            <line x1="0" y1="7" x2="14" y2="7"></line>
                            <line x1="7" y1="0" x2="7" y2="14"></line>
                          </svg></span>
                      </div>
                      <div class="cart-product__nums">
                        <div class="cart-product__pts">00 @lang('shopping::shopping_cart.cart.points')</div>
                        <div class="cart-product__price">x $0.00</div>
                      </div>
                    </div>
                  </div>
                </li>
                <li class="cart-product__item">
                  <figure class="cart-product__img"><img src="{{ asset('themes/omnilife2018/images/omnilife/products/002.jpg') }}" alt=""></figure>
                  <div class="cart-product__content">
                    <div class="cart-product__top">
                      <div class="cart-product__title">Omnlife probiotic</div>
                      <div class="cart-product__code">@lang('shopping::shopping_cart.cart.product_code'): 12312312</div>
                      <div class="bin">
                        <figure class="icon-bin"><img src="{{ asset('themes/omnilife2018/images/icons/bin.svg') }}" alt="OMNILIFE - eliminar"></figure>
                      </div>
                    </div>
                    <div class="cart-product__bottom">
                      <div class="form-group numeric"><span class="minus">
                          <svg height="14" width="14">
                            <line x1="0" y1="8" x2="14" y2="8"></line>
                          </svg></span>
                        <input class="form-control" type="numeric" name="qty#{val}" value="1"><span class="plus">
                          <svg height="14" width="14">
                            <line x1="0" y1="7" x2="14" y2="7"></line>
                            <line x1="7" y1="0" x2="7" y2="14"></line>
                          </svg></span>
                      </div>
                      <div class="cart-product__nums">
                        <div class="cart-product__pts">00 @lang('shopping::shopping_cart.cart.points')</div>
                        <div class="cart-product__price">x $0.00</div>
                      </div>
                    </div>
                  </div>
                </li>
              </ul>
              <div class="cart-preview__resume list-nostyle">
                <li>@lang('shopping::shopping_cart.cart.bill.subtotal'): $00.00</li>
                <li>@lang('shopping::shopping_cart.cart.bill.management'): $00.00</li>
                <li>@lang('shopping::shopping_cart.cart.bill.taxes'): $00.00</li>
                <li>@lang('shopping::shopping_cart.cart.bill.points'): 0000</li>
                <li class="total">@lang('shopping::shopping_cart.cart.bill.total'): $00.00</li>
              </div>
            </div>
          </div>
        </div>
        <div class="cart-preview-mov" id="cart-preview-mov">
          <div class="cart-preview__head">
            <p>@lang('shopping::shopping_cart.cart.header')</p>
          </div>
          <div class="cart-preview__resume list-nostyle">
            <li>@lang('shopping::shopping_cart.cart.bill.points'): 0000</li>
            <li class="total">@lang('shopping::shopping_cart.cart.bill.total'): $00.00</li>
          </div>
        </div>
        <div class="step step3 cart__confirm" id="step3">
          <header class="cart__confirm-head">
            <p>@lang('shopping::shopping_cart.confirm.header')</p>
            <h5>@lang('shopping::shopping_cart.confirm.subheader')</h5>
          </header>
          <div class="cart__confirm-icon"></div>
          <p>@lang('shopping::shopping_cart.confirm.order_arrive'): 10 días hábiles.</p>
          <div class="cart__confirm-info">
            <p>@lang('shopping::shopping_cart.confirm.order_number'): 13400210491</p>
            <p>@lang('shopping::shopping_cart.confirm.card_payment'): **** **** **** 0000</p>
            <p class="bold">@lang('shopping::shopping_cart.confirm.total'): $000.00</p>
            <p>@lang('shopping::shopping_cart.confirm.send_to') Fco. I. Madero 1020 Col. Chapultepec, Morelia, Michoacán.</p>
          </div>
          <ul class="cart__confirm-items list-nostyle mul">
            <li class="cart__confirm-item"><span class="cart__confirm-item__qty">2</span><span class="cart__confirm-item__name">Nombre del producto</span><span class="cart__confirm-item__code">12312312</span><span class="cart__confirm-item__pts">00 pts</span><span class="cart__confirm-item__price">$00.00</span><span class="cart__confirm-item__price">$00.00</span></li>
            <li class="cart__confirm-item"><span class="cart__confirm-item__qty">3</span><span class="cart__confirm-item__name">Nombre del producto</span><span class="cart__confirm-item__code">12312312</span><span class="cart__confirm-item__pts">00 pts</span><span class="cart__confirm-item__price">$00.00</span><span class="cart__confirm-item__price">$00.00</span></li>
            <li class="cart__confirm-item"><span class="cart__confirm-item__qty">2</span><span class="cart__confirm-item__name">Nombre del producto</span><span class="cart__confirm-item__code">12312312</span><span class="cart__confirm-item__pts">00 pts</span><span class="cart__confirm-item__price">$00.00</span><span class="cart__confirm-item__price">$00.00</span></li>
            <li class="cart__confirm-item"><span class="cart__confirm-item__qty">1</span><span class="cart__confirm-item__name">Nombre del producto</span><span class="cart__confirm-item__code">12312312</span><span class="cart__confirm-item__pts">00 pts</span><span class="cart__confirm-item__price">$00.00</span><span class="cart__confirm-item__price">$00.00</span></li>
          </ul>
          <div class="cart__confirm-banners">
            <figure class="cart__confirm-banner"><img src="{{ asset('themes/omnilife2018/images/checkout-banner001.jpg') }}" alt="">
              <figcaption>HISTORIAS DE ÉXITO</figcaption>
            </figure>
            <figure class="cart__confirm-banner"><img src="{{ asset('themes/omnilife2018/images/checkout-banner002.jpg') }}" alt="">
              <figcaption>RALLY 2018</figcaption>
            </figure>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('modals')
  <!-- modal cargando-->
  <div class="modal modal-loading" id="realizando-pago">
    <div class="modal__inner ps-container">
      <header class="modal__body">
        <p class="text-top">@lang('shopping::shopping_cart.modal.header')</p>
        <p class="price">$575.87 MXN</p>
        <div class="loading">
          <figure class="icon-loading"><img src="{{ asset('themes/omnilife2018/images/icons/loading.svg') }}" alt="OMNILIFE - loading"/></figure>
        </div>
        <p class="highlight">@lang('shopping::shopping_cart.modal.text_highlight')</p>
        <p>@lang('shopping::shopping_cart.modal.text')</p>
      </header>
    </div>
  </div>
@endsection
