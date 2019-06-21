@section('styles')
@endsection
<div class="container">
    <a class="btn btn-info btn-sm pull-right" href="{{ route('admin.promoprods.index') }}" role="button">
        @lang('admin::shopping.promoprods.index.btn_return')
    </a>
    @if(session('msg'))
        <div class="alert alert-success" role="alert">{{ session('msg') }}</div>
    @elseif(session('errors') != null)
        <div class="alert alert-danger" role="alert">{{ session('errors')->first('msg') }}</div>
    @endif
    <h1>{!!trans('admin::shopping.promoprods.edit.view.title-add')!!}</h1>
    <form id="updateForm" method="POST">
        {{ csrf_field() }}
        <input type="hidden" name="promo_id" id="promo_id" value="{{$promo->id}}">
        <input type="hidden" name="locale" id="locale" value="{{ $locale }}">




        <div class="form-group">


            <div class="tab-content">



                <div class="form-group">
                    <label for="promo_key">{{ trans('admin::shopping.promoprods.index.promo_key') }}*</label>
                    <input type="text" name="promo_key" id="requerido" rel="requerido" class="requerido form-control"  value="{{isset($promo->clv_promo) ? $promo->clv_promo : ''}}"/>
                </div>

                <!--Fin inputs generales-->


                    @foreach($languages as $langCountry)

                        <div role="panel-group" id="accordion-{{ $langCountry->id }}">
                            <div class="panel panel-default">
                                <div role="tab" class="panel-heading">
                                    <h4 class="panel-title">
                                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion"
                                           href="#product-language-{{ $langCountry->id }}">
                                            {{trans('admin::shopping.products.add.second_general_tab.country-language-title') . $langCountry->language }}
                                        </a>
                                    </h4>
                                </div>
                                <div role="tabpanel" data-parent="#accordion" class="panel-collapse collapse"
                                     id="product-language-{{ $langCountry->id }}" >
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="promo_name">@lang('admin::shopping.promoprods.add.input.promo_name') *</label>
                                                    <input name="promo_name[]"
                                                           type="text" rel="requerido"
                                                           class="requerido requerido requerido_{{ $langCountry->id }} form-control"
                                                           id="requerido_{{ $langCountry->id }}"
                                                           placeholder="@lang('admin::shopping.promoprods.add.input.promo_name')"
                                                           @if(isset($promo->translate($langCountry->locale_key)->name_header) && !empty($promo->translate($langCountry->locale_key)->name_header))
                                                           value="{{ $promo->translate($langCountry->locale_key)->name_header }}"
                                                           @else
                                                           value="{{ old('promo_name'.$langCountry->id) }}"
                                                            @endif>
                                                </div>
                                                <div class="form-group">
                                                    <label for="promo_desc">@lang('admin::shopping.promoprods.add.input.promo_desc') *</label>
                                                    <input name="promo_desc[]"
                                                           type="text" rel=""
                                                           class="form-control"
                                                           id="requerido_{{ $langCountry->id }}"
                                                           placeholder="@lang('admin::shopping.promoprods.add.input.promo_desc')"
                                                           @if(isset($promo->translate($langCountry->locale_key)->description_header) && !empty($promo->translate($langCountry->locale_key)->description_header))
                                                           value="{{ $promo->translate($langCountry->locale_key)->description_header }}"
                                                           @else
                                                           value="{{ old('promo_desc'.$langCountry->id) }}"
                                                            @endif>
                                                    <input type="hidden" name="local_key[]" value="{{$langCountry->locale_key}}">
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
                    <?php $valActive = 0; ?>
                    @isset($promo->active)
                        @if($promo->active == 1)
                            <?php $valActive = 1; ?>
                        @endif
                    @endisset
                    <label for="exampleInputEmail1">@lang('admin::shopping.promoprods.add.view.form-active')</label>
                    <div class="radio">
                        <label>
                            <input type="radio" name="active" value="1" {{ $valActive == 1 ? ' checked' : '' }}>
                            @lang('admin::shopping.promoprods.add.input.yes')
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                            <input type="radio" name="active" value="0" {{ $valActive == 0 ? ' checked' : '' }}>
                            @lang('admin::shopping.promoprods.add.input.no')
                        </label>
                    </div>
                </div>






            </div>
        </div>
        <div class="form-group text-center">
            <div class="alert alert-danger alert-info-input" role="alert" style="display: none">
                @lang('admin::shopping.promoprods.add.view.form-error')
            </div>
            <button type="button" id="formUpdateButton" class="btn btn-default">
                <span id="savepromo" class="btn-submit-text">@lang('admin::shopping.promoprods.add.view.form-save-button')</span>
                <span class="btn-submit-spinner" style="display: none"><i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i></span>
            </button>
            <div class="alert alert-success alert-success-promo" role="alert" style="display: none">

            </div>
            <div class="alert alert-success alert-danger-promo" role="alert" style="display: none">

            </div>
        </div>
    </form>

    <div id="addProdPromo" class="">

        <h3>@lang('admin::shopping.promoprods.add.view.linkpromoprods')</h3>

        <hr />
        <h6> @lang('admin::shopping.promoprods.add.view.instructionprods')</h6>
        <hr />

        <!--Form products to promo-->
        <form id="prodspromo" method="POST" action="{{ route('admin.promoprods.saveProdPromo') }}">
            {{ csrf_field() }}
            <input type="hidden" name="promo_id" id="promo_id" value="{{$promo->id}}">
            <input type="hidden" value="" name="promo_id_p" id="promo_id_p" />
            <a class="btn btn-primary" href="javascript:void(0)" id="addInput">
                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                @lang('admin::shopping.promoprods.add.view.addProducts')
            </a>
            <br/><br /><br />
            <div id="dynamicDiv">

                <!--carga de los productos previamente relacionados-->

               @foreach($promo->promoprods as $key => $pp)


                        <div class="added" style="display:block;padding:10px;border:2px solid #692780;margin-bottom:10px;overflow:hidden;" id="{{$key}}">
                        <input type="hidden" name="deleted[]" value="" class="deleted"/>
                        <div class="form-group">
                            <input type="hidden" name="id_pp[]" value="{{$pp->id}}">
                            <label for="productcode">@lang('admin::shopping.promoprods.add.input.productcode') *</label>
                            <input name="productcode[]" type="text" rel="requerido{{$key}}" class="requerido{{$key}} requerido{{$key}} form-control" id="requerido{{$key}}" placeholder="@lang('admin::shopping.promoprods.add.input.productcode')"
                                    value="{{isset($pp->clv_producto) ? $pp->clv_producto : ''}}"
                                    >
                            </div>

                        @foreach($languages as $langCountry)
                            <div role="panel-group" id="accordion2-prod{{$key}}-{{ $langCountry->locale_key }}">
                                <div class="panel panel-default">
                                    <div role="tab" class="panel-heading">
                                        <h4 class="panel-title">
                                            <a class="accordion2-toggle" data-toggle="collapse" data-parent="#accordion2" href="#product2-prod{{$key}}-language-{{ $langCountry->locale_key }}">{{trans('admin::shopping.products.add.second_general_tab.country-language-title') . $langCountry->language }}</a>
                                            </h4>
                                        </div>
                                    <div role="tabpanel" data-parent="#accordion2" class="panel-collapse collapse" id="product2-prod{{$key}}-language-{{ $langCountry->locale_key }}" >
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="nameprod">@lang('admin::shopping.promoprods.add.input.nameprod') *</label>
                                                        <input name="nameprod_{{$key}}_{{ $langCountry->locale_key }}" type="text" rel="requerido{{$key}}" class="requerido{{$key}} requerido{{$key}}_{{ $langCountry->locale_key }} form-control" id="requerido{{$key}}_{{ $langCountry->locale_key }}" placeholder="@lang('admin::shopping.promoprods.add.input.nameprod')"
                                                               @if(isset($pp->translate($langCountry->locale_key)->name) && !empty($pp->translate($langCountry->locale_key)->name))
                                                               value="{{ $pp->translate($langCountry->locale_key)->name }}"
                                                               @else
                                                               value=""
                                                                @endif>
                                                        </div>
                                                    <div class="form-group">
                                                        <label for="descprod">@lang('admin::shopping.promoprods.add.input.descprod') *</label>
                                                        <input name="descprod_{{$key}}_{{ $langCountry->locale_key }}" type="text" rel="" class="form-control" id="requerido{{$key}}_{{ $langCountry->locale_key }}" placeholder="@lang('admin::shopping.promoprods.add.input.descprod')"
                                                               @if(isset($pp->translate($langCountry->locale_key)->description) && !empty($pp->translate($langCountry->locale_key)->description))
                                                               value="{{ $pp->translate($langCountry->locale_key)->description }}"
                                                               @else
                                                               value=""
                                                                @endif>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                        @endforeach
                        <a class="btn btn-danger pull-right" style="margin-top:8px;" href="javascript:void(0)" id="remInputExisting">
                            <span class="glyphicon glyphicon-minus" aria-hidden="true"></span>
                            @lang('admin::shopping.promoprods.add.view.removeProducts')
                            </a>
                        </div>


               @endforeach

                <!--Final carga productos previamente relacionados-->



            </div>

            <div class="form-group text-center">
                <div class="alert alert-danger alert-info-producs-input" role="alert" style="display: none">
                    @lang('admin::shopping.promoprods.add.view.form-error')
                </div>
                <button type="button" id="formProducPromoButton" class="btn btn-default">
                    <span id="saveprodspromo" class="btn-submitproduct-text">@lang('admin::shopping.promoprods.add.view.form-save-button')</span>
                    <span class="btn-submit-products-spinner" style="display: none"><i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i></span>
                </button>
            </div>

            @foreach($languages as $langCountry)
                <input type="hidden" name="local_key[]" value="{{$langCountry->locale_key}}">
            @endforeach

            <div class="alert alert-success alert-success-promo-prod" role="alert" style="display: none">

            </div>
            <div class="alert alert-success alert-danger-promo-prod" role="alert" style="display: none">

            </div>

        </form>

        <!--Fin products to promo-->

    </div>



