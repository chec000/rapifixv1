<h1>@lang('admin::shopping.filters.view.title_rel')</h1>
<h3>@lang('admin::shopping.filters.view.brand') : {{ $filter->brandGroup->brand->name }} </h3>
<h3>@lang('admin::shopping.filters.view.filter') : {{ $filter->code }} - {{$filter->name }} </h3>
@if(session('msg'))
    <div class="alert {{ session('alert') }} alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        {{ session('msg') }}
    </div>
@endif
<div class="form-group">
    <div class="row">
        <div class="col-md-12">
            {!! Form::label('country_id', trans('admin::shopping.filters.input.label.country'), ['class' => 'control-label']) !!}
            <select class="form-control" onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
                @foreach($countryUser as $key => $cU)
                    @php $selected = $key == $countryUserSelected ? 'selected' : ''; @endphp
                    <option {{$selected}} value="{{ route('admin.filters.categoriesshow', ['code' => $filter->code, 'idCountry' => $key, 'idCategory' => 0]) }}">
                        {{ $cU }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            {!! Form::label('category_id', trans('admin::shopping.filters.input.label.category'), ['class' => 'control-label']) !!}
            <select class="form-control" onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
                @foreach($categoryCountry as $key => $cC)
                    @php $selected = $key == $categoryCountrySelected ? 'selected' : ''; @endphp
                    <option {{$selected}} value="{{ route('admin.filters.categoriesshow', ['code' => $filter->code, 'idCountry' => $countryUserSelected, 'idCategory' => $key]) }}">
                        {{ $cC }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="row">
        {!! Form::open( ['route' => 'admin.filters.categoriescreate']) !!}
        <div class="col-md-10">
            {!! Form::label('product_id', trans('admin::shopping.filters.input.label.product'), ['class' => 'control-label']) !!}
            {!! Form::select('product_id', $categoryProducts, '', ['required','class' => 'form-control']) !!}
            <span class="help-block" style="color: red">{{ $errors->first('product_id') }}</span>
        </div>
        <div class="col-md-2 text-center">
            <br />
            <button class='btn btn-primary addButton' type="submit" style="margin-top: 0">
                @lang('admin::shopping.filters.buttons.save')
            </button>
        </div>
        {!! Form::hidden('category_id', $categoryCountrySelected) !!}
        {!! Form::hidden('country_id', $countryUserSelected) !!}
        {!! Form::hidden('filter_id', $filter->id) !!}
        {!! Form::hidden('filter_code', $filter->code) !!}
        {!! Form::close() !!}
    </div>
</div><br />
<div class="form-group">
    <div class="table">
        <table class="table">
            <thead>
                <tr>
                    <th>@lang('admin::shopping.filters.view.product')</th>
                    <th class="text-center">@lang('admin::shopping.filters.view.delete')</th>
                </tr>
            </thead>
            <tbody>
                @foreach($filterProducts as $fP)
                    <tr>
                        <td> {{ $fP->countryProduct->product->sku }} - {{ $fP->countryProduct->product->global_name }} </td>
                        <td class="text-center">
                            {!! Form::open( ['route' => 'admin.filters.categoriesdelete', 'id' => 'delete_form']) !!}
                            <i class="fa fa-trash" aria-hidden="true" onclick="document.getElementById('delete_form').submit();"></i>
                            {!! Form::hidden('id', $fP->id) !!}
                            {!! Form::hidden('category_id', $categoryCountrySelected) !!}
                            {!! Form::hidden('country_id', $countryUserSelected) !!}
                            {!! Form::hidden('filter_id', $filter->id) !!}
                            {!! Form::hidden('filter_code', $filter->code) !!}
                            {!! Form::close() !!}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <p class="text-center">
        <a class="btn btn-default" href="{{ route('admin.filters.index') }}">
            @lang('admin::shopping.filters.buttons.back_list')
        </a>
    </p>
</div>
@section('scripts')
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script type="text/javascript"> </script>
@endsection