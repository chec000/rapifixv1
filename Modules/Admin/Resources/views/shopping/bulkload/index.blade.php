<h1>@lang('admin::shopping.bulkload.views.title_index')</h1>
<div class="container">
    <fieldset class="fieldset_gray">
        <legend class="legend_gray">@lang('admin::shopping.bulkload.views.load-product')</legend>
        <div class="form-group">
            <form name="form-product"  id="form-product" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-md-6">
                        <label>@lang('admin::shopping.bulkload.inputs.labels.product')</label>
                        <input name="fileUpload" type="file" class="form-control input-sm" >
                        <span class="error-product help-block" style="color: red"> </span>
                        <a href="{{ asset('files/carga_productos.csv') }}">{{ trans('admin::distributorsPool.csv.download_base_file') }}</a>
                    </div>
                    <div class="col-md-2 text-center"><br />
                        <button id="button-product" class="btn btn-default">
                            @lang('admin::shopping.bulkload.buttons.submit')
                        </button>
                    </div>
                    <div class="col-md-4 text-left product-response" style="display: none; overflow-x: auto; height: 80px">
                        <div class="text-left">@lang('admin::shopping.bulkload.views.response'):</div>
                        <div id="modal-product"></div>
                    </div>
                </div>
            </form>
        </div>
    </fieldset>
    <hr />
    <fieldset class="fieldset_gray">
        <legend class="legend_gray">@lang('admin::shopping.bulkload.views.load-related')</legend>
        <div class="form-group">
            <form name="form-related"  id="form-related" method="POST" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-6">
                        <label>@lang('admin::shopping.bulkload.inputs.labels.related')</label>
                        <input name="fileUpload" type="file" class="form-control input-sm" >
                        <span class="error-related help-block" style="color: red"> </span>
                        <a href="{{ asset('files/carga_relacionados.csv') }}">{{ trans('admin::distributorsPool.csv.download_base_file') }}</a>
                    </div>
                    <div class="col-md-2 text-center"><br />
                        <button id="button-related" class="btn btn-default">
                            @lang('admin::shopping.bulkload.buttons.submit')
                        </button>
                    </div>
                    <div class="col-md-4 text-left related-response" style="display: none; overflow-x: auto; height: 80px">
                        <div class="text-left">@lang('admin::shopping.bulkload.views.response'):</div>
                        <div id="modal-related"></div>
                    </div>
                </div>
            </form>
        </div>
    </fieldset>
    <hr />
    <fieldset class="fieldset_gray">
        <legend class="legend_gray">@lang('admin::shopping.bulkload.views.load-category')</legend>
        <div class="form-group">
            <form name="form-category"  id="form-category" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-md-6">
                        <label>@lang('admin::shopping.bulkload.inputs.labels.category')</label>
                        <input name="fileUpload" type="file" class="form-control input-sm" >
                        <span class="error-category help-block" style="color: red"> </span>
                        <a href="{{ asset('files/carga_categorias.csv') }}">{{ trans('admin::distributorsPool.csv.download_base_file') }}</a>
                    </div>
                    <div class="col-md-2 text-center"><br />
                        <button id="button-category" class="btn btn-default">
                            @lang('admin::shopping.bulkload.buttons.submit')
                        </button>
                    </div>
                    <div class="col-md-4 text-left category-response" style="display: none; overflow-x: auto; height: 80px">
                        <div class="text-left">@lang('admin::shopping.bulkload.views.response'):</div>
                        <div id="modal-category"></div>
                    </div>
                </div>
            </form>
        </div>
    </fieldset>
    <hr />
    <fieldset class="fieldset_gray">
        <legend class="legend_gray">@lang('admin::shopping.bulkload.views.load-system')</legend>
        <div class="form-group">
            <form name="form-system"  id="form-system" method="POST" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-6">
                        <label>@lang('admin::shopping.bulkload.inputs.labels.system')</label>
                        <input name="fileUpload" type="file" class="form-control input-sm" >
                        <span class="error-system help-block" style="color: red"> </span>
                        <a href="{{ asset('files/carga_sistemas.csv') }}">{{ trans('admin::distributorsPool.csv.download_base_file') }}</a>
                    </div>
                    <div class="col-md-2 text-center"><br />
                        <button id="button-system" class="btn btn-default">
                            @lang('admin::shopping.bulkload.buttons.submit')
                        </button>
                    </div>
                    <div class="col-md-4 text-left system-response" style="display: none; overflow-x: auto; height: 80px">
                        <div class="text-left">@lang('admin::shopping.bulkload.views.response'):</div>
                        <div id="modal-system"></div>
                    </div>
                </div>
            </form>
        </div>
    </fieldset>
    <hr />
    <!-- Upload products by warehouse -->
    <fieldset class="fieldset_gray">
        <legend class="legend_gray">@lang('admin::shopping.bulkload.views.load-warehouses')</legend>
        <div class="form-group">
            <form name="form-warehouse"  id="form-warehouse" method="POST" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-6">
                        <label>@lang('admin::shopping.bulkload.inputs.labels.warehouse')</label>
                        <input name="fileUpload" type="file" class="form-control input-sm" >
                        <span class="error-warehouse help-block" style="color: red"> </span>
                        <a href="{{ asset('files/carga_productos_almacenes.csv') }}">{{ trans('admin::distributorsPool.csv.download_base_file') }}</a>
                    </div>
                    <div class="col-md-2 text-center"><br />
                        <button id="button-warehouse" class="btn btn-default">
                            @lang('admin::shopping.bulkload.buttons.submit')
                        </button>
                    </div>
                    <div class="col-md-4 text-left warehouse-response" style="display: none; overflow-x: auto; height: 80px">
                        <div class="text-left">@lang('admin::shopping.bulkload.views.response'):</div>
                        <div id="modal-warehouse"></div>
                    </div>
                </div>
            </form>
        </div>
    </fieldset>
