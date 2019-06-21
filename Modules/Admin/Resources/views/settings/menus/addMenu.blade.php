
<h1>{!!trans('admin::menu.new_menu')!!}</h1>
<p class="text-right"><a href="{{ route('admin.menuadmin.list') }}">{{trans('admin::menu.return')}}</a></p>
{!! Form::open() !!}

<div class="row">
    <!-- country key field -->
    <div class="col-md-6">
        <div class="form-group {!! FormMessage::getErrorClass('isPrincipal') !!}">
            {!! Form::label('isPrincipal',  trans('admin::menu.is_action'), ['class' => 'control-label']) !!}
            <div class="radio" style="display: inline-block">
                <label onclick=" displayAction()">
                    <input type="radio" name='isPrincipal' value="1"  checked>               
                             {!!  trans('admin::brand.form_add.is_principal')!!} 
                </label> 
            </div>
            <div class="radio" style="display: inline-block">
                <label onclick="hideAction()">
                   <input type="radio" name='isPrincipal' value="0" >               
            
                    {!!  trans('admin::brand.form_add.isnot_principal')!!} 
                </label>         
            </div>    
            <span class="help-block">{!! FormMessage::getErrorMessage('isPrincipal') !!}</span>
        </div>                
    </div>
    <div class="col-md-6">
        <div class="form-group {!! FormMessage::getErrorClass('action') !!}" id="div_action" >
            {!! Form::label('isPrincipal',  trans('admin::menu.select_action'), ['class' => 'control-label']) !!}
            <!--{!!Form::select('size', $actions, null, ['name' => 'action','placeholder' => 'Selecciona una acción','class' => 'form-control'])!!}-->                
            <select class='form-control' name="action">
                <option value="">{!!trans('admin::menu.select')!!}</option>             
                @foreach($actions as $a)                          
                <option  value="{{$a->id}}"   >{{$a->name}}</option>
                @endforeach
            </select>                  
</div>
        </div>  
          <span class="help-block">{!! FormMessage::getErrorMessage('action') !!}</span>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">   
            {!! Form::label('isPrincipal',  trans('admin::menu.parent_action'), ['class' => 'control-label']) !!}

            <div class="radio" style="display: inline-block">
                <label onclick="displayParent()">
                    <input type="radio" name="parent_r" value="1" checked>
                    <!--{!! Form::radio('parent',true, ['class' => 'form-control separar_radio','onclick'=>'displayParent()']) !!}-->
                    {!!  trans('admin::brand.form_add.is_principal')!!} 
                </label> 
            </div>
            <div class="radio" style="display: inline-block">
                <label onclick="hideParent()">
                  <input type="radio" name="parent_r" value="0">
<!-- {!! Form::radio('parent',false, ['class' => 'form-control separar_radio']) !!}-->
                    {!!  trans('admin::brand.form_add.isnot_principal')!!}
                </label>  
            </div>    
        </div>

    </div>    
    <div class="col-md-6">                    
        <div  class="form-group {!! FormMessage::getErrorClass('parent') !!}"  id="parent_div">
            {!! Form::label('isPrincipal',  trans('admin::menu.select_parent'), ['class' => 'control-label']) !!}
            <!--{!!Form::select('size', $actions, null, ['name' => 'action','placeholder' => 'Selecciona una acción','class' => 'form-control'])!!}-->                
            <select class='form-control' name="parent" id="parent_id" >
                <option value="">{!!trans('admin::menu.select')!!}</option>
                @foreach($parents as $a)
                <option value="{{$a->id}}"> {{ $a->item_name}} </option>
                @endforeach
            </select>           
        </div>  
                <span class="help-block">{!! FormMessage::getErrorMessage('parent') !!}</span>

    </div>
</div>
{!! Form::hidden('order', '',['id'=>'order']) !!}
<div class="row">
    <div class="col-md-12">
        {!! Form::label('parent_brand', trans('admin::menu.add_icon'), ['class' => 'control-label']) !!}               
        <div class="input-group {!! FormMessage::getErrorClass('icon') !!}">
            <span class="input-group-addon">fa fa-</span>
            <input id="icon" type="text" class="form-control" name="icon">
            <span class="help-block">{!! FormMessage::getErrorMessage('icon') !!}</span>            

        </div>
    </div>                  
</div>
<div>
    <h3>{{ trans('admin::language.lang_add_trans') }}</h3>
    <p class="text-danger" style="font-style: italic;">{{ trans('admin::menu.mesagge_traslations') }}</p>


    @foreach ($languages as $i=> $lan)
        <div role="panel-group" id="accordion-{{$lan['id'] }}">
            <div class="panel panel-default">
                <div role="tab" class="panel-heading">
                    <h4 class="panel-title">
                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion-{{$lan['id'] }}" href="#menu-language-{{$lan['id'] }}">{{trans('admin::language.country-language-title') . $lan['language'] }}</a>
                    </h4>
                </div>
                <div role="tabpanel" data-parent="#accordion-{{$lan['id'] }}" id="menu-language-{{$lan['id'] }}"
                     class="panel-collapse {{($lan['id'] == Session::get('language') ? 'in' : 'collapse')}}" >
                    <div class="panel-body">
                        <h3>{!! $lan->language!!}</h3>
                        <div class="form-group">
                            <!-- language name field -->
                            <div class="form-group">
                                <label class="control-label">{{ trans('admin::countries.add_name') }}</label>
                                <input   class="form-control" name="name_lang[]" value="" type="text">
                                <input  name="locale[]" type="hidden"  value="{{$lan->locale_key}}">
                                <input  type="hidden" name='language_id[]' value="{{$lan->id}}">
                                <span class="text-danger">{!!$msg!!}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
<!-- submit button -->
<button type="submit" class="btn btn-primary addButton"><i class="fa fa-plus"></i> &nbsp; {{ isset($countryEdit->id) ? trans('admin::countries.add_button') : trans('admin::countries.edit_button') }}</button>

{!! Form::close() !!}

@section('scripts')

<script type='text/javascript'>
    $(document).ready(function () {
        load_editor_js();
        $('#multiselect_language_id').select2();
    });
    function displayAction(){
            $("#div_action").css("display", "block");

}
function hideAction(){
        $("#div_action").css("display", "none");
        $("#no_selected_action").prop("selected", true);
}
function displayParent(){
            $("#parent_div").css("display", "block");

}
function hideParent(){
        $("#parent_div").css("display", "none");
                $("#no_selected_parent").prop("selected", true);

}
    $('#parent_id').on('change', function (e) {
        //  var optionSelected = $("option:selected", this);
        var valueSelected = this.value;
       
        var ruta=route('admin.menuadmin.order');
          $.ajax({
            url: ruta,
            type: 'POST',
            data: {menu_id: valueSelected},
            success: function (data) {
                if (data !== null) {
                    $('#order').val(data[0].order + 1);
                }
            }
        });
    });
</script>
@endsection


