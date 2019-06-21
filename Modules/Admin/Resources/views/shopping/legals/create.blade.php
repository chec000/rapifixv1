@section('styles')
@endsection
<div class="container">
    <a class="btn btn-info btn-sm pull-right" href="{{ route('admin.legals.index') }}" role="button">
        @lang('admin::shopping.legals.index.btn_return')
    </a>
    @if(session('msg'))
        <div class="alert alert-success" role="alert">{{ session('msg') }}</div>
    @elseif(session('errors') != null)
        <div class="alert alert-danger" role="alert">{{ session('errors')->first('msg') }}</div>
    @endif
    <h1>{!!trans('admin::shopping.legals.add.view.title-add')!!}</h1>
    <form id="legals" method="POST" action="{{ route('admin.legals.store') }}" enctype="multipart/form-data">
        {{ csrf_field() }}
        <input type="hidden" name="legal_id" id="legal_id" value="" >
        <input type="hidden" name="locale" id="locale" value="{{ $locale }}">
        <input type="hidden" id="countries_by_brand" value="{{ $countriesUser }}">


        <div class="form-group">
            <label for="exampleInputEmail1">@lang('admin::shopping.legals.add.view.form-country')</label><br />

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
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="activecontract_{{ $uC->id }}" checked name="activecontract_{{ $uC->id }}">
                                <label class="form-check-label" for="exampleCheck1">@lang('admin::shopping.legals.add.input.activecontract')</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" checked id="activedisclaimer_{{ $uC->id }}" name="activedisclaimer_{{ $uC->id }}">
                                <label class="form-check-label" for="exampleCheck1">@lang('admin::shopping.legals.add.input.activedisclaimer')</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" checked id="activepolicies_{{ $uC->id }}" name="activepolicies_{{ $uC->id }}">
                                <label class="form-check-label" for="exampleCheck1">@lang('admin::shopping.legals.add.input.activepolicies')</label>
                            </div>

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
                                                    <!--Form group comentado para cambiarlo por ruta de archivo-->
                                                    <!-- div class="form-group">
                                                        <label for="exampleInputEmail1">@lang('admin::shopping.legals.add.input.contract')*</label>
                                                        <textarea name="contract_{{ $uC->id }}_{{ $langCountry->id }}"
                                                                  rel="requerido_tiny_{{ $uC->id }}"
                                                                  src = "requerido_tiny_{{ $uC->id }}_{{ $langCountry->id }}"
                                                                  class="requerido_tiny requerido_tiny_{{ $uC->id }} requerido_tiny_{{ $uC->id }}_{{ $langCountry->id }} form-control tin"
                                                                  id="requerido_tiny_{{ $uC->id }}_{{ $langCountry->id }}"
                                                                  rows="3"
                                                                  placeholder="@lang('admin::shopping.legals.add.input.contract')"
                                                        >
                                                            {{ old('contract_'.$uC->id.'_'.$langCountry->id) }}
                                                        </textarea>
                                                    </div -->
                                                    <div class="form-group">

                                                        <span class="fa fa2x fa-info-circle" style="cursor: pointer;" data-toggle="modal" onclick="openInstructions('terms')">
                                                            @lang('admin::shopping.legals.add.input.exampleterms')
                                                        </span><br>
                                                        <label for="exampleInputEmail1">@lang('admin::shopping.legals.add.input.contract')*</label>
                                                        <div class="input-group">
                                                            <input name="contract_{{ $uC->id }}_{{ $langCountry->id }}"
                                                                   rel="requerido_{{ $uC->id }}"
                                                                   src = "requerido_{{ $uC->id }}_{{ $langCountry->id }}"
                                                                   class="requerido requerido_{{ $uC->id }} requerido_{{ $uC->id }}_{{ $langCountry->id }} form-control pdfvalidated"
                                                                   id="test_{{ $uC->id }}_{{ $langCountry->id }}"
                                                                   value="{{ old('contract_'.$uC->id.'_'.$langCountry->id) }}">
                                                            <span class="input-group-btn">
                                                                <a href="{!! URL::to(config('admin.config.public') . '/filemanager/dialog.php?type=2&field_id=test_'.$uC->id.'_'.$langCountry->id) !!}"
                                                                   class="btn btn-default iframe-btn">
                                                                    {{ trans('admin::shopping.legals.add.input.btn-pdf') }}
                                                                </a>
                                                            </span>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">

                                                            <span class="fa fa2x fa-info-circle" style="cursor: pointer;" data-toggle="modal" onclick="openInstructions('contract')">
                                                                @lang('admin::shopping.legals.add.input.examplecontract')
                                                            </span><br>
                                                            <label for="exampleInputEmail1">@lang('admin::shopping.legals.add.input.contract-pdf')*</label>
                                                            <div class="input-group">
                                                                <input name="contractpdf_{{ $uC->id }}_{{ $langCountry->id }}"
                                                                       rel="requerido_{{ $uC->id }}"
                                                                       src = "requerido_{{ $uC->id }}_{{ $langCountry->id }}"
                                                                       class="requerido requerido_{{ $uC->id }} requerido_{{ $uC->id }}_{{ $langCountry->id }} form-control pdfvalidated"
                                                                       id="test1_{{ $uC->id }}_{{ $langCountry->id }}"
                                                                       value="{{ old('contractpdf_'.$uC->id.'_'.$langCountry->id) }}">
                                                                <span class="input-group-btn">
                                                                    <a href="{!! URL::to(config('admin.config.public') . '/filemanager/dialog.php?type=2&field_id=test1_'.$uC->id.'_'.$langCountry->id) !!}"
                                                                       class="btn btn-default iframe-btn">
                                                                        {{ trans('admin::shopping.legals.add.input.btn-pdf') }}
                                                                    </a>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    <div class="form-group">

                                                        <label for="exampleInputEmail1">@lang('admin::shopping.legals.add.input.terms-pdf')*</label>
                                                        <div class="input-group">
                                                            <input name="termspdf_{{ $uC->id }}_{{ $langCountry->id }}"
                                                                   rel="requerido_{{ $uC->id }}"
                                                                   src = "requerido_{{ $uC->id }}_{{ $langCountry->id }}"
                                                                   class="requerido requerido_{{ $uC->id }} requerido_{{ $uC->id }}_{{ $langCountry->id }} form-control pdfvalidated"
                                                                   id="test2_{{ $uC->id }}_{{ $langCountry->id }}"
                                                                   value="{{ old('termspdf_'.$uC->id.'_'.$langCountry->id) }}">
                                                            <span class="input-group-btn">
                                                                    <a href="{!! URL::to(config('admin.config.public') . '/filemanager/dialog.php?type=2&field_id=test2_'.$uC->id.'_'.$langCountry->id) !!}"
                                                                       class="btn btn-default iframe-btn">
                                                                        {{ trans('admin::shopping.legals.add.input.btn-pdf') }}
                                                                    </a>
                                                                </span>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">@lang('admin::shopping.legals.add.input.disclaimer')</label>
                                                        <textarea name="disclaimer_{{ $uC->id }}_{{ $langCountry->id }}"
                                                                  rel="requerido_{{ $uC->id }}"
                                                                  src = "requerido_{{ $uC->id }}_{{ $langCountry->id }}"
                                                                  class="form-control"
                                                                  id="requerido_{{ $uC->id }}_{{ $langCountry->id }}"
                                                                  rows="3"
                                                                  placeholder="@lang('admin::shopping.legals.add.input.disclaimer')"
                                                        >{{ old('disclaimer_'.$uC->id.'_'.$langCountry->id) }}</textarea>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- dd($langCountry)  --}}
                        @endforeach
                        <hr />

                        <div class="form-group">
                            <label for="exampleInputEmail1">@lang('admin::shopping.legals.add.view.form-active')</label>
                            <div class="radio">
                                <label>
                                    <input type="radio" name="active_{{ $uC->id }}" value="1" @if(old('active_'.$uC->id) == null || old('active_'.$uC->id)) checked @else '' @endif>
                                    @lang('admin::shopping.legals.add.input.yes')
                                </label>
                            </div>
                            <div class="radio">
                                <label>
                                    <input type="radio" name="active_{{ $uC->id }}" value="0" {{ old('active_'.$uC->id) === 0 ? ' checked' : '' }}>
                                    @lang('admin::shopping.legals.add.input.no')
                                </label>
                            </div>
                        </div>

                    </div>
                    <!-- Modal -->
                    <div class="modal fade" id="modalIndications" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <p class="pull-left">@lang('admin::shopping.legals.add.input.instructions')</p>
                                    <button type="button" class="close pull-right" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>

                                </div>
                                <div class="modal-body">
                                    <object id="obj" type="application/pdf"  data="" width="100%" height="500" style="height: 85vh;">No Support</object>

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="form-group text-center">
            <div class="alert alert-danger alert-info-input" role="alert" style="display: none">
                @lang('admin::shopping.legals.add.view.form-error')<br />
                @lang('admin::shopping.legals.add.view.form-error-pdf')
            </div>
            <button type="submit" id="formLegalButton" class="btn btn-default">
                <span class="btn-submit-text">@lang('admin::shopping.legals.add.view.form-save-button')</span>
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
            // $('.form-check-input:not(:checked)')
            // $('.form-check-input:checked')

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


        function openInstructions(type){

            switch(type){
                case 'terms' :
                    var fileLoad = '{{asset('/files/contrato-tcarta_usa_2017.pdf')}}';
                    break;
                case 'contract':
                    var fileLoad = '{{asset('/files/eng_contract.pdf')}}';
                    break;
            }

            $("#obj").attr('data',fileLoad);
            $("#modalIndications").modal('show');



        }

        // Activar el botón para continuar con el formulario
        function enableNextButton() {
            var enable = false;

            $.each($('.form-check-input'), function (i, check) {
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

            tinymce.init({
                selector: '.tin',
                theme: 'modern',
                plugins: 'preview fullpage fullscreen image table hr  lists textcolor colorpicker',
                toolbar1: 'formatselect | bold italic forecolor | link | alignleft aligncenter alignright alignjustify  | numlist bullist outdent indent',
                image_advtab: false,
                content_css: [
                    '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
                    '//www.tinymce.com/css/codepen.min.css'
                ]
            });


            $("#countryForm li a:first").click();
            $(".accordion-toggle:first").click();

            // Inactivar el botón para continuar con el llenado del formulario
            $('#accept-modal').addClass('disabled');

            /* $('.pdfvalidated').change(function() {
                alert("hanged");
                var ext = $(this).val().split('.').pop().toLowerCase();
                alert(ext);
                if ($.inArray(ext, ['pdf']) == -1) {


                    /* $('#modal-messages').html(getErrorsBlock(errors));
                    $('#upload-file').prop('disabled', true);
                    $('#file_csv').val('');
                } else {
                    //$('#upload-file').prop('disabled', false);
                }
            }); */



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
        $( "#legals" ).submit(function( event )
        {

            $('.btn-submit-text').hide();
            $('.btn-submit-spinner').show();
            $('.alert-info-input').hide();
            $('#formLegalButton').prop('disabled', true);

            var banderaFinal = 2;
            var banderaFinalTiny = 2;
            var exit_tiny = 1;
            var exit = 1;
            var validate = "<!DOCTYPEhtml><html><head></head><body></body></html>";
            /* $('.requerido_tiny').each(function(i, elem)
            {

                var nameClass = '.'+$(elem).attr('rel');
                var banderaCountryTiny = 0;
                var banderaLangTiny = 0;

                $(nameClass).each(function(i1, elem1)
                {
                    var nameId = '.'+$(elem1).attr('src');

                    var inputLangTiny = 0;
                    var contLangTiny = 0;

                    $(nameId).each(function(i2, elem2)
                    {
                        contLangTiny ++;

                        var elemtTiny = $(elem2).val();
                        var valortiny = tinyMCE.get($(elem).attr('id')).getContent();

                        if(valortiny != '' && validate != valortiny.replace(/\s/g, '')){
                            $(elem2).css({'border':'1px solid #ccc'});
                            $(elem2).siblings().css({'color':'black'});
                            inputLangTiny ++;
                        } else {
                            $(elem2).css({'border':'1px solid red'});
                            $(elem2).siblings().css({'color':'red'});
                        }
                    });

                    if(inputLangTiny == contLangTiny){
                        banderaLangTiny = 1;
                    }
                    if(banderaLangTiny == 1){
                        banderaCountryTiny = 1;
                    }
                });

                if(banderaFinalTiny == 2 || banderaFinalTiny == 1){


                    if (banderaCountryTiny == 1 && banderaLangTiny == 1){

                        exit_tiny = 0;
                        banderaFinalTiny = 1;
                    }else{

                        exit_tiny = 1;
                        banderaFinalTiny = 0;
                    }


                }
                else{

                    exit_tiny = 1;
                }
            });
            */


            $('.requerido').each(function (i, elem) {

                    var nameClass = '.' + $(elem).attr('rel');

                    var banderaLang = 0;
                    var banderaCountry = 0;

                    $(nameClass).each(function (i1, elem1) {
                        var nameId = '.' + $(elem1).attr('src');
                        var inputLang = 0;
                        var contLang = 0;

                        $(nameId).each(function (i2, elem2) {
                            contLang++;

                            var elemtTiny = $(elem2).val();

                            if (elemtTiny != '') {
                                $(elem2).css({'border': '1px solid #ccc'});
                                $(elem2).siblings().css({'color': 'black'});
                                inputLang++;
                            } else {

                                $(elem2).css({'border': '1px solid red'});
                                $(elem2).siblings().css({'color': 'red'});

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


            var passespdf = 0;
            var quantity = 0;
            var accepted = 0;

           $('.pdfvalidated').each(function (i,elem) {



               var ext = $(this).val().split('.').pop().toLowerCase();

               if ($.inArray(ext, ['pdf']) == -1) {
                   var errors = [
                       '{{ trans('admin::distributorsPool.validation.file_type') }}'
                   ]
                   $(this).css({'border':'1px solid red'});
                   $(this).siblings().css({'color':'red'});

                   quantity += 1;
               } else {
                   //$('#upload-file').prop('disabled', false);
                   passespdf += 1;
                   $(this).css({'border':'1px solid black'});
                   $(this).siblings().css({'color':'black'});
               }






           });

            if(quantity < 1  && passespdf > 0){
                accepted = 1;
            }




            //|| exitTiny == 1 en caso de haber campos con tinyMCE
            if (exit == 1 || accepted == 0) {


                event.preventDefault();
                $('.alert-info-input').show();
                $('.btn-submit-text').show();
                $('.btn-submit-spinner').hide();
                $('#formLegalButton').prop('disabled', false);
            }








        });
    </script>

@endsection
