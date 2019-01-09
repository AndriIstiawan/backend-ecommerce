<?php

use Illuminate\Database\Seeder;

class CouriersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('couriers')->truncate();
        DB::table('couriers')->insert([
            [
                'courier' => 'JNE',
                'type' => 'default courier',
                'slug' => 'jne',
                'location' => [
                    [
                        'city_id' => '152',
                        'province_id' => '6',
                        'province' => 'DKI Jakarta',
                        'type' => 'Kota',
                        'city_name' => 'Jakarta Pusat',
                        'postal_code' => '10540',
                    ],
                ],
                'status' => 'on',
                'service' => [],
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [
                'courier' => 'POS',
                'type' => 'default courier',
                'slug' => 'pos',
                'location' => [
                    [
                        'city_id' => '152',
                        'province_id' => '6',
                        'province' => 'DKI Jakarta',
                        'type' => 'Kota',
                        'city_name' => 'Jakarta Pusat',
                        'postal_code' => '10540',
                    ],
                ],
                'status' => 'on',
                'service' => [],
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [
                'courier' => 'TIKI',
                'type' => 'default courier',
                'slug' => 'tiki',
                'location' => [
                    [
                        'city_id' => '152',
                        'province_id' => '6',
                        'province' => 'DKI Jakarta',
                        'type' => 'Kota',
                        'city_name' => 'Jakarta Pusat',
                        'postal_code' => '10540',
                    ],
                ],
                'status' => 'on',
                'service' => [],
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [
                'courier' => 'Hoky Courier',
                'type' => 'e-commerce courier',
                'slug' => 'hoky',
                'location' => [
                    [
                        'city_id' => '152',
                        'province_id' => '6',
                        'province' => 'DKI Jakarta',
                        'type' => 'Kota',
                        'city_name' => 'Jakarta Pusat',
                        'postal_code' => '10540',
                    ],
                ],
                'status' => 'on',
                'service' => [
                    [
                        'name' => 'Hoky SIP',
                        'description' => 'hoky pengiriman express'
                    ],
                    [
                        'name' => 'Hoky OKE',
                        'description' => 'hoky pengiriman standar'
                    ],
                ],
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
        ]);
    }
}
