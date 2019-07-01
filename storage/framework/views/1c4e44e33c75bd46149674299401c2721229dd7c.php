<div class="modal alert access" id="loginShopping">
    <button class="button secondary close modal-close" type="button" id="btnCloseLoginModal">X</button>

    <div class="modal__inner ps-container">
        <div class="modal__body">
            <div class="modal__login">
                <h3 class="modal__login--title"><?php echo app('translator')->getFromJson('shopping::login.modal.login.title'); ?></h3>

                <div class="modal__login--content">
                    <form id="formLoginShopping" name="formLoginShopping">
                        <div class="login--form">
                            <div id="error_ws_modal" class="error__box theme__transparent hidden" style="font-size: 10pt;">
                                <span class="error__single"><img src="<?php echo e(asset('themes/omnilife2018/images/warning.svg')); ?>"> <?php echo app('translator')->getFromJson('cms::reset_password.errors'); ?></span>
                                <ul id="error_ws_ul_modal">
                                </ul>
                            </div>

                            <input type="text" id="code_modal" name="code" placeholder="<?php echo app('translator')->getFromJson('shopping::login.modal.login.user'); ?>" class="form-control">

                            <div class="error-msg" id="div_code_modal"></div>

                            <input type="password" id="password_modal" name="password" placeholder="<?php echo app('translator')->getFromJson('shopping::login.modal.login.password'); ?>" class="form-control">

                            <div class="error-msg" id="div_password_modal"></div>

                            <input class="form-control transparent" type="hidden" name="url_previous" id="url_previous_modal" value="<?php echo e(session('url_previous')); ?>">
                            <input class="form-control transparent" type="hidden" name="country_corbiz" id="country_corbiz_modal" value="<?php echo e(Session::get('portal.main.country_corbiz')); ?>">
                            <input class="form-control transparent" type="hidden" name="language_corbiz" id="language_corbiz_modal" value="<?php echo e(Session::get('portal.main.language_corbiz')); ?>">

                            <button id="btnLoginShopping" class="button small" type="button"><?php echo app('translator')->getFromJson('shopping::login.modal.login.btn'); ?></button>
                            <a class="password__recovery" href="<?php echo e(route(\App\Helpers\TranslatableUrlPrefix::getRouteName(session()->get('portal.main.app_locale'), ['reset-password', 'index']))); ?>"><?php echo app('translator')->getFromJson('shopping::login.modal.login.reset_password'); ?></a>
                        </div>
                    </form>
                </div>
            </div>

            <div class="modal__register">
                <h3 class="modal__register--title"><?php echo app('translator')->getFromJson('shopping::login.modal.register.title'); ?></h3>

      
            </div>
        </div>
    </div>


</div>

<?php echo $__env->make('themes.omnilife2018.sections.loader', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<button id="btnShowModalLogin" href="#loginShopping" data-modal="true" style="display: none;"></button>