
        <h1>{!!trans('admin::control.add_controller')!!}</h1>
        <p class="text-right"><a href="{{ route('admin.controller.list') }}">{{trans('admin::menu.return')}}</a></p>
        {!! Form::open() !!}

        <div class="row">
            
            <div class="col-md-6  {!! FormMessage::getErrorClass('controller_alias') !!}" >
                 {!! Form::label('controller_alias',  trans('admin::control.control_name'), ['class' => 'control-label']) !!}           
               {!! Form::text('controller_alias', "", ['class' => 'form-control','required']) !!}      
                   <span class="help-block">{!! FormMessage::getErrorMessage('controller_alias') !!}</span>
            </div>
    <div class="col-md-6 {!! FormMessage::getErrorClass('rol_section') !!}">
                  {!! Form::label('rol_section',  trans('admin::control.rol_section'), ['class' => 'control-label']) !!}           
                  <select name="rol_section" class="form-control" required>
                    <option></option>
                    @foreach($sections as $section)
                    <option value="{{$section['id']}}">{!!$section['section']!!}</option>
                     @endforeach
                </select>
    <span class="help-block">{!! FormMessage::getErrorMessage('rol_section') !!}</span>
         </div>
        </div>        
        <div class="row">
                        <div class="col-md-12">
             <div>
            <h3>{{ trans('admin::language.lang_add_trans') }}</h3>
            <p class="text-danger" style="font-style: italic;">{{ trans('admin::control.traslates') }}</p>

             @foreach ($languages as $i=> $lan)
                 <div role="panel-group" id="accordion-{{$lan['id'] }}">
                     <div class="panel panel-default">
                         <div role="tab" class="panel-heading">
                             <h4 class="panel-title">
                                 <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion-{{$lan['id'] }}" href="#control-language-{{$lan['id'] }}">{{trans('admin::language.country-language-title') . $lan['language'] }}</a>
                             </h4>
                         </div>
                         <div role="tabpanel" data-parent="#accordion-{{$lan['id'] }}" id="control-language-{{$lan['id'] }}"
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
                                         <span class="text-danger">{{$msg}}</span>
                                     </div>
                                 </div>
                             </div>
                         </div>
                     </div>
                 </div>
             @endforeach

        </div>
            </div>
        </div>
        <!-- submit button -->
        <button type="submit" class="btn btn-primary addButton"><i class="fa fa-plus"></i> &nbsp; {{ isset($countryEdit->id) ? trans('admin::countries.add_button') : trans('admin::countries.edit_button') }}</button>

        {!! Form::close() !!}

        @section('scripts')

        <script type='text/javascript'>
            $(document).ready(function () {
              
                $('#multiselect_language_id').select2();
            });
        </script>
        @endsection
 

