<?php AssetBuilder::setStatus('cms-editor', true); ?>

<h1>{!! trans('admin::pages.add_new_page') !!} {!! $item_name !!}</h1>
<!--
<p class="text-right"><a class="btn btn-warning" href="{{ route('admin.pages.index') }}">{{trans('admin::brand.form_add.back_list')}}
         <i class="fa fa-reply">
            </i>
    </a></p>
    -->
    <div class="row">
        <div class="col-md-8">

        </div>
        <div  class="col-md-4">
             <div class="text-right">
            <form  action="{{route('admin.pages.index')}}" method="get" style="display: inline-block">
                 <input name="brand_id" type="hidden" value="{{$brand->id}}">
              <input name="country_id" type="hidden" value="{{$country->id}}">
              <input name="language_id" type="hidden" value="{{$language->id}}">
            <button class="btn btn-warning"  type="submit">
                                 {{trans('admin::brand.form_add.back_list')}}
                        <i class="fa fa-reply">                
            </i>
            </button>             
</form>
        
    </div>
            
        </div>
    </div>
   


{!! Form::open(['class' => 'form-horizontal', 'id' => 'addForm', 'enctype' => 'multipart/form-data']) !!}

<div class="tabbable" id="contentTabs">

    <ul class="nav nav-tabs">
        {!! $tab['headers'] !!}
    </ul>
    <h4>{!! trans('admin::pages.global_details') !!}</h4>
    <div class="form-group">
        <div class="row" >
                       <label for="brand_id" class="control-label col-md-2">{!! trans('admin::pages.brand') !!}: </label>
          <div class="col-sm-10">
               <span class="form-control">{{$brand->name}}</span>
            <input name="brand_id" type="hidden" value="{{$brand->id}}">
              </div>

    </div>
    </div>
    <div class="form-group">
        <div class="row">
                          <label for="country_id" class="control-label col-md-2">{!! trans('admin::pages.country') !!}:</label>

                  <div class="col-sm-10">
              <span class="form-control">{{$country->name}}</span>

            <input name="country_id" type="hidden" value="{{$country->id}}">
           </div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
                          <label for="language_id" class="control-label col-md-2">{!! trans('admin::pages.language') !!}:</label>

             <div class="col-sm-10">
              <span class="form-control">{{$language->language}}</span>
              <input name="language_id" type="hidden" value="{{$language->id}}">
             </div>
        </div>
        
    </div>
    
    <div class="tab-content">
        {!! $tab['contents'] !!}
    </div>

</div>

{!! Form::close() !!}

@section('scripts')
    <script type='text/javascript'>
        $(document).ready(function () {

            selected_tab('#addForm', 0);
            updateListenPageUrl();
            updateListenGroupFields();
            updateListenLiveOptions();
            load_editor_js();
            headerNote();

            var link_show, url_prefix;
            $('#page_info\\[link\\]').change(function () {
                if ($(this).is(':checked')) {
                    url_prefix = $('#url-prefix').detach();
                    if (link_show) {
                        link_show.appendTo('#url-group');
                    }
                    $('#template_select').hide();
                }
                else {
                    if (url_prefix) {
                        url_prefix.prependTo('#url-group');
                    }
                    link_show = $('.link_show').detach();
                    $('#template_select').show();
                }
            }).trigger('change');

            $('#page_info\\[parent\\]').change(function () {
                $('#url-prefix').html(urlArray[$(this).val()]);
            });

        });
    </script>
@append
