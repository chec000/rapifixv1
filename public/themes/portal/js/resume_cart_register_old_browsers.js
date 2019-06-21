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
                $('[data-id=' + id + ']').remove();
                ResumeCart.remove_item(id);
                ResumeCart.getInitQuotation("register");

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
                    ResumeCart.getInitQuotation("register");

                }).fail(function (response, textStatus, errorThrown) {
                    console.log(response, textStatus, errorThrown);
                    $(".loader").removeClass("show");
                });
            }
        }
    },
    {
        key: 'update_items',
        value: function update_items() {
            var total_items = ResumeCart.get_total_items();

            if (total_items === 0) {
                $('.nav-item .notification').hide();
            } else {
                if ($('.nav-item .notification').is(":hidden")) {
                    $('.nav-item .notification').show();
                }

                $('.nav-item .notification').text(total_items);
            }
        }
    },{
            key: 'get_total_items',
            value: function get_total_items() {
                var cart = document.shopping_cart;
                var items = 0;

                if (cart !== undefined && cart != null) {
                    $.each(cart, function (i, item) {
                        items += parseInt(item.quantity);
                    });
                }

                return items;
            }},

    {
        /**
         * getInitQuotation
         * Inicia el proceso de cotizacion
         */

        key: 'getInitQuotation',
        value: function getInitQuotation(process) {
            flushRegisterTransaction();
            var showPromotions = false;
            var url = 'register/initQuotation';
            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                method: 'POST',
                url: url,
                type: 'JSON',
                dataType: 'JSON',
                data: {fromChanged : true},
                statusCode: { 419: function _() {
                    window.location.href = URL_PROJECT;
                } }
            }).done(function (response, textStatus, jqXHR) {
                console.log(response);
                if (response.status) {
                    console.log("en estatus true");
                    $("#error__box_ul_step3").html("");
                    $("#error_step3").hide();
                    flushRegisterTransaction();

                    if (response.resultASW && response.resultASW.existsPromotions) {
                        showPromotions = true;
                    }

                    getViewCartPreviewQuotation();
                    $("#choose").hide();
                    $("#banks").removeClass('hide hidden');

                } else {
                    console.log("en estatus false");
                    $('.loader').removeClass('show').addClass('hide');
                    $("#error_step3").show();
                    $("#error__box_ul_step3").html("");
                    $("#city").addClass("has-error");

                    if(response.messages){
                        $.each(response.messages, function (i, item) {
                            $("#error__box_ul_step3").append("<li class='text-danger'>"+item.messUser+"</li>");
                        });
                    }else{
                        $("#error__box_ul_step3").append("<li class='text-danger'>"+response.messages+"</li>");
                    }
                }

                ResumeCart.getViewCartPreviewQuotation();

                if(showPromotions) {
                    getViewModalPromotions('register');
                }
            }).fail(function (response, textStatus, errorThrown) {
                //console.log(response, textStatus, errorThrown);
                $('.loader').removeClass('show').addClass('hide');
            });

        }
    },{
        key: 'getViewCartPreviewQuotation',
        value: function getViewCartPreviewQuotation() {
            console.log("calling preview");
            var url = 'register/quotation/getCartPreviewQuotation';
            $.ajax({
                url: url,
                type: 'GET',
                success: function (result) {
                    $('.loader').removeClass('show').addClass('hide');
                    if (result) {
                        $('div#cart-preview').find(".cart-preview__content").removeClass('hide hidden');
                        $('div#cart-preview').find(".cart-preview__resume").removeClass('hide hidden');
                        $('div#cart-preview').find(".cart-product__item").remove();
                        $('div#cart-preview').find(".cart-product__list").append(result.items);
                        $('div#cart-preview').find(".cart-preview__resume").html("");
                        $('div#cart-preview').find(".cart-preview__resume").append(result.totals);
                        $('div#cart-preview').removeClass("active");
                        //$('div#cart-preview').replaceWith(result);

                        /*document.getElementById("cart-preview").classList.add("ps");
                         document.getElementById("cart-preview").classList.add("ps--active-y");
                         */
                        $('div#cart-preview').removeClass("active");
                        $('#cart-preview-mov li.total').text($('#total').text());
                        $('#cart-preview-mov li.points').text($('#points').text());
                    } else {
                        alert('No se cargo resumen de compra')
                    }
                },
                complete: function () {
                    $('.loader').removeClass('show').addClass('hide');
                },
                error: function() {
                    $('.loader').removeClass('show').addClass('hide');
                    $(".overlay").css("display",'none');
                    $("#blank-overlay").css("display",'none');
                }
            });
        }
    },
    {
        key: 'flushRegisterTransaction',
        value: function flushRegisterTransaction() {
            console.log("calling flush");
            var url = 'register/flushRegisterTransaction';
            $.ajax({
                url: url,
                type: 'POST',
                success: function (result) {
                    console.log(result);

                },
                complete: function () {

                },
                error: function() {

                }
            });
        }
    }


    ]);

    return ResumeCart;
}();

$(document).ready(function () {
    /**
     * car_list.on('click', '.icon-bin img', function ())
     * Eliminar completamente un producto del carrito de compras
     */
    $(document).on('click', '.cart-list .icon-bin img', function () {
        $(".loader").addClass("show");
        var liItem = $(this).closest('[data-id]');
        var id = liItem.data('id');

        ResumeCart.remove_all_from_item(id);

    });

    /**
     * car_list.on('change', 'input', function ())
     * Actualiza la cantidad de items de un producto en el carrito de compras
     */
    $(document).on('change', '.cart-list input', function () {
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




    });

});