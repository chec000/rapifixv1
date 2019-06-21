{!! PageBuilder::section('head') !!}

    <!-- Main slider home markup-->
    {!! PageBuilder::block('main_slider', [
        'view' => PageBuilder::block('main_slider_view'),
        'gradient_theme' => PageBuilder::block('main_slider_gradient_theme')
    ]) !!}
    <!-- end Main slider home markup-->

    <!-- Main content markup-->
    <div class="wrapper full-size-mobile business__main">

        <!-- Title markup-->
        <div class="business__main-title col3-4">
            <div class="business__main-inner">
                <h3 class="products-maintitle">
                    {{ PageBuilder::block('jobs_title') }}
                    <span>{{ PageBuilder::block('jobs_title_highligth') }}</span>
                </h3>
            </div>
        </div>
        <!-- end Title markup-->

        <!-- Jobs markup-->
        <div class="jobs--container">
            <div class="jobs--description">
                {!! PageBuilder::block('jobs_description') !!}
                {!! PageBuilder::block('jobs_thumbnails') !!}

                <!-- Jobs Vision markup-->
                <div class="jobs--vision">
                    <div class="c-50">
                        <h2 class="jobs--vision__title">
                            {{ PageBuilder::block('jobs_vision_title') }}
                            <br>
                            <span>{{ PageBuilder::block('jobs_vision_brand') }}</span>
                        </h2>
                    </div>
                    <div class="c-50">
                        <div class="jobs--vision__description">
                            {!! PageBuilder::block('jobs_vision_description') !!}
                        </div>
                    </div>
                </div>
                <!-- end Jobs Vision markup-->

                <!-- Vacancies markup-->
                <div class="jobs--vacancies flexbox">
                    {!! PageBuilder::block('jobs_vacancies') !!}
                    <div class="c-100 text-center">
                        <h3 class="vacancies--message">
                            {{ PageBuilder::block('jobs_vacancies_message') }}
                        </h3>
                        <div class="vacancies--mail">
                            <a href="mailto:{{ PageBuilder::block('jobs_vacancies_email') }}">
                                {{ PageBuilder::block('jobs_vacancies_email') }}
                            </a>
                        </div>
                    </div>
                </div>
                <!-- end Vacancies markup-->

                <!-- Rewards markup-->
                <div class="jobs--rewards flexbox">
                    <h2 class="rewards--title">{{ PageBuilder::block('jobs_rewards_message') }}</h2>
                    {!! PageBuilder::block('jobs_rewards') !!}
                </div>
                <!-- end Rewards markup-->

            </div>
        </div>
        <!-- end Jobs markup-->

    </div>
    <!-- end Main content markup-->

{!! PageBuilder::section('footer') !!}
