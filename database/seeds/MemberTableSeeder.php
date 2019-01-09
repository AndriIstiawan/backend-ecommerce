<?php

use Illuminate\Database\Seeder;

class MemberTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('members')->truncate();
        DB::table('members')->insert([
            [
	        	'name' => 'Member',
                'email' => 'member@ecommerce.com',
                'phone' => '081363916161',
                'point' => 0,
	        	'level' => [],
                'status' => 'on',
                'type' => [
                    [
                        'type' => 'B2B',
                        'businessattr' => [
                            [
                                'business'=>'Business',
                                'department'=>'Department',
                                'businesstype'=>'Telecomunication',
                                'totalemployee'=>'0-20',
                            ],
                        ],
                    ],
                    [
                        'type' => 'B2C',
                    ]
                ],
                'address' => [
                    [
                        'address_alias' => 'kalideres',
                        'receiver_name' => 'faishal',
                        'phone_number' => '081818827077',
                        'address' => 'jalan bedugul',
                        'city_id' => '151',
                        'province_id' => '6',
                        'province' => 'DKI Jakarta',
                        'type' => 'Kota',
                        'city_name' => 'Jakarta Barat',
                        'postal_code' => '11220',
                        'primary' => true
                    ]
                ],
                'dompet' => 0,
                'koin' => 0,
                'password' =>  bcrypt('asdasd'),
                'sales' => [],
				'created_at' => date("Y-m-d H:i:s"),
				'updated_at' => date("Y-m-d H:i:s")
            ],
            [
                'name' => 'Member 2',
                'email' => 'member2@ecommerce.com',
                'phone' => '081363912626',
                'point' => 0,
                'level' => [],
                'status' => 'on',
                'type' => [
                    [
                        'type' => 'B2B',
                        'businessattr' => [
                            [
                                'business'=>'Business',
                                'department'=>'Department',
                                'businesstype'=>'Telecomunication',
                                'totalemployee'=>'0-20',
                            ],
                        ],
                    ],
                    [
                        'type' => 'B2C',
                    ]
                ],
                'address' => [
                    [
                        'address_alias' => 'kalideres',
                        'receiver_name' => 'faishal',
                        'phone_number' => '081818827077',
                        'address' => 'jalan bedugul',
                        'city_id' => '151',
                        'province_id' => '6',
                        'province' => 'DKI Jakarta',
                        'type' => 'Kota',
                        'city_name' => 'Jakarta Barat',
                        'postal_code' => '11220',
                        'primary' => true
                    ]
                ],
                'dompet' => 0,
                'koin' => 0,
                'password' =>  bcrypt('asdasd'),
                'sales' => [],
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],
            [
                'name' => 'Member 3',
                'email' => 'member3@ecommerce.com',
                'phone' => '081363913636',
                'point' => 0,
                'level' => [],
                'status' => 'on',
                'type' => [
                    [
                        'type' => 'B2B',
                        'businessattr' => [
                            [
                                'business'=>'Business',
                                'department'=>'Department',
                                'businesstype'=>'Telecomunication',
                                'totalemployee'=>'0-20',
                            ],
                        ],
                    ],
                    [
                        'type' => 'B2C',
                    ]
                ],
                'address' => [
                    [
                        'address_alias' => 'kalideres',
                        'receiver_name' => 'faishal',
                        'phone_number' => '081818827077',
                        'address' => 'jalan bedugul',
                        'city_id' => '151',
                        'province_id' => '6',
                        'province' => 'DKI Jakarta',
                        'type' => 'Kota',
                        'city_name' => 'Jakarta Barat',
                        'postal_code' => '11220',
                        'primary' => true
                    ]
                ],
                'dompet' => 0,
                'koin' => 0,
                'password' =>  bcrypt('asdasd'),
                'sales' => [],
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],
            [
                'name' => 'Member 4',
                'email' => 'member4@ecommerce.com',
                'phone' => '081363914646',
                'point' => 0,
                'level' => [],
                'status' => 'on',
                'type' => [
                    [
                        'type' => 'B2B',
                        'businessattr' => [
                            [
                                'business'=>'Business',
                                'department'=>'Department',
                                'businesstype'=>'Telecomunication',
                                'totalemployee'=>'0-20',
                            ],
                        ],
                    ],
                    [
                        'type' => 'B2C',
                    ]
                ],
                'address' => [
                    [
                        'address_alias' => 'kalideres',
                        'receiver_name' => 'faishal',
                        'phone_number' => '081818827077',
                        'address' => 'jalan bedugul',
                        'city_id' => '151',
                        'province_id' => '6',
                        'province' => 'DKI Jakarta',
                        'type' => 'Kota',
                        'city_name' => 'Jakarta Barat',
                        'postal_code' => '11220',
                        'primary' => true
                    ]
                ],
                'dompet' => 0,
                'koin' => 0,
                'password' =>  bcrypt('asdasd'),
                'sales' => [],
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],
            [
                'name' => 'Member 5',
                'email' => 'member5@ecommerce.com',
                'phone' => '081363915656',
                'point' => 0,
                'level' => [],
                'status' => 'on',
                'type' => [
                    [
                        'type' => 'B2B',
                        'businessattr' => [
                            [
                                'business'=>'Business',
                                'department'=>'Department',
                                'businesstype'=>'Telecomunication',
                                'totalemployee'=>'0-20',
                            ],
                        ],
                    ],
                    [
                        'type' => 'B2C',
                    ]
                ],
                'address' => [
                    [
                        'address_alias' => 'kalideres',
                        'receiver_name' => 'faishal',
                        'phone_number' => '081818827077',
                        'address' => 'jalan bedugul',
                        'city_id' => '151',
                        'province_id' => '6',
                        'province' => 'DKI Jakarta',
                        'type' => 'Kota',
                        'city_name' => 'Jakarta Barat',
                        'postal_code' => '11220',
                        'primary' => true
                    ]
                ],
                'dompet' => 0,
                'koin' => 0,
                'password' =>  bcrypt('asdasd'),
                'sales' => [],
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],
            [
                'name' => 'Member 6',
                'email' => 'member6@ecommerce.com',
                'phone' => '081363916666',
                'point' => 0,
                'level' => [],
                'status' => 'on',
                'type' => [
                    [
                        'type' => 'B2B',
                        'businessattr' => [
                            [
                                'business'=>'Business',
                                'department'=>'Department',
                                'businesstype'=>'Telecomunication',
                                'totalemployee'=>'0-20',
                            ],
                        ],
                    ],
                    [
                        'type' => 'B2C',
                    ]
                ],
                'address' => [
                    [
                        'address_alias' => 'kalideres',
                        'receiver_name' => 'faishal',
                        'phone_number' => '081818827077',
                        'address' => 'jalan bedugul',
                        'city_id' => '151',
                        'province_id' => '6',
                        'province' => 'DKI Jakarta',
                        'type' => 'Kota',
                        'city_name' => 'Jakarta Barat',
                        'postal_code' => '11220',
                        'primary' => true
                    ]
                ],
                'dompet' => 0,
                'koin' => 0,
                'password' =>  bcrypt('asdasd'),
                'sales' => [],
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ]
        ]);

        $parent = DB::table('users')->whereIn('email',['sales@gmail.com'])->get();
        DB::table('members')->whereIn('email', ['member@ecommerce.com'])
            ->update(['sales' => $parent->toArray()]);
        
        $kk = DB::table('levels')->whereIn('name',['Toko Besar'])->get();
        DB::table('members')->whereIn('email', ['member@ecommerce.com'])
            ->update(['level' => $kk->toArray()]);

        $parent = DB::table('users')->whereIn('email',['sales@gmail.com'])->get();
        DB::table('members')->whereIn('email', ['member2@ecommerce.com'])
            ->update(['sales' => $parent->toArray()]);
        
        $kk = DB::table('levels')->whereIn('name',['Panel Maker'])->get();
        DB::table('members')->whereIn('email', ['member2@ecommerce.com'])
            ->update(['level' => $kk->toArray()]);

        $parent = DB::table('users')->whereIn('email',['sales@gmail.com'])->get();
        DB::table('members')->whereIn('email', ['member3@ecommerce.com'])
            ->update(['sales' => $parent->toArray()]);
        
        $kk = DB::table('levels')->whereIn('name',['Kontraktor'])->get();
        DB::table('members')->whereIn('email', ['member3@ecommerce.com'])
            ->update(['level' => $kk->toArray()]);

        $parent = DB::table('users')->whereIn('email',['sales@gmail.com'])->get();
        DB::table('members')->whereIn('email', ['member4@ecommerce.com'])
            ->update(['sales' => $parent->toArray()]);
        
        $kk = DB::table('levels')->whereIn('name',['Industri'])->get();
        DB::table('members')->whereIn('email', ['member4@ecommerce.com'])
            ->update(['level' => $kk->toArray()]);

        $parent = DB::table('users')->whereIn('email',['sales@gmail.com'])->get();
        DB::table('members')->whereIn('email', ['member5@ecommerce.com'])
            ->update(['sales' => $parent->toArray()]);
        
        $kk = DB::table('levels')->whereIn('name',['Modern Retail'])->get();
        DB::table('members')->whereIn('email', ['member5@ecommerce.com'])
            ->update(['level' => $kk->toArray()]);

        $parent = DB::table('users')->whereIn('email',['sales@gmail.com'])->get();
        DB::table('members')->whereIn('email', ['member6@ecommerce.com'])
            ->update(['sales' => $parent->toArray()]);
        
        $kk = DB::table('levels')->whereIn('name',['Oem'])->get();
        DB::table('members')->whereIn('email', ['member6@ecommerce.com'])
            ->update(['level' => $kk->toArray()]);
    }
}
