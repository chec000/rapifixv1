
<div id="brand-modal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">@lang('admin::shopping.reports.modals.title')</h4>
            </div>
            <div class="modal-body">
                <form id="categories" method="POST" action="{{ route('admin.categories.store') }}">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <div id="products-check-countries">
                            <label>@lang('admin::shopping.reports.modals.select') </label>
                            <select name="select-report" id="select-report" class="form-control">
                                <option value=""> @lang('admin::shopping.reports.modals.select_report') </option>
                                @foreach(config('admin.reports') as $r)
                                    <option value="{{ $r['action'] }}"> @lang('admin::shopping.reports.views.'.$r['name']) </option>
                                @endforeach

                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button id="close-modal" type="button" class="btn btn-default" data-dismiss="modal">@lang('admin::shopping.categories.add.view.form-cancell-button')</button>
                {{-- <button id="accept-modal" type="button" class="btn btn-primary">@lang('admin::shopping.categories.add.view.form-next-button')</button>--}}
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->