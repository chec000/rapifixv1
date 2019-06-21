function validateFieldsPortal(url,form,tipo,step,nextStep) {
    cleanMessagesValidateFieldsPortal(step);

    $.ajax({
        url: url,
        type: 'POST',
        dataType: 'JSON',
        data: form.serialize(),
        statusCode: {
            419: function() {
                window.location.href = URL_PROJECT;
            }
        },
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        success: function (data) {
            if (data.success == true) {
                if (tipo == 'customer') {
                    if (step == 'step1') {
                        /* Tab Activa */
                        $('#tab__' + step).removeClass('active');
                        $('#' + step).removeClass('active');
                        $('#tab__' + nextStep).addClass('active');
                        $('#' + nextStep).addClass('active');
                    }
                    else if (step == 'step2') {
                        validateCustomer(form.serialize());
                    }
                    else if (step == 'step3') {
                        generateTransaction();
                    }
                }
                if(tipo == 'register'){
                    var country = $("#country").val();
                    if (step == 'step1') {

                        $('#tab__' + step).removeClass('active');
                        $('#' + step).removeClass('active');
                        $('#tab__' + nextStep).addClass('active');
                        $('#' + nextStep).addClass('active');
                        $('.tabs-static__item_' + step).removeClass('active');
                        $('.tabs-static__item_' + nextStep).addClass('active');
                        if($("#isback").val() == 0){
                            getStates(country);
                        }



                    }else if( step == "step2"){

                        validateFormCorbiz();


                    }else if(step == "step3"){


                    }
                    else{

                    }
                }
            }
            if (data.success == false) {
                $.each(data.message, function (key, message) {
                    if (key.substr(0,7) == 'id_type') {
                        addErrorMsgValidateFieldsPortal(key.replace('.', ''), message);
                    }
                    else if (key.substr(0,6) == 'id_num') {
                        addErrorMsgValidateFieldsPortal(key.replace('.', ''), message);
                    }
                    else if (key.substr(0,13) == 'id_expiration') {
                        addErrorMsgValidateFieldsPortal(key.replace('.', ''), message);
                    }
                    else if (key == 'error__box_' + step) {
                        $('#error__box_' + step).show();
                        $('#error__box_ul_' + step).html('<li>' + message + '</li>');
                    }
                    else {
                        addErrorMsgValidateFieldsPortal(key, message);
                    }
                });
            }
        },
        beforeSend: function () {
            $('#error__box_' + step).hide();
            $('#error__box_ul_' + step).html('');
            $('.loader').removeClass('hide').addClass('show');
        },
        complete: function() {
            $('.loader').removeClass('show').addClass('hide');
            window.location.href = "#tabs_register";
        }
    });
}

function backStepPortal(step,prev) {
    $('#tab__' + step).removeClass('active');
    $('#' + step).removeClass('active');
    $('#tab__' + prev).addClass('active');
    $('#' + prev).addClass('active');
    $('.tabs-static__item_' + step).removeClass('active');
    $('.tabs-static__item_' + prev).addClass('active');

}

function addErrorMsgValidateFieldsPortal(key, message) {
    $('#' + key).addClass('has-error');
    $('#div_' + key).html(message);
}

function cleanMessagesValidateFieldsPortal(step) {
    $('#error__box_' + step).hide();
    $('#error__box_ul_' + step).html('');
    $('.has-error').removeClass('has-error');
    $('.error-msg').html('');
}

function validateFieldAutocomplete(url,urlcities,field,chars,paramName,token,validate,check,tipo) {
    $('#' + field).autocomplete({
        minChars: chars,
        serviceUrl: url,
        type: 'POST',
        dataType: 'JSON',
        paramName: paramName,
        params: { _token: token},
        onSelect: function(suggestion) {
            $('#zip').val(suggestion.data.zipcode);
            citybystate(suggestion.data.idState,suggestion.data.idCity,suggestion.data.cityDescr,urlcities,token,validate,tipo);
            $('#state').val(suggestion.data.idState);
            $('#state_hidden').val(suggestion.data.idState);
            if (check == 'county') {
                $('#colony').val(suggestion.data.county);
            }
            else if (check == 'suburb') {
                $('#colony').val(suggestion.data.suburb);
            }

            $('#city_hidden').val(suggestion.data.idCity);

            $('#state').attr('disabled', true);
            $('#city').attr('disabled', true);
            $('#colony').attr('readonly', true);
        },
        onSearchComplete: function(query, suggestions) {
            if (typeof(suggestions) == "undefined" || suggestions === null) {
                // arr is empty
                $('#state').removeAttr('disabled');
                $('#city').removeAttr('disabled');
                $('#colony').removeAttr('readonly');
                $('#colony').val('');
                $('#state').val('');
                $('#city').val('');
            }
        },
    });
}

