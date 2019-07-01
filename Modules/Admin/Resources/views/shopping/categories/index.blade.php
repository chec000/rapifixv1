@if(session('msg'))
    <div class="alert alert-success" role="alert">{{ session('msg') }}</div>
@elseif(session('errors') != null)
    <div class="alert alert-danger" role="alert">{{ session('errors')->first('msg') }}</div>
@endif
<div class="row textbox">
    <div class="col-sm-6">
        <h1> {{trans('admin::shopping.categories.index.title')}} </h1>
    </div>
    <div class="col-sm-6 text-right">
        @if (Auth::action('categories.create'))
            <a href="{{ route('admin.categories.create') }}" class="btn btn-warning addButton"><i class="fa fa-plus"></i> &nbsp;
                 {{trans('admin::shopping.categories.index.form-add-button')}} 
            </a>
        @endif
    </div>
</div>
<div class="table">
    <table class="table table-striped" id="tb_products">
        <thead>
            <tr>
                <th>{{ trans('admin::shopping.categories.index.thead-category-name-global') }}</th>
                <th>{{ trans('admin::shopping.categories.index.thead-category-countries') }}</th>
                <th>{{ trans('admin::shopping.categories.index.thead-category-brand') }}</th>
                <th>{{ trans('admin::shopping.categories.index.thead-category-active') }}</th>
                @if (Auth::action('categories.edit') || Auth::action('categories.delete'))
                    <th class="text-center">{{ trans('admin::shopping.categories.index.thead-category-actions') }}</th>
                @endif
            </tr>
        </thead>
        <tbody>
        @foreach ($categories as $cat)
            <tr id="cat_{!! $cat->id !!}">
                <td>{{ $cat->code }} - {{ $cat->global_name }}</td>
                <td>
                    @foreach ($cat->countries as $country)
                        <span class="label label-default">{{  $country->name }}</span>
                    @endforeach
                </td>
                <td>{{ $cat->brandGroup->brand->name }}</td>
                <td>
                    @if($cat->actives == 1)
                        <span class="label label-success">@lang('admin::shopping.categories.index.category_active')</span>
                    @else
                        <span class="label label-warning">@lang('admin::shopping.categories.index.category_inactive')</span>
                    @endif
                </td>
                <td>
                    <div class="row">
                        <div class="col-xs-4 text-center">
                            @if($cat->actives == 1)
                                @if (Auth::action('categories.changeStatus'))
                                    <form name="formOff_{{ $cat->code }}" method="POST" action="{{ route('admin.categories.changeStatus') }}">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="code" value="{{ $cat->code }}"/>
                                        <input type="hidden" name="type" value="deactivate"/>
                                        <i class="fa fa-pause itemTooltip" aria-hidden="true" style="color: red"
                                           onclick="document.forms['formOff_{{ $cat->code }}'].submit();"
                                           title="{{ trans('admin::shopping.categories.index.disable_category') }}"></i>
                                    </form>
                                @endif
                            @else
                                @if (Auth::action('categories.changeStatus'))
                                    <form name="formOn_{{ $cat->code }}" method="POST" action="{{ route('admin.categories.changeStatus') }}">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="code" value="{{ $cat->code }}"/>
                                        <input type="hidden" name="type" value="activate"/>
                                        <i class="fa fa-play itemTooltip" aria-hidden="true" style="color: green"
                                           onclick="document.forms['formOn_{{ $cat->code }}'].submit();"
                                           title="{{ trans('admin::shopping.categories.index.enable_category') }}"></i>
                                    </form>
                                @endif
                            @endif
                        </div>
                        <div class="col-xs-4 text-center">
                            <a class="fa fa-pencil itemTooltip" href="{{ route('admin.categories.edit', ['id' => $cat->code]) }}"
                               title="{{ trans('admin::shopping.categories.index.edit_category') }}" style="color: black"></a>

                        @if (Auth::action('categories.edit'))

                            @endif
                        </div>
                        <div class="col-xs-4 text-center">
                            @if (Auth::action('categories.delete'))
                                <form name="formDel_{{ $cat->code }}" method="POST" action="{{ route('admin.categories.destroy', ['code' => $cat->code]) }}">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}
                                    <input type="hidden" name="code" value="{{ $cat->code }}"/>
                                    <i class="fa fa-trash itemTooltip" aria-hidden="true" onclick="deleteElement(this)" data-id="{{ $cat->code }}" data-element="{{ $cat->global_name }}" title="{{ trans('admin::shopping.categories.index.delete_category') }}"></i>
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

            $('#confirm-modal .modal-body').text('{{trans('admin::shopping.categories.index.confirm')}}');
            $('#accept-confirm').text('{{trans('admin::shopping.categories.index.confirm_yes')}}');
            $('#cancel-confirm').text('{{trans('admin::shopping.categories.index.confirm_no')}}');

            $('#confirm-modal').modal({
                backdrop: 'static',
                keyboard: false
            }).one('click', '#delete', function(e) {
                document.forms['formDel_'+id].submit();
            });
        }
        function disable_product(active,productId) {
            var url  = '{{ route('admin.categories.changeStatus') }}';
            var type = 'activate';
            if (active==='0'){
                type = 'deactivate';
            }

            $.ajax({
                url: url,
                type: 'POST',
                data: {id: productId, type: type},
                success: function (r) {
                    if (r.status === 0) {
                        $("#product_" + productId + " .glyphicon-play").addClass('hide');
                        $("#product_" + productId + " .glyphicon-stop").removeClass('hide');
                        $("#product_" + productId + " .cActive").hide();
                        $("#product_" + productId + " .cInactive").show();
                    }
                    else {
                        $("#product_" + productId + " .glyphicon-stop").addClass('hide');
                        $("#product_" + productId + " .glyphicon-play").removeClass('hide');
                        $("#product_" + productId + " .cActive").show();
                        $("#product_" + productId + " .cInactive").hide();
                    }
                }
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