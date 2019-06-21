<h1> {{trans('admin::brand.form_add.updatebrand')}}</h1>
<p class="text-right"><a href="{{ route('admin.brand.list') }}">{{trans('admin::brand.form_add.back_list')}}</a></p>
{!! Form::open( ['id'=>'form_add_brand']) !!}
<input type="hidden" value="{!!$brand->id!!}" name="id_brand">
<div class="row">

    <div class="col-md-6">
        <div  class= "form-group {!! FormMessage::getErrorClass('dominio') !!}" >
            {!! Form::label('dominio', trans('admin::brand.form_add.url'), ['class' => 'control-label']) !!}
            <div class="{!! FormMessage::getErrorClass('dominio') !!}">
                {!! Form::text('dominio', isset($brand->domain)? $brand->domain:'', ['class' => 'form-control','id'=>'domicilio']) !!}
                <span class="help-block">{!! FormMessage::getErrorMessage('dominio') !!}</span>
            </div>
        </div>

    </div>
    <div class="col-md-6">
              <div class="form-group   {!! FormMessage::getErrorClass('country_id') !!}">
            {!! Form::label('country_id', trans('admin::brand.form_add.countries'), ['class' => 'control-label']) !!}
            {!! Form::select('country_id[]', $countries, $countriesSelected,array('required','class' => 'form-control'
            , 'multiple'=>true, 'name' => 'country_id[]', 'id' => 'multiselect_country_id')) !!}
            <span class="help-block">{!! FormMessage::getErrorMessage('country_id') !!}</span>
        </div>

</div>
</div>
<div class="row">
    <div class="col-md-6">
             <div class="form-group {!! FormMessage::getErrorClass('isPrincipal') !!}">  
    {!! Form::label('isPrincipal', trans('admin::brand.form_add.parent_brands') , ['class' => 'control-label']) !!}
    <label onclick=" displayDominio()">
        <!--{!! Form::radio('isPrincipal',$brand->is_main, [($brand->is_dependent==1)?'checked':'','class' => 'form-control','onclick'=>'displayDominio()']) !!}-->
        <input type="radio" value="1" name="isPrincipal" {!!($brand->parent_brand_id!=0)?'checked':''!!}>
        {!!  trans('admin::brand.form_add.is_principal')!!}
    </label>
    <label onclick="hideDominio()">
        <!--{!! Form::radio('isPrincipal',0, ['class' => 'form-control']) !!}-->
        <input type="radio" value="0" name="isPrincipal"  {{($brand->parent_brand_id==0)?'checked':''}}>
        {!!  trans('admin::brand.form_add.isnot_principal')!!}
    </label>
    <span class="help-block">{!! FormMessage::getErrorMessage('isPrincipal') !!}</span>
</div>      

    </div>
    <div class="col-md-6">
     <div style='display: {{($brand->parent_brand_id!=0)?'block':'none'}}'  class="form-group   {!! FormMessage::getErrorClass('parent_brand') !!}" id="dominio_div" >
            {!! Form::label('parent_brand', trans('admin::brand.form_add.brands'), ['class' => 'control-label']) !!}
            {!! Form::select('parent_brand[]', $brands,$brandsDependents,array('class' => 'form-control'
            , 'multiple'=>true, 'name' => 'parent_brand[]', 'id' => 'multiselect_domain')) !!}
            <span class="help-block">{!! FormMessage::getErrorMessage('parent_brand') !!}</span>

        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <p class="text-danger">{!!$validacion!!}</p>
    </div>
</div>
<div class="row">
    
    <div class="col-md-6">
                         <div class="form-group">
            <label class="control-label">{{ trans('admin::brand.form_add.favicon') }}</label>
            <div class="input-group">

                <input id="flag" class="img_src form-control" value='{{$brand->favicon}}' name="flag" value="" type="text">
                <span class="input-group-btn">
                    <a href="{!! URL::to(config('admin.config.public').'/filemanager/dialog.php?type=1&field_id=flag') !!}" class="btn btn-default iframe-btn">{{ trans('admin::countries.add_btn_image') }}</a>
                </span>
            </div>
        </div>
    </div>
  
           <div class="col-md-6">
              <div class="form-group {!! FormMessage::getErrorClass('is_main') !!}">
              {!! Form::label('isPrincipal',  trans('admin::brand.form_add.is_main'), ['class' => 'control-label']) !!}
              <label>
    <input type="radio" name="is_main" value="1"  {{($brand->is_main==1)?'checked':'' }} >
        {!!  trans('admin::brand.form_add.is_principal')!!}
    </label>
    <label>
        <input type="radio" name="is_main" value="0"  {{($brand->is_main==0)?'checked':''}}  >
       {!!  trans('admin::brand.form_add.isnot_principal')!!}
    </label>              
     </div>        
    </div>  
  
    
