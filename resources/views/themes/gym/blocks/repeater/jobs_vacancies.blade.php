@if ($is_first)
@endif
    <div class="c-33">
        <figure class="vacant--item {{ PageBuilder::block('jobs_vacancies_theme') }}">
            {!! PageBuilder::block('jobs_vacancies_icon') !!}
            <figcaption>
                <div class="vacant--title">
                    {{ PageBuilder::block('jobs_vacancies_title') }}
                </div>
                <div class="vacant--description">
                    {!! PageBuilder::block('jobs_vacancies_list') !!}
                    {!! PageBuilder::images('icons/icon-arrow.png') !!}
                </div>
            </figcaption>
        </figure>
    </div>
@if ($is_last)
@endif
