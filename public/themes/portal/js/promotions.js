function getViewModalPromotions(process){
    var url = 'checkout/quotation/getViewModalPromotions/'+process;
    $.ajax({
        url: url,
        type: 'GET',
        success: function (result) {
            //
            //console.log(result);
            if (result) {
                $('div#promo').replaceWith(result);
                $(".overlay").css("display",'block');
            } else {
                alert('No se cargo modal de promociones')
            }
        },
        complete: function () {
            $("div#promo").addClass('active');
            //$(".overlay").css("display",'block');
        },
        error: function() {
            $(".loader").removeClass("show");
            $(".overlay").css("display",'none');
        }
    });
}

function showHidePromo(idPromo){
    console.log(idPromo);
    var valCollapse = $('.modal__body').find('div#collapsePromo'+idPromo).is(":visible");
    if(valCollapse){
        $('.modal__body').find('div#collapsePromo'+idPromo).fadeOut();
        $('.modal__body').find('a#btnCollapsePromo'+idPromo).addClass('collapsed');
    } else {
        $('.modal__body').find('div#collapsePromo'+idPromo).fadeIn();
        $('.modal__body').find('a#btnCollapsePromo'+idPromo).removeClass('collapsed');
    }
}

function minusPromo(idPromo, idLine) {
    var collapsePromo = $('div#collapsePromo'+idPromo);
    var input = collapsePromo.find("div#promoLine"+idLine).find(".numeric").find('input');
    var required = collapsePromo.find('input.promoRequired').val();

    if (parseInt(input.val()) > 0){
        /*if(parseInt(input.val()) === 1 && parseInt(required) === 1){
            alert("Esta promoción es obligatoria, la cantidad no puede ser menor a 1");
        } else {*/
        input.val(parseInt(input.val()) > 0 ? parseInt(input.val()) - 1 : 0);
        //}

    }

    $('div#collapsePromo'+idPromo).find("div#promoLine"+idLine).find(".numeric").find('input').val(parseInt(input.val()));

    /*ShoppingCart.remove_one(id);
    if (parseInt(input.val()) === 0) {
        ShoppingCart.remove_item(id);
    }*/
}

function plusPromo(idPromo, idLine) {
    var collapsePromo = $('div#collapsePromo'+idPromo);
    var input = collapsePromo.find("div#promoLine"+idLine).find(".numeric").find('input');
    var maxQuantity = collapsePromo.find('input.maxQuantity').val();

    if (parseInt(input.val()) < parseInt(maxQuantity)) {
        input.val(parseInt(input.val()) + 1);
    }
    $('div#collapsePromo'+idPromo).find("div#promoLine"+idLine).find(".numeric").find('input').val(parseInt(input.val()));
}

function minusPromoC(idPromo, idLine, sku) {
    var collapsePromo = $('div#collapsePromo'+idPromo);
    var input = collapsePromo.find("div#promoLine"+idLine+"-"+sku).find(".numeric").find('input');
    var required = collapsePromo.find('input.promoRequired').val();

    if (parseInt(input.val()) > 0){
        input.val(parseInt(input.val()) > 0 ? parseInt(input.val()) - 1 : 0);
    }

    $('div#collapsePromo'+idPromo).find("div#promoLine"+idLine+"-"+sku).find(".numeric").find('input').val(parseInt(input.val()));

    /*ShoppingCart.remove_one(id);
    if (parseInt(input.val()) === 0) {
        ShoppingCart.remove_item(id);
    }*/
}

function plusPromoC(idPromo, idLine, sku) {
    var collapsePromo = $('div#collapsePromo'+idPromo);
    var input = collapsePromo.find("div#promoLine"+idLine+"-"+sku).find(".numeric").find('input');
    var maxQuantity = collapsePromo.find('input.maxQuantity').val();
    var totalItemsC = 0;

    $('div#collapsePromo'+idPromo).find("div.card").each(function() {
        var valueCardC = $(this).find(".numeric").find('input').val();
        totalItemsC = totalItemsC + valueCardC;
    });

    if (parseInt(totalItemsC) < parseInt(maxQuantity)) {
        input.val(parseInt(input.val()) + 1);
    }
    $('div#collapsePromo'+idPromo).find("div#promoLine"+idLine+"-"+sku).find(".numeric").find('input').val(parseInt(input.val()));
}

$(document).on('click','#btnValidatePromos',function () {
    var process = $(this).closest(".modal-promos").find("input.process").val();
    validatePromos(process);
});

