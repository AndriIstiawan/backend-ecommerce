<?php

use Illuminate\Database\Seeder;

class LevelTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('levels')->truncate();
        DB::table('levels')->insert([
			[
                'order' => 1,
                'key_id' => 'toko',
                'parent' => [],
                'name' => 'Toko',
                'loyalty_point' => 0,
                'hutang' => 0,
				'created_at' => date("Y-m-d H:i:s"),
				'updated_at' => date("Y-m-d H:i:s")
            ],
            [
                'order' => 1,
                'key_id' => 'toko-kecil',
                'parent' => [],
                'name' => 'Toko Kecil',
                'loyalty_point' => 100,
                'hutang' => 0,
				'created_at' => date("Y-m-d H:i:s"),
				'updated_at' => date("Y-m-d H:i:s")
            ],
            [
                'order' => 2,
                'key_id' => 'toko-sedang',
                'parent' => [],
                'name' => 'Toko Sedang',
                'loyalty_point' => 100,
                'hutang' => 0,
				'created_at' => date("Y-m-d H:i:s"),
				'updated_at' => date("Y-m-d H:i:s")
            ],
            [
                'order' => 3,
                'key_id' => 'toko-besar',
                'parent' => [],
                'name' => 'Toko Besar',
                'loyalty_point' => 100,
                'hutang' => 1000000,
				'created_at' => date("Y-m-d H:i:s"),
				'updated_at' => date("Y-m-d H:i:s")
        	],
            [
                'order' => 2,
                'key_id' => 'panel-maker',
                'parent' => [],
                'name' => 'Panel Maker',
                'loyalty_point' => 0,
                'hutang' => 0,
				'created_at' => date("Y-m-d H:i:s"),
				'updated_at' => date("Y-m-d H:i:s")
            ],
            [
                'order' => 1,
                'key_id' => 'panel-maker-kecil',
                'parent' => [],
                'name' => 'Panel Maker Kecil',
                'loyalty_point' => 200,
                'hutang' => 2000000,
				'created_at' => date("Y-m-d H:i:s"),
				'updated_at' => date("Y-m-d H:i:s")
            ],
            [
                'order' => 2,
                'key_id' => 'panel-maker-sedang',
                'parent' => [],
                'name' => 'Panel Maker Sedang',
                'loyalty_point' => 200,
                'hutang' => 3000000,
				'created_at' => date("Y-m-d H:i:s"),
				'updated_at' => date("Y-m-d H:i:s")
            ],
            [
                'order' => 3,
                'key_id' => 'panel-maker-besar',
                'parent' => [],
                'name' => 'Panel Maker Besar',
                'loyalty_point' => 200,
                'hutang' => 5000000,
				'created_at' => date("Y-m-d H:i:s"),
				'updated_at' => date("Y-m-d H:i:s")
            ],
            [
                'order' => 3,
                'key_id' => 'kontraktor',
                'parent' => [],
                'name' => 'Kontraktor',
                'loyalty_point' => 0,
                'hutang' => 0,
				'created_at' => date("Y-m-d H:i:s"),
				'updated_at' => date("Y-m-d H:i:s")
            ],
            [
                'order' => 1,
                'key_id' => 'kontraktor-kecil',
                'parent' => [],
                'name' => 'Kontraktor Kecil',
                'loyalty_point' => 500,
                'hutang' => 10000000,
				'created_at' => date("Y-m-d H:i:s"),
				'updated_at' => date("Y-m-d H:i:s")
            ],
            [
                'order' => 2,
                'key_id' => 'kontraktor-sedang',
                'parent' => [],
                'name' => 'Kontraktor Sedang',
                'loyalty_point' => 500,
                'hutang' => 20000000,
				'created_at' => date("Y-m-d H:i:s"),
				'updated_at' => date("Y-m-d H:i:s")
            ],
            [
                'order' => 3,
                'key_id' => 'kontraktor-besar',
                'parent' => [],
                'name' => 'Kontraktor Besar',
                'loyalty_point' => 500,
                'hutang' => 50000000,
				'created_at' => date("Y-m-d H:i:s"),
				'updated_at' => date("Y-m-d H:i:s")
            ],
            [
                'order' => 4,
                'key_id' => 'industri',
                'parent' => [],
                'name' => 'Industri',
                'loyalty_point' => 0,
                'hutang' => 0,
				'created_at' => date("Y-m-d H:i:s"),
				'updated_at' => date("Y-m-d H:i:s")
            ],
            [
                'order' => 1,
                'key_id' => 'industri-kecil',
                'parent' => [],
                'name' => 'Industri Kecil',
                'loyalty_point' => 500,
                'hutang' => 60000000,
				'created_at' => date("Y-m-d H:i:s"),
				'updated_at' => date("Y-m-d H:i:s")
            ],
            [
                'order' => 2,
                'key_id' => 'industri-sedang',
                'parent' => [],
                'name' => 'Industri Sedang',
                'loyalty_point' => 500,
                'hutang' => 75000000,
				'created_at' => date("Y-m-d H:i:s"),
				'updated_at' => date("Y-m-d H:i:s")
            ],
            [
                'order' => 3,
                'key_id' => 'industri-besar',
                'parent' => [],
                'name' => 'Industri Besar',
                'loyalty_point' => 500,
                'hutang' => 100000000,
				'created_at' => date("Y-m-d H:i:s"),
				'updated_at' => date("Y-m-d H:i:s")
            ],
            [
                'order' => 5,
                'key_id' => 'modern-retail',
                'parent' => [],
                'name' => 'Modern Retail',
                'loyalty_point' => 0,
                'hutang' => 0,
				'created_at' => date("Y-m-d H:i:s"),
				'updated_at' => date("Y-m-d H:i:s")
            ],
            [
                'order' => 1,
                'key_id' => 'modern-retail-kecil',
                'parent' => [],
                'name' => 'Modern Retail Kecil',
                'loyalty_point' => 1000,
                'hutang' => 200000000,
				'created_at' => date("Y-m-d H:i:s"),
				'updated_at' => date("Y-m-d H:i:s")
            ],
            [
                'order' => 2,
                'key_id' => 'modern-retail-sedang',
                'parent' => [],
                'name' => 'Modern Retail Sedang',
                'loyalty_point' => 1000,
                'hutang' => 300000000,
				'created_at' => date("Y-m-d H:i:s"),
				'updated_at' => date("Y-m-d H:i:s")
            ],
            [
                'order' => 3,
                'key_id' => 'modern-retail-besar',
                'parent' => [],
                'name' => 'Modern Retail Besar',
                'loyalty_point' => 1000,
                'hutang' => 500000000,
				'created_at' => date("Y-m-d H:i:s"),
				'updated_at' => date("Y-m-d H:i:s")
            ],
            [
                'order' => 6,
                'key_id' => 'oem',
                'parent' => [],
                'name' => 'OEM',
                'loyalty_point' => 0,
                'hutang' => 0,
				'created_at' => date("Y-m-d H:i:s"),
				'updated_at' => date("Y-m-d H:i:s")
            ],
            [
                'order' => 1,
                'key_id' => 'oem-kecil',
                'parent' => [],
                'name' => 'OEM Kecil',
                'loyalty_point' => 3000,
                'hutang' => 1000000000,
				'created_at' => date("Y-m-d H:i:s"),
				'updated_at' => date("Y-m-d H:i:s")
            ],
            [
                'order' => 2,
                'key_id' => 'oem-sedang',
                'parent' => [],
                'name' => 'OEM Sedang',
                'loyalty_point' => 3000,
                'hutang' => 2000000000,
				'created_at' => date("Y-m-d H:i:s"),
				'updated_at' => date("Y-m-d H:i:s")
            ],
            [
                'order' => 3,
                'key_id' => 'oem-besar',
                'parent' => [],
                'name' => 'OEM Besar',
                'loyalty_point' => 4000,
                'hutang' => 5000000000,
				'created_at' => date("Y-m-d H:i:s"),
				'updated_at' => date("Y-m-d H:i:s")
            ],
        ]);
        
        $parent = DB::table('levels')->whereIn('key_id',['toko'])->get();
        DB::table('levels')->whereIn('key_id', ['toko-kecil','toko-sedang','toko-besar'])->update(['parent' => $parent->toArray()]);
        $parent = DB::table('levels')->whereIn('key_id',['panel-maker'])->get();
        DB::table('levels')->whereIn('key_id', ['panel-maker-kecil','panel-maker-sedang','panel-maker-besar'])->update(['parent' => $parent->toArray()]);
        $parent = DB::table('levels')->whereIn('key_id',['kontraktor'])->get();
        DB::table('levels')->whereIn('key_id', ['kontraktor-kecil','kontraktor-sedang','kontraktor-besar'])->update(['parent' => $parent->toArray()]);
        $parent = DB::table('levels')->whereIn('key_id',['industri'])->get();
        DB::table('levels')->whereIn('key_id', ['industri-kecil','industri-sedang','industri-besar'])->update(['parent' => $parent->toArray()]);
        $parent = DB::table('levels')->whereIn('key_id',['modern-retail'])->get();
        DB::table('levels')->whereIn('key_id', ['modern-retail-kecil','modern-retail-sedang','modern-retail-besar'])->update(['parent' => $parent->toArray()]);
        $parent = DB::table('levels')->whereIn('key_id',['oem'])->get();
        DB::table('levels')->whereIn('key_id', ['oem-kecil','oem-sedang','oem-besar'])->update(['parent' => $parent->toArray()]);
    }
}
