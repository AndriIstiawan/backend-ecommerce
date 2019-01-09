<?php

namespace App\Http\Controllers\OrderManagement;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\OrderStatuses;
use App\Taxes;
use Yajra\Datatables\Datatables;

class OrderStatusController extends Controller
{
    //Protected module orderstatuses by slug
    public function __construct()
    {
        $this->middleware('perm.acc:orderstatuses');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    //public index orderstatus
    public function index()
    {
        return view('panel.order-management.orderstatuses.index');
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    //view form create
    public function create()
    {
        return view('panel.order-management.orderstatuses.form-create');
    }

    //For find email if already use
    public function find(Request $request)
    {

        if ($request->id) {
            $orderstatuses = OrderStatuses::where('plot', $request->plot)->first();
            if (count($orderstatuses) > 0) {
                return ($request->id == $orderstatuses->id ? 'true' : 'false');
            } else {
                return 'true';
            }
        } else {
            return (OrderStatuses::where('plot', $request->plot)->first() ? 'false' : 'true');
        }
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
        $taxes->plot = $request->plot;
        $taxes->notification = $request->notification;
        $taxes->save();
        
        return redirect()->route('orderstatuses.index')->with('toastr', 'new');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //for getting datatable at index
    public function show(Request $request, $action){
        $taxes = OrderStatuses::select(['name', 'notification', 'created_at']);
        
        return Datatables::of($taxes)
            ->addColumn('action', function ($taxes) {
                return 
                    '<button class="btn btn-success btn-sm"  data-toggle="modal" data-target="#primaryModal"
                         onclick="funcModal($(this))" data-link="'.route('orderstatuses.edit',['id' => $taxes->id]).'">
                        <i class="fa fa-pencil-square-o"></i>&nbsp;Edit</button>'.
                    '<form style="display:inline;" method="POST" action="'.
                        route('orderstatuses.destroy',['id' => $taxes->id]).'">'.method_field('DELETE').csrf_field().
                    '<button type="button" class="btn btn-danger btn-sm" onclick="removeList($(this))"><i class="fa fa-remove"></i>&nbsp;Remove</button></form>';
            })
            ->rawColumns(['status', 'action'])
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
        $taxes = OrderStatuses::find($id);
        return view('panel.order-management.orderstatuses.form-edit')->with(['orderstatuses'=>$taxes]);
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
        $taxes->plot = $request->plot;
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
