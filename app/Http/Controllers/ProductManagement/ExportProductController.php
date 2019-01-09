<?php

namespace App\Http\Controllers\ProductManagement;

use App\Http\Controllers\Controller;
use App\Product;
use Excel;
use Illuminate\Http\Request;

class ExportProductController extends Controller
{
    //Protected module product by slug
    public function __construct()
    {
        $this->middleware('perm.acc:product');
    }

    //public index export product
    public function index(Request $request)
    {
        $today = date("F_j_Y");
        $products = Product::all();
        $this->excelProccess($products, $today);
    }

    public function export_selected(Request $request)
    {
        $today = date("F_j_Y");
        $this->excelProccess(Product::whereIn('_id', $request->product_id)->get(), $today);
    }

    private function excelProccess($products, $today)
    {
        Excel::create('List of Products-' . $today, function ($excel) use ($products) {
            $excel->sheet('Product', function ($sheet) use ($products) {
                $sheet->cell(1, function ($row) {
                    $row->setFont(array(
                        'family' => 'Calibri',
                        'size'   => '12',
                        'bold'   => true
                    ));
                    $row->setBackground('#FFBF00');
                });
                $sheet->loadView('template-excel.export-product', compact('products'));
            });

            $excel->sheet('Variation', function ($sheet) use ($products) {
                $sheet->cell(1, function ($row) {
                    $row->setFont(array(
                        'family' => 'Calibri',
                        'size'   => '12',
                        'bold'   => true
                    ));
                    $row->setBackground('#FFBF00');
                });
                $sheet->loadView('template-excel.export-product-variation', compact('products'));
            });
        })->download('xls');
    }
}
