var tinymce_cnf = {
    selector: 'textarea.tinymce',
    plugins: 'link table code fullscreen preview textcolor paste image media responsivefilemanager anchor codesample',
    toolbar: "responsivefilemanager undo redo | styleselect | bold italic forecolor | alignleft aligncenter alignright alignjustify | bullist numlist indent outdent | link unlink anchor | image media | code | codesample",
    min_height: 160,
    paste_as_text: true,
    relative_urls: false,
    valid_elements : '*[*]',
    external_filemanager_path: get_public_url()+"filemanager/",
    filemanager_title: "Responsive Filemanager",
    external_plugins: { "filemanager" : get_public_url()+"filemanager/plugin.min.js"}
};
var tinymce_fetched_cms_pages = false;

function load_editor_js(rerun) {
    if (rerun != undefined) {
        $('.tinymce').each(function() {
            if ($(this).attr('addedmce') == undefined) {
                $(this).attr('addedmce', 'true');
                tinymce.execCommand('mceRemoveEditor',true,$(this).attr('id'));
                tinymce.execCommand('mceAddEditor',true,$(this).attr('id'));
            }
        });
    }
    else {
        if (!tinymce_fetched_cms_pages) {
            $.ajax({
                url: route('admin.pages.tinymce-page-list'),
                dataType: 'json',
                success: function(r) {
                    tinymce_cnf['link_list'] = r;
                    tinymce.init(tinymce_cnf);
                },
                error: function() {
                    tinymce.init(tinymce_cnf);
                }
            });
            tinymce_fetched_cms_pages = true;
        }
        else {
            tinymce.init(tinymce_cnf);
        }
    }

    // fileupload
    $('.iframe-btn').fancybox({
        'type'		: 'iframe',
        'autoSize'  : false,
        beforeLoad : function() {
            this.width  = 900;
            this.height = 600;
        },
        afterClose: function() {
            $('.img_src').each(function() {
                $('#'+$(this).attr('id').replace('source', 'image')).attr("src", $(this).val());
            });
        }
    });

    // date time block
    $('.datetimepicker').datetimepicker({dateFormat: dateFormat, timeFormat: timeFormat});

    // image blocks
    $(".fancybox").fancybox();
    $('.img_src').change(function() {
        $('#'+$(this).attr('id').replace('source', 'image')).attr("src", $(this).val());
    });

    // forms blocks
    $(".form-template").change(function() {
        var captcha_checkbox = $('[name="'+$(this).attr('name').replace('template', 'captcha')+'"]');
        if ($(this).find("option:selected").text().indexOf('does not support captcha') != -1) {
            captcha_checkbox.parent().parent().hide();
            captcha_checkbox.prop('checked', false);
        }
        else {
            captcha_checkbox.parent().parent().show();
        }
    }).trigger('change');

    // repeater blocks
    $(".repeater-table tbody").sortable({
        handle: 'td:first',
        items: 'tr'
    });
    $(".repeater_button").unbind('click').bind('click', function() {
        $(this).parent().parent().parent().parent().attr('class', 'col-sm-10 col-sm-offset-2');
        var repeater_id = $(this).attr("data-repeater");
        var page_id = $(this).attr("data-page");
        var block_id = $(this).attr("data-block");
        var language_id_repeater=$("#language_id_repeater").val();
        $.ajax({
            url: route('admin.repeaters.index'),
            type: 'POST',
            data: {repeater_id: repeater_id, block_id: block_id, page_id: page_id,language_id_repeater:language_id_repeater},
            success: function(r) {
                $("#repeater_"+repeater_id).parent().removeClass("hide");
                $("#repeater_"+repeater_id+" > tbody").append(r);
                load_editor_js(1);
            }
        });
    });

    // multi-select / video select
    $(".chosen-select").select2();
    $(".chosen-select-class").select2({
        escapeMarkup: function (m) {
            return m;
        },
        templateResult: function (data) {
            return '<span class="'+data.text+'"></span> '+" &nbsp; "+data.text;
        },
        templateSelection: function (data) {
            return '<span class="'+data.text+'"></span> '+" &nbsp; "+data.text;
        }
    });
    var videoTokens = {};
    $(".video-search").select2({
        placeholder: 'Insert youtube link link or search for video ...',
        minimumInputLength: 3,
        ajax: {
            url: 'https://www.googleapis.com/youtube/v3/search',
            dataType: 'json',
            quietMillis: 100,
            data: function (params) { // page is the one-based page number tracked by Select2
                if (videoTokens[params.term] == undefined) {
                    videoTokens[params.term] = '';
                }
                return {
                    q: params.term, //search term
                    part: 'id,snippet',
                    maxResults: 10,
                    type: 'video',
                    pageToken: videoTokens[params.term]['next'],
                    key: ytBrowserKey
                };
            },
            processResults: function (data, params) {
                params.page = params.page || 1;
                $.each(data.items, function (k, v) {
                    v.id = v.id.videoId;
                    data.items[k] = v;
                });
                videoTokens[params.term] = {'next': data.nextPageToken};
                return {
                    results: data.items,
                    pagination: {
                        more: (params.page * data.pageInfo.resultsPerPage) < data.pageInfo.totalResults
                    }
                };
            },
            error: function () {
                throw new Error("Invalid API key");
            }
        },
        templateResult: function (video) {
            if (!video.id || !video.snippet) return video.text;
            var t = new Date(video.snippet.publishedAt);
            return '<b>' + video.snippet.title + '</b> (' + video.snippet.channelTitle + ' ' + t.getDate() + '/' + (t.getMonth() + 1) + '/' + t.getFullYear() + ')<br /><i>https://www.youtube.com/watch?v=' + video.id + '</i>';
        },
        templateSelection: function (video) {
            if (!video.id || !video.snippet) return video.text;
            var t = new Date(video.snippet.publishedAt);
            return '<b>' + video.snippet.title + '</b> (' + video.snippet.channelTitle + ' ' + t.getDate() + '/' + (t.getMonth() + 1) + '/' + t.getFullYear() + ')';
        },
        escapeMarkup: function (m) {
            return m;
        } // we do not want to escape markup since we are displaying html in results
    }).on("change", function () {
        $('#' + this.id + '_preview').attr('src', '//www.youtube.com/embed/' + $(this).val()).css('display', 'block');
    });

    // select colour options
    var select_colour_els = $('.select_colour');
    select_colour_els.find('option').each(function () {
        if ($(this).val() != 'none') $(this).css('background-color', $(this).val());
    });
    select_colour_els.change(function () {
        if ($(this).val() != 'none') $(this).css('background-color', $(this).val());
    }).trigger('change');

    // page select block
    $('.custom-link').change(function () {
        $('[name="'+$(this).attr('name').replace('custom', 'internal')+'"]').val(0);
    });
    $('.internal-link').change(function () {
        if ($(this).val() > 0) {
            $('[name="'+$(this).attr('name').replace('internal', 'custom')+'"]').val('');
        }
    });

}

