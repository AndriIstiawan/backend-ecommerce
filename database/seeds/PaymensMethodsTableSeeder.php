<?php

use Illuminate\Database\Seeder;

class PaymensMethodsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('payment_methods')->truncate();
        DB::table('payment_methods')->insert([
            [
               'type' => 'Payment Gateway',
               'key' => 'midtrans',
               'image' => 'midtrans.png',
               'name' => 'Midtrans Payment',
               'account' => 'HOKY',
               'account_number' => 'default',
               'status' => 'on',
               'created_at' => date("Y-m-d H:i:s"),
               'updated_at' => date("Y-m-d H:i:s")
            ],
            [
               'type' => 'ATM Transfer',
               'key' => '',
               'image' => 'mandiri-logo.png',
               'name' => 'MANDIRI',
               'account' => 'C FAISHAL AMRULLAH',
               'account_number' => '1760000997310',
               'status' => 'on',
               'created_at' => date("Y-m-d H:i:s"),
               'updated_at' => date("Y-m-d H:i:s")
            ],
            [
                'type' => 'ATM Transfer',
                'key' => '',
                'image' => 'bca-logo.png',
                'name' => 'BCA',
                'account' => 'C FAISHAL AMRULLAH',
                'account_number' => '7640873943',
                'status' => 'on',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
             ],
       ]);
    }
}
