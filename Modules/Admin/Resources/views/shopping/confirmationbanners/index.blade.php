@if(session('msg'))
    <div class="alert alert-success" role="alert">{{ session('msg') }}</div>
@elseif(session('errors') != null)
    <div class="alert alert-danger" role="alert">{{ session('errors')->first('msg') }}</div>
@endif
<div class="row textbox">
    <div class="col-sm-6">
        <h1> {{trans('admin::shopping.confirmationbanners.index.title')}} </h1>
    </div>
    <div class="col-sm-6 text-right">
        @if (Auth::action('confirmationbanners.create'))
            <a href="{{ route('admin.confirmationbanners.create') }}" class="btn btn-warning addButton"><i class="fa fa-plus"></i> &nbsp;
                 {{trans('admin::shopping.confirmationbanners.index.form-add-button')}} 
            </a>
        @endif
    </div>
</div>
<div class="table">
    <table class="table table-striped" id="tb_confirmations">
        <thead>
            <tr>
                <th>{{ trans('admin::shopping.products.index.thead-product-global_name') }}</th>
                <th>{{ trans('admin::shopping.confirmationbanners.index.thead-confirmation-type') }}</th>
                <th>{{ trans('admin::shopping.confirmationbanners.index.thead-confirmation-countries') }}</th>
                <th>{{ trans('admin::shopping.confirmationbanners.index.thead-confirmation-purpose') }}</th>
                <th>{{ trans('admin::shopping.confirmationbanners.index.thead-confirmation-active') }}</th>
                @if (Auth::action('confirmationbanners.edit') || Auth::action('confirmationbanners.delete'))
                    <th class="text-center">{{ trans('admin::shopping.confirmationbanners.index.thead-confirmation-actions') }}</th>
                @endif
            </tr>
        </thead>
        <tbody>

        @foreach ($confirmationbanners as $cat)
            <tr id="cat_{!! $cat->id !!}">
                <td>{{ $cat->global_name }}</td>
                <td>
                @foreach ($cat->types as $t)
                    {{  $t->type }}
                @endforeach
                </td>
                <td>
                    @foreach ($cat->countries as $country)
                        <span class="label label-default">{{  $country->name }}</span>
                    @endforeach
                </td>
                <td>
                    @foreach ($cat->purposes as $p)
                        {{  $p->purpose }}
                    @endforeach
                </td>
                <td>
                    @if($cat->active == 1)
                        <span class="label label-success">@lang('admin::shopping.categories.index.category_active')</span>
                    @else
                        <span class="label label-warning">@lang('admin::shopping.categories.index.category_inactive')</span>
                    @endif
                </td>
                <td>
                    <div class="row">
                        <div class="col-xs-4 text-center">
                            @if($cat->active == 1)
                                @if (Auth::action('confirmationbanners.changeStatus'))
                                    <form name="formOff_{{ $cat->type_id }}_{{ $cat->purpose_id }}" method="POST" action="{{ route('admin.confirmationbanners.changeStatus') }}">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="new-status" value="deactivate"/>
                                        <input type="hidden" name="type" value="{{ $cat->type_id }}"/>
                                        <input type="hidden" name="purpose" value="{{ $cat->purpose_id }}"/>
                                        <i class="fa fa-pause itemTooltip" aria-hidden="true" style="color: red"
                                           onclick="document.forms['formOff_{{ $cat->type_id }}_{{ $cat->purpose_id }}'].submit();"
                                           title="{{ trans('admin::shopping.confirmationbanners.index.disable') }}"></i>
                                    </form>
                                @endif
                            @else
                                @if (Auth::action('confirmationbanners.changeStatus'))
                                    <form name="formOn_{{ $cat->type_id }}_{{ $cat->purpose_id }}" method="POST" action="{{ route('admin.confirmationbanners.changeStatus') }}">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="new-status" value="activate"/>
                                        <input type="hidden" name="type" value="{{ $cat->type_id }}"/>
                                        <input type="hidden" name="purpose" value="{{ $cat->purpose_id }}"/>
                                        <i class="fa fa-play itemTooltip" aria-hidden="true" style="color: green"
                                           onclick="document.forms['formOn_{{ $cat->type_id }}_{{ $cat->purpose_id }}'].submit();"
                                           title="{{ trans('admin::shopping.confirmationbanners.index.enable') }}"></i>
                                    </form>
                                @endif
                            @endif
                        </div>
                        <div class="col-xs-4 text-center">
                            @if (Auth::action('confirmationbanners.edit'))
                                <a class="fa fa-pencil itemTooltip" href="{{ route('admin.confirmationbanners.edit',['global_name'=>urlencode($cat->global_name)]) }}"
                               title="{{ trans('admin::shopping.confirmationbanners.index.edit') }}" style="color: black"></a>
                            @endif
                        </div>
                        <div class="col-xs-4 text-center">
                            @if (Auth::action('confirmationbanners.delete'))
                                <form name="formDel_{{ $cat->type_id }}_{{ $cat->purpose_id }}" method="POST" action="{{ route('admin.confirmationbanners.destroy', ['code' => $cat->id]) }}">
                                    <input type="hidden" name="type" value="deactivate"/>
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}
                                    <input type="hidden" name="type" value="{{ $cat->type_id }}"/>
                                    <input type="hidden" name="purpose" value="{{ $cat->purpose_id }}"/>
                                    <i class="fa fa-trash itemTooltip" aria-hidden="true" onclick="document.forms['formDel_{{ $cat->type_id }}_{{ $cat->purpose_id }}'].submit();"
                                       title="{{ trans('admin::shopping.confirmationbanners.index.delete') }}"></i>
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
        $('#tb_confirmations').DataTable({
            "responsive": true,
            "ordering": false,
             "language": { 
                    "url": "{{ trans('admin::datatables.lang') }}"
               }  
        });
    </script>
@stop