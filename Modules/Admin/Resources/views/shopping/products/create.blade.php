<div class="container">
    <form>
        <input type="hidden" name="locale" id="locale" value="{{ $locale }}">
        <ul class="nav nav-pills" role="tablist">
            <li  role="presentation" class="active">
                <a  data-toggle="tab" href="#tab-products-basic-information-content"  id="tab-products-basic-information" class="nav-link active"> {{trans('admin::shopping.products.add.first_general_tab.title')}} </a>
            </li>
            <li  role="presentation" class="">
                <a  data-toggle="tab" href="#tab-products-detail-information-content"  id="tab-products-detail-information" class="nav-link active">{{trans('admin::shopping.products.add.second_general_tab.title')}}</a>
            </li>
        </ul>
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="tab-products-basic-information-content">
                <hr>
                <div class="form-group" id="products-sku-group">
                    <div class="row">
                        <label class="control-label col-md-2" for="products-sku">{{trans('admin::shopping.products.add.first_general_tab.form-sku-label')}}</label>
                        <div class="col-md-5">
                            <input type="hidden" id="products-id" value="">
                            <input type="hidden" id="exist-sku" value="0">
                            <input type="text" class="form-control" id="products-sku" required="required">
                        </div>
                    </div>
                </div>
                <div class="form-group" id="products-sku-group">
                    <div class="row">
                        <label class="control-label col-md-2" for="global-name">{{trans('admin::shopping.products.add.first_general_tab.form-global-name-label')}}</label>
                        <div class="col-md-5">
                            <input type="text" class="form-control" id="global-name" name="global-name" required="required">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="checkbox">
                                <input type="checkbox" class="form-check-input" id="is-kit" value="1">
                                <label for="is-kit" class="form-check-label">{{trans('admin::shopping.products.add.first_general_tab.form-is-kit-label')}}</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-6" id="products-check-brands">
                            <label class="border-botom">{{trans('admin::shopping.products.add.first_general_tab.select-brand-label')}}</label>
                            @foreach($brandsUser as $brand)
                                <div class="checkbox">
                                    <input type="radio" class="form-check-input" id="checkBrand_{{$brand['id']}}" name="checkBrand" value="{{$brand['id']}}">
                                    <label for="checkBrand_{{$brand['id']}}" class="form-check-label">{{$brand['name']}}</label>
                                </div>
                            @endforeach
                        </div>
                        <div class="col-md-6" id="products-check-countries">
                            <label class="border-botom">{{trans('admin::shopping.products.add.first_general_tab.select-country-label')}}</label>
                            {{--@foreach($countryUser as $country)
                            <div data-country-checkbox="{{$country['id']}}" class="checkbox" id="check-countries">
                                <input type="checkbox" class="form-check-input" id="checkCountry_{{ $country['id'] }}" value="{{ $country['id'] }}" onclick="checkCountry('{{ $country['id'] }}')">
                                <input type="hidden" id="country-langs-{{ $country['id'] }}" value="{{ json_encode($country['languages']) }}">
                                <label for="checkCountry_{{$country['id']}}" id="label-langsCountry_{{ $country['id'] }}" class="form-check-label">{{ $country['name'] }}</label>
                            </div>
                            @endforeach--}}
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-2 col-md-offset-3">
                            <a role="button" class="form-control btn btn-primary col-3" id="form-cancell-button">{{trans('admin::shopping.products.add.first_general_tab.form-cancell-button')}}</a>
                        </div>
                        <div class="col-md-2 col-md-offset-1">
                            <a role="button" id="products-goto-detail" class="form-control btn btn-primary col-3">{{trans('admin::shopping.products.add.first_general_tab.form-next-button')}}</a>
                        </div>
                    </div>
                </div>
            </div>
            <div role="tabpanel" class="tab-pane" id="tab-products-detail-information-content">
                <hr>
                
                <div class="row" id="product-country-selected">
                    <div class="col-md-12">
                        <p class="text-danger text-center">{{trans('admin::shopping.products.add.second_general_tab.first-text')}}</p>
                    </div>
                </div>
                <div class="row" id="tab-products-detail-information-content-countries">
                    <div class="col-md-12">
                        <ul class="nav nav-pills" id="tab-products-detail-information-content-countries">
                            @php
                            $i=0
                            @endphp
                            @foreach($countryUser as $country)
                            <li data-showid="{{ $country['id'] }}" role="presentation" class="hidden" id="produc-country-{{ $country['id'] }}">
                                <a role="tab" data-toggle="tab" href="#produc-country-information-{{ $country['id'] }}" class="nav-link" id="product-country-tab-{{ $country['id'] }}">{{trans('admin::shopping.products.add.second_general_tab.country-tab-title')}}{{ $country['name'] }}</a>
                            </li>
                            @endforeach
                        </ul>
                        <div class="tab-content">
                            @foreach($countryUser as $country)
                                <div role="tabpanel" class="tab-pane " id="produc-country-information-{{ $country['id'] }}">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label class="control-label" for="country-product-price-{{ $country['id'] }}">{{trans('admin::shopping.products.add.second_general_tab.country-form-price-label')}}</label>
                                            <input type="text" class="form-control" id="country-product-price-{{ $country['id'] }}">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="control-label" for="country-product-points-{{ $country['id'] }}">{{trans('admin::shopping.products.add.second_general_tab.country-form-points-label')}}</label>
                                            <input type="text" class="form-control" id="country-product-points-{{ $country['id'] }}">
                                        </div>
                                    </div>
                                </div>

                                <hr class="hr_bold_violet">

                                <div class="row">
                                    <div class="col-md-12">
                                        <p class="text-danger text-center">{{trans('admin::shopping.products.add.second_general_tab.second-text')}}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        @foreach($country['languages'] as $language)
                                        <div role="panel-group" id="accordion-{{ $country['id']}}-{{$language['id'] }}">
                                            <div class="panel panel-default">
                                                <div role="tab" class="panel-heading">
                                                    <h4 class="panel-title">
                                                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion-{{ $country['id']}}-{{$language['id'] }}" href="#product-language-{{ $country['id']}}-{{$language['id'] }}">{{trans('admin::shopping.products.add.second_general_tab.country-language-title') . $language['name'] }}</a>
                                                    </h4>
                                                </div>
                                                <div data-show="{{ $country['id'] }}" role="tabpanel" data-parent="#accordion-{{ $country['id']}}-{{$language['id'] }}" class="panel-collapse collapse" id="product-language-{{ $country['id']}}-{{$language['id'] }}" >
                                                    <div class="panel-body">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="form-group">    
                                                                    <label class="control-label"  for="product-name-{{ $country['id']}}-{{$language['id'] }}">
                                                                        {{trans('admin::shopping.products.add.second_general_tab.form-product-name-label')}}
                                                                    </label>
                                                                    <input type="text" class="form-control" rel="obligatorio"
                                                                           name="product-name-{{ $country['id']}}-{{$language['id'] }}"
                                                                           id="product-name-{{ $country['id']}}-{{$language['id'] }}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label class="control-label">
                                                                        {{trans('admin::shopping.products.add.second_general_tab.form-product-short-description-label')}}
                                                                    </label>
                                                                    <input type="text" class="form-control" rel="obligatorio"
                                                                           name="product-short-description-{{ $country['id']}}-{{$language['id'] }}"
                                                                           id="product-short-description-{{ $country['id']}}-{{$language['id'] }}" maxlength="140">
                                                                    <p class="help-block">{{ trans("admin::shopping.products.add.alerts.warning-limit-chars") }}</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label class="control-label">
                                                                        {{trans('admin::shopping.products.add.second_general_tab.form-product-description-label')}}
                                                                    </label>
                                                                    <textarea class="form-control" rows="6"  rel="obligatorio"
                                                                              name="product-description-{{ $country['id']}}-{{$language['id'] }}"
                                                                              id="product-description-{{ $country['id']}}-{{$language['id'] }}"></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="control-label">
                                                                        {{trans('admin::shopping.products.add.second_general_tab.form-product-benefits-label')}}
                                                                    </label>
                                                                    <textarea class="form-control header_note" rows="4" rel=""
                                                                              name="product-benefits-{{ $country['id']}}-{{$language['id'] }}"
                                                                              id="product-benefits-{{ $country['id']}}-{{$language['id'] }}"></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="control-label">
                                                                        {{trans('admin::shopping.products.add.second_general_tab.form-product-ingredients-label')}}</label>
                                                                    <textarea class="form-control" rows="4" rel=""
                                                                              name="product-ingredients-{{ $country['id']}}-{{$language['id'] }}"
                                                                              id="product-ingredients-{{ $country['id']}}-{{$language['id'] }}"></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label class="control-label"  for="product-comments-{{ $country['id']}}-{{$language['id'] }}">
                                                                        {{trans('admin::shopping.products.add.second_general_tab.form-product-comments-label')}}
                                                                    </label>
                                                                    <textarea class="form-control" rows="6" rel=""
                                                                              name="product-comments-{{ $country['id']}}-{{$language['id'] }}"
                                                                              id="product-comments-{{ $country['id']}}-{{$language['id'] }}"></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="control-label">
                                                                        {{trans('admin::shopping.products.add.second_general_tab.form-product-image-label')}}
                                                                    </label>
                                                                    <div class="input-group">
                                                                        <input class="img_src form-control" rel="obligatorio"
                                                                               readonly="true"  type="text"
                                                                               name="product-image-{{ $country['id']}}-{{$language['id'] }}"
                                                                               id="product-image-{{ $country['id']}}-{{$language['id'] }}">
                                                                        <span class="input-group-btn">
                                                                            <a href="{!! URL::to(config('admin.config.public') .
                                                                            '/filemanager/dialog.php?type=1&field_id=product-image-'.$country['id'].'-'.$language['id'])   !!}"
                                                                               class="btn btn-default iframe-btn">{{ trans('admin::countries.add_btn_image') }}
                                                                            </a>
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="control-label"  for="product-nutritional-info-{{ $country['id']}}-{{$language['id'] }}">{{trans('admin::shopping.products.add.second_general_tab.form-product-nutritional-info-label')}}</label>
                                                                    <div class="input-group">
                                                                        <input class="img_src form-control"  rel=""
                                                                               readonly="true" type="text"
                                                                               name="product-nutritional-info-{{ $country['id']}}-{{$language['id'] }}"
                                                                               id="product-nutritional-info-{{ $country['id']}}-{{$language['id'] }}">
                                                                        <span class="input-group-btn">
                                                                            <a href="{!! URL::to(config('admin.config.public').'/filemanager/dialog.php?type=1&field_id=product-nutritional-info-' . $country['id'] . '-'. $language['id']) !!}" class="btn btn-default iframe-btn">{{ trans('admin::countries.add_btn_image') }}</a>
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
                                    </div>
                                </div>
                                <!-- Productos complementarios sección-->

                                <hr class="hr_bold_violet">

                                <div class="form-group">
                                    <label for="exampleInputEmail1">@lang('admin::shopping.categories.add.view.form-product-select')</label>
                                    <input type="hidden" name="products_{{ $country['id'] }}" id="products_{{ $country['id'] }}" class="form-control"
                                           value="{{ old('products_'.$country['id']) }}"/>
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <div id="alert_{{ $country['id'] }}" class="alert alert-danger btn-xs" role="alert" style="display: none; padding: 5px">
                                                @lang('admin::shopping.categories.add.error.select-product-error')
                                            </div>
                                        </div>
                                        <div class="col-xs-10">
                                            <select class="form-control" id="sel_{{ $country['id'] }}">
                                                <option id="opt_{{ $country['id'] }}" value="">
                                                    @lang('admin::shopping.categories.add.input.product')
                                                </option>
                                                @foreach(Auth::user()->activeProductsByCountry($country['id']) as $prod)
                                                    <option id="opt_{{$prod->id}}_{{ $country['id'] }}" value="{{$prod->id}}">{{$prod->sku}} - {{$prod->global_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-xs-2">
                                            <button type="button" class="btn btn-default"
                                                    onclick="addProduct({{ $country['id'] }}, {{ Auth::user()->activeProductsByCountry($country['id']) }})">
                                                @lang('admin::shopping.categories.add.view.form-add-button')
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div id="alert_limit_{{ $country['id'] }}" class="alert alert-danger btn-xs" role="alert" style="display: none; padding: 5px">
                                        @lang('admin::shopping.categories.add.error.select-category')
                                    </div>
                                    <div id="alert_limit_home{{ $country['id'] }}" class="alert alert-danger btn-xs" role="alert" style="display: none; padding: 5px">
                                        @lang('admin::shopping.categories.add.error.select-banner')
                                    </div>
                                    <div id="alert_limit_category{{ $country['id'] }}" class="alert alert-danger btn-xs" role="alert" style="display: none; padding: 5px">
                                        @lang('admin::shopping.categories.add.error.select-home')
                                    </div>
                                    <table class="table text-center">
                                        <tr>
                                            <th class="text-center" colspan="5">@lang('admin::shopping.categories.add.view.form-product-list')</th>
                                        </tr>
                                        <tr>
                                            <th class="text-center">@lang('admin::shopping.categories.add.view.form-list-id')</th>
                                            <th class="text-center">@lang('admin::shopping.categories.add.view.form-list-sku')</th>
                                            <th class="text-center">@lang('admin::shopping.products.add.first_general_tab.form-global-name-label')</th>
                                            <th class="text-center">@lang('admin::shopping.categories.add.view.form-list-delete')</th>
                                        </tr>
                                        @foreach(Auth::user()->activeProductsByCountry($country['id']) as $prod)
                                            <tr id="dis_{{$prod->id}}_{{ $country['id'] }}" style="display: none">
                                                <td>{{ $prod->id }}</td>
                                                <td>{{ $prod->sku }}</td>
                                                <td>{{ $prod->global_name }}</td>
                                                {{-- <td class="text-center">
                                                    <i id="homOff_{{$prod->id.'_'.$uC->id}}" class="fa fa-star-o fa-2x"
                                                       aria-hidden="true" onclick="addHome({{$prod->id}},{{ $uC->id }})"></i>
                                                    <i id="homOn_{{$prod->id.'_'.$uC->id}}" class="fa fa-star fa-2x"
                                                       aria-hidden="true" onclick="quitHome({{$prod->id}},{{ $uC->id }})"
                                                       style="color: gold;display: none"></i>
                                                </td>--}}
                                                <td>
                                                    <i id="{{$prod->id}}|{{ $country['name'] }}" class="del_btn fa fa-trash fa-2x"
                                                       aria-hidden="true" onclick="delProduct({{$prod->id}},'{{ $country['id'] }}')"></i>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </div>

                                <hr class="hr_bold_violet">

                                <!-- Productos complementarios sección-->
                                <div class="form-group">
                                    <label for="active-country-{{ $country['id'] }}">@lang('admin::shopping.products.add.second_general_tab.country-form-active-product')</label>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" id="active-country-yes-{{ $country['id'] }}" name="active-country-{{ $country['id'] }}" value="1" @if(old('active-country-'.$country['id']) == null || old('active-country-'.$country['id'])) {{ 'checked' }} @else {{ '' }} @endif>
                                            @lang('admin::shopping.categories.add.input.yes')
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" id="active-country-no-{{ $country['id'] }}" name="active-country-{{ $country['id'] }}" value="0" {{ old('active-country-'.$country['id']) === 0 ? ' checked' : '' }}>
                                            @lang('admin::shopping.categories.add.input.no')
                                        </label>
                                    </div>
                                    </div>
                            </div>
                            @endforeach <!-- FINAL FOREACH paises-->
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-5 col-md-offset-4">
                        <div class="form-group">
                            <button class="btn btn-primary" type="button" id="form-button-cancell">{{trans('admin::shopping.products.add.second_general_tab.form-cancell-button')}}</button>
                            <button class="btn btn-primary" type="button" id="save-product-information">{{trans('admin::shopping.products.add.second_general_tab.form-save-button')}}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

@section('scripts')
<script type='text/javascript'>
    var translations = {
        errorEmptySKU:                  '{{ trans("admin::shopping.products.add.alerts.empty-sku") }}',
        errorSKUExist:                  '{{ trans("admin::shopping.products.add.alerts.empty-sku-exist") }}',
        errorEmptyGlobalName:           '{{ trans("admin::shopping.products.add.alerts.empty-global-name") }}',
        errorEmptyBrand:                '{{ trans("admin::shopping.products.add.alerts.empty-brand") }}',
        errorEmptyCountry:              '{{ trans("admin::shopping.products.add.alerts.empty-country") }}',
        errorEmptyCountryPrice:         '{{ trans("admin::shopping.products.add.alerts.empty-country-price") }}',
        errorEmptyCountryPoints:        '{{ trans("admin::shopping.products.add.alerts.empty-country-points") }}',
        errorEmptyCountryCategory:      '{{ trans("admin::shopping.products.add.alerts.empty-country-category") }}',
        errorEmptyCountryLanguageItem:  '{{ trans("admin::shopping.products.add.alerts.empty-country-language-item") }}',
        productSaved:                   '{{ trans("admin::shopping.products.add.alerts.product-saved") }}',
        errorSavingProduct:             '{{ trans("admin::shopping.products.add.alerts.error-saving-product") }}',
        cancellDialogTitle:             '{{ trans("admin::shopping.products.add.alerts.cancell-dialog-title") }}',
        cancellDialogContent:           '{{ trans("admin::shopping.products.add.alerts.cancell-dialog-content") }}',
        cancellDialogButtonYes:         '{{ trans("admin::shopping.products.add.alerts.cancell-dialog-button-yes") }}',
        cancellDialogButtonNo:          '{{ trans("admin::shopping.products.add.alerts.cancell-dialog-button-no") }}',
        errorQuantityRelated:           '{{ trans("admin::shopping.products.add.alerts.errorQuantityRelated") }}',
        errorQuantityRelated2:          '{{ trans("admin::shopping.products.add.alerts.errorQuantityRelated2") }}',
        errorInfoProdLang:              '{{ trans("admin::shopping.products.add.alerts.error-info") }}'
    }
</script>
<script type='text/javascript'>
    function generateCountryCheckbox(countryId, languages, name) {
        return '<div data-country-checkbox="'+countryId+'" class="checkbox" id="check-countries">\
                <input class="form-check-input" id="checkCountry_'+countryId+'" value="'+countryId+'" onclick="checkCountry(\''+countryId+'\')" type="checkbox">\
                <input id="country-langs-'+countryId+'" value="'+languages+'" type="hidden">\
                <label for="checkCountry_'+countryId+'" id="label-langsCountry_'+countryId+'" class="form-check-label">'+name+'</label>\
                </div>';
    }

    var checkCountry = function (countryId) {
        $(document).ready(function () {
            if ( $("#checkCountry_" + countryId).is(":checked") ) {
                $("#produc-country-" + countryId).removeClass("hidden");
                $("#product-country-tab-" + countryId).trigger('click');
                $("#produc-country-information-" + countryId).addClass("active");
            } else {
                var firstSelected = $('#products-check-countries input:checked').first().val();
                if(firstSelected!==undefined){
                    $("#product-country-tab-" + firstSelected).trigger('click');
                }
                $("#produc-country-" + countryId).addClass("hidden");
                $("#produc-country-information-" + countryId).removeClass("active");
            }  
        });
    };
    this.loadListProduct();
    function loadListProduct()
    {
        var userCountries = <?= Auth::user()->countries ?>;
        userCountries.forEach(function(element) {
            if ($("#products_"+element.id).length > 0) {
                var idProd = $("#products_"+element.id).val();
                if(idProd != "")
                {
                    var prod = jQuery.parseJSON(idProd);
                    prod.forEach(function(element1)
                    {
                        $("#opt_"+element1.id+"_"+element.id).hide();
                        $("#dis_"+element1.id+"_"+element.id).show();
                    });
                }
            }
        });
        //var prodSelect = "#products_"+idCountry;

    }
    function addProduct(idCountry,allProduct)
    {
        // Se optiene id del producto seleccionado
        var idProd = $("#sel_"+idCountry).val();

        // Se valida que este seleccionado un producto
        if(idProd != ""){
            // se oculta la alerta
            $("#alert_"+idCountry).hide();
            // Se oculta el producto seleccionado del select
            $("#opt_"+idProd+"_"+idCountry).hide();
            // Se cambia el de elemento el select
            $("#sel_"+idCountry).val("");
            // Se muestra en la tabla el producto agregado
            $("#dis_"+idProd+"_"+idCountry).show();
            // Se guarda el producto agregado en el json.
            this.saveProduct(idProd,idCountry,allProduct);
        }else {
            // Se muestra mensaje de error
            $("#alert_"+idCountry).show();
        }
    }
    function saveProduct(idProd,idCountry,allProduct)
    {
        var prodSelect = "#products_"+idCountry;
        // Se recorre el array para guardar el producto seleccionado
        allProduct.forEach(function(element) {

            var ar = [];
            if(element.id == idProd){
                // Se optiene la informacion del input
                var prodJson = $(prodSelect).val();
                // Se valida que no este vacio para agregar los elementos al array
                if(prodJson != ""){
                    var obj = jQuery.parseJSON(prodJson);
                    ar = obj;
                }
                // se crea el objecto para agregarlo al array
                var productAdd = new Object();
                productAdd.id_related = element.id;
                productAdd.sku = element.sku;
                productAdd.country = idCountry;
                // Se agrega el producto al array
                ar.push(productAdd);
                // Se inserta en el input para su envio
                $(prodSelect).val(JSON.stringify(ar));
            }
        });
    }
    function delProduct(idProd, idCountry)
    {
        var prodSelect = "#products_"+idCountry;
        var obj = jQuery.parseJSON($(prodSelect).val());
        $("#favOff_"+idProd+"_"+idCountry).show();
        $("#favOn_"+idProd+"_"+idCountry).hide();
        obj.forEach(function(element, index) {
            if(element.id_related == idProd){
                obj.splice(index,1);
            }
        });
        if(obj.length == 0){
            $(prodSelect).val("")
        }else {
            $(prodSelect).val(JSON.stringify(obj))
        }
        $("#dis_"+idProd+"_"+idCountry).hide();
        $("#opt_"+idProd+"_"+idCountry).show();
    }

    function showCountriesByBrand(brand) {
        $.ajax({
            url: '{{ route('admin.products.getproducts') }}',
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

                $.each(response.data, function (i, country) {
                    $('#sel_'+country.countryId).empty();
                    $('#sel_'+country.countryId).append('<option>{{ trans('admin::shopping.categories.add.input.product') }}</option>');

                    $.each(country.products, function (j, product) {
                        $('#sel_'+country.countryId).append('<option id="opt_'+product.id+'_'+country.countryId+'" value="'+product.id+'">'+product.sku+' - '+product.global_name+'</option>');
                    });
                });
            }
        }).fail(function (response, textStatus, errorThrown) {
            console.log(response, textStatus, errorThrown);
        });
    }

    $(document).ready(function () {
        load_editor_js();
        /*tinymce.init({
            selector: 'textarea',  // change this value according to your HTML
        });*/

        $('[data-showid]').click(function () {
            var id = $(this).data('showid');
            $('#produc-country-information-'+id+' [data-show='+id+']').removeClass('in');
            $('#produc-country-information-'+id+' [data-show='+id+']').first().addClass('in');
        });

        // Si ya se encuentra una marca seleccionada, mostrar sus paises
        if ($('[name="checkBrand"]:checked').val() != undefined && $('[name="checkBrand"]:checked').val() != '') {
            showCountriesByBrand($('[name="checkBrand"]:checked').val());
        }

        $('#products-sku').change(function () {
            console.log($(this).val());

            $.ajax({
                url: '{{ route('admin.products.existSKU') }}',
                method: 'POST',
                data: {sku: $(this).val()},
                dataType: 'JSON',
                statusCode: { 419: function() {window.location.href = '{{ route('admin.home') }}'} }
            }).done(function (response, textStatus, jqXHR) {
                if (response.status) {
                    $('#exist-sku').val('1');
                } else {
                    if (response.redirect !== false) {
                        window.location.replace(response.redirect);
                    } else {
                        $('#exist-sku').val('0');
                    }
                }
            }).fail(function (response, textStatus, errorThrown) {
                console.log(response, textStatus, errorThrown);
            });
        });

        $('[name="checkBrand"]').change(function () {
            showCountriesByBrand($(this).val());
        });


        function xyz(){
            var json= (@php echo isset($product) ? json_encode($product) : 'undefined' @endphp);
            if(json!==undefined){
                $("#products-id").val(json.id);
                $("#products-sku").val(json.sku);
                $("#is-kit").prop('checked', json.isKit);
                $("#checkBrand_" + json.brandId).prop("checked", true);
                $.each(json.countries, function(i, country) {
                    $("#checkCountry_" + country.countryId).prop('checked', country.active);
                    $("#country-product-price-" + country.countryId).val(country.price);
                    $("#country-product-points-" + country.countryId).val(country.points);
                    $.each(country.detail, function(i,lang){
                       $("#product-name-" + country.countryId + "-" + lang.languageId).val(lang.name);
                       $("#product-short-description-" + country.countryId + "-" + lang.languageId).val(lang.shortDescription);
                       $("#product-description-" + country.countryId + "-" + lang.languageId).val(lang.description);
                       $("#product-benefits-" + country.countryId + "-" + lang.languageId).val(lang.benefits);
                       $("#product-ingredients-" + country.countryId + "-" + lang.languageId).val(lang.ingredients);
                       $("#product-image-" + country.countryId + "-" + lang.languageId).val(lang.image);
                       $("#product-nutritional-info-" + country.countryId + "-" + lang.languageId).val(lang.nutritionalTable); 
                    });  
                    if(country.active){
                       checkCountry(country.countryId); 
                    }
                });
            }
        }
        xyz();
        var isValidBasicInformation = function()
        {
            if ($("#products-sku").val().length === 0) {
                $("#products-sku").parent().parent().parent().addClass("has-error");
                bootbox.alert(translations.errorEmptySKU);
            } else {
                if ($('#exist-sku').val() == '1') {
                    $("#products-sku").parent().parent().parent().addClass("has-error");
                    bootbox.alert(translations.errorSKUExist);
                } else {
                    if ($("[name=global-name]").val().length == 0) {
                        $("[name=global-name]").parent().parent().parent().addClass("has-error");
                        bootbox.alert(translations.errorEmptyGlobalName);
                    } else {
                        $("#products-sku").parent().parent().parent().removeClass("has-error");
                        var countries =[];
                        $('#products-check-countries input:checked').each(function () {
                            var countryId = $(this).attr('value');
                            var country = {id: countryId, name: $("#label-langsCountry_" + countryId).text()};
                            countries.push(country);
                        });
                        if (countries.length === 0) {
                            $("#products-check-countries").addClass("has-error");
                            bootbox.alert(translations.errorEmptyCountry);
                        } else {
                            $("#products-check-countries").removeClass("has-error");
                            var brands = [];
                            $('#products-check-brands input:checked').each(function () {
                                var brand = {id: $(this).attr('value')};
                                brands.push(brand);
                            });
                            if (brands.length === 0) {
                                bootbox.alert(translations.errorEmptyBrand);
                                $("#products-check-brands").addClass("has-error");
                            } else {
                                $("#products-check-brands").removeClass("has-error");
                                return true;
                            }
                        }
                    }
                }
            }
            return false;
        };
        $("#products-goto-detail").click(function () {
            if(isValidBasicInformation()){
                $("#tab-products-detail-information").trigger('click');
            }
        });
        $("#tab-products-detail-information").click(function(event){
            if(!isValidBasicInformation()){ 
                event.stopPropagation();
                $("#tab-products-basic-information").trigger('click');
            }
        });
        $("#save-product-information").click(function(){
            var jsonCountries = [];
            var isValid       = true;
            var banderaFinal  = 1;
            $('#products-check-countries input[type="checkbox"]').each(function () {
                var isChecked   = $(this).is(":checked");
                var countryId   = $(this).attr('value');
                var active      = $('[name="active-country-'+countryId+'"]:checked').val();

                var jsonCountry                      = {};
                jsonCountry.countryId                = countryId,
                jsonCountry.active                   = isChecked ? 1 : 0;;
                jsonCountry.activateProductByCountry = parseInt(active);
                if(isChecked)
                {
                    var countryName     = $("#label-langsCountry_" + countryId).text();
                    var countryPrice    = $("#country-product-price-" + countryId).val();
                    var countryPoints   = $("#country-product-points-" + countryId).val();
                    var countryLangs    = JSON.parse($("#country-langs-" + countryId).val());
                    if($("#products_" + countryId).val()){
                        var countryRelateds = JSON.parse($("#products_" + countryId).val());
                        if($("#products_" + countryId).val()){
                            var countryRelateds = JSON.parse($("#products_" + countryId).val());
                            if(countryRelateds.length > 3) {
                                    isValid = false;
                                    bootbox.alert(translations.errorQuantityRelated2 + " "+countryName);
                            }
                        }
                    }
                    if( countryPrice <= 0 || countryPrice === '') {
                        isValid = false;
                        banderaFinal = 0;
                        $("#country-product-price-" + countryId).parent().addClass("has-error");
                        bootbox.alert(translations.errorEmptyCountryPrice + " "+countryName);
                    }
                    else
                    {
                        $("#country-product-price-"+countryId).parent().removeClass("has-error");
                        if(countryPoints === ''){
                            isValid = false;
                            banderaFinal = 0;
                            $("#country-product-points-" + countryId).parent().addClass("has-error");
                            bootbox.alert(translations.errorEmptyCountryPoints + " "+countryName);
                        } else {
                            var languages    = [];
                            var llenadoInfoCountry = 0;
                            if(banderaFinal == 1)
                            {
                                $.each(countryLangs,function(id,lang)
                                {
                                    var hasErrors = false;
                                    if (llenadoInfoCountry != 1)
                                    {
                                        var llenadoInfoLangs = 1;
                                        $("#product-language-" + countryId + "-" + lang.id + " input, #product-language-" +
                                                countryId + "-" + lang.id + " textarea").each(function ()
                                        {
                                            if($(this).attr('rel') == "obligatorio"){
                                                var value = '';
                                                if (tinyMCE.get($(this).attr('id')) !== null) {
                                                    value = tinyMCE.get($(this).attr('id')).getContent();
                                                } else {
                                                    value = $(this).val();
                                                }
                                                if (value.length === 0) {
                                                    llenadoInfoLangs = 0;
                                                    hasErrors = true;
                                                    $(this).parent().addClass("has-error");
                                                } else {
                                                    $(this).parent().removeClass("has-error");
                                                }
                                            }
                                        });

                                        if (llenadoInfoLangs == 1) {
                                            llenadoInfoCountry = 1;
                                        }
                                    }
                                    if(hasErrors) {
                                        isValid = false;
                                    } else {
                                        isValid = true;
                                        languages.push({
                                            languageId              : lang.id,
                                            languageName            : lang.localeKey,
                                            name                    : $("#product-name-" + countryId + "-" + lang.id).val(),
                                            shortDescription        : $("#product-short-description-" + countryId + "-" + lang.id).val(),
                                            //description             : tinyMCE.get("product-description-" + countryId + "-" + lang.id).getContent(),
                                            //benefits                : tinyMCE.get("product-benefits-" + countryId + "-" + lang.id).getContent(),
                                            //ingredients             : tinyMCE.get("product-ingredients-" + countryId + "-" + lang.id).getContent(),
                                            //comments                : tinyMCE.get("product-comments-" + countryId + "-" + lang.id).getContent(),
                                            description             : $("#product-description-" + countryId + "-" + lang.id).val(),
                                            benefits                : $("#product-benefits-" + countryId + "-" + lang.id).val(),
                                            ingredients             : $("#product-ingredients-" + countryId + "-" + lang.id).val(),
                                            comments                : $("#product-comments-" + countryId + "-" + lang.id).val(),
                                            image                   : $("#product-image-" + countryId + "-" + lang.id).val(),
                                            nutritionalTable        : $("#product-nutritional-info-" + countryId + "-" + lang.id).val(),
                                        });
                                    }
                                });
                            }
                            if(isValid){
                                jsonCountry.price       = countryPrice,
                                jsonCountry.points      = countryPoints,
                                jsonCountry.categoryId  = 0;
                                jsonCountry.detail      = languages;
                                jsonCountry.related     = countryRelateds;
                            }
                        }
                    }
                }

                if(typeof(llenadoInfoCountry) != "undefined" && llenadoInfoCountry !== null) {
                    if(llenadoInfoCountry == 1){
                        banderaFinal = 1;
                    }else{
                        banderaFinal = 0;
                    }
                }
                jsonCountries.push(jsonCountry);
            });
            if(banderaFinal != 1){
                isValid = false;
                bootbox.alert(translations.errorInfoProdLang);
            }else {
                isValid = true;
            }

            if ($('#exist-sku').val() == '1') {
                isValid = false;
                $("#products-sku").parent().parent().parent().addClass("has-error");
                bootbox.alert(translations.errorSKUExist);
            }

            if(isValid){
                var jsonProduct        = {};
                jsonProduct.id         = $("#products-id").val();
                jsonProduct.sku        = $("#products-sku").val();
                jsonProduct.globalName = $("[name=global-name]").val();
                jsonProduct.isKit      = $("#is-kit").is(":checked") ? 1 : 0;
                jsonProduct.brandId    = $('#products-check-brands input:checked').first().val();
                jsonProduct.countries  = jsonCountries;
                $.ajax({
                    type: "POST",
                    url: "{{ route('admin.products.store') }}",
                    data: jsonProduct,
                    statusCode: { 419: function() {window.location.href = '{{ route('admin.home') }}'} },
                    success: function (data){
                        bootbox.alert({
                            message: translations.productSaved, 
                            callback: function(){
                                window.location.href="{{ route('admin.products.index') }}";
                            }
                        });
                    },
                    error:function(data){
                        bootbox.alert(translations.errorSavingProduct);
                    },
                    beforeSend: function () {
                        $("#save-product-information").prop('disabled', true);
                    },
                    complete: function () {
                        $("#save-product-information").prop('disabled', false);
                    }
                });
            }
        });
        $('#form-cancell-button').click(function(){
            bootbox.confirm({
                title: translations.cancellDialogTitle,
                message: translations.cancellDialogContent,
                buttons: {
                    cancel: {
                        label: '<i class="fa fa-times"></i> '+translations.cancellDialogButtonNo
                    },
                    confirm: {
                        label: '<i class="fa fa-check"></i> '+translations.cancellDialogButtonYes
                    }
                },
                callback: function (result) {
                    window.location.href="{{ route('admin.products.index') }}";
                }
            });
        })
        $('#form-button-cancell').click(function(){
            bootbox.confirm({
                title: translations.cancellDialogTitle,
                message: translations.cancellDialogContent,
                buttons: {
                    cancel: {
                        label: '<i class="fa fa-times"></i> '+translations.cancellDialogButtonNo
                    },
                    confirm: {
                        label: '<i class="fa fa-check"></i> '+translations.cancellDialogButtonYes
                    }
                },
                callback: function (result) {
                    window.location.href="{{ route('admin.products.index') }}";
                }
            });
        })
    });   
</script>
@endsection
