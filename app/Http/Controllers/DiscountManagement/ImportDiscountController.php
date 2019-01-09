<?php

namespace App\Http\Controllers\DiscountManagement;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Box\Spout\Reader\ReaderFactory;
use Box\Spout\Writer\WriterFactory;
use Box\Spout\Common\Type;
use App\Jobs\DiscountSetting;
use App\Discounts;
use App\Brand;
use App\Categories;
use App\Product;
use App\Levels;
use App\Member;
use App\Jobs;
use Auth;

class ImportDiscountController extends Controller
{
    //Protected module product by slug
    public function __construct()
    {
        $this->middleware('perm.acc:discount');
    }

    //public index export discount
    public function index()
    {
        return view('panel.master-deal.discount.form-import');
    }

    //download import form
    public function downloadImportForm(){
        $file= public_path(). "/files/discount/discount-form-import.xlsx";
        return response()->download($file);
    }

    //public index import product
    public function importData(Request $request)
    {
        $file = $request->file('import');
        $filename = 'discount-log-import['.date("H-i-s d-m-Y")."][".Auth::user()->email."].xlsx";
        $file->move(storage_path('exports'), $filename);

        $reader = ReaderFactory::create(Type::XLSX); // for XLSX files
        $reader->open(storage_path('exports/'.$filename));
        $sheet1[] = [
            'discount title', 
            'discount [key id]', 
            'discount [value]', 
            'discount [type]', 
            'expired date', 
            'status discount', 
            'description',
            'log status'
        ];
        $sheet2[] = ['slug', 'parent slug', 'action', 'log status'];
        $sheet3[] = ['slug', 'parent slug', 'action', 'log status'];
        $sheet4[] = ['slug', 'parent slug', 'action', 'log status'];
        $sheet5[] = ['slug', 'parent slug', 'action', 'log status'];
        $sheet6[] = ['slug', 'parent slug', 'action', 'log status'];

        // loop semua sheet dan dapatkan sheet orders
        foreach ($reader->getSheetIterator() as $sheet) {
            if ($sheet->getName() === 'Discount') {
                $i = 0;
                $total_valid_row = 0;
                $total_invalid_row = 0;
                $total_discount_create = 0;
                $total_discount_update = 0;
                $total_discount_proccess_invalid = 0;
                foreach ($sheet->getRowIterator() as $idx) {
                    $i++;
                    if($i > 5){
                        $statusValidasi = $this->validasiDataRow($idx);
                        $data_feedback = $statusValidasi['data'];
                        //jika valid baru masukkan data
                        if($statusValidasi['status']){
                            $total_valid_row++;
                            $discount = Discounts::where('key_id', (string)trim($idx[1]))->first();
                            if(isset($discount->id)){
                                if($discount->status == 'on'){
                                    $this->discount_setting($discount->id, 'false');
                                }
                                $discount_status = 'update';
                            }else{
                                $discount_status = 'create';
                                $discount = new Discounts();
                            }

                            $discount->title = trim($idx[0]);
                            $discount->description = trim($idx[6]);
                            $discount->status = trim($idx[5]);
                            $discount->value = (double)trim($idx[2]);
                            $discount->type = trim($idx[3]);
                            $discount->expired_date = trim($idx[4]);
                            $discount->brands = [];
                            $discount->categories = [];
                            $discount->products = [];
                            $discount->levels = [];
                            $discount->members = [];
                            $exec = $discount->save();

                            if($exec){
                                if($discount->status == 'on'){
                                    $this->discount_setting($discount->id, 'true');
                                }
                                if($discount_status == 'update'){
                                    $total_discount_update++;
                                    $data_feedback[] = 'Update discount successfully';
                                }else{
                                    $total_discount_create++;
                                    $data_feedback[] = 'Create discount successfully';
                                }
                            }else{
                                $total_discount_proccess_invalid++;
                                $data_feedback[] = 'discount process invalid';
                            }

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
                $sheet1[] = ['total discount process : '.($total_discount_create+$total_discount_update+$total_discount_proccess_invalid)];
                $sheet1[] = ['total product create  : '.$total_discount_create];
                $sheet1[] = ['total product update  : '.$total_discount_update];
                $sheet1[] = ['total product invalid proccess  : '.$total_discount_proccess_invalid];
            }
            if ($sheet->getName() === 'Discount by Brand'||$sheet->getName() === 'Discount by Category'||$sheet->getName() === 'Discount by Product'
            ||$sheet->getName() === 'Discount by Level'||$sheet->getName() === 'Discount by Member') {
                $i = 0;
                $total_valid_row = 0;
                $total_invalid_row = 0;
                $total_collection_create = 0;
                $total_collection_update = 0;
                $sheet_collection = [];
                foreach ($sheet->getRowIterator() as $idx) {
                    $i++;
                    if($i > 5){
                        $statusValidasi = $this->validasiDataRow2($idx, $sheet->getName());
                        $data_feedback = $statusValidasi['data'];

                        if($statusValidasi['status']){
                            $total_valid_row++;
                            $data_feedback[] = 'next steep';
                        }else{
                            $total_invalid_row++;
                        }
                        $sheet_collection[] = $data_feedback;
                    }
                }
                $sheet_collection[] = [' '];
                $sheet_collection[] = ['total row : '.($total_valid_row+$total_invalid_row)];
                $sheet_collection[] = ['total valid data row : '.$total_valid_row];
                $sheet_collection[] = ['total invalid data row : '.$total_invalid_row];
                $sheet_collection[] = ['total collection process : '.($total_discount_create+$total_discount_update+$total_discount_proccess_invalid)];
                $sheet_collection[] = ['total product create  : '.$total_discount_create];
                $sheet_collection[] = ['total product update  : '.$total_discount_update];
                $sheet_collection[] = ['total product invalid proccess  : '.$total_discount_proccess_invalid];
            }
        }

        $writer = WriterFactory::create(Type::XLSX); // for XLSX files
        $writer->openToFile(storage_path('exports/'.$filename)); // stream data directly to the browser
        $firstSheet = $writer->getCurrentSheet();
        $writer->addRows($sheet1);
        $newSheet = $writer->addNewSheetAndMakeItCurrent();
        $writer->addRows($sheet2);
        $newSheet = $writer->addNewSheetAndMakeItCurrent();
        $writer->addRows($sheet3);
        $newSheet = $writer->addNewSheetAndMakeItCurrent();
        $writer->addRows($sheet4);
        $newSheet = $writer->addNewSheetAndMakeItCurrent();
        $writer->addRows($sheet5);
        $newSheet = $writer->addNewSheetAndMakeItCurrent();
        $writer->addRows($sheet6);
        $writer->close();
        return $filename;
    }

    //validasi data
    public function validasiDataRow($idx){
        $data = [$idx[0], $idx[1], $idx[2], $idx[3], $idx[4], $idx[5], $idx[6]];
        $msg = '';
        $statusValidasi = false;
        if(trim($idx[0]) == '' || trim($idx[1]) == '' || trim($idx[2]) == '' || trim($idx[3]) == '' || trim($idx[4]) == ''){
            $msg .= '[ rows require is empty ]';
        }
        if($msg == ''){
            if(!(double)trim($idx[2])){
                $msg .= '[ discount value must be number only ]';
            }
            if(trim($idx[3]) != 'percent' && trim($idx[3]) != 'price'){
                $msg .= '[ discount type only "percent" and "price" ]';
            }
            if(!strtotime(trim($idx[4]))){
                $msg .= '[ expired date not valid, cant be convert to time system ]';
            }
            if(trim($idx[5]) != 'on' && trim($idx[5]) != 'off' && trim($idx[5]) != ''){
                $msg .= '[ status discount only "on" and "off" ]';
            }
        }

        if($msg == ''){
            $statusValidasi = true;
        }else{
            $data[] = $msg;
        }
        return ['status' => $statusValidasi, 'data' => $data];
    }

    //validasi data sheet 2-6
    public function validasiDataRow2($idx, $sheet){
        $data = [$idx[0], $idx[1], $idx[2]];
        $msg = '';
        $statusValidasi = false;

        if(trim($idx[0]) == '' || trim($idx[1]) == '' || trim($idx[2]) == ''){
            $msg .= '[ rows require is empty ]';
        }
        if($msg == ''){
            if(trim($idx[3]) != 'percent' && trim($idx[3]) != 'price'){
                $msg .= '[ action type only "add" and "remove" ]';
            }
        }
        if($msg == ''){
            $statusValidasi = true;
        }else{
            $data[] = $msg;
        }
        return ['status' => $statusValidasi, 'data' => $data];

    }

    //validasi collection brand, category, product, level, member
    public function validasi_collection($key, $table){
        $collection = Brand::where('slug', trim($key_id))->first();
        if(!$brand){
            return false;
        }else{
            return true;
        }
    }

    //setting discount status
    public function discount_setting($discount_id, $action){
        $discount = Discounts::find($discount_id);
        $this->remove_discount($discount_id);
        $discount->status = ($action == 'true'?'on':'off');

        if($action == 'true'){
            $this->dispatch(new DiscountSetting('start', $discount_id));
            $delay = strtotime($discount->expired_date) - strtotime(date("Y-m-d H:i:s"));
            if($delay > 0){
                $jobs = $this->dispatch((new DiscountSetting('stop', $discount->id))->delay($delay));
                $discount->jobs_id = (string)$jobs;
            }
        }
        $discount->save();
    }

    //remove discount from product
    public function remove_discount($id){
        $discount = Discounts::find($id);
        $products = Product::where('_id', '<>', $id);
        $products_update = $products->pull('discounts', ['_id' => $id]);

        if($products_update && count($discount->levels) == 0 && count($discount->members) == 0){
            if($discount->type == 'price'){
                $products_update = $products->decrement('discount_price', $discount->value);
            }else{
                $products_update = $products->decrement('discount_percent', $discount->value);
            }
        }
        //delete jobs already assign
        if(isset($discount->jobs_id)){
            //delete already job sent
            $job = Jobs::find($discount->jobs_id);
            if($job){
                $job->delete();
            }
        }
        return true;
    }

}
