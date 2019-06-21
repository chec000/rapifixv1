@if ($is_first)
@endif
    <div class="c-33">
        <figure class="rewards--item">
            {!! PageBuilder::block('jobs_rewards_icon') !!}
            <figcaption>
                {{ PageBuilder::block('jobs_rewards_title') }}<br>
                {{ PageBuilder::block('jobs_rewards_description') }}<br>
                {{ PageBuilder::block('jobs_rewards_year') }}
            </figcaption>
        </figure>
    </div>
@if ($is_last)
@endif
