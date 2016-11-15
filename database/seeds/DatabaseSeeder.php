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
            'name' => 'aravinda',
            'all_products_api' => '',
            'show_product_api' => '',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
    	DB::table('sellers')->insert([
            'name' => 'arun',
            'all_products_api' => '',
            'show_product_api' => '',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
    	DB::table('sellers')->insert([
            'name' => 'binoy',
            'all_products_api' => '',
            'show_product_api' => '',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
    	DB::table('sellers')->insert([
            'name' => 'sunil',
            'all_products_api' => '',
            'show_product_api' => '',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
    	DB::table('sellers')->insert([
            'name' => 'umang',
            'all_products_api' => '',
            'show_product_api' => '',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
    }
}
