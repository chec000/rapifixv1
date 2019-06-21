function search() {
    var search = $('#search-input').val();
    window.location.href = CURRENT_ROUTE + '?search=' + search;
}

$('#search-btn').on('click', function () {
    search();
    return false;
});

$('#search-input').keypress(function(e) {
    if (e.which == 13) {
        search();
        return false;
    }
});

$('#stories-filter').change(function () {
    var value = $(this).val();
    var i = 0;
    $('.story-item').each(function (index) {
        if (value == 0) {
            $(this).removeClass('hide-story');
            i++;
        } else {
            ACTIVE_FILTER = 'story-filter-' + value;
            if ($(this).hasClass(ACTIVE_FILTER)) {
                $(this).removeClass('hide-story');
                i++;
            } else {
                $(this).addClass('hide-story');
            }
        }
    });
    if (i > 0) {
        $('#empty-stories').hide();
    } else {
        $('#empty-stories').show();
    }
});

$('#load-stories').click(function () {
    if ($('#stories-filter').val() != 0) {
        $('.story-item').each(function () {
            if ($(this).hasClass(ACTIVE_FILTER)) {
                $(this).removeClass('hide-story');
            }
        });
    } else {
        $('.story-item').removeClass('hide-story');
    }
    $('#load-stories-container').hide();
});

//init conf
$('#empty-stories').hide();
$('#stories-filter').val('0');
$('.story-item').each(function (index) {
    if (index > 3) {
        $(this).addClass('hide-story');
    }
});
if ($('.story-item').length <= 4) {
    $('#load-stories-container').hide();
}
