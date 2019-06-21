@if(session('msg'))
    <div class="alert alert-success" role="alert">{{ session('msg') }}</div>
@elseif(session('errors') != null)
    <div class="alert alert-danger" role="alert">{{ session('errors')->first('msg') }}</div>
@endif
<div class="row textbox">
    <div class="col-sm-6">
        <h1> {{trans('admin::shopping.legals.index.title')}} </h1>
    </div>
    <div class="col-sm-6 text-right">
        @if (Auth::action('legals.create'))
            <a href="{{ route('admin.legals.create') }}" class="btn btn-warning addButton"><i class="fa fa-plus"></i> &nbsp;
                 {{trans('admin::shopping.legals.index.form-add-button')}} 
            </a>
        @endif
    </div>
</div>
<div class="table">
    <table class="table table-striped" id="tb_products">
        <thead>
            <tr>
                <th>{{ trans('admin::shopping.legals.index.thead-legals-countries') }}</th>
                <th>{{ trans('admin::shopping.legals.index.thead-legals-activecontract') }}</th>
                <th>{{ trans('admin::shopping.legals.index.thead-legals-activedisclaimer') }}</th>
                <th>{{ trans('admin::shopping.legals.index.thead-legals-activepolicies') }}</th>
                <th>{{ trans('admin::shopping.legals.index.thead-legals-active') }}</th>
                @if (Auth::action('legals.edit') || Auth::action('legals.delete'))
                    <th class="text-center">{{ trans('admin::shopping.legals.index.thead-legals-actions') }}</th>
                @endif
            </tr>
        </thead>
        <tbody>
        @foreach ($legals as $leg)
            <tr id="cat_{!! $leg->id !!}">
                <td>{{ $leg->country->name }}</td>


                <td>
                    @if($leg->active_contract == 1)
                        <span class="fa fa-check fa-2x text-success"></span>
                    @else
                        <span class="fa fa-ban fa-2x text-danger"></span>
                    @endif
                </td>
                <td>
                    @if($leg->active_disclaimer == 1)
                        <span class="fa fa-check fa-2x text-success"></span>
                    @else
                        <span class="fa fa-ban fa-2x text-danger"></span>
                    @endif
                </td>
                <td>
                    @if($leg->active_policies == 1)
                        <span class="fa fa-check fa-2x text-success"></span>
                    @else
                        <span class="fa fa-ban fa-2x text-danger"></span>
                    @endif
                </td>
                <td>
                    @if($leg->active == 1)
                        <span class="label label-success">@lang('admin::shopping.legals.index.legal_active')</span>
                    @else
                        <span class="label label-warning">@lang('admin::shopping.legals.index.legal_inactive')</span>
                    @endif
                </td>
                <td>
                    <div class="row">
                        <div class="col-xs-4 text-center">
                            @if($leg->active == 1)
                                @if (Auth::action('legals.changeStatus'))
                                    <form name="formOff_{{ $leg->id }}" method="POST" action="{{ route('admin.legals.changeStatus') }}">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="new-status" value="deactivate"/>
                                        <input type="hidden" name="id" value="{{ $leg->id }}"/>
                                        <i class="fa fa-pause itemTooltip" aria-hidden="true" style="color: red"
                                           onclick="document.forms['formOff_{{ $leg->id }}'].submit();"
                                           title="{{ trans('admin::shopping.legals.index.disable') }}"></i>
                                    </form>
                                @endif
                            @else
                                @if (Auth::action('legals.changeStatus'))
                                    <form name="formOn_{{ $leg->id }}" method="POST" action="{{ route('admin.legals.changeStatus') }}">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="new-status" value="activate"/>
                                        <input type="hidden" name="id" value="{{ $leg->id }}"/>
                                        <i class="fa fa-play itemTooltip" aria-hidden="true" style="color: green"
                                           onclick="document.forms['formOn_{{ $leg->id }}'].submit();"
                                           title="{{ trans('admin::shopping.legals.index.enable') }}"></i>
                                    </form>
                                @endif
                            @endif
                        </div>
                        <div class="col-xs-4 text-center">
                            @if (Auth::action('legals.edit'))
                                <a class="fa fa-pencil itemTooltip" href="{{ route('admin.legals.edit', ['id' => $leg->id]) }}"
                               title="{{ trans('admin::shopping.legals.index.edit') }}" style="color: black"></a>
                            @endif
                        </div>
                        <div class="col-xs-4 text-center">
                            @if (Auth::action('legals.delete'))
                                <form name="formDel_{{ $leg->id }}" method="POST" action="{{ route('admin.legals.destroy', ['id' => $leg->id]) }}">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}
                                    <input type="hidden" name="id" value="{{ $leg->id }}"/>
                                    <i class="fa fa-trash itemTooltip" aria-hidden="true" onclick="document.forms['formDel_{{ $leg->id }}'].submit();"
                                       title="{{ trans('admin::shopping.legals.index.delete') }}"></i>
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

        $(document).ready(function () {

        });

    </script>
@stop