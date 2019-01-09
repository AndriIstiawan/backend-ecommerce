<?php

namespace App\Http\Controllers\DiscountManagement;

use App\Discounts;
use App\Http\Controllers\Controller;
use Excel;
use Illuminate\Http\Request;

class ExportDiscountController extends Controller
{
    //Protected module product by slug
    public function __construct()
    {
        $this->middleware('perm.acc:discount');
    }

    //public index export discount
    public function index(Request $request)
    {
        $discounts = Discounts::all();
        $this->exportData($discounts);
    }

    public function export_selected(Request $request)
    {
        $this->exportData(Discounts::whereIn('_id', $request->id)->get());
    }

    //export data
    public function exportData($discounts)
    {
        //target in public
        $file = public_path() . "/files/discount/discount-form-import.xlsx";
        //load excel form and editing row
        $excel = Excel::selectSheetsByIndex(0)->load($file, function ($reader) use ($discounts) {
            $discount_brands = [];
            $discount_categories = [];
            $discount_products = [];
            $discount_levels = [];
            $discount_members = [];
            $data = [];
            foreach ($discounts as $discount) {
                $data[] = [
                    $discount->title,
                    $discount->key_id,
                    $discount->value,
                    $discount->type,
                    $discount->expired_date,
                    $discount->status,
                    $discount->description,
                    "created at : " . $discount->created_at
                ];

                $discount_key = $discount->key_id;
                //set discount brand
                $discount_brands_sub = array_map(function ($x) use ($discount_key){
                    return [$discount_key, $x['slug'], 'add'];
                },$discount->brands);
                $discount_brands = array_merge($discount_brands, $discount_brands_sub);
                //set discount category
                $discount_categories_sub = array_map(function ($x) use ($discount_key){
                    return [$discount_key, $x['slug'], 'add'];
                },$discount->categories);
                $discount_categories = array_merge($discount_categories, $discount_categories_sub);
                //set discount products
                $discount_products_sub = array_map(function ($x) use ($discount_key){
                    return [$discount_key, $x['sku'], 'add'];
                },$discount->products);
                $discount_products = array_merge($discount_products, $discount_products_sub);
                //set discount levels
                $discount_levels_sub = array_map(function ($x) use ($discount_key){
                    return [$discount_key, $x['key_id'], 'add'];
                },$discount->levels);
                $discount_levels = array_merge($discount_levels, $discount_levels_sub);
                //set discount members
                $discount_members_sub = array_map(function ($x) use ($discount_key){
                    return [$discount_key, $x['email'], 'add'];
                },$discount->members);
                $discount_members = array_merge($discount_members, $discount_members_sub);
            }
            //editing sheet 1
            $reader->setActiveSheetIndex(0);
            $sheet1 = $reader->getActiveSheet();
            $sheet1->fromArray($data, null, 'A6', false, false);
            //set autosize width cell
            foreach(range('A','H') as $columnID){
                $sheet1->getColumnDimension($columnID)->setAutoSize(true);
            }

            //editing sheet 2
            $reader->setActiveSheetIndex(1);
            $sheet1 = $reader->getActiveSheet();
            $sheet1->fromArray($discount_brands, null, 'A6', false, false);
            //editing sheet 3
            $reader->setActiveSheetIndex(2);
            $sheet1 = $reader->getActiveSheet();
            $sheet1->fromArray($discount_categories, null, 'A6', false, false);
            //editing sheet 4
            $reader->setActiveSheetIndex(3);
            $sheet1 = $reader->getActiveSheet();
            $sheet1->fromArray($discount_products, null, 'A6', false, false);
            //editing sheet 5
            $reader->setActiveSheetIndex(4);
            $sheet1 = $reader->getActiveSheet();
            $sheet1->fromArray($discount_levels, null, 'A6', false, false);
            //editing sheet 6
            $reader->setActiveSheetIndex(5);
            $sheet1 = $reader->getActiveSheet();
            $sheet1->fromArray($discount_members, null, 'A6', false, false);
            
            //set autosize width cell
            for ($i=1; $i < 6; $i++) { 
                $reader->setActiveSheetIndex($i);
                $sheet1 = $reader->getActiveSheet();
                foreach(range('A','C') as $columnID){
                    $sheet1->getColumnDimension($columnID)->setAutoSize(true);
                }
            }
        })->setFilename('discount-form-export[' . date("H-i-s d-m-Y") . "]")->download('xlsx');
    }
}