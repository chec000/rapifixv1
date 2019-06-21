var IS_SEARCHING = 0;

function renderTitle(title) {
    var item;
    item = '<div class="search-result product">';
    item += '<h3 class="search-row search-row-header">';
    item += title;
    item += '</h3>';
    item += '</div>';

    return item;
}

function renderLink(result) {
    var item;
    item = '<div class="search-result product">';
    item += '<a href="' + result.link + '">';
    item += '<h3 class="search-row" style="display: flex">';
    item += result.header;
    item += '<span class="small-label ' + result.brand.toLowerCase().latinize() + '">' + result.brand + '</span>';
    item += '</h3>';
    item += '<p class="search-row-description">' + result.description + '</p>';
    item += '</a>';
    item += '</div>';

    return item;
}

function renderResults(results) {
    var html = '';
    results.forEach(function (result) {
        html += renderTitle(result.title);
        result.links.forEach(function (link) {
            html += renderLink(link);
        });
    });

    $('#global-search-results').html(html);
}


function globalSearch(search) {
    if (IS_SEARCHING == 0) {
        $.ajax({
            url: _GLOBAL_SEARCH_URL,
            type: 'GET',
            data: {
                _token: _CSRF_TOKEN,
                search: search
            },
            beforeSend: function () {
                $('#global-search-container').show().scrollTop(0);
                $('#global-search-results').hide();
                $('#global-search-empty').hide();
                $('#global-search-loading').show();
                IS_SEARCHING = 1;
            },
            success: function (response) {
                console.log(response);
                if (response.length > 0) {
                    renderResults(response);
                    $('#global-search-loading').hide();
                    $('#global-search-results').show();
                } else {
                    $('#global-search-loading').hide();
                    $('#global-search-empty').show();
                }
                IS_SEARCHING = 0;
            },
            error: function (jqXHR, timeout, message) {
                var contentType = jqXHR.getResponseHeader("Content-Type");
                if (jqXHR.status === 200 && contentType.toLowerCase().indexOf("text/html") >= 0) {
                    window.location.reload();
                }
            }
        });
    }
}

$('#global-search').on('keypress', function (e) {
    var value = $(this).val();
    if (e.which == 13 && value != '') {
        globalSearch(value);
        return false;
    }
});
