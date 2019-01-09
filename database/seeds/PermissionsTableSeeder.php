<?php

use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::table('permissions')->truncate();
        DB::table('permissions')->insert([
            [
	        	'name' => 'Footer Management',
	        	'slug' => 'footer',
	        	'type' => 'module-menu',
				'icon' => 'fa fa-bars',
				'parent' => null,
				'description' => 'Module Menu',
				'guard_name' => 'web',
				'created_at' => date("Y-m-d H:i:s"),
				'updated_at' => date("Y-m-d H:i:s")
			],
            [
	        	'name' => 'Master-Home',
	        	'slug' => null,
	        	'type' => 'module-menu',
				'icon' => 'fa fa-home',
				'parent' => null,
				'description' => 'Module Menu',
				'guard_name' => 'web',
				'created_at' => date("Y-m-d H:i:s"),
				'updated_at' => date("Y-m-d H:i:s")
            ],
            [
	        	'name' => 'Home Slider',
	        	'slug' => 'slider',
	        	'type' => 'module-menu',
				'icon' => 'icon-cursor',
				'parent' => null,
				'description' => 'Module Menu',
				'guard_name' => 'web',
				'created_at' => date("Y-m-d H:i:s"),
				'updated_at' => date("Y-m-d H:i:s")
            ],
            [
	        	'name' => 'Brands/Partners',
	        	'slug' => 'brands',
	        	'type' => 'module-menu',
				'icon' => 'icon-cursor',
				'parent' => null,
				'description' => 'Module Menu',
				'guard_name' => 'web',
				'created_at' => date("Y-m-d H:i:s"),
				'updated_at' => date("Y-m-d H:i:s")
			],
			[
	        	'name' => 'User Management',
	        	'slug' => null,
	        	'type' => 'module-menu',
				'icon' => 'icon-people',
				'parent' => null,
				'description' => 'Module Menu',
				'guard_name' => 'web',
				'created_at' => date("Y-m-d H:i:s"),
				'updated_at' => date("Y-m-d H:i:s")
			],
			// [
	        // 	'name' => 'Permission',
	        // 	'slug' => 'permission',
	        // 	'type' => 'module-menu',
			// 	'icon' => 'icon-cursor',
			// 	'parent' => null,
			// 	'description' => 'Module Menu',
			// 	'guard_name' => 'web',
			// 	'created_at' => date("Y-m-d H:i:s"),
			// 	'updated_at' => date("Y-m-d H:i:s")
			// ],
			[
	        	'name' => 'Role',
	        	'slug' => 'role',
	        	'type' => 'module-menu',
				'icon' => 'icon-cursor',
				'parent' => null,
				'description' => 'Module Menu',
				'guard_name' => 'web',
				'created_at' => date("Y-m-d H:i:s"),
				'updated_at' => date("Y-m-d H:i:s")
			],
			[
	        	'name' => 'Master User',
	        	'slug' => 'master-user',
	        	'type' => 'module-menu',
				'icon' => 'icon-cursor',
				'parent' => null,
				'description' => 'Module Menu',
				'guard_name' => 'web',
				'created_at' => date("Y-m-d H:i:s"),
				'updated_at' => date("Y-m-d H:i:s")
            ],
            [
	        	'name' => 'Master Member',
	        	'slug' => null,
	        	'type' => 'module-menu',
				'icon' => 'fa fa-users',
				'parent' => null,
				'description' => 'Module Menu',
				'guard_name' => 'web',
				'created_at' => date("Y-m-d H:i:s"),
				'updated_at' => date("Y-m-d H:i:s")
			],
			[
	        	'name' => 'Member',
	        	'slug' => 'master-member',
	        	'type' => 'module-menu',
				'icon' => 'icon-cursor',
				'parent' => null,
				'description' => 'Module Menu',
				'guard_name' => 'web',
				'created_at' => date("Y-m-d H:i:s"),
				'updated_at' => date("Y-m-d H:i:s")
			],
			[
	        	'name' => 'Level',
	        	'slug' => 'level',
	        	'type' => 'module-menu',
				'icon' => 'icon-cursor',
				'parent' => null,
				'description' => 'Module Menu',
				'guard_name' => 'web',
				'created_at' => date("Y-m-d H:i:s"),
				'updated_at' => date("Y-m-d H:i:s")
            ],
			[
	        	'name' => 'Saldo',
	        	'slug' => 'saldo-member',
	        	'type' => 'module-menu',
				'icon' => 'icon-cursor',
				'parent' => null,
				'description' => 'Module Menu',
				'guard_name' => 'web',
				'created_at' => date("Y-m-d H:i:s"),
				'updated_at' => date("Y-m-d H:i:s")
            ],
			[
	        	'name' => 'Company',
	        	'slug' => 'company-member',
	        	'type' => 'module-menu',
				'icon' => 'icon-cursor',
				'parent' => null,
				'description' => 'Module Menu',
				'guard_name' => 'web',
				'created_at' => date("Y-m-d H:i:s"),
				'updated_at' => date("Y-m-d H:i:s")
            ],
			[
	        	'name' => 'Master Deal',
	        	'slug' => null,
	        	'type' => 'module-menu',
				'icon' => 'fa fa-money',
				'parent' => null,
				'description' => 'Module Menu',
				'guard_name' => 'web',
				'created_at' => date("Y-m-d H:i:s"),
				'updated_at' => date("Y-m-d H:i:s")
			],
			[
	        	'name' => 'Discount',
	        	'slug' => 'discount',
	        	'type' => 'module-menu',
				'icon' => 'icon-cursor',
				'parent' => null,
				'description' => 'Module Menu',
				'guard_name' => 'web',
				'created_at' => date("Y-m-d H:i:s"),
				'updated_at' => date("Y-m-d H:i:s")
			],
			[
	        	'name' => 'Promo',
	        	'slug' => 'promo',
	        	'type' => 'module-menu',
				'icon' => 'icon-cursor',
				'parent' => null,
				'description' => 'Module Menu',
				'guard_name' => 'web',
				'created_at' => date("Y-m-d H:i:s"),
				'updated_at' => date("Y-m-d H:i:s")
			],
			[
	        	'name' => 'Product Management',
	        	'slug' => null,
	        	'type' => 'module-menu',
				'icon' => 'fa fa-cubes',
				'parent' => null,
				'description' => 'Module Menu',
				'guard_name' => 'web',
				'created_at' => date("Y-m-d H:i:s"),
				'updated_at' => date("Y-m-d H:i:s")
			],
			[
	        	'name' => 'Product',
	        	'slug' => 'product',
	        	'type' => 'module-menu',
				'icon' => 'icon-cursor',
				'parent' => null,
				'description' => 'Module Menu',
				'guard_name' => 'web',
				'created_at' => date("Y-m-d H:i:s"),
				'updated_at' => date("Y-m-d H:i:s")
			],
			// [
	        // 	'name' => 'Attributes',
	        // 	'slug' => 'attributes',
	        // 	'type' => 'module-menu',
			// 	'icon' => 'fa fa-tag',
			// 	'parent' => null,
			// 	'description' => 'Module Menu',
			// 	'guard_name' => 'web',
			// 	'created_at' => date("Y-m-d H:i:s"),
			// 	'updated_at' => date("Y-m-d H:i:s")
			// ],
			// [
	        // 	'name' => 'Attribute Sets',
	        // 	'slug' => 'attribute-sets',
	        // 	'type' => 'module-menu',
			// 	'icon' => 'fa fa-tags',
			// 	'parent' => null,
			// 	'description' => 'Module Menu',
			// 	'guard_name' => 'web',
			// 	'created_at' => date("Y-m-d H:i:s"),
			// 	'updated_at' => date("Y-m-d H:i:s")
			// ],
			[
	        	'name' => 'Category',
	        	'slug' => 'category',
	        	'type' => 'module-menu',
				'icon' => 'icon-cursor',
				'parent' => null,
				'description' => 'Module Menu',
				'guard_name' => 'web',
				'created_at' => date("Y-m-d H:i:s"),
				'updated_at' => date("Y-m-d H:i:s")
			],
			// [
	        // 	'name' => 'Variants',
	        // 	'slug' => 'variant',
	        // 	'type' => 'module-menu',
			// 	'icon' => 'icon-cursor',
			// 	'parent' => null,
			// 	'description' => 'Module Menu',
			// 	'guard_name' => 'web',
			// 	'created_at' => date("Y-m-d H:i:s"),
			// 	'updated_at' => date("Y-m-d H:i:s")
			// ],
			// [
	        // 	'name' => 'Taxes',
	        // 	'slug' => 'taxes',
	        // 	'type' => 'module-menu',
			// 	'icon' => 'fa fa-balance-scale',
			// 	'parent' => null,
			// 	'description' => 'Module Menu',
			// 	'guard_name' => 'web',
			// 	'created_at' => date("Y-m-d H:i:s"),
			// 	'updated_at' => date("Y-m-d H:i:s")
			// ],
			// [
	        // 	'name' => 'Orders Management',
	        // 	'slug' => null,
	        // 	'type' => 'module-menu',
			// 	'icon' => 'fa fa-shopping-cart',
			// 	'parent' => null,
			// 	'description' => 'Module Menu',
			// 	'guard_name' => 'web',
			// 	'created_at' => date("Y-m-d H:i:s"),
			// 	'updated_at' => date("Y-m-d H:i:s")
			// ],
			// [
	        // 	'name' => 'Order Status',
	        // 	'slug' => 'orderstatuses',
	        // 	'type' => 'module-menu',
			// 	'icon' => 'icon-cursor',
			// 	'parent' => null,
			// 	'description' => 'Module Menu',
			// 	'guard_name' => 'web',
			// 	'created_at' => date("Y-m-d H:i:s"),
			// 	'updated_at' => date("Y-m-d H:i:s")
            // ],
            [
	        	'name' => 'Cart',
	        	'slug' => 'cart',
	        	'type' => 'module-menu',
				'icon' => 'fa fa-shopping-basket',
				'parent' => null,
				'description' => 'Module Menu',
				'guard_name' => 'web',
				'created_at' => date("Y-m-d H:i:s"),
				'updated_at' => date("Y-m-d H:i:s")
            ],
            [
	        	'name' => 'B2C selling',
	        	'slug' => null,
	        	'type' => 'module-menu',
				'icon' => 'fa fa-id-badge',
				'parent' => null,
				'description' => 'Module Menu',
				'guard_name' => 'web',
				'created_at' => date("Y-m-d H:i:s"),
				'updated_at' => date("Y-m-d H:i:s")
            ],
            [
	        	'name' => 'Order History B2C',
	        	'slug' => 'orders',
	        	'type' => 'module-menu',
				'icon' => 'icon-cursor',
				'parent' => null,
				'description' => 'Module Menu',
				'guard_name' => 'web',
				'created_at' => date("Y-m-d H:i:s"),
				'updated_at' => date("Y-m-d H:i:s")
			],
            [
	        	'name' => 'B2B selling',
	        	'slug' => null,
	        	'type' => 'module-menu',
				'icon' => 'fa fa-opencart',
				'parent' => null,
				'description' => 'Module Menu',
				'guard_name' => 'web',
				'created_at' => date("Y-m-d H:i:s"),
				'updated_at' => date("Y-m-d H:i:s")
            ],
            [
	        	'name' => 'Pending PO',
	        	'slug' => 'pending-po',
	        	'type' => 'module-menu',
				'icon' => 'icon-cursor',
				'parent' => null,
				'description' => 'Module Menu',
				'guard_name' => 'web',
				'created_at' => date("Y-m-d H:i:s"),
				'updated_at' => date("Y-m-d H:i:s")
            ],
            [
	        	'name' => 'Order History B2B',
	        	'slug' => 'orders-b2b',
	        	'type' => 'module-menu',
				'icon' => 'icon-cursor',
				'parent' => null,
				'description' => 'Module Menu',
				'guard_name' => 'web',
				'created_at' => date("Y-m-d H:i:s"),
				'updated_at' => date("Y-m-d H:i:s")
            ],
			[
	        	'name' => 'Deliveries',
	        	'slug' => null,
	        	'type' => 'module-menu',
				'icon' => 'fa fa-truck',
				'parent' => null,
				'description' => 'Module Menu',
				'guard_name' => 'web',
				'created_at' => date("Y-m-d H:i:s"),
				'updated_at' => date("Y-m-d H:i:s")
			],
			[
	        	'name' => 'View Deliveries',
	        	'slug' => 'deliveries',
	        	'type' => 'module-menu',
				'icon' => 'icon-cursor',
				'parent' => null,
				'description' => 'Module Menu',
				'guard_name' => 'web',
				'created_at' => date("Y-m-d H:i:s"),
				'updated_at' => date("Y-m-d H:i:s")
			],
			[
	        	'name' => 'Courier & COD',
	        	'slug' => 'courier',
	        	'type' => 'module-menu',
				'icon' => 'icon-cursor',
				'parent' => null,
				'description' => 'Module Menu',
				'guard_name' => 'web',
				'created_at' => date("Y-m-d H:i:s"),
				'updated_at' => date("Y-m-d H:i:s")
			],
			[
	        	'name' => 'Payment Method',
	        	'slug' => 'payment-method',
	        	'type' => 'module-menu',
				'icon' => 'icon-cursor',
				'parent' => null,
				'description' => 'Module Menu',
				'guard_name' => 'web',
				'created_at' => date("Y-m-d H:i:s"),
				'updated_at' => date("Y-m-d H:i:s")
			],
            /*[
	        	'name' => 'Archievement',
	        	'slug' => 'archievement',
	        	'type' => 'module-menu',
				'icon' => 'fa fa-bars',
				'parent' => null,
				'description' => 'Module Menu',
				'guard_name' => 'web',
				'created_at' => date("Y-m-d H:i:s"),
				'updated_at' => date("Y-m-d H:i:s")
			],*/
			[
	        	'name' => 'Master Setting',
	        	'slug' => 'master-setting',
	        	'type' => 'access',
				'icon' => 'fa fa-cog',
				'parent' => null,
				'description' => 'Module Menu',
				'guard_name' => 'web',
				'created_at' => date("Y-m-d H:i:s"),
				'updated_at' => date("Y-m-d H:i:s")
			],
			// [
	        // 	'name' => 'Custom PO',
	        // 	'slug' => 'custom-po',
	        // 	'type' => 'module-menu',
			// 	'icon' => 'fa fa-opencart',
			// 	'parent' => null,
			// 	'description' => 'Module Menu',
			// 	'guard_name' => 'web',
			// 	'created_at' => date("Y-m-d H:i:s"),
			// 	'updated_at' => date("Y-m-d H:i:s")
			// ],
			[
	        	'name' => 'Payment',
	        	'slug' => null,
	        	'type' => 'module-menu',
				'icon' => 'fa fa-credit-card-alt',
				'parent' => null,
				'description' => 'Module Menu',
				'guard_name' => 'web',
				'created_at' => date("Y-m-d H:i:s"),
				'updated_at' => date("Y-m-d H:i:s")
			],
			[
	        	'name' => 'View Payment',
	        	'slug' => 'payment',
	        	'type' => 'module-menu',
				'icon' => 'icon-cursor',
				'parent' => null,
				'description' => 'Module Menu',
				'guard_name' => 'web',
				'created_at' => date("Y-m-d H:i:s"),
				'updated_at' => date("Y-m-d H:i:s")
			],
			[
	        	'name' => 'Payment PO',
	        	'slug' => 'paymentpo',
	        	'type' => 'module-menu',
				'icon' => 'icon-cursor',
				'parent' => null,
				'description' => 'Module Menu',
				'guard_name' => 'web',
				'created_at' => date("Y-m-d H:i:s"),
				'updated_at' => date("Y-m-d H:i:s")
			],
			// [
	        // 	'name' => 'Footer',
	        // 	'slug' => 'footer',
	        // 	'type' => 'module-menu',
			// 	'icon' => 'icon-cursor',
			// 	'parent' => null,
			// 	'description' => 'Module Menu',
			// 	'guard_name' => 'web',
			// 	'created_at' => date("Y-m-d H:i:s"),
			// 	'updated_at' => date("Y-m-d H:i:s")
			// ],
			// [
	        // 	'name' => 'Segment',
	        // 	'slug' => 'segment',
	        // 	'type' => 'module-menu',
			// 	'icon' => 'icon-cursor',
			// 	'parent' => null,
			// 	'description' => 'Module Menu',
			// 	'guard_name' => 'web',
			// 	'created_at' => date("Y-m-d H:i:s"),
			// 	'updated_at' => date("Y-m-d H:i:s")
			// ],
			// [
	        // 	'name' => 'Segment Attributes',
	        // 	'slug' => 'segment-attributes',
	        // 	'type' => 'module-menu',
			// 	'icon' => 'icon-cursor',
			// 	'parent' => null,
			// 	'description' => 'Module Menu',
			// 	'guard_name' => 'web',
			// 	'created_at' => date("Y-m-d H:i:s"),
			// 	'updated_at' => date("Y-m-d H:i:s")
            // ],
            [
	        	'name' => 'Mail Blast',
	        	'slug' => 'mail',
	        	'type' => 'module-menu',
				'icon' => 'fa fa-send-o',
				'parent' => null,
				'description' => 'Module Menu',
				'guard_name' => 'web',
				'created_at' => date("Y-m-d H:i:s"),
				'updated_at' => date("Y-m-d H:i:s")
			],
            [
	        	'name' => 'Image Upload',
	        	'slug' => 'image-upload',
	        	'type' => 'module-menu',
				'icon' => 'fa fa-image',
				'parent' => null,
				'description' => 'Module Menu',
				'guard_name' => 'web',
				'created_at' => date("Y-m-d H:i:s"),
				'updated_at' => date("Y-m-d H:i:s")
			],
            [
	        	'name' => 'News',
	        	'slug' => 'news',
	        	'type' => 'module-menu',
				'icon' => 'fa fa-newspaper-o',
				'parent' => null,
				'description' => 'Module Menu',
				'guard_name' => 'web',
				'created_at' => date("Y-m-d H:i:s"),
				'updated_at' => date("Y-m-d H:i:s")
			],
            [
	        	'name' => 'Segments',
	        	'slug' => 'segments',
	        	'type' => 'module-menu',
				'icon' => 'icon-cursor',
				'parent' => null,
				'description' => 'Module Menu',
				'guard_name' => 'web',
				'created_at' => date("Y-m-d H:i:s"),
				'updated_at' => date("Y-m-d H:i:s")
			],
   //          [
	  //       	'name' => 'Hot deals',
	  //       	'slug' => 'hot-deals',
	  //       	'type' => 'module-menu',
			// 	'icon' => 'icon-cursor',
			// 	'parent' => null,
			// 	'description' => 'Module Menu',
			// 	'guard_name' => 'web',
			// 	'created_at' => date("Y-m-d H:i:s"),
			// 	'updated_at' => date("Y-m-d H:i:s")
			// ],
   //          [
	  //       	'name' => 'Best choice',
	  //       	'slug' => 'best-choice',
	  //       	'type' => 'module-menu',
			// 	'icon' => 'icon-cursor',
			// 	'parent' => null,
			// 	'description' => 'Module Menu',
			// 	'guard_name' => 'web',
			// 	'created_at' => date("Y-m-d H:i:s"),
			// 	'updated_at' => date("Y-m-d H:i:s")
			// ],
        ]);
        
        $parent = DB::table('permissions')->where('name','Master-Home')->first();
		DB::table('permissions')->whereIn('slug', ['slider','brands'])
			->update(['parent' => (string)$parent['_id']]);
		
		$parent = DB::table('permissions')->where('name','User Management')->first();
		DB::table('permissions')->whereIn('slug', ['permission', 'role', 'master-user'])
            ->update(['parent' => (string)$parent['_id']]);

        $parent = DB::table('permissions')->where('name','Master Member')->first();
        DB::table('permissions')->whereIn('slug', ['master-member','level','saldo-member', 'company-member'/*,'archievement'*/])
            ->update(['parent' => (string)$parent['_id']]);
        
        $parent = DB::table('permissions')->where('name','Product Management')->first();
        DB::table('permissions')->whereIn('slug', ['product','attributes','attribute-sets','category','variant','taxes'])
            ->update(['parent' => (string)$parent['_id']]);

		$parent = DB::table('permissions')->where('name','Master Deal')->first();
		DB::table('permissions')->whereIn('slug', ['discount','promo', 'segments', 'hot-deals', 'best-choice'])
			->update(['parent' => (string)$parent['_id']]);

		// $parent = DB::table('permissions')->where('name','Orders Management')->first();
		// DB::table('permissions')->whereIn('slug', ['orderstatuses','orders'])
		// 	->update(['parent' => (string)$parent['_id']]);

		$parent = DB::table('permissions')->where('name','Payment')->first();
		DB::table('permissions')->whereIn('slug', ['payment','payment-method','paymentpo'])
			->update(['parent' => (string)$parent['_id']]);

		$parent = DB::table('permissions')->where('name','Deliveries')->first();
		DB::table('permissions')->whereIn('slug', ['deliveries','courier'])
			->update(['parent' => (string)$parent['_id']]);
        
        $parent = DB::table('permissions')->where('name','B2B selling')->first();
        DB::table('permissions')->whereIn('slug', ['pending-po','orders-b2b'])
            ->update(['parent' => (string)$parent['_id']]);
        
        $parent = DB::table('permissions')->where('name','B2C selling')->first();
        DB::table('permissions')->whereIn('slug', ['orders'])
            ->update(['parent' => (string)$parent['_id']]);
    }
}
