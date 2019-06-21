<?php

namespace Modules\Admin\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Foundation\Http\Kernel;
use Illuminate\Routing\Router;
use Modules\Admin\Http\Middleware\AdminAuth;
use Modules\Admin\Http\Middleware\GuestAuth;
use Modules\Admin\Http\Middleware\LanguageMiddleware;
use Modules\Admin\Http\Middleware\SecureUpload;
use Modules\Admin\Http\Middleware\UploadChecks;
use Modules\CMS\Events\LoadMiddleware;


class AdminServiceProvider extends ServiceProvider
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
    public function boot(Router $router, Kernel $kernel)
    {
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->registerFactories();
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');

        // add router middleware
        $globalMiddleware = [
            UploadChecks::class
        ];
        $routerMiddleware = [
            'admin.auth' => AdminAuth::class,
            'admin.guest' => GuestAuth::class,
            'admin.secure_upload' => SecureUpload::class,
            'admin.langLocale' => LanguageMiddleware::class,
        ];
        event(new LoadMiddleware($globalMiddleware, $routerMiddleware));
        foreach ($globalMiddleware as $globalMiddlewareClass) {
            $kernel->pushMiddleware($globalMiddlewareClass);
        }
        foreach ($routerMiddleware as $routerMiddlewareName => $routerMiddlewareClass) {
            $router->middlewareGroup($routerMiddlewareName, [$routerMiddlewareClass]);
        }
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->publishes([
            __DIR__.'/../Config/config.php' => config_path('admin.php'),
        ], 'config');
        $this->mergeConfigFrom(
            __DIR__.'/../Config/config.php', 'admin'
        );
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = resource_path('views/modules/admin');

        $sourcePath = __DIR__.'/../Resources/views';

        $this->publishes([
            $sourcePath => $viewPath
        ],'views');

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/admin';
        }, \Config::get('view.paths')), [$sourcePath]), 'admin');
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/modules/admin');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'admin');
        } else {
            $this->loadTranslationsFrom(__DIR__ .'/../Resources/lang', 'admin');
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
        return [];
    }
}
