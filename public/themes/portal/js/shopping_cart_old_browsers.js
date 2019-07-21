'use strict';

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

/**
 * Created by PhpStorm.
 * User: Vicente Gutiérrez <vicente.gutierrez@omnilife.com>
 * Date: 11/07/18
 * Time: 11:07
 */
var ShoppingCart = function () {
    function ShoppingCart() {
        _classCallCheck(this, ShoppingCart);
    }

    _createClass(ShoppingCart, null, [{
        key: 'add',


        /**
         * add
         * Aumenta en <quantity> la cantidad de unidades de un producto (sesión)
         *
         * @param id        ID del producto
         * @param quantity  Cantidad de unidades a aumentar
         * @param from      Llave para obtener el producto <products|shopping_cart>
         */
        value: function add(id) {
            var quantity = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 1;
            var from = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : 'products';

            var item = from === 'products' ? JSON.parse(JSON.stringify(document.products[id])) : JSON.parse(JSON.stringify(document.shopping_cart[id]));
            item.quantity = quantity;
                var products_i=$(".cart-items");
            if (products_i.children().length > 0) {
                ShoppingCart.show_resume_cart();
            }

            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('#shop_secret').val() },
                method: 'POST',
                url: URL_PROJECT + '/shopping-cart/add-one',
                type: 'JSON',
                dataType: 'JSON',
                data: item,
                statusCode: { 419: function _() {
                        window.location.href = URL_PROJECT;
                    } }
            }).done(function (response, textStatus, jqXHR) {
                ShoppingCart.update_resume_cart(response.cart_resume, {
                    translates: response.translates
                });
                ShoppingCart.add_item_to_list(item, quantity, {
                    translates: response.translates,
                    price: response.price
                });
                showAddCartModal(response,item);
                ShoppingCart.update_items();
            }).fail(function (response, textStatus, errorThrown) {
                console.log(response, textStatus, errorThrown);
            });
        }    

        /**
         * add
         * Aumenta en 1 la cantidad de unidades de un producto (sesión)
         *
         * @param id        ID del producto
         * @param from      Llave para obtener el producto <products|shopping_cart>
         */

    }, {
        key: 'add_one',
        value: function add_one(id) {
            var from = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 'products';

            var item = from === 'products' ? JSON.parse(JSON.stringify(document.products[id])) : JSON.parse(JSON.stringify(document.shopping_cart[id]));
            item.quantity = 1;

            if ($('#cart-list').has('li#cart-empty').length > 0) {
                ShoppingCart.show_resume_cart();
            }

            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('#shop_secret').val() },
                method: 'POST',
                url: URL_PROJECT + '/shopping-cart/add-one',
                type: 'JSON',
                dataType: 'JSON',
                data: item,
                statusCode: { 419: function _() {
                        window.location.href = URL_PROJECT;
                    } }
            }).done(function (response, textStatus, jqXHR) {
                ShoppingCart.update_resume_cart(response.cart_resume, {
                    translates: response.translates
                });
                ShoppingCart.add_item_to_list(item, 1, {
                    translates: response.translates,
                    price: response.price
                });
             showAddCartModal(response,item);
                ShoppingCart.update_items();
            }).fail(function (response, textStatus, errorThrown) {
                console.log(response, textStatus, errorThrown);
            });
        }

        /**
         * remove_one
         * Resta una unidad a un producto del carrito (sesión)
         *
         * @param id        ID del producto
         */

    }, {
        key: 'remove_one',
        value: function remove_one(id) {
            var item = JSON.parse(JSON.stringify(document.shopping_cart[id]));

            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('#shop_secret').val() },
                method: 'POST',
                url: URL_PROJECT + '/shopping-cart/remove-one',
                type: 'JSON',
                dataType: 'JSON',
                data: item,
                statusCode: { 419: function _() {
                        window.location.href = URL_PROJECT;
                    } }
            }).done(function (response, textStatus, jqXHR) {
                ShoppingCart.update_resume_cart(response.cart_resume, {
                    translates: response.translates
                });
                if (!ShoppingCart.has_items()) {
                    ShoppingCart.hide_resume_cart(response.translates);
                }

                ShoppingCart.update_items();
            }).fail(function (response, textStatus, errorThrown) {
                console.log(response, textStatus, errorThrown);
            });
        }

        /**
         * remove_all_from_item
         * Elimina completamente un producto del carrito (sesión)
         *
         * @param id        ID del producto
         */

    }, {
        key: 'remove_all_from_item',
        value: function remove_all_from_item(id) {
            var item = JSON.parse(JSON.stringify(document.shopping_cart[id]));

            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('#shop_secret').val() },
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
              var prot=$("#product-checkout-"+id).remove();
                pro.remove(); 
                ShoppingCart.remove_item(id);
                ShoppingCart.update_resume_cart(response.cart_resume, {
                    translates: response.translates
                });

                if (!ShoppingCart.has_items()) {
                    ShoppingCart.hide_resume_cart(response.translates);
                }

                ShoppingCart.update_items();
            }).fail(function (response, textStatus, errorThrown) {
                console.log(response, textStatus, errorThrown);
            });
        }

        /**
         * add_item_to_list
         * Agrega un producto al carrito o incrementa en uno las unidades si este ya existe (front)
         *
         * @param item          Producto
         * @param quantity      Cantidad de unidades
         * @param options       Opciones
         */

    }, {
        key: 'add_item_to_list',
        value: function add_item_to_list(item) {
            var quantity = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 1;
            var options = arguments[2];

            var item_found = $('.cart-items').find('[data-id=' + item.id + ']');

            ShoppingCart.save_item(item);

            if (item_found.length === 0) {
                ShoppingCart.add_html_item_to_list(item, options);
            } else {
                ShoppingCart.add_to_item(item.id, quantity);
            }
        }

        /**
         * add_html_item_to_list
         * Agrega el html de un producto nuevo al carrito (front)
         *
         * @param item          Producto
         * @param options       Opciones
         */

    }, {
        key: 'add_html_item_to_list',
        value: function add_html_item_to_list(item, options) {
    
            var product='<div data-id='+item.id+' class="cart-float-single-item d-flex"><span class="remove-item" onclick="ShoppingCart.remove_all_from_item('+item.id+')"><i class="fa fa-trash"></i></span>   <div class="cart-float-single-item-image">   <img src='+item.image+' class="img-fluid" alt=""></div><div class="cart-float-single-item-desc item-id-'+item.id+'><span class="product-title"><span class="count">'+item.quantity+' X '+item.name+' </span></span><input class="form-control" style="width: 34px" type="text" value='+item.quantity+' name="product-'+item.id+'" onkeypress="return isNumeric(event)"><p class="size"> <a href="shop-left-sidebar.html"></a></p><p class="price">'+item.price+'</p></div></div>';

          // var product='<div data-id='+item.id+' class="cart-float-single-item d-flex"><span class="remove-item" onclick="ShoppingCart.remove_all_from_item('+item.id+')"><a href="#"><i class="fa fa-trash"></i></a></span><div class="cart-float-single-item-image"><img src=' + item.image + ' class="img-fluid" alt=""></div><div class="cart-float-single-item-desc"><p class="product-title"><span class="count">' + item.quantity + 'X</span><a href="single-product-variable.html">' + item.name + '</a></p><p class="size"> <a href="shop-left-sidebar.html">' + item.name + '</a></p></div></div>';
            $('.cart-items').append(product);
        }

        /**
         * add_to_item
         * Incrementa en <quantity> las unidades de un producto en el carrito (front)
         *
         * @param id
         * @param quantity
         */

    }, {
        key: 'add_to_item',
        value: function add_to_item(id, quantity) {
            var item_found = $('.cart-items').find('[data-id=' + id + ']');

            if (item_found.length > 0) {
                var input = item_found.find('input');
                input.val(parseInt(input.val()) + parseInt(quantity));
                $(".cart-list").find(".item-id-" + id).find('input').val(input.val());
            }
        }

        /**
         * save_item
         * Guarda un producto o incrementa la cantidad del mismo (front)
         *
         * @param item
         * @returns {boolean}   true si el producto ya existía
         */

    }, {
        key: 'save_item',
        value: function save_item(item) {
            var items = document.shopping_cart === undefined || document.shopping_cart === null || document.shopping_cart === [] ? {} : document.shopping_cart;
            var exists = false;

            $.each(items, function (i, oItem) {
                if (oItem.sku === item.sku) {
                    exists = true;
                    items[i].quantity++;
                }
            });

            if (!exists) {
                items[item.id] = item;
            }

            document.shopping_cart = items;

            return exists;
        }

        /**
         * remove_all
         * Elimina todos los productos del carrito (sesión)
         */

    }, {
        key: 'remove_all',
        value: function remove_all() {
            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('#shop_secret').val() },
                method: 'POST',
                url: URL_PROJECT + '/shopping-cart/remove-all',
                type: 'JSON',
                dataType: 'JSON',
                data: {},
                statusCode: { 419: function _() {
                        window.location.href = URL_PROJECT;
                    } }
            }).done(function (response, textStatus, jqXHR) {
                $('.cart-list').empty();

                ShoppingCart.clear_shopping_cart();
                ShoppingCart.hide_resume_cart(response.translates);
                ShoppingCart.hide_modal_cart();
                ShoppingCart.update_items();
            }).fail(function (response, textStatus, errorThrown) {
                console.log(response, textStatus, errorThrown);
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
            $("#cart-floating-box").show();
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

        /**
         * has_items
         * Verifica si el carrito tiene items (front)
         *
         * @returns {boolean}
         */

    }, {
        key: 'has_items',
        value: function has_items() {
            return $('.cart-list').has('li').length > 0;
        }

        /**
         * show_modal_cart
         * Muestra el modal del carrito (front)
         */

    }, {
        key: 'show_modal_cart',
        value: function show_modal_cart() {
            $('div.overlay').show();
            $('div.cart-preview.aside').addClass('active');
        }

        /**
         * hide_modal_cart
         * Oculta el modal del carrito (front)
         */

    }, {
        key: 'hide_modal_cart',
        value: function hide_modal_cart() {
            $('div.cart-preview.aside').removeClass('active');
            $('div.overlay').hide();
        }

        /**
         * add_system
         * Obtiene los items de un sistema para guardarlos en sesión (front)
         *
         * @param id        ID del sistema
         */

    }, {
        key: 'add_system',
        value: function add_system(id) {
            var items = JSON.parse(JSON.stringify(document.systems[id]));

            ShoppingCart.add_many(items);
        }

        /**
         * add_related_products
         * Obtiene los productos relacionados de un producto para guardarlos en sesión (front)
         *
         * @param id        ID del producto
         */

    }, {
        key: 'add_related_products',
        value: function add_related_products(id) {
            var items = JSON.parse(JSON.stringify(document.related_products[id]));

            ShoppingCart.add_many(items);
        }

        /**
         * add_many
         * Agrega varios productos en el carrito (sesión)
         *
         * @param items     Productos
         */

    }, {
        key: 'add_many',
        value: function add_many(items) {
            if ($('#cart-list').has('li#cart-empty').length > 0) {
                ShoppingCart.show_resume_cart();
            }

            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('#shop_secret').val() },
                method: 'POST',
                url: URL_PROJECT + '/shopping-cart/add-many',
                type: 'JSON',
                dataType: 'JSON',
                data: items,
                statusCode: { 419: function _() {
                        window.location.href = URL_PROJECT;
                    } }
            }).done(function (response, textStatus, jqXHR) {
                ShoppingCart.update_resume_cart(response.cart_resume, {
                    translates: response.translates
                });
                $.each(items, function (i, item) {
                    ShoppingCart.add_item_to_list(item, 1, {
                        translates: response.translates,
                        price: response.prices[item.sku]
                    });
                });
                ShoppingCart.update_items();
            }).fail(function (response, textStatus, errorThrown) {
                console.log(response, textStatus, errorThrown);
            });
        }

        /**
         * change_quantity
         * Actualiza la cantidad de unidades de un producto en el carrito
         *
         * @param id        ID del producto
         * @param quantity  Cantidad
         */

    }, {
        key: 'change_quantity',
        value: function change_quantity(id, quantity) {
            var item = JSON.parse(JSON.stringify(document.shopping_cart[id]));
            item.quantity = parseInt(quantity);

            if (item.quantity === 0) {
                ShoppingCart.remove_all_from_item(item.id);
            } else {
                if ($('.cart-list').has('li.cart-empty').length > 0) {
                    ShoppingCart.show_resume_cart();
                }

                $.ajax({
                    headers: { 'X-CSRF-TOKEN': $('#shop_secret').val() },
                    method: 'POST',
                    url: URL_PROJECT + '/shopping-cart/change-quantity',
                    type: 'JSON',
                    dataType: 'JSON',
                    data: item,
                    statusCode: { 419: function _() {
                            window.location.href = URL_PROJECT;
                        } }
                }).done(function (response, textStatus, jqXHR) {
                    ShoppingCart.update_resume_cart(response.cart_resume, {
                        translates: response.translates
                    });

                    ShoppingCart.update_items();
                }).fail(function (response, textStatus, errorThrown) {
                    console.log(response, textStatus, errorThrown);
                });
            }
        }

    }, {
        key: 'update_items',
        value: function update_items() {
            var total_items = ShoppingCart.get_total_items();

            if (total_items === 0) {
                $('.nav-item .notification').hide();
            } else {
                if ($('.nav-item .notification').is(":hidden")) {
                    $('.nav-item .notification').show();
                }

                $('.nav-item .notification').text(total_items);
            }
        }

    }, {
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
        }

    }]);

    return ShoppingCart;
}();