</div>



@section('scripts')
    <script type="text/javascript">



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
            var scntDiv = $('#dynamicDiv');
            var con = obtainCantDivs('added');


            $(document).on('click', '#addInput', function () {
                $('<div class="added" data-cant="' + con +'" style="display:block;padding:10px;border:2px solid #692780;margin-bottom:10px;overflow:hidden;" id="' + con +'">'+
                    '<input type="hidden" class="quantity" value="'+con+'"/>'+
                    '<input type="hidden" name="deleted[]" value="" class="deleted"/>'+
                    '<input type="hidden" name="id_pp[]" value="">'+
                    '<input type="hidden" name="position[]" value="' + con + '">'+
                    '<div class="form-group">'+
                    '<label for="productcode">@lang('admin::shopping.promoprods.add.input.productcode') *</label>'+
                    '<input name="productcode[]" type="text" rel="requerido' + con + '" class="requerido' + con + ' requerido' + con+' form-control" id="requerido' + con +'" placeholder="@lang('admin::shopping.promoprods.add.input.productcode')">'+
                    '</div>'+
                        @foreach($languages as $langCountry)
                            '<div role="panel-group" id="accordion2-prod' + con +'-{{ $langCountry->locale_key }}">'+
                    '<div class="panel panel-default">'+
                    '<div role="tab" class="panel-heading">'+
                    '<h4 class="panel-title">'+
                    '<a class="accordion2-toggle" data-toggle="collapse" data-parent="#accordion2" href="#product2-prod' + con +'-language-{{ $langCountry->locale_key }}">{{trans('admin::shopping.products.add.second_general_tab.country-language-title') . $langCountry->language }}</a>'+
                    '</h4>'+
                    '</div>'+
                    '<div role="tabpanel" data-parent="#accordion2" class="panel-collapse collapse" id="product2-prod' + con +'-language-{{ $langCountry->locale_key }}" >'+
                    '<div class="panel-body">'+
                    '<div class="row">'+
                    '<div class="col-md-12">'+
                    '<div class="form-group">'+
                    '<label for="nameprod">@lang('admin::shopping.promoprods.add.input.nameprod') *</label>'+
                    '<input name="nameprod_' + con +'_{{ $langCountry->locale_key }}" type="text" rel="requerido' + con + '" class="requerido' + con + ' requerido' + con +'_{{ $langCountry->locale_key }} form-control" id="requerido' + con +'_{{ $langCountry->locale_key }}" placeholder="@lang('admin::shopping.promoprods.add.input.nameprod')">'+
                    '</div>'+
                    '<div class="form-group">'+
                    '<label for="descprod">@lang('admin::shopping.promoprods.add.input.descprod') *</label>'+
                    '<input name="descprod_' + con +'_{{ $langCountry->locale_key }}" type="text" rel="" class="form-control" id="requerido' + con +'_{{ $langCountry->locale_key }}" placeholder="@lang('admin::shopping.promoprods.add.input.descprod')">'+

                    '</div>'+
                    '</div>'+
                    '</div>'+
                    '</div>'+
                    '</div>'+
                    '</div>'+
                    '</div>'+

                        @endforeach
                            '<a class="btn btn-danger pull-right" style="margin-top:8px;" href="javascript:void(0)" id="remInput">'+
                    '<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> '+
                    '@lang('admin::shopping.promoprods.add.view.removeProducts')'+
                    '</a>'+
                    '</div>').appendTo(scntDiv);
                con++;
                return false;
            });


            $(document).on('click', '#remInput', function () {
                $(this).parents('.added').remove();
                return false;
            });


            $(document).on('click', '#remInputExisting', function () {
                $(this).parents('.added').hide('fadeOut');
                $(this).parents('.added').children('.deleted').val(1);

                return false;
            });


            //envio de formualrio para almacenar promociones
            $("#formUpdateButton").click(function (event) {


                $('.btn-submit-spinner').show();
                $('.alert-info-input').hide();
                $('#formUpdateButton').prop('disabled', true);

                var banderaFinal = 2;
                var exit = 1;

                $('.requerido').each(function (i, elem) {

                    var nameClass = '.' + $(elem).attr('rel');
                    var banderaLang = 0;
                    var banderaCountry = 0;


                    $(nameClass).each(function (i1, elem1) {

                        var nameId = '.' + $(elem1).attr('id');
                        var inputLang = 0;
                        var contLang = 0;

                        $(nameId).each(function (i2, elem2) {
                            contLang++;

                            var elemtTiny = $(elem2).val();


                            if (elemtTiny != '') {
                                $(elem2).css({'border': '1px solid #ccc'});
                                inputLang++;
                            } else {

                                $(elem2).css({'border': '1px solid red'});
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


                if (exit == 1) {

                    event.preventDefault();
                    $('.alert-info-input').show();
                    $('.btn-submit-text').show();
                    $('.btn-submit-spinner').hide();
                    $('#formUpdateButton').prop('disabled', false);
                } else {
                    //Envio de ajax para insertar en la tabla promo

                    $.ajax({
                        type: "POST",
                        url: "{{ route('admin.promoprods.update') }}",
                        data: $("#updateForm").serialize(),
                        statusCode: { 419: function() { window.location.href = URL_PROJECT; }},
                        success: function (result){
                         
                                if(result.success){
                                    var info = result.data;
                                    var conf = result.config;
                                    $('.btn-submit-spinner').hide();
                                    $(".alert-success-promo").html(result.message);
                                    $(".alert-success-promo").show();
                                    $('#formUpdateButton').prop('disabled', false);
                                    window.location.reload();

                                }
                                else{

                                    $('.btn-submit-spinner').hide();
                                    $(".alert-success-promo").hide();
                                    $(".alert-danger-promo").html(result.message);
                                    $(".alert-danger-promo").show();


                            }


                        },
                        error:function(result){

                            $(".alert-danger-promo").html(result.message);
                            $(".alert-danger-promo").show();
                        },
                        beforeSend: function () {
                            // $("#error-msg-parameters").html("");


                        },
                        complete: function () {


                        }
                    });

                }
            });



            //envio de formualrio para almacenar productos ligados a la promocion formProducPromoButton
            $("#formProducPromoButton").click(function (event) {

                $('.btn-submitproduct-text').hide();
                $('.btn-submit-products-spinner').show();
                $('.alert-info-producs-input').hide();
                $('#formProducPromoButton').prop('disabled', true);

                var banderaFinal2 = 2;
                var exit2 = 1;
                const URL_PROJECT = "{{url('/')}}";
                $('.added').each(function (i,elem) {
                    console.log(this);
                    console.log($(this).is(":visible"));
                    if($(this).is(":visible")){
                        var banderaLang2 = 0;
                        var banderaCountry2 = 0;
                        var pos = $(elem).attr('id');
                        $('.requerido' + pos).each(function (i, elem) {

                            var nameClass2 = '.' + $(elem).attr('rel');



                            $(nameClass2).each(function (i1, elem1) {

                                var nameId2 = '.' + $(elem1).attr('id');
                                var inputLang2 = 0;
                                var contLang2 = 0;

                                $(nameId2).each(function (i2, elem2) {

                                    contLang2++;

                                    var elemtTiny2 = $(elem2).val();


                                    if (elemtTiny2 != '') {

                                        $(elem2).css({'border': '1px solid #ccc'});
                                        inputLang2++;
                                    } else {

                                        $(elem2).css({'border': '1px solid red'});
                                    }
                                });

                                if (inputLang2 == contLang2) {
                                    banderaLang2 = 1;
                                }
                                if (banderaLang2 == 1) {
                                    banderaCountry2 = 1;
                                }
                            });
                            if (banderaFinal2 == 2 || banderaFinal2 == 1) {


                                if (banderaCountry2 == 1 && banderaLang2 == 1) {

                                    exit2 = 0;
                                    banderaFinal2 = 1;
                                } else {

                                    exit2 = 1;
                                    banderaFinal2 = 0;
                                }
                            } else {
                                exit2 == 1;
                            }
                        });
                    }else{
                        exit2 = 0;
                    }



                });



                if (exit2 == 1) {

                    event.preventDefault();
                    $('.alert-info-producs-input').show();
                    $('.btn-submitproduct-text').show();
                    $('.btn-submit-products-spinner').hide();
                    $('#formProducPromoButton').prop('disabled', false);
                }
                else {
                    //Envio de ajax para insertar en la tabla promo

                    $.ajax({
                        type: "POST",
                        url: "{{ route('admin.promoprods.updateProdPromo') }}",
                        data: $("#prodspromo").serialize(),
                        statusCode: { 419: function() { window.location.href = URL_PROJECT; }},
                        success: function (result){
                  
                            if(result.success){
                                var info = result.data;
                                var conf = result.config;

                                $('.btn-submit-spinner').hide();
                                $(".alert-success-promo-prod").html(result.message);
                                $(".alert-success-promo-prod").show();
                                $('#saveprodspromo').prop('disabled', false);

                                setTimeout(function(){

                                    window.location.href = URL_PROJECT + '/support/promoprods';
                                }, 500);


                            }
                            else{
                                $(".alert-success-promo-prodo").hide();
                                $(".alert-danger-promo-prod").html(result.message);
                                $(".alert-danger-promo-prod").show();


                            }


                        },
                        error:function(result){

                            /*  $(".alert-danger-promo").html(result.message);
                             $(".alert-danger-promo").show(); */
                        },
                        beforeSend: function () {
                            // $("#error-msg-parameters").html("");

                        },
                        complete: function () {


                        }
                    });

                }
            });


        });


        function obtainCantDivs(elem){
            cant = $('.' + elem).last().attr('id');
            var totalcant = isNaN(parseInt(cant)) ? 0 :  parseInt(cant);

            return totalcant;
        }
    </script>



@endsection
