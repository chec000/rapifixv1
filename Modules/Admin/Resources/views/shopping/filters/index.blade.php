@if(session('msg'))
    <div class="alert alert-success" role="alert">{{ session('msg') }}</div>
@elseif(session('errors') != null)
    <div class="alert alert-danger" role="alert">{{ session('errors')->first('msg') }}</div>
@endif
<div class="row textbox">
    <div class="col-sm-6">
        <h1> {{trans('admin::shopping.filters.index.title')}} </h1>
    </div>
    <div class="col-sm-6 text-right">
        @if (Auth::action('filters.create'))
            <a href="{{ route('admin.filters.create') }}" class="btn btn-warning addButton"><i class="fa fa-plus"></i> &nbsp;
                 {{trans('admin::shopping.filters.index.form-add-button')}}
            </a>
        @endif
    </div>
</div>
<div class="table">
    <table class="table table-striped" id="tb_products">
        <thead>
            <tr>
                <th>{{ trans('admin::shopping.filters.index.thead-name-global') }}</th>
                <th>{{ trans('admin::shopping.filters.index.thead-brand') }}</th>
                <th>{{ trans('admin::shopping.filters.index.thead-country') }}</th>
                <th class="text-center">{{ trans('admin::shopping.filters.index.thead-active') }}</th>
                @if (Auth::action('filters.edit') || Auth::action('filters.delete'))
                    <th class="text-center">{{ trans('admin::shopping.filters.index.thead-actions') }}</th>
                @endif
            </tr>
        </thead>
        <tbody>
        @foreach ($filters as $fil)
            <tr id="cat_{!! $fil->id !!}">
                <td>{{ $fil->code }} - {{ $fil->global_name }}</td>
                <td>{{ $fil->brandGroup->brand->name }}</td>
                <td>
                    @foreach($fil->countries as $filCountry)
                        <span class="label label-default">{{ $filCountry->name }}</span>
                    @endforeach
                </td>
                <td class="text-center">
                    @if($fil->actives == 1)
                        <span class="label label-success">@lang('admin::shopping.filters.index.category_active')</span>
                    @else
                        <span class="label label-warning">@lang('admin::shopping.filters.index.category_inactive')</span>
                    @endif
                </td>
                <td>
                    <div class="row">
                        <div class="col-xs-3 text-center">
                            <a href="{{ route('admin.filters.categoriesshow', ['code' => $fil->code, 'idCountry' => 0, 'idCategory' => 0]) }}"
                               title="{{ trans('admin::shopping.products.index.edit_product') }}" style="text-decoration: none;color: #000;">
                                <i class="fa fa-random" aria-hidden="true"></i>
                            </a>
                        </div>
                        <div class="col-xs-3 text-center">
                            @if($fil->actives == 1)
                                @if (Auth::action('filters.changeStatus'))
                                    <form name="formOff_{{ $fil->code }}" method="POST" action="{{ route('admin.filters.changeStatus') }}">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="code" value="{{ $fil->code }}"/>
                                        <input type="hidden" name="type" value="deactivate"/>
                                        <i class="fa fa-pause itemTooltip" aria-hidden="true" style="color: red"
                                           onclick="document.forms['formOff_{{ $fil["code"] }}'].submit();"
                                           title="{{ trans('admin::shopping.filters.index.disable_category') }}"></i>
                                    </form>
                                @endif
                            @else
                                @if (Auth::action('filters.changeStatus'))
                                    <form name="formOn_{{ $fil->code }}" method="POST" action="{{ route('admin.filters.changeStatus') }}">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="code" value="{{ $fil->code }}"/>
                                        <input type="hidden" name="type" value="activate"/>
                                        <i class="fa fa-play itemTooltip" aria-hidden="true" style="color: green"
                                           onclick="document.forms['formOn_{{ $fil->code }}'].submit();"
                                           title="{{ trans('admin::shopping.filters.index.enable_category') }}"></i>
                                    </form>
                                @endif
                            @endif
                        </div>
                        <div class="col-xs-3 text-center">
                            @if (Auth::action('filters.edit'))
                                <a class="fa fa-pencil itemTooltip" href="{{ route('admin.filters.edit', ['id' => $fil->code]) }}"
                               title="{{ trans('admin::shopping.filters.index.edit_category') }}" style="color: black"></a>
                            @endif
                        </div>
                        <div class="col-xs-3 text-center">
                            @if (Auth::action('filters.delete'))
                                <form name="formDel_{{ $fil->code }}" method="POST" action="{{ route('admin.filters.destroy', ['code' => $fil->code]) }}">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}
                                    <input type="hidden" name="code" value="{{ $fil->code }}"/>
                                    <i class="fa fa-trash itemTooltip" aria-hidden="true" onclick="deleteElement(this)" data-id="{{ $fil->code }}" data-element="{{ $fil->global_name }}" title="{{ trans('admin::shopping.filters.index.delete_category') }}"></i>
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
               }, 
        });
        function deleteElement(element) {
            var id = $(element).data('id');
            var name = $(element).data('element');

            $('#confirm-modal .modal-body').text('{{trans('admin::shopping.products.index.confirm')}} ' + name + '?');

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