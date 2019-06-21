 {{--Created by PhpStorm.--}}
  {{--User: mario.avila--}}
  {{--Date: 07/08/2018--}}
   {{--Time: 05:35 PM--}}
 <div class="container">
     <a class="btn btn-info btn-sm pull-right" href="{{ route('admin.kiosco.index') }}" role="button">
         @lang('admin::shopping.confirmationbanners.index.btn_return')
     </a>
     @if(session('msg'))
         <div class="alert alert-success" role="alert">{{ session('msg') }}</div>
     @elseif(session('errors') != null)
         <div class="alert alert-danger" role="alert">{{ session('errors')->first('msg') }}</div>
     @endif
     <h1>{!!trans('admin::shopping.confirmationbanners.add.view.title-edit')!!}</h1>
     <form id="confirmationbanners" method="POST" action="{{ route('admin.kiosco.updateBanner') }}">
         {{ csrf_field() }}
         {{ method_field('PUT') }}
         <input type="hidden" name="id_banner" value="{{$banner->id}}">
         <div class="form-group">
             <label>@lang('admin::shopping.confirmationbanners.add.view.form-country')</label><br />
             <ul id="countryForm" class="nav nav-tabs" role="tablist">
                 <li data-country-tab="{{ $banner->country_id }}" role="presentation">
                     <a href="#{{str_replace(" ","_", $banner->country->name) }}" aria-controls="home" role="tab" data-toggle="tab">
                         {{ $banner->country->name }} <i class="fa fa-caret-square-o-down" aria-hidden="true"></i>
                     </a>
                 </li>
             </ul>
             <div class="tab-content">
                 <div data-country-pane="{{ $banner->country->id }}" role="tabpanel" class="tab-pane" id="{{ str_replace(" ","_",$banner->country->name) }}"> <br />
                     @foreach(Auth::user()->getCountryLang($banner->country->id) as $langCountry)
                         <div class="form-group">
                             <label for="link">{{ trans('admin::shopping.confirmationbanners.index.link') }} *</label>
                             <input type="text" name="link_{{ $banner->country->id }}" id="link_{{ $banner->country->id }}" class="form-control" value="{{ $banner->link }}">
                         </div>
                         <div role="panel-group" id="accordion-{{ $banner->country->id }}-{{ $langCountry->id }}">
                             <div class="panel panel-default">
                                 <div role="tab" class="panel-heading">
                                     <h4 class="panel-title">
                                         <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#product-language-{{ $banner->country->id }}-{{ $langCountry->id }}">
                                             {{trans('admin::shopping.products.add.second_general_tab.country-language-title') . $langCountry->language }}
                                         </a>
                                     </h4>
                                 </div>
                                 <div role="tabpanel" data-parent="#accordion" class="panel-collapse collapse" id="product-language-{{ $banner->country->id }}-{{ $langCountry->id }}" >
                                     <div class="panel-body">
                                         <div class="row">
                                             <div class="col-md-12">
                                                 <div class="form-group">
                                                     <label for="exampleInputEmail1">@lang('admin::shopping.confirmationbanners.add.input.image')</label>
                                                     <div class="input-group">
                                                         <input type="hidden" name="id_language" value="{{ $langCountry->id }}">
                                                         <input name="image"  rel="requerido_{{ $banner->country->id }}"
                                                                class="requerido requerido_{{ $banner->country->id }} requerido_{{ $banner->country->id }}_{{ $langCountry->id }} form-control"
                                                                id="requerido_{{ $banner->country->id }}_{{ $langCountry->id }}"
                                                                @if(isset($banner->translate($langCountry->locale_key)->image) && !empty($banner->translate($langCountry->locale_key)->image))
                                                                    value="{{ $banner->translate($langCountry->locale_key)->image }}"
                                                                @else
                                                                    value="{{ old('image_'.$banner->country->id.'_'.$langCountry->id) }}"
                                                                 @endif>
                                                         <span class="input-group-btn">
                                                        <a href="{!! URL::to(config('admin.config.public') . '/filemanager/dialog.php?type=1&field_id=requerido_'.$banner->country->id.'_'.$langCountry->id) !!}"
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
                         <div class="radio">
                             <label>
                                 <input type="radio" name="active" value="1"  {{ $banner->active == 1 ? ' checked' : '' }} > Si
                             </label>
                         </div>
                         <div class="radio">
                             <label>
                                 <input type="radio" name="active" value="0" {{ $banner->active == 0 ? ' checked' : '' }}> No
                             </label>
                         </div>
                     </div><br />
                 </div>
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

         });

         $( "#confirmationbanners" ).submit(function( event ) {
             $('.btn-submit-text').hide();
             $('.btn-submit-spinner').show();
             $('.alert-info-input').hide();
             $('#formConfirmationButton').prop('disabled', true);

             let exit         = 1;
             let banderaFinal = 2;

             $('.requerido').each(function(i, elem) {
                 let nameClass      = '.'+$(elem).attr('rel');
                 let banderaLang    = 0;
                 let banderaCountry = 0;
                 $(nameClass).each(function(i1, elem1) {
                     let nameId = '.'+$(elem1).attr('id');
                     let inputLang = 0;
                     let contLang = 0;

                     $(nameId).each(function(i2, elem2) {
                         contLang ++;
                         let elemtTiny = $(elem2).val();

                         if (elemtTiny !== '') {
                             $(elem2).css({'border':'1px solid #ccc'});
                             inputLang ++;
                         } else {
                             $(elem2).css({'border':'1px solid red'});
                         }
                     });

                     if (inputLang === contLang) {
                         banderaLang = 1;
                     }
                     if (banderaLang === 1) {
                         banderaCountry = 1;
                     }
                 });
                 if (banderaFinal === 2 || banderaFinal === 1) {
                     if (banderaCountry === 1 && banderaLang === 1) {
                         exit = 0;
                         banderaFinal = 1;
                     } else {
                         exit = 1;
                         banderaFinal = 0;
                     }
                 } else {
                     exit = 1;
                 }
             });

             if (exit === 1) {
                 event.preventDefault();
                 $('.alert-info-input').show();
                 $('.btn-submit-text').show();
                 $('.btn-submit-spinner').hide();
                 $('#formConfirmationButton').prop('disabled', false);
             }
         });
     </script>
 @endsection