function showAddCartModal(response,item) {
    console.log(response,item);
    $("#img-product-cart").attr("src",item.image);
    $("#name-product-cart").text(item.name);
    $("#description-product-cart").text(item.description);
    $("#quantity-product-cart").text(item.quantity);
    $("#price-product-cart").text(response.price);
    $("#total-cart").text(response.cart_resume.subtotal_formatted);
    $("#add-to-cart-modal-container").modal('show');
    
}


$(document).ready(function () {


    var car_list = $('.cart-list');
    var product_detail = $('#product-detail');

    /**
     * car_list.on('click', '.plus', function ())
     * Aumentar en uno la cantidad de un producto en el modal del carrito de compras
     */
    car_list.on('click', '.plus', function () {
        var input = $(this).parent().find('input');
        var id = $(this).closest('[data-id]').data('id');

        if (!$(this).hasClass('s')) {
            input.val(parseInt(input.val()) + 1);
        }

        if ($(this).hasClass('r')) {
            input.val(parseInt(input.val()) - 1);
        }

        ShoppingCart.add_one(id, 'shopping_cart');
    });

    /**
     * car_list.on('click', '.minus', function ())
     * Disminuir en uno la cantidad de un producto en el modal del carrito de compras
     */
    car_list.on('click', '.minus', function () {
        var input = $(this).parent().find('input');
        var id = $(this).closest('[data-id]').data('id');

        if (!$(this).hasClass('s')) {
            input.val(parseInt(input.val()) > 0 ? parseInt(input.val()) - 1 : 0);
        }

        $(".cart-list").find(".item-id-" + id).find('input').val(parseInt(input.val()));

        ShoppingCart.remove_one(id);
        if (parseInt(input.val()) === 0) {
            ShoppingCart.remove_item(id);
        }
    });

    /**
     * car_list.on('click', '.icon-bin img', function ())
     * Eliminar completamente un producto del carrito de compras
     */
    car_list.on('click', '.icon-bin img', function () {
        var liItem = $(this).closest('[data-id]');
        var id = liItem.data('id');

        ShoppingCart.remove_all_from_item(id);
    });

    /**
     * checkout_list.on('click', '.icon-bin img', function ())
     * Eliminar completamente un producto del carrito de compras
     */

    /**
     * car_list.on('change', 'input', function ())
     * Actualiza la cantidad de items de un producto en el carrito de compras
     */
    car_list.on('change', 'input', function () {
        var liItem = $(this).closest('[data-id]');
        var input = $(this);

        var id = liItem.data('id');
        var quantity = input.val();

        $(".cart-list").find(".item-id-" + id).find('input').val(quantity);

        if (quantity === '') {
            quantity = 0;
        }

        ShoppingCart.change_quantity(id, quantity);
    });

    /**
     * product_detail.on('click', '#add-product', function ())
     * Agrega n cantidad de items a un producto en el detalle del mismo
     */
    product_detail.on('click', '#add-product', function () {
        var quantity = $('#product-detail input').val();
        var id = $('#add-product').data('id');

        ShoppingCart.add(id, quantity);
    });
});