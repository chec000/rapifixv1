{!! PageBuilder::section('head') !!}

    <!-- Main slider home markup-->
    {!! PageBuilder::block('main_slider', [
        'view' => PageBuilder::block('main_slider_view'),
        'gradient_theme' => PageBuilder::block('main_slider_gradient_theme')
    ]) !!}
    <!-- end Main slider home markup-->

    <!-- Content Body -->
    <div class="wrapper full-size-mobile business__main cases">
        <div class="business__main-title col3-4 cases__headline">
            <div class="business__main-inner">
                <h3 class="business__title">{{ PageBuilder::block('success_stories_title') }}</h3>
            </div>
        </div>
        @php
            $search = Request::get('search');
            $successStories = PageBuilder::block('success_stories', ['search' => $search]);
        @endphp
        @if (!empty($successStories))
            {!! $successStories !!}
            <div id="empty-stories" class="products-background">
                <h1 class="products-background-header">@lang('cms::get-inspired.no_stories')</h1>
            </div>  
        @else
            <div class="products-background">
                <h1 class="products-background-header">@lang('cms::get-inspired.no_stories')</h1>
            </div>
        @endif
        <div id="load-stories-container" class="col3-4 offset1-4 cases__load">
            <div class="business__main-inner">
                <a id="load-stories"class="cases__load-link" href="#" onclick="return false">
                    <svg class="icon" viewBox="0 0 768 768">
                        <path fill="#FFF" d="M237 250.5l147 147 147-147 45 45-192 192-192-192z"></path>
                    </svg>
                    <h3 class="business__title">{{ PageBuilder::block('success_stories_load_more') }}</h3>
                    <svg class="icon" viewBox="0 0 768 768">
                        <path fill="#FFF" d="M237 250.5l147 147 147-147 45 45-192 192-192-192z"></path>
                    </svg>
                </a>
            </div>
        </div>
        <div class="cases__filter">
            <div class="business__main--search">
                <div class="datefilter__group search__group"><span class="datefilter__label business-center"></span>
                    <input id="search-input" class="datefilter__search" type="search"
                        placeholder="{{ trans('cms::get-inspired.search') }}" value="{{ (!empty($search)) ? $search : '' }}">
                    <a href="#" id="search-btn" class="icon-btn icon-search" type="button">
                        {!! Pagebuilder::images('search-icon.svg') !!}
                    </a>
                </div>
            </div>
            <div class="tools__form-group">
                <span class="cases__filter-label">@lang('cms::get-inspired.filter'):</span>
                <div class="select select--stories">
                    <select id="stories-filter" class="form-control" name="category">
                        @foreach (config('cms.success_stories_filters') as $key => $value)
                            <option value="{{ $key }}">{{ trans($value) }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>
    <!-- Content Body -->

    <!-- bottom banner-->
    <div class="bottom-banner gradient cases__banner" style="background-image: url('{{ PageBuilder::block('registration_background_image', ['view' => 'raw']) }}');">
        <div class="wrapper bottom-banner__content">
            <h2 class="highlight">{{ PageBuilder::block('registration_title') }}</h2>
            <h2>{{ PageBuilder::block('registration_subtitle') }}</h2>
            <a {{ PageBuilder::block('registration_link') }}>
                {!! BlockFormatter::smallButton(PageBuilder::block('registration_button_text')) !!}
            </a>
        </div>
    </div>
    <!-- end bottom banner-->

{!! PageBuilder::section('footer') !!}

<script type="text/javascript">
    var CURRENT_ROUTE = '{{ url()->current() }}';
    var ACTIVE_FILTER = '0';
</script>
<script type="text/javascript" src="{{ PageBuilder::js('get_inspired') }}"></script>
