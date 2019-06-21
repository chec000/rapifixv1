
<h1>{!!trans('admin::action.add_action')!!}</h1>
<p class="text-right"><a href="{{ route('admin.action.list') }}">{{trans('admin::menu.return')}}</a></p>
{!! Form::open() !!}
<input type="hidden" name="id_action" value="{{$action->id}}">
<div class="row">
    <div class="col-md-6  {!! FormMessage::getErrorClass('action_alias')!!}">
        {!! Form::label('action_alias', trans('admin::action.action_name'), ['class' => 'control-label']) !!}           
        {!! Form::text('action_alias',$action->action,['class' => 'form-control','required'] ) !!}                                       
    </div>
    <div class="col-md-6 {!! FormMessage::getErrorClass('rol_section')!!}" >
       
        {!! Form::label('rol_section', trans('admin::action.select_controller'), ['class' => 'control-label']) !!}           
        <select name="controller" class="form-control" required="">
            <option></option>
            @foreach($controllers as $controller)
            
            <option   {{($action->controller_id==$controller->id)?'selected':''}}  value="{{$controller->id}}"  >{!!$controller->role_name!!}</option>
   
            @endforeach
        </select>

    </div>

    <div class="col-md-6  {!! FormMessage::getErrorClass('action_alias')!!}">
        {!! Form::label('action_others', trans('admin::action.action_others'), ['class' => 'control-label']) !!}
        {!! Form::text('action_others',$action->action_others,['class' => 'form-control'] ) !!}
    </div>

</div>

<div class="row">
    <div class="col-md-6">                    
        <div class="form-group ">   
            <div class="col-md-6">                    
                <div class="form-group ">   
                    <div class="checkbox">
                        {!!trans('admin::action.edited_based')!!}
                        <label> {!! Form::checkbox('edit_based',1,null) !!}                         
                            <input type="checkbox"   name="edit_based" value='1' {{($action->edit_based==1)?'checked':''}}>
                        </label>
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
                     <input type="radio" value="1" name='parent'  {{($action->inherit>0)?'checked':''}}>
                  
                    <!--{!! Form::radio('parent',true, [($action->inherit>0)?'checked':'','class' => 'form-control separar_radio','required']) !!}-->
                    {!!  trans('admin::brand.form_add.is_principal')!!} 

                </label> 
            </div>
<!--            {{$action}}-->
            <div class="radio" style="display: inline-block">
                <label onclick='hideDependentAction()' id="dependent_action_radio">
                    <input type="radio" value="0" name='parent'  {{($action->inherit==0)?'checked':''}}>
                    <!--{!! Form::radio('parent',0, [($action->inherit==0)?'checked':'','class' => 'form-control separar_radio']) !!}-->                    
                    {!!  trans('admin::brand.form_add.isnot_principal')!!}
                </label>  
            </div>    
            <div class="radio" style="display: inline-block">
                <label onclick="hideDependentAction()">
                    <input type="radio" name='parent'  value="-1" {{($action->inherit==-1)?'checked':''}}>
                    <!--{!! Form::radio('parent',-1, [($action->inherit==-1)?'checked':'', 'class' => 'form-control separar_radio']) !!}-->
                    {!!  trans('admin::action.general_permission')!!}
                </label>  
            </div>   
        </div>

    </div>    

</div>

<div class="row">
    <div class="col-md-12" id="dependent_action" style="display: {{($action->inherit>0)?'block':'none'}}">
        {!! Form::label('dependet_action', trans('admin::action.action_dependent'), ['class' => 'control-label']) !!}               

        <select name="dependent_action" class="form-control"  id="dependent_action_select">
            <option id="dependent_select"></option>
            @foreach($actions as $a)
            <option {{($action->inherit==$a->id)?'selected':''}} value="{{$a->id}}" >{!!$a->name!!}</option>
         
            @endforeach
        </select>
 
    </div>                  
</div>
<div>
    <h3>{{ trans('admin::language.lang_add_trans') }}</h3>
    <p class="text-danger" style="font-style: italic;">{{ trans('admin::menu.mesagge_traslations') }}</p>

    
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
                            <input   class="form-control" name="name_lang[]" value="{{$lan->item_name}}" type="text">
                            <label class="control-label">{{ trans('admin::action.description') }}</label>
                            <input   class="form-control" name="description[]" value="{{$lan->description}}" type="text">                 
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
<!-- submit button -->
@if($can_edit)
<button type="submit" class="btn btn-primary addButton"><i class="fa fa-plus"></i> &nbsp;{{trans('admin::countries.edit_button') }}</button>

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
       $("#dependent_select").prop("selected", "selected")
    }

</script>
@endsection