function repeater_delete(repeater_id, row_id) {
    $("#"+repeater_id+"_"+row_id).remove();
}

function update_inputs_blocks_hide() {
    $('#id_brand_id').val($('#select_brand_id').val());
    $('#id_country_id').val($('#select_country_id').val());
    $('#id_language_id').val($('#select_language_id').val());
}

function update_selects_country_language(selectUpdate, search_id, optionDefault) {
    $.ajax({
        url: route('admin.blocks.selecFiltersUpdate'),
        dataType: 'json',
        type: 'POST',
        data: {select: selectUpdate, search_id: search_id},
        beforeSend: function () {
            $('#select_language_id')
                .find('option')
                .remove()
                .end()
                .append('<option selected="selected" value="">'+optionDefault+'</option>');

            if(selectUpdate === 'country'){
                $('#select_country_id')
                    .find('option')
                    .remove()
                    .end()
                    .append('<option selected="selected" value="">'+optionDefault+'</option>');
            }
        },
        success: function(r) {
            $.each(r, function(key,value) {
                $('#select_'+selectUpdate+'_id')
                    .append('<option value="'+key+'">'+value+'</option>');
            });
        }
    });
};

function validateFilters(filters, button) {
    var isValid = true;
    for (var i = 0; i < filters.length; i++) {
        if (filters[i].val() === '') {
            isValid = false;
            break;
        }
    }
    (isValid) ? button.attr('disabled', false) : button.attr('disabled', true);
}

function initFilters(filters, button) {
    for (var i = 0; i < filters.length; i++) {
        filters[i].change(function () {
            validateFilters(filters, button);
        });
    }
    validateFilters(filters, button);
}
