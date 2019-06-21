        </div>
 <div id="panel-survey">    
 </div>
    {!! Form::open(array('id'=>'exist_survey','url' => 'getActiveSurvey'))!!}      
    {!! Form::close() !!}
     {!! Form::open(array('id'=>'list_cuestions','url' => 'getCuestionsSurvey'))!!}   
     <input type="hidden" name="type" id="type">
    {!! Form::close() !!}
        <footer class="main-f">
            <div class="wrapper">
                <div class="main-f__row">
                    <nav class="main-f__nav">
                        <ul class="main-f__list list-nostyle">
                            <li class="main-f__item logo">
                                <a class="logo" {!! PageBuilder::block('footer_logo_link') !!}>
                                    <figure class="icon-omnilife2">
                                        {!! PageBuilder::block('logo_footer') !!}
                                    </figure>
                                </a>
                            </li>
                            {!! PageBuilder::menu('footer',['view' =>'footer']) !!}

                            <li class="main-f__item"><a href="{{route('cedis.index')}}">@lang('cms::footer.cedis')</a></li>
                        </ul>
                    </nav>
                    {!! PageBuilder::block('social') !!}
                </div>
                <div class="main-f__row bottom">
                    <ul class="main-f__list list-nostyle">
                        {!! PageBuilder::block('footer_repeater_links') !!}
                        <li class="main-f__item">{{ PageBuilder::block('copyright', ['version' => 29]) }}</li>
                        <li class="main-f__item">{!! PageBuilder::block('footer_html', ['source' => true]) !!}</li>
                    </ul>

                    <p class="address">{{ PageBuilder::block('address_footer') }}</p>
                </div>
            </div>
        </footer>
        @include('shopping::partial_views.login')
        <script type="text/javascript">
            var _GLOBAL_SEARCH_URL = '{{ url('/web_api/global_search') }}';
            var _MUTE_CONTROL_ICON = '{{ asset('/themes/omnilife2018/images/icons/icon-mute.svg') }}';
            var _CSRF_TOKEN = '{{ csrf_token() }}';
            var URL_PROJECT = "{{ url('/') }}";
            var HIDE_PRICE = '{{ hide_price() }}';

            var isMobile = window.matchMedia("only screen and (max-width: 768px)");
            var _IS_MOBILE = false;
            if (isMobile.matches) {
                var _IS_MOBILE = true;
            }
        </script>
        <!-- Core JavaScript
            ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
        <script src="{{ PageBuilder::js('jquery.min') }}"></script>
        <script type="text/javascript">
            if (_IS_MOBILE) {
                $('.youtube-slide').remove();
            }
            var _YOUTUBE_PATCH = false;
        </script>
        <script src="{{ PageBuilder::js('bootstrap.min') }}"></script>
        <script src="{{ PageBuilder::js('app').'?version=01082018_1' }}"></script>
        <script src="{{ PageBuilder::js('index') }}"></script>
        <script src="{{ PageBuilder::js('main').'?version=01082018_1' }}"></script>
        <script src="{{ PageBuilder::js('latinize.min').'?version=30072018_1' }}"></script>
        <script src="{{ PageBuilder::js('search').'?version=30072018_1' }}"></script>
      <script src="{{ PageBuilder::js('jquery-ui.min') }}"></script>
      <script src="{{ PageBuilder::js('jquery.easing.min') }}"></script>
        <script src="{{ asset('/cms/jquery/fancybox/jquery.fancybox.pack.js') }}"></script>
        <script>
            $('.dropdown-item_change_country').click(function () {
                var currentCountryId = $(this).find('a.change_country_header').data('countryidcurrent');
                var newCountryId = $(this).find('a.change_country_header').data('countryid');

                if(currentCountryId != newCountryId) {
                    $(".loader").addClass("show");
                    change_country_language(newCountryId, 'country');
                }
            });

            $('.dropdown-item_change_lang').click(function () {
                var currentLangId = $(this).find('a.change_language_header').data('langidcurrent');
                var newLangId = $(this).find('a.change_language_header').data('langid');

                if(currentLangId != newLangId) {
                    $(".loader").addClass("show");
                    change_country_language(newLangId, 'language');
                }
            });

            function change_country_language(idData, typeChange) {
                hideCookiesDocument(0).done(function(data) {
                    var url = window.location.pathname;
                    var pageId = '{{ Pagebuilder::page_id() }}';
                    var templateId = '{{ Pagebuilder::page_template_id() }}';
                    $.ajax({
                        url: URL_PROJECT+'/changeCountryLang',
                        type: 'POST',
                        dataType: 'json',
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        data: {typeChange: typeChange, idData: idData, url: url, pageId: pageId, templateId: templateId},
                        success: function (data) {
                            if(data.code !== 500) {
                                var url = data.url.toString().trim();
                                var firstChartUrl = url.substring(0,1);
                                if(firstChartUrl !== "/") {
                                    url = "/"+url;
                                }
                                location.href = URL_PROJECT + url;
                                $(".loader").removeClass("show");
                            }
                        },
                        error: function (data) {
                            $(".loader").removeClass("show");
                            console.log(data);
                        }
                    });
                });

                hideCookiesDocument(0).fail(function() {
                    var url = window.location.pathname;
                    var pageId = '{{ Pagebuilder::page_id() }}';
                    var templateId = '{{ Pagebuilder::page_template_id() }}';
                    $.ajax({
                        url: URL_PROJECT+'/changeCountryLang',
                        type: 'POST',
                        dataType: 'json',
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        data: {typeChange: typeChange, idData: idData, url: url, pageId: pageId, templateId: templateId},
                        success: function (data) {
                            if(data.code !== 500) {
                                location.href = data.url;
                            }
                        },
                        error: function (data) {
                            console.log(data);
                        }
                    });
                });
            };
        </script>
        <script type="text/javascript" src="{{ asset('js/login/global.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/functionsPortal.js') }}"></script>
        @if(session('sectionLogin'))
            <script>
                $(document).ready(function () {
                    $('.icon-user').click();
                });
            </script>
        @endif
        @if(session('modalLogin'))
            <script>
                $(document).ready(function () {
                    $('#btnShowModalLogin').click();
                });
            </script>
        @endif
        @if(session('modalExit'))
            <script>
                $(document).ready(function () {
                    $('#btnExitModalRegister').click();
                });
            </script>
        @endif
        @if (!\App\Helpers\SessionHdl::isShoppingActive())
            <script>                
                $('div.cart-preview.aside').removeClass('active'); $('div.overlay').hide();
            </script>
        @endif
        @if (isset($paymentjs) && $paymentjs)
            @include('shopping::frontend.shopping.includes.paymentjs')
        @endif
        <script src="https://www.youtube.com/iframe_api"></script>
        <script type="text/javascript" src="{{ PageBuilder::js('youtube') }}"></script>
    </body>
