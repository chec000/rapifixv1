<!-- starts header-->
<header class="main-h">
    <div class="wrapper">
        <div class="logo main-h__logo">
            <a class="logo" <?php echo e(PageBuilder::block('header_logo_link')); ?>>
                <figure class="icon-omnilife">
                <?php echo PageBuilder::block('logo'); ?>

                </figure>
            </a>
        </div>
        <nav class="main-nav">
            <div class="main-nav__head mov">
                <?php if(Session::get('portal.eo.auth') == true): ?>
                    <figure class="avatar small">
                        <img class="icon-btn icon-user-logged-header" style="height: 100%;">
                    </figure>
                    <div class="main-nav__user">
                        <div class="main-nav__name">
                            <?php echo e(Session::get('portal.eo.shortTitleName')); ?>

                        </div>
                        <div class="main-nav__level">
                            <span>Nivel bronce</span>
                            <span class="sep">|</span>
                            <span class="points">3,000 pts</span>
                        </div>
                    </div>
                <?php else: ?>
                    <?php if(config('settings::frontend.webservices') == 1): ?>
                        <?php if((session()->get('portal.eo.auth') == true)): ?>
                            <button class="icon-btn icon-user-logged-header" id="iuser-mobile"></button>
                        <?php else: ?>
                            <button class="icon-btn icon-user" id="iuser-mobile"></button>
                        <?php endif; ?>
                    <a class="main-nav__link" id="login-btn-mov" href="#"><?php echo app('translator')->getFromJson('cms::header.log_in'); ?></a>
                    <a class="main-nav__link bold" href="#"><?php echo app('translator')->getFromJson('cms::header.sign_in'); ?></a>
                    <?php endif; ?>
                <?php endif; ?>
                <button class="icon-btn icon-cross close"></button>
            </div>
            <div class="main-nav__body">
                <input type="hidden" name="country_current_selected" value="<?php echo e(session()->get('portal.main.country_id')); ?>" id="country_current_selected">
                <ul class="nav-list top list-nostyle">
                    <?php if(!empty(session()->get('portal.main.varsMenu.otherBrands'))): ?>
                        <?php $__currentLoopData = session()->get('portal.main.varsMenu.otherBrands'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $brandMenu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li class="nav-item nav-item_hover_<?php echo e(config('cms.brand_css.'.$brandMenu->id)); ?>"><a data-brandId="<?php echo e($brandMenu->id); ?>" href="<?php echo e($brandMenu->domain); ?>"><?php echo e($brandMenu->name); ?></a></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>

                    <?php if(session()->get('portal.main.brand.parent_brand_id') != 0 && !empty(session()->get('portal.main.varsMenu.parentBrands'))): ?>
                        <?php if(is_object(session()->get('portal.main.varsMenu.parentBrands')) && count(session()->get('portal.main.varsMenu.parentBrands')) > 1): ?>
                            <li class="nav-item"><a href="#"><?php echo app('translator')->getFromJson('cms::header.products'); ?></a>
                                <ul class="nav-item__list list-nostyle">
                                    <?php $__currentLoopData = session()->get('portal.main.varsMenu.parentBrands'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $parentBrand): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li class="nav-item__item">
                                            <a data-brandId="<?php echo e($parentBrand->id); ?>" href="<?php echo e($parentBrand->domain); ?>/<?php echo e(\App\Helpers\TranslatableUrlPrefix::getTranslatablePrefixByIndexAndLang('products', session()->get('portal.main.app_locale'))); ?>"><?php echo e($parentBrand->alias); ?></a>
                                        </li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            </li>
                        <?php else: ?>
                                <li class="nav-item"><a href="<?php echo e(session()->get('portal.main.varsMenu.parentBrands.0.domain')); ?>/<?php echo e(\App\Helpers\TranslatableUrlPrefix::getTranslatablePrefixByIndexAndLang('products', session()->get('portal.main.app_locale'))); ?>"> <?php echo app('translator')->getFromJson('cms::header.products'); ?></a></li>
                        <?php endif; ?>
                    <?php else: ?>
                    <!--<li class="nav-item"><a href="<?php echo e(route(\App\Helpers\TranslatableUrlPrefix::getRouteName(session()->get('portal.main.app_locale'), ['products', 'index']))); ?>"> <?php echo app('translator')->getFromJson('cms::header.products'); ?></a></li>-->
                    <?php endif; ?>
                    <?php echo PageBuilder::menu('main_menu',['view' =>'main_menu']); ?>

                </ul>
                <ul class="nav-list list-nostyle">
                    <li class="nav-item dropdown"><span class="dropdown-toggle"><?php echo app('translator')->getFromJson('cms::header.country'); ?>:
                            <figure class="flag"><img src="<?php echo e(asset(session()->get('portal.main.flag'))); ?>" alt=""></figure><?php echo e(session()->get('portal.main.country_name')); ?></span>
                        <ul class="dropdown-list list-nostyle">
                            <?php if(!empty(session()->get('portal.main.brand.countries'))): ?>
                                <?php $__currentLoopData = session()->get('portal.main.brand.countries'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $countryMenu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li class="dropdown-item dropdown-item_change_country">
                                        <a class="change_country_header" data-countryid="<?php echo e($countryMenu->id); ?>"
                                           data-countryidcurrent="<?php echo e(session()->get('portal.main.country_id')); ?>">
                                            <figure class="flag">
                                                <img src="<?php echo e(asset($countryMenu->flag)); ?>" alt="<?php echo e($countryMenu->name); ?>">
                                            </figure><?php echo e($countryMenu->name); ?>

                                        </a>
                                    </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                        </ul>
                    </li>
                    <?php if(!empty(session()->get('portal.main.varsMenu.countryLangs')) && count(session()->get('portal.main.varsMenu.countryLangs')) > 1): ?>
                    <li class="nav-item dropdown"> <span class="dropdown-toggle"><?php echo app('translator')->getFromJson('cms::header.language'); ?>: <?php echo e(session()->get('portal.main.language_name')); ?></span>

                        <ul class="dropdown-list list-nostyle">
                            <?php $__currentLoopData = session()->get('portal.main.varsMenu.countryLangs'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $langMenu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li class="dropdown-item dropdown-item_change_lang"><a class="change_language_header" data-langid="<?php echo e($index); ?>"
                                     data-langidcurrent="<?php echo e(session()->get('portal.main.language_id')); ?>" type="button"><?php echo e($langMenu); ?></a></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </li>
                    <?php endif; ?>
                    <?php if(config('settings::frontend.webservices') == 1 && session()->get('portal.main.inscription_active') == 1 && !session()->has('portal.eo')): ?>
                    <li class="nav-item desk bold">
                        <a href="<?php echo e(route('register')); ?>"><?php echo app('translator')->getFromJson('cms::header.register'); ?></a>
                    </li>
                    <?php endif; ?>
                    <?php if(config('settings::frontend.webservices') == 1 && !session()->has('portal.eo')): ?>
                        <li class="nav-item desk bold "><a href="#" id="login-btn"><?php echo app('translator')->getFromJson('cms::header.sign_in'); ?></a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </nav>
        <ul class="main-h__icons list-nostyle">
            <li class="main-h__icon">
                <button class="icon-btn icon-search" id="isearch"></button>
            </li>
            <?php if(\App\Helpers\SessionHdl::isShoppingActive()): ?>
                <li class="nav-item main-h__icon">
                    <button class="icon-btn icon-cart" id="icart"></button>
                    <span style="display: none;" class="notification">0</span>
                </li>

            <?php else: ?>
                <li class="main-h__n-icon">
                    <a target="_blank" href="https://www.omnilife.com/shopping/login.php?fidioma=<?php echo e(strtolower(\App\Helpers\SessionHdl::getCorbizLanguage())); ?>"><button class="icon-btn icon-cart"></button></a>
                </li>
            <?php endif; ?>
            <?php if(config('settings::frontend.webservices') == 1): ?>
                <li class="main-h__icon">
                    <?php if(session()->get('portal.eo.auth') == true): ?>
                        <button class="icon-btn icon-user-logged-header" id="iuser"></button>
                    <?php else: ?>
                        <button class="icon-btn icon-user" id="iuser"></button>
                    <?php endif; ?>
                </li>
            <?php endif; ?>
            <li class="main-h__icon mov">
                <button class="icon-btn" id="imenu">
                    <figure class="icon-menu"><img src="<?php echo e(asset('themes/omnilife2018/images/icons/menu-red.svg')); ?>" alt="OMNILIFE - menu">
                    </figure>
                </button>
            </li>
        </ul>
    </div>
</header>
<!-- ends header-->
