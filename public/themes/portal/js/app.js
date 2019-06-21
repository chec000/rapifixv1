$('.video-responsive').each(function () {
    var height = Math.round($(this).width() / 1.77);
    $(this).height(height);
});

$('.video-responsive-youtube').each(function () {
    var height = Math.round($(this).width() / 2.4);
    $(this).height(height);
});

$('#isearch').click(function () {
    $('#global-search').focus();
});
