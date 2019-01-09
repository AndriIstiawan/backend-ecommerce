<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use App\Jobs\ProductImageUpload;
use App\Product;
use Image;

class ProductImageUpload implements ShouldQueue
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
        $product = Product::find($this->id);
        if($this->action == 'main-image'){
            $key = array_keys(array_column($product->image, 'upload_image'), true);

            if($key){
                $image_list = $product->image;
                $uploaded_file = file_get_contents($image_list[$key[0]]['filename']);

                if($uploaded_file){
                    $extension = pathinfo($image_list[$key[0]]['filename'])['extension'];
                    $destinationPath = public_path('/img/products/['.$key[0].']'.$product->id.'.'.$extension);
                    $image_store  = Image::make($image_list[$key[0]]['filename'])->fit(300)->save($destinationPath);

                    if($image_store){
                        $size = $image_store->filesize();
                        $image_list[$key[0]] = [
                            'filename' => '['.$key[0].']'.$product->id.'.'.$extension,
                            'size' => $size,
                            'upload_image' => false,
                        ];
                        $product->image = $image_list;
                        $product->save();
                        $this->dispatch(new ProductImageUpload('main-image', $product->id));
                    }
                    
                }
            }
        }else{
            $key = array_keys(array_column($product->variant, 'upload_image'), true);
            if($key){
                $variant_list = $product->variant;
                $uploaded_file = file_get_contents($variant_list[$key[0]]['image']);

                if($uploaded_file){
                    $extension = pathinfo($variant_list[$key[0]]['image'])['extension'];
                    $destinationPath = public_path('/img/products/['.$product->id.']'.$variant_list[$key[0]]['key'].'.'.$extension);
                    $image_store  = Image::make($variant_list[$key[0]]['image'])->fit(300)->save($destinationPath);

                    if($image_store){
                        $variant_list[$key[0]] = [
                            'key' => $variant_list[$key[0]]['key'],
                            'image' => '['.$product->id.']'.$variant_list[$key[0]]['key'].'.'.$extension,
                            'upload_image' => false,
                            'price' => (double)$variant_list[$key[0]]['price'],
                            'sku' => $variant_list[$key[0]]['sku'],
                            'stock' => (double)$variant_list[$key[0]]['stock']
                        ];
                        $product->variant = $variant_list;
                        $product->save();
                        $this->dispatch(new ProductImageUpload('variant-image', $product->id));
                    }
                }
            }
        }
    }
}
