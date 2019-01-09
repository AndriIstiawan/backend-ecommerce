<?php

use Illuminate\Database\Seeder;

class DiscountsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('discounts')->truncate();
        DB::table('discounts')->insert([
            [
                'key_id' => 'discount-percentage',
                'title' => 'Discount Percentage',
                'description' => 'Discount Percentage',
                'status' => 'off',
                'value' => 20,
                'type' => 'percent',
                'expired_date' => '2019-07-31 00:00:00',
                'brands' => [],
                'categories' => [],
                'products' => [],
                'levels' => [],
                'members' => [],
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [
                'key_id' => 'discount-cut-price',
                'title' => 'Discount cut price',
                'description' => 'Discount cut price',
                'status' => 'off',
                'value' => 100000,
                'type' => 'price',
                'expired_date' => '2019-07-31 00:00:00',
                'brands' => [],
                'categories' => [],
                'products' => [],
                'levels' => [],
                'members' => [],
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
        ]);
    }
}
