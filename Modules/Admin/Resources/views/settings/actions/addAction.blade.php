
<h1>{!!trans('admin::action.add_action')!!}</h1>
<p class="text-right"><a href="{{ route('admin.action.list') }}">{{trans('admin::menu.return')}}</a></p>
{!! Form::open() !!}

<div class="row">
    <div class="col-md-6  {!! FormMessage::getErrorClass('action_alias')!!}">
        {!! Form::label('action_alias', trans('admin::action.action_name'), ['class' => 'control-label']) !!}           
        {!! Form::text('action_alias','',['class' => 'form-control','required'] ) !!}                                       
    </div>
    <div class="col-md-6 {!! FormMessage::getErrorClass('rol_section')!!}" >
        {!! Form::label('rol_section', trans('admin::action.select_controller'), ['class' => 'control-label']) !!}           
        <select name="controller" class="form-control" required="">
            <option></option>
            @foreach($controllers as $controller)
            @if(old('controller',$controller->id) == $controller->id )
            <option value="{{$controller->id}}" selected>{!!$controller->role_name!!}</option>
            @else
            <option value="{{$controller->id}}">{!!$controller->role_name!!}</option>
            @endif   
            @endforeach
        </select>
    </div>
    <div class="col-md-6  {!! FormMessage::getErrorClass('action_alias')!!}">
        {!! Form::label('action_others', trans('admin::action.action_others'), ['class' => 'control-label']) !!}
        {!! Form::text('action_others','',['class' => 'form-control'] ) !!}
    </div>

</div>

<div class="row">
    <div class="col-md-6">                    
        <div class="form-group ">   
            <div class="col-md-6">                    
                <div class="form-group ">   
                    <div class="checkbox">
                        {!!trans('admin::action.edited_based')!!}
                        <label> {!! Form::checkbox('edit_based',1,null) !!} </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group {!! FormMessage::getErrorClass('action_alias')!!}">   
            {!! Form::label('isPrincipal',  trans('admin::menu.parent_action'), ['class' => 'control-label']) !!}

            <div class="radio" style="display: inline-block">
                <label id="dependent_action_radio">
                    {!! Form::radio('parent',true, ['class' => 'form-control separar_radio','required','onclick'=>'displayParent()']) !!}
                    {!!  trans('admin::brand.form_add.is_principal')!!} 

                </label> 
            </div>
            <div class="radio" style="display: inline-block">
                <label onclick='hideDependentAction()' id="dependent_action_radio">
                    {!! Form::radio('parent',0, ['class' => 'form-control separar_radio']) !!}                    
                    {!!  trans('admin::brand.form_add.isnot_principal')!!}
                </label>  
            </div>    
            <div class="radio" style="display: inline-block">
                <label onclick="hideDependentAction()">
                    {!! Form::radio('parent',-1, ['class' => 'form-control separar_radio']) !!}
                    {!!  trans('admin::action.general_permission')!!}
                </label>  
            </div>   
        </div>

    </div>    

</div>

<div class="row">
    <div class="col-md-12" id="dependent_action" style="display: none">
        {!! Form::label('dependet_action', trans('admin::action.action_dependent'), ['class' => 'control-label']) !!}               

        <select name="dependent_action" class="form-control" required id="dependent_action_select">
            <option></option>
            @foreach($actions as $action)
               @if(old('dependent_action',$action->id) ==$action->id)
              <option value="{{$action->id}}" selected>{!!$action->name!!}</option>
            @else
        <option value="{{$action->id}}">{!!$action->name!!}</option>
            @endif              
            @endforeach
        </select>

    </div>                  
</div>
<div>
    <h3>{{ trans('admin::language.lang_add_trans') }}</h3>
    <p class="text-danger" style="font-style: italic;">{{ trans('admin::action.mesagge_traslations') }}</p>
<!--    <ul class="nav nav-tabs">
        @foreach ($languages as $i => $lan)
        <li role="presentation" class="{{ $i==0 ? 'active' : ''}}" ><a data-toggle="tab" href="#menu{!! $lan->id!!}">{!! $lan->language_country !!}</a></li>
        @endforeach
    </ul>-->

    <div class="tab-content">
        @foreach ($languages as $i=> $lan)
        
                  <div role="panel-group" id="accordion-{{$lan->id}}">
            <div class="panel panel-default">
                <div role="tab" class="panel-heading">
                    <h4 class="panel-title">
                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion-{{$lan->id}}" href="#country-language-{{$lan['id'] }}">{{trans('admin::roles.modal_add.country-language-title') . $lan['language'] }}</a>
                    </h4>
                </div>
                <div role="tabpanel" data-parent="#accordion{{$lan->id}}" id="country-language-{{$lan->id}}"
                     class="panel-collapse {{($lan['id'] == Session::get('language') || $errors->has('role_data['.$lan->id.'][name]')) ? 'in' : 'collapse'}}" >
                    <div class="panel-body">
                        <h3>{!! $lan->language!!}</h3>
                        <div class="form-group">
                    <label class="control-label">{{ trans('admin::countries.add_name') }}</label>
                    <input   class="form-control" name="name_lang[]" value="" type="text">
                    <label class="control-label">{{ trans('admin::action.description') }}</label>
                    <input   class="form-control" name="description[]" value="" type="text">                 
                    <input  name="locale[]" type="hidden"  value="{{$lan->locale_key}}"> 
                    <input  type="hidden" name='language_id[]' value="{{$lan->id}}">
                    <span class="text-danger">{!!$msg!!}</span>
                </div>
                    </div>
                </div>
            </div>

        </div>
        

        @endforeach
    </div>
</div>

  @if($can_add)   
<button type="submit" class="btn btn-primary addButton"><i class="fa fa-plus"></i> &nbsp; {{ isset($countryEdit->id) ? trans('admin::countries.add_button') : trans('admin::countries.edit_button') }}</button>
@endif
{!! Form::close() !!}

@section('scripts')

<script type='text/javascript'>
    $(document).ready(function () {
        $('#multiselect_language_id').select2();
    });

    $("#dependent_action_radio").click(function () {
        $("#dependent_action").css("display", "block");
        $("#dependent_action_select").attr("required", 'required');

    });

    function hideDependentAction() {
        $("#dependent_action_select").removeAttr("required");
        $("#dependent_action").css("display", "none");
    }

</script>
@endsection


