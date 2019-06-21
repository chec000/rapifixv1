@extends('cms::layouts.master')

@section('content')
  <div class="register fullsteps">
    <nav class="tabs-static">
      <div class="wrapper">
        <!--registro barra pasos-->
        <ul class="list-nostyle tabs-static__list">
          <li class="tabs-static__item active">
            <span class="desk">@lang('shopping::register.tabs.account.desktop')</span>
            <span class="mov">@lang('shopping::register.tabs.account.mobile')</span>
          </li>
          <li class="tabs-static__item">
            <span class="desk">@lang('shopping::register.tabs.info.desktop')</span>
            <span class="mov">@lang('shopping::register.tabs.info.mobile')</span>
          </li>
          <li class="tabs-static__item">
            <span class="desk">@lang('shopping::register.tabs.kit.desktop')</span>
            <span class="mov">@lang('shopping::register.tabs.kit.mobile')</span>
          </li>
          <li class="tabs-static__item">
            <span class="desk">@lang('shopping::register.tabs.confirm.desktop')</span>
            <span class="mov">@lang('shopping::register.tabs.confirm.mobile')</span>
          </li>
        </ul>
      </div>
    </nav>
    <div class="register__main">
      <form>
        <!-- registro paso 1-->
        <div class="register__step step step1 fade-in-down active" id="step1">
          <div class="form-group">
            <div class="form-label mov">@lang('shopping::register.account.invited.label.desktop'):</div>
            <div class="form-label desk">@lang('shopping::register.account.invited.label.mobile'):</div>
            <div class="col-right">
              <div class="form-radio inline">
                <span class="radio-label">@lang('shopping::register.account.invited.answer.yes')</span>
                <input type="radio" id="invited1" name="invited" value="1">
                <label class="radio-fake" for="invited1"></label>
              </div>
              <div class="form-radio inline">
                <span class="radio-label">@lang('shopping::register.account.invited.answer.no')</span>
                <input type="radio" id="invited2" name="invited" value="0">
                <label class="radio-fake" for="invited2"></label>
              </div>
            </div>
          </div>
          <div class="form-group hidden" id="invited-yes">
            <div class="form-label">@lang('shopping::register.account.businessman_code.label'):</div>
            <div class="col-right">
              <input class="form-control" type="text" id="register-code" name="register-code" placeholder="@lang('shopping::register.account.businessman_code.placeholder')*">
              <!--.error-msg Este campo es obligatorio-->
            </div>
          </div>
          <div class="form-group hidden" id="invited-no">
            <div class="form-label">@lang('shopping::register.account.meet_us.label'):</div>
            <div class="col-right">
              <div class="select">
                <select class="form-control" name="country">
                  <option value="">@lang('shopping::register.account.meet_us.default')</option>
                  <option value="1">Redes Sociales</option>
                  <option value="2">YouTube</option>
                  <option value="3">Por familiares y amigos</option>
                </select>
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="form-label">@lang('shopping::register.account.country.label'):</div>
            <div class="col-right">
              <div class="select">
                <select class="form-control" name="country">
                  <option value="">@lang('shopping::register.account.country.default')</option>
                  <option value="mx">México</option>
                  <option value="us">Estados Unidos</option>
                  <option value="pg">Portugal</option>
                </select>
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="form-label">@lang('shopping::register.account.email.label'):</div>
            <div class="col-right">
              <input class="form-control" type="text" id="email" name="email" placeholder="@lang('shopping::register.account.email.placeholder')*">
            </div>
          </div>
          <div class="form-group">
            <div class="form-label">@lang('shopping::register.account.confirm_email.label'):</div>
            <div class="col-right">
              <input class="form-control" type="text" id="confirm-email" name="confirm-email" placeholder="@lang('shopping::register.account.confirm_email.placeholder')*">
            </div>
          </div>
          <div class="form-group">
            <div class="form-label">@lang('shopping::register.account.phone.label'):</div>
            <div class="col-right">
              <input class="form-control" type="text" id="tel" name="tel" placeholder="@lang('shopping::register.account.phone.placeholder')*">
            </div>
          </div>
          <div class="form-group">
            <div class="form-label">@lang('shopping::register.account.secret_question.label'):</div>
            <div class="col-right">
              <div class="select">
                <select class="form-control" name="secret-question">
                  <option value="">@lang('shopping::register.account.secret_question.default')</option>
                  <option value="1">¿Cómo se llama tu perro?</option>
                  <option value="2">¿Cómo se llama tu gato?</option>
                </select>
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="form-label">@lang('shopping::register.account.secret_answer.label'):</div>
            <div class="col-right">
              <input class="form-control" type="text" id="response-question" name="response-question" placeholder="@lang('shopping::register.account.secret_answer.placeholder')*">
            </div>
          </div>
          <div class="buttons-container">
            <button class="button secondary" type="button">@lang('shopping::register.prev_button')</button>
            <button class="button" type="button" data-to="step2">@lang('shopping::register.next_button')</button>
          </div>
        </div>
        <!-- registro paso 2-->
        <div class="register__step step step2 fade-in-down" id="step2">
          <div class="form-row">
            <div class="form-label block">@lang('shopping::register.info.full_name.label')</div>
            <div class="form-group medium">
              <input class="form-control" type="text" id="name" name="name" placeholder="@lang('shopping::register.info.full_name.placeholders.name')*">
              <div class="error-msg">Este campo es obligatorio.</div>
            </div>
            <div class="form-group medium">
              <input class="form-control" type="text" id="lastname" name="lastname" placeholder="@lang('shopping::register.info.full_name.placeholders.last_name')*">
            </div>
            <div class="form-group medium">
              <input class="form-control" type="text" id="lastname2" name="lastname2" placeholder="@lang('shopping::register.info.full_name.placeholders.last_name2')*">
            </div>
            <div class="form-group medium">
              <input class="form-control" type="text" id="sex" name="sex" placeholder="@lang('shopping::register.info.full_name.placeholders.sex')*">
            </div>
          </div>
          <div class="form-row left">
            <div class="form-label block">@lang('shopping::register.info.birth_date.label')</div>
            <div class="form-group select small">
              <select class="form-control" name="day">
                <option value="">@lang('shopping::register.info.birth_date.defaults.day')*</option>
                <option value="1">01</option>
                <option value="2">02</option>
                <option value="3">03</option>
                <option value="4">04</option>
              </select>
            </div>
            <div class="form-group select small">
              <select class="form-control" name="month">
                <option value="">@lang('shopping::register.info.birth_date.defaults.month')*</option>
                <option value="1">01</option>
                <option value="2">02</option>
                <option value="3">03</option>
                <option value="4">04</option>
              </select>
            </div>
            <div class="form-group select small">
              <select class="form-control" name="year">
                <option value="">@lang('shopping::register.info.birth_date.defaults.year')*</option>
                <option value="1920">1920</option>
                <option value="1921">1921</option>
                <option value="1922">1922</option>
                <option value="1923">1923</option>
              </select>
            </div>
          </div>
          <div class="form-row">
            <div class="form-label block">@lang('shopping::register.info.id.label')</div>
            <div class="form-group select mediumx">
              <select class="form-control" name="id_type">
                <option value="">@lang('shopping::register.info.id.defaults.type')</option>
              </select>
            </div>
            <div class="form-group mediumx">
              <input class="form-control" type="text" id="id_num" name="id_num" placeholder="@lang('shopping::register.info.id.placeholders.number')*">
            </div>
          </div>
          <div class="form-row">
            <div class="form-label block">@lang('shopping::register.info.address.label')</div>
            <div class="form-group medium">
              <input class="form-control" type="text" id="street" name="street" placeholder="@lang('shopping::register.info.address.placeholders.street')*">
            </div>
            <div class="form-group medium">
              <input class="form-control" type="text" id="ext_num" name="ext_num" placeholder="@lang('shopping::register.info.address.placeholders.ext_num')*">
            </div>
            <div class="form-group medium">
              <input class="form-control" type="text" id="int_num" name="int_num" placeholder="@lang('shopping::register.info.address.placeholders.int_num')*">
            </div>
            <div class="form-group medium">
              <input class="form-control" type="text" id="colony" name="colony" placeholder="@lang('shopping::register.info.address.placeholders.colony')">
            </div>
            <div class="form-group large">
              <input class="form-control" type="text" id="betweem_streets" name="betweem_streets" placeholder="@lang('shopping::register.info.address.placeholders.streets')">
            </div>
            <div class="form-group select medium">
              <select class="form-control" name="state">
                <option value="">@lang('shopping::register.info.address.placeholders.state')</option>
              </select>
            </div>
            <div class="form-group medium">
              <input class="form-control" type="text" id="city" name="city" placeholder="@lang('shopping::register.info.address.placeholders.city')">
            </div>
            <div class="form-group medium">
              <input class="form-control" type="text" id="zip" name="zip" placeholder="@lang('shopping::register.info.address.placeholders.zip')">
            </div>
          </div>
          <div class="form-row">
            <div class="form-group form-checkbox">
              <input type="checkbox" id="terms1" name="terms1">
              <label class="checkbox-fake" for="terms1"></label><span class="checkbox-label">@lang('shopping::register.info.terms_contract.text') <a href="#terminos-y-condiciones-contrato" data-modal="true">@lang('shopping::register.info.terms_contract.link')</a>.</span>
            </div>
            <div class="form-group form-checkbox">
              <input type="checkbox" id="terms2" name="terms2">
              <label class="checkbox-fake" for="terms2"></label><span class="checkbox-label">@lang('shopping::register.info.terms_payment.text') <a href="#terminos-y-condiciones-pago">@lang('shopping::register.info.terms_payment.link')</a>.</span>
            </div>
          </div>
          <div class="buttons-container">
            <button class="button secondary" type="button" data-to="step1">@lang('shopping::register.prev_button')</button>
            <button class="button" type="button" data-to="step3">@lang('shopping::register.next_button')</button>
          </div>
        </div>
        <!-- registro paso 3-->
        <div class="register__step step step3 fade-in-down" id="step3">
          <div class="form-group">
            <div class="form-label">@lang('shopping::register.kit.types')</div>
            <div class="form-radio inline card">
              <input type="radio" id="kit1" name="kit" value="1" checked>
              <figure class="card__img"><img src="{{ asset('themes/omnilife2018/images/9410335.png') }}" alt=""></figure>
              <label class="card__content-wrap" for="kit1">
                <div class="card__content">
                  <h3 class="card__title">KIT MALETÍN NUTRICIONAL WEB</h3>
                  <p class="card__price">$499</p>
                  <ul class="card__features list-nostyle">
                    <li>1 mochila</li>
                    <li>1 botella de agua Blu 500 ml</li>
                    <li>1 Magnum Supreme caja con 30 sachets</li>
                    <li>1 calendario</li>
                    <li>1 agenda</li>
                    <li>1 revista OM Magazine</li>
                    <li>1 DVD entrenamiento con Jorge</li>
                  </ul>
                  <label class="radio-fake" for="kit1"></label><span class="radio-label">Seleccionar</span>
                </div>
              </label>
            </div>
            <div class="form-radio inline card">
              <input type="radio" id="kit2" name="kit" value="0">
              <figure class="card__img"><img src="{{ asset('themes/omnilife2018/images/9410335.png') }}" alt=""></figure>
              <label class="card__content-wrap" for="kit2">
                <div class="card__content">
                  <h3 class="card__title">KIT MALETÍN NUTRICIONAL WEB</h3>
                  <p class="card__price">$499</p>
                  <ul class="card__features list-nostyle">
                    <li>1 mochila</li>
                    <li>1 botella de agua Blu 500 ml</li>
                    <li>1 Magnum Supreme caja con 30 sachets</li>
                    <li>1 calendario</li>
                    <li>1 agenda</li>
                    <li>1 revista OM Magazine</li>
                    <li>1 DVD entrenamiento con Jorge</li>
                  </ul>
                  <label class="radio-fake" for="kit2"></label><span class="radio-label">Seleccionar</span>
                </div>
              </label>
            </div>
          </div>
          <div class="form-group">
            <div class="form-label">@lang('shopping::register.kit.shipping')</div>
            <div class="form-radio card">
              <input type="radio" id="shipping_way1" name="shipping_way" value="1">
              <label class="card__content-wrap" for="shipping_way1">
                <div class="card__content">
                  <label class="radio-fake" for="shipping_way1"></label><span class="radio-label">Enviar por DHL Internacional</span>
                </div>
              </label>
            </div>
            <div class="form-radio card">
              <input type="radio" id="shipping_way2" name="shipping_way" value="0">
              <label class="card__content-wrap" for="shipping_way2">
                <div class="card__content">
                  <label class="radio-fake" for="shipping_way2"></label><span class="radio-label">Enviar por Estafeta Mexicana</span>
                </div>
              </label>
            </div>
          </div>
          <div class="form-group">
            <div class="form-label">@lang('shopping::register.kit.payment')</div>
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
                      <div class="form-group mediumx left">
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
            <div class="register__total">
              <p class="text small">@lang('shopping::register.kit.bill.subtotal'): $499.00</p>
              <p class="text small">@lang('shopping::register.kit.bill.management'): $66.27</p>
              <p class="text small">@lang('shopping::register.kit.bill.taxes'): $79.43 </p>
              <p class="text">@lang('shopping::register.kit.bill.total'): $575.87</p>
            </div>
          </div>
          <div class="form-group form-checkbox">
            <input type="checkbox" id="savecard" name="savecard">
            <label class="checkbox-fake" for="savecard"></label><span class="checkbox-label">Guardar mi número de tarjeta para la próxima compra en este sitio web.</span>
          </div>
          <div class="buttons-container">
            <button class="button secondary" type="button" data-to="step2">@lang('shopping::register.prev_button')</button>
            <button class="button" type="button" id="make-payment" data-to="step4">@lang('shopping::register.checkout_button')</button>
          </div>
        </div>
      </form>
      <!-- registro bienvenido-->
      <div class="register__step step step4 register__welcome" id="step4">
        <h3>@lang('shopping::register.confirm.email')</h3>
        <p>@lang('shopping::register.confirm.businessman_code'): 001-123-RPT</p>
      </div>
    </div>
  </div>
@endsection

@section('modals')
  <!-- modal cargando-->
  <div class="modal modal-loading" id="realizando-pago">
    <div class="modal__inner ps-container">
      <header class="modal__body">
        <p class="text-top">@lang('shopping::register.modal.header')</p>
        <p class="price">$575.87 MXN</p>
        <div class="loading">
          <figure class="icon-loading"><img src="{{ asset('themes/omnilife2018/images/icons/loading.svg') }}" alt="OMNILIFE - loading"/></figure>
        </div>
        <p class="highlight">@lang('shopping::register.modal.text_highlight')</p>
        <p>@lang('shopping::register.modal.text')</p>
      </header>
    </div>
  </div>
@endsection
