<div class="modal alert address" id="addressAdd">
    <button class="button secondary close modal-close" type="button">X</button>
    <div class="modal__inner ps-container">
        <header class="modal__head">
            <h5 class="modal__title highlight">@lang('shopping::shippingAddress.new_address')</h5>
        </header>
        <div class="">
            <div class="card__content">

                <div class="form-group">
                    <span class="small">@lang('shopping::shippingAddress.enter_new_data') <br></span>
                    <span class="small">@lang('shopping::shippingAddress.msg_new_address_change')</span>
                </div>

                <div class="error__box" id="error_step1_add" style="display: none; width:100%;">
                    <span class="error__single">
                        <img src="{{ asset('themes/omnilife2018/images/icons/warning.svg') }}">@lang('shopping::shippingAddress.we_have_a_problem'):
                    </span>
                    <ul id="error__boxSA_ul_step1_add"></ul>
                    <br>
                </div>

                {{ Form::open(array('url' => 'addShippingAddress','id'=>'form_addShippingAddress')) }}
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
                        <select class="form-control" disabled="disabled" id="state">
                            <option value="">@lang('shopping::shippingAddress.fields.state.placeholder')</option>
                        </select>
                        <input type="hidden" value="" name="state" id="state_hidden" />
                        <div class="error-msg" id="div_state"></div>
                    </div>
                    <div class="form-group select medium">
                        <select class="form-control" disabled="disabled" id="city">
                            <option value="">@lang('shopping::shippingAddress.fields.city.placeholder')</option>
                        </select>
                        <input type="hidden" value="" name="city" id="city_hidden" />
                        <input type="hidden" id="city_name" name="city_name">
                        <div class="error-msg" id="div_city"></div>
                    </div>
                    <div class="form-group medium">
                        <input class="form-control" readonly="readonly" type="text" id="suburb" name="suburb" placeholder="@lang('shopping::shippingAddress.fields.suburb.placeholder')">
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
                    <div class="form-group left">
                        <input class="form-control" type="text" id="complement" name="complement" placeholder="@lang('shopping::shippingAddress.fields.complement.placeholder')">
                        <div class="error-msg" id="div_complement"></div>
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
                {{ Form::close() }}
            </div>
        </div>
        <footer class="modal__foot">
            <div class="buttons-container">
                <button class="button secondary close" type="button">@lang('shopping::shippingAddress.cancel')</button>
                <button id="btnAddShippingAddress" class="button primary" type="button">@lang('shopping::shippingAddress.save')</button>
            </div>
        </footer>
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
        ajaxSettings: {
            statusCode: { 419: function () { window.location.href = URL_PROJECT; } },
        },
        onSelect: function (suggestion) {
            console.log(suggestion);
            $("#zip").val(suggestion.data.zipcode);

            citybystateSA(suggestion.data.idState,suggestion.data.idCity);
            $("#state").val(suggestion.data.idState);
            $('#state_hidden').val(suggestion.data.idState);
            $('#city').val(suggestion.data.idCity);
            $('#city_hidden').val(suggestion.data.idCity);

            $("#suburb").val(suggestion.data.suburb);
            $('#state').attr('disabled', true);
            $('#city').attr('disabled', true);

        },
        onSearchComplete: function (query, suggestions) {

            if (typeof(suggestions) == "undefined" || suggestions === null) {
                // arr is empty
                $('#state').removeAttr('disabled');
                $('#city').removeAttr('disabled');
                $('#suburb').removeAttr('readonly');
                $('#suburb').val('');
                $('#state').val('');
                $('#city').val('');
                $('#city_hidden').val('');
                $('#city_name').val('');
                $('#state_hidden').val('');
                $("#div_zip").html("");

            }else{
                $('#suburb').val('');
                $('#state').val('');
                $('#city').val('');
                $('#city_hidden').val('');
                $('#city_name').val('');
                $('#state_hidden').val('');
                $('#state').attr('disabled', true);
                $('#city').attr('disabled', true);
                $('#suburb').attr('readonly', true);
            }
        },

    });

    function citybystateSA(stateSelected,citySelected){
        $(".loader").addClass("show");
        var htmlCities = '';
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            url: "{{ route('checkout.shippingAddress.citiesUSA') }}",
            data: {'state':stateSelected, 'city':citySelected, _token: '{{csrf_token()}}'},
            statusCode: { 419: function() { window.location.href = URL_PROJECT; }},
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
                    getShippingCompany(stateSelected,citySelected);
                    //$("#city").trigger("change");

                }else{
                    $("#error_step1").show();
                    $("#error__boxSA_ul_step1").html("");
                    $("#city").addClass("has-error");
                    $.each(result.messages, function (i, item) {
                        $("#error__boxSA_ul_step1").append("<li class='text-danger'>"+item+"</li>");
                    });
                }

                $(".loader").removeClass("show");
            },
            error:function(result){
                console.log("Error cities");
                $(".loader").removeClass("show");
            },
            beforeSend: function () {
                $("#error__boxSA_ul_step1").html("");
                $("#error_step1").hide();
                $("#city").children('option:not(:first)').remove();

            },
            complete: function () {
                $(".loader").removeClass("show");
            }
        });

    }

    function getZipCodeFromCorbiz(zip) {
        $.ajax({
            url: "{{ route('checkout.shippingAddress.zipcode') }}",
            type: 'POST',
            dataType: 'JSON',
            data: { zipCode: zip },
            statusCode: {
                419: function() {
                    window.location.href = URL_PROJECT;
                }
            },
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            success: function(result) {
                $('#zip').val(result.suggestions[0].data.zipcode);
                $('#state').val(result.suggestions[0].data.idState);
                $('#state_hidden').val(result.suggestions[0].data.idState);

                citybystateSA(result.suggestions[0].data.idState,result.suggestions[0].data.idCity);

                $('#suburb').val(result.suggestions[0].data.suburb);
                $('#city_hidden').val(result.suggestions[0].data.idCity);

                $('.loader').removeClass('show').addClass('hide');
            },
            beforeSend: function() {
                $('.loader').removeClass('hide').addClass('show');
            },
            error: function(result) {
                $('.loader').removeClass('show').addClass('hide');
            }
        });
    }

    function getShippingCompany(state, city) {
        var cityname = $("#city option:selected").text();
        var htmlShippingCompanies = '';
        $.ajax({
            type: "POST",
            url: "{{ route('checkout.shippingAddress.shippingCompanies') }}",
            data: {'state': state, 'city': city, _token: '{{csrf_token()}}'},
            statusCode: {
                419: function () {
                    window.location.href = URL_PROJECT;
                }
            },
            success: function (result) {

                if (result.status) {
                    $("#error__boxSA_ul_step1").html("");
                    $("#error_step1").hide();

                    $('#shipping_company').removeClass('has-error');
                    if (!$.trim(result.data)) {

                        $("#error_step1").show();
                        $("#error__boxSA_ul_step1").append("<li class='text-danger'>" + translations.errorEmptyShippingCompanies + "</li>");
                        $('html,body').animate({
                            scrollTop: $(".tabs-static").offset().top
                        }, 'slow');
                    } else {
                        $.each(result.data, function (i, item) {

                            htmlShippingCompanies += '<option value="' + $.trim(item.comp_env) + '">' + $.trim(item.descripcion) + '</option>';

                        });
                        $("#shipping_company").append(htmlShippingCompanies);
                    }

                } else {

                    $("#error_step1").show();
                    $("#error__boxSA_ul_step1").html("");
                    $("#shipping_company").addClass("has-error");
                    $.each(result.messages, function (i, item) {
                        $("#error__boxSA_ul_step1").append("<li class='text-danger'>" + item + "</li>");
                    });
                }
            },
            error: function (result) {

            },
            beforeSend: function () {

                $("#error__boxSA_ul_step1").html("");
                $("#error_step1").hide();
                $("#shipping_company").children('option:not(:first)').remove();

            },
            complete: function () {

            }
        })
    }

    $(document).on("click", "#btnAddressAdd", function (){
        cleanMessagesvalidateFieldsPortalSA("step1");
        //Funciones para la carga de datos en el formulario de registro de direcciones

        $("#error_step1_add").css('display', 'none');
        $("#error__boxSA_ul_step1_add").html("");
        $("#error__boxSA_ul_step1_add").find(".div_details_error").remove();


        getStatesSA(country, 1);

        setTimeout(
            function () {
                if (defaultZipcode !== "0") {
                    getZipCodeFromCorbiz(defaultZipcode);
                }
                $("#addressAdd").addClass("active");
                $(".loader").removeClass("show");
                $(".overlay").css("display",'block');
            }, 500);
    });

    function getStatesSA(country,start){

        var stateHtml = '';
        $.ajax({
            type: "POST",
            url: "{{ route('checkout.shippingAddress.states') }}",
            data: {'country':country, _token: '{{csrf_token()}}'},
            statusCode: { 419: function() { window.location.href = URL_PROJECT; }},
            success: function (result){

                if(result.status){
                    if( start !== 1){
                        $("#error__boxSA_ul_step1").html("");
                        $("#error_step1").hide();
                    }
                    $('#state').removeClass('has-error');
                    $('#edit_state').removeClass('has-error');

                    $.each(result.data, function (i, item) {
                        stateHtml += '<option value="'+$.trim(item.id)+'">' + $.trim(item.name) + '</option>';
                    });
                    $("#state").append(stateHtml);
                    $("#edit_state").append(stateHtml);
                }else{
                    if(start !== 1){
                        $("#error__boxSA_ul_step1").html("");
                    }

                    $("#error_step1").show();
                    $("#state").addClass("has-error");
                    $("#editstate").addClass("has-error");
                    $.each(result.messages, function (i, item) {
                        $("#error__boxSA_ul_step1").append("<li class='text-danger'>"+item+"</li>");
                    });
                }
            },
            error:function(result){
            },
            beforeSend: function () {
                if(start !== 1){
                    $("ul#error__boxSA_ul_step1").html("");
                }
                $("#error_step1").hide();
                $("#state").children('option:not(:first)').remove();
                $("#edit_state").children('option:not(:first)').remove();
            },
            complete: function () {
            }
        });
    }

    $(document).on('change','#state',function () {
        var state = $(this).val();
        var country = $("#current_country").val();
        var htmlCities = '';
        $('#state_hidden').val($(this).val());
        $.ajax({
            type: "POST",
            url: "{{ route('checkout.shippingAddress.cities') }}",
            data: {'country':country,'state':state, _token: '{{csrf_token()}}'},
            statusCode: { 419: function() { window.location.href = URL_PROJECT; }},
            success: function (result){

                if(result.status){
                    $("#error__boxSA_ul_step1").html("");
                    $("#error_step1").hide();

                    $("#city_name").val("");

                    $('#city').removeClass('has-error');

                    $.each(result.data, function (i, item) {

                        htmlCities += '<option value="'+$.trim(item.id)+'">' + $.trim(item.name) + '</option>';

                    });
                    $("#city").append(htmlCities);
                }else{
                    $("#error_step1").show();
                    $("#error__boxSA_ul_step1").html("");
                    $("#city").addClass("has-error");
                    $("#city_name").val("");
                    $.each(result.messages, function (i, item) {
                        $("#error__boxSA_ul_step1").append("<li class='text-danger'>"+item+"</li>");
                    });
                }
            },
            error:function(result){

            },
            beforeSend: function () {
                $("#error__boxSA_ul_step1").html("");
                $("#error_step1").hide();
                $("#city").children('option:not(:first)').remove();

            },
            complete: function () {

            }
        });
    });

    $(document).on('change','#city',function () {
        var state = $("#state").val();
        var city = $(this).val();
        $('#city_hidden').val($(this).val());
        var cityname = $("#city option:selected").text();
        var htmlShippingCompanies = '';
        $.ajax({
            type: "POST",
            url: "{{ route('checkout.shippingAddress.shippingCompanies') }}",
            data: {'state':state, 'city':city, _token: '{{csrf_token()}}'},
            statusCode: { 419: function() { window.location.href = URL_PROJECT; }},
            success: function (result){

                if(result.status){
                    $("#error__boxSA_ul_step1").html("");
                    $("#error_step1").hide();
                    $("#city_name").val(cityname);
                    $('#shipping_company').removeClass('has-error');
                    if(!$.trim(result.data)){

                        $("#error_step1").show();
                        $("#error__boxSA_ul_step1").append("<li class='text-danger'>"+translations.errorEmptyShippingCompanies+"</li>");
                        $('html,body').animate({
                            scrollTop: $(".tabs-static").offset().top
                        }, 'slow');
                    } else {
                        $.each(result.data, function (i, item) {

                            htmlShippingCompanies += '<option value="' + $.trim(item.comp_env) + '">' + $.trim(item.descripcion) + '</option>';

                        });
                        $("#shipping_company").append(htmlShippingCompanies);
                    }

                }else{

                    $("#error_step1").show();
                    $("#error__boxSA_ul_step1").html("");
                    $("#shipping_company").addClass("has-error");
                    $.each(result.messages, function (i, item) {
                        $("#error__boxSA_ul_step1").append("<li class='text-danger'>"+item+"</li>");
                    });
                }
            },
            error:function(result){

            },
            beforeSend: function () {

                $("#error__boxSA_ul_step1").html("");
                $("#error_step1").hide();
                $("#shipping_company").children('option:not(:first)').remove();

            },
            complete: function () {

            }
        });
    });

    $(document).on('click','#btnAddShippingAddress',function () {
        validateAddShippingAddress();
    });

    function validateAddShippingAddress() {
        var url = "{{route('checkout.shippingAddress.validateAddShippingAddress')}}";
        var form = $("#form_addShippingAddress");
        var tipo  = 'addShippingAddress';
        var step = 'step1';
        var nextStep = 'step2';

        validateFieldsPortalSA(url,form,tipo,step,nextStep);
    }

    function validateFieldsPortalSA(url,form,tipo,step,nextStep) {
        cleanMessagesvalidateFieldsPortalSA(step);

        $.ajax({
            url: url,
            type: 'POST',
            dataType: 'JSON',
            data: form.serialize(),
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            statusCode: { 419: function() { window.location.href = URL_PROJECT; }},
            success: function (data) {
                if (data.success == true) {
                    if (tipo == 'checkout') {
                        if (step == 'step1') {
                            $('#tab__' + step).removeClass('active');
                            $('#' + step).removeClass('active');
                            $('#tab__' + nextStep).addClass('active');
                            $('#' + nextStep).addClass('active');
                        }
                        else if (step == 'step2') {
                        }
                        else if (step == 'step3') {
                        }
                    }
                    if(tipo == 'addShippingAddress'){
                        saveShippingAddress(form.serialize());
                    }
                    if(tipo == 'editShippingAddress'){
                        var folioEdit = form.find("#edit_idfolio").val();
                        saveEditShippingAddress(form.serialize(), folioEdit);
                    }
                }
                else if (data.success == false) {
                    $.each(data.message, function(key, message) {
                        addErrorMsgValidateFieldsPortalSA(key, message);
                    });
                }
            }
        });
    }

    function saveShippingAddress(dataForm){

        var successSave = false;
        var successFolio = false;
        $.ajax({
            type: "POST",
            url: "{{ route("checkout.shippingAddress.addShippingAddress") }}",
            data: dataForm,
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            statusCode: { 419: function() { window.location.href = URL_PROJECT; }},
            success: function (result){

                if(result.status){
                    successSave = true;
                    successFolio = result.Folio;
                    $("#error__boxSA_ul_step1_add").html("");
                    $("#error_step1_add").hide();
                    $("#success_step1").show();
                    $("#success__boxSA_ul_step1").html("");
                    $("#success__boxSA_ul_step1").append("<li class='text-success'>"+result.message_modal+"</li>");

                    document.getElementById("form_addShippingAddress").reset();

                    $(".overlay").css("display",'none');
                    $("div#addressAdd").removeClass("active");

                }else{
                    $("#error_step1_add").show();
                    $("#error__boxSA_ul_step1_add").html("");
                    $.each(result.messages, function (i, item) {
                        $("#error__boxSA_ul_step1_add").append("<li class='text-danger'>"+item+"</li>");
                    });

                    if (result.details != '') {
                        $("#error__boxSA_ul_step1_add")
                            .append('<div align="left"class="div_details_error"><a href="#" class="detail-err-open" style="text-align: right;font-size: 12px;color: #F44336;text-decoration: underline;">{{trans('cms::errors.modal.more')}}</a></div>');
                        setErrors(result.details);
                    }

                }
            },
            error:function(result){

            },
            beforeSend: function () {
                $("#error__boxSA_ul_step1_add").html("");
                $("#error_step1_add").hide();
            },
            complete: function () {

                $('html,body').animate({
                    scrollTop: $(".tabs-static").offset().top
                }, 'slow');
            }
        }).then(function(){
            if(successSave) {
                setTimeout(
                    function() {
                        getShippingAddress(1,0, successFolio);
                    }, 1000);
            } else {
                getShippingAddress(0,0, false);
            }
        });
    }

    function addErrorMsgValidateFieldsPortalSA(key, message) {
        $('#' + key).addClass('has-error');
        $('#div_' + key).html(message);
    }

    function cleanMessagesvalidateFieldsPortalSA(step) {
        $('#error__box_' + step).hide();
        $('#error__box_ul_' + step).html('');
        $('.has-error').removeClass('has-error');
        $('.error-msg').html('');
    }

</script>