var globalBrandCategories;
var activeCategoryId;

function changeCategoryUrl(select) {
    $('a.button.button--products.small').attr('href', $(select).find(":selected").data('url'));
}

function printBrandCategory(brandCategory, isFirstBrand) {
    var select = $('<select onchange="changeCategoryUrl(this)"></select>').attr({ 'class' : 'form-control select-category',
        'name' : 'category', 'id' : 'select-brand-' + brandCategory.brand.id });
    brandCategory.categories.forEach(function (category, index) {

        if (category.home_products > 0) {
            var opt = $('<option></option>').attr({ 'value' : category.id, 'data-url': category.url }).html(category.name);
            select.append(opt);
            if (index == 0 && isFirstBrand) {
                activeCategoryId = opt.val();
                $('a.button.button--products.small').attr('href', category.url);
            }
        }
    });
    var divCategories = $('<div></div>').attr({ 'class' : 'select select--categories' }).append(select);
    var divTools = $('<div></div>').attr({ 'class' : 'tools__form-group' }).append(divCategories);
    return divTools;
}

function printBrandTabs(brandCategories) {
    var divTabs = $('<div></div>').attr({ 'class' : 'tabs'});
    var divTabsHeader = $('<div></div>').attr({ 'class' : 'tabs__header'});
    brandCategories.forEach(function (brandCategory, index) {
        var tabContent = '<a href="#">' + brandCategory.brand.alias + '</a>';
        var tab = $('<div></div>').append(tabContent)
            .attr({ 'class' : 'tabs__item', 'data-target' : brandCategory.brand.id, 'onclick' : "return false" });
        if (index == 0) {
            tab.addClass('active');
        }
        divTabsHeader.append(tab);
    });
    var divCategories = $('<div></div>').attr({ 'class' : 'tabs__content', 'id' : 'productsCategory' });
    brandCategories.forEach(function (brandCategory, index) {
        var tabPane = $('<div></div>').attr({ 'class' : 'tabs__pane', 'id' : 'tab-pane-' + brandCategory.brand.id });
        if (index == 0) {
            tabPane.addClass('active').append(printBrandCategory(brandCategory, true));
        } else {
            tabPane.append(printBrandCategory(brandCategory, false));
        }
        divCategories.append(tabPane);
    });
    divTabs.append(divTabsHeader).append(divCategories);

    return divTabs;
}

function generateCategories(brandCategories, show_tabs) {
    var categoriesWrapper = $('#categories-wrapper');
    if (brandCategories.length > 1 || show_tabs) {
        categoriesWrapper.append(printBrandTabs(brandCategories));
    } else {
        categoriesWrapper.append(printBrandCategory(brandCategories[0], true));
    }
    var description = $('<p></p>').attr({ 'class' : 'products-desc__description', 'id' : 'products-description' });
    categoriesWrapper.append(description);
    setDescription();
}

function setDescription() {
    globalBrandCategories.forEach(function (brandCategory) {
        brandCategory.categories.forEach(function (category) {
            if (activeCategoryId == category.id) {
                $('#products-description').html(category.description);
                getProducts();
            }
        });
    });
}

function setActiveTab(tab) {
    $('.tabs__item').removeClass('active');
    $('.tabs__pane').removeClass('active');
    tab.addClass('active');
    var dataTarget = tab.attr('data-target');

    $('a.button.button--products.small').attr('href', $('#select-brand-'+dataTarget).find(":selected").data('url'));

    $('#tab-pane-' + dataTarget).addClass('active');
    activeCategoryId = $('#select-brand-' + dataTarget).val();
    setDescription();
}

function categoryComboChange(option) {
    activeCategoryId = option.val();
    setDescription();
}

function printProducts(products, shopping_active, is_ws_active, is_logged) {
    hideProducts();
    if (products.length > 0) {
        var homeProducts = $('#home-products');
        homeProducts.html('');
        products.forEach(function (product) {
            var h3 = $('<h3></h3>').attr({ 'class' : 'product__name' }).html(product.name);
            var img = $('<img>').attr({ 'src' : PUBLIC_URL + product.image, 'alt' : product.name });
            var figure = $('<figure></figure>').attr({ 'class' : 'product__image' }).append(img);
            var p = $('<p></p>').attr({ 'class' : 'product__description' }).html(product.description);

            var spanPrice = $('<span></span>').attr({ 'class' : 'product__price' }).html(product.price);
            var spanPoints = $('<span></span>').attr({ 'class' : 'product__pts' }).html((HIDE_PRICE !== '1' && is_ws_active && is_logged) ? product.points + ' PTS' : '');
            var spanNums = $('<span></span>').attr({ 'class' : 'product__nums' }).append(spanPrice).append(spanPoints);

            var link = $('<a></a>').attr({ 'class' : 'product__link', 'href' : product.url})
                .append(h3).append(figure).append(p).append(spanNums);

            var separator = $('<div class="product__sep"></div>');
            var btn = $('<button></button>').attr({ 'class' : 'button clean', 'type' : 'button', 'onclick': "ShoppingCart.add('"+product.id+"', 1)"}).html(BUTTON_LANG);
            var footer = $('<footer></footer>').attr({ 'class' : 'product__f' }).append(separator).append(btn);

            var item = $('<div></div>').attr({ 'class' : 'product slider__item' }).append(link);

            if (shopping_active && is_ws_active && HIDE_PRICE !== '1') {
                item.append(footer);
            }

            homeProducts.append(item);

        });
        $('#home-products').show();

        $('#products-slider .slider__bullets').remove();
        new document.slider.default('products-slider', {
            navBullets: true,
            onlyMobile: true
        });

    } else {
        $('#home-products-empty').show();
    }
}

function getProducts() {
    $.ajax({
        url: GET_PRODUCTS_URL,
        data: {
            category_id: activeCategoryId,
        },
        beforeSend: function () {
            hideProducts();
            $('#home-products-loader').show();
        },
        success: function (data) {
            document.products = jQuery.parseJSON(data.json_products);
            printProducts(data.products, data.shopping_active, data.is_ws_active, data.is_logged);
        },
        error: function (jqXHR, timeout, message) {
           var contentType = jqXHR.getResponseHeader("Content-Type");
           if (jqXHR.status === 200 && contentType.toLowerCase().indexOf("text/html") >= 0) {
               window.location.reload();
           }
        }
    });
}

function hideProducts() {
    $('#home-products').hide();
    $('#home-products-empty').hide();
    $('#home-products-loader').hide();
}

$(document).ready(function () {
    $.ajax({
        url: GET_CATEGORIES_URL,
        data: {
            brand_id: BRAND_ID,
            country_id: COUNTRY_ID,
        },
        success: function (data) {
            globalBrandCategories = data.brandCategories;

            var shopping_cart = jQuery.parseJSON(data.json_shopping_cart);
            if (shopping_cart.constructor === Array && shopping_cart.length == 0) {
                shopping_cart = {};
            }
            document.shopping_cart = shopping_cart;

            generateCategories(data.brandCategories, data.show_tabs);
            ShoppingCart.update_items();
        },
        error: function (jqXHR, timeout, message) {
           var contentType = jqXHR.getResponseHeader("Content-Type");
           if (jqXHR.status === 200 && contentType.toLowerCase().indexOf("text/html") >= 0) {
               window.location.reload();
           }
        }
    });
    $(document).on('click', '.tabs__item', function(){
        setActiveTab($(this));
    });
    $(document).on('change', '.select-category', function(){
        categoryComboChange($(this));
    });
});
