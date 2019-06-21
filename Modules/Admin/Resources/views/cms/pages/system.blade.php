<h1>{{ trans('admin:system.header') }}</h1>

<br/>

<div id="system_tabs" class="tabbable">

    <ul class="nav nav-tabs">
        <li id="navtab0"><a href="#tab0" data-toggle="tab">{{ trans('admin:system.settings') }}</a></li>
        <li id="navtab1"><a href="#tab1" data-toggle="tab">{{ trans('admin:system.site_health') }}</a></li>
        @if (Auth::action('coaster.wpimport'))
            <li id="navtab2"><a href="#tab2" data-toggle="tab">{{ trans('admin:system.import_tools') }}</a></li>
        @endif
    </ul>

    <div class="tab-content">

        <div class="tab-pane" id="tab0">
            <br />
            {!! Form::open(['url' => Request::url()]) !!}

            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>{{ trans('admin:system.name') }}</th>
                            <th>{{ trans('admin:system.value') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($site_details as $setting)
                            <tr>
                                <td>{!!$setting->label !!}</td>
                                <td>
                                    <?php $inputDetails = ($setting->editable) ? ['class' => 'form-control'] :
                                        ['class' => 'form-control', 'disabled' => true]; ?>
                                    @if (is_string($setting->value))
                                        {!! Form::text($setting->name, $setting->value, $inputDetails) !!}
                                    @else
                                        {!! Form::select($setting->name, $setting->value->options,
                                            $setting->value->selected, $inputDetails) !!}
                                    @endif
                                    @if ($setting->note)
                                        <span class="help-block">{!! $setting->note !!}</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if (Auth::action('system.update'))
                <div class="form-group">
                    {!! Form::submit(trans('admin:system.update'), ['class' => 'btn btn-primary']) !!}
                </div>
            @endif
            {!! Form::close() !!}
        </div>
        <div class="tab-pane" id="tab1">
            <br/>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <tbody>
                    <tr>
                        <td>{{ trans('admin:system.php_version') }}</td>
                        <td>
                            <span class="{{ version_compare(phpversion(), '5.5.9')?'text-success':'text-danger' }}">
                                {{ phpversion() }}&nbsp; ({{ trans('admin:system.required') }}: 5.5.9+)</span>
                        </td>
                    </tr>
                    <tr>
                        <td>{{ trans('admin:system.site_version') }}</td>
                        @if ($can_upgrade && $upgrade->required)
                            <td>
                                <span class="text-warning">{{ $upgrade->from }}
                                    [{{ trans('admin:system.latest_release') }} {{ $upgrade->to }}]</span>
                                <a href="{{ route('admin.system.upgrade') }}">({{ trans('admin:system.upgrade') }})</a>
                            </td>
                        @else
                            <td>
                                <span class="text-success">{{ $upgrade->from }}
                                    [{{ trans('admin:system.latest_release') }} {{ $upgrade->to }}]</span>
                            </td>
                        @endif
                    </tr>
                    <tr>
                        <td>{{ trans('admin:system.database_structure') }}</td>
                        <td>
                            @if (!empty($database_structure['errors']))
                                <span class="text-danger">
                                    {{ count($database_structure['errors']) . ' ' . str_plural(trans('admin:system.errors'),
                                        count($database_structure['errors'])) . ' ' . trans('admin:system.found') }}
                                </span>
                            @elseif (!empty($database_structure['warnings']))
                                <span class="text-warning">
                                    {{ count($database_structure['warnings']) . ' ' . str_plural(trans('admin:system.warnings'),
                                        count($database_structure['warnings'])) . ' ' . trans('admin:system.found') }}
                                </span>
                            @elseif (!empty($database_structure['notices']))
                                <span class="text-success">
                                    {{ count($database_structure['notices']).' '.str_plural(trans('admin:system.notices'),
                                        count($database_structure['notices'])) . ' ' . trans('admin:system.found') }}
                                </span>
                            @else
                                <span class="text-success">{{ trans('admin:system.no_errors') }}</span>
                            @endif
                            @if ($can_validate)
                                <a href="{{ route('admin.system.validate-db') }}">
                                    ({{ trans('admin:system.more_details') }})
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>{{ trans('admin:system.search_index') }}</td>
                        <td>
                            @if ($last_indexed_search)
                                <span id="last_indexed_search">
                                    {{ trans('admin:system.last_ran') }} - {{ $last_indexed_search }}
                                </span>
                                @if ($can_index_search)
                                    <a href="javascript:void(0)" id="search_index">(reindex)</a>
                                @endif
                            @else
                                N/A
                            @endif
                        </td>
                    </tr>
                    </tbody>
                </table>

                @if ($can_upgrade && $upgrade->required)
                    <br/><br/>
                    <a class="btn btn-primary" href="{{ route('admin.system.upgrade') }}">
                        {{ trans('admin:system.upgrade_cms') }}
                    </a>
                @endif
            </div>
        </div>
        @if (Auth::action('coaster.wpimport'))
            <div class="tab-pane" id="tab2">
                <br/>
                <a class="btn btn-primary" href="{{ route('admin.wpimport') }}">
                    {{ trans('admin:system.wordpress') }}
                </a>
            </div>
        @endif
    </div>
</div>

@section('scripts')
    <script type='text/javascript'>
        $(document).ready(function () {
            $('#system_tabs a:first').tab('show');
            $('#search_index').click(function () {
                $('#search_index').html("(reindex in progress)");
                $.ajax({
                    url: route('admin.system.search'),
                    type: 'GET',
                    success: function (r) {
                        if (r == 1) {
                            $('#last_indexed_search').addClass("text-success");
                            $('#last_indexed_search').html("successfully re-indexed");
                        }
                        else {
                            $('#last_indexed_search').addClass("text-danger");
                            $('#last_indexed_search').html("failed to reindex");
                        }
                        $('#search_index').html("(reindex)");
                    }, error: function (jqXHR, timeout, message) {
                        var contentType = jqXHR.getResponseHeader("Content-Type");
                        if (jqXHR.status === 200 && contentType.toLowerCase().indexOf("text/html") >= 0) {
                            window.location.reload();
                        }
                    }
                });
            });
        });
    </script>
@endsection
