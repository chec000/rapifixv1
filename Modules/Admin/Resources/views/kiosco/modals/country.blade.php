   {{--Created by PhpStorm.--}}
    {{--User: mario.avila--}}
    {{--Date: 09/08/2018--}}
     {{--Time: 11:00 AM--}}
   <style>
       .form-check-input { margin-left: 20px !important; }
   </style>
   <div id="countries-modal" class="modal fade" tabindex="-1" role="dialog">
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
                               @foreach($countriesUser as $cu)
                                   <div data-country-checkbox="{{ $cu->id }}" name="check-countries">
                                       <input class="form-check-input js-check-country" id="checkCountry_{{ $cu->id }}" value="{{ $cu->id }}" type="checkbox" onclick="enableNextButton()">
                                       <label for="checkCountry_{{ $cu->id }}" id="label-langsCountry_{{ $cu->id }}" class="form-check-label">{{ $cu->name }}</label>
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