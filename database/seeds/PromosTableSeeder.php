<?php

use Illuminate\Database\Seeder;

class PromosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $level = DB::table('levels')->where('name','Toko Besar')->first();
        DB::table('promos')->truncate();
        DB::table('promos')->insert([
            [
                'image' => 'promo-cashback.jpg',
                'title' => 'Hoky Cashback',
                'code' => 'Hoky Cashback',
                'value' => 100000,
                'type' => 'price',
                'expired_date' => date("Y-m-d H:i:s", strtotime("+100 day")),
                'target' => [
                    [
                        'target' => 'total price'
                    ]
                ],
                'content_html' => '',
                'levels' => [],
                'members' => [],
                'created_at' => date("Y-m-d H:i:s"),
				'updated_at' => date("Y-m-d H:i:s")
            ],
            [
                'image' => 'sale-promo.jpg',
                'title' => 'Hoky Sale',
                'code' => 'Hoky Sale',
                'value' => 10,
                'type' => 'percent',
                'expired_date' => date("Y-m-d H:i:s", strtotime("+100 day")),
                'target' => [
                    [
                        'target' => 'total price'
                    ]
                ],
                'content_html' => '',
                'levels' => [],
                'members' => [],
                'created_at' => date("Y-m-d H:i:s"),
				'updated_at' => date("Y-m-d H:i:s")
            ],
        ]);
    }
}
