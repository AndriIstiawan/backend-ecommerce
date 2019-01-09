<?php

namespace App\Http\Controllers\B2BSelling;

use Illuminate\Http\Request;
use App\Cart;
use App\Inquiries;
use App\Orders;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use MongoDB\BSON\ObjectID;
use Auth;

class PendingPOController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('panel.b2b-selling.pending-po.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if($id == 'list-unresolve'){
            $order = Orders::where('inquiry', 'elemMatch', array('status' => 'Active'))->get();
        }else{
            $order = Orders::where('inquiry', 'elemMatch', array('status' => 'Resolved'))->get();
        }
        $inquiry = [];
        foreach($order as $order_list){
            $inquiry[] = $order_list->inquiry[0]['_id'];
        }
        
        $inquiry = Inquiries::whereIn('_id',$inquiry)->get();
        return Datatables::of($inquiry)
            ->addColumn('member_detail', function ($inquiry) {
                $str = "guest";
                if(count($inquiry->member) > 0){
                    foreach($inquiry->member as $member_det){
                        $str = $member_det['name']."<br>";
                    }
                }
                return $str;
            })
            ->addColumn('inquiries_status', function ($inquiry) {
                $pending  = 0;
                $accepted = 0;
                $rejected = 0;
                $str = '';
                foreach($inquiry->inquiries as $inq_status){
                    foreach($inq_status['status'] as $inq_det_sts){
                        switch($inq_det_sts['statusType']){
                            case "Pending" : $pending++;
                            break;
                            case "Approved" : $accepted++;
                            break;
                            case "Rejected" : $rejected++;
                            break;
                        }
                    }
                }
                if($inquiry->status == 'Active'){
                    $str .= '<span class="badge badge-pill badge-warning">Pending
                        <span class="badge badge-light badge-pill" style="position: static;">'.$pending.'</span></span>';
                }else{
                    $str .= '<span class="badge badge-pill badge-danger">Rejected
                        <span class="badge badge-light badge-pill" style="position: static;">'.$rejected.'</span></span>';
                    $str .= '<span class="badge badge-pill badge-success">Approved
                        <span class="badge badge-light badge-pill" style="position: static;">'.$accepted.'</span></span>';
                }
                return $str;
            })
            ->addColumn('total_product_cart', function ($inquiry) {
                $cart = Cart::find($inquiry['cart_id']);
                if($cart){ $total_product_cart = count($cart->products); }else{ $total_product_cart = 0; }
                return '<span class="pull-right" style="margin-right:20px;">'.$total_product_cart.'</span>';
            })
            ->addColumn('total_price_cart', function ($inquiry) {
                return "Rp. " . str_replace(',00','',number_format($inquiry->total_price_cart,2,',','.'));
            })
            ->addColumn('action', function ($inquiry) {
                return
                    '<a class="btn btn-success btn-sm" href="'.route('pending-po.edit',['id' => $inquiry->id]).'">
                        <i class="fa fa-search"></i>&nbsp;View</a>';
            })
            ->rawColumns(['member_detail','inquiries_status','total_product_cart','total_price_cart','action'])
            ->make(true);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $inquiry = Inquiries::find($id);
        return view('panel.b2b-selling.pending-po.form-edit')->with(['inquiry' => $inquiry]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $order = Orders::where('inquiry', 'elemMatch', array('_id' => new \MongoDB\BSON\ObjectID($id) ))->first();
        $inquiry = Inquiries::find($id);
        $products = [];
        foreach($request->id as $productID){
            $products[] = [
                'id' => new \MongoDB\BSON\ObjectID($productID),
                'productImage' => $request->input('image'.$productID),
                'productName' => $request->input('name'.$productID),
                'description' => $request->input('description'.$productID),
                'quantity' => $request->input('quantity'.$productID),
                'price' => (double)str_replace(',', '.',str_replace('.', '',$request->input('price'.$productID))),
                'totalPrice' => (double)str_replace(',', '.',str_replace('.', '',$request->input('total'.$productID))),
                'status' => [[
                    'statusType' => $request->input('status'.$productID),
                    'statusNote' => $request->input('note'.$productID),
                ]],
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ];
            $inquiry->total_price_cart = $inquiry->total_price_cart + (double)str_replace(',', '.',str_replace('.', '',$request->input('total'.$productID)));
        }
        $inquiry->inquiries = $products;
        $inquiry->status = 'Resolved';
        $inquiry->approval = Auth::user()->id;
        $order['inquiry'] = [$inquiry->toArray()];
        $order['total_price'] = $inquiry->total_price_cart;
        $order->save();
        $inquiry->save();
        return view('panel.b2b-selling.pending-po.index')->with('update', 'Inquiry updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
