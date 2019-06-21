<div class="modal alert h50x100a" id="exitModalRegister">
    <div class="modal__inner ps-container">
        <header class="modal__head">
            <h5 class="modal__title highlight">@lang('shopping::register_customer.modal_exit.title')</h5>
        </header>
        <div class="modal__body">
            <p>@lang('shopping::register_customer.modal_exit.body')</p>
            <input id="name_session" name="name_session" type="hidden" value="{{session('nameSession')}}">
            <input id="url_next_exit_register" name="url_next_exit_register" type="hidden" value="{{session('urlNextExitRegister')}}">
        </div>
        <footer class="modal__foot">
            <div class="buttons-container">
                <button id="btnCancelModalExitRegister" class="button secondary close" type="button">@lang('shopping::register_customer.modal_exit.btn.cancel')</button>
                <button id="btnAcceptModalExitRegister" class="button primary" type="button">@lang('shopping::register_customer.modal_exit.btn.accept')</button>
            </div>
        </footer>
    </div>
</div>

@include('themes.omnilife2018.sections.loader')