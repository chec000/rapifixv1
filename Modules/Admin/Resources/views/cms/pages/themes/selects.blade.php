<h1>{!! trans('admin::themes.labels.select_block_options') !!} {{ !empty($block)?' - '.trans('admin::themes.labels.'.$block->name):""  }}</h1>

@if (!empty(Session::get('resultSaved')))
    <div class="alert alert-{{!empty(Session::get('resultSaved.type_alert')) ? Session::get('resultSaved.type_alert') : ''}} alert-dismissible">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        {{!empty(Session::get('resultSaved.message_alert')) ? Session::get('resultSaved.message_alert') : ''}}
    </div>
@endif

@if (!empty($block))

    <p><a href="{{ route('admin.themes.selects') }}">&raquo; {!! trans('admin::themes.labels.back_select_option') !!}</a></p>

    {!! Form::open() !!}

    @if (!empty($import))

        <p><a href="{{ route('admin.themes.selects', ['blockId' => $block->id]) }}">&raquo; {!! trans('admin::themes.labels.manage_options') !!}</a></p>
        <p>&nbsp;</p>

        <div class="row">

            <div class="col-sm-12">

                <div class="form-group row">
                    <label for="selectOptionImport" class="control-label col-sm-2">{!! trans('admin::themes.labels.import_from') !!}</label>
                    <div class="col-sm-10">
                        {!! Form::select('selectOptionImport', $import, null, ['class' => 'form-control']) !!}
                    </div>
                </div>

                <div class="form-group row">
                    <label for="selectOptionText" class="control-label col-sm-2">{!! trans('admin::themes.labels.import_option') !!}</label>
                    <div class="col-sm-10">
                        {!! Form::text('selectOptionValue', '<span class="fa {{$match}}"></span>', ['class' => 'form-control']) !!}
                    </div>
                </div>

                <div class="form-group row">
                    <label for="selectOptionValue" class="control-label col-sm-2">{!! trans('admin::themes.labels.import_option_text') !!}</label>
                    <div class="col-sm-10">
                        {!! Form::text('selectOptionText', 'fa $match', ['class' => 'form-control']) !!}
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button class="btn btn-primary" type="submit"><span class="glyphicon glyphicon-upload glyphicon-white"></span>
                            &nbsp; Import
                        </button>
                    </div>
                </div>

            </div>

        </div>

    @else

        <p><a href="{{ route('admin.themes.selects', ['blockId' => $block->id, 'import' => 1]) }}">&raquo; {!! trans('admin::themes.labels.import_options_from_source') !!}</a></p>
        <p>&nbsp;</p>

        <div class="table-responsive">
            <table id="selectOptions" class="table table-striped">
                <thead>
                <tr>
                    <th>{!! trans('admin::themes.fields.option_text') !!}</th>
                    <th>{!! trans('admin::themes.fields.option_value') !!}</th>
                    @if (in_array($block->id, explode(",", config('settings::themes.block_text_options'))))
                    <!-- <th>{!! trans('admin::themes.fields.brand') !!}</th>
                    <th>{!! trans('admin::themes.fields.country') !!}</th> -->
                    @endif
                    <th>{!! trans('admin::themes.labels.remove') !!}</th>
                </tr>
                </thead>
                <tbody>
                @if (in_array($block->id, explode(",", config('settings::themes.block_text_options'))))
                    @foreach ($options as $option)
                        <tr id="selectOption_{!! $option['data']->id !!}">
                            <td>
                                <p class="text-danger" style="font-style: italic;">{!! trans('admin::themes.labels.lang_disclaimer') !!}</p>
                                @foreach ($languages as $i=> $lan)
                                    <div role="panel-group" id="accordion-{{$lan['id'] }}-option-{{$option['data']->id}}">
                                        <div class="panel panel-default">
                                            <div role="tab" class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion-{{$lan['id'] }}-option-{{$option['data']->id}}" href="#SelOption-{{$option['data']->id}}-language-{{$lan['id'] }}">{{trans('admin::themes.labels.country-language-title') . $lan['language'] }}</a>
                                                </h4>
                                            </div>
                                            <div role="tabpanel" data-parent="#accordion-{{$lan['id'] }}-option-{{$option['data']->id}}" id="SelOption-{{$option['data']->id}}-language-{{$lan['id'] }}"
                                                 class="panel-collapse {{($lan['id'] == Session::get('language') || $errors->has('selectOption['.$option['data']->id.'][lang]['.$lan->id.'][option]')) ? 'in' : 'collapse'}}" >
                                                <div class="panel-body">
                                                    <h3>{!! $lan->language!!}</h3>
                                                    <div class="form-group">
                                                        <div class="form-group row {!! FormMessage::getErrorClass('selectOption['.$option['data']->id.'][lang]['.$lan->id.'][option]') !!}">
                                                            <div class="col-sm-3">
                                                                {!! Form::label('selectOption['.$option['data']->id.'][lang]['.$lan->id.'][option]', trans('admin::themes.fields.option_text'), ['class' => 'control-label text-left', 'required']) !!}
                                                            </div>
                                                            <div class="col-sm-9">
                                                                {!! Form::text('selectOption['.$option['data']->id.'][lang]['.$lan->id.'][option]', isset($option['lang'][$lan->locale_key]['locale']) ? $option['lang'][$lan->locale_key]['locale'] : '', ['class' => 'form-control']) !!}
                                                                <span class="help-block">{!! FormMessage::getErrorMessage('selectOption['.$option['data']->id.'][lang]['.$lan->id.'][option]') !!}</span>
                                                            </div>
                                                            <input type="hidden" name="selectOption[{{ $option['data']->id}}][lang][{{$lan->id}}][locale_key]" value="{!! $lan->locale_key !!}">
                                                            <input type="hidden" name="selectOption[{{ $option['data']->id}}][lang][{{$lan->id}}][id_option]" value="{!! isset($option['lang'][$lan->locale_key]['id']) ? $option['lang'][$lan->locale_key]['id'] : 0 !!}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </td>
                            <td>
                                {!! Form::text('selectOption['.$option['data']->id.'][value]', $option['data']->value, ['class' => 'form-control']) !!}
                            </td>
                            <td>
                                <i class="glyphicon glyphicon-remove itemTooltip" title="{!! trans('admin::themes.buttons.remove_opt') !!}" data-toggle="modal" data-target="#removeRegister" data-id="{!! $option['data']->id !!}"></i>
                            </td>
                        </tr>
                    @endforeach

                    <div id="newRowTextOption">
                    <!--
                        <tr id="selectOption_{new_id_option}">
                            <td>
                                <p class="text-danger" style="font-style: italic;">{!! trans('admin::themes.msgs.lang_disclaimer') !!}</p>
                                @foreach ($languages as $i=> $lan)
                                    <div role="panel-group" id="accordion-{{$lan['id'] }}-option-{new_id_option}">
                                        <div class="panel panel-default">
                                            <div role="tab" class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion-{{$lan['id'] }}-option-{new_id_option}" href="#SelOption-{new_id_option}-language-{{$lan['id'] }}">{{trans('admin::roles.modal_add.country-language-title') . $lan['language'] }}</a>
                                                </h4>
                                            </div>
                                            <div role="tabpanel" data-parent="#accordion-{{$lan['id'] }}-option-{new_id_option}" id="SelOption-{new_id_option}-language-{{$lan['id'] }}"
                                                 class="panel-collapse {{($lan['id'] == Session::get('language') || $errors->has('selectOption[{new_id_option}][lang]['.$lan->id.'][option]')) ? 'in' : 'collapse'}}" >
                                                <div class="panel-body">
                                                    <h3>{!! $lan->language!!}</h3>
                                                    <div class="form-group">
                                                        <div class="form-group row {!! FormMessage::getErrorClass('selectOption[{new_id_option}][lang]['.$lan->id.'][option]') !!}">
                                                            <div class="col-sm-3">
                                                                {!! Form::label('selectOption[{new_id_option}][lang]['.$lan->id.'][option]', trans('admin::themes.fields.option_text'), ['class' => 'control-label text-left', 'required']) !!}
                                                            </div>
                                                            <div class="col-sm-9">
                                                                {!! Form::text('selectOption[{new_id_option}][lang]['.$lan->id.'][option]', null, ['class' => 'form-control']) !!}
                                                                <span class="help-block">{!! FormMessage::getErrorMessage('selectOption[{new_id_option}][lang]['.$lan->id.'][option]') !!}</span>
                                                            </div>
                                                            <input type="hidden" name="selectOption[{new_id_option}][lang][{{$lan->id}}][locale_key]" value="{!! $lan->locale_key !!}">
                                                            <input type="hidden" name="selectOption[{new_id_option}][lang][{{$lan->id}}][id_option]" value="0">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                @endforeach
                            </td>
                            <td>
                                {!! Form::text('selectOption[{new_id_option}][value]', null, ['class' => 'form-control']) !!}
                            </td>
                            <td>
                                <i class="glyphicon glyphicon-remove itemTooltip" title="{!! trans('admin::themes.buttons.remove_opt') !!}" data-toggle="modal" data-target="#removeRegister" data-id="{new_id_option}"></i>
                            </td>
                        </tr> -->
                    </div>
                @else
                    @foreach ($options as $option)
                        <tr id="selectOption_{!! $option->id !!}">
                            <td>
                                {!! Form::text('selectOption['.$option->id.'][option]', $option->option, ['class' => 'form-control']) !!}
                            </td>
                            <td>
                                {!! Form::text('selectOption['.$option->id.'][value]', $option->value, ['class' => 'form-control']) !!}
                            </td>
                            <td>
                                <i class="glyphicon glyphicon-remove itemTooltip" title="{!! trans('admin::themes.buttons.remove_opt') !!}" data-toggle="modal" data-target="#removeRegister" data-id="{!! $option->id !!}"></i>
                            </td>
                        </tr>
                    @endforeach
                @endif

                </tbody>
            </table>
        </div>

        <div class="row textbox">
            <div class="col-sm-12">
                <button type="button" class="btn" onclick="add_option()"><i class="fa fa-plus"></i>
                    &nbsp; {!! trans('admin::themes.buttons.add_another') !!}
                </button>
                <button class="btn btn-primary" type="submit"><i class="fa fa-floppy-o"></i> &nbsp; {!! trans('admin::themes.buttons.save_opt') !!}</button>
            </div>
        </div>

        <div aria-labelledby="myModalLabel" class="modal fade" id="removeRegister" role="dialog" tabindex="-1">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">{!! trans('admin::themes.modal_confirm_remove.title_remove') !!}</h4>
                    </div>
                    <div class="modal-body">
                        <p>{!! trans('admin::themes.modal_confirm_remove.msg_remove_option') !!}</p>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-default" data-dismiss="modal" type="button">{!! trans('admin::themes.buttons.cancel') !!}</button>
                        <button class="btn btn-danger" id="remove-button" type="button">{!! trans('admin::themes.buttons.remove_opt') !!}</button>
                    </div>
                </div>
                <!-- end modal-content -->
            </div>
            <!-- end modal-dialog -->
        </div>
        <!-- end modal -->
