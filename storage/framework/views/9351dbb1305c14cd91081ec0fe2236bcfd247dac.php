<section class="login">
    <div class="login__head">
        <?php if((Session::get('portal.eo.auth') == true)): ?>
        <p><?php echo app('translator')->getFromJson('cms::login_aside.section.head.logged'); ?>:</p>
        <?php else: ?>
        <p><?php echo app('translator')->getFromJson('cms::login_aside.section.head.login'); ?></p>
        <?php endif; ?>

        <button id="btnCloseLoginSection" class="icon-btn icon-cross close" type="button"></button>
    </div>

    <div class="login__content">
        <?php if((Session::get('portal.eo.auth') == true)): ?>
        <div class="login__profile">
            <div class="login__profile-avatar <?php if(!session()->get('portal.eo.shortTitleName')): ?> profile-no-content <?php endif; ?>"
                data-level="<?php echo e(Session::get('portal.eo.shortTitleName')); ?>" >
                <figure class="avatar medium">
                    <?php if(config('settings::frontend.distributorarea_active', 0) == 1 && session()->get('portal.da.distImage')): ?>
                        <img class="icon-btn icon-user-logged" src="<?php echo e(asset(session()->get('portal.da.distImage'))); ?>"
                            style="height: 100%;">
                    <?php else: ?>
                        <img class="icon-btn icon-user-logged" style="height: 100%;">
                    <?php endif; ?>
                </figure>
            </div>

            <p class="login__profile-name"><?php echo e(Session::get('portal.eo.name1')); ?></p>
            <?php if(config('settings::frontend.distributorarea_active') == 1): ?>
            <a href="#" class="button default"><?php echo app('translator')->getFromJson('cms::login_aside.section.content.profile.view'); ?></a>
            <p class="login__profile-points"><?php echo app('translator')->getFromJson('cms::login_aside.section.content.profile.points'); ?>: 000</p>
            <?php endif; ?>
        </div>
        <?php else: ?>
        <form id="formLoginSection" name="formLoginSection">
            <div id="error_ws_section" class="error__box theme__transparent hidden" style="font-size: 11pt; text-align: left;">
                <span class="error__single"><img src="<?php echo e(asset('themes/omnilife2018/images/warning.svg')); ?>"> <?php echo app('translator')->getFromJson('cms::reset_password.errors'); ?></span>
                <ul id="error_ws_ul_section">
                </ul>
            </div>

            <div class="form-group">
                <input class="form-control transparent" type="text" name="code" id="code" placeholder="<?php echo app('translator')->getFromJson('cms::login_aside.section.content.placeholder.code'); ?>">

                <div id="div_code" class="error-msg"></div>
            </div>

            <div class="form-group">
                <input class="form-control transparent" type="password" name="password" id="password" placeholder="<?php echo app('translator')->getFromJson('cms::login_aside.section.content.placeholder.password'); ?>">

                <div id="div_password" class="error-msg"></div>
            </div>

            <div class="form-group">
                <input class="form-control transparent" type="hidden" name="url_previous" id="url_previous" value="<?php echo e(session('url_previous')); ?>">
                <input class="form-control transparent" type="hidden" name="country_corbiz" id="country_corbiz" value="<?php echo e(Session::get('portal.main.country_corbiz')); ?>">
                <input class="form-control transparent" type="hidden" name="language_corbiz" id="language_corbiz" value="<?php echo e(Session::get('portal.main.language_corbiz')); ?>">
            </div>

            <button id="btnFormLoginSection" class="button default" type="button"><?php echo app('translator')->getFromJson('cms::login_aside.btn.login'); ?></button><a class="link" href="<?php echo e(route(\App\Helpers\TranslatableUrlPrefix::getRouteName(session()->get('portal.main.app_locale'), ['reset-password', 'index']))); ?>"><?php echo app('translator')->getFromJson('cms::login_aside.btn.reset'); ?></a>
        </form>
        <?php endif; ?>


    </div>
</section>