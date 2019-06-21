<div class="row textbox">
    <div class="col-sm-6">
        <h1>{{ trans('admin::vars.vars_list') }}</h1>
    </div>
    <div class="col-sm-6 text-right">
        @if ($can_save)
          <button type="button" class="btn btn-warning addButton add-var">
            <i class="fa fa-plus"></i> &nbsp;
            {{ trans('admin::vars.vars_add') }}
          </button>
        @endif
    </div>
</div>

{{ Form::open() }}

<div class="table">
    @if (Session::has('message'))
        <div class="alert alert-success alert-dismissible">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            {!! Session::get('message') !!}
        </div>
    @endif
    @if (Session::has('error'))
        <div class="alert alert-danger alert-dismissible">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            {!! Session::get('error') !!}
        </div>
    @endif
    <table class="table table-striped" id="tb_vars">
        <thead>
        <tr>
            <th>{{ trans('admin::vars.vars_list_name') }}</th>
            <th>{{ trans('admin::vars.vars_list_value') }}</th>
            <th>{{ trans('admin::vars.vars_list_description') }}</th>
            @if ($can_delete)
                <th>{{ trans('admin::vars.vars_list_actions') }}</th>
            @endif
        </tr>
        </thead>
        <tbody>
        @foreach ($vars as $var)
            <tr id="var_{!! $var->id !!}">
                <td>
                  {!! Form::hidden('id[]', $var->id, ['class' => 'form-control']) !!}
                  {!! Form::text('name[]', old("name", isset($var->name) ? $var->name : ''), ['class' => 'form-control']) !!}
                </td>
                <td>
                  {!! Form::text('value[]', old("value", isset($var->value) ? $var->value: ''), ['class' => 'form-control']) !!}
                </td>
                <td>
                  {!! Form::text('label[]', old("label", isset($var->label) ? $var->label : ''), ['class' => 'form-control']) !!}
                </td>
                @if ($can_delete)
                    <td data-lid="{!! $var->id !!}">
                        <a class="glyphicon glyphicon-remove delete-var" value='{!! $var->id !!}'></a>
                    </td>
                @endif
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

<div class="row textbox">
  <div class="col-sm-12">
    @if ($can_save)
      <button type="button" class="btn btn-default add-var">
        <i class="fa fa-plus"></i> &nbsp;
        {{ trans('admin::vars.vars_add') }}
      </button>
      <button type="submit" class="btn btn-primary">
        <i class="fa fa-floppy-o"></i> &nbsp;
        {{ trans('admin::vars.vars_save') }}
      </button>
    @endif
  </div>
</div>

{!! Form::close() !!}

@section('scripts')
    <script type="text/javascript">
      var DELETE_ROUTE = '{!! route('admin.vars.delete') !!}';
      var CONFIRM_DIALOG = '{!! trans('admin::vars.vars_delete_confirm') !!}';
      var CSRF = '{!! csrf_field() !!}';
      function addVarRow() {
        var row = $('<tr></tr>');
        row.append('<td>{!! Form::hidden('id[]', 0, ['class' => 'form-control']) !!}{!! Form::text('name[]', '', ['class' => 'form-control']) !!}</td>');
        row.append('<td>{!! Form::text('value[]', '', ['class' => 'form-control']) !!}</td>');
        row.append('<td>{!! Form::text('label[]', '', ['class' => 'form-control']) !!}</td>');
        var deleteBtn = $('<a class="glyphicon glyphicon-remove itemTooltip" title="{{ trans('admin::vars.vars_list_delete') }}"></a>');
        deleteBtn.click(function() {
          $(this).closest('tr').remove();
        });
        var col = $('<td></td>').append(deleteBtn);
        row.append(col);
        $('#tb_vars > tbody:last-child').append(row);
      }
      $('.add-var').click(function(){
        addVarRow();
      });
      $('.delete-var').click(function() {
        var confirmVal = confirm(CONFIRM_DIALOG);
        if (confirmVal == true) {
          var element = $(this);
          $.ajax({
            url: DELETE_ROUTE,
            method: 'POST',
            data: {
              csrf: CSRF,
              id: element.attr('value'),
            },
            complete: function () {
              element.closest('tr').remove();
            }
          });
        }
      });
    </script>
@stop
