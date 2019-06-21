@section('styles')
@endsection
<div class="container">
    <a class="btn btn-info btn-sm pull-right" href="{{ route('admin.filters.index') }}" role="button">
        @lang('admin::shopping.filters.buttons.back_list')
    </a>
    @if(session('msg'))
        <div class="alert alert-success" role="alert">{{ session('msg') }}</div>
    @elseif(session('errors') != null)
        <div class="alert alert-danger" role="alert">{{ session('errors')->first('msg') }}</div>
    @endif
    <h1>{!!trans('admin::shopping.filters.view.title_edit')!!}</h1>
    <form id="categories" method="POST" action="{{ route('admin.filters.update', [$code]) }}">
        {{ csrf_field() }}
        {{ method_field('PATCH') }}

        <input type="hidden" name="code" value="{{ $code }}">
        <input type="hidden" name="countries_brand" id="countries_by_brand" value="">

        <div class="form-group">
            @foreach(Auth::user()->userBrandsPermission() as $uB)
                @if ($brand->id == $uB['id'])
                    <p class="lead">Brand: <strong>{{ $uB['name'] }}</strong></p>
                    <input type="hidden" name="brand_id" id="brand_id" value="{{ $brand->id }}">
                @endif
            @endforeach
        </div>

        <div class="form-group">
            <label for="global_name">{{ trans('admin::shopping.products.index.thead-product-global_name') }} *</label>
            <input type="text" name="global_name" id="global_name" class="form-control" required="required" value="{{ $globalName }}">
        </div>

        <div class="form-group">
            <label>@lang('admin::shopping.categories.add.view.form-country')</label><br />
            <ul id="countryForm" class="nav nav-tabs" role="tablist">
                @foreach($categoriesByCountry as $category)
                    @if (in_array($category->country->id, $countriesByBrand))
                        <li data-country-tab="{{ $category->country->id }}" role="presentation">
                            <a href="#{{ str_replace(' ', '_', $category->country->name) }}" aria-controls="home" role="tab" data-toggle="tab">
                                {{ $category->country->name }} <i class="fa fa-caret-square-o-down" aria-hidden="true"></i>
                            </a>
                        </li>
                    @endif
                @endforeach

                @foreach($anotherCountries as $uC)
                    <li role="presentation" data-country-tab="{{ $uC->id }}">
                        <a href="#{{ str_replace(' ', '_', $uC->name) }}" aria-controls="home" role="tab" data-toggle="tab">
                            {{ $uC->name }} <i class="fa fa-caret-square-o-down" aria-hidden="true"></i>
                        </a>
                    </li>
                @endforeach
            </ul>
            <div class="tab-content">
                @foreach($categoriesByCountry as $category)
                    @if (in_array($category->country->id, $countriesByBrand))
                        <div data-country-pane="{{ $category->country->id }}" role="tabpanel" class="tab-pane" id="{{ str_replace(' ', '_', $category->country->name) }}"> <br />
                            @foreach(Auth::user()->getCountryLang($category->country->id) as $langCountry)
                                <div role="panel-group" id="accordion-{{ $category->country->id }}-{{ $langCountry->id }}">
                                    <div class="panel panel-default">
                                        <div role="tab" class="panel-heading">
                                            <h4 class="panel-title">
                                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#product-language-{{ $category->country->id }}-{{ $langCountry->id }}">
                                                    {{trans('admin::shopping.products.add.second_general_tab.country-language-title') . $langCountry->language }}
                                                </a>
                                            </h4>
                                        </div>
                                        <div role="tabpanel" data-parent="#accordion" class="panel-collapse collapse" id="product-language-{{ $category->country->id }}-{{ $langCountry->id }}" >
                                            <div class="panel-body">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label>@lang('admin::shopping.filters.input.label.filter')</label>
                                                            <input name="filter[{{ $category->country->id }}][{{ $langCountry->id }}]"
                                                                   type="text" rel="requerido_{{ $category->country->id }}"
                                                                   class="requerido requerido_{{ $category->country->id }} requerido_{{ $category->country->id }}_{{ $langCountry->id }} form-control"
                                                                   id="requerido_{{ $category->country->id }}_{{ $langCountry->id }}"
                                                                   placeholder="@lang('admin::shopping.categories.add.input.category')"
                                                                   @if (isset($category->translate($langCountry->locale_key)->name) && !empty($category->translate($langCountry->locale_key)->name))
                                                                   value="{{ $category->translate($langCountry->locale_key)->name }}"
                                                                   @else
                                                                   value="{{ old('filter['.$category->country->id.']['.$langCountry->id.']') }}"
                                                                    @endif>
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
                                <label>@lang('admin::shopping.categories.add.view.form-active')</label>
                                <?php $valActive = 0; ?>
                                @isset($category->active)
                                    @if($category->active == 1)
                                        <?php $valActive = 1; ?>
                                    @endif
                                @endisset
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="active[{{ $category->country->id }}]" value="1"  {{ $valActive == 1 ? ' checked' : '' }} >
                                        @lang('admin::shopping.categories.add.input.yes')
                                    </label>
                                </div>
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="active[{{ $category->country->id }}]" value="0" {{ $valActive == 0 ? ' checked' : '' }}>
                                        @lang('admin::shopping.categories.add.input.no')
                                    </label>
                                </div>
                            </div><br />
                        </div>
                    @endif
                @endforeach

                @foreach($anotherCountries as $uC)
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
                                                        <label for="exampleInputEmail1">@lang('admin::shopping.categories.add.input.category') *</label>
                                                        <input name="filter[{{ $uC->id }}][{{ $langCountry->id }}]"
                                                               type="text" rel="requerido_{{ $uC->id }}"
                                                               class="requerido requerido_{{ $uC->id }} requerido_{{ $uC->id }}_{{ $langCountry->id }} form-control"
                                                               id="requerido_{{ $uC->id }}_{{ $langCountry->id }}"
                                                               placeholder="@lang('admin::shopping.categories.add.input.category')"
                                                               value="{{ old('filter['.$uC->id.']['.$langCountry->id.']') }}">
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
                            <label for="exampleInputEmail1">@lang('admin::shopping.categories.add.view.form-active')</label>
                            <div class="radio">
                                <label>
                                    <input type="radio" name="active[{{ $uC->id }}]" value="1" @if(old('active_'.$uC->id) == null || old('active_'.$uC->id)) checked @else '' @endif>
                                    @lang('admin::shopping.categories.add.input.yes')
                                </label>
                            </div>
                            <div class="radio">
                                <label>
                                    <input type="radio" name="active[{{ $uC->id }}]" value="0" {{ old('active_'.$uC->id) === 0 ? ' checked' : '' }}>
                                    @lang('admin::shopping.categories.add.input.no')
                                </label>
                            </div>
                        </div><br />
                    </div>
                @endforeach
            </div>
        </div>
        <div class="form-group text-center">
            <div class="alert alert-danger alert-info-input" role="alert" style="display: none">
                @lang('admin::shopping.categories.add.view.form-error')
            </div>
            <button type="submit" id="formCategoryButton" class="btn btn-default">
                <span class="btn-submit-text">@lang('admin::shopping.categories.add.view.form-save-button')</span>
                <span class="btn-submit-spinner" style="display: none"><i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i></span>
            </button>
        </div>
    </form>
