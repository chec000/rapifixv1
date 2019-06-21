<div id="brand-modal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ $title }}</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12" id="error-modal" style="display: none" >
                        <div class="alert alert-warning alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            @lang('admin::shopping.filters.message.error.brand')
                        </div>
                    </div >
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>@lang('admin::shopping.filters.view.brand')</label>
                            @foreach ($userBrands as $brand)
                                <div class="radio">
                                    <label>
                                        <input data-name="{{ $brand['name'] }}" type="radio" name="brand-user"
                                               id="optionsRadios1" class="optionsRadios1" value="{{ $brand['id'] }}">
                                        {{ $brand['name'] }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <div id="products-check-countries">
                                <label>@lang('admin::shopping.filters.view.country')</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button id="close-modal" type="button" class="btn btn-default" data-dismiss="modal">@lang('admin::shopping.categories.add.view.form-cancell-button')</button>
                <button id="accept-modal" type="button" class="btn btn-primary">@lang('admin::shopping.categories.add.view.form-next-button')</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->