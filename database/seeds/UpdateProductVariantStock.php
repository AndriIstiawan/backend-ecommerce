<?php

use Illuminate\Database\Seeder;

class UpdateProductVariantStock extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = DB::table('products')->get()->toArray();
        $products_update = array_map(function ($product){
            if(isset($product['variant'])){
                $variant = array_map(function ($variant){
                    return array(
                        'key' => $variant['key'],
                        'image' => $variant['image'],
                        'upload_image' => false,
                        'price' => $variant['price'],
                        'sku' => $variant['sku'],
                        'stock' => (isset($variant['varStock'])?$variant['varStock']:0),
                    );
                },$product['variant']);
                //update tax product
                $price = [[
                    "min" => (isset($product['price'][0]['min'])?$product['price'][0]['min']:0),
                    "max" => (isset($product['price'][0]['max'])?$product['price'][0]['max']:0),
                    "tax_include" => (isset($product['price'][0]['tax_include'])?$product['price'][0]['tax_include']:'yes')
                ]];

                if(isset($product['image'])){
                    $main_image = array_map(function ($main_image){
                        return array(
                            'filename' => $main_image['filename'],
                            'size' => $main_image['size'],
                            'upload_image' => (isset($main_image['upload_image'])?$main_image['upload_image']:false)
                        );
                    },$product['image']);
                }
                DB::table('products')->where('_id', $product['_id'])->update(['variant' => $variant, 'image' => $main_image, 'price' => $price]);
            }
        },$products);
    }
}
