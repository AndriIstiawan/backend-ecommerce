<?php

namespace App\Http\Controllers\ProductManagement;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Box\Spout\Reader\ReaderFactory;
use Box\Spout\Writer\WriterFactory;
use Box\Spout\Common\Type;

use App\Jobs\ProductImageUpload;
use App\Jobs\ProductUpdatePrice;
use App\Brand;
use App\Categories;
use App\Product;
use Auth;
use Image;
use File;

class ImportProductController extends Controller
{
    //Protected module product by slug
    public function __construct()
    {
        $this->middleware('perm.acc:product');
    }

    //public index import product
    public function index()
    {
        return view('panel.product-management.product.import-panel.index');
    }

    //public index import product
    public function importData(Request $request)
    {
        $file = $request->file('import');
        $filename = 'product-log-import['.date("H-i-s d-m-Y")."][".Auth::user()->email."].xlsx";
        $file->move(storage_path('exports'), $filename);

        $reader = ReaderFactory::create(Type::XLSX); // for XLSX files
        $reader->open(storage_path('exports/'.$filename));
        $sheet1[] = ['Product Name', 'SKU', 'Brand', 'Category', 'Price [MIN]', 'Price [MAX]', 'Include Tax', 'Product Stock',
            'Product Description', 'Weight [UNIT]', 'Weight [VALUE]', 'Main Image [URL]', 'log status'];
        $sheet2[] = ['Product SKU', 'Variant Key Name', 'Image Variant [URL]', 'Price', 'SKU', 'Stock', 'Action', 'log status'];

        // loop semua sheet dan dapatkan sheet orders
        foreach ($reader->getSheetIterator() as $sheet) {
            if ($sheet->getName() === 'Product') {
                $i = 0;
                $total_valid_row = 0;
                $total_invalid_row = 0;
                $total_product_create = 0;
                $total_product_update = 0;
                $total_product_proccess_invalid = 0;
                foreach ($sheet->getRowIterator() as $idx) {
                    $i++;
                    if($i > 5){
                        $statusValidasi = $this->validasiDataRow($idx);
                        $data_feedback = $statusValidasi['data'];
                        
                        //jika valid baru masukkan data
                        if($statusValidasi['status']){
                            $total_valid_row++;
                            $product = Product::where('sku', (string)trim($idx[1]))->first();
                            if(isset($product->id)){
                                for ($jx=0; $jx < count($product->image); $jx++) { 
                                    if(!$product->image[$jx]['upload_image']){
                                        File::delete(public_path('/img/products/' . $product->image[$jx]['filename']));
                                    }
                                }
                                $product_status = 'update';
                            }else{
                                $product_status = 'create';
                                $product = new Product();
                            }

                            $product->name = $idx[0];
                            $image_url = explode('|', trim($idx[11]));
                            $image_list = array_map(function ($x){
                                return [
                                    'filename' => $x,
                                    'size' => 0,
                                    'upload_image' => true
                                ];
                            },$image_url);

                            $product->image = $image_list;
                            $product->sku = (string) trim($idx[1]);
                            $product->brand = Brand::where('slug', str_slug($idx[2]))->get()->toArray();
                            $categories = [];
                            $parent_slug = $idx[3];
                            do {
                                $category = Categories::where('slug', str_slug($parent_slug))->first();
                                if($category){
                                    array_push($categories, $category->toArray());
                                    $parent_slug = (isset($category->parent[0]['slug'])?$category->parent[0]['slug']:"");
                                }else{
                                    $parent_slug = "";
                                }
                            } while ($parent_slug != "");

                            $product->categories = $categories;
                            $product->price = [[
                                'min' => (double)trim($idx[4]),
                                'max' => (trim($idx[5])!= ''?(double)trim($idx[5]):(double)trim($idx[4])),
                                'tax_include' => strtolower(trim($idx[6])),
                            ]];
                            $product->stock = (trim($idx[7])!= ''?(double)trim($idx[7]):0);
                            $product->description = trim($idx[8]);
                            $product->weight = [[
                                'unit' => strtolower(trim($idx[9])),
                                'weight' => (double)trim($idx[10]),
                            ]];
                            $exec = $product->save();
                            if($exec){
                                if($product_status == 'update'){
                                    $total_product_update++;
                                    $data_feedback[] = 'Update product successfully [image upload to storage progress]';
                                }else{
                                    $total_product_create++;
                                    $data_feedback[] = 'Create product successfully [image upload to storage progress]';
                                }
                            }else{
                                $total_product_proccess_invalid++;
                                $data_feedback[] = 'product process invalid';
                            }
                            // $this->dispatch(new ProductImageUpload('main-image', $product->id));
                        }else{
                            $total_invalid_row++;
                        }
                        $sheet1[] = $data_feedback;
                    }
                }
                $sheet1[] = [' '];
                $sheet1[] = ['total row : '.($total_valid_row+$total_invalid_row)];
                $sheet1[] = ['total valid data row : '.$total_valid_row];
                $sheet1[] = ['total invalid data row : '.$total_invalid_row];
                $sheet1[] = ['total product process : '.($total_product_create+$total_product_update+$total_product_proccess_invalid)];
                $sheet1[] = ['total product create  : '.$total_product_create];
                $sheet1[] = ['total product update  : '.$total_product_update];
                $sheet1[] = ['total product invalid proccess  : '.$total_product_proccess_invalid];
            }

            if ($sheet->getName() === 'Variation') {
                $i = 0;
                $total_valid_row = 0;
                $total_invalid_row = 0;
                $total_variant_proccess_valid = 0;
                $total_variant_proccess_invalid = 0;
                foreach ($sheet->getRowIterator() as $idx) {
                    $i++;
                    if($i > 5){
                        $statusValidasi = $this->validasiDataRow2($idx);
                        $data_feedback = $statusValidasi['data'];

                        //jika valid baru masukkan data
                        if($statusValidasi['status']){
                            $total_valid_row++;
                            $total_variant_proccess_valid++;
                            $product = Product::where('sku', (string)trim($idx[0]))->first();
                            $variant_status = 'Remove variant successfully';
                            if(isset($product->variant)){
                                $image_remove = array_map(function ($x) use ($idx){
                                    if($x['key'] == trim($idx[1]) && !$x['upload_image']){
                                        if($x['image'] != ''){
                                            File::delete(public_path('/img/products/' . $x['image']));
                                        }
                                    }
                                },$product->variant);
                                //remove variant
                                $product_pull = Product::where('sku', (string)trim($idx[0]))->pull('variant', ['key' => (string)trim($idx[1])]);
                            }else{
                                $product->variant = [];
                                $product->save();
                            }

                            if(strtolower($idx[6]) == 'add'){
                                $variant_add = [
                                    'key' => (string)trim($idx[1]),
                                    'image' => (string)trim($idx[2]),
                                    'upload_image' => (trim($idx[2])!= ''?true:false),
                                    'price' => (double)trim($idx[3]),
                                    'sku' => (string)trim($idx[4]),
                                    'stock' => (trim($idx[5])!= ''?(double)trim($idx[5]):0)
                                ];
                                $variant_status = 'Add variant successfully';
                                //remove variant
                                $product_push = Product::where('sku', (string)trim($idx[0]))->push('variant', $variant_add);
                                if(!$product_push){
                                    $total_variant_proccess_invalid++;
                                    $total_variant_proccess_valid--;
                                    $variant_status = 'variant process invalid';
                                }else{
                                    $this->dispatch(new ProductUpdatePrice($product->id));
                                    if(trim($idx[2])!= ''){
                                        // $this->dispatch(new ProductImageUpload('variant-image', $product->id));
                                    }
                                }
                            }
                            $data_feedback[] = $variant_status;
                        }else{
                            $total_invalid_row++;
                        }
                        $sheet2[] = $data_feedback;
                    }
                }
                $sheet2[] = [' '];
                $sheet2[] = ['total row : '.($total_valid_row+$total_invalid_row)];
                $sheet2[] = ['total valid data row : '.$total_valid_row];
                $sheet2[] = ['total invalid data row : '.$total_invalid_row];
                $sheet2[] = ['total variant success process : '.$total_variant_proccess_valid];
                $sheet2[] = ['total variant invalid proccess  : '.$total_variant_proccess_invalid];
            }
        }
        $reader->close();

        $writer = WriterFactory::create(Type::XLSX); // for XLSX files
        $writer->openToFile(storage_path('exports/'.$filename)); // stream data directly to the browser
        $firstSheet = $writer->getCurrentSheet();
        $writer->addRows($sheet1);
        $newSheet = $writer->addNewSheetAndMakeItCurrent();
        $writer->addRows($sheet2);
        $writer->close();
        return $filename;
    }

