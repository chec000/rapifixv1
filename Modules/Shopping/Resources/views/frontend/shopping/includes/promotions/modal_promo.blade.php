<div class="modal alert modal-promos" id="promo">
    <div class="form-group">
        <header class="modal__head">
            <h5 class="modal__title highlight">@lang('shopping::checkout.promotions.title_modal')</h5>
        </header>
        <div class="form-label">@lang('shopping::checkout.promotions.msg_select_promotions')</div>

        <div class="modal__body promotions-modal">
            {{ Form::open(array('url' => 'getQuantityPomotions','id'=>'form_quantityPromotions')) }}
            <input type="hidden" name="process" class="process" value="{{ isset($process) ? $process : "" }}">
            @if(isset($promotions['head']) && !empty($promotions['head']))
                @foreach($promotions['head'] as $indexPromo => $typePromo)
            <hr>
                    @foreach($typePromo as $promo)
            <div role="tab" class="panel-heading form-label">
                <h2 class="panel-title">
                    <a id="btnCollapsePromo{{$promo['key_promo']}}" class="btn promo_collpase accordion-toggle {{ !$promo['required'] ? 'collapsed' : '' }}" role="button" data-id_promo="{{$promo['key_promo']}}"
                       onclick="showHidePromo('{{$promo['key_promo']}}')">{{$promo['description']}}  {{ $promo['required'] ? trans('shopping::checkout.promotions.msg_promo_required') : '' }}</a>
                </h2>
            </div>

            <div id="collapsePromo{{$promo['key_promo']}}" class="form-group" style="{{ !$promo['required'] ? 'display : none' : '' }}">
                <input type="hidden" class="promoRequired" value="{{ $promo['required'] ? 1 : 0 }}">
                <input type="hidden" class="maxQuantity" value="{{ $promo['quantity'] }}">
                <input type="hidden" class="keyPromo" value="{{ $promo['key_promo'] }}">
                <div class="form-label">{{trans_choice('shopping::checkout.promotions.msg_promo_'.$indexPromo, $promo['quantity'] , ['qty' => $promo['quantity']])}}</div>

                    @foreach($promotions['items'][$promo['type']][$promo['key_promo']] as $indexLine => $line)
                        @include("shopping::frontend.shopping.includes.promotions.promo".$indexPromo,
                            ['indexPromo' => $indexPromo,
                            'indexLine'=> $indexLine,
                            'promo' => $promo,
                            'line' => $line
                            ])

                    @endforeach
            </div>
            <div class="error-msg" id="div_msg_error_{{$promo['key_promo']}}"></div>
                    @endforeach
                @endforeach
            @endif
            {{ Form::close() }}
        </div>
    </div>
    <div class="buttons-container">
        <button id="btnValidatePromos" class="button small" type="button">@lang('shopping::checkout.promotions.btn_accept')</button>
    </div>
</div>

<script type="text/javascript">




</script>