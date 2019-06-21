 {{--Created by PhpStorm.--}}
  {{--User: mario.avila--}}
  {{--Date: 07/08/2018--}}
   {{--Time: 03:49 PM--}}
 @if(session('msg'))
     <div class="alert alert-success" role="alert">{{ session('msg') }}</div>
 @elseif(session('errors') != null)
     <div class="alert alert-danger" role="alert">{{ session('errors')->first('msg') }}</div>
 @endif
 <div class="row textbox">
     <div class="col-sm-6">
         <h1> {{trans('admin::kiosco.banners.index.title')}} </h1>
     </div>
     <div class="col-sm-6 text-right">
         @if (Auth::action('confirmationbanners.create'))
             <a href="{{ route('admin.kiosco.createBanner') }}" class="btn btn-warning addButton"><i class="fa fa-plus"></i> &nbsp;
                 {{trans('admin::kiosco.banners.index.form-add-button')}}
             </a>
         @endif
     </div>
 </div>
 <div class="table">
     <table class="table table-striped" id="tb_confirmations">
         <thead>
         <tr>
             <th>{{ trans('admin::shopping.confirmationbanners.index.thead-confirmation-countries') }}</th>
             <th>{{ trans('admin::shopping.confirmationbanners.index.thead-confirmation-purpose') }}</th>
             <th>{{ trans('admin::shopping.confirmationbanners.index.thead-confirmation-active') }}</th>
             @if (Auth::action('confirmationbanners.edit') || Auth::action('confirmationbanners.delete'))
                 <th class="text-center">{{ trans('admin::shopping.confirmationbanners.index.thead-confirmation-actions') }}</th>
             @endif
         </tr>
         </thead>
         <tbody>
         @foreach ($kiosco_banners as $banner)
             <tr id="cat_{!! $banner->id !!}">
                 <td>
                     <span class="label label-default"> {{  $banner->country->name }} </span>
                 </td>
                 <td>
                     @foreach ($banner->purposes as $p)
                         {{  $p->purpose }}
                     @endforeach
                 </td>
                 <td>
                     @if($banner->active == 1)
                         <span class="label label-success">@lang('admin::shopping.categories.index.category_active')</span>
                     @else
                         <span class="label label-warning">@lang('admin::shopping.categories.index.category_inactive')</span>
                     @endif
                 </td>
                 <td>
                     <div class="row">
                         <div class="col-xs-4 text-center">
                             @if($banner->active == 1)
                                 @if (\Auth::action('kiosco.changeStatusBanner'))
                                     <form name="formOff_{{ $banner->type_id }}_{{ $banner->purpose_id }}" method="POST" action="{{ route('admin.kiosco.changeStatusBanner') }}">
                                         {{ csrf_field() }}
                                         <input type="hidden" name="new-status" value="0"/>
                                         <input type="hidden" name="id_banner" value="{{$banner->id}}">
                                         <i class="fa fa-pause itemTooltip" aria-hidden="true" style="color: red"
                                            onclick="document.forms['formOff_{{ $banner->type_id }}_{{ $banner->purpose_id }}'].submit();"
                                            title="{{ trans('admin::shopping.confirmationbanners.index.disable') }}"></i>
                                     </form>
                                 @endif
                             @else
                                 @if (\Auth::action('kiosco.changeStatusBanner'))
                                     <form name="formOn_{{ $banner->type_id }}_{{ $banner->purpose_id }}" method="POST" action="{{ route('admin.kiosco.changeStatusBanner') }}">
                                         {{ csrf_field() }}
                                         <input type="hidden" name="new-status" value="1"/>
                                         <input type="hidden" name="id_banner" value="{{$banner->id}}">
                                         <i class="fa fa-play itemTooltip" aria-hidden="true" style="color: green"
                                            onclick="document.forms['formOn_{{ $banner->type_id }}_{{ $banner->purpose_id }}'].submit();"
                                            title="{{ trans('admin::shopping.confirmationbanners.index.enable') }}"></i>
                                     </form>
                                 @endif
                             @endif
                         </div>
                         <div class="col-xs-4 text-center">
                             @if (\Auth::action('kiosco.editBanner'))
                                 <a class="fa fa-pencil itemTooltip" href="{{ route('admin.kiosco.editBanner', ['id_banner'=>$banner->id])}}"
                                    title="{{ trans('admin::shopping.confirmationbanners.index.edit') }}" style="color: black"></a>
                             @endif
                         </div>
                         <div class="col-xs-4 text-center">
                             @if (\Auth::action('kiosco.destroyBanner'))
                                 <form name="formDel_{{ $banner->type_id }}_{{ $banner->purpose_id }}" method="POST" action="{{ route('admin.kiosco.destroyBanner', ['code' => $banner->id]) }}">
                                     <input type="hidden" name="type" value="deactivate"/>
                                     {{ csrf_field() }}
                                     {{ method_field('DELETE') }}
                                     <input type="hidden" name="id_banner" value="{{$banner->id}}">
                                     <i class="fa fa-trash itemTooltip" aria-hidden="true" onclick="document.forms['formDel_{{ $banner->type_id }}_{{ $banner->purpose_id }}'].submit();"
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