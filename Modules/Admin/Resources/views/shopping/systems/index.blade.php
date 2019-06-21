@if(session('msg'))
    <div class="alert alert-success" role="alert">{{ session('msg') }}</div>
@elseif(session('errors') != null)
    <div class="alert alert-danger" role="alert">{{ session('errors')->first('msg') }}</div>
@endif
<div class="row textbox">
    <div class="col-sm-6">
        <h1> {{trans('admin::shopping.systems.index.title')}} </h1>
    </div>
    <div class="col-sm-6 text-right">
        @if (Auth::action('systems.create'))
            <a href="{{ route('admin.systems.create') }}" class="btn btn-warning addButton"><i class="fa fa-plus"></i> &nbsp;
                 {{trans('admin::shopping.systems.index.form-add-button')}}
            </a>
        @endif
    </div>
</div>
<div class="table">
    <table class="table table-striped" id="tb_products">
        <thead>
            <tr>
                <th>{{ trans('admin::shopping.systems.index.thead-category-name-global') }}</th>
                <th>{{ trans('admin::shopping.categories.index.thead-category-countries') }}</th>
                <th>{{ trans('admin::shopping.systems.index.thead-category-brand') }}</th>
                <th class="text-center">{{ trans('admin::shopping.systems.index.thead-category-active') }}</th>
                @if (Auth::action('systems.edit') || Auth::action('systems.delete'))
                    <th class="text-center">{{ trans('admin::shopping.systems.index.thead-category-actions') }}</th>
                @endif
            </tr>
        </thead>
        <tbody>
        @foreach ($systems as $sys)
            <tr id="cat_{!! $sys->id !!}">
                <td>{{ $sys->code }} - {{ $sys->global_name }}</td>
                <td>
                    @foreach ($sys->countries as $country)
                        <span class="label label-default">{{  $country->name }}</span>
                    @endforeach
                </td>
                <td>{{ $sys->brandGroup->brand->name }}</td>
                <td class="text-center">
                    @if($sys->actives == 1)
                        <span class="label label-success">@lang('admin::shopping.systems.index.category_active')</span>
                    @else
                        <span class="label label-warning">@lang('admin::shopping.systems.index.category_inactive')</span>
                    @endif
                </td>
                <td>
                    <div class="row">
                        <div class="col-xs-4 text-center">
                            @if($sys->actives == 1)
                                @if (Auth::action('systems.changeStatus'))
                                    <form name="formOff_{{ $sys->code }}" method="POST" action="{{ route('admin.systems.changeStatus') }}">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="code" value="{{ $sys->code }}"/>
                                        <input type="hidden" name="type" value="deactivate"/>
                                        <i class="fa fa-pause itemTooltip" aria-hidden="true" style="color: red"
                                           onclick="document.forms['formOff_{{ $sys->code }}'].submit();"
                                           title="{{ trans('admin::shopping.systems.index.disable_category') }}"></i>
                                    </form>
                                @endif
                            @else
                                @if (Auth::action('systems.changeStatus'))
                                    <form name="formOn_{{ $sys->code }}" method="POST" action="{{ route('admin.systems.changeStatus') }}">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="code" value="{{ $sys->code }}"/>
                                        <input type="hidden" name="type" value="activate"/>
                                        <i class="fa fa-play itemTooltip" aria-hidden="true" style="color: green"
                                           onclick="document.forms['formOn_{{ $sys->code }}'].submit();"
                                           title="{{ trans('admin::shopping.systems.index.enable_category') }}"></i>
                                    </form>
                                @endif
                            @endif
                        </div>
                        <div class="col-xs-4 text-center">
                            @if (Auth::action('systems.edit'))
                                <a class="fa fa-pencil itemTooltip" href="{{ route('admin.systems.edit', ['id' => $sys->code]) }}"
                               title="{{ trans('admin::shopping.systems.index.edit_category') }}" style="color: black"></a>
                            @endif
                        </div>
                        <div class="col-xs-4 text-center">
                            @if (Auth::action('systems.delete'))
                                <form name="formDel_{{ $sys->code }}" method="POST" action="{{ route('admin.systems.destroy', ['code' => $sys->code]) }}">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}
                                    <input type="hidden" name="code" value="{{ $sys->code }}"/>
                                    <i class="fa fa-trash itemTooltip" aria-hidden="true" onclick="deleteElement(this)" data-id="{{ $sys->code }}" data-element="{{ $sys->global_name }}" title="{{ trans('admin::shopping.systems.index.delete_category') }}"></i>
                                </form>
                            @endif
                        </div>
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@section('scripts')
    <script type="text/javascript">
        $('#tb_products').DataTable({
            "responsive": true,
            "ordering": false,
             "language": { 
                    "url": "{{ trans('admin::datatables.lang') }}"
               }
        });

        function deleteElement(element) {
            var id = $(element).data('id');
            var name = $(element).data('element');

            $('#confirm-modal .modal-body').text('{{trans('admin::shopping.systems.index.confirm')}}');
            $('#accept-confirm').text('{{trans('admin::shopping.systems.index.confirm_yes')}}');
            $('#cancel-confirm').text('{{trans('admin::shopping.systems.index.confirm_no')}}');

            $('#confirm-modal').modal({
                backdrop: 'static',
                keyboard: false
            }).one('click', '#delete', function(e) {
                document.forms['formDel_'+id].submit();
            });
        }
        $(document).ready(function () {
            $('.glyphicon-play').click(function () {
                disable_product(0,$(this).parent().attr('data-cid'));
            });
            $('.glyphicon-stop').click(function () {
                disable_product(1,$(this).parent().attr('data-cid'));
            });
        });

    </script>
@stop