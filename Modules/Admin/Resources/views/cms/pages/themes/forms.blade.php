<h1>{!! trans('admin::themes.labels.form_rules') !!}{{ !empty($template)?' - '.trans('admin::themes.labels.'.$template):'' }}</h1>

@if (!empty($template))

    {!! Form::open() !!}

    <div class="table-responsive">
        <table id="rules" class="table table-striped">
            <thead>
            <tr>
                <th>{!! trans('admin::themes.labels.field') !!}</th>
                <th>{!! trans('admin::themes.labels.rule') !!}</th>
                <th>{!! trans('admin::themes.labels.remove') !!}</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($rules as $rule)
                <tr id="rule_{!! $rule->id !!}">
                    <td>
                        {!! Form::text('rule['.$rule->id.'][field]', $rule->field, ['class' => 'form-control']) !!}
                    </td>
                    <td>
                        {!! Form::text('rule['.$rule->id.'][rule]', $rule->rule, ['class' => 'form-control']) !!}
                    </td>
                    <td>
                        <i class="glyphicon glyphicon-remove itemTooltip" title="{!! trans('admin::themes.labels.remove_rule') !!}" onclick="delete_rule('{!! $rule->id !!}')"></i>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div class="row textbox">
        <div class="col-sm-12">
            <button type="button" class="btn add_rule" onclick="add_rule()"><i class="fa fa-plus"></i>
                &nbsp; {!! trans('admin::themes.labels.add_rule') !!}
            </button>
            <button class="btn btn-primary" type="submit"><i class="fa fa-floppy-o"></i> &nbsp; {!! trans('admin::themes.labels.save_rules') !!}</button>
        </div>
    </div>

    {!! Form::close() !!}

    @section('scripts')
        <script type='text/javascript'>

            var new_rule = 1;

            function delete_rule(id) {
                $("#rule_" + id).remove();
            }

            function add_rule() {
                var id = 'new' + new_rule;
                new_rule++;
                $("#rules tbody").append('<tr id="rule_' + id + '">' +
                        '<td><input class="form-control" name="rule[' + id + '][field]" type="text"></td>' +
                        '<td><input class="form-control" name="rule[' + id + '][rule]" type="text"></td>' +
                        '<td><i class="glyphicon glyphicon-remove itemTooltip" title="{!! trans('admin::themes.labels.remove_rule') !!}" onclick="delete_rule(\'' + id + '\')"></i></td>' +
                        '</tr>'
                );
                $('.itemTooltip').tooltip({placement: 'bottom', container: 'body'});
            }

        </script>
    @stop


@else
    
    <p>{!! trans('admin::themes.labels.form_validations') !!}</p>

    @if (!empty($templates))

        <h2>{!! trans('admin::themes.labels.form_templates_found') !!}</h2>

        <ul>

        @foreach($templates as $template)

            <li><a href="{{ route('admin.themes.forms', ['template' => $template]) }}">{!! trans('admin::themes.labels.'.$template) !!}</a></li>

        @endforeach

        </ul>

    @else

        <h2>{!! trans('admin::themes.labels.form_templates_not_found') !!}</h2>

    @endif

@endif