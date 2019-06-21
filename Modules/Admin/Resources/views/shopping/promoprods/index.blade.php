@if(session('msg'))
    <div class="alert alert-success" role="alert">{{ session('msg') }}</div>
@elseif(session('errors') != null)
    <div class="alert alert-danger" role="alert">{{ session('errors')->first('msg') }}</div>
@endif
<div class="row textbox">
    <div class="col-sm-6">
        <h1> {{trans('admin::shopping.promoprods.index.title')}} </h1>
    </div>
    <div class="col-sm-6 text-right">
        @if (Auth::action('confirmationbanners.create'))
            <a href="{{ route('admin.promoprods.create') }}" class="btn btn-warning addButton"><i class="fa fa-plus"></i> &nbsp;
                 {{trans('admin::shopping.promoprods.index.form-add-button')}} 
            </a>
        @endif
    </div>
</div>
<div class="table">
    <table class="table table-striped" id="tb_confirmations">
        <thead>
            <tr>
                <th>{{ trans('admin::shopping.promoprods.index.thead-promoname') }}</th>
                <th>{{ trans('admin::shopping.promoprods.index.thead-productsrelated') }}</th>
                <th>{{ trans('admin::shopping.promoprods.index.thead-promoprods-active') }}</th>
                @if (Auth::action('confirmationbanners.edit') || Auth::action('confirmationbanners.delete'))
                    <th class="text-center">{{ trans('admin::shopping.promoprods.index.thead-promoprods-actions') }}</th>
                @endif
            </tr>
        </thead>
        <tbody>

        @foreach ($promos as $pro)
            <tr id="prom_{!! $pro->id !!}">
                <td>
                    {{$pro->clv_promo}}
                </td>
                <td>
                    <ul>
                        @foreach($pro->promoprods as $pp)

                                <li>
                                 {{$pp->clv_producto}}
                                </li>

                        @endforeach
                    </ul>


                   
                </td>
                <td>
                    @if($pro->active == 1)
                        <span class="label label-success">@lang('admin::shopping.promoprods.index.promoprodactive')</span>
                    @else
                        <span class="label label-warning">@lang('admin::shopping.promoprods.index.promoprodinactive')</span>
                    @endif
                </td>
                <td>
                    <div class="row">
                        <div class="col-xs-4 text-center">
                            @if($pro->active == 1)
                                @if (Auth::action('confirmationbanners.changeStatus'))
                                    <form name="formOff_{{ $pro->id }}" method="POST" action="{{ route('admin.promoprods.changeStatus') }}">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="new-status" value="deactivate"/>
                                        <input type="hidden" name="id" value="{{ $pro->id }}"/>
                                        <i class="fa fa-pause itemTooltip" aria-hidden="true" style="color: red"
                                           onclick="document.forms['formOff_{{ $pro->id }}'].submit();"
                                           title="{{ trans('admin::shopping.promoprods.index.disable') }}"></i>
                                    </form>
                                @endif
                            @else
                                @if (Auth::action('confirmationbanners.changeStatus'))
                                    <form name="formOn_{{ $pro->id }}" method="POST" action="{{ route('admin.promoprods.changeStatus') }}">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="new-status" value="activate"/>
                                        <input type="hidden" name="id" value="{{ $pro->id }}"/>

                                        <i class="fa fa-play itemTooltip" aria-hidden="true" style="color: green"
                                           onclick="document.forms['formOn_{{ $pro->id }}'].submit();"
                                           title="{{ trans('admin::shopping.promoprods.index.enable') }}"></i>
                                    </form>
                                @endif
                            @endif
                        </div>
                        <div class="col-xs-4 text-center">
                            @if (Auth::action('confirmationbanners.edit'))
                                <a class="fa fa-pencil itemTooltip" href="{{ route('admin.promoprods.edit',['id' => $pro->id]
) }}"
                               title="{{ trans('admin::shopping.promoprods.index.edit') }}" style="color: black"></a>
                            @endif
                        </div>
                        <div class="col-xs-4 text-center">
                            @if (Auth::action('confirmationbanners.delete'))
                                <form name="formDel_{{ $pro->id }}" method="POST" action="{{ route('admin.promoprods.destroy', ['id' => $pro->id]) }}">
                                    <input type="hidden" name="type" value="deactivate"/>
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}
                                    <input type="hidden" name="id" value="{{ $pro->id }}"/>
                                    <i class="fa fa-trash itemTooltip" aria-hidden="true" onclick="document.forms['formDel_{{ $pro->id }}'].submit();"
                                       title="{{ trans('admin::shopping.promoprods.index.delete') }}"></i>
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
            "ordering": false
        });


    </script>
@stop