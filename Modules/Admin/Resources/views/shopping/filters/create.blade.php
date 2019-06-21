<div class="container">
    <a class="btn btn-info btn-sm pull-right" href="{{ route('admin.filters.index') }}" role="button">
        @lang('admin::shopping.filters.buttons.back_list')
    </a>
    @if(session('msg'))
        <div class="alert alert-success" role="alert">{{ session('msg') }}</div>
    @elseif(session('errors') != null)
        <div class="alert alert-danger" role="alert">{{ session('errors')->first('msg') }}</div>
    @endif
    <h1>{!!trans('admin::shopping.filters.view.title_add')!!}</h1>
    <form id="categories" method="POST" action="{{ route('admin.filters.store') }}">
        {{ csrf_field() }}
        <p class="lead">Brand: <strong id="brandName"></strong></p>
        <input type="hidden" name="brand_id" id="brand_id" value="">
        <input type="hidden" name="locale" id="locale" value="{{ $locale }}">
        <input type="hidden" name="countries_brand" id="countries_by_brand" value="{{ $countriesByBrand }}">

        <div class="form-group">
            <label for="global_name">{{ trans('admin::shopping.products.index.thead-product-global_name') }} *</label>
            <input type="text" name="global_name" id="global_name" class="form-control" required="required">
        </div>

        <div class="form-group">
            <label>@lang('admin::shopping.filters.view.form-country')</label><br />
            <ul id="countryForm" class="nav nav-tabs" role="tablist">
                @foreach(Auth::user()->countries as $uC)
                    <li role="presentation" data-country-tab="{{ $uC->id }}">
                        <a href="#{{ str_replace(' ', '_', $uC->name) }}" aria-controls="home" role="tab" data-toggle="tab">
                            {{ $uC->name }} <i class="fa fa-caret-square-o-down" aria-hidden="true"></i>
                        </a>
                    </li>
                @endforeach
            </ul>
            <div class="tab-content">
                @foreach(Auth::user()->countries as $uC)
                    <div role="tabpanel" class="tab-pane" id="{{ str_replace(' ', '_', $uC->name) }}" data-country-pane="{{ $uC->id }}"> <br />
                        @foreach(Auth::user()->getCountryLang($uC->id) as $langCountry)
                            <div role="panel-group" id="accordion-{{ $uC->id }}-{{ $langCountry->id }}">
                                <div class="panel panel-default">
                                    <div role="tab" class="panel-heading">
                                        <h4 class="panel-title">
                                            <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion"
                                               href="#product-language-{{ $uC->id }}-{{ $langCountry->id }}">
                                                {{trans('admin::shopping.products.add.second_general_tab.country-language-title') . $langCountry->language }}
                                            </a>
                                        </h4>
                                    </div>
                                    <div role="tabpanel" data-parent="#accordion" class="panel-collapse collapse"
                                         id="product-language-{{ $uC->id }}-{{ $langCountry->id }}" >
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label>@lang('admin::shopping.filters.input.label.filter') *</label>
                                                        <input name="filter[{{ $uC->id }}][{{ $langCountry->id }}]"
                                                               type="text" rel="requerido_{{ $uC->id }}"
                                                               class="requerido requerido_{{ $uC->id }} requerido_{{ $uC->id }}_{{ $langCountry->id }} form-control"
                                                               id="requerido_{{ $uC->id }}_{{ $langCountry->id }}"
                                                               placeholder="@lang('admin::shopping.filters.input.placeholder.filter')"
                                                               value="{{ old('filter['.$uC->id.']['.$langCountry->id.']') }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        <hr />
                        <div class="form-group">
                            <label>@lang('admin::shopping.filters.input.label.active')</label>
                            <div class="radio">
                                <label>
                                    <input type="radio" name="active[{{ $uC->id }}]" value="1" @if(old('active_'.$uC->id) == null || old('active_'.$uC->id)) checked @else '' @endif>
                                    @lang('admin::shopping.filters.input.placeholder.yes')
                                </label>
                            </div>
                            <div class="radio">
                                <label>
                                    <input type="radio" name="active[{{ $uC->id }}]" value="0" {{ old('active_'.$uC->id) === 0 ? ' checked' : '' }}>
                                    @lang('admin::shopping.filters.input.placeholder.no')
                                </label>
                            </div>
                        </div>
                        <br />
                    </div>
                @endforeach
            </div>
        </div>
        <div class="form-group text-center">
            <button type="submit" id="formCategoryButton" class="btn btn-default">
                <span class="btn-submit-text">@lang('admin::shopping.filters.buttons.save')</span>
                <span class="btn-submit-spinner" style="display: none"><i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i></span>
            </button>
        </div>
    </form>
