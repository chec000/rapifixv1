@section('styles')
@endsection
<div class="container">
    <a class="btn btn-info btn-sm pull-right" href="{{ route('admin.confirmationbanners.index') }}" role="button">
        @lang('admin::shopping.confirmationbanners.index.btn_return')
    </a>
    @if(session('msg'))
        <div class="alert alert-success" role="alert">{{ session('msg') }}</div>
    @elseif(session('errors') != null)
        <div class="alert alert-danger" role="alert">{{ session('errors')->first('msg') }}</div>
    @endif
    <h1>{!!trans('admin::shopping.confirmationbanners.add.view.title-edit')!!}</h1>
    <form id="confirmationbanners" method="POST" action="{{ route('admin.confirmationbanners.update', ['global_name'=>urlencode($globalName)]) }}">
        {{ csrf_field() }}
        {{ method_field('POST') }}

        <input type="hidden" name="type_old" value="{{ $type }}">
        <input type="hidden" name="purpose_old" value="{{ $purpose }}">
        <input type="hidden" name="global_name_old" value="{{ $globalName }}">

        <div class="form-group">
            <label for="global_name">{{ trans('admin::shopping.products.index.thead-product-global_name') }}</label>
            <input type="text" name="global_name" id="global_name" class="form-control" value="{{ $globalName }}">
        </div>
        <div class="form-group">
            <label for="purpose">{{ trans('admin::shopping.confirmationbanners.index.purpose') }} *</label>
            <select name="purpose" id="purpose" class="form-control" required="required">
                <option value="">{{trans('admin::shopping.confirmationbanners.index.choose_option')}}</option>
                @foreach($purpose_list as $pl)

                 <option value="{{$pl->id}}" {{ $purpose == $pl->id ? 'selected="selected"' : '' }}>{{$pl->purpose}}</option>

                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="type">{{ trans('admin::shopping.confirmationbanners.index.type') }} *</label>
            <select name="type" id="type" class="form-control" required="required">
                <option value="">{{trans('admin::shopping.confirmationbanners.index.choose_option')}}</option>
                @foreach($type_list as $tl)

                    <option value="{{$tl->id}}" {{ $type == $tl->id ? 'selected="selected"' : '' }}>{{$tl->type}}</option>

                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>@lang('admin::shopping.confirmationbanners.add.view.form-country')</label><br />
            <ul id="countryForm" class="nav nav-tabs" role="tablist">
                @foreach($confirmationsByCountry as $confirmation)
                    @if (in_array($confirmation->country->id, $countriesTo))
                        <li data-country-tab="{{ $confirmation->country->id }}" role="presentation">
                            <a href="#{{str_replace(" ","_", $confirmation->country->name) }}" aria-controls="home" role="tab" data-toggle="tab">
                                {{ $confirmation->country->name }} <i class="fa fa-caret-square-o-down" aria-hidden="true"></i>
                            </a>
                        </li>
                    @endif
                @endforeach

                @foreach($anotherCountries as $uC)
                    <li role="presentation" data-country-tab="{{ $uC->id }}">
                        <a href="#{{ str_replace(" ","_",$uC->name) }}" aria-controls="home" role="tab" data-toggle="tab">
                            {{ $uC->name }} <i class="fa fa-caret-square-o-down" aria-hidden="true"></i>
                        </a>
                    </li>
                @endforeach
            </ul>
            <div class="tab-content">
                @foreach($confirmationsByCountry as $confirmation)
                    @if (in_array($confirmation->country->id, $countriesTo))
                        <div data-country-pane="{{ $confirmation->country->id }}" role="tabpanel" class="tab-pane" id="{{ str_replace(" ","_",$confirmation->country->name) }}"> <br />

                            @foreach(Auth::user()->getCountryLang($confirmation->country->id) as $langCountry)
                                <div class="form-group">
                                    <label for="link">{{ trans('admin::shopping.confirmationbanners.index.link') }} *</label>
                                    <input type="text" name="link_{{ $confirmation->country->id }}" id="link_{{ $confirmation->country->id }}" class="form-control" value="{{ $confirmation->link }}">
                                </div>
                                <div role="panel-group" id="accordion-{{ $confirmation->country->id }}-{{ $langCountry->id }}">
                                    <div class="panel panel-default">
                                        <div role="tab" class="panel-heading">
                                            <h4 class="panel-title">
                                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#product-language-{{ $confirmation->country->id }}-{{ $langCountry->id }}">
                                                    {{trans('admin::shopping.products.add.second_general_tab.country-language-title') . $langCountry->language }}
                                                </a>
                                            </h4>
                                        </div>
                                        <div role="tabpanel" data-parent="#accordion" class="panel-collapse collapse" id="product-language-{{ $confirmation->country->id }}-{{ $langCountry->id }}" >
                                            <div class="panel-body">
                                                <div class="row">
                                                    <div class="col-md-12">


                                                        <div class="form-group">
                                                            <label for="exampleInputEmail1">@lang('admin::shopping.confirmationbanners.add.input.image')</label>
                                                            <div class="input-group">
                                                                <input name="image_{{ $confirmation->country->id }}_{{ $langCountry->id }}"
                                                                       rel="requerido_{{ $confirmation->country->id }}"
                                                                       class="requerido requerido_{{ $confirmation->country->id }} requerido_{{ $confirmation->country->id }}_{{ $langCountry->id }} form-control"
                                                                       id="requerido_{{ $confirmation->country->id }}_{{ $langCountry->id }}"
                                                                       @if(isset($confirmation->translate($langCountry->locale_key)->image) && !empty($confirmation->translate($langCountry->locale_key)->image))
                                                                       value="{{ $confirmation->translate($langCountry->locale_key)->image }}"
                                                                       @else
                                                                       value="{{ old('image_'.$confirmation->country->id.'_'.$langCountry->id) }}"
                                                                        @endif>
                                                                <span class="input-group-btn">
                                                                <a href="{!! URL::to(config('admin.config.public') . '/filemanager/dialog.php?type=1&field_id=requerido_'.$confirmation->country->id.'_'.$langCountry->id) !!}"
                                                                   class="btn btn-default iframe-btn">
                                                                    {{ trans('admin::countries.add_btn_image') }}
                                                                </a>
                                                            </span>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            <hr />
                            <div class="form-group">
                                <label>@lang('admin::shopping.confirmationbanners.add.view.form-active')</label>
                                <?php $valActive = 0; ?>
                                @isset($confirmation->active)
                                    @if($confirmation->active == 1)
                                        <?php $valActive = 1; ?>
                                    @endif
                                @endisset
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="active_{{ $confirmation->country->id }}" value="1"  {{ $valActive == 1 ? ' checked' : '' }} > Si
                                    </label>
                                </div>
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="active_{{ $confirmation->country->id }}" value="0" {{ $valActive == 0 ? ' checked' : '' }}> No
                                    </label>
                                </div>
                            </div><br />

                        </div>
                    @endif
                @endforeach

                @foreach($anotherCountries as $uC)
                    <div role="tabpanel" class="tab-pane" id="{{ str_replace(" ","_",$uC->name) }}" data-country-pane="{{ $uC->id }}"> <br />
                        @foreach(Auth::user()->getCountryLang($uC->id) as $langCountry)
                            <div class="form-group">
                                <label for="link">{{ trans('admin::shopping.confirmationbanners.index.link') }}</label>
                                <input type="text" name="link_{{ $langCountry->id }}" id="link_{{ $langCountry->id }}" class="form-control" value="">
                            </div>
                            <div role="panel-group" id="accordion-{{ $uC->id }}-{{ $langCountry->id }}">
                                <div class="panel panel-default">
                                    <div role="tab" class="panel-heading">
                                        <h4 class="panel-title">
                                            <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion"
                                               href="#product-language-{{ $uC->id }}-{{ $langCountry->id }}">
                                                {{trans('admin::shopping.products.add.second_general_tab.country-language-title') . $langCountry->language }}
                                            </a>
                                        </h4>
                                    </div>
                                    <div role="tabpanel" data-parent="#accordion" class="panel-collapse collapse"
                                         id="product-language-{{ $uC->id }}-{{ $langCountry->id }}" >
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="col-md-12">

                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">@lang('admin::shopping.confirmationbanners.add.input.image')*</label>
                                                        <div class="input-group">
                                                            <input name="image_{{ $uC->id }}_{{ $langCountry->id }}"
                                                                   rel="requerido_{{ $uC->id }}"
                                                                   class="requerido requerido_{{ $uC->id }} requerido_{{ $uC->id }}_{{ $langCountry->id }} form-control"
                                                                   id="requerido_{{ $uC->id }}_{{ $langCountry->id }}"
                                                                   value="{{ old('image_'.$uC->id.'_'.$langCountry->id) }}">
                                                            <span class="input-group-btn">
                                                                <a href="{!! URL::to(config('admin.config.public') . '/filemanager/dialog.php?type=1&field_id=requerido_'.$uC->id.'_'.$langCountry->id) !!}"
                                                                   class="btn btn-default iframe-btn">
                                                                    {{ trans('admin::countries.add_btn_image') }}
                                                                </a>
                                                            </span>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- dd($langCountry)  --}}
                        @endforeach
                        <hr />
                        <div class="form-group">
                            <label for="exampleInputEmail1">@lang('admin::shopping.confirmationbanners.add.view.form-active')</label>
                            <div class="radio">
                                <label>
                                    <input type="radio" name="active_{{ $uC->id }}" value="1" @if(old('active_'.$uC->id) == null || old('active_'.$uC->id)) checked @else '' @endif>
                                    @lang('admin::shopping.confirmationbanners.add.input.yes')
                                </label>
                            </div>
                            <div class="radio">
                                <label>
                                    <input type="radio" name="active_{{ $uC->id }}" value="0" {{ old('active_'.$uC->id) === 0 ? ' checked' : '' }}>
                                    @lang('admin::shopping.confirmationbanners.add.input.no')
                                </label>
                            </div>
                        </div><br />

                    </div>
                @endforeach
            </div>
        </div>
        <div class="form-group text-center">
            <div class="alert alert-danger alert-info-input" role="alert" style="display: none">
                @lang('admin::shopping.confirmationbanners.add.view.form-error')
            </div>
            <button type="submit" id="formConfirmationButton" class="btn btn-default">
                <span class="btn-submit-text">@lang('admin::shopping.confirmationbanners.add.view.form-save-button')</span>
                <span class="btn-submit-spinner" style="display: none"><i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i></span>
            </button>
        </div>
    </form>
