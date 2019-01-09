<?php

use Illuminate\Database\Seeder;

class SlidersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sliders')->truncate();
        DB::table('sliders')->insert([
            [
                'title' => 'Promo Ramadhan',
                'image' => 'ramadhan.jpg',
                'redirect' => 'off',
                'url' => 'http://103.82.241.18/',
                'created_at' => date("Y-m-d H:i:s"),
				'updated_at' => date("Y-m-d H:i:s")
            ],
            [
                'title' => 'Promo Cashback',
                'image' => 'cashback.png',
                'redirect' => 'off',
                'url' => null,
                'created_at' => date("Y-m-d H:i:s"),
				'updated_at' => date("Y-m-d H:i:s")
            ],
            [
                'title' => 'Promo Merchant',
                'image' => 'merchant.jpg',
                'redirect' => 'off',
                'url' => null,
                'created_at' => date("Y-m-d H:i:s"),
				'updated_at' => date("Y-m-d H:i:s")
            ]
        ]);
    }
}
