@if (session()->exists('message-error-sw') && (is_array(session()->get('message-error-sw')) || is_object(session()->get('message-error-sw'))))
    <div id="error__box-resumeQuotation" class="error__box">
        <span class="error__single">
            <img src="{{ asset('themes/omnilife2018/images/icons/warning.svg') }}">@lang('shopping::shippingAddress.we_have_a_problem'):
        </span>
        <ul style="list-style: none; padding: 0px;">
            @foreach(session()->get('message-error-sw') as $err)
                <li>{{ $err }}</li>
            @endforeach
        </ul>
    </div>
@endif
@if (session()->exists('delete-items'))
    <div class="error__box theme__transparent" style="display: inline-block; font-size: 0.85em; padding: 10px; margin: 0 auto;width: 100%;text-align: center;border: 2px solid #fcb219;">
        <ul style="list-style: none; padding: 0px;">

            <li>{{ session()->get('delete-items') }}</li>

        </ul>
    </div>
@endif
