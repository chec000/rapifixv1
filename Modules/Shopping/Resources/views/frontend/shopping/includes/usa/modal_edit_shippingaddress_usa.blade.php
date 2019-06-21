<div class="modal alert address" id="addressEdit">
                <button class="button secondary close modal-close" type="button">X</button>
    <div class="modal__inner ps-container">
        <header class="modal__head">
            <h5 class="modal__title highlight">@lang('shopping::shippingAddress.edit_address')</h5>
        </header>
        <div class="">
            <div class="card__content">
                <div class="error__box" id="error_step1_modal_edit" style="display: none;">
                            <span class="error__single">
                                <img src="{{ asset('themes/omnilife2018/images/icons/warning.svg') }}">@lang('shopping::shippingAddress.we_have_a_problem'):
                            </span>
                    <ul id="error__boxSA_ul_step1_modal_edit">
                    </ul>
                </div>
                {{ Form::open(array('url' => 'editShippingAddress','id'=>'form_editShippingAddress')) }}
                <div class="form-row" id="idDivDescriptionEdit">
                    <div class="form-group left">
                        <input class="form-control" type="text" id="edit_description" name="edit_description" placeholder="@lang('shopping::shippingAddress.fields.description.placeholder')*">
                        <div class="error-msg" id="div_edit_description"></div>
                    </div>
                </div>
                <div id="idDivNameEdit" class="form-row">
                    <div class="form-group large">
                        <input class="form-control" type="text" id="edit_name" name="edit_name" placeholder="@lang('shopping::shippingAddress.fields.name.label')*">
                        <div class="error-msg" id="div_edit_name"></div>
                    </div>
                    <div class="form-group medium">
                        <input class="form-control" type="text" id="edit_zip" name="edit_zip" placeholder="@lang('shopping::shippingAddress.fields.zip.placeholder')">
                        <div class="error-msg" id="div_edit_zip"></div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group select medium">
                        <select class="form-control" id="edit_state"  disabled="disabled">
                            <option value="">@lang('shopping::shippingAddress.fields.state.label')</option>
                        </select>
                        <input type="hidden" value="" name="edit_state" id="edit_state_hidden" />
                        <div class="error-msg" id="div_edit_state"></div>
                    </div>
                    <div class="form-group select medium">
                        <select class="form-control" id="edit_city" disabled="disabled">
                            <option value="">@lang('shopping::shippingAddress.fields.city.label')</option>
                        </select>
                        <input type="hidden" value="" name="edit_city" id="edit_city_hidden" />
                        <input type="hidden" id="edit_city_name" name="edit_city_name">
                        <div class="error-msg" id="div_edit_city"></div>
                    </div>
                    <div class="form-group medium">
                        <input class="form-control" type="text" id="edit_county" name="edit_county" readonly="readonly" placeholder="@lang('shopping::shippingAddress.fields.county.placeholder')">
                        <div class="error-msg" id="div_edit_county"></div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group left">
                        <input class="form-control" type="text" id="edit_address" name="edit_address" placeholder="@lang('shopping::shippingAddress.fields.address.placeholder') @lang('shopping::shippingAddress.fields.address.example')*">
                        <div class="warning-msg" id="div_message_edit_address" style="color:black;padding-top:5px;font-size: 14px;">@lang('shopping::register.info.address.street_message')</div>
                        <div class="error-msg" id="div_edit_address"></div>
                    </div>
                </div>
                <div id="idDivComplementEdit" class="form-row">
                    <div class="form-group left">
                        <input class="form-control" type="text" id="edit_complement" name="edit_complement" placeholder="@lang('shopping::shippingAddress.fields.complement.placeholder')">
                        <div class="error-msg" id="div_edit_complement"></div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group medium">
                        <input class="form-control" type="email" id="edit_email" name="edit_email" placeholder="@lang('shopping::shippingAddress.fields.email.placeholder')">
                        <div class="error-msg" id="div_edit_email"></div>
                    </div>
                    <div class="form-group medium">
                        <input class="form-control" type="text" id="edit_phone" name="edit_phone" placeholder="@lang('shopping::shippingAddress.fields.phone.placeholder')*">
                        <div class="error-msg error-validation" id="div_edit_phone"></div>
                    </div>
                    <div class="form-group select medium">
                        <select class="form-control" id="edit_shipping_company" name="edit_shipping_company">
                            <option value="">@lang('shopping::shippingAddress.fields.shippingCompany.placeholder')</option>
                        </select>
                        <div class="error-msg" id="div_edit_shipping_company"></div>
                    </div>
                </div>
                <input type="hidden" id="edit_idfolio" name="edit_folio" value="">
                <input type="hidden" id="edit_type" name="edit_type" value="">
                {{ Form::close() }}
            </div>
        </div>
        <footer class="modal__foot">
            <div class="buttons-container">
                <button class="button secondary close" type="button">@lang('shopping::shippingAddress.cancel')</button>
                <button id="btnEditShippingAddress" class="button primary" type="button">@lang('shopping::shippingAddress.save')</button>
            </div>
        </footer>
    </div>
