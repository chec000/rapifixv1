<div class="row textbox">
    <div class="col-sm-6">
        <h1>{!! trans('admin::themes.labels.beacon_list') !!}</h1>
    </div>
    <div class="col-sm-6 text-right">
        <button class="btn btn-warning addButton"><i class="fa fa-plus"></i> &nbsp; {!! trans('admin::themes.buttons.import') !!}</button>
    </div>
</div>

<p>{!! trans('admin::themes.labels.beacon_title') !!}<a href="http://kontakt.io" target="_blank">Kontakt.io</a>
    {!! trans('admin::themes.labels.beacon_info') !!} <a href="http://www.coastercms.org/beacons" target="_blank">{!! trans('admin::themes.labels.beacon_here') !!}</a>.</p>

@if ($rows)
    <p>{!! trans('admin::themes.labels.beacon_page_info') !!}</p>

    @if (!$bitly)
        <p class="text-danger">{!! trans('admin::themes.labels.beacon_url_info_danger') !!}<a href="https://bitly.com/a/oauth_apps" target="_blank">{!! trans('admin::themes.labels.beacon_token') !!}</a>{!! trans('admin::themes.labels.beacon_token_system') !!} .</p>
    @else
        <p class="text-success">{!! trans('admin::themes.labels.beacon_url_info_sucess') !!}</p>
    @endif

@else
    <p class="text-danger">{!! trans('admin::themes.labels.beacon_not_found') !!}<a href="https://support.kontakt.io/hc/en-gb/articles/201628731-How-do-I-find-my-developer-API-Key-" target="_blank">{!! trans('admin::themes.labels.beacon_key') !!}</a> {!! trans('admin::themes.labels.beacon_api') !!}.</p>
@endif

<p>&nbsp;</p>

<table class="table table-bordered" id="beacons">

    <thead>
    <tr>
        <th>{!! trans('admin::themes.labels.beacon_id') !!}</th>
        <th>{!! trans('admin::themes.labels.beacon_ui') !!}</th>
        <th>{!! trans('admin::themes.labels.type') !!}</th>
        <th>{!! trans('admin::themes.labels.beacon_name') !!}</th>
        <th></th>
    </tr>
    </thead>

    <tbody>
    {!! $rows !!}
    </tbody>

</table>

<p class="text-danger">{!! trans('admin::themes.labels.beacon_shared') !!}<p>

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            $('.addButton').click(function () {
                $.ajax({
                    url: route('admin.themes.beacons.post'),
                    type: 'POST',
                    data: {add: true},
                    success: function (r) {
                        $('#beacons tbody').html(r);
                    }
                });
            });
            $('.glyphicon-remove').click(function () {
                var button = $(this);
                $.ajax({
                    url: route('admin.themes.beacons.post'),
                    type: 'POST',
                    data: {delete_id: $(this).data('id')},
                    success: function () {
                        button.parent().parent().remove();
                    }
                });
            });
        });
    </script>
@endsection
