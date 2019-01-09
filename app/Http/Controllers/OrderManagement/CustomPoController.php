<?php

namespace App\Http\Controllers\OrderManagement;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Member;
use App\Cart;
use App\Product;
use App\Inquiries;
use Yajra\Datatables\Datatables;

class CustomPoController extends Controller
{
    //Protected module cart by slug
    public function __construct()
    {
        $this->middleware('perm.acc:custom-po');
    }

    public function index()
    {
        return view('panel.order-management.custom-po.index');
    }
    
    public function create()
    {
    }

    public function store(Request $request)
    {
        // $custom = new custom();
        // $member= Member::whereIn('_id', $request->member)->get();
        // $custom->member=$member->toArray();
        // $custom->name_product = $request->name_product;
        // $custom->description_product = $request->description_product;
        // $custom->quantity_product = $request->quantity_product;
        // $custom->comment = $request->comment;

        // if ($request->hasFile('picture')) {
        //     $pictureFile = $request->file('picture');
        //     $extension = $pictureFile->getClientOriginalExtension();
        //     $destinationPath = public_path('/img/avatars');
        //     $pictureFile->move($destinationPath, $custom->name_product.'.'.$extension);
        //     $custom->picture = $custom->name_product.'.'.$extension;
        // }
		// $custom->save();

		// return redirect()->route('custom-po.index')->with('toastr', 'custom');
    }

    public function show(Request $request, $action){
        $inquiries = Inquiries::all();
        
        return Datatables::of($inquiries)
            ->addColumn('member_detail', function ($carts) {
                $str = "";
                if(count($carts->member) > 0){
                    foreach($carts->member as $member_det){
                        $str .= $member_det['name']."<br>";
                    }
                }
                return $str;
            })
            ->addColumn('product_list', function ($carts) {
                $str = "";
                if(count($carts->products) > 0){
                    foreach($carts->products as $prod_list){
                        $str .= $prod_list['productName']." [ variant:".$prod_list['variant']."][QTY:".$prod_list['quantity']."]<br>";
                    }
                }
                return $str;
            })
            ->addColumn('total_cart', function ($carts) {
                return "Rp. " . str_replace(',00','',number_format($carts->total_price,2,',','.'));
            })
            ->addColumn('action', function ($carts) {
                return
                    '<a class="btn btn-success btn-sm" href="'.route('custom-po.edit',['id' => $carts->id]).'">
                        <i class="fa fa-pencil"></i>&nbsp;View</a>';
            })
            ->rawColumns(['member_detail','product_list','total_cart', 'action'])
            ->make(true);
    }
    
    public function edit($id)
    {
        $inquiry = Inquiries::find($id);
        $cart = Cart::where('_id',$inquiry->cart_id)->first();
        $product = Product::where('_id',array_column($cart->products, 'productID'))->get();
        $member = Member::where('name',array_column($inquiry->member, 'name'))->get();
        return view('panel.order-management.custom-po.form-create')->with([
            'cart' => $cart,
            'inquiry' => $inquiry,
            'member' => $member,
            'product' => $product
        ]);
    }

    public function update(Request $request, $id)
    {
        // $custom = custom::find($id);
        // $custom->comment = $request->comment;
        // $custom->save();
		
		// return redirect()->route('custom-po.index')->with('toastr', 'custom');
    }

    public function destroy($id)
    {
        // $custom = custom::find($id);
        // $custom->delete();
        // return redirect()->route('custom-po.index')->with('dlt', 'custom');
    }
}
