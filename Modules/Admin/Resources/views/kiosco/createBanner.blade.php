<div class="container">
    <a class="btn btn-info btn-sm pull-right" href="{{ route('admin.kiosco.index') }}" role="button">
        @lang('admin::shopping.confirmationbanners.index.btn_return')
    </a>
    @if(session('msg'))
        <div class="alert alert-success" role="alert">{{ session('msg') }}</div>
    @elseif(session('errors') != null)
        <div class="alert alert-danger" role="alert">{{ session('errors')->first('msg') }}</div>
    @endif
    <h1>{!!trans('admin::shopping.confirmationbanners.add.view.title-add')!!}</h1>
    <form id="confirmation" method="POST" action="{{ route('admin.kiosco.addBanners') }}">
        {{ csrf_field() }}
        <input type="hidden" name="confirmation_id" id="confirmation_id" value="">
        <input type="hidden" name="locale" id="locale" value="{{ $locale }}">
        <input type="hidden" id="countries_by_brand" value="{{ $countriesUser }}">
        <div class="form-group">
            <label for="exampleInputEmail1">@lang('admin::shopping.confirmationbanners.add.view.form-country')</label>
            <br />
            <ul id="countryForm" class="nav nav-tabs" role="tablist">
                @foreach(Auth::user()->countries as $uC)
                    <li role="presentation" data-country-tab="{{ $uC->id }}">
                        <a href="#{{ str_replace(" ","_",$uC->name) }}" aria-controls="home" role="tab" data-toggle="tab">
                            {{ $uC->name }} <i class="fa fa-caret-square-o-down" aria-hidden="true"></i>
                        </a>
                    </li>
                @endforeach
            </ul>
            <div class="tab-content">
                @foreach(Auth::user()->countries as $uC)
                    <div role="tabpanel" class="tab-pane" id="{{ str_replace(" ","_",$uC->name) }}" data-country-pane="{{ $uC->id }}"> <br />
                        <div class="form-group">
                            <label for="link">{{ trans('admin::shopping.confirmationbanners.index.link') }}</label>
                            <input type="text" name="link_{{ $uC->id }}" id="link_{{ $uC->id }}" class="form-control">
                        </div>
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
                                                        <label for="exampleInputEmail1">@lang('admin::shopping.confirmationbanners.add.input.image')*</label>
                                                        <div class="input-group">
                                                            <input type="hidden" name="id_country" value="{{$uC->id}}">
                                                            <input name="image_{{ $uC->id }}_{{ $langCountry->id }}"
                                                                   rel="requerido_{{ $uC->id }}"
                                                                   class="requerido requerido_{{ $uC->id }} requerido_{{ $uC->id }}_{{ $langCountry->id }} form-control"
                                                                   id="requerido_{{ $uC->id }}_{{ $langCountry->id }}"
                                                                   value="{{ old('image_'.$uC->id.'_'.$langCountry->id) }}">
                                                            <span class="input-group-btn">
                                                                <a href="{!! URL::to(config('admin.config.public') . '/filemanager/dialog.php?type=1&field_id=requerido_'.$uC->id.'_'.$langCountry->id) !!}"
                                                                   class="btn btn-default iframe-btn">
                                                                    {{ trans('admin::countries.add_btn_image') }}
                                                                </a>
                                                            </span>
                                                        </div>
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
                            <label for="exampleInputEmail1">@lang('admin::shopping.confirmationbanners.add.view.form-active')</label>
                            <div class="radio">
                                <label>
                                    <input type="radio" name="active_{{ $uC->id }}" value="1" @if(old('active_'.$uC->id) == null || old('active_'.$uC->id)) checked @else '' @endif>
                                    @lang('admin::shopping.confirmationbanners.add.input.yes')
                                </label>
                            </div>
                            <div class="radio">
                                <label>
                                    <input type="radio" name="active" value="0" {{ old('active_'.$uC->id) === 0 ? ' checked' : '' }}>
                                    @lang('admin::shopping.confirmationbanners.add.input.no')
                                </label>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="form-group text-center">
            <div class="alert alert-danger alert-info-input" role="alert" style="display: none">
                @lang('admin::shopping.confirmationbanners.add.view.form-error')
            </div>
            <button type="submit" id="formConfirmationButton" class="btn btn-default">
                <span class="btn-submit-text">@lang('admin::shopping.confirmationbanners.add.view.form-save-button')</span>
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

        // Eliminar las tabs de los paises que no fueron seleccionados
        function deleteTabsFromUnselectedCountries() {
            countriesToCreate = [];
            $.each($('.form-check-input:checked'), function (i, checkbox) {
                countriesToCreate.push(parseInt($(checkbox).val()));
            });

            $.each($('[data-country-tab]'), function (i, element) {
                if (countriesToCreate.indexOf($(element).data('country-tab')) == -1) { $(element).remove(); }
            });

            $.each($('[data-country-pane]'), function (i, element) {
                if (countriesToCreate.indexOf($(element).data('country-pane')) == -1) { $(element).remove(); }
            });
        }

        //Para permitiri sólo un checked.
        $('.js-check-country').on('click', function () {
            $('.js-check-country').prop('checked', false);
            $(this).prop('checked', true);
        });

        // Activar el botón para continuar con el formulario
        function enableNextButton() {
            let enable = false;

            $.each($('.js-check-country'), function (i, check) {
                if ($(check).is(':checked')) {
                    enable = true;
                }
            });

            if (enable) {
                $('#accept-modal').removeClass('disabled');
            } else {
                $('#accept-modal').addClass('disabled');
            }
        }

        $( document ).ready(function() {
            load_editor_js();
            $("#countryForm li a:first").click();
            $(".accordion-toggle:first").click();

            // Inactivar el botón para continuar con el llenado del formulario
            $('#accept-modal').addClass('disabled');

            // Modal para seleccionar la marca
            $('#countries-modal').modal({
                show: true,
                keyboard: false,
                backdrop: 'static',
            });

            // Acción para cancelar el formulario
            $('#close-modal').click(function () {
                history.go(-1);
            });

            // Acción una vez seleccionada la marca y el país
            $('#accept-modal').click(function () {
                var selectedCountry = false;
                $.each($('.form-check-input'), function (i, check) {
                    if ($(check).is(':checked')) {
                        selectedCountry = true;
                    }
                });

                if (selectedCountry != false) {
                    $('#countries-modal').modal('hide');
                    //deleteTabsFromAnotherCountry(brandId);
                    deleteTabsFromUnselectedCountries();
                }
            });
        });
        //formulario de envio al controlador
        $( "#confirmation" ).submit(function( event ) {
            $('.btn-submit-text').hide();
            $('.btn-submit-spinner').show();
            $('.alert-info-input').hide();
            $('#formConfirmationButton').prop('disabled', true);

            var exit = 1;
            var banderaFinal = 2;

            $('.requerido').each(function(i, elem) {
                var      nameClass = '.'+$(elem).attr('rel');
                var    banderaLang = 0;
                var banderaCountry = 0;
                $(nameClass).each(function(i1, elem1) {
                    var nameId = '.'+$(elem1).attr('id');
                    var inputLang = 0;
                    var contLang = 0;

                    $(nameId).each(function(i2, elem2) {
                        contLang ++;
                        var elemtTiny = $(elem2).val();
                        if (elemtTiny != '') {
                            $(elem2).css({'border':'1px solid #ccc'});
                            inputLang ++;
                        } else {
                            $(elem2).css({'border':'1px solid red'});
                        }
                    });

                    if (inputLang == contLang) {
                        banderaLang = 1;
                    }
                    if (banderaLang == 1) {
                        banderaCountry = 1;
                    }
                });
                if (banderaFinal == 2 || banderaFinal == 1) {
                    if (banderaCountry == 1 && banderaLang == 1) {
                        exit = 0;
                        banderaFinal = 1;
                    } else {
                        exit = 1;
                        banderaFinal = 0;
                    }
                } else {
                    exit == 1;
                }
            });
            if(exit == 1){
                event.preventDefault();
                $('.alert-info-input').show();
                $('.btn-submit-text').show();
                $('.btn-submit-spinner').hide();
                $('#formConfirmationButton').prop('disabled', false);
            }
        });
    </script>

@endsection