function validatePromos(process) {
    var url = "checkout/quotation/validateQuantityPromos";
    var form = $("#form_quantityPromotions");

    validateQuantityPromos(url,form, process);
}

function validateQuantityPromos(url,form, process) {

    $.ajax({
        url: url,
        type: 'POST',
        dataType: 'JSON',
        data: form.serialize(),
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        success: function (data) {
            if (data.success == true) {
                $("div#promo").removeClass('active');
                getInitQuotationPromos(process);
            }
            else if (data.success == false) {
                $.each(data.messages, function(key, message) {
                    addErrorMsgValidatePromos(key, message);
                    $('.modal__body').find('div#collapsePromo'+key).fadeIn();
                    $('.modal__body').find('a#btnCollapsePromo'+key).removeClass('collapsed');
                });
            }
        },beforeSend: function (){
            cleanMessagesvalidatePromos();
            $(".loader").addClass("show");
        },
        complete: function () {
            $(".loader").removeClass("show");
            $(".overlay").css("display",'none');
        },
        error: function() {
            $(".loader").removeClass("show");
            $(".overlay").css("display",'none');
        }
    });
}

function checkSelectPromo(checkPromo,idPromo,idLine) {
    var qtyCards = $("div#collapsePromo"+idPromo).find("div.card").length;
    console.log(checkPromo, qtyCards);
    var current_id = checkPromo.id;

    var current_val = parseInt($("#"+current_id).closest("div.card").find(".numeric").find("input").val());


    if(qtyCards === 1) {
        $(checkPromo).toggleClass('hasChecked');
        if ($(checkPromo).hasClass('hasChecked')) {
            $(checkPromo).prop("checked", true);
        } else {
            $(checkPromo).prop("checked", false);
        }

    } else {
        var haschecked = $(checkPromo).hasClass('hasChecked');

        $('div#collapsePromo'+idPromo).find("div.card").each(function() {
            $(this).find(".numeric").find('input').val(0);
            $(this).find("input[id^='selectPromo']").removeClass('hasChecked');
            $(this).find("input[id^='selectPromo']").prop("checked", false);
        });


        if (haschecked) {
            $("#"+current_id).prop("checked", false);
        } else {
            $("#"+current_id).toggleClass('hasChecked');
            $("#"+current_id).prop("checked", true);
        }

        /*$('div#collapsePromo'+idPromo).find("div.card").each(function() {
            $(this).find(".numeric").find('input').val(0);
        });*/

        if($("#"+current_id).hasClass("hasChecked")) {
            $("#"+current_id).closest("div.card").find(".numeric").find("input").val(current_val);
        }
        //$('div#collapsePromo'+idPromo).find(".numeric").find('input#'+current_id).val(current_val > 0 ? current_val : 1);

    }
}

function addErrorMsgValidatePromos(key, message) {
    $('#collapsePromo' + key).find(".numeric").find('input').addClass('has-error');
    $('#collapsePromo' + key).find(".card__content").find("span.radio-label").addClass('has-error');
    $('#div_msg_error_' + key).html(message);
}

function cleanMessagesvalidatePromos() {
    $('.has-error').removeClass('has-error');
    $('.error-msg').html('');
}

function getInitQuotationPromos(process){

    var showPromotions = false;
    var url = 'checkout/quotation/getInitQuotationPromos/'+process;
    $.ajax({
        url: url,
        type: 'GET',
        success: function (result) {
            console.log(result);
            if (result.success) {
                $('div#error_step1').css('display','none');
                $("ul#error__boxSA_ul_step1").html("");

                if (result.existsPromotions) {
                    showPromotions = true;
                }

                getViewCartPreviewQuotation();
                $("div#change_period_step1").show();

            } else {

                $("#addressSuccess").find(".modal__title").empty().append(result.messages);
                $("#addressSuccess").find(".modal__body").empty().append("<p>"+result.messages+"</p>");
                $("#addressSuccess").addClass("active");
                $(".overlay").css("display",'block');

                $('div#error_step1').css('display','inline-block');
                $("ul#error__boxSA_ul_step1").html("");
                $('ul#error__boxSA_ul_step1').append("<li>"+result.messages+"</li>");
                $("div#change_period_step1").hide();

                $(".loader").removeClass("show");
            }
        },
        complete: function () {
            //$(".loader").removeClass("show");
            //console.log("showPromotions: "+showPromotions);
            if(showPromotions) {
                getViewModalPromotions(process);
            }
        },
        error: function() {
            $(".loader").removeClass("show");
        }
    });
}