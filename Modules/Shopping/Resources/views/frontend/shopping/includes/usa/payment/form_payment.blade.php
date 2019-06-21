<div class="cart__main-subtitle">{{ trans('shopping::checkout.payment.select_payment') }}</div>
<div id="generic_error"></div>
<div class="form-group">
    @if(isset($paymentMethods) && $paymentMethods->count() > 0)
        @foreach ($paymentMethods as $i => $paymentMethod)
            <div class="form-radio card stack">
                <input type="radio" id="payment{{ $i }}" name="payment" value="{{ $paymentMethod->id }}">
                <label class="card__content-wrap" for="payment1">
                    <div class="card__content">
                        <label class="radio-fake" for="payment{{ $i }}"></label>
                        <span class="radio-label">{{ $paymentMethod->name }}<span class="small">{{ $paymentMethod->description }}</span></span>
                    </div>
                </label>
            </div>
        @endforeach
    @endif
</div>