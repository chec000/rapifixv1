@if ($is_first)

@endif
        <h3 class="faq--subtitle">
            {!! PageBuilder::block('ambassador_faq_objectives_question') !!}
        </h3>
        {!! PageBuilder::block('ambassador_faq_objectives_answer') !!}

@if ($is_last)

@endif
