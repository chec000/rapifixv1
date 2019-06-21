
<div class="form-group">
    <div class="form-radio card stack">
            <div class="card__content">
                <div class="error__box" id="error_step1_add" style="display: none;">
                                    <span class="error__single">
                                        <img src="{{ asset('themes/omnilife2018/images/icons/warning.svg') }}">@lang('shopping::shippingAddress.we_have_a_problem'):
                                    </span>
                    <ul id="error__boxSA_ul_step1_add">
                    </ul>
                </div>
        {{ Form::open(array('url' => 'addShippingAddress','id'=>'form_addShippingAddress')) }}

                <span class="radio-label">
                    @lang('shopping::shippingAddress.new_address')
                    <span class="small">@lang('shopping::shippingAddress.enter_new_data') <br></span>
                    <span class="small">@lang('shopping::shippingAddress.msg_new_address_change')</span>
                </span>
                <div class="card__extra">
                    <div class="form-row">
                        <div class="form-group left">
                            <input class="form-control" type="text" id="description" name="description" placeholder="@lang('shopping::shippingAddress.fields.description.placeholder')*">
                            <div class="error-msg" id="div_description"></div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group large">
                            <input class="form-control" type="text" id="name" name="name" placeholder="@lang('shopping::shippingAddress.fields.name.label')*">
                            <div class="error-msg" id="div_name"></div>
                        </div>
                        <div class="form-group medium">
                            <input class="form-control" type="text" id="zip" name="zip" placeholder="@lang('shopping::shippingAddress.fields.zip.placeholder')">
                            <div class="error-msg" id="div_zip"></div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group select medium">
                            <select class="form-control" id="state" name="state">
                                <option value="">@lang('shopping::shippingAddress.fields.state.placeholder')</option>
                            </select>
                            <div class="error-msg" id="div_state"></div>
                        </div>
                        <div class="form-group select medium">
                            <select class="form-control" id="city" name="city">
                                <option value="">@lang('shopping::shippingAddress.fields.city.placeholder')</option>
                            </select>
                            <input type="hidden" id="city_name" name="city_name">
                            <div class="error-msg" id="div_city"></div>
                        </div>
                        <div class="form-group medium">
                            <input class="form-control" type="text" id="suburb" name="suburb" placeholder="@lang('shopping::shippingAddress.fields.suburb.placeholder')">
                            <div class="error-msg" id="div_suburb"></div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group left">
                            <input class="form-control" type="text" id="address" name="address" placeholder="@lang('shopping::shippingAddress.fields.address.placeholder') @lang('shopping::shippingAddress.fields.address.example')*">
                            <div class="error-msg" id="div_address"></div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group medium">
                            <input class="form-control" type="email" id="email" name="email" placeholder="@lang('shopping::shippingAddress.fields.email.placeholder')">
                            <div class="error-msg" id="div_email"></div>
                        </div>
                        <div class="form-group medium">
                            <input class="form-control" type="text" id="phone" name="phone" placeholder="@lang('shopping::shippingAddress.fields.phone.placeholder')*">
                            <div class="error-msg error-validation" id="div_phone"></div>
                        </div>
                        <div class="form-group select medium">
                            <select class="form-control" id="shipping_company" name="shipping_company">
                                <option value="">@lang('shopping::shippingAddress.fields.shippingCompany.placeholder')</option>
                            </select>
                            <div class="error-msg" id="div_shipping_company"></div>
                        </div>
                    </div>
                    <div class="form-row">
                        <button id="btnAddShippingAddress" class="button small" type="button">@lang('shopping::shippingAddress.save')</button>
                    </div>
                </div>
            </div>
        {{ Form::close() }}
    </div>
</div>

<script>

    $('#zip').autocomplete({
        minChars: 4,
        serviceUrl: "{{ route('checkout.shippingAddress.zipcode') }}",
        type: "POST",
        dataType: "json",
        paramName: "zipCode",
        params: { _token: '{{csrf_token()}}'},
        onSelect: function (suggestion) {
            console.log(suggestion);
            $("#zip").val(suggestion.data.zipcode);

            citybystateSA(suggestion.data.idState,suggestion.data.idCity);
            $("#state").val(suggestion.data.idState);
            $("#suburb").val(suggestion.data.suburb);
            $('#state').attr('readonly', true);
            $('#city').attr('readonly', true);

        },
        onSearchComplete: function (query, suggestions) {

            if (suggestions.length === 0) {
                // arr is empty
                $("#state").removeAttr("readonly");
                $("#city").removeAttr("readonly");
                $("#suburb").removeAttr("readonly");
                $('#suburb').val('');
                $('#state').val('');
                $('#city').val('');
                $('#city_name').val('');

            }
        },

    });

    function citybystateSA(stateSelected,citySelected){
        var htmlCities = '';
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            url: "{{ route('checkout.shippingAddress.cities') }}",
            data: {'state':stateSelected, _token: '{{csrf_token()}}'},
            success: function (result){
                console.log(result);
                if(result.status){
                    $("#error__boxSA_ul_step1").html("");
                    $("#error_step1").hide();
                    $('#city').removeClass('has-error');

                    $.each(result.data, function (i, item) {
                        var atrSelected =  citySelected != '' && citySelected == $.trim(item.id) ? 'selected' : '';
                        htmlCities += '<option value="'+$.trim(item.id)+'" ' + atrSelected + ' >' + $.trim(item.name) + '</option>';

                    });
                    $('#city').append(htmlCities);
                    $("#city").trigger("change");

                }else{
                    $("#error_step1").show();
                    $("#error__boxSA_ul_step1").html("");
                    $("#city").addClass("has-error");
                    $.each(result.messages, function (i, item) {
                        $("#error__boxSA_ul_step1").append("<li class='text-danger'>"+item+"</li>");
                    });
                }
            },
            error:function(result){
                console.log("Error cities");
            },
            beforeSend: function () {
                $("#error__boxSA_ul_step1").html("");
                $("#error_step1").hide();
                $("#city").children('option:not(:first)').remove();

            },
            complete: function () {

            }
        });

    }



</script>