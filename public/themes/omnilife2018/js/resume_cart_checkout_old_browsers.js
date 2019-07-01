'use strict';

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

/**
 * Created by PhpStorm.
 * User: Vicente Gutiérrez <vicente.gutierrez@omnilife.com>
 * Date: 11/07/18
 * Time: 11:07
 */
var ResumeCart = function () {
    function ResumeCart() {
        _classCallCheck(this, ResumeCart);
    }

    _createClass(ResumeCart, null, [

        /**
         * remove_all_from_item
         * Elimina completamente un producto del carrito (sesión)
         *
         * @param id        ID del producto
         */

    {
        key: 'remove_all_from_item',
        value: function remove_all_from_item(id) {
            var item = JSON.parse(JSON.stringify(document.shopping_cart[id]));

            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                method: 'POST',
                url: URL_PROJECT + '/shopping-cart/remove-all-from-item',
                type: 'JSON',
                dataType: 'JSON',
                data: item,
                statusCode: { 419: function _() {
                        window.location.href = URL_PROJECT;
                    } }
            }).done(function (response, textStatus, jqXHR) {
                var pro=$('[data-id=' + id + ']');
                pro.remove();

                ResumeCart.remove_item(id);
                ResumeCart.getInitQuotation("checkout");

                if (!ResumeCart.has_items()) {
                    ResumeCart.hide_resume_cart(response.translates);
                }
            }).fail(function (response, textStatus, errorThrown) {
                console.log(response, textStatus, errorThrown);
                $(".loader").removeClass("show");
            });
        }
    },
        /**
         * remove_all
         * Elimina todos los productos del carrito (sesión)
         */

    {
        key: 'remove_all',
        value: function remove_all() {
            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                method: 'POST',
                url: URL_PROJECT + '/shopping-cart/remove-all-resume-cart',
                type: 'JSON',
                dataType: 'JSON',
                data: {},
                statusCode: { 419: function _() {
                        window.location.href = URL_PROJECT;
                    } }
            }).done(function (response, textStatus, jqXHR) {
                $('.cart-list').empty();
                ResumeCart.clear_shopping_cart();
                window.location.href = URL_PROJECT;
            }).fail(function (response, textStatus, errorThrown) {
                console.log(response, textStatus, errorThrown);
                $(".loader").removeClass("show");
            });
        }

        /**
         * clear_shopping_cart
         * Elimina todos los productos del carrito (front)
         */

    }, {
        key: 'clear_shopping_cart',
        value: function clear_shopping_cart() {
            document.shopping_cart = null;
        }

        /**
         * remove_item
         * Elimina un producto del carrito (front)
         *
         * @param id        ID del producto
         */

    }, {
        key: 'remove_item',
        value: function remove_item(id) {
            $('[data-id=' + id + ']').remove();
            delete document.shopping_cart[id];
        }

        /**
         * hide_resume_cart
         * Oculta el resumen de la compra (front)
         *
         * @param translates    Traducciones
         */

    }, {
        key: 'hide_resume_cart',
        value: function hide_resume_cart(translates) {
            //$('#cart-list').append(`<li id="cart-empty" style="text-align: center; margin-top: 50px;">${translates.no_items}</li>`);
            $('.cart-list').append('<li id="cart-empty" style="text-align: center; margin-top: 50px;">' + translates.no_items + '</li>');
            $('.js-empty-cart').hide();
        }

        /**
         * show_resume_cart
         * Muestra el resumen de la compra (front)
         */

    }, {
        key: 'show_resume_cart',
        value: function show_resume_cart() {
            //$('#cart-list').empty();
            $('.cart-list').empty();
            $('.js-empty-cart').show();
        }

        /**
         * update_resume_cart
         * Actualiza el resumen de la compra (front)
         *
         * @param resume    Resumen de la compra
         * @param options   Opciones
         */

    }, {
        key: 'update_resume_cart',
        value: function update_resume_cart(resume, options) {
            $('#subtotal').text(options.translates.subtotal + ': ' + resume.subtotal_formatted);
            $('#points').text(options.translates.points + ': ' + resume.points);
            $('#total').text(options.translates.total + ': ' + resume.subtotal_formatted);

            $('.subtotal_checkout').text(options.translates.subtotal + ': ' + resume.subtotal_formatted);
            $('.points_checkout').text(options.translates.points + ': ' + resume.points);
            $('.total_checkout').text(options.translates.total + ': ' + resume.subtotal_formatted);
        }
    }, {
            /**
             * has_items
             * Verifica si el carrito tiene items (front)
             *
             * @returns {boolean}
             */
        key: 'has_items',
        value: function has_items() {
            return $('.cart-list').has('li').length > 0;
        }
    },
    {
        /**
         * add_system
         * Obtiene los items de un sistema para guardarlos en sesión (front)
         *
         * @param id        ID del sistema
         */
        key: 'add_system',
        value: function add_system(id) {
            var items = JSON.parse(JSON.stringify(document.systems[id]));

            ResumeCart.add_many(items);
        }
    },

    {
        /**
         * change_quantity
         * Actualiza la cantidad de unidades de un producto en el carrito
         *
         * @param id        ID del producto
         * @param quantity  Cantidad
         */

        key: 'change_quantity',
        value: function change_quantity(id, quantity) {
            var item = JSON.parse(JSON.stringify(document.shopping_cart[id]));
            item.quantity = parseInt(quantity);

            if (item.quantity === 0) {
                ResumeCart.remove_all_from_item(item.id);
            } else {
                //if ($('#cart-list').has('li#cart-empty').length > 0) {
                if ($('.cart-list').has('li.cart-empty').length > 0) {
                    ResumeCart.show_resume_cart();
                }

                $.ajax({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    method: 'POST',
                    url: URL_PROJECT + '/shopping-cart/change-quantity',
                    type: 'JSON',
                    dataType: 'JSON',
                    data: item,
                    statusCode: { 419: function _() {
                            window.location.href = URL_PROJECT;
                        }
                    }
                }).done(function (response, textStatus, jqXHR) {
                    ResumeCart.getInitQuotation("checkout");

                }).fail(function (response, textStatus, errorThrown) {
                    console.log(response, textStatus, errorThrown);
                    $(".loader").removeClass("show");
                });
            }
        }
    },
    {
        /**
         * getInitQuotation
         * Inicia el proceso de cotizacion
         */

        key: 'getInitQuotation',
        value: function getInitQuotation(process) {
            if ($('.cart-list').has('li.cart-empty').length > 0) {
                window.location.href = URL_PROJECT;
            }

            var showPromotions = false;
            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                method: 'GET',
                url: URL_PROJECT + '/shopping/checkout/quotation/getInitQuotation/'+process,
                type: 'JSON',
                dataType: 'JSON',
                statusCode: { 419: function _() {
                    window.location.href = URL_PROJECT;
                } }
            }).done(function (response, textStatus, jqXHR) {
                //console.log(response);
                if (response.success) {
                    //$('div#error_step1').css('display','none');
                    $("ul#error__boxSA_ul_step1").html("");

                    if (response.existsPromotions) {
                        showPromotions = true;
                    }

                    getViewCartPreviewQuotation();
                    $("div#change_period_step1").show();

                } else {

                    $("#addressSuccess").find(".modal__title").empty().append(response.messages);
                    $("#addressSuccess").find(".modal__body").empty().append("<p>"+response.messages+"</p>");
                    $("#addressSuccess").addClass("active");
                    $(".overlay").css("display",'block');

                    $('div#error_step1').css('display','inline-block');
                    $("ul#error__boxSA_ul_step1").html("");
                    $('ul#error__boxSA_ul_step1').append("<li>"+response.messages+"</li>");
                    $("div#change_period_step1").hide();

                    $(".loader").removeClass("show");
                }



                if(showPromotions) {
                    $(".overlay").css("display",'block');
                    getViewModalPromotions('checkout');
                } else {
                    $(".overlay").css("display",'none');
                }
            }).fail(function (response, textStatus, errorThrown) {
                //console.log(response, textStatus, errorThrown);
                $(".loader").removeClass("show");
            });

        }
    },{
        key: 'getViewCartPreviewQuotation',
        value: function getViewCartPreviewQuotation() {
            var url = 'checkout/quotation/getCartPreviewQuotation';
            $.ajax({
                url: url,
                type: 'GET',
                success: function (result) {
                    //$(".overlay").css("display",'none');
                    if (result) {
                        $('div#cart-preview').find("#cart-empty").hide();
                        $('div#cart-preview').find(".cart-product__item").remove();
                        $('div#cart-preview').find(".cart-product__list").append(result.items);
                        $('div#cart-preview').find(".cart-preview__resume").html("");
                        $('div#cart-preview').find(".cart-preview__resume").append(result.totals);
                        $('div#cart-preview').removeClass("active");
                        //$('div#cart-preview').replaceWith(result);

                        /*document.getElementById("cart-preview").classList.add("ps");
                        document.getElementById("cart-preview").classList.add("ps--active-y");

                        $('div#cart-preview').removeClass("active");*/
                        $("#buttonToStep2").removeAttr('disabled');

                        $('#cart-preview-mov li.total').text($('#total').text());
                        $('#cart-preview-mov li.points').text($('#points').text());

                    } else {
                        $('div#cart-preview').find("#cart-empty").show();
                        //alert('No se cargo resumen de compra')
                    }
                },
                complete: function () {
                    $(".loader").removeClass("show");
                },
                error: function() {
                    $(".loader").removeClass("show");
                    //$(".overlay").css("display",'none');
                    $("#blank-overlay").css("display",'none');
                }
            });
        }
    }]);

    return ResumeCart;
}();

