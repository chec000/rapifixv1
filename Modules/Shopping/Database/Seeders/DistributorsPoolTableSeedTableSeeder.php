<?php

namespace Modules\Shopping\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\Admin\Entities\DistributorsPool;

class DistributorsPoolTableSeedTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $distributorOne = new DistributorsPool();
        $distributorOne->country_id        = 1;
        $distributorOne->distributor_code  = '000515vcj';
        $distributorOne->distributor_name  = 'Jose Vergara';
        $distributorOne->distributor_email = 'jose.vergara@omnilife.com';
        $distributorOne->used              = 0;
        $distributorOne->last_modifier_id  = 1;

        $distributorTwo = new DistributorsPool();
        $distributorTwo->country_id        = 2;
        $distributorTwo->distributor_code  = '000525drs';
        $distributorTwo->distributor_name  = 'Juan López';
        $distributorTwo->distributor_email = 'juan.lopez@omnilife.com';
        $distributorTwo->used              = 0;
        $distributorTwo->last_modifier_id  = 1;

        $distributorThree = new DistributorsPool();
        $distributorThree->country_id        = 1;
        $distributorThree->distributor_code  = '000518vcj';
        $distributorThree->distributor_name  = 'Maria Juárez';
        $distributorThree->distributor_email = 'maria.juarez@omnilife.com';
        $distributorThree->used              = 0;
        $distributorThree->last_modifier_id  = 1;

        DB::transaction(function () use ($distributorOne, $distributorTwo, $distributorThree) {
            $distributorOne->save();
            $distributorTwo->save();
            $distributorThree->save();
        });
    }
}
