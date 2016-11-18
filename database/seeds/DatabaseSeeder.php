<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::table('sellers')->insert([
            'owner' => 'aravinda',
            'name' => 'AirWind',
            'all_products_api' => '',
            'show_product_api' => '',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
    	DB::table('sellers')->insert([
            'owner' => 'arun',
            'name' => 'Juranet',
            'all_products_api' => '',
            'show_product_api' => '',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
    	DB::table('sellers')->insert([
            'owner' => 'binoy',
            'name' => 'Fabposters',
            'all_products_api' => 'http://fabposters.slashbin.in/api/products',
            'show_product_api' => 'http://fabposters.slashbin.in/api/products/%product_id%',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
    	DB::table('sellers')->insert([
            'owner' => 'sunil',
            'name' => 'Gargoos',
            'all_products_api' => '',
            'show_product_api' => '',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
    	DB::table('sellers')->insert([
            'owner' => 'umang',
            'name' => 'GeekBabu',
            'all_products_api' => '',
            'show_product_api' => '',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
    }
}
