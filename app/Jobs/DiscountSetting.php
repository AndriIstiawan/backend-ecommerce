<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Discounts;
use App\Product;

class DiscountSetting implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $action;
    protected $id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($action, $id)
    {
        $this->action = $action;
        $this->id = $id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $discount = Discounts::find($this->id);
        $products = Product::where('_id', '<>', $this->id);
        $discount->status = ($this->action == 'start'?'on':'off');
        $discount->save();

        if(count($discount->brands) > 0){
            $brands = array_column($discount->brands, '_id');
            $products = $products->whereIn('brand._id', $brands );
        }
        if(count($discount->categories) > 0){
            $categories = array_column($discount->categories, '_id');
            $products = $products->whereIn('categories._id', $categories );
        }
        if(count($discount->products) > 0){
            $discount_products = array_column($discount->products, '_id');
            $products = $products->whereIn('_id', $discount_products );
        }

        if($this->action == 'start'){
            $products_update = $products->push('discounts', $discount->toArray());
            if(count($discount->levels) == 0 && count($discount->members) == 0){
                if($discount->type == 'price'){
                    $products_update = $products->increment('discount_price', $discount->value);
                }else{
                    $products_update = $products->increment('discount_percent', $discount->value);
                }
            }
        }else{
            $products_update = $products->pull('discounts', ['_id' => $this->id]);
            if(count($discount->levels) == 0 && count($discount->members) == 0){
                if($discount->type == 'price'){
                    $products_update = $products->decrement('discount_price', $discount->value);
                }else{
                    $products_update = $products->decrement('discount_percent', $discount->value);
                }
            }
        }

    }//end handle()
}
