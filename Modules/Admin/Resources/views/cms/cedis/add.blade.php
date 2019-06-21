<h1> {{trans('admin::cedis.add.new')}}</h1>
<p class="text-right"><a href="{{ route('admin.cedis.index') }}">{{trans('admin::brand.form_add.back_list')}}</a></p>

<form id="form-cedis" method="POST" action="{{ route('admin.cedis.save') }}">
    {{ csrf_field() }}
    <style>.required{color:red;font-weight:bold;}</style>

    <div id="messages">
        @if (session()->exists('success'))
            <div class="alert alert-success alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                {{ session()->get('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>

    <!-- Global name -->
    <fieldset class="fieldset_gray">
        <div class="row">
            <div class="col-xs-12">
                <label class="control-label">{{ trans('admin::shopping.products.index.thead-product-global_name') }}</label><span class="required">*</span>
                <input type="text" name="global_name" class="form-control" required="required" value="{{ old('global_name') }}">
            </div>
        </div>
    </fieldset>

    <hr class="hr_bold_violet">

    <!-- Country -->
    <fieldset class="fieldset_gray">
        <legend class="legend_gray">{{ trans('admin::cedis.general.country') }}</legend>

        <div class="row">
            <div class="col-xs-12">
                <label class="control-label">{{ trans('admin::cedis.add.select_country') }}</label><span class="required">*</span>
                <select name="country" class="form-control" required>
                    <option readonly></option>
                    @foreach($countries as $country)
                        <option value="{{ $country->id }}"
                            @php $langs = []; @endphp
                            @foreach ($country->languages as $lang) @php $langs[] = $lang->language->id @endphp @endforeach
                            data-langs="{{ json_encode($langs) }}"
                        >{{ $country->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </fieldset>

    <hr class="hr_bold_violet">

    <!-- General information -->
    <fieldset class="fieldset_gray">
        <legend class="legend_gray">{{ trans('admin::cedis.general.general_info') }}</legend>

        <div class="row">
            <!-- Address -->
            <div class="form-group col-xs-12 col-sm-6">
                <label class="control-label">{{ trans('admin::cedis.add.address') }}</label><span class="required">*</span>
                <input type="text" name="address" class="form-control" required="required" value="{{ old('address') }}">
            </div>

            <!-- Neighborhood -->
            <div class="form-group col-xs-12 col-sm-3">
                <label class="control-label">{{ trans('admin::cedis.add.neighborhood') }}</label>
                <input type="text" name="neighborhood" class="form-control" value="{{ old('neighborhood') }}">
            </div>

            <!-- Postal code -->
            <div class="form-group col-xs-12 col-sm-3">
                <label class="control-label">{{ trans('admin::cedis.add.postal_code') }}</label>
                <input type="text" name="postal_code" class="form-control" value="{{ old('postal_code') }}">
            </div>
        </div>

        <div class="row">
            <!-- Phone number 01 -->
            <div class="form-group col-xs-12 col-sm-3">
                <label class="control-label">{{ trans('admin::cedis.add.phone_number_01') }}</label>
                <input type="text" name="phone_number_01" class="form-control" value="{{ old('phone_number_01') }}">
            </div>

            <!-- Phone number 02 -->
            <div class="form-group col-xs-12 col-sm-3">
                <label class="control-label">{{ trans('admin::cedis.add.phone_number_02') }}</label>
                <input type="text" name="phone_number_02" class="form-control" value="{{ old('phone_number_02') }}">
            </div>

            <!-- Telemarketing -->
            <div class="form-group col-xs-12 col-sm-3">
                <label class="control-label">{{ trans('admin::cedis.add.telemarketing') }}</label>
                <input type="text" name="telemarketing" class="form-control" value="{{ old('telemarketing') }}">
            </div>

            <!-- Fax -->
            <div class="form-group col-xs-12 col-sm-3">
                <label class="control-label">{{ trans('admin::cedis.add.fax') }}</label>
                <input type="text" name="fax" class="form-control" value="{{ old('fax') }}">
            </div>
        </div>

        <div class="row">
            <!-- Email -->
            <div class="form-group col-xs-12 col-sm-6">
                <label class="control-label">{{ trans('admin::cedis.add.email') }}</label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}">
            </div>

            <!-- Latitude -->
            <div class="form-group col-xs-12 col-sm-3">
                <label class="control-label">{{ trans('admin::cedis.general.latitude') }}</label><span class="required">*</span>
                <input type="text" name="latitude" class="form-control" required="required" value="{{ old('latitude') }}">
            </div>

            <!-- Longitude -->
            <div class="form-group coñ-xs-12 col-sm-3">
                <label class="control-label">{{ trans('admin::cedis.general.longitude') }}</label><span class="required">*</span>
                <input type="text" name="longitude" class="form-control" required="required" value="{{ old('longitude') }}">
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12">
                <h3>{{ trans('admin::cedis.general.images') }}</h3>
            </div>
        </div>

        <div class="row">
            <!-- Image 01 -->
            <div class="form-group col-xs-12 col-sm-4">
                <label class="control-label">{{ trans('admin::cedis.add.image_01') }}</label><span class="required">*</span>
                <div class="input-group">
                    <input readonly id="image_01" class="img_src form-control" name="image_01" type="text" required="required" value="{{ old('image_01') }}">
                    <span class="input-group-btn">
                    <a href="{!! URL::to(config('admin.config.public').'/filemanager/dialog.php?type=1&field_id=image_01') !!}" class="btn btn-default iframe-btn">{{ trans('admin::countries.add_btn_image') }}</a>
                </span>
                </div>
                <span class="help-block">{!! FormMessage::getErrorMessage('flag') !!}</span>
            </div>

            <!-- Image 02 -->
            <div class="form-group col-xs-12 col-sm-4">
                <label class="control-label">{{ trans('admin::cedis.add.image_02') }}</label>
                <div class="input-group">
                    <input readonly id="image_02" class="img_src form-control" name="image_02" value="{{ old('image_02') }}" type="text">
                    <span class="input-group-btn">
                    <a href="{!! URL::to(config('admin.config.public').'/filemanager/dialog.php?type=1&field_id=image_02') !!}" class="btn btn-default iframe-btn">{{ trans('admin::countries.add_btn_image') }}</a>
                </span>
                </div>
                <span class="help-block">{!! FormMessage::getErrorMessage('flag') !!}</span>
            </div>

            <!-- Image 03 -->
            <div class="form-group col-xs-12 col-sm-4">
                <label class="control-label">{{ trans('admin::cedis.add.image_03') }}</label>
                <div class="input-group">
                    <input readonly id="image_03" class="img_src form-control" name="image_03" value="{{ old('image_03') }}" type="text">
                    <span class="input-group-btn">
                    <a href="{!! URL::to(config('admin.config.public').'/filemanager/dialog.php?type=1&field_id=image_03') !!}" class="btn btn-default iframe-btn">{{ trans('admin::countries.add_btn_image') }}</a>
                </span>
                </div>
                <span class="help-block">{!! FormMessage::getErrorMessage('flag') !!}</span>
            </div>
        </div>

        <div class="row">
            <!-- Banner's link -->
            <div class="form-group col-xs-12 col-sm-12">
                <label class="control-label">{{ trans('admin::cedis.add.banner_link') }}</label>
                <input type="url" name="banner_link" class="form-control" value="{{ old('banner_link') }}">
            </div>
        </div>
    </fieldset>

    <hr class="hr_bold_violet">

    <!-- Fields by language -->
    <div class="row">
        <div class="col-md-12">
            <div>
                <h3>{{ trans('admin::language.lang_add_trans') }}</h3>
                <p class="text-danger" style="font-style: italic;">{{ trans('admin::control.traslates') }}</p>

                @foreach ($languages as $i => $language)
                    <div data-lang="{{ $language->id }}" role="panel-group" id="accordion-{{ $language->id }}" role="tablist" aria-multiselectable="true">
                        <input data-key="lang" type="hidden" value="{{ $language->locale_key }}">

                        <div class="panel panel-default">
                            <div role="tab" class="panel-heading" id="head-{{ $language->id }}">
                                <h4 class="panel-title">
                                    <a aria-expanded="true" aria-controls="#control-language-{{ $language->id }}" role="button" class="accordion-toggle" data-toggle="collapse" data-parent="#accordion-{{ $language->id }}" href="#control-language-{{ $language->id }}">{{trans('admin::language.country-language-title') . $language->language }}</a>
                                </h4>
                            </div>
                            <div aria-labelledby="head-{{ $language->id }}" role="tabpanel" data-parent="#accordion-{{ $language->id }}" id="control-language-{{ $language->id }}" class="panel-collapse {{ ($language->id == Session::get('language') ? 'collapse in' : 'collapse') }}" >
                                <div class="panel-body">
                                    <div class="col-xs-12">
                                        <h3>{{ $language->language }}</h3>
                                    </div>

                                    <!-- Name -->
                                    <div class="form-group col-xs-12 col-sm-6">
                                        <label class="control-label">{{ trans('admin::cedis.general.name') }}</label><span class="required">*</span>
                                        <!--required="required"-->
                                        <input type="text" name="translate[{{ $language->locale_key }}][name]" class="form-control" value="{{ old('translate['.$language->locale_key .'][name]') }}">
                                    </div>

                                    <!-- Description -->
                                    <div class="form-group col-xs-12 col-sm-6">
                                        <label class="control-label">{{ trans('admin::cedis.add.description') }}</label>
                                        <!--required="required"-->
                                        <textarea class="form-control" name="translate[{{ $language->locale_key }}][description]" rows="8">{{ old('translate['.$language->locale_key .'][description]') }}</textarea>
                                    </div>

                                    <!-- State -->
                                    <div class="form-group col-xs-12 col-sm-6">
                                        <label class="control-label">{{ trans('admin::cedis.add.state') }}</label><span class="required">*</span>
                                        <!--required="required"-->
                                        <select data-lang="{{ $language->locale_key }}" name="translate[{{ $language->locale_key }}][state]" class="form-control select-state">
                                            <option value=""></option>
                                        </select>
                                        <input type="hidden" name="translate[{{ $language->locale_key }}][state_name]">
                                    </div>

                                    <!-- City -->
                                    <div class="form-group col-xs-12 col-sm-6">
                                        <label class="control-label">{{ trans('admin::cedis.add.city') }}</label><span class="required">*</span>
                                        <!--required="required"-->
                                        <select data-lang="{{ $language->locale_key }}" name="translate[{{ $language->locale_key }}][city]" class="form-control select-city">
                                            <option value=""></option>
                                        </select>
                                        <input type="hidden" name="translate[{{ $language->locale_key }}][city_name]">
                                    </div>

                                    <!-- Schedule -->
                                    <div class="form-group col-xs-12 col-sm-12">
                                        <label class="control-label">{{ trans('admin::cedis.add.schedule') }}</label><span class="required">*</span>
                                        <!--required="required"-->
                                        <input type="text" name="translate[{{ $language->locale_key }}][schedule]" class="form-control" value="{{ old('translate['.$language->locale_key .'][schedule]') }}">
                                    </div>

                                    <!-- Banner -->
                                    <div class="form-group col-xs-12 col-sm-12">
                                        <label class="control-label">{{ trans('admin::cedis.add.banner') }}</label>
                                        <div class="input-group">
                                            <input id="banner_{{ $language->locale_key }}" class="img_src form-control" name="translate[{{ $language->locale_key }}][banner]" value="{{ old('banner') }}" type="text">
                                            <span class="input-group-btn">
                                                <a href="{!! URL::to(config('admin.config.public').'/filemanager/dialog.php?type=1&field_id=banner_'.$language->locale_key) !!}" class="btn btn-default iframe-btn">{{ trans('admin::countries.add_btn_image') }}</a>
                                            </span>
                                        </div>
                                        <span class="help-block">{!! FormMessage::getErrorMessage('flag') !!}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <hr>

    @if (Auth::action('cedis.add'))
        <div class="row">
            <div class="col-xs-12">
                <button id="save-cedis" type="submit" class="btn btn-primary pull-right">
                    {{ trans('admin::cedis.general.save') }}
                </button>
            </div>
        </div>
    @endif
</form>

@section('scripts')
<script>
    /**
     *  Funciones de ayuda
     **/
    function validate_empty_fields() {
        var n_langs_filled = 0;

        $.each($('[data-key=lang]'), function (index, field) {
            if (are_not_empty_fields_from_lang($(field).val())) {
                n_langs_filled++;
            }
        });

        return n_langs_filled > 0;
    }

    function are_not_empty_fields_from_lang(lang) {
        if (($('[name="translate['+lang+'][name]"]').val()       != '' && $('[name="translate['+lang+'][name]"]').val()       != null) &&
            ($('[name="translate['+lang+'][state]"]').val()      != '' && $('[name="translate['+lang+'][state]"]').val()      != null) &&
            ($('[name="translate['+lang+'][state_name]"]').val() != '' && $('[name="translate['+lang+'][state_name]"]').val() != null) &&
            ($('[name="translate['+lang+'][city]"]').val()       != '' && $('[name="translate['+lang+'][city]"]').val()       != null) &&
            ($('[name="translate['+lang+'][city_name]"]').val()  != '' && $('[name="translate['+lang+'][city_name]"]').val()  != null) &&
            ($('[name="translate['+lang+'][schedule]"]').val()   != '' && $('[name="translate['+lang+'][schedule]"]').val()   != null)
        ) {
            return true;
        }

        return false;
    }

    function get_message_panel(message, type) {
        $('#save-cedis').prop('disabled', false);
        return '<div class="alert alert-'+type+' alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'+message+'</div>';
    }

    $(document).ready(function () {
        /** Configuración inicial
         **/
        load_editor_js();

        /** Ocultar todas las tabs de idiomas
         **/
        $('[role=panel-group]').hide();

        /** Mostramos los idiomas y cargamos los estados del país seleccionado
         **/
        $('[name=country]').change(function () {
            var langs   = $(this).find(":selected").data('langs');
            var message = '';

            $.ajax({
                url: '{{ route('admin.cedis.getStates') }}',
                method: 'POST',
                data: {country_id: $(this).val()},
                dataType: 'JSON',
                statusCode: { 419: function() {window.location.href = '{{ route('admin.home') }}'} }
            }).done(function (response, textStatus, jqXHR) {
                $.each(response.data, function (country_id, info) {
                    $('.help-block.state').remove();
                    $('[name="translate['+info.lang+'][state]"]').parent().removeClass('has-error');

                    if (info.corbiz.status) {
                        $('[name="translate['+info.lang+'][state]"]').children('option').remove();
                        $('[name="translate['+info.lang+'][state]"]').append($('<option>', {value: '', text: ''}));
                        $.each(info.corbiz.data, function (i, state) {
                            $('[name="translate['+info.lang+'][state]"]').append($('<option>', {value: state.idState, text: state.stateDescr}));
                        });
                    } else {
                        if (info.corbiz.messages.length > 1) {
                            $.each(info.corbiz.messages, function (i, msg) {
                                message += (msg.concat((i == info.corbiz.messages.length -1) ? '' : '<br>')) ;
                            });
                        } else {
                            message = info.corbiz.messages[0];
                        }

                        $('[name="translate['+info.lang+'][state]"]').children('option').remove();
                        $('[name="translate['+info.lang+'][state]"]').parent().append('<span class="help-block state">'+message+'</span>');
                        $('[name="translate['+info.lang+'][state]"]').parent().addClass('has-error');
                    }
                });
            }).fail(function (response, textStatus, errorThrown) {
                console.log(response, textStatus, errorThrown);
            });

            $('[role=panel-group]').show();
            $('[role=tabpanel]').removeClass('in');

            $.each($('[role=panel-group]'), function (i, tab) {
                if (langs.indexOf($(tab).data('lang')) == -1) {
                    $(tab).hide();
                }
            });

            $('[role=panel-group]:visible .panel-collapse.collapse').first().collapse('show');
        });

        /** Cargamos las ciudades y estados según la opción seleccionada
         **/
        var select_state = $('.select-state');
        select_state.change(function () {
            var lang    = $(this).data('lang');
            var country = $('[name=country]').val();
            var state   = $(this).val();
            var message = '';

            $.ajax({
                url: '{{ route('admin.cedis.getCities') }}',
                method: 'POST',
                data: {country_id: country, state_key: state, lang: lang},
                dataType: 'JSON',
                statusCode: { 419: function() {window.location.href = '{{ route('admin.home') }}'} },
                beforeSend: function () {
                    $.each($('[role=panel-group]:visible .select-city'), function (i, select) {
                        $('[name="translate['+$(select).data('lang')+'][city]"]').children('option').remove();
                    });
                }
            }).done(function (response, textStatus, jqXHR) {
                if (response.data.corbiz.status) {
                    $('.help-block.city').remove();

                    $.each($('[role=panel-group]:visible .select-city'), function (i, select) {
                        $('[name="translate['+$(select).data('lang')+'][city]"]').parent().removeClass('has-error');
                        $.each(response.data.corbiz.data, function (i, city) {
                            $('[name="translate['+$(select).data('lang')+'][city]"]').append($('<option>', {value: city.idCity, text: city.cityDescr}));
                            if (i == 0) { $('[name="translate['+$(select).data('lang')+'][city_name]"]').val(city.cityDescr); }
                        });
                    });
                } else {
                    if (response.data.corbiz.messages.length > 1) {
                        $.each(response.data.corbiz.messages, function (i, msg) {
                            message += (msg.concat((i == response.data.corbiz.messages.length -1) ? '' : '<br>')) ;
                        });
                    } else {
                        message = response.data.corbiz.messages[0];
                    }

                    $.each($('[role=panel-group]:visible .select-city'), function (i, select) {
                        $('[name="translate['+$(select).data('lang')+'][city]"]').parent().append('<span class="help-block city">'+message+'</span>');
                        $('[name="translate['+$(select).data('lang')+'][city]"]').parent().addClass('has-error');
                    });
                }
            }).fail(function (response, textStatus, errorThrown) {
                console.log(response, textStatus, errorThrown);
            });
        });
        select_state.click(function () {
            var name = $(this).find(':selected').text();
            var val  = $(this).val();

            $.each($('[role=panel-group]:visible .select-state'), function (i, select) {
                var lang = $(select).data('lang');

                $('[name="translate['+lang+'][state_name]"]').val(name);
                $('[name="translate['+lang+'][state]"]').val(val);
            });
        });

        $('.select-city').click(function () {
            var name = $(this).find(':selected').text();
            var val  = $(this).val();

            $.each($('[role=panel-group]:visible .select-city'), function (i, select) {
                var lang = $(select).data('lang');

                $('[name="translate['+lang+'][city_name]"]').val(name);
                $('[name="translate['+lang+'][city]"]').val(val);
            });
        });

        /** Validación antes de enviar el formulario
         **/
        $('#form-cedis').submit(function () {
            $('#save-cedis').prop('disabled', true);

            if (validate_empty_fields()) {
                return true;
            }

            $('#messages').html(get_message_panel('{!! trans("admin::cedis.add.empty_lang_fields") !!}', 'danger'));
            window.location.hash = '#messages';
            return false;
        });
    });
</script>
@endsection