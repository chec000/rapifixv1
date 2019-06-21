<div class="form-radio inline card discount" id="promoLine{{$indexLine}}">
    <input type="hidden" class="idLine" value="{{$indexLine}}">
    <label class="card__content-wrap" for="discount{{ $promo['key_promo'] }}">
        <div class="card__content">
            @foreach($line as $item)
            <h3 class="card__title"><b>{{$item['quantity']}} X </b> {{$item['description']}} <span class="card__price discount">{{$item['price']}}</span></h3>
            @endforeach
            <p class="card__price discount">@lang('shopping::checkout.promotions.label_quantity'):</p>
            <div class="form-group numeric discount">
                <span class="minus" onclick="minusPromo('{{ $promo['key_promo'] }}','{{$indexLine}}')">
                    <svg height="14" width="14">
                        <line x1="0" y1="8" x2="14" y2="8"></line>
                    </svg>
                </span>
                    <input class="form-control number" maxlength="4" onkeypress="return esNumero(event)"
                           name="qtyPromo[{{$indexPromo}}][{{$item['key_promo']}}][{{$indexLine}}]" value="0" type="numeric">
                <span class="plus" onclick="plusPromo('{{ $promo['key_promo'] }}','{{$indexLine}}')">
                    <svg height="14" width="14">
                    <line x1="0" y1="7" x2="14" y2="7"></line>
                    <line x1="7" y1="0" x2="7" y2="14"></line>
                    </svg>
                </span>
            </div>
            <ul class="card__features list-nostyle"></ul>
        </div>
    </label>
</div>