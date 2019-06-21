<?php namespace Modules\CMS\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider;

class CoasterEventsProvider extends EventServiceProvider
{
    /**
     * The event listener mappings.
     *
     * @var array
     */
    protected $listen = [
        'Modules\Admin\Events\AuthRoute' => [
            'Modules\Admin\Listeners\AuthRouteCheck',
        ],
    ];
    
}
