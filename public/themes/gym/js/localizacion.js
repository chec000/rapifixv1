var x = document.getElementById("demo");
var saveWHSession = 0;
var labelLanguageDefault = $('#labelLanguageDefault').val();
var labelStateDefault = $('#labelStateDefault').val();
var labelCityDefault = $('#labelCityDefault').val();
var labelFieldRequired = $('#labelFieldRequired').val();
var labelZipRequired = $('#labelZipRequired').val();
var useGeolocalization = 0;

function getLocation() {
    if (location.protocol === 'https:') {
        if (navigator.geolocation && (changeCountryId === "0" && changeLanguageId === "0")) {
            navigator.geolocation.getCurrentPosition(showPosition, showError);
        }
    }
}


function showPosition(position) {
    saveWHSession = 1;
     showPanel();
    var form = $("#form_country");
    var option;
    var country_id;
    useGeolocalization = 1;
    var url = form.attr('action') + '/' + position.coords.latitude + '/' + position.coords.longitude;
    $.ajax({
        url: url,
        type: 'GET',
        success: function (data) {
              console.log(data);
            if (data.code === 200) {
                option = $("#country-" + data.data.id);
                country_id = data.data.id;
                   option.prop("selected", true);
            getLanguages(country_id);
                hidePanel();
            } else if (data.code === 300) {
                option = $("#country-" + data.data);
                country_id = data.data;
              option.prop("selected", true);
                getLanguages(country_id);
                hidePanel();
            }else{
                 hidePanel();
            }

        },
        error: function (jqXHR, timeout, message) {
            var contentType = jqXHR.getResponseHeader("Content-Type");
            if (jqXHR.status === 200 && contentType.toLowerCase().indexOf("text/html") >= 0) {
                window.location.reload();
            }
        }
    });

}

$("#countries_select").change(function (e) {
    getLanguages(this.value);

});
$("#languages_select").change(function () {
    setLanguage(this.value);
});

$("#states_select").change(function () {
    getCities(this.value);
});
$("#cities_select").change(function () {
    //$("#btn_go").removeAttr("disabled");
});

$("#btn_go").click(function () {
    validationsGoFunction();
    //goFunction();
});

$("#postalCode").keyup(function () {
    /*if($(this).val().length > 4){
        $("#btn_go").removeAttr('disabled');
    }else{
        $("#btn_go").attr('disabled');
    }*/
});


function getLanguages(country_id) {
    console.log(saveWHSession);
    var form = $("#form_languages");
    var url = form.attr('action') + '/' + country_id + '/' + saveWHSession;

    var selectState = $('#states_select');
    selectState.css('display', 'none');
    $("#div_states_select").css('display', 'none');
    selectState.empty();

    var selectCity = $('#cities_select');
    selectCity.css('display', 'none');
    $("#div_cities_select").css('display', 'none');
    selectCity.empty();

    var postalCode = $('#postalCode');
    postalCode.css('display', 'none');
    $("#div_postal_code").css('display', 'none');
    postalCode.val('');

    var idLangDefault = "";
    var default_locale = "";

    $.ajax({
        url: url,
        type: 'GET',
        success: function (data) {
            console.log(data);
            shopping_active = data.shopping_active;
            var select = $('#languages_select');
            if (data.code === 200) {
                if(useGeolocalization === 1){
                    $(location).attr('href', APP_URL);
                }
                $("#div_languages_select").css('display', 'inline-block');
                select.css('display', 'inline-block');
                select.empty();
                if (data.data.length > 1) {
                    //$("#btn_go").attr("disabled", 'disabled');
                    //select.append("<option >"+labelLanguageDefault+"</option>");
                    $.each(data.data, function (k, v) {
                        if (v.locale_key === data.country.default_locale) {

                            select.append("<option selected value=" + v.id + ">" + v.language + "</option>");
                            idLangDefault = v.id;

                            if(!data.useZipCodeOrCity){
                                //$("#btn_go").removeAttr("disabled");
                            } else if(data.useZipCodeOrCity.code === 500) {
                                $('div.error__box > ul').empty();
                                $('div.error__box > ul').append("<li>"+data.useZipCodeOrCity.data.messUser+"</li>");
                                $('div.error__box').css('display','inline-block');
                            }
                        } else {
                            select.append("<option value=" + v.id + ">" + v.language + "</option>");
                        }
                    });
                    $("#btn_go").removeAttr("data-type");

                    default_locale = data.country.default_locale;
                }
            } else {
                select.css('display', 'none');
                $("#div_languages_select").css('display', 'none');
                if(data.useZipCodeOrCity) {
                    if(data.useZipCodeOrCity.code == 200) {
                        switch (data.useZipCodeOrCity.type) {
                            case "ZIPCODE":
                                $("#div_postal_code").css('display', 'inline-block');
                                $("#postalCode").css('display', 'inline-block');
                                $("#btn_go").attr("data-type", 'ZIPCODE');
                                //$("#btn_go").attr("disabled", 'disabled');
                                if(useGeolocalization === 1){
                                    $(location).attr('href', APP_URL);
                                }
                                break;
                            case "CITY":
                                //var selectState = $('#states_select');
                                $("#div_states_select").css('display', 'inline-block');
                                selectState.css('display', 'inline-block');
                                selectState.empty();
                                selectState.append("<option value='' selected>" + labelStateDefault + "</option>");
                                $.each(data.useZipCodeOrCity.arrayStates, function (k, v) {
                                    selectState.append("<option value=" + v.idState + ">" + v.stateDescr + "</option>");
                                });
                                $("#btn_go").attr("data-type", 'CITY');
                                //$("#btn_go").attr("disabled", 'disabled');
                                break;
                            case "COUNTRY":
                                $(location).attr('href', APP_URL);
                        }
                    } else if(data.useZipCodeOrCity.code === 500){
                        $('div.error__box > ul').empty();
                        $('div.error__box > ul').append("<li>"+data.useZipCodeOrCity.data.messUser+"</li>");
                        $('div.error__box').css('display','inline-block');
                            switch (data.useZipCodeOrCity.type) {
                                case "ZIPCODE":
                                    $("#div_postal_code").css('display', 'inline-block');
                                    $("#postalCode").css('display', 'inline-block');
                                    $("#btn_go").attr("data-type", 'ZIPCODE');
                                    //$("#btn_go").attr("disabled", 'disabled');
                                    break;
                            }
                    }
                    default_locale = data.country.default_locale;
                } else {
                    $(location).attr('href', APP_URL);
                }
            }
        },
        error: function (jqXHR, timeout, message) {
            var contentType = jqXHR.getResponseHeader("Content-Type");
            if (jqXHR.status === 200 && contentType.toLowerCase().indexOf("text/html") >= 0) {
                window.location.reload();
            }
        }
    }).then(function(){
        if(default_locale !== app_locale) {
            location.reload(true);
        } else {
            if(idLangDefault !== ""){
                setLanguage(idLangDefault);
            }
        }
    });


}


