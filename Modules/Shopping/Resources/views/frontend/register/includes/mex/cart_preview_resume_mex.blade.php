<li id="discount" class="discount_checkout">@lang('shopping::checkout.quotation.resume_cart.discount'): {{ isset($discount) ? $discount : '0%' }}</li>
<li id="subtotal" class="subtotal_checkout">@lang('shopping::checkout.quotation.resume_cart.subtotal'): {{ isset($subtotal) ? $subtotal : '$00.00' }}</li>
<li id="points" class="points_checkout">@lang('shopping::checkout.quotation.resume_cart.points'): {{ isset($points) ? $points : '0000' }}</li>
@if(isset($handle))
    <li id="manage"class="manage_checkout">@lang('shopping::checkout.quotation.resume_cart.handling'): {{ isset($handle) ? $handle : '--' }} </li>
@endif
@if(isset($taxes))
    <li id="taxes" class="taxes_checkout">@lang('shopping::checkout.quotation.resume_cart.taxes'): {{ isset($taxes) ? $taxes : '--' }}</li>
@endif
<li id="total" class="total total_checkout">@lang('shopping::checkout.quotation.resume_cart.total'): {{ isset($total) ? $total : $subtotal }}</li>
