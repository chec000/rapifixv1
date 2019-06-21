<h1>{{ trans('admin::shopping.warehouses.product.label.title') }}</h1>

<div class="form-group">
    {!! Form::open( ['route' => 'admin.products.warehouselist', 'name' => 'country_form']) !!}
        {!! Form::label('id_country', trans('admin::shopping.warehouses.product.label.countries'), ['class' => 'control-label']) !!}
        {!! Form::select('id_country', $countryUser, $countryUserSelected, ['required','class' => 'form-control country_id']) !!}
        <span class="help-block" style="color: red">{{ $errors->first('country') }}</span>
        {!! Form::hidden('id_product', $id) !!}
        <input type="hidden" name="id_country_product" value="{{ $productCountryId }}">
    {!! Form::close() !!}
</div>
    <h2>{{ trans('admin::shopping.warehouses.product.label.product') }}: {{ $productName }}</h2>
<div class="form-group">
    {!! Form::open( ['route' => 'admin.products.warehousecreate']) !!}
        <fieldset class="fieldset_gray">
            <legend class="legend_gray"> {{ trans('admin::shopping.warehouses.product.label.wherehouses') }} {{ $countryUser[$countryUserSelected] }}{{-- {!! trans('admin::shopping.warehouses.add.label.legend_add') !!}--}}</legend>
            <div class="row">
                <div class="col-md-10">
                        {!! Form::select('warehouse', $warehousesAvailable, '', ['required','class' => 'form-control id_warehouses']) !!}
                        <span class="help-block" style="color: red">{{ $errors->first('warehouse') }}</span>
                </div>
                <div class="col-md-2 text-center">
                        <button class='btn btn-primary addButton' type="submit" style="margin-top: 0">
                            {{trans('admin::shopping.warehouses.add.label.button-save')}}
                        </button>
                </div>
            </div>
            {!! Form::hidden('id_product', $id) !!}
            {!! Form::hidden('id_country', '',['id'=>'id_country_hidden']) !!}
            <input type="hidden" name="id_country_product" value="{{ $productCountryId }}">
        </fieldset>
    {!! Form::close() !!}
</div><br />
<div class="form-group">
    <div class="table">
        <table class="table table-striped" id="tb_products">
            <thead>
                <tr>
                    <th>@lang('admin::shopping.warehouses.product.label.wherehouse')</th>
                    <th class="text-center">@lang('admin::shopping.warehouses.product.label.status')</th>
                    <th>@lang('admin::shopping.warehouses.product.label.action')</th>
                </tr>
            </thead>
            <tbody>
                @foreach($selectedWarehousesProduct as $sWA)
                    <tr>
                        <td> <i class="fa fa-building" aria-hidden="true"></i> - {{ $sWA->warehouse }}  </td>
                        <td class="text-center">
                            @if($sWA->activeRow == 1)
                                <span class="label label-success cActive_{{ $sWA->idRow }}">{{ trans('admin::shopping.products.index.product_active') }}</span>
                                <span class="label label-default cInactive_{{ $sWA->idRow }}" style="display: none">{{ trans('admin::shopping.products.index.product_inactive') }}</span>
                            @else
                                <span class="label label-success cActive_{{ $sWA->idRow }}" style="display: none">{{ trans('admin::shopping.products.index.product_active') }}</span>
                                <span class="label label-default cInactive_{{ $sWA->idRow }}">{{ trans('admin::shopping.products.index.product_inactive') }}</span>
                            @endif
                        </td>
                        <td>
                            <div class="row" style="padding: 0">
                                <div class="col-xs-6 text-center">
                                    @if($sWA->activeRow == 1)
                                        <spam class="actDisabled cActive_{{ $sWA->idRow }}" id="{{ $sWA->idRow }}" ><i class="fa fa-stop" aria-hidden="true"></i></spam>
                                        <spam class="actEnabled cInactive_{{ $sWA->idRow }}" id="{{ $sWA->idRow }}" style="display: none"><i class="fa fa-play" aria-hidden="true"></i></spam>
                                    @else
                                        <spam class="actDisabled cActive_{{ $sWA->idRow }}" id="{{ $sWA->idRow }}" style="display: none"><i class="fa fa-stop" aria-hidden="true"></i></spam>
                                        <spam class="actEnabled cInactive_{{ $sWA->idRow }}" id="{{ $sWA->idRow }}" ><i class="fa fa-play" aria-hidden="true"></i></spam>
                                    @endif
                                </div>
                                <div class="col-xs-6 text-center">
                                    {!! Form::open( ['route' => 'admin.products.warehousedelete', 'id' => 'delete_form_'.$sWA->idRow]) !!}
                                    <i class="fa fa-trash" aria-hidden="true" onclick="document.getElementById('delete_form_{{$sWA->idRow}}').submit();"></i>
                                    <input type="hidden" name="id" value="{{ $sWA->idRow }}">
                                    <input type="hidden" name="id_product" value="{{ $id }}">
                                    <input type="hidden" name="id_country" id="id_country_hidden" value="{{ $countryUserSelected }}">
                                    <input type="hidden" name="id_country_product" value="{{ $productCountryId }}">
                                    {!! Form::close() !!}
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <p class="text-center">
        <a class="btn btn-default" href="{{ route('admin.products.index') }}">
            {{ trans('admin::shopping.warehouses.add.label.back_list') }}
        </a>
    </p>
</div>
@section('scripts')
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script type="text/javascript">
             $('#tb_products').DataTable({ "responsive": true,
         "language": { 
                    "url": "{{ trans('admin::datatables.lang') }}"
               }    
        });
        
        $( document ).ready(function() {
            load_editor_js();
            $("#countryForm li a:first").click();
            $(".accordion-toggle:first").click();       
            $('#id_country_hidden').val($('.country_id').val());
            $('.country_id').change(function () {
                $("form[name='country_form']").submit();
            });
        });

        $(".actDisabled").click(function () {
            axios.post('{{ route('admin.products.warehouseoff') }}', {
                id: $(this).attr('id')
            }).then(function (response) {
                $('.cActive_'+ response.data.id).hide();
                $('.cInactive_'+ response.data.id).show();
            }).catch(function (error) {
                console.log(error);
            });
        });

        $(".actEnabled").click(function () {
            axios.post('{{ route('admin.products.warehouseon') }}', {
                id: $(this).attr('id')
            }).then(function (response) {
                $('.cActive_'+ response.data.id).show();
                $('.cInactive_'+ response.data.id).hide();
            }).catch(function (error) {
                console.log(error);
            });
        });
    </script>
@endsection