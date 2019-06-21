<h1>@lang('admin::shopping.reports.views.title_index')</h1>
<div class="container">

</div>
@section('scripts')
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script>
    $('#brand-modal').modal({
        show: true,
        keyboard: false,
        backdrop: 'static',
    });
    $('#close-modal').click(function () {
        history.go(-1);
    });
    $("#select-report").change(function () {
        var option = $(this).val();
        window.location = option;
    });
</script>
@stop