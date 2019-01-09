<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use App\Product;

class ProductUpdatePrice implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $product = Product::find($this->id);
        $price = $product->price;
        if(isset($product->variant)){
            if(count($product->variant)>0){
                $product_variant = $product->variant;
                $price_min = 0;
                $price_max = 0;
                for ($i=0; $i < count($product_variant); $i++) {
                    if($price_min == 0){
                        $price_min = $product_variant[$i]['price'];
                        $price_max = $product_variant[$i]['price'];
                    }
                    if($product_variant[$i]['price'] < $price_min){
                        $price_min = $product_variant[$i]['price'];
                    }
                    if($product_variant[$i]['price'] > $price_max){
                        $price_max = $product_variant[$i]['price'];
                    }
                }
                $price = [[
                    'min' => $price_min,
                    'max' => $price_max,
                    'tax_include' => (isset($price[0]['tax_include'])?$price[0]['tax_include']:'yes'),
                ]];
            }
        }
        $product->price = $price;
        $product->save();
    }
}