function setLanguage(id_language){
    var form = $("#form_save_language");
    var url = form.attr('action') + '/' + id_language;

    var postalCode = $('#postalCode');
    /*postalCode.css('display', 'none');
    $("#div_postal_code").css('display', 'none');
    postalCode.val('');*/

    var selectState = $('#states_select');
    /*selectState.css('display', 'none');
    $("#div_states_select").css('display', 'none');
    selectState.empty();*/

    var selectCity = $('#cities_select');
    /*selectCity.css('display', 'none');
    $("#div_cities_select").css('display', 'none');
    selectCity.empty();*/
    $.ajax({
        url: url,
        type: 'GET',
        success: function (data) {
              console.log(data);
            /*if (data.code === 200) {
             console.log(data);
            }*/

            if(data.useZipCodeOrCity) {
                if(data.useZipCodeOrCity.code === 200) {
                    switch (data.useZipCodeOrCity.type) {
                        case "ZIPCODE":

                            selectState.css('display', 'none');
                            $("#div_states_select").css('display', 'none');
                            selectState.empty();

                            selectCity.css('display', 'none');
                            $("#div_cities_select").css('display', 'none');
                            selectCity.empty();

                            $("#div_postal_code").css('display', 'inline-block');
                            $("#postalCode").css('display', 'inline-block');
                            $("#btn_go").attr("data-type", 'ZIPCODE');
                            //$("#btn_go").attr("disabled", 'disabled');

                            break;
                        case "CITY":

                            postalCode.css('display', 'none');
                            $("#div_postal_code").css('display', 'none');
                            postalCode.val('');

                            //var selectState = $('#states_select');
                            $("#div_states_select").css('display', 'inline-block');
                            selectState.css('display', 'inline-block');
                            selectState.empty();
                            selectState.append("<option value='' selected>" + labelStateDefault + "</option>");
                            $.each(data.useZipCodeOrCity.arrayStates, function (k, v) {
                                selectState.append("<option value=" + v.idState + ">" + v.stateDescr + "</option>");
                            });
                            $("#btn_go").attr("data-type", 'CITY');
                            //$("#btn_go").attr("disabled", 'disabled');
                            break;
                        case "COUNTRY":
                            $(location).attr('href', APP_URL);
                            //$("#btn_go").trigger("click");
                    }
                } else if(data.useZipCodeOrCity.code === 500) {
                    $('div.error__box > ul').empty();
                    $('div.error__box > ul').append("<li>"+data.useZipCodeOrCity.data.messUser+"</li>");
                    $('div.error__box').css('display','inline-block');

                }
            } else {
                $("#btn_go").attr("data-type", 'COUNTRY');
                //$("#btn_go").removeAttr("disabled");
            }
        },
        error: function (jqXHR, timeout, message) {
            var contentType = jqXHR.getResponseHeader("Content-Type");
            if (jqXHR.status === 200 && contentType.toLowerCase().indexOf("text/html") >= 0) {
                window.location.reload();
            }
        }
    });
}


