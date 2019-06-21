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
                <div class="form-row">
                    <div class="form-group left">
                        <input class="form-control" type="text" id="edit_description" name="edit_description" placeholder="@lang('shopping::shippingAddress.fields.description.placeholder')*">
                        <div class="error-msg" id="div_edit_description"></div>
                    </div>
                </div>
                <div class="form-row">
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
                        <select class="form-control" id="edit_state" name="edit_state">
                            <option value="">@lang('shopping::shippingAddress.fields.state.label')</option>
                        </select>
                        <div class="error-msg" id="div_edit_state"></div>
                    </div>
                    <div class="form-group select medium">
                        <select class="form-control" id="edit_city" name="edit_city">
                            <option value="">@lang('shopping::shippingAddress.fields.city.label')</option>
                        </select>
                        <input type="hidden" id="edit_city_name" name="edit_city_name">
                        <div class="error-msg" id="div_edit_city"></div>
                    </div>
                    <div class="form-group medium">
                        <input class="form-control" type="text" id="edit_suburb" name="edit_suburb" placeholder="@lang('shopping::shippingAddress.fields.suburb.placeholder')">
                        <div class="error-msg" id="div_edit_suburb"></div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group left">
                        <input class="form-control" type="text" id="edit_address" name="edit_address" placeholder="@lang('shopping::shippingAddress.fields.address.placeholder') @lang('shopping::shippingAddress.fields.address.example')*">
                        <div class="error-msg" id="div_edit_address"></div>
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
        onSelect: function (suggestion) {
            console.log(suggestion);
            $("#edit_zip").val(suggestion.data.zipcode);

            citybystateSAEdit(suggestion.data.idState,suggestion.data.idCity);
            $("#edit_state").val(suggestion.data.idState);
            $("#edit_suburb").val(suggestion.data.suburb);
            $('#edit_state').attr('readonly', true);
            $('#edit_city').attr('readonly', true);

        },
        onSearchComplete: function (query, suggestions) {

            if (suggestions.length === 0) {
                // arr is empty
                $("#edit_state").removeAttr("readonly");
                $("#edit_city").removeAttr("readonly");
                $("#edit_suburb").removeAttr("readonly");
                $('#edit_suburb').val('');
                $('#edit_state').val('');
                $('#edit_city').val('');

            }
        },

    });

    function citybystateSAEdit(stateSelected,citySelected){
        var htmlCities = '';
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            url: "{{ route('checkout.shippingAddress.cities') }}",
            data: {'state':stateSelected, _token: '{{csrf_token()}}'},
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
                    $("#edit_city").trigger("change");

                }else{
                    $("#error_step1_modal_edit").show();
                    $("#error__boxSA_ul_step1_modal_edit").html("");
                    $("#edit_city").addClass("has-error");
                    $.each(result.messages, function (i, item) {
                        $("#error__boxSA_ul_step1_modal_edit").append("<li class='text-danger'>"+item+"</li>");
                    });
                }
            },
            error:function(result){

            },
            beforeSend: function () {
                $("#error__boxSA_ul_step1_modal_edit").html("");
                $("#error_step1_modal_edit").hide();
                $("#edit_city").children('option:not(:first)').remove();

            },
            complete: function () {

            }
        });

    }

    $(document).on('change','#edit_state',function () {
        var state = $(this).val();
        changeStateSAEdit(state);
    });

    function changeStateSAEdit (state){
        var country = $("#current_country").val();
        var htmlCities = '';
        return $.ajax({
            type: "POST",
            url: "{{ route('checkout.shippingAddress.cities') }}",
            data: {'country':country,'state':state, _token: '{{csrf_token()}}'},
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
            success: function (result){

                if(result.status){
                    $("#error__boxSA_ul_step1_modal_edit").html("");
                    $("#error_step1_modal_edit").hide();
                    $('#edit_shipping_company').removeClass('has-error');
                    $.each(result.data, function (i, item) {
                        htmlShippingCompanies += '<option value="'+$.trim(item.comp_env)+'">' + $.trim(item.descripcion) + '</option>';
                    });
                    $("#edit_shipping_company").append(htmlShippingCompanies);
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
        getEditShippingAddress(valueFolio);
    });

    function getEditShippingAddress(folio){

        var resultAjax = false;
        var city = 0;
        var state = 0;
        $.ajax({
            type: "POST",
            url: "{{ route('checkout.shippingAddress.getEditShipmentAddress') }}",
            data: {'Folio':folio, _token: '{{csrf_token()}}'},
            success: function (result){

                resultAjax = result.status;
                if(result.status){
                    var promise = changeStateSAEdit(result.dataShippmentAddress.stateKey).then(function(){
                        changeCitySAEdit(result.dataShippmentAddress.stateKey, result.dataShippmentAddress.cityKey).then(function(){

                            $("#edit_name").val(result.dataShippmentAddress.name);
                            $("#edit_description").val(result.dataShippmentAddress.label);
                            $("#edit_zip").val(result.dataShippmentAddress.zipcode);

                            $("#edit_state").val(result.dataShippmentAddress.stateKey);
                            $("#edit_city").val(result.dataShippmentAddress.cityKey);
                            $("#edit_city_name").val(result.dataShippmentAddress.cityName);
                            $("#edit_suburb").val(result.dataShippmentAddress.suburb);
                            $("#edit_address").val(result.dataShippmentAddress.address);
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

                    $("#error_step1_modal_edit").show();
                    $("#error__boxSA_ul_step1_modal_edit").html("");
                    $.each(result.messages, function (i, item) {
                        $("#error__boxSA_ul_step1_modal_edit").append("<li class='text-danger'>"+item+"</li>");
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

    function saveEditShippingAddress(dataForm){

        $.ajax({
            type: "POST",
            url: "{{ route("checkout.shippingAddress.editShippingAddress") }}",
            data: dataForm,
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            success: function (result){
                if(result.status){
                    getShippingAddress(1,0);
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
                    getShippingAddress(0,0);
                    //$("#addressEdit").removeClass("active");
                    $(".overlay").css("display",'none');
                    $("#error_step1_modal_edit").show();
                    $("#error__boxSA_ul_step1_modal_edit").html("");
                    $.each(result.data.messages, function (i, item) {
                        $("#error__boxSA_ul_step1_modal_edit").append("<li class='text-danger'>"+item+"</li>");
                    });

                    /*var msgs_error = "";
                    $.each(result.data.messages, function (i, item) {
                        msgs_error = "<li class='text-danger'>"+item+"</li>";
                    });

                    $("#addressSuccess").find(".modal__title").empty().append(result.data.title_message);
                    $("#addressSuccess").find(".modal__body").empty().append("<p>"+result.data.message_modal+"</p>");
                    if(msgs_error !== ""){
                        $("#addressSuccess").find(".modal__body").empty().append("<ul>"+msgs_error+"</ul>");
                    }
                    $("#addressSuccess").addClass("active");*/
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

</script>