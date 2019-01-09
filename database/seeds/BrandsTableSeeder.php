<?php

use Illuminate\Database\Seeder;

class BrandsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('brands')->truncate();
        DB::table('brands')->insert([
            [
                'name' => 'Asus',
                'slug' => 'asus',
                'picture' => '5ae42ce81c44d05872744332.png',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [
                'name' => 'Tong tji',
                'slug' => 'tong-tji',
                'picture' => '5ae42d471c44d05872744333.png',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [
                'name' => 'Yuasa',
                'slug' => 'yuasa',
                'picture' => '5ae42d831c44d05872744334.png',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [
                'name' => 'Samsung',
                'slug' => 'samsung',
                'picture' => '5ae42db31c44d05872744335.png',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [
                'name' => 'Nutrifood',
                'slug' => 'nutrifood',
                'picture' => '5ae42de61c44d05872744336.png',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [
                'name' => 'Hargen',
                'slug' => 'hargen',
                'picture' => '5ae42e0f1c44d05872744337.png',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [
                'name' => 'Garmin',
                'slug' => 'garmin',
                'picture' => '5ae42e351c44d05872744338.png',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [
                'name' => 'Fluke',
                'slug' => 'fluke',
                'picture' => '5ae42e581c44d05872744339.png',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [
                'name' => 'Erafone',
                'slug' => 'erafone',
                'picture' => '5ae42e831c44d0587274433a.png',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [
                'name' => 'Otsuka',
                'slug' => 'otsuka',
                'picture' => '5ae42ea81c44d0587274433b.png',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [
                'name' => 'Element 14',
                'slug' => 'element-14',
                'picture' => '5ae42edb1c44d0587274433c.png',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [
                'name' => 'Honda',
                'slug' => 'honda',
                'picture' => '5ae42efe1c44d0587274433d.png',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [
                'name' => 'OT',
                'slug' => 'ot',
                'picture' => '5ae42f211c44d0587274433e.png',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [
                'name' => 'Mustika Ratu',
                'slug' => 'mustika-ratu',
                'picture' => '5ae42f461c44d0587274433f.png',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [
                'name' => 'BTicino',
                'slug' => 'bticino',
                'picture' => 'bticino.png',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [
                'name' => 'Cablofil',
                'slug' => 'cablofil',
                'picture' => 'cablofil.png',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [
                'name' => 'Watt Stopper',
                'slug' => 'watt-stopper',
                'picture' => 'watt-stopper.png',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [
                'name' => 'Zucchini',
                'slug' => 'zucchini',
                'picture' => 'zucchini.png',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
        ]
        );
    }
}