/**
 * car_list.on('click', '.icon-bin img', function ())
 * Eliminar completamente un producto del carrito de compras
 */
/*$(document).on('click', '.cart-list .icon-bin img', function () {
    $(".loader").addClass("show");
    var liItem = $(this).closest('[data-id]');
    var id = liItem.data('id');

    ResumeCart.remove_all_from_item(id);

});*/

function removeResumeCartItem(item) {
    $(".loader").addClass("show");
    var liItem = $("#"+item).closest('[data-id]');
    var id = liItem.data('id');

    ResumeCart.remove_all_from_item(id);

};



/**
 * car_list.on('change', 'input', function ())
 * Actualiza la cantidad de items de un producto en el carrito de compras
 */
/*$(document).on('change', '.cart-list input', function () {
    $(".loader").addClass("show");
    var liItem = $(this).closest('[data-id]');
    var input = $(this);

    var id = liItem.data('id');
    var quantity = input.val();

    $(".cart-list").find(".item-id-" + id).find('input').val(quantity);

    if (quantity === '') {
        quantity = 0;
    }

    ResumeCart.change_quantity(id, quantity);


});*/

function changeQtyResumeCart (item) {
    //console.log(item);
    $(".loader").addClass("show");
    var liItem = $("#"+item.id).closest('[data-id]');

    var id = liItem.data('id');
    var quantity = item.value;

    $(".cart-list").find(".item-id-" + id).find('input').val(quantity);

    if (quantity === '') {
        quantity = 0;
    }

    ResumeCart.change_quantity(id, quantity);
}