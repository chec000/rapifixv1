<style>
    .form-check-input { margin-left: 20px !important; }
</style>
<div id="brand-modal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ $title }}</h4>
            </div>

            <div class="modal-body">
                <form id="categories" method="POST" action="{{ route('admin.categories.store') }}">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-6">
                                <label>@lang('admin::shopping.categories.add.view.form-brands')</label>
                                @foreach ($userBrands as $brand)
                                    <div class="radio">
                                        <label>
                                            @if (old('brand-user') != null)
                                                <input data-name="{{ $brand['name'] }}" type="radio" name="brand-user" id="optionsRadios1" value="{{ $brand['id'] }}"
                                                        {{ old('brand-user') == $brand['id'] ? ' checked' : '' }} >
                                            @else
                                                <input data-name="{{ $brand['name'] }}" type="radio" name="brand-user" id="optionsRadios2" value="{{ $brand['id'] }}">
                                            @endif
                                            {{ $brand['name'] }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>

                            <div class="col-sm-6">
                                <div id="products-check-countries">
                                    <label>{{trans('admin::shopping.orderestatus.index.countries')}}</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button id="close-modal" type="button" class="btn btn-default" data-dismiss="modal">@lang('admin::shopping.categories.add.view.form-cancell-button')</button>
                <button id="accept-modal" type="button" class="btn btn-primary">@lang('admin::shopping.categories.add.view.form-next-button')</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->