</div><!-- Temp markup -->

<script>

    $('#edit_zip').autocomplete({
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
            $("#edit_zip").val(suggestion.data.zipcode);

            citybystateSAEdit(suggestion.data.idState,suggestion.data.idCity);
            $("#edit_state").val(suggestion.data.idState);
            $("#edit_state_hidden").val(suggestion.data.idState);
            $("#edit_city_hidden").val(suggestion.data.idCity);

            $("#edit_county").val(suggestion.data.county);
            $('#edit_state').attr('disabled', true);
            $('#edit_city').attr('disabled', true);
            $('#edit_county').attr('readonly', true);

            /*$('#edit_state').attr('readonly', true);
            $('#edit_city').attr('readonly', true);*/

        },
        onSearchComplete: function (query, suggestions) {

            if (typeof(suggestions) == "undefined" || suggestions === null) {
                // arr is empty
                $('#edit_state').removeAttr('disabled');
                $('#edit_city').removeAttr('disabled');
                $('#edit_county').removeAttr('readonly');
                $('#edit_county').val('');
                $('#edit_state').val('');
                $('#edit_city').val('');
                $('#edit_city_hidden').val('');
                $('#edit_city_name').val('');
                $('#edit_state_hidden').val('');
                $("#div_edit_zip").html("");

            }else{
                $('#edit_county').val('');
                $('#edit_state').val('');
                $('#edit_city').val('');
                $('#edit_city_hidden').val('');
                $('#edit_city_name').val('');
                $('#edit_state_hidden').val('');
                $('#edit_state').attr('disabled', true);
                $('#edit_city').attr('disabled', true);
                $('#edit_county').attr('readonly', true);
            }
        },

    });

    function citybystateSAEdit(stateSelected,citySelected){
        $(".loader").addClass("show");
        var htmlCities = '';
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            url: "{{ route('checkout.shippingAddress.cities') }}",
            data: {'state':stateSelected, _token: '{{csrf_token()}}'},
            statusCode: { 419: function() { window.location.href = URL_PROJECT; }},
            success: function (result){
                if(result.status){
                    $("#error__boxSA_ul_step1_modal_edit").html("");
                    $("#error_step1_modal_edit").hide();
                    $('#edit_city').removeClass('has-error');

                    $.each(result.data, function (i, item) {
                        var atrSelected =  citySelected != '' && citySelected == $.trim(item.id) ? 'selected' : '';
                        htmlCities += '<option value="'+$.trim(item.id)+'" ' + atrSelected + ' >' + $.trim(item.name) + '</option>';

                    });
                    $('#edit_city').append(htmlCities);
                    changeCitySAEdit(stateSelected,citySelected);
                    //$("#edit_city").trigger("change");

                }else{
                    $("#error_step1_modal_edit").show();
                    $("#error__boxSA_ul_step1_modal_edit").html("");
                    $("#edit_city").addClass("has-error");
                    $.each(result.messages, function (i, item) {
                        $("#error__boxSA_ul_step1_modal_edit").append("<li class='text-danger'>"+item+"</li>");
                    });
                }
                $(".loader").removeClass("show");
            },
            error:function(result){
                $(".loader").removeClass("show");
            },
            beforeSend: function () {
                $("#error__boxSA_ul_step1_modal_edit").html("");
                $("#error_step1_modal_edit").hide();
                $("#edit_city").children('option:not(:first)').remove();

            },
            complete: function () {
                $(".loader").removeClass("show");
            }
        });

    }

    $(document).on('change','#edit_state',function () {
        var state = $(this).val();
        $('#edit_state_hidden').val($(this).val());
        changeStateSAEdit(state);
    });

    function changeStateSAEdit (state){
        var country = $("#current_country").val();
        var htmlCities = '';
        return $.ajax({
            type: "POST",
            url: "{{ route('checkout.shippingAddress.cities') }}",
            data: {'country':country,'state':state, _token: '{{csrf_token()}}'},
            statusCode: { 419: function() { window.location.href = URL_PROJECT; }},
            success: function (result){

                if(result.status){
                    $("#error__boxSA_ul_step1_modal_edit").html("");
                    $("#error_step1_modal_edit").hide();
                    $('#edit_city').removeClass('has-error');
                    $.each(result.data, function (i, item) {

                        htmlCities += '<option value="'+$.trim(item.id)+'">' + $.trim(item.name) + '</option>';

                    });
                    $("#edit_city").append(htmlCities);
                }else{
                    $("#error_step1_modal_edit").show();
                    $("#error__boxSA_ul_step1_modal_edit").html("");
                    $("#edit_city").addClass("has-error");
                    $.each(result.messages, function (i, item) {
                        $("#error__boxSA_ul_step1_modal_edit").append("<li class='text-danger'>"+item+"</li>");
                    });
                }

                return 1;
            },
            error:function(result){
                return 0;
            },
            beforeSend: function () {
                $("#error__boxSA_ul_step1_modal_edit").html("");
                $("#error_step1_modal_edit").hide();
                $("#edit_city").children('option:not(:first)').remove();
                $("#edit_city_name").val("");
            },
            complete: function () {
                return 1;
            }
        });
    }


    $(document).on('change','#edit_city',function () {
        var state = $("#edit_state").val();
        var city = $(this).val();
        $('#edit_city_hidden').val($(this).val());
        var cityName = $("#edit_city option:selected").text();
        $("#edit_city_name").val(cityName);

        changeCitySAEdit(state, city);
    });

    function changeCitySAEdit (state, city){
        var htmlShippingCompanies = '';
        return $.ajax({
            type: "POST",
            url: "{{ route('checkout.shippingAddress.shippingCompanies') }}",
            data: {'state':state, 'city':city, _token: '{{csrf_token()}}'},
            statusCode: { 419: function() { window.location.href = URL_PROJECT; }},
            success: function (result){

                if(result.status){
                    $("#error__boxSA_ul_step1_modal_edit").html("");
                    $("#error_step1_modal_edit").hide();
                    $('#edit_shipping_company').removeClass('has-error');

                    if(!$.trim(result.data)){

                        $("#error_step1_modal_edit").show();
                        $("#error__boxSA_ul_step1_modal_edit").append("<li class='text-danger'>"+translations.errorEmptyShippingCompanies+"</li>");

                        $('div#addressEdit').find(".modal__inner").animate({ scrollTop: 0 }, 'slow');

                    } else {
                        $.each(result.data, function (i, item) {
                            htmlShippingCompanies += '<option value="' + $.trim(item.comp_env) + '">' + $.trim(item.descripcion) + '</option>';
                        });
                        $("#edit_shipping_company").append(htmlShippingCompanies);
                    }
                }else{

                    $("#error_step1_modal_edit").show();
                    $("#error__boxSA_ul_step1_modal_edit").html("");
                    $('#edit_shipping_company').addClass('has-error');
                    $.each(result.messages, function (i, item) {
                        $("#error__boxSA_ul_step1_modal_edit").append("<li class='text-danger'>"+item+"</li>");
                    });
                    $("#edit_city_name").val("");
                }
            },
            error:function(result){
            },
            beforeSend: function () {
                $("#error__boxSA_ul_step1_modal_edit").html("");
                $("#error_step1_modal_edit").hide();
                $("#edit_shipping_company").children('option:not(:first)').remove();
            },
            complete: function () {

            }
        });
    }

    $(document).on("click", ".edit_sa_modal", function (){
        cleanMessagesvalidateFieldsPortalSA("step1");
        var valueFolio = $(this).closest(".card__content").find(".valueFolio").val();
        $("#addressEdit").find("#edit_idfolio").val(valueFolio);
        getStatesSA(country, 1);
        getEditShippingAddress(valueFolio);
    });

    function getEditShippingAddress(folio){

        var resultAjax = false;
        var city = 0;
        var state = 0;
        var placeholderDescr = "@lang('shopping::shippingAddress.fields.description.placeholder')";
        var placeholderComplement = "@lang('shopping::shippingAddress.fields.complement.placeholder')";
        $.ajax({
            type: "POST",
            url: "{{ route('checkout.shippingAddress.getEditShipmentAddress') }}",
            data: {'Folio':folio, _token: '{{csrf_token()}}'},
            statusCode: { 419: function() { window.location.href = URL_PROJECT; }},
            success: function (result){

                resultAjax = result.status;
                if(result.status){
                    var promise = changeStateSAEdit(result.dataShippmentAddress.stateKey).then(function(){
                        changeCitySAEdit(result.dataShippmentAddress.stateKey, result.dataShippmentAddress.cityKey).then(function(){

                            $("#idDivDescriptionEdit").html("");
                            $("#idDivComplementEdit").html("");
                            $("#idDivNameEdit").find('input#edit_name').attr('readonly', true);

                            if(result.dataShippmentAddress.type !== "PERSONAL"){
                                var description_html = "<div class='form-group left'>"
                                    +"<input class='form-control' type='text' id='edit_description' name='edit_description' placeholder='"+placeholderDescr+"*' "
                                    +"value='"+result.dataShippmentAddress.label+"'>"
                                    +"<div class='error-msg' id='div_edit_description'></div>"
                                    +"</div>";
                                $("#idDivDescriptionEdit").append(description_html);
                                var complement_html = "<div class='form-group left' id='idDivComplementEdit'>" +
                                    "<input class='form-control' type='text' id='edit_complement' name='edit_complement' placeholder='"+placeholderComplement+"'" +
                                    "value='"+result.dataShippmentAddress.complement+"'>"+
                                    "<div class='error-msg' id='div_edit_complement'></div>" +
                                    "</div>";
                                $("#idDivComplementEdit").append(complement_html);
                                //$("#edit_description").val(result.dataShippmentAddress.label);
                                $("#idDivNameEdit").find('input#edit_name').removeAttr("readonly");
                            }

                            $("#edit_name").val(result.dataShippmentAddress.name);
                            $("#edit_zip").val(result.dataShippmentAddress.zipcode);

                            $("#edit_state").val(result.dataShippmentAddress.stateKey);
                            $("#edit_state_hidden").val(result.dataShippmentAddress.stateKey);
                            $("#edit_city_hidden").val(result.dataShippmentAddress.cityKey);
                            $("#edit_city").val(result.dataShippmentAddress.cityKey);
                            $("#edit_city_name").val(result.dataShippmentAddress.cityName);
                            $("#edit_county").val(result.dataShippmentAddress.county);
                            $("#edit_address").val(result.dataShippmentAddress.address);
                            //$("#edit_complement").val(result.dataShippmentAddress.complement);
                            $("#edit_email").val(result.dataShippmentAddress.email);
                            $("#edit_phone").val(result.dataShippmentAddress.phone);
                            $("#edit_shipping_company").val(result.dataShippmentAddress.shippingCompany);
                            $("#addressEdit").find("#edit_type").val(result.dataShippmentAddress.type);
                            $("#addressEdit").addClass("active");
                            $(".loader").removeClass("show");
                            $(".overlay").css("display",'block');
                        });
                    });

                }else{

                    $("#error_step1").show();
                    $("#error__boxSA_ul_step1").html("");
                    $.each(result.messages, function (i, item) {
                        $("#error__boxSA_ul_step1").append("<li class='text-danger'>"+item+"</li>");
                    });
                    $(".loader").removeClass("show");
                }
            },
            error:function(result){
                $(".loader").removeClass("show");
            },
            beforeSend: function () {
                $(".loader").addClass("show");
                $("#error__boxSA_ul_step1_modal_edit").html("");
                $("#error_step1_modal_edit").css('display', 'none');
            },
            complete: function () {
            }
        });
    }


    $(document).on('click','#btnEditShippingAddress',function () {
        validateEditShippingAddress();
    });

    function validateEditShippingAddress() {
        var url = "{{route('checkout.shippingAddress.validateEditShippingAddress')}}";
        var form = $("#form_editShippingAddress");
        var tipo  = 'editShippingAddress';
        var step = 'step1';
        var nextStep = 'step2';

        validateFieldsPortalSA(url,form,tipo,step,nextStep);
    }

    function saveEditShippingAddress(dataForm, folioEdit){
        $.ajax({
            type: "POST",
            url: "{{ route("checkout.shippingAddress.editShippingAddress") }}",
            data: dataForm,
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            statusCode: { 419: function() { window.location.href = URL_PROJECT; }},
            success: function (result){
                if(result.status){
                    reloadShippingAddress(1,0, folioEdit);
                    $("#addressEdit").removeClass("active");
                    $(".overlay").css("display",'none');
                    /*$("#addressSuccess").find(".modal__title").empty().append(result.data.title_message);
                    $("#addressSuccess").find(".modal__body").empty().append("<p>"+result.data.message_modal+"</p>");
                    $("#addressSuccess").addClass("active");*/
                    $("#success_step1").show();
                    $("#success__boxSA_ul_step1").html("");
                    $("#success__boxSA_ul_step1").append("<li class='text-success'>"+result.data.message_modal+"</li>");
                    document.getElementById("form_editShippingAddress").reset();

                }else{
                    reloadShippingAddress(0,0, folioEdit);
                    //$("#addressEdit").removeClass("active");
                    $(".overlay").css("display",'none');
                    $("#error_step1_modal_edit").show();
                    $("#error__boxSA_ul_step1_modal_edit").html("");
                    $.each(result.data.messages, function (i, item) {
                        $("#error__boxSA_ul_step1_modal_edit").append("<li class='text-danger'>"+item+"</li>");
                    });

                    if (result.data.details != '') {
                        $("#error__boxSA_ul_step1_modal_edit")
                            .append('<br><div align="left"><a href="#" class="detail-err-open" style="text-align: right;font-size: 12px;color: #F44336;text-decoration: underline;">{{trans('cms::errors.modal.more')}}</a></div>');
                        setErrors(result.data.details);
                    }

                    $(".overlay").css("display",'block');
                }
            },
            error:function(result){

            },
            beforeSend: function () {
                $("#error__boxSA_ul_step1_modal_edit").html("");
                $("#error_step1_modal_edit").hide();
            },
            complete: function () {

            }
        });
    }

    /*Funcion para recargar las direcciones despues de una editar alguna direccion*/
    function reloadShippingAddress(getFromWS, start, folioEdit){
        var url = URL_PROJECT+'/shopping/checkout/getShippingAddress/'+getFromWS;
        var defaultShippmentAddress = false;
        $.ajax({
            url: url,
            type: 'GET',
            success: function (data) {
                console.log(data);
                if (data.success || data.listShipmentAddress !== ""){

                    var listShipmentAddress = $('.listShipmentAddress');
                    listShipmentAddress.empty();
                    $.each(data.listShipmentAddress, function( index, value ) {
                        var newShipmentAddress = '';

                        if(folioEdit){
                            defaultShippmentAddress = folioEdit;
                        } else {
                            defaultShippmentAddress = data.defaultShippmentAddress;
                        }

                        if(value.correct){
                            newShipmentAddress += '<div class="form-radio card stack">' ;
                            if(getFromWS === 1 && value.folio == defaultShippmentAddress){
                                newShipmentAddress += '<input type="radio" id="address'+value.folio+'" class="btnAddressChecked" name="address" value="'+ value.folio+'" checked="checked">';
                            } else {
                                newShipmentAddress += '<input type="radio" id="address'+value.folio+'" class="btnAddressChecked" name="address" value="'+ value.folio+'">';
                            }
                            newShipmentAddress += '<label class="card__content-wrap" for="address'+value.folio+'">';
                        } else {
                            if(value.folio === defaultShippmentAddress){
                                defaultShippmentAddress = false;
                            }
                            newShipmentAddress += '<div class="form-radio error__box card stack">'+
                                '<span class="error__single">' +
                                '@lang('shopping::shippingAddress.msg_address_error')' +
                                '</span>';
                        }

                        newShipmentAddress += '<div class="card__content">'+
                            '<input type="hidden" class="valueFolio" name="folio" value="'+ value.folio+'">'+
                            '<a class="ezone__info-edit checkout edit_sa_modal" href="#">';
                        if(value.permissions.canEdit) {
                            newShipmentAddress += '<figure class="icon icon-edit">' +
                                '<span class="icon-edit__text">{{trans("shopping::shippingAddress.edit")}}</span>' +
                                '<img src="{{ asset('themes/omnilife2018/images/icons/edit.svg') }}" alt="OMNILIFE - {{trans("shopping::shippingAddress.edit")}}">' +
                                '</figure>' +
                                '</a>';
                        }
                        if(value.type === "ALTERNA" && value.permissions.canDelete) {
                            newShipmentAddress += '<a href="#" class="ezone__info-delete checkout delete_sa_modal">' +
                                '<figure class="icon icon-delete">' +
                                '<span class="icon-edit__text">{{trans("shopping::shippingAddress.delete")}}</span>' +
                                '<img src="{{ asset('themes/omnilife2018/images/icons/bin.svg') }}" alt="OMNILIFE - {{trans("shopping::shippingAddress.delete")}}">' +
                                '</figure>' +
                                '</a>';
                        }
                        newShipmentAddress += '<label class="radio-fake" for="address'+value.folio+'"></label>'+value.labelSA+
                            //'<span class="radio-label">'+value.Etiqueta+'<span class="small">'+value.Direccion+', '+ value.Colonia+', '+ value.Ciudad +' '+ value.Estado+'</span>'+
                            '</span>'+
                            '</div>'+
                            '</label>'+
                            '</div>';
                        listShipmentAddress.append(newShipmentAddress);
                    });

                    $(".loader").removeClass("show");
                    $(".overlay").css("display",'none');
                }

                if (!data.success){
                    $('div#error_step1').css('display','inline-block');
                    if(start !== 1){
                        $("ul#error__boxSA_ul_step1").html("");
                    }

                    $.each(data.error, function( index, value ) {
                        $('ul#error__boxSA_ul_step1').append("<li>"+value+"</li>");
                    });

                    $(".loader").removeClass("show");
                    $(".overlay").css("display",'none');
                }
            },
            beforeSend: function () {
                $(".loader").addClass("show");
            },complete: function () {
//                $(".loader").removeClass("show");

                    //return defaultShippmentAddress;
                    setTimeout(
                        function() {
                            if(getFromWS === 1 && defaultShippmentAddress !== false){
                                $(".loader").addClass("show");
                                selectShippingAddress(defaultShippmentAddress);
                            } else {
                                $("#buttonToStep2").css('display','none');
                                $("#cart-resume").html("");

                                /*$("#alertShippingAddress").find('.modal__head h2').html("").append(modal_alerts.title_no_match_zip_listAddress);
                                $("#alertShippingAddress").addClass('active').find('.modal__body p').html("").append(modal_alerts.no_match_zip_listAddress);*/
                                $(".loader").removeClass("show");
                                $(".overlay").css("display",'block');
                            }
                        }, 1000);
                },
            error: function (jqXHR, timeout, message) {
                $(".loader").removeClass("show");
                var contentType = jqXHR.getResponseHeader("Content-Type");
                if (jqXHR.status === 200 && contentType.toLowerCase().indexOf("text/html") >= 0) {
                    window.location.reload();
                }
            }
        });
    }

    $(document).on('keyup','#edit_address',function(){
        var street = $(this).val();
        $.ajax({
            type: "POST",
            url: "{{ route('register.validatestreet') }}",
            data: {'street':street, _token: '{{csrf_token()}}'},
            statusCode: { 419: function() { window.location.href = URL_PROJECT; }},
            success: function (result){

                if(result.passes){
                    $("#btnEditShippingAddress").attr('disabled',false);
                    $("#div_message_edit_address").html('');
                    $("#div_message_edit_address").html(result.message).css('color','black');
                }else{
                    $("#btnEditShippingAddress").attr('disabled',true);
                    $("#div_message_edit_address").html('');
                    $("#div_message_edit_address").html(result.message).css('color','red');
                }

            },
            error:function(result){

            },
            beforeSend: function () {

            },
            complete: function () {
            }
        });
    });

</script>