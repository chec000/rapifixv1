<div class="form-label block">@lang('shopping::register_customer.account.address.label')</div>

<div class="form-group medium">
    <input class="form-control" type="text" id="zip" name="zip" placeholder="@lang('shopping::register_customer.account.address.placeholders.zip')*" class="{{config('register.country')}}" maxlength="8">

    <div class="error-msg" id="div_zip"></div>
</div>

<div class="form-group large">
    <input class="form-control" type="text" id="street" name="street" placeholder="@lang('shopping::register_customer.account.address.placeholders.street')*" maxlength="120">

    <div class="error-msg" id="div_message_street" style="color:black;padding-top:5px;">@lang('shopping::register.info.address.street_message')</div>

    <div class="error-msg" id="div_street"></div>
</div>

<div class="form-group select medium">
    <select class="form-control" readonly="readonly" name="state" id="state" disabled="disabled">
        <option value="default">@lang('shopping::register_customer.account.address.placeholders.state')*</option>
    </select>

    <input type="hidden" value="" name="state_hidden" id="state_hidden" />

    <div class="error-msg" id="div_state_hidden"></div>
</div>

<div class="form-group select medium">
    <select class="form-control" readonly="readonly" name="city" id="city" disabled="disabled">
        <option value="default">@lang('shopping::register_customer.account.address.placeholders.city')*</option>
    </select>

    <input type="hidden" value="" name="city_hidden" id="city_hidden" />
    <input type="hidden" value="" name="city_name" id="city_name" />

    <div class="error-msg" id="div_city_hidden"></div>
</div>

<div class="form-group medium">
    <input class="form-control" type="text" id="colony" name="colony" placeholder="@lang('shopping::register_customer.account.address.placeholders.county')*" readonly>

    <div class="error-msg" id="div_colony"></div>
</div>

<div class="form-group large">
    <input class="form-control" type="text" id="betweem_streets" name="betweem_streets" placeholder="@lang('shopping::register_customer.account.address.placeholders.betweem_streets')" maxlength="80">
</div>

<div class="form-group select medium">
    <select class="form-control" readonly="readonly" name="shipping_company" id="shipping_company">
        <option value="default">@lang('shopping::register_customer.account.address.placeholders.shipping_company')*</option>
    </select>

    <div class="error-msg" id="div_shipping_company"></div>
</div>

@if(config('shopping.zip.'.Session::get('portal.register_customer.country_corbiz').'.applies') == true)
    <script>
        var field       = "zip";
        var chars       = 4;
        var url         = "{{route('registercustomer.zipcode')}}";
        var urlcities   = "{{route('registercustomer.cities')}}";
        var paramName   = "zipCode";
        var token       = "{{csrf_token()}}";
        var validate    = "{{config('shopping.zip.' . Session::get('portal.register_customer.country_corbiz') . '.validate')}}";
        var check       = "{{config('shopping.zip.' . Session::get('portal.register_customer.country_corbiz') . '.check')}}";
        var tipo        = 'register_customer';
        var message     = "@lang('shopping::register.info.address.placeholders.choose_zip')";

        validateFieldAutocomplete(url,urlcities,field,chars,paramName,token,validate,check,tipo,message);
    </script>
@endif