    //validasi data
    public function validasiDataRow($idx){
        $data = [$idx[0], $idx[1], $idx[2], $idx[3], $idx[4], $idx[5], $idx[6], $idx[7], $idx[8], $idx[9], $idx[10], $idx[11]];
        $msg = '';
        $statusValidasi = false;

        //validasi empty value
        if(trim($idx[0]) == ''||trim($idx[1]) == ''||trim($idx[2]) == ''||trim($idx[3]) == ''||trim($idx[4]) == ''
        ||trim($idx[6]) == ''||trim($idx[8]) == ''||trim($idx[9]) == ''||trim($idx[10]) == ''||trim($idx[11]) == ''){
            $msg = '[ rows require is empty ]';
        }

        //validasi number
        if(!(double)trim($idx[4])){ $msg .= '[ price min value not valid ]'; }
        if(!(double)trim($idx[5])&&trim($idx[5])!=''){ $msg .= '[ price max value not valid ]'; }
        if(!(double)trim($idx[7])&&trim($idx[7])!=''){ $msg .= '[ product stock value not valid ]'; }
        if(!(double)trim($idx[10])&&trim($idx[10])!=''){ $msg .= '[ weight value not valid ]'; }

        //validasi include tax and weight unit
        if(strtolower(trim($idx[6])) != 'yes'&&strtolower(trim($idx[6])) != 'no'){ $msg .= '[ include tax set not valid ]'; }
        if(strtolower(trim($idx[9])) != 'g'&&strtolower(trim($idx[9])) != 'kg'&&trim($idx[9])!=''){ $msg .= '[ weight unit set not valid ]'; }

        //validasi brand and category
        if(!$this->validasi_brand($idx[2])){ $msg .= '[ brand key not found ]'; }
        if(!$this->validasi_category($idx[3])){ $msg .= '[ category slug not found ]'; }

        //validasi image
        $validasi_image = $this->validasi_image($idx[11]);
        if(!$validasi_image['status']){
            $msg .= $validasi_image['msg'];
        }

        if($msg == ''){
            $statusValidasi = true;
        }else{
            $data[] = $msg;
        }
        return ['status' => $statusValidasi, 'data' => $data];
    }

