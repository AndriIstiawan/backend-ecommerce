<?php

namespace App\Http\Controllers\DiscountManagement;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Promo;
use App\Images;
use File;
use Excel;

class ExportPromoController extends Controller
{
    //Protected module product by slug
    public function __construct()
    {
        $this->middleware('perm.acc:promo');
    }
    
    //public index export promo
    public function index(Request $request)
    {
        $promos = Promo::all();
        $this->exportData($promos);
    }

    public function export_selected(Request $request)
    {
        $this->exportData(Promo::whereIn('_id', $request->id)->get());
    }

    //export data
    public function exportData($promos)
    {
        //target in public
        $file = public_path(). "/files/promos/promos-form-import.xlsx";
        $folder = public_path('/img/promos/');
        $destPath = public_path('/img/storage/');
        $list_image = $promos->pluck('image')->toArray();
        Images::whereIn('filename', $list_image)->delete();
        
        //load excel form and editing row
        $excel = Excel::selectSheetsByIndex(0)->load($file, function($reader) use ($promos,$folder,$destPath) {
            //define data empty
            $dataImage = [];
            $data = [];
            $promo_levels = [];
            $promo_members = [];
            $promo_brands = [];
            $promo_categories = [];
            $promo_products = [];
            $promo_couriers = [];
            foreach($promos as $promo){
                //remove uploaded image in storage
                $filename = $folder.$promo->image;
                $destination = $destPath.$promo->image;
                if(File::exists($destination)) { File::delete($destination); }
                File::copy($filename,$destination);
                $promo_key = $promo->code;
                $data[] = [
                    $promo->title, 
                    $promo->code,
                    url('/img/storage/'.$promo->image),
                    $promo->value,
                    $promo->type,
                    $promo->expired_date,
                    $promo->target[0]['target'],
                    $promo->content_html,
                    "created at : ".$promo->created_at
                ];
                $dataImage[] = [
                    'filename' => $promo->image,
                    'size' => 0,
                    'destination' => '/img/storage',
                    'updated_at' => date("Y-m-d H:i:s"),
                    'created_at' => date("Y-m-d H:i:s")
                ];

                //set promo levels
                $promo_levels_sub = array_map(function ($x) use ($promo_key){
                    return [$promo_key, $x['key_id'], 'add'];
                },$promo->levels);
                $promo_levels = array_merge($promo_levels, $promo_levels_sub);
                //set promo members
                $promo_members_sub = array_map(function ($x) use ($promo_key){
                    return [$promo_key, $x['email'], 'add'];
                },$promo->members);
                $promo_members = array_merge($promo_members, $promo_members_sub);
                if($promo->target[0]['target'] == 'product'){
                    //set promo brand
                    $promo_brands_sub = array_map(function ($x) use ($promo_key){
                        return [$promo_key, $x['slug'], 'add'];
                    },$promo->target[0]['brands']);
                    $promo_brands = array_merge($promo_brands, $promo_brands_sub);
                    //set promo category
                    $promo_categories_sub = array_map(function ($x) use ($promo_key){
                        return [$promo_key, $x['slug'], 'add'];
                    },$promo->target[0]['categories']);
                    $promo_categories = array_merge($promo_categories, $promo_categories_sub);
                    //set promo products
                    $promo_products_sub = array_map(function ($x) use ($promo_key){
                        return [$promo_key, $x['sku'], 'add'];
                    },$promo->target[0]['products']);
                    $promo_products = array_merge($promo_products, $promo_products_sub);
                }
                if($promo->target[0]['target'] == 'courier'){
                    //set promo courier
                    $promo_couriers_sub = array_map(function ($x) use ($promo_key){
                        return [$promo_key, $x['slug'], 'add'];
                    },$promo->target[0]['couriers']);
                    $promo_couriers = array_merge($promo_couriers, $promo_couriers_sub);
                }
            }
            //editing sheet 1
            $reader->setActiveSheetIndex(0);
            $sheet1 = $reader->getActiveSheet();
            $sheet1->fromArray($data, null, 'A6', false, false);
            //set autosize width cell
            foreach(range('A','I') as $columnID){
                $sheet1->getColumnDimension($columnID)->setAutoSize(true);
            }

            //editing sheet 2
            $reader->setActiveSheetIndex(1);
            $sheet1 = $reader->getActiveSheet();
            $sheet1->fromArray($promo_levels, null, 'A6', false, false);
            //editing sheet 3
            $reader->setActiveSheetIndex(2);
            $sheet1 = $reader->getActiveSheet();
            $sheet1->fromArray($promo_members, null, 'A6', false, false);
            //editing sheet 4
            $reader->setActiveSheetIndex(3);
            $sheet1 = $reader->getActiveSheet();
            $sheet1->fromArray($promo_brands, null, 'A6', false, false);
            //editing sheet 5
            $reader->setActiveSheetIndex(4);
            $sheet1 = $reader->getActiveSheet();
            $sheet1->fromArray($promo_categories, null, 'A6', false, false);
            //editing sheet 6
            $reader->setActiveSheetIndex(5);
            $sheet1 = $reader->getActiveSheet();
            $sheet1->fromArray($promo_products, null, 'A6', false, false);
            //editing sheet 7
            $reader->setActiveSheetIndex(6);
            $sheet1 = $reader->getActiveSheet();
            $sheet1->fromArray($promo_couriers, null, 'A6', false, false);
            //set autosize width cell
            for ($i=1; $i < 7; $i++) { 
                $reader->setActiveSheetIndex($i);
                $sheet1 = $reader->getActiveSheet();
                foreach(range('A','C') as $columnID){
                    $sheet1->getColumnDimension($columnID)->setAutoSize(true);
                }
            }

            Images::insert($dataImage);
        })->setFilename('promos-form-export['.date("H-i-s d-m-Y")."]")->download('xlsx');
    }
}
