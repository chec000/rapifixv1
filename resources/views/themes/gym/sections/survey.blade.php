<div class="survey--container" id="survey" style="display: none">
    <button class="icon-btn icon-cross close" type="button" onclick="hideSurvay()"></button>    
    {!! Form::open(array('id'=>'msform','class'=>"survey",'url' => 'saveSurvey','onsubmit'=>'check(event, this)'))!!}              
        <article>
            {{trans('cms::survey.portal.title')}}            
        </article>
        <!-- progressbar -->
        <ul id="progressbar" class="progressbar">
            @foreach ($questions as $key=> $question)
        
            @if($key==1)
            <li class="active"></li>
            @else
            <li></li>            
            @endif
            @endforeach
            <li></li>                            
        </ul>
        @foreach ($questions as $key1=> $question)
        <fieldset id="fieldset-{{$key1}}">
            <div class="{{$question['class']}}">
                <h3 class="fs-subtitle">{{$question['id']}}.- {{$question['question']}}:
                </h3>                    
                @foreach ($question['answers'] as $key => $a)

                @switch($question['type'])
                @case("role")
             <label style="height: 33px;">
                    <input type="radio" name="{{$question['type']}}" value="{{$key}}">                           
                    <p></p>
                    <span>{{$a}}</span>
                </label>            
                @break
                @case("redesign")
                <label style="">
                        <input type="radio" name="{{$question['type']}}" value="{{$key}}">                    
                    <p class="mood--{{$key}}"></p>
                    <span>{{$a}}</span>                                             
                </label>       
                 @break
                @case ("performance")
                <label>
                      <input type="radio" name="{{$question['type']}}" value="{{$key}}">                 
                    <p class="mood--{{$key}}"></p>                    
                    <span>{{$a}}</span>
                </label>
                
                @break
                @endswitch
             
                @endforeach             
                <input type="hidden" name="{{$question['type']}}_id" value="{{$question['id']}}">
                @if($question['comments']['apply'])
                <div class="redesign--question">
                    <h3 class="fs-subtitle">{{trans('cms::survey.portal.comment.question-'.$question['id'])}} </h3>
                        <input type="text" name="{{$question['type']}}_comment"  placeholder="">
            </div>
            @endif
              </div>   
                            @if($key1==0)
            <button id="next-{{$key1}}" type="button" name="next" class="next action-button"  onclick="nextQuestion(this)">
                                {{trans('cms::survey.portal.buttons.next')}} 
                </button>            
                @elseif($key1==(count($questions)-1))
              
                
                        <button  id="previous-{{$key1}}" onclick="previousFieldset(this)"  type="button" name="previous" class="previous action-button" >
                             {{trans('cms::survey.portal.buttons.previous')}} 
                        </button>
                        <button type="button" id="send-{{$key1}}" onclick="saveSurvey(this)" name="submit" class="submit action-button">
                              {{trans('cms::survey.portal.buttons.send')}} 
                        </button>
                        @else
                        <button  id="previous-{{$key1}}"  onclick="previousFieldset(this)" type="button" name="previous" class="previous action-button" >
                              {{trans('cms::survey.portal.buttons.previous')}}  
                        </button>
                        <button id="next-{{$key1}}" type="button" name="next" class="next action-button"  onclick="nextQuestion(this)">
                             {{trans('cms::survey.portal.buttons.next')}} 
                        </button>    
                        @endif
                        </fieldset>                
                        @endforeach                                                
                        <fieldset id="last-fielset" style="display:none">
                            <div class="redesign">
                                <article class="message--success">
                                    <img src="{{ asset('themes/omnilife2018/images/completed.png') }}" alt="">                                 
                                        {{trans('cms::survey.portal.message')}}      
                                </article>                                
                            </div>
                        </fieldset>
                      {!! Form::close() !!}    
                        </div>