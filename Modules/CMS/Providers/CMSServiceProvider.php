<?php

namespace Modules\CMS\Providers;

use App;
use Auth;
use Modules\CMS\Events\LoadAuth;
use Modules\CMS\Events\SetViewPaths;
use Modules\CMS\Libraries\Builder\FormMessage\FormMessageInstance;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Foundation\AliasLoader;
use Modules\CMS\Events\LoadedConfig;
use Modules\Admin\Entities\ACL\User;
use Illuminate\Routing\Router;
use Modules\CMS\Http\Middleware\VerifyDomain;
use Modules\CMS\Http\Middleware\BrandMiddleware;
use Modules\Admin\Entities\Setting;

class CMSServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot(Router $router)
    {
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->registerFactories();
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');

        Setting::loadAll(null, 'settings', true);

        $overrideConfigValues = [
            'auth.guards.web.driver' => 'coaster',
            'auth.providers.users.model' => User::class,
            'croppa.src_dir' => public_path(),
            'croppa.crops_dir' => public_path() . '/cache',
            'croppa.path' => 'cache/(' . config('settings::frontend.croppa_handle') . ')$'
        ];

        event(new LoadedConfig($overrideConfigValues));

        foreach ($overrideConfigValues as $attribute => $value) {
            app()->config->set($attribute, $value);
        }

        //Add middleware to CMS
        $routerMiddleware = [
            'cms.brand_middleware' => BrandMiddleware::class,
        ];

        foreach ($routerMiddleware as $routerMiddlewareName => $routerMiddlewareClass) {
            $router->middlewareGroup($routerMiddlewareName, [$routerMiddlewareClass]);
        }

        // use coater guard and user provider
        $authGuard = \Modules\CMS\Helpers\CoasterGuard::class;
        $authUserProvider = \Modules\CMS\Providers\CoasterAuthUserProvider::class;
        event(new LoadAuth($authGuard, $authUserProvider));
        if ($authGuard && $authUserProvider) {
            Auth::extend('coaster', function ($app) use ($authGuard, $authUserProvider) {
                $guard = new $authGuard(
                    'coasterguard',
                    new $authUserProvider($app['hash'], config('auth.providers.users.model')),
                    $app['session.store'],
                    $app['request']
                );


                // set cookie jar for cookies
                if (method_exists($guard, 'setCookieJar')) {
                    $guard->setCookieJar($this->app['cookie']);
                }
                if (method_exists($guard, 'setDispatcher')) {
                    $guard->setDispatcher($this->app['events']);
                }
                if (method_exists($guard, 'setRequest')) {
                    $guard->setRequest($this->app->refresh('request', $guard, 'setRequest'));
                }

                return $guard;
            });
        }

        $this->app->singleton('formMessage', function () {
            return new FormMessageInstance($this->app['request'], 'default', config('cms.frontend.form_error_class'));
        });
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->app->register('Modules\CMS\Providers\CoasterEventsProvider');
        //$this->app->register('Modules\CMS\Providers\CoasterConfigProvider');
        $this->app->register('Modules\CMS\Providers\CoasterConsoleProvider');
        $this->app->register('Modules\CMS\Providers\CoasterPageBuilderProvider');

        // register third party providers
        $this->app->register('Bkwld\Croppa\ServiceProvider');
        $this->app->register('Collective\Html\HtmlServiceProvider');

        // register aliases
        $loader = AliasLoader::getInstance();
        $loader->alias('Form', 'Collective\Html\FormFacade');
        $loader->alias('HTML', 'Collective\Html\HtmlFacade');
        $loader->alias('Croppa', 'Modules\CMS\Helpers\Croppa\CroppaFacade');
        $loader->alias('CmsBlockInput', 'Modules\CMS\Helpers\View\CmsBlockInput');
        $loader->alias('FormMessage', 'Modules\CMS\Libraries\Builder\FormMessageFacade');
        $loader->alias('AssetBuilder', 'Modules\CMS\Libraries\Builder\AssetBuilder');
        $loader->alias('DateTimeHelper', 'Modules\CMS\Helpers\DateTimeHelper');
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->publishes([
            __DIR__.'/../Config/config.php' => config_path('cms.php'),
        ], 'config');
        $this->mergeConfigFrom(
            __DIR__.'/../Config/config.php', 'cms'
        );
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = resource_path('views/modules/cms');

        $sourcePath = __DIR__.'/../Resources/views';

        $this->publishes([
            $sourcePath => $viewPath
        ],'views');

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/cms';
        }, \Config::get('view.paths')), [$sourcePath]), 'cms');
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/modules/cms');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'cms');
        } else {
            $this->loadTranslationsFrom(__DIR__ .'/../Resources/lang', 'cms');
        }
    }

    /**
     * Register an additional directory of factories.
     * @source https://github.com/sebastiaanluca/laravel-resource-flow/blob/develop/src/Modules/ModuleServiceProvider.php#L66
     */
    public function registerFactories()
    {
        if (! app()->environment('production')) {
            app(Factory::class)->load(__DIR__ . '/../Database/factories');
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            //'Modules\CMS\Providers\CoasterConfigProvider',
            'Modules\CMS\Providers\CoasterEventsProvider',
            'Modules\CMS\Providers\CoasterConsoleProvider',
            'Modules\CMS\Providers\CoasterPageBuilderProvider',
            'Bkwld\Croppa\ServiceProvider',
            'Collective\Html\HtmlServiceProvider'
        ];
    }
}
