<?php namespace Modules\CMS\Providers;

use Modules\CMS\Helpers\Page\PageLoader;
use Modules\CMS\Libraries\Builder\PageBuilder\DefaultInstance;
use Modules\CMS\Libraries\Builder\PageBuilderFactory;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use View;

class CoasterPageBuilderProvider extends ServiceProvider
{

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->singleton('pageBuilder', function () {
            $pb = new PageBuilderFactory(DefaultInstance::class, [new PageLoader]);
            View::share('pb', $pb);
            return $pb;
        });
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        // register aliases
        $loader = AliasLoader::getInstance();
        $loader->alias('PageBuilder', 'Modules\CMS\Libraries\Builder\PageBuilderFacade');
    }

}