    //validasi data
    public function validasiDataRow2($idx){
        $data = [$idx[0], $idx[1], $idx[2], $idx[3], $idx[4], $idx[5], $idx[6]];
        $msg = '';
        $statusValidasi = false;

        //validasi empty value
        if(trim($idx[0]) == ''||trim($idx[1]) == ''||trim($idx[3]) == ''||trim($idx[4]) == ''||trim($idx[6]) == ''){
            $msg = '[ rows require is empty ]';
        }

        //validasi number
        if(!(double)trim($idx[3])&&trim($idx[3])!=''){ $msg .= '[ price value not valid ]'; }
        if(!(double)trim($idx[5])&&trim($idx[5])!=''){ $msg .= '[ stock value not valid ]'; }

        //validasi action
        if(strtolower(trim($idx[6])) != 'add'&&strtolower(trim($idx[6])) != 'remove'){ $msg .= '[ action set not valid ]'; }

        //validasi image
        if(trim($idx[2]) != ''){
            $validasi_image = $this->validasi_image($idx[2]);
            if(!$validasi_image['status']){
                $msg .= $validasi_image['msg'];
            }
        }

        //validasi product sku
        if(!$this->validasi_sku($idx[0])){ $msg .= '[ product sku not found ]'; }

        if($msg == ''){
            $statusValidasi = true;
        }else{
            $data[] = $msg;
        }
        return ['status' => $statusValidasi, 'data' => $data];
    }

    //validasi product sku
    public function validasi_sku($product_sku){
        $product = Product::where('sku', trim($product_sku))->first();
        if(!$product){
            return false;
        }else{
            return true;
        }
    }

    //validasi brands
    public function validasi_brand($brand_slug){
        $brand = Brand::where('slug', str_slug($brand_slug))->first();
        if(!$brand){
            return false;
        }else{
            return true;
        }
    }

    //validasi brands
    public function validasi_category($category_slug){
        $category = Categories::where('slug', str_slug($category_slug))->first();
        if(!$category){
            return false;
        }else{
            return true;
        }
    }

    //validasi image
    public function validasi_image($image_url){
        $msg = '';
        $statusImage = false;
        $image_url = explode('|', trim($image_url));
        for ($i=0; $i < count($image_url); $i++) {
            if (!preg_match('/\.(jpeg|jpg|png|gif)$/i', $image_url[$i])) {
                $msg .= '[ image extension not valid ]';
            }
            if(strpos($image_url[$i], 'https://') === false && strpos($image_url[$i], 'http://') === false ){
                $msg .= '[ image url not valid ]';
            }
        }

        if($msg == ''){
            $statusImage = true;
        }
        return ['status' => $statusImage, 'msg' => $msg];
    }
}
