/**
 * Created by PhpStorm.
 * User: Vicente Gutiérrez <vicente.gutierrez@omnilife.com>
 * Date: 11/07/18
 * Time: 11:07
 */
class ShoppingCart  {

    /**
     * add
     * Aumenta en <quantity> la cantidad de unidades de un producto (sesión)
     *
     * @param id        ID del producto
     * @param quantity  Cantidad de unidades a aumentar
     * @param from      Llave para obtener el producto <products|shopping_cart>
     */
    static add (id, quantity=1, from='products') {
        let item = from === 'products' ? JSON.parse(JSON.stringify(document.products[id])) : JSON.parse(JSON.stringify(document.shopping_cart[id]));
        item.quantity = quantity;

        if ($('#cart-list').has('li#cart-empty').length > 0) {
            ShoppingCart.show_resume_cart();
        }

        $.ajax({
            headers   : { 'X-CSRF-TOKEN': $('#shop_secret').val() },
            method    : 'POST',
            url       : URL_PROJECT + '/shopping-cart/add-one',
            type      : 'JSON',
            dataType  : 'JSON',
            data      : item,
            statusCode: { 419: function() {window.location.href = URL_PROJECT} }
        }).done(function (response, textStatus, jqXHR) {
            ShoppingCart.update_resume_cart(response.cart_resume, {
                translates: response.translates
            });
            ShoppingCart.add_item_to_list(item, quantity, {
                translates: response.translates,
                price: response.price
            });
            ShoppingCart.show_modal_cart();
        }).fail(function(response, textStatus, errorThrown) {
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
    static add_one (id, from='products') {
        let item = (from === 'products') ? JSON.parse(JSON.stringify(document.products[id])) : JSON.parse(JSON.stringify(document.shopping_cart[id]));
        item.quantity = 1;

        if ($('#cart-list').has('li#cart-empty').length > 0) {
            ShoppingCart.show_resume_cart();
        }

        $.ajax({
            headers   : { 'X-CSRF-TOKEN': $('#shop_secret').val() },
            method    : 'POST',
            url       : URL_PROJECT + '/shopping-cart/add-one',
            type      : 'JSON',
            dataType  : 'JSON',
            data      : item,
            statusCode: { 419: function() {window.location.href = URL_PROJECT} }
        }).done(function (response, textStatus, jqXHR) {
            ShoppingCart.update_resume_cart(response.cart_resume, {
                translates: response.translates
            });
            ShoppingCart.add_item_to_list(item, 1, {
                translates: response.translates,
                price: response.price
            });
            ShoppingCart.show_modal_cart();
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
    static remove_one (id) {
        let item = JSON.parse(JSON.stringify(document.shopping_cart[id]));

        $.ajax({
            headers   : { 'X-CSRF-TOKEN': $('#shop_secret').val() },
            method    : 'POST',
            url       : URL_PROJECT + '/shopping-cart/remove-one',
            type      : 'JSON',
            dataType  : 'JSON',
            data      : item,
            statusCode: { 419: function() {window.location.href = URL_PROJECT} }
        }).done(function (response, textStatus, jqXHR) {
            ShoppingCart.update_resume_cart(response.cart_resume, {
                translates: response.translates
            });
            if (!ShoppingCart.has_items()) {
                ShoppingCart.hide_resume_cart(response.translates);
            }
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
    static remove_all_from_item (id) {
        let item = JSON.parse(JSON.stringify(document.shopping_cart[id]));

        $.ajax({
            headers   : { 'X-CSRF-TOKEN': $('#shop_secret').val() },
            method    : 'POST',
            url       : URL_PROJECT + '/shopping-cart/remove-all-from-item',
            type      : 'JSON',
            dataType  : 'JSON',
            data      : item,
            statusCode: { 419: function() {window.location.href = URL_PROJECT} }
        }).done(function (response, textStatus, jqXHR) {
            $(`[data-id=${id}]`).remove();
            ShoppingCart.remove_item(id);
            ShoppingCart.update_resume_cart(response.cart_resume, {
                translates: response.translates
            });

            if (!ShoppingCart.has_items()) {
                ShoppingCart.hide_resume_cart(response.translates);
            }
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
    static add_item_to_list (item, quantity=1, options) {
        let item_found = $('#cart-list').find(`[data-id=${item.id}]`);

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
    static add_html_item_to_list (item, options) {
        $('#cart-list').append(`<li data-id="${item.id}" class="cart-product__item">
                <figure class="cart-product__img"><img src="${item.image}" alt=""></figure>
                <div class="cart-product__content">
                    <div class="cart-product__top">
                        <div class="cart-product__title">${item.name}</div>
                        <div class="cart-product__code">${options.translates.code}: ${item.sku}</div>
                        <div class="bin"><figure class="icon-bin"><img src="/themes/omnilife2018/images/icons/bin.svg" alt="Eliminar"></figure></div>
                    </div>
                    <div class="cart-product__bottom">
                        <div class="form-group numeric">
                            <span class="minus r" style="margin-right: 10px"><svg height="14" width="14"><line x1="0" y1="8" x2="14" y2="8"></line></svg></span>
                            <input class="form-control" type="numeric" name="qty" value="${item.quantity}">
                            <span class="plus r" style="margin-left: 10px"><svg height="14" width="14"><line x1="0" y1="7" x2="14" y2="7"></line><line x1="7" y1="0" x2="7" y2="14"></line></svg></span>
                        </div>
                        <div class="cart-product__nums"><div class="cart-product__pts">${item.points} ${options.translates.pts}</div><div class="cart-product__price">x ${options.price}</div></div>
                    </div>
                </div>
            </li>`);
    }

    /**
     * add_to_item
     * Incrementa en <quantity> las unidades de un producto en el carrito (front)
     *
     * @param id
     * @param quantity
     */
    static add_to_item (id, quantity) {
        let item_found = $('#cart-list').find(`[data-id=${id}]`);

        if (item_found.length > 0) {
            let input = item_found.find('input');
            input.val(parseInt(input.val()) + parseInt(quantity));
            $(".cart-list").find(".item-id-"+id).find('input').val(input.val());
        }
    }

    /**
     * save_item
     * Guarda un producto o incrementa la cantidad del mismo (front)
     *
     * @param item
     * @returns {boolean}   true si el producto ya existía
     */
    static save_item (item) {
        let items  = document.shopping_cart === undefined || document.shopping_cart === null || document.shopping_cart === [] ? {} : document.shopping_cart;
        let exists = false;

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
    static remove_all () {
        $.ajax({
            headers   : { 'X-CSRF-TOKEN': $('#shop_secret').val() },
            method    : 'POST',
            url       : URL_PROJECT + '/shopping-cart/remove-all',
            type      : 'JSON',
            dataType  : 'JSON',
            data      : {},
            statusCode: { 419: function() {window.location.href = URL_PROJECT} }
        }).done(function (response, textStatus, jqXHR) {
            $('.cart-list').empty();

            ShoppingCart.clear_shopping_cart();
            ShoppingCart.hide_resume_cart(response.translates);
            ShoppingCart.hide_modal_cart();
        }).fail(function (response, textStatus, errorThrown) {
            console.log(response, textStatus, errorThrown);
        });
    }

    /**
     * clear_shopping_cart
     * Elimina todos los productos del carrito (front)
     */
    static clear_shopping_cart () {
        document.shopping_cart = null;
    }

    /**
     * remove_item
     * Elimina un producto del carrito (front)
     *
     * @param id        ID del producto
     */
    static remove_item (id) {
        $(`[data-id=${id}]`).remove();
        delete document.shopping_cart[id];
    }

    /**
     * hide_resume_cart
     * Oculta el resumen de la compra (front)
     *
     * @param translates    Traducciones
     */
    static hide_resume_cart (translates) {
        //$('#cart-list').append(`<li id="cart-empty" style="text-align: center; margin-top: 50px;">${translates.no_items}</li>`);
        $('.cart-list').append(`<li id="cart-empty" style="text-align: center; margin-top: 50px;">${translates.no_items}</li>`);
        $('.js-empty-cart').hide();
    }

    /**
     * show_resume_cart
     * Muestra el resumen de la compra (front)
     */
    static show_resume_cart () {
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
    static update_resume_cart (resume, options) {
        $('#subtotal').text(`${options.translates.subtotal}: ${resume.subtotal_formatted}`);
        $('#points').text(`${options.translates.points}: ${resume.points}`);
        $('#total').text(`${options.translates.total}: ${resume.subtotal_formatted}`);

        $('.subtotal_checkout').text(`${options.translates.subtotal}: ${resume.subtotal_formatted}`);
        $('.points_checkout').text(`${options.translates.points}: ${resume.points}`);
        $('.total_checkout').text(`${options.translates.total}: ${resume.subtotal_formatted}`);
    }

    /**
     * has_items
     * Verifica si el carrito tiene items (front)
     *
     * @returns {boolean}
     */
    static has_items () {
        return $('.cart-list').has('li').length > 0;
    }

    /**
     * show_modal_cart
     * Muestra el modal del carrito (front)
     */
    static show_modal_cart () {
        $('div.overlay').show();
        $('div.cart-preview.aside').addClass('active');
    }

    /**
     * hide_modal_cart
     * Oculta el modal del carrito (front)
     */
    static hide_modal_cart () {
        $('div.cart-preview.aside').removeClass('active');
        $('div.overlay').hide();
    }

    /**
     * add_system
     * Obtiene los items de un sistema para guardarlos en sesión (front)
     *
     * @param id        ID del sistema
     */
    static add_system (id) {
        let items = JSON.parse(JSON.stringify(document.systems[id]));

        ShoppingCart.add_many(items);
    }

    /**
     * add_related_products
     * Obtiene los productos relacionados de un producto para guardarlos en sesión (front)
     *
     * @param id        ID del producto
     */
    static add_related_products (id) {
        let items = JSON.parse(JSON.stringify(document.related_products[id]));

        ShoppingCart.add_many(items);
    }

    /**
     * add_many
     * Agrega varios productos en el carrito (sesión)
     *
     * @param items     Productos
     */
    static add_many (items) {
        if ($('#cart-list').has('li#cart-empty').length > 0) {
            ShoppingCart.show_resume_cart();
        }

        $.ajax({
            headers   : { 'X-CSRF-TOKEN': $('#shop_secret').val() },
            method    : 'POST',
            url       : URL_PROJECT + '/shopping-cart/add-many',
            type      : 'JSON',
            dataType  : 'JSON',
            data      : items,
            statusCode: { 419: function() {window.location.href = URL_PROJECT} }
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
            ShoppingCart.show_modal_cart();
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
    static change_quantity (id, quantity) {
        let item = JSON.parse(JSON.stringify(document.shopping_cart[id]));
        item.quantity = parseInt(quantity);

        if (item.quantity === 0) {
            ShoppingCart.remove_all_from_item(item.id);
        } else {
            //if ($('#cart-list').has('li#cart-empty').length > 0) {
            if ($('.cart-list').has('li.cart-empty').length > 0) {
                ShoppingCart.show_resume_cart();
            }

            $.ajax({
                headers   : { 'X-CSRF-TOKEN': $('#shop_secret').val() },
                method    : 'POST',
                url       : URL_PROJECT + '/shopping-cart/change-quantity',
                type      : 'JSON',
                dataType  : 'JSON',
                data      : item,
                statusCode: { 419: function() {window.location.href = URL_PROJECT} }
            }).done(function (response, textStatus, jqXHR) {
                ShoppingCart.update_resume_cart(response.cart_resume, {
                    translates: response.translates
                });
            }).fail(function (response, textStatus, errorThrown) {
                console.log(response, textStatus, errorThrown);
            });
        }
    }
}

$(document).ready(function () {
    let car_list       = $('.cart-list');
    let product_detail = $('#product-detail');

    /**
     * car_list.on('click', '.plus', function ())
     * Aumentar en uno la cantidad de un producto en el modal del carrito de compras
     */
    car_list.on('click', '.plus', function () {
        let input = $(this).parent().find('input');
        let id = $(this).closest('[data-id]').data('id');

        if (!$(this).hasClass('s')) {
            input.val(parseInt(input.val())+1);
        }

        if ($(this).hasClass('r')) {
            input.val(parseInt(input.val())-1);
        }



        ShoppingCart.add_one(id, 'shopping_cart');
    });


    /**
     * car_list.on('click', '.minus', function ())
     * Disminuir en uno la cantidad de un producto en el modal del carrito de compras
     */
    car_list.on('click', '.minus', function () {
        let input = $(this).parent().find('input');
        let id = $(this).closest('[data-id]').data('id');

        if (!$(this).hasClass('s')) {
            input.val(parseInt(input.val()) > 0 ? parseInt(input.val())-1 : 0);
        }

        $(".cart-list").find(".item-id-"+id).find('input').val(parseInt(input.val()));

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
        let liItem = $(this).closest('[data-id]');
        let id     = liItem.data('id');

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
        let liItem = $(this).closest('[data-id]');
        let input = $(this);

        let id = liItem.data('id');
        let quantity = input.val();

        $(".cart-list").find(".item-id-"+id).find('input').val(quantity);

        if (quantity === '') { quantity = 0; }

        ShoppingCart.change_quantity(id, quantity);
    });


    /**
     * product_detail.on('click', '#add-product', function ())
     * Agrega n cantidad de items a un producto en el detalle del mismo
     */
    product_detail.on('click', '#add-product', function () {
        let quantity = $('#product-detail input').val();
        let id = $('#add-product').data('id');

        ShoppingCart.add(id, quantity);
    });
});