@section('scripts')
    <script type='text/javascript'>

        var new_selectOption = 1;

        function delete_option(id) {
            $("#selectOption_" + id).remove();
        }

        var delId = '';
        $('#removeRegister').on('show.bs.modal', function(e) {
            delId = $(e.relatedTarget).data('id');
        });

        $('#remove-button').click(function() {
            $("#selectOption_" + delId).remove();
            $('#removeRegister').modal('hide');
        });

        @if (in_array($block->id, explode(",", config('settings::themes.block_text_options'))))

            function add_option() {

            var id = $.now();
            var newRow = $('#newRowTextOption').html();

            var re = /{new_id_option}/g;
            newRow = newRow.replace(re, id);
            newRow = newRow.replace('<!--', '');
            newRow = newRow.replace('-->', '');

            $('#selectOptions tbody').append(newRow);

            $('.itemTooltip').tooltip({placement: 'bottom', container: 'body'});
            }

        @else
            function add_option() {
                var id = 'new' + new_selectOption;

                new_selectOption++;
                $("#selectOptions tbody").append('<tr id="selectOption_' + id + '">' +
                        '<td><input class="form-control" name="selectOption[' + id + '][option]" type="text"></td>' +
                        '<td><input class="form-control" name="selectOption[' + id + '][value]" type="text"></td>' +
                        '<td><i class="glyphicon glyphicon-remove itemTooltip" title="Remove Option" onclick="delete_option(\'' + id + '\')"></i></td>' +
                        '</tr>'
                );
                $('.itemTooltip').tooltip({placement: 'bottom', container: 'body'});
            }
        @endif

    </script>
@stop

@endif

{!! Form::close() !!}

@else

    <p>{!! trans('admin::themes.labels.select_options_are_attached') !!}</p>

    @if (!empty($blocks))

        <h2>{!! trans('admin::themes.labels.block_select_found') !!}</h2>

        <ul>

            @foreach($blocks as $id => $name)

                <li><a href="{{ route('admin.themes.selects', ['blockId' => $id]) }}">{!! trans('admin::themes.labels.'.$name) !!}</a></li>

            @endforeach

        </ul>

    @else

        <h2>{!! trans('admin::themes.labels.no_select_blocks_found') !!}</h2>

    @endif

@endif