</div>
@section('scripts')
    <script type="text/javascript">
        function deleteTabsFromAnotherCountry(brandId) {
            var countriesByBrand = jQuery.parseJSON($('#countries_by_brand').val());
            countriesByBrand = countriesByBrand[brandId];
            $.each($('[data-country-tab]'), function (i, element) {
                if (countriesByBrand.indexOf($(element).data('country-tab')) == -1) { $(element).remove(); }
            });
            $.each($('[data-country-pane]'), function (i, element) {
                if (countriesByBrand.indexOf($(element).data('country-pane')) == -1) { $(element).remove(); }
            });
        }
        function deleteTabsFromUnselectedCountries() {
            countriesToCreate = [];
            $.each($('.form-check-input:checked'), function (i, checkbox) {
                countriesToCreate.push(parseInt($(checkbox).val()));
            });
            $("#countries_by_brand").val(countriesToCreate);
            $.each($('[data-country-tab]'), function (i, element) {
                if (countriesToCreate.indexOf($(element).data('country-tab')) == -1) { $(element).remove(); }
            });
            $.each($('[data-country-pane]'), function (i, element) {
                if (countriesToCreate.indexOf($(element).data('country-pane')) == -1) { $(element).remove(); }
            });
            $("#countryForm li a:first").click();
            $(".accordion-toggle:first").click();
        }
        function generateCountryCheckbox(countryId, languages, name) {
            return '<div data-country-checkbox="'+countryId+'" name="check-countries">\
                <input class="form-check-input" id="checkCountry_'+countryId+'" value="'+countryId+'" type="checkbox">\
                <input id="country-langs-'+countryId+'" value="'+languages+'" type="hidden">\
                <label for="checkCountry_'+countryId+'" id="label-langsCountry_'+countryId+'" class="form-check-label">'+name+'</label>\
                </div>';
        }
        // Obtener los paises por marca
        function showCountriesByBrand(brand) {
            $.ajax({
                url: '{{ route('admin.categories.getcountries') }}',
                dataType: 'JSON',
                method: 'POST',
                data: {brand_id: brand},
                statusCode: { 419: function() {window.location.href = '{{ route('admin.home') }}'} }
            }).done(function (response, textStatus, jqXHR) {
                if (response.status) {
                    $('[data-country-checkbox]').remove();
                    $.each(response.countriesByBrand, function (i, country) {
                        $('#products-check-countries').append(generateCountryCheckbox(country.id, country.languages, country.name));
                    });
                }
            }).fail(function (response, textStatus, errorThrown) {
                console.log(response, textStatus, errorThrown);
            });
        }
        $( document ).ready(function() {
            load_editor_js();

            $('#brand-modal').modal({
                show: true,
                keyboard: false,
                backdrop: 'static',
            });
            $('#close-modal').click(function () {
                history.go(-1);
            });
            $('#accept-modal').click(function () {
                var brandId = $('[name="brand-user"]:checked').val();
                $('#brand_id').val( brandId );
                $('#brandName').text( $('[name="brand-user"]:checked').data('name') );

                if(brandId != undefined && $('.form-check-input').is(':checked')){
                    $('#brand-modal').modal('hide');
                    deleteTabsFromUnselectedCountries();
                }else{
                    $('#error-modal').show();
                }
            });

            // Si ya se encuentra una marca seleccionada, mostrar sus paises
            if ($('[name="brand-user"]:checked').val() != undefined && $('[name="brand-user"]:checked').val() != '') {
                showCountriesByBrand($('[name="brand-user"]:checked').val());
            }

            $('[name="brand-user"]').change(function () {
                showCountriesByBrand($(this).val());
            });
        });

        $( "#categories" ).submit(function( event )
        {
            $('.btn-submit-text').hide();
            $('.btn-submit-spinner').show();
            $('.alert-info-input').hide();
            $('#formCategoryButton').prop('disabled', true);

            var banderaFinal = 2;
            var exit = 1;
            $('.requerido').each(function(i, elem)
            {
                var nameClass = '.'+$(elem).attr('rel');
                var banderaLang = 0;
                var banderaCountry = 0;
                $(nameClass).each(function(i1, elem1)
                {
                    var nameId = '.'+$(elem1).attr('id');
                    var inputLang = 0;
                    var contLang = 0;
                    $(nameId).each(function(i2, elem2)
                    {
                        contLang ++;
                        if($(elem2).val() != ''){
                            $(elem2).css({'border':'1px solid #ccc'});
                            inputLang ++;
                        } else {
                            $(elem2).css({'border':'1px solid red'});
                        }
                    });
                    if(inputLang == contLang){
                        banderaLang = 1;
                    }
                    if(banderaLang == 1){
                        banderaCountry = 1;
                    }
                });
                if(banderaFinal == 2 || banderaFinal == 1){
                    if (banderaCountry == 1 && banderaLang == 1){
                        exit = 0;
                        banderaFinal = 1;
                    }else{
                        exit = 1;
                        banderaFinal = 0;
                    }
                }else{
                    exit == 1;
                }
            });
            if(exit == 1){
                event.preventDefault();
                $('.alert-info-input').show();
                $('.btn-submit-text').show();
                $('.btn-submit-spinner').hide();
                $('#formCategoryButton').prop('disabled', false);
            }
        });
    </script>
@endsection