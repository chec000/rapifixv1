<?php

namespace Modules\CMS\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class CedisTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cedis                  = new \Modules\Admin\Entities\Cedis();
        $cedis->address         = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.';
        $cedis->country_id      = 1;
        $cedis->state_key       = '';
        $cedis->city_key        = '';
        $cedis->neighborhood    = 'Lorem ipsum';
        $cedis->postal_code     = 12345;
        $cedis->phone_number_01 = '1234567890';
        $cedis->phone_number_02 = '0987654321';
        $cedis->telemarketing   = '1234567890';
        $cedis->fax             = '1234567890';
        $cedis->email           = 'email@email.com';
        $cedis->latitude        = '20.671339';
        $cedis->longitude       = '-103.3887788';
        $cedis->image_01        = 'img1.jpg';
        $cedis->image_02        = 'img2.jpg';
        $cedis->image_03        = 'img3.jpg';
        $cedis->banner_link     = 'www.omnilife.com';
        $cedis->status          = 1;
        $cedis->delete          = 0;

        $cedis->translateOrNew('en')->name         = 'CEDIS EN';
        $cedis->translateOrNew('en')->description  = 'EN Lorem ipsum dolor sit amet, consectetur adipiscing elit.';
        $cedis->translateOrNew('en')->state_name   = 'EN STATE';
        $cedis->translateOrNew('en')->city_name    = 'EN CITY';
        $cedis->translateOrNew('en')->schedule     = 'MONDAY TO FRIDAY';
        $cedis->translateOrNew('en')->banner_image = 'banne1en.jpg';

        $cedis->translateOrNew('es')->name         = 'CEDIS ES';
        $cedis->translateOrNew('es')->description  = 'ES Lorem ipsum dolor sit amet, consectetur adipiscing elit.';
        $cedis->translateOrNew('es')->state_name   = 'SN STATE';
        $cedis->translateOrNew('es')->city_name    = 'ES CITY';
        $cedis->translateOrNew('es')->schedule     = 'LUNES A VIERNES';
        $cedis->translateOrNew('es')->banner_image = 'banne1es.jpg';
        $cedis->save();

    }
}