function getCities(id_state){
    var url = 'getCitiesWs/' + id_state;

    var selectCity = $('#cities_select');
    selectCity.css('display', 'none');
    $("#div_cities_select").css('display', 'none');
    selectCity.empty();
    $.ajax({
        url: url,
        type: 'GET',
        success: function (data) {
            console.log(data);
            if (data.code === 200) {

                //var selectState = $('#states_select');
                $("#div_cities_select").css('display', 'inline-block');
                selectCity.css('display', 'inline-block');
                selectCity.empty();
                selectCity.append("<option value='' selected>"+ labelCityDefault +"</option>");
                $.each(data.arrayCities, function (k, v) {
                    selectCity.append("<option value=" + v.idCity + ">" + v.cityDescr + "</option>");
                });
            } else if(data.code === 500) {
                $('div.error__box > ul').empty();
                $('div.error__box > ul').append("<li>"+data.data.messUser+"</li>");
                $('div.error__box').css('display','inline-block');
                //alert('Ocurrio un error durante WS WareHouse');
            }
        },
        error: function (jqXHR, timeout, message) {
            var contentType = jqXHR.getResponseHeader("Content-Type");
            if (jqXHR.status === 200 && contentType.toLowerCase().indexOf("text/html") >= 0) {
                window.location.reload();
            }
        }
    });
}

function validationsGoFunction() {
    var result = true;

    $(".validate_go:visible").each(function (index) {
        if($(this).hasClass('validate_zip')) {
            if ($(this).val().length < 5) {
                $(this).addClass('has-error');
                $(this).css('border','1px !important');
                $(this).closest('div').find(".div_answer").empty();
                $(this).closest('div').find(".div_answer").append("<span>"+labelZipRequired+"</span>");
                result = false;
            } else {
                $(this).removeClass('has-error');
                $(this).css('border','0');
                $(this).closest('div').find(".div_answer").empty();
            }
        } else {
            if ($(this).val() === null || $(this).val() === "") {
                $(this).addClass('has-error');
                $(this).css('border','1px !important');
                $(this).closest('div').find(".div_answer").empty();
                $(this).closest('div').find(".div_answer").append("<span>"+labelFieldRequired+"</span>");
                result = false;
            } else {
                $(this).removeClass('has-error');
                $(this).css('border','0');
                $(this).closest('div').find(".div_answer").empty();
            }
        }

    });

    if (result) {
        goFunction();
    }
}
function goFunction(){

    /*alert('Entro a Botón Go');
    return 1;*/
    if(frontend_webservices == 0 || shopping_active == 0){
        $(location).attr('href', APP_URL);
    } else {
        $('div.error__box').css('display','none');
        var url =  APP_URL+'/setVariablesStartWH';

        var selectedCity = $('#cities_select').val();
        var postalCode = $('#postalCode').val() == null ? 0 : $('#postalCode').val();
        var type = $('#btn_go').data('type');

        $.ajax({
            url: url,
            type: 'POST',
            dataType: 'json',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: {type:type, city:selectedCity, zipcode:postalCode},
            success: function (data) {
                console.log(data);
                if (data.code === 200) {
                    $(location).attr('href', APP_URL);
                } else if(data.code === 500) {
                    $('div.error__box > ul').empty();
                    $('div.error__box > ul').append("<li>"+data.data.messUser+"</li>");
                    $('div.error__box').css('display','inline-block');
                }
            },
            error: function () {
                $('div.error__box').css('display','inline-block');
                //alert('Ocurrio un error durante peticion AJAX');
            }

        });
    }
}


function showError(error) {
    switch (error.code) {
        case error.PERMISSION_DENIED:
            //existSessionValiables();
            break;
        case error.POSITION_UNAVAILABLE:
        existSessionValiables();
           console.log(error);
            break;
        case error.TIMEOUT:
            existSessionValiables();
            console.log(error);
            break;
        case error.UNKNOWN_ERROR:
           existSessionValiables();
            console.log(error);
            break;
    }
}

$(window).load(function () {
    getLocation();

});

var map;

function initMap() {
    map = new google.maps.Map(document.getElementById('map'), {
        center: {lat: -34.397, lng: 150.644},
        zoom: 8
    });
}

function showPanel() {
    var loader = $('.loader');
    loader.addClass('show');
}
function hidePanel() {
    var loader = $('.loader');
    loader.removeClass('show');
}


function existSessionValiables(){
    $.ajax({
        url: APP_URL+'/'+'existSession',
        type: 'GET',
        success: function (data) {
            var value=$.trim(data);
            console.log(value);
            if (value=== "1") {
             $(location).attr('href', APP_URL);
            }else{
                return false;
            }
        },
        error: function (jqXHR, timeout, message) {
            var contentType = jqXHR.getResponseHeader("Content-Type");
            if (jqXHR.status === 200 && contentType.toLowerCase().indexOf("text/html") >= 0) {
                window.location.reload();
            }
        }
    });
}
