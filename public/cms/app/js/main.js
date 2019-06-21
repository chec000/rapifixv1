$(document).ready(function() {
      load_editor_js();
    $.ajaxPrefilter(function (options, originalOptions, xhr) { // this will run before each request
        var token = $('meta[name="_token"]').attr('content');
        if (token) {
            return xhr.setRequestHeader('X-CSRF-TOKEN', token);
        }
    });
    $('.itemTooltip').tooltip({placement : 'bottom', container: 'body'});
});

$("#form-search").submit(function(e){
    e.preventDefault();
    var name = $("#name").val();
    if (name !== null) {
        searchPages(name);
    }
});

function searchPages(name) {
    var url = $("#form-search").attr("action");
    var brand = $("#select_brand_id").val();
    var country = $("#select_country_id").val();
    var language = $("#select_language_id").val();
    if (brand !== null && country !== null && language !== null) {
        $.ajax({
            type: 'POST',
            url: url,
            data: {
                brand_id: brand,
                country_id: country,
                language_id: language,
                name: name
            },
            success: function(r) {
                if (r.code === 200) {
                    $("#panel").css('display', 'block');
                    $('#sort-wrap').html(r.data);
                } else {
                    $('#sort-wrap').html(r.data);
                }
            }
        });
    }
}

function select_country_combo(traslate,brand_id,country_id,language_id) {
    if (brand_id !== null) {
        $.ajax({
            url: route('admin.blocks.selecFiltersUpdate'),
            dataType: 'json',
            type: 'POST',
            data: {
                select: 'country',
                search_id: brand_id
            },
            success: function(r) {
                $('#select_country_id')
                    .find('option')
                    .remove()
                    .end()
                    .append('<option selected="selected" value="">' + traslate + '</option>');
                $.each(r, function(key, value) {
                    if (parseInt(key) === country_id) {
                        $('#select_country_id').append('<option selected value="' + key + '">' + value + '</option>');
                    } else {
                        $('#select_country_id').append('<option value="' + key + '">' + value + '</option>');
                    }
                });
                select_language(country_id, language_id, traslate);
            }
        });
    }
};

function select_language(country_id, language_id, optionDefault) {
    $.ajax({
        url: route('admin.blocks.selecFiltersUpdate'),
        dataType: 'json',
        type: 'POST',
        data: {
            select: 'language',
            search_id: country_id
        },
        success: function(r) {
            $('#select_language_id')
                .find('option')
                .remove()
                .end()
                .append('<option selected="selected" value="">' + optionDefault + '</option>');
            $.each(r, function(key, value) {
                if (parseInt(key) === language_id) {
                    $('#select_language_id').append('<option selected value="' + key + '">' + value + '</option>');
                } else {
                    $('#select_language_id').append('<option value="' + key + '">' + value + '</option>');
                }
            });
            getPages();
        }
    });
};
