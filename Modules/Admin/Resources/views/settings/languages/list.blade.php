<div class="row textbox">
    <div class="col-sm-6">
        <h1>{{ trans('admin::language.lang_list') }}</h1>
    </div>
    <div class="col-sm-6 text-right">
        @if (Auth::action('languages.add') == true)
            <a href="{{ route('admin.languages.add') }}" class="btn btn-warning addButton"><i class="fa fa-plus"></i> &nbsp;
                {{ trans('admin::language.lang_add') }}</a>
        @endif
    </div>
</div>

<div class="table-responsive">
    @if (isset($success))
        <div class="alert alert-success alert-dismissible">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            {{ $action == 'edit' ? trans('admin::language.lang_edit_success', array('lang' => $lang)) : trans('admin::language.lang_add_success', array('lang' => $lang)) }}
        </div>
    @endif
    <table class="table table-striped" id="tb_lang">
        <thead>
        <tr>
            <th>{{ trans('admin::language.lang_list_key') }}</th>
            <th>{{ trans('admin::language.lang_list_corbiz') }}</th>
            <th>{{ trans('admin::language.lang_list_name') }}</th>
            <th>{{ trans('admin::language.lang_list_active') }}</th>
            @if (Auth::action('languages.edit') || Auth::action('languages.delete'))
                <th>{{ trans('admin::language.lang_list_actions') }}</th>
            @endif
        </tr>
        </thead>
        <tbody>
        @foreach ($languages as $languague)
            <tr id="lang_{!! $languague->id !!}">
                <td>{!! $languague->locale_key !!}</td>
                <td>{!! $languague->corbiz_key !!}</td>
                <td>{!! $languague->language !!}</td>
                <td>
                    <span class="label label-success langActive" style="display:{{ ($languague->active == 1) ? '' : 'none' }}">{{ trans('admin::language.lang_list_st_active') }}</span>
                    <span class="label label-default langInactive" style="display:{{ ($languague->active == 0) ? '' : 'none' }}">{{ trans('admin::language.lang_list_st_inactive') }}</span>
                </td>
                @if (Auth::action('languages.edit') || Auth::action('languages.active') || Auth::action('languages.delete'))
                    <td data-lid="{!! $languague->id !!}">
                        @if (Auth::action('languages.active'))
                            <?php $enable = ($languague->active == 0) ? null : ' hide'; ?>
                            <?php $disable = ($languague->active == 0) ? ' hide' : null; ?>
                            <i onclick="inactivate({!! $languague->id !!})" class="glyphicon glyphicon-stop itemTooltip{!! $enable !!}" title="{{ trans('admin::language.lang_list_enable') }}"></i>
                            <i onclick="activate({!! $languague->id !!})" class="glyphicon glyphicon-play itemTooltip{!! $disable !!}" title="{{ trans('admin::language.lang_list_disable') }}"></i>
                            <a class="glyphicon glyphicon-pencil itemTooltip" href="{{ route('admin.languages.edit', ['langId' => $languague->id]) }}" title="{{ trans('admin::language.lang_list_edit') }}"></a>
                            @if (Auth::action('languages.delete'))
                                <form id="delete-lang-form-{{ $languague->id }}" action="{{ route('admin.languages.delete', $languague->id) }}", method="POST" style="display: inline">
                                    {{ csrf_field() }}
                                    <a onclick="deleteElement(this)" data-code="{{ $languague->id }}" data-element="{{ $languague->language }}" id="delete-{{ $languague->id }}" class="glyphicon glyphicon-trash itemTooltip" href="#" title="{{ trans('admin::language.delete_lang') }}"></a>
                                </form>
                            @endif
                        @endif
                    </td>
                @endif
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

@section('scripts')
    <script type="text/javascript">

        $('#tb_lang').DataTable({
            "responsive": true,
            "ordering": false,
                 "language": { 
                    "url": "{{ trans('admin::datatables.lang') }}"
               }   
        });

        function deleteElement(element) {
            var code = $(element).data('code');
            var name = $(element).data('element');

            $('#confirm-modal .modal-body').text('{{trans('admin::shopping.products.index.confirm')}} ' + name + '?');

            $('#confirm-modal').modal({
                backdrop: 'static',
                keyboard: false
            }).one('click', '#delete', function(e) {
                $('#delete-lang-form-'+code).submit();
            });
        }

        function disable_lang(lang_id, active) {
            $.ajax({
                url: route('admin.languages.edit.post', {langId: lang_id, action: 'status'}),
                type: 'POST',
                data: {set: active},
                success: function (r) {
                    if (r == 1) {
                        if (active == 0) {
                            $("#lang_" + lang_id + " .glyphicon-play").addClass('hide');
                            $("#lang_" + lang_id + " .glyphicon-stop").removeClass('hide');
                            $("#lang_" + lang_id + " .langActive").hide();
                            $("#lang_" + lang_id + " .langInactive").show();
                        }
                        else {
                            $("#lang_" + lang_id + " .glyphicon-stop").addClass('hide');
                            $("#lang_" + lang_id + " .glyphicon-play").removeClass('hide');
                            $("#lang_" + lang_id + " .langActive").show();
                            $("#lang_" + lang_id + " .langInactive").hide();
                        }
                    }
                    else {
                        cms_alert('danger', '{{ trans('admin::language.lang_err_disable')  }}');
                    }
                }
            });
        }

        function activate(id) {
            disable_lang(id,0);
        }

        function inactivate(id) {
            disable_lang(id,1);
        }

    </script>
@stop
