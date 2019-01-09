<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //validasi untuk database yang sudah di seed
        if(DB::table('permissions')->count() == 0){
            $this->call(RolesTableSeeder::class);
            $this->call(UsersTableSeeder::class);
            $this->call(PermissionsTableSeeder::class);
            $this->call(DiscountsTableSeeder::class);
            $this->call(BrandsTableSeeder::class);
            $this->call(CouriersTableSeeder::class);
            $this->call(CategoriesTableSeeder::class);
            $this->call(LevelTableSeeder::class);
            $this->call(MemberTableSeeder::class);
            $this->call(OrderStatusesTableSeeder::class);
            $this->call(MasterSettingTableSeeder::class);
            $this->call(PaymentsTableSeeder::class);
            $this->call(OrdersTableSeeder::class);
            $this->call(SegmentAttributesTableSeeder::class);
            $this->call(SegmentsTableSeeder::class);
            $this->call(SlidersTableSeeder::class);
            $this->call(PromosTableSeeder::class);
            $this->call(FootersTableSeeder::class);
            $this->call(PaymensMethodsTableSeeder::class);
            $this->call(ProductsTableSeeder::class);
            $this->call(ProductUpdateDiscountSeeder::class);
            $this->call(SaldoSeeder::class);
        }
        //start update 24-sep-2018
        $this->call(UpdateProductVariantStock::class);
        $this->call(UpdateMemberLevelName::class);
    }
}