</div>

@section('scripts')
    <script type="text/javascript">
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
        }

        $( document ).ready(function() {
            load_editor_js();
            $("#countryForm li a:first").click();
            $(".accordion-toggle:first").click();

            $('#brand-modal').modal({
                show: true,
                keyboard: false,
                backdrop: 'static',
            });
            $('#close-modal').click(function () {
                history.go(-1);
            });
            $('#accept-modal').click(function () {
                $('#brand-modal').modal('hide');
                deleteTabsFromUnselectedCountries();
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
    <script>
        this.loadListProduct();
        function loadListProduct()
        {
            var userCountries = <?= Auth::user()->countries ?>;
            userCountries.forEach(function(element) {

                if ($("#products_"+element.id).length > 0) {
                    var idProd = $("#products_"+element.id).val();
                    if(idProd != "")
                    {
                        console.log(idProd);
                        var prod = jQuery.parseJSON(idProd);
                        console.log(prod);
                        prod.forEach(function(element1) {
                            if (element1.home == 1){
                                $("#homOff_"+element1.id+"_"+element.id).hide();
                                $("#homOn_"+element1.id+"_"+element.id).show();
                            }
                            if (element1.favorite == 1){
                                $("#favOff_"+element1.id+"_"+element.id).hide();
                                $("#favOn_"+element1.id+"_"+element.id).show();
                            }
                            if (element1.category == 1){
                                $("#catOff_"+element1.id+"_"+element.id).hide();
                                $("#catOn_"+element1.id+"_"+element.id).show();
                            }
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
                    productAdd.id = element.id;
                    productAdd.sku = element.sku;
                    productAdd.favorite = 0;
                    productAdd.home = 0;
                    productAdd.category = 0;
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
                if(element.id == idProd){
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

        function addFavorite(idProd,idCountry)
        {
            var prodSelect = "#products_"+idCountry;
            var prodJson = $(prodSelect).val();
            var obj = jQuery.parseJSON(prodJson);
            var count = 0;
            obj.forEach(function(element) {
                if (element.favorite == 1){
                    count++;
                }
            });
            if (count < {{ config('settings::categories.home') }}){
                obj.forEach(function(element) {
                    if(element.id == idProd){
                        element.favorite = 1;
                        $("#favOff_"+idProd+"_"+idCountry).hide();
                        $("#favOn_"+idProd+"_"+idCountry).show();
                    }
                });
            }else{
                $("#alert_limit_"+idCountry).show();
            }
            $(prodSelect).val(JSON.stringify(obj));
        }

        function quitFavorite(idProd, idCountry)
        {
            $("#alert_limit_"+idCountry).hide();
            var prodSelect = "#products_"+idCountry;
            var prodJson = $(prodSelect).val();
            var obj = jQuery.parseJSON(prodJson);
            var count = 0;
            obj.forEach(function(element) {
                if(element.id == idProd){
                    element.favorite = 0;
                    $("#favOff_"+idProd+"_"+idCountry).show();
                    $("#favOn_"+idProd+"_"+idCountry).hide();
                }
            });
            $(prodSelect).val(JSON.stringify(obj));
        }

        function addCat(idProd,idCountry)
        {
            var prodSelect = "#products_"+idCountry;
            var prodJson = $(prodSelect).val();
            var obj = jQuery.parseJSON(prodJson);
            var count = 0;
            obj.forEach(function(element) {
                if (element.category == 1){
                    count++;
                }
            });
            if (count < 3){
                obj.forEach(function(element) {
                    if(element.id == idProd){
                        element.category = 1;
                        $("#catOff_"+idProd+"_"+idCountry).hide();
                        $("#catOn_"+idProd+"_"+idCountry).show();
                    }
                });
            }else{
                $("#alert_limit_category"+idCountry).show();
            }
            $(prodSelect).val(JSON.stringify(obj));
        }

        function quitCat(idProd, idCountry)
        {
            $("#alert_limit_category"+idCountry).hide();
            var prodSelect = "#products_"+idCountry;
            var prodJson = $(prodSelect).val();
            var obj = jQuery.parseJSON(prodJson);
            var count = 0;
            obj.forEach(function(element) {
                if(element.id == idProd){
                    element.category = 0;
                    $("#catOff_"+idProd+"_"+idCountry).show();
                    $("#catOn_"+idProd+"_"+idCountry).hide();
                }
            });
            $(prodSelect).val(JSON.stringify(obj));
        }

        function addHome(idProd,idCountry) {
            var prodSelect = "#products_"+idCountry;
            var prodJson = $(prodSelect).val();
            var obj = jQuery.parseJSON(prodJson);
            var count = 0;
            obj.forEach(function(element) {
                if (element.home == 1){
                    count++;
                }
            });
            if (count < 1){
                obj.forEach(function(element) {
                    if(element.id == idProd){
                        element.home = 1;
                        $("#homOff_"+idProd+"_"+idCountry).hide();
                        $("#homOn_"+idProd+"_"+idCountry).show();
                    }
                });
            }else{
                $("#alert_limit_home"+idCountry).show();
            }
            $(prodSelect).val(JSON.stringify(obj));
        }
        function quitHome(idProd, idCountry) {
            $("#alert_limit_home"+idCountry).hide();
            var prodSelect = "#products_"+idCountry;
            var prodJson = $(prodSelect).val();
            var obj = jQuery.parseJSON(prodJson);
            var count = 0;
            obj.forEach(function(element) {
                if(element.id == idProd){
                    element.home = 0;
                    $("#homOff_"+idProd+"_"+idCountry).show();
                    $("#homOn_"+idProd+"_"+idCountry).hide();
                }
            });
            $(prodSelect).val(JSON.stringify(obj));
        }
    </script>
@endsection
