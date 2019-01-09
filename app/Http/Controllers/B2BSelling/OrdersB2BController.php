<?php

namespace App\Http\Controllers\B2BSelling;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Orders;
use Yajra\Datatables\Datatables;

class OrdersB2BController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('panel.b2b-selling.order-history-b2b.index');
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
        $orders = Orders::where('type','B2B');
        
        return Datatables::of($orders)
            ->addColumn('order_type', function ($orders) {
                if(isset($orders->cart[0]['products'])){
                    return "cart";
                }else{
                    return "inquiry";
                }
            })
            ->addColumn('total_product', function ($orders) {
                return 0;
            })
            ->addColumn('action', function ($orders) {
                return 
                    '<a class="btn btn-success btn-sm" href="#">
                        <i class="fa fa-search"></i>&nbsp;View</a>';
            })
            ->rawColumns(['total_product', 'order_type', 'action'])
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
        //
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
        //
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
