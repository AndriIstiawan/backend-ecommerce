<?php

use Illuminate\Database\Seeder;

class FootersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('footers')->truncate();
        DB::table('footers')->insert([
        	[
	            'left' => [[
                    'title' => 'HOKY',
                    'list' => [
                        [
                            'type' => 'Link',
                            'link' => 'About Us',
                            'url' => 'http://103.82.241.18/about-us'
                        ],
                        [
                            'type' => 'Link',
                            'link' => 'Blog',
                            'url' => 'http://103.82.241.18/blog'
                        ],
                        [
                            'type' => 'Link',
                            'link' => 'Our Value',
                            'url' => 'http://103.82.241.18/our-value'
                        ],
                        [
                            'type' => 'Link',
                            'link' => 'Term and Condition',
                            'url' => 'http://103.82.241.18/term-and-condition'
                        ],
                        [
                            'type' => 'Link',
                            'link' => 'Career',
                            'url' => 'http://103.82.241.18/career'
                        ],
                    ],
                ]],
                'middle' => [[
                    'title' => 'Our Location',
                    'list' => [
                        [
                            'type' => 'Text',
                            'text' => 'Komplek Ruko Glodok Jaya No. 11, Jl. Hayam Wuruk, RT.1/RW.6, Mangga Besar, Tamansari, Kota Jakarta Barat, Daerah Khusus Ibukota Jakarta 11180',
                        ],
                        [
                            'type' => 'Title',
                            'title' => 'Opening Hours:',
                        ],
                        [
                            'type' => 'Text',
                            'text' => 'Monday - Friday',
                        ],
                        [
                            'type' => 'Text',
                            'text' => '08:00 - 17:00',
                        ],
                    ],
                ]],
                'right' => [[
                    'title' => 'Contact Us',
                    'list' => [
                        [
                            'type' => 'Icon Text',
                            'icon' => 'phone',
                            'text' => '(021) 2939123',
                        ],
                        [
                            'type' => 'Icon Text',
                            'icon' => 'email',
                            'text' => 'info@hoky.com',
                        ],
                    ],
                ]],
	            'created_at' => date("Y-m-d H:i:s"),
				'updated_at' => date("Y-m-d H:i:s")
			]
        ]);
    }
}
