<?php namespace Modules\CMS\Helpers\Croppa;

use \Illuminate\Support\Facades\Facade;

class CroppaFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'Modules\CMS\Helpers\Croppa\Croppa';
    }
}