</div>

@section('scripts')
    <script type="text/javascript">
        function deleteTabsFromUnselectedCountries() {
            // $('.form-check-input:not(:checked)')
            // $('.form-check-input:checked')

            countriesToCreate = [];
            $.each($('.form-check-input:checked'), function (i, checkbox) {
                countriesToCreate.push(parseInt($(checkbox).val()));
            });

            $.each($('[data-country-tab]'), function (i, element) {
                if (countriesToCreate.indexOf($(element).data('country-tab')) == -1) { $(element).remove(); }
            });

            $.each($('[data-country-pane]'), function (i, element) {
                if (countriesToCreate.indexOf($(element).data('country-pane')) == -1) { $(element).remove(); }
            });
        }

        $( document ).ready(function() {
            load_editor_js();
            $("#countryForm li a:first").click();
            $(".accordion-toggle:first").click();

            $('#brand-modal').modal({
                show: true,
                keyboard: false,
                backdrop: 'static',
            });
            $('#close-modal').click(function () {
                history.go(-1);
            });
            $('#accept-modal').click(function () {
                $('#brand-modal').modal('hide');
                deleteTabsFromUnselectedCountries();
            });
        });
        $( "#confirmationbanners" ).submit(function( event )
        {
            $('.btn-submit-text').hide();
            $('.btn-submit-spinner').show();
            $('.alert-info-input').hide();
            $('#formConfirmationButton').prop('disabled', true);

            var banderaFinal = 2;
            var exit = 1;
            $('.requerido').each(function(i, elem)
            {

                var nameClass = '.'+$(elem).attr('rel');
                var banderaLang = 0;
                var banderaCountry = 0;


                $(nameClass).each(function(i1, elem1)
                {

                    var nameId = '.'+$(elem1).attr('id');
                    var inputLang = 0;
                    var contLang = 0;

                    $(nameId).each(function(i2, elem2)
                    {
                        contLang ++;

                        var elemtTiny = $(elem2).val();


                        if(elemtTiny != ''){
                            $(elem2).css({'border':'1px solid #ccc'});
                            inputLang ++;
                        } else {

                            $(elem2).css({'border':'1px solid red'});
                        }
                    });

                    if(inputLang == contLang){
                        banderaLang = 1;
                    }
                    if(banderaLang == 1){
                        banderaCountry = 1;
                    }
                });
                if(banderaFinal == 2 || banderaFinal == 1){


                    if (banderaCountry == 1 && banderaLang == 1){

                        exit = 0;
                        banderaFinal = 1;
                    }else{

                        exit = 1;
                        banderaFinal = 0;
                    }
                }else{

                    exit == 1;
                }
            });
            if(exit == 1){
                event.preventDefault();
                $('.alert-info-input').show();
                $('.btn-submit-text').show();
                $('.btn-submit-spinner').hide();
                $('#formConfirmationButton').prop('disabled', false);
            }
        });
    </script>
@endsection