</div>
@if(isset($update))
<h3>{{ trans('admin::brand.form_add.brand_traslates') }}</h3>
<p class="text-danger" style="font-style: italic;">{{ trans('admin::brand.form_add.brand_disclaimer') }}</p>
@foreach ($languages as $i=> $lan)
<div role="panel-group" id="accordion-{{$lan['id'] }}">
    <div class="panel panel-default">
        <div role="tab" class="panel-heading">
            <h4 class="panel-title">
                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion-{{$lan['id'] }}" href="#brand-language-{{$lan['id'] }}">{{trans('admin::roles.modal_add.country-language-title') . $lan['language'] }}</a>
            </h4>
        </div>
        <div role="tabpanel" data-parent="#accordion-{{$lan['id'] }}" id="brand-language-{{$lan['id'] }}"
             class="panel-collapse {{($lan['id'] == Session::get('language') || $errors->has('role_data['.$lan->id.'][name]')) ? 'in' : 'collapse'}}" >
            <div class="panel-body">
                <h3>{!! $lan->language!!}</h3>
                <div class="row">
                    <!-- language name field -->
                    <div class="form-group col-sm-6">
                        <label for="language_lang" class="control-label">{{ trans('admin::brand.form_add.name_brand') }}</label>
                        <input  class="form-control" name="brand_name[]" value="{{$lan->name}}" type="text">
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="language_lang" class="control-label">{{ trans('admin::brand.form_add.key_brand') }}</label>
                        <input  class="form-control" name="brand_alias[]" value="{{$lan->alias}}" type="text">
                        <input  class="form-control" name="brand_locale[]" value="{!!$lan->locale_key !!}" type="hidden">
                    </div>

                </div>
                 <div class="row">
                    <div class="form-group col-md-6 {!! FormMessage::getErrorClass('flag') !!}">
            <label class="control-label">{{ trans('admin::brand.form_add.add_icon') }}</label>
            <div class="input-group">
                <input  value="{{$lan->logo}}" id="logo-{{$lan->id}}" class="img_src form-control" name="logo[]" value="" type="text">
                <span class="input-group-btn">
                    <a href="{{ URL::to(config('admin.config.public').'/filemanager/dialog.php?type=1&field_id=logo-'.$lan->id ) }}" class="btn btn-default iframe-btn">{{ trans('admin::countries.add_btn_image') }}</a>
                </span>
            </div>
            <span class="help-block">{!! FormMessage::getErrorMessage('flag') !!}</span>
        </div>
                </div>

            </div>
        </div>
    </div>

</div>
@endforeach
<span class="text-danger">{!!$msg!!}</span>
@endif
<div class="form-group">
    {!!Form::submit(trans('admin::brand.form_add.btn_update'),[ 'class'=>'btn btn-primary addButton'])!!}


</div>

<!--<button type="submit" class="btn btn-primary addButton"><i class="fa fa-plus"></i> &nbsp; Add Language</button>-->

{!! Form::close() !!}
@section('scripts')
<script type="text/javascript">

    function displayDominio() {
        $("#dominio_div").css("display", "block");
        let span = $('#multiselect_domain').siblings('span');
        span.css('width', '100%');
//        multiselect_domain
    }

    function displayAction() {
        $("#div_action").css("display", "block");

    }

    function hideAction() {
        $("#div_action").css("display", "none");
        $("#no_selected_action").prop("selected", true);
    }
    function displayParent() {
        $("#parent_div").css("display", "block");
        let span = $('#multiselect_domain').siblings('span');
        console.log(span);
        span.css('width', '100%');
    }
    function hideParent() {
        $("#parent_div").css("display", "none");
        $("#no_selected_parent").prop("selected", true);

    }


    function hideDominio() {
        $("#dominio_div").css("display", "none");
    }


    $(document).ready(function () {
        load_editor_js();
        $('#multiselect_country_id').select2();
        $('#multiselect_domain').select2();


    });


    $('#parent_id').on('change', function (e) {
//  var optionSelected = $("option:selected", this);
        var valueSelected = this.value;
        $.ajax({
            url: route('admin.menu.order'),
            type: 'POST',
            data: {menu_id: valueSelected},
            success: function (data) {
                if (data !== null) {
                    $('#order').val(data.order + 1);
                }
            }
        });
    });


</script>
@stop