function citybystate(stateSelected,citySelected,cityName,urlcities,token,validate,tipo) {
    var htmlCities = '';

    $.ajax({
        type: 'POST',
        url: urlcities,
        data: {'state': stateSelected, _token: token},
        statusCode: { 419: function() { window.location.href = URL_PROJECT; }},
        success: function(result) {
            if(result.status) {
                if (tipo == 'register') {
                    $('#error__box_ul_step2').html('');
                    $('#error_step2').hide();
                }
                else if (tipo == 'register_customer') {
                    $('#error__box_ul_step1').html('');
                    $('#error__box_step1').hide();
                }

                $('#city').removeClass('has-error');

                $.each(result.data, function (i, item) {
                    var validator = item.id;
                    var atrSelected = citySelected != '' && citySelected == $.trim(validator) ? 'selected' : '';
                    htmlCities += '<option value="' + $.trim(item.id) + '" ' + atrSelected + ' >' + $.trim(item.name) + '</option>';
                });

                $('#city').html(htmlCities);
                $('#city_name').val(cityName);

                if (tipo == 'register_customer') {
                    getShippingCompanyFromCorbiz(stateSelected,citySelected);
                }
            }
            else {
                if (tipo == 'register') {
                    $("#error_step1").show();
                    $("#error__box_ul_step2").html("");
                    $("#city").addClass("has-error");

                    $.each(result.messages, function (i, item) {
                        $("#error__box_ul_step2").append("<li class='text-danger'>" + item + "</li>");
                    });
                }
                else if (tipo == 'register_customer') {
                    $('#error__box_step1').show();
                    $('#error__box_ul_step1').html('');
                    $("#city").addClass("has-error");

                    $.each(result.messages, function (i, item) {
                        $("#error__box_ul_step1").append("<li class='text-danger'>" + item + "</li>");
                    });
                }
            }
        },
        error:function(result) {
        },
        beforeSend: function() {
            if (tipo == 'register') {
                $("#error__box_ul_step2").html("");
                $("#error_step2").hide();
            }
            else if (tipo == 'register_customer') {
                $('#error__box_ul_step1').html('');
                $('#error__box_step1').hide();
            }

            $("#city").children('option:not(:first)').remove();
        },
        complete: function() {
        }
    });
}

function PrintElem(elem)
{

    var mywindow = window.open('', 'PRINT', 'height=500,width=800');

    mywindow.document.write('<html><head><title>' + document.title  + '</title>');
    mywindow.document.write('</head><body >');
    mywindow.document.write('<h1>' + document.title  + '</h1>');
    mywindow.document.write(document.getElementById(elem).innerHTML);
    mywindow.document.write('</body></html>');

    mywindow.document.close(); // necessary for IE >= 10
    mywindow.focus(); // necessary for IE >= 10*/

    mywindow.print();
    mywindow.close();

    return true;
}

function printDoc(elem){
    var contents = document.getElementById(elem).innerHTML;
    var frame1 = document.createElement('iframe');
    frame1.name = "frame1";
    frame1.style.position = "absolute";
    frame1.style.top = "-1000000px";
    document.body.appendChild(frame1);
    var frameDoc = frame1.contentWindow ? frame1.contentWindow : frame1.contentDocument.document ? frame1.contentDocument.document : frame1.contentDocument;
    frameDoc.document.open();
    frameDoc.document.write('<html><head><title>DIV Contents</title>');
    frameDoc.document.write('</head><body>');
    frameDoc.document.write(contents);
    frameDoc.document.write('</body></html>');
    frameDoc.document.close();
    setTimeout(function () {
        window.frames["frame1"].focus();
        window.frames["frame1"].print();
        document.body.removeChild(frame1);
    }, 500);
    return false;
}

/* * * Funciones para Modal de Registro Inconcluso * * */
function modalUnfinishedRegister(url, dataForm) {
    $.ajax({
        url: url,
        type: 'POST',
        dataType: 'JSON',
        data: dataForm,
        statusCode: {
            419: function() {
                window.location.href = URL_PROJECT;
            }
        },
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        success: function(data) {
            if (data.success) {
                location.href = data.message;
            }
        },
        beforeSend: function() {
            $('.loader').removeClass('hide').addClass('show');
        },
        complete: function() {
            $('.loader').removeClass('show').addClass('hide');
        }
    });
}

/*Funcion para invocar el valida form*/