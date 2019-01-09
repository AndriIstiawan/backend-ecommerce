<?php

namespace App\Http\Controllers\OrderManagement;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\OrderStatuses;
use App\Orders;
use App\Cart;
use App\Inquiries;
use App\Couriers;
use App\User;
use App\Member;
use Yajra\Datatables\Datatables;

class CartsController extends Controller
{
    //Protected module cart by slug
    public function __construct()
    {
        $this->middleware('perm.acc:cart');
    }

    /**
     * set cart cost
     *
     * @return \Illuminate\Http\Response
     */
    public function set_cost(Request $request)
    {   
        $cart = Cart::find($request->id);
        $total_price = [[
            'total_product' => $cart->total_price[0]['total_product'],
            'courier_cost' => (double) str_replace(',', '.', str_replace('.', '', $request->cartCost)),
            'courier_cut_promo' => $cart->total_price[0]['courier_cut_promo'],
            'total' => $cart->total_price[0]['total'],
            'total_cut_promo' => $cart->total_price[0]['total_cut_promo'],
            'currency' => $cart->total_price[0]['currency']
        ]];
        $courier_set = [
            [
                "code" => $cart->courier[0]['code'],
                "name" => $cart->courier[0]['name'],
                "detail" => $cart->courier[0]['detail'],
                "costs" => [
                    [
                        "service" => $request->cartService,
                        "description" => $request->cartDescription,
                        "cost" => [
                            [
                                "value" => (double) str_replace(',', '.', str_replace('.', '', $request->cartCost)),
                                "etd" => $request->cartEtd,
                                "note" => $request->cartNote,
                            ]
                        ]
                    ]
                ]
            ]
        ];
        $cart->courier = $courier_set;
        if(isset($cart->promo[0]['target'][0]['target'])){
            if($cart->promo[0]['target'][0]['target'] == 'courier'){
                if($cart->promo[0]['type'] == 'percent'){
                    $total_price[0]['courier_cut_promo'] = $total_price[0]['courier_cost'] - ($total_price[0]['courier_cost']*$cart->promo[0]['value']/100);
                }else{
                    $total_price[0]['courier_cut_promo'] = $total_price[0]['courier_cost'] - $cart->promo[0]['value'];
                }
                if($total_price[0]['courier_cut_promo'] < 0){
                    $total_price[0]['courier_cut_promo'] = 0;
                }
                $total_price[0]['total'] = $total_price[0]['total_product'] + $total_price[0]['courier_cut_promo'];
            }else{
                if($cart->promo[0]['type'] == 'percent'){
                    $total_price[0]['total_cut_promo'] = $total_price[0]['total_product'] + $total_price[0]['courier_cost'];
                }else{
                    $total_price[0]['total_cut_promo'] = $total_price[0]['total_product'] + $total_price[0]['courier_cost'];
                }
                if($total_price[0]['total_cut_promo'] < 0){
                    $total_price[0]['total_cut_promo'] = 0;
                }
            }
        }
        $cart->total_price = $total_price;
        $cart->payment_status =  true;
        $cart->status = "waiting for payment";
        $cart->save();
        return "success";
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    //public index orderstatus
    public function index()
    {
        return view('panel.order-management.cart.index');
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    //view form create
    public function create()
    {   

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    //store data orderstatus
    public function store(Request $request)
    {
        $taxes = new OrderStatuses();
        $taxes->name = $request->name;
        $taxes->notification = $request->notification;
        $taxes->save();
        
        return redirect()->route('cart.index')->with('toastr', 'new');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //for getting datatable at index
    public function show(Request $request, $action){
        $carts = Cart::where('status', '!=', 'Ordering')->get();
        
        return Datatables::of($carts)
            ->addColumn('member_detail', function ($carts) {
                $str = "guest";
                if(count($carts->member) > 0){
                    foreach($carts->member as $member_det){
                        $str = $member_det['name']."<br>";
                    }
                }
                return $str;
            })
            ->addColumn('product_count', function ($carts) {
                return count($carts->products);
            })
            ->addColumn('payment_notes', function ($carts) {
                return ($carts->payment_status == "true" ? '<span class="badge badge-primary">Available</span>':'<span class="badge badge-warning">Not Available</span>');
            })
            ->addColumn('total_cart', function ($carts) {
                return "Rp. " . str_replace(',00','',number_format($carts->total_price[0]['total'],2,',','.'));
            })
            ->addColumn('action', function ($carts) {
                return
                    '<a class="btn btn-success btn-sm" href="'.route('cart.edit',['id' => $carts->id]).'">
                        <i class="fa fa-search"></i>&nbsp;View</a>';
            })
            ->rawColumns(['member_detail','product_count','payment_notes','total_cart', 'action'])
            ->make(true);
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //view form edit
    public function edit($id)
    {
        $cart = Cart::find($id);
        $courier = null;
        if(isset($cart['courier'][0]['code'])){
            $courier = Couriers::where('slug', $cart['courier'][0]['code'])->first();
        }
        
        return view('panel.order-management.cart.form-create')->with(['cart' => $cart, 'courier' => $courier]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //update dataorderstatus
    public function update(Request $request, $id)
    {
        $taxes = OrderStatuses::find($id);
        $taxes->name = $request->name;
        $taxes->notification = $request->notification;
        
        $taxes->save();
        return redirect()->route('orderstatuses.index')->with('update', 'Order Statuses updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //delete data orderstatus
    public function destroy($id)
    {
        $taxes = OrderStatuses::find($id);
        $taxes->delete();
        
        return redirect()->route('orderstatuses.index')->with('dlt', 'Order Statuses deleted!');
    }
}
