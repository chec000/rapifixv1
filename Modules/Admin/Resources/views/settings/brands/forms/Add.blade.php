<h1> {{trans('admin::brand.form_add.add_new_brand')}}</h1>
<p class="text-right"><a href="{{ route('admin.brand.list') }}">{{trans('admin::brand.form_add.back_list')}}</a></p>
{!! Form::open( ['id'=>'form_add_brand']) !!}

<div class="row">
    <div class="col-md-6">
        <div  class= "form-group {!! FormMessage::getErrorClass('dominio') !!}">
            {!! Form::label('dominio', trans('admin::brand.form_add.url'), ['minlength'=>'5','class' => 'control-label']) !!}

            {!! Form::url('dominio', isset($brand->domain)? $brand->domain:'', ['required','class' => 'form-control','id'=>'domicilio']) !!}
            <span class="help-block">{!! FormMessage::getErrorMessage('dominio') !!}</span>
        </div>

    </div>
    <div class="col-md-6">
  <div class="form-group   {!! FormMessage::getErrorClass('country_id') !!}">
            {!! Form::label('country_id', trans('admin::brand.form_add.countries'), ['class' => 'control-label']) !!}
            {!! Form::select('country_id[]', $countries, Request::input('country_id'),array('required','class' => 'form-control'
            , 'multiple'=>true, 'name' => 'country_id[]', 'id' => 'multiselect_country_id')) !!}
            <span class="help-block">{!! FormMessage::getErrorMessage('country_id') !!}</span>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
               <div class="form-group {!! FormMessage::getErrorClass('isPrincipal') !!}">
    {!! Form::label('isPrincipal',  trans('admin::brand.form_add.parent_brands'), ['class' => 'control-label']) !!}
    <label onclick=" displayDominio()">
            <input type="radio" name="isPrincipal"  value="1" onclick="displayDominio()">
        {!!  trans('admin::brand.form_add.is_principal')!!}
    </label>
    <label onclick="hideDominio()">
        <input type="radio" name="isPrincipal"  checked  value="0" onclick="displayDominio()">
      {!!  trans('admin::brand.form_add.isnot_principal')!!}
    </label>
    <span class="help-block">{!! FormMessage::getErrorMessage('isPrincipal') !!}</span>
  
</div>
          
      
    </div>
    <div class="col-md-6">
        <div  class="form-group   {!! FormMessage::getErrorClass('parent_brand') !!}" id="dominio_div" style="display: none">
            {!! Form::label('parent_brand', trans('admin::brand.form_add.brands'), ['class' => 'control-label']) !!}
            {!! Form::select('parent_brand[]', $brands, Request::input('parent_brand'),array('class' => 'form-control'
            , 'multiple'=>true, 'name' => 'parent_brand[]', 'id' => 'multiselect_domain')) !!}
            <span class="help-block">{!! FormMessage::getErrorMessage('country_id') !!}</span>
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
   <div class="form-group {!! FormMessage::getErrorClass('flag') !!}">
            <label class="control-label">{{ trans('admin::brand.form_add.favicon') }}</label>
            <div class="input-group">
                <input id="flag" class="img_src form-control" name="flag" value="" type="text">
                <span class="input-group-btn">
                    <a href="{!! URL::to(config('admin.config.public').'/filemanager/dialog.php?type=1&field_id=flag') !!}" class="btn btn-default iframe-btn">{{ trans('admin::countries.add_btn_image') }}</a>
                </span>
            </div>
            <span class="help-block">{!! FormMessage::getErrorMessage('flag') !!}</span>
        </div>
    </div>
          <div class="col-md-6">
              <div class="form-group {!! FormMessage::getErrorClass('is_main') !!}">
              {!! Form::label('isPrincipal',  trans('admin::brand.form_add.is_main'), ['class' => 'control-label']) !!}
              <label>
    <input type="radio" name="is_main"  value="1">
        {!!  trans('admin::brand.form_add.is_principal')!!}
    </label>
    <label>
        <input type="radio" name="is_main" checked value="0">
       {!!  trans('admin::brand.form_add.isnot_principal')!!}
    </label>              
     </div>        
    </div>     
    </div>   




@if(isset($add))
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
                <!-- language name field -->
                <div class="row">
                        <div class="form-group col-sm-6">
                    <label for="language_lang" class="control-label">{{ trans('admin::brand.form_add.name_brand') }}</label>
                    <input  class="form-control" name="brand_name[]" value="" type="text">
                </div>
                <!-- language country field -->
                <div class="form-group col-sm-6">

                    <label for="language_lang" class="control-label">{{ trans('admin::brand.form_add.key_brand') }}</label>
                    <input class="form-control"  name="brand_alias[]" value="" type="text">
                    <input type="hidden" name="brand_locale[]" value="{!! $lan->locale_key!!}">

                </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6 {!! FormMessage::getErrorClass('flag') !!}">
            <label class="control-label">{{ trans('admin::brand.form_add.add_icon') }}</label>
            <div class="input-group">
                <input id="logo-{{$lan->id}}" class="img_src form-control" name="logo[]" value="" type="text">
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
        <button class='btn btn-primary addButton' type="submit">
        {{trans('admin::brand.form_add.btn_add')}}
    </button>

</div>
{!! Form::close() !!}

@section('scripts')
<script type="text/javascript">



    $(document).ready(function () {
        load_editor_js();
        $('#multiselect_country_id').select2();
        $('#multiselect_domain').select2();
  var country= $('#multiselect_country_id');
  var span=country.siblings('span');
          span.css('width', '100%');

    });
    function saveBrand() {
        var form = $('#form_add_brand');

        var datos = form.serialize();

        var uri = form.attr('action');
        var request = $.ajax({
            url: uri,
            data: datos,
            method: "POST",
        });
        request.done(function (result) {
            // $('#form_add_brand')[0].reset();
            saveIcon();
            console.log(result);
            if (result.code === 200) {
                let alerta = $('#cmsDefaultNotification');
                alerta.addClass(result.class);
                //alerta.realertamoveAttr( 'style' );
                alerta.css("display", "block");
                alerta.append('<span>' + result.message + '</span>');
                $('html, body').animate({scrollTop: 0}, 'slow');
                alerta.hide(6000, function () {
                    alerta.css("display", "none");
                });
            }

        });

    }


    function displayDominio() {
        $("#dominio_div").css("display", "block");
              let span = $('#multiselect_domain').siblings('span');
                    span.css('width', '100%');
                 
                  
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

    }
    function hideParent() {
        $("#parent_div").css("display", "none");
        $("#no_selected_parent").prop("selected", true);

    }


    function hideDominio() {
        $("#dominio_div").css("display", "none");
    }
    function disableBrand(brand_id) {
        $.ajax({
            url: route('admin.bread.activeBrand'),
            type: 'POST',
            data: {brand_id: brand_id},
            success: function (data) {
                let label = $("#status" + brand_id);
                let iconActive = $("#activeBrand" + brand_id);
                let iconInactive = $("#inactiveBrand" + brand_id);
                if (data.status === 0) {
                    iconActive.removeClass('hide');
                    iconInactive.addClass('hide');
                    label.removeClass('label-success').addClass('label-default');
                    label.text(data.message);
                } else {
                    iconActive.addClass('hide');
                    iconInactive.removeClass('hide');
                    label.removeClass('label-default').addClass('label-success');
                    label.text(data.message);
                }
            }
        });
    }

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