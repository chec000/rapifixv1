
<li id="subtotal" class="subtotal_checkout">@lang('shopping::checkout.quotation.resume_cart.subtotal'): {{ isset($subtotal) ? $subtotal : '$00.00' }}</li>
<li id="points" class="points_checkout">@lang('shopping::checkout.quotation.resume_cart.points'): {{ isset($points) ? $points : '0000' }}</li>
@if(isset($handle))
    <li id="manage"class="manage_checkout">@lang('shopping::checkout.quotation.resume_cart.handling'): {{ isset($handle) ? $handle : '--' }} </li>
@endif
@if(isset($taxes))
    <li id="taxes" class="taxes_checkout">@lang('shopping::checkout.quotation.resume_cart.taxes'): {{ isset($taxes) ? $taxes : '--' }}</li>
@endif
<li id="total" class="total total_checkout">@lang('shopping::checkout.quotation.resume_cart.total'): {{ isset($total) ? $total : $subtotal }}</li>

@if (isset($show_period_change) && $show_period_change)
    <div class="form-group violet__box" id="change_period_step1">
    <span>
        <b>@lang('shopping::checkout.quotation.change_period')  </b>
    </span>
        <label>@lang('shopping::checkout.quotation.change_period_yes')
            <input type="radio" id="address'+value.folio+'" class="btnchangePeriodQuotation" name="change_period_quotation" value="1"
                    {{ $change_period == 1 ? 'checked=checked' : ''  }}>
        </label>
        <label>@lang('shopping::checkout.quotation.change_period_no')
            <input type="radio" id="address'+value.folio+'" class="btnchangePeriodQuotation" name="change_period_quotation" value="0"
                    {{ $change_period != 1 ? 'checked=checked' : ''  }}>
        </label>
    </div>
@endif