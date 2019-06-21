<h1>{{ trans('admin::redirects.header') }}</h1>

<div class="row textbox">
    <div class="col-sm-12">
        <p>{{ trans('admin::redirects.force_option') }}</p>
        <p>{{ trans('admin::redirects.force_option_explain') }}</p>
    </div>
</div>

{!! Form::open(['id' => 'editForm', 'enctype' => 'multipart/form-data']) !!}

<div class="table-responsive">
    <table id="redirects" class="table table-striped">
        <thead>
        <tr>
            <th><a href="{!! route('admin.redirects.index').'?order=redirect' !!}">{{ trans('admin::redirects.from') }}</a></th>
            <th><a href="{!! route('admin.redirects.index').'?order=to' !!}">{{ trans('admin::redirects.to') }}</a></th>
            <th><a href="{!! route('admin.redirects.index').'?order=forced' !!}">{{ trans('admin::redirects.forced') }}</a></th>
            @if ($can_edit)
                <th>{{ trans('admin::redirects.remove') }}</th>
            @endif
        </tr>
        </thead>
        <tbody>
        @foreach ($redirects as $redirect)
            <tr id="redirect_{!! $redirect->id !!}">
                <td>
                    @if ($can_edit)
                        {!! Form::text('redirect['.$redirect->id.'][from]', $redirect->redirect, ['class' => 'form-control']) !!}
                    @else
                        {!! $redirect->redirect !!}
                    @endif
                </td>
                <td>
                    @if ($can_edit)
                        {!! Form::text('redirect['.$redirect->id.'][to]', $redirect->to, ['class' => 'form-control']) !!}
                    @else
                        {!! $redirect->to !!}
                    @endif
                </td>
                <td>
                    @if ($can_edit)
                        {!! Form::checkbox('redirect['.$redirect->id.'][force]', 1, $redirect->force, ['class' => 'form-control']) !!}
                    @else
                        {!! ($redirect->force==1) ? trans('admin::redirects.yes') : trans('admin::redirects.no') !!}
                    @endif
                </td>
                @if ($can_edit)
                    <td>
                        <i class="glyphicon glyphicon-remove itemTooltip" title="{{ trans('admin::redirects.remove_redirect') }}"
                           onclick="delete_redirect('{!! $redirect->id !!}')"></i>
                    </td>
                @endif
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

@if ($can_edit)
    <div class="row textbox">
        <div class="col-sm-12">
            <button type="button" class="btn add_another" onclick="add_redirect()"><i class="fa fa-plus"></i>
                &nbsp; {{ trans('admin::redirects.add') }}
            </button>
            <button class="btn btn-primary" type="submit"><i class="fa fa-floppy-o"></i>
                &nbsp; {{ trans('admin::redirects.save') }}
            </button>
        </div>
    </div>
@endif

{!! Form::close() !!}


@section('scripts')
    <script type='text/javascript'>

        function delete_redirect(id) {
            var check_new = id.toString().substr(0, 3);
            if (check_new != 'new') {
                $.ajax({
                    url: route('admin.redirects.edit'),
                    type: 'POST',
                    data: {delete_id: id},
                    success: function () {
                        $("#redirect_" + id).remove();
                    }
                });
            }
            else {
                $("#redirect_" + id).remove();
            }
        }

        var new_redirect = 1;

        @if ($can_edit)
        function add_redirect() {
            var id = 'new' + new_redirect;
            new_redirect++;
            $("#redirects > tbody").append('<tr id="redirect_' + id + '">' +
                    '<td><input class="form-control" name="redirect[' + id + '][from]" type="text"></td>' +
                    '<td><input class="form-control" name="redirect[' + id + '][to]" type="text"></td>' +
                    '<td><input name="redirect[' + id + '][force]" class="form-control" type="checkbox" value="1"></td>' +
                    '<td><i class="glyphicon glyphicon-remove itemTooltip" title="Remove Redirect" onclick="delete_redirect(\'' + id + '\')"></i></td>' +
                    '</tr>'
            );
            $('.itemTooltip').tooltip({placement: 'bottom', container: 'body'});
        }
        @endif

    </script>
@stop
