
<h1>{!!trans('admin::template.new_template')!!}</h1>
<p class="text-right"><a href="{{ route('admin.template.list') }}">{{trans('admin::menu.return')}}</a></p>
{!! Form::open() !!}

<div class="row">
    <div class="col-md-12">
        {!! Form::label('template', trans('admin::template.add_template'), ['class' => 'control-label']) !!}               
        <div class="form-group {!! FormMessage::getErrorClass('template') !!}">
    
            <input id="template" type="text" class="form-control" name="template">
            <span class="help-block">{!! FormMessage::getErrorMessage('template') !!}</span>            

        </div>
    </div>                  
</div>
<div>
    <h3>{{ trans('admin::language.lang_add_trans') }}</h3>
    <p class="text-danger" style="font-style: italic;">{{ trans('admin::template.mesagge_traslations') }}</p>


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
                               <label class="control-label">{{ trans('admin::template.template') }}</label>
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

