<?php

namespace App\Http\Controllers\DeliveriesManagement;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use App\Couriers;
use RajaOngkir;

class CourierController extends Controller
{

    //Protected module courier by slug
    public function __construct()
    {
        $this->middleware('perm.acc:courier');
    }

    public function find(Request $request){
        
        if($request->id){
            $courier = Couriers::where('slug', $request->slug)->first();
            if($courier){
                return ($request->id == $courier->id ? 'true' : 'false');
            }else{
                return 'true';
            }
        }else{
            return (Couriers::where('slug', $request->slug)->first() ? 'false' : 'true' );    
        }
    }

    public function set_status(Request $request){
        $action = ($request->action == 'true'?'on':'off');
        $courier = Couriers::find($request->id);
        $courier->status = $action;
        $courier->save();

        return 'success';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('panel.deliveries-management.courier.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cities = RajaOngkir::Kota()->all();
        return view('panel.deliveries-management.courier.form-create')->with([
            'cities' => $cities,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $service = [];
        foreach($request->serviceID as $sid){
            $service[] = [
                'name' => $request->input('service'.$sid),
                'description' => $request->input('description'.$sid),
            ];
        }
        $courier = new Couriers();
        $courier->courier = $request->courier;
        $courier->type = 'e-commerce courier';
        $courier->slug = $request->slug;
        $courier->location = [RajaOngkir::Kota()->find($request->location)];
        $courier->status = ($request->status == 'on' ? 'on' : 'off');
        $courier->service = $service;
        $courier->save();

        return redirect()->route('courier.index')->with('new', 'Courier');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $couriers = Couriers::all();
        
        return Datatables::of($couriers)
            ->addColumn('location_set', function ($couriers) {
                return $couriers->location[0]['type'].' '.$couriers->location[0]['city_name'];    
            })
            ->addColumn('status_set', function ($couriers) {
                $value = '<label class="switch switch-text switch-pill switch-success">
                    <input type="checkbox" class="switch-input" ' . ($couriers->status == 'on' ? 'checked' : '') . ' tabindex="-1"
                    onchange="courierSetStatus($(this));" data-id="' . $couriers->id . '">
                    <span class="switch-label" data-on="On" data-off="Off"></span>
                    <span class="switch-handle"></span>
                </label>';
                return $value;
            })
            ->addColumn('action', function ($couriers) {
                $value = '<a class="btn btn-success btn-sm" href="'.route('courier.edit',['id' => $couriers->id]).'">
               <i class="fa fa-pencil-square-o"></i>&nbsp;Edit Courier</a>';

                if($couriers->type != 'default courier'){
                    $value .= '<form style="display:inline;" method="POST" action="'.
                    route('courier.destroy',['id' => $couriers->id]).'">'.method_field('DELETE').csrf_field().
                '<button type="button" class="btn btn-danger btn-sm" onclick="removeList($(this))"><i class="fa fa-remove"></i>&nbsp;Remove</button></form>';
                }

                return $value;    
            })
            ->rawColumns(['location_set', 'status_set', 'action'])
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
        $cities = RajaOngkir::Kota()->all();
        $courier = Couriers::find($id);
        return view('panel.deliveries-management.courier.form-edit')->with([
            'courier' => $courier,
            'cities' => $cities,
        ]);
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
        $service = [];
        if(isset($request->serviceID)){
            foreach($request->serviceID as $sid){
                $service[] = [
                    'name' => $request->input('service'.$sid),
                    'description' => $request->input('description'.$sid),
                ];
            }
        }
        
        $courier = Couriers::find($id);
        $courier->courier = $request->courier;
        $courier->type = $request->type;
        $courier->slug = $request->slug;
        $courier->location = [RajaOngkir::Kota()->find($request->location)];
        $courier->status = ($request->status == 'on' ? 'on' : 'off');
        $courier->service = $service;
        $courier->save();

        return redirect()->route('courier.index')->with('edit', 'Courier');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $courier = Couriers::find($id);
        $courier->delete();
        return redirect()->route('courier.index')->with('dlt', 'Courier');
    }
}
