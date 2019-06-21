@section('styles')
    <style>
        .ui-datepicker-title select{
            color: black;
        }
    </style>
@endsection
<h1>@lang('admin::shopping.reports.views.title_order')</h1>
<div class="container">
    <fieldset class="fieldset_gray">
        <legend class="legend_gray">@lang('admin::shopping.reports.views.filter')</legend>
        <div class="form-group">
            @if(session('msg'))
                <div class="alert {{ session('alert') }} alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    {{ session('msg') }}
                </div>
            @endif
            <form name="form-product" action="{{ route('admin.report.ordersgenerate') }}"  id="form-product" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-md-3">
                        <label>@lang('admin::shopping.reports.inputs.labels.country')</label>
                        <select name="country" class="form-control">
                            <option value="0" {{ old('country') == 0?'selected':'' }} >All</option>
                            @foreach(Auth::user()->countries as $userCountry)
                                <option value="{{ $userCountry->id }}" {{ old('country') == $userCountry->id?'selected':'' }}>{{ $userCountry->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label for="from">@lang('admin::shopping.reports.inputs.labels.from')</label>
                        <input type="text" class="form-control" id="from" name="from" value="{{ old('from') }}" placeholder="@lang('admin::shopping.reports.inputs.placeholders.from')">
                    </div>
                    <div class="col-md-2">
                        <label for="to">@lang('admin::shopping.reports.inputs.labels.to')</label>
                        <input type="text" class="form-control" id="to" name="to" value="{{ old('to') }}" placeholder="@lang('admin::shopping.reports.inputs.placeholders.to')">
                        <span class="error-product help-block" style="color: red"> </span>
                    </div>
                    <div class="col-md-3">
                        <label>@lang('admin::shopping.reports.inputs.labels.eo')</label>
                        <input type="text" name="eo" class="form-control" value="{{ old('eo') }}" placeholder="@lang('admin::shopping.reports.inputs.placeholders.eo')">
                    </div>
                    <div class="col-md-2 text-left product-response" ><br />
                        <button type="submit" id="button-product" class="btn btn-default">
                            @lang('admin::shopping.reports.buttons.submit')
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </fieldset>
</div>
@section('scripts')
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script>
    $( function() {
        var dateFormat = "yy-mm-dd",
            from = $( "#from" )
                .datepicker({
                    changeMonth: true,
                    changeYear: true,
                    dateFormat: 'yy-mm-dd',
                    numberOfMonths: 1
                })
                .on( "change", function() {
                    to.datepicker( "option", "minDate", getDate( this ) );
                }),
            to = $( "#to" ).datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat: 'yy-mm-dd',
                numberOfMonths: 1
            })
                .on( "change", function() {
                    from.datepicker( "option", "maxDate", getDate( this ) );
                });

        function getDate( element ) {
            var date;
            try {
                date = $.datepicker.parseDate( dateFormat, element.value );
            } catch( error ) {
                date = null;
            }
            return date;
        }
    } );
</script>
@stop