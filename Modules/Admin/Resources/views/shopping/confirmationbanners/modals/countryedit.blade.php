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
                <form id="categories" method="POST" action="{{ route('admin.confirmationbanners.store') }}">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <div id="products-check-countries">
                            <label>{{trans('admin::shopping.orderestatus.index.countries')}}</label>

                            @foreach($confirmationsByCountry as $confirmation)
                                <div data-country-checkbox="{{ $confirmation->country->id }}" name="check-countries">
                                    <input checked class="form-check-input" id="checkCountry_{{ $confirmation->country->id }}" value="{{ $confirmation->country->id }}" type="checkbox">
                                    <label for="checkCountry_{{ $confirmation->country->id }}" id="label-langsCountry_{{ $confirmation->country->id }}" class="form-check-label">{{ $confirmation->country->name }}</label>
                                </div>
                            @endforeach

                            @foreach($anotherCountries as $uC)
                                <div data-country-checkbox="{{ $uC->id }}" name="check-countries">
                                    <input class="form-check-input" id="checkCountry_{{ $uC->id }}" value="{{ $uC->id }}" type="checkbox">
                                    <label for="checkCountry_{{ $uC->id }}" id="label-langsCountry_{{ $uC->id }}" class="form-check-label">{{ $uC->name }}</label>
                                </div>
                            @endforeach
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