</div>
@section('scripts')
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script>
    $('#form-product').submit(function (event)
    {
        event.preventDefault();
        $(".error-product").empty();
        $('#button-product').attr("disabled", true);
        var data = new FormData($('#form-product')[0]);
        axios.post('{{ route("admin.load.product") }}', data )
            .then(function (response) {
                if (response.data.res.length) {
                    $('.product-response').show();
                    $('#modal-product').html(getResponseBlock(response.data.res));
                }
                $("#button-product").removeAttr("disabled");
            })
            .catch(function (error) {
                if(error.response.status == 500){
                    var errorFile = "@lang('admin::shopping.bulkload.messages.errors.500')";
                    $(".error-product").text("*"+errorFile);
                }else{
                    var errorFile = error.response.data.errors.fileUpload[0];
                    $(".error-product").text("*"+errorFile);
                }
                $("#button-product").removeAttr("disabled");
            });
    });
    $('#form-related').submit(function (event)
    {
        event.preventDefault();
        $(".error-related").empty();
        $('#button-related').attr("disabled", true);
        var data = new FormData($('#form-related')[0]);
        axios.post('{{ route("admin.load.related") }}', data )
            .then(function (response) {
                if (response.data.res.length) {
                    $('.related-response').show();
                    $('#modal-related').html(getResponseBlock(response.data.res));
                }
                $("#button-related").removeAttr("disabled");
            })
            .catch(function (error) {
                if(error.response.status == 500){
                    var errorFile = "@lang('admin::shopping.bulkload.messages.errors.500')";
                    $(".error-related").text("*"+errorFile);
                }else{
                    var errorFile = error.response.data.errors.fileUpload[0];
                    $(".error-related").text("*"+errorFile);
                }
                $("#button-related").removeAttr("disabled");
            });
    });
    $('#form-category').submit(function (event)
    {
        event.preventDefault();
        $(".error-category").empty();
        $('#button-category').attr("disabled", true);
        var data = new FormData($('#form-category')[0]);
        axios.post('{{ route("admin.load.category") }}', data )
            .then(function (response) {
                if (response.data.res.length) {
                    $('.category-response').show();
                    $('#modal-category').html(getResponseBlock(response.data.res));
                }
                $("#button-category").removeAttr("disabled");
            })
            .catch(function (error) {
                if(error.response.status == 500){
                    var errorFile = "@lang('admin::shopping.bulkload.messages.errors.500')";
                    $(".error-category").text("*"+errorFile);
                }else{
                    var errorFile = error.response.data.errors.fileUpload[0];
                    $(".error-category").text("*"+errorFile);
                }
                $("#button-category").removeAttr("disabled");
            });
    });
    $('#form-system').submit(function (event)
    {
        event.preventDefault();
        $(".error-system").empty();
        $('#button-system').attr("disabled", true);
        var data = new FormData($('#form-system')[0]);
        axios.post('{{ route("admin.load.system") }}', data )
            .then(function (response) {
                if (response.data.res.length) {
                    $('.system-response').show();
                    $('#modal-system').html(getResponseBlock(response.data.res));
                }
                $("#button-system").removeAttr("disabled");
            })
            .catch(function (error) {
                if(error.response.status == 500){
                    var errorFile = "@lang('admin::shopping.bulkload.messages.errors.500')";
                    $(".error-system").text("*"+errorFile);
                }else{
                    var errorFile = error.response.data.errors.fileUpload[0];
                    $(".error-system").text("*"+errorFile);
                }
                $("#button-system").removeAttr("disabled");
            });
    });

    $('#form-warehouse').submit(function (e) {
        e.preventDefault();

        $('.error-warehouse').empty();
        $('#button-warehouse').attr('disabled', true);

        var data = new FormData($('#form-warehouse')[0]);
        axios.post('{{ route('admin.load.warehouses') }}', data)
            .then(function (response) {
                if (response.data.res.length) {
                    $('.warehouse-response').show();
                    $('#modal-warehouse').html(getResponseBlock(response.data.res));
                }
                $('#button-warehouse').removeAttr('disabled');
            })
            .catch(function (err) {
                if (err.response.status === 500){
                    $('.error-warehouse').text('*'+'@lang('admin::shopping.bulkload.messages.errors.500')');
                } else {
                    $('.error-warehouse').text('*'+err.response.data.errors.fileUpload[0]);
                }
                $('#button-warehouse').removeAttr('disabled');
            });
    });

    function getResponseBlock(data) {
        var responseList = '';
        $.each(data, function (i, element) {
            var label = 'Success';
            if (element.class == 'danger') {
                label = 'Error';
            }

            var skuOrLine = element.message.indexOf('product') != -1 ? 'SKU' : 'Line';
            skuOrLine = element.message.indexOf('warehouses') != -1 ? 'Line' : skuOrLine;

            responseList += '<p style="margin:0;font-size: 11px;"><span class="label label-'+element.class+'"> '+label+'</span>'+skuOrLine+': '+element.line+', '+element.message+'</p>';
        });
        return responseList;
    }
</script>
@stop