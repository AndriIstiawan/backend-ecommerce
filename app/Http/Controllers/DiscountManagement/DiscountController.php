<?php

namespace App\Http\Controllers\DiscountManagement;

use App\Http\Controllers\Controller;
use App\Jobs\DiscountSetting;
use App\Discounts;
use App\Brand;
use App\Categories;
use App\Product;
use App\Levels;
use App\Member;
use App\Jobs;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class DiscountController extends Controller
{
    //Protected module discount by slug
    public function __construct()
    {
        $this->middleware('perm.acc:discount');
    }

    public function find(Request $request){
        if($request->id){
            $discount = Discounts::where('key_id', $request->keyID)->first();
            if($discount){
                return ($request->id == $discount->id ? 'true' : 'false');
            }else{
                return 'true';
            }
        }else{
            return (Discounts::where('key_id', $request->keyID)->first() ? 'false' : 'true' );    
        }
    }

    //public index discount
    public function index()
    {
        return view('panel.master-deal.discount.index');
    }

    //view form create
    public function create()
    {
        $brands = Brand::all();
        $categories = Categories::all();
        $products = Product::all();
        $levels = Levels::all();
        $members = Member::all();
        return view('panel.master-deal.discount.form-create')->with([
            'brands' => $brands,
            'categories' => $categories,
            'products' => $products,
            'levels' => $levels,
            'members' => $members,
        ]);
    }

    //store data discount
    public function store(Request $request)
    {
        $brands = [];
        $categories = [];
        $products = [];
        $levels = [];
        $members = [];

        $discount = new Discounts();
        $discount->key_id = $request->keyID;
        $discount->title = $request->title;
        $discount->description = $request->description;
        $discount->status = ($request->status == 'on' ? 'on' : 'off');
        $discount->value = (double)$request->value;
        $discount->type = $request->type;
        $discount->expired_date = $request->expiredDate;
        if (isset($request->brand)) {
            $brands = Brand::select('id', 'slug')->whereIn('_id', $request->brand)->get()->toArray();
        }
        $discount->brands = $brands;

        if (isset($request->category)) {
            $categories = Categories::select('_id', 'slug')->whereIn('_id', $request->category)->get()->toArray();
        }
        $discount->categories = $categories;

        if (isset($request->product)) {
            $products = Product::select('_id')->whereIn('_id', $request->product)->get()->toArray();
        }
        $discount->products = $products;

        if (isset($request->level)) {
            $levels = Levels::select('_id')->whereIn('_id', $request->level)->get()->toArray();
        }
        $discount->levels = $levels;

        if (isset($request->member)) {
            $members = Member::select('_id')->whereIn('_id', $request->member)->get()->toArray();
        }
        $discount->members = $members;
        $discount->save();

        //set discount if status on
        if (isset($request->status)) {
            $this->dispatch(new DiscountSetting('start', $discount->id));
            $delay = strtotime($discount->expired_date) - strtotime(date("Y-m-d H:i:s"));
            if($delay > 0){
                $jobs = $this->dispatch((new DiscountSetting('stop', $discount->id))->delay($delay));
                $discount->jobs_id = (string)$jobs;
            }
        }

        $discount->save();
        return redirect()->route('discount.index')->with('new', 'Discount');
    }

    //view list datatables of discount
    public function list_data()
    {
        $discounts = Discounts::all();

        return Datatables::of($discounts)
            ->addColumn('value_set', function ($discount) {
                $value = $discount->value;
                if ($discount->type == 'price') {
                    $value = 'Rp. ' . str_replace(',00', '', number_format($discount->value, 2, ',', '.'));
                } else {
                    $value = $value . " % ";
                }
                return $value;
            })
            ->addColumn('unique_modifier', function ($discount) {
                $value = '';
                if (count($discount->brands) > 0) {
                    $value .= '<span class="badge badge-primary">Brand : ' . count($discount->brands) . '</span>';
                }
                if (count($discount->categories) > 0) {
                    $value .= '<span class="badge badge-secondary">Category : ' . count($discount->categories) . '</span>';
                }
                if (count($discount->products) > 0) {
                    $value .= '<span class="badge badge-success">Product : ' . count($discount->products) . '</span>';
                }
                if (count($discount->levels) > 0) {
                    $value .= '<span class="badge bg-orange">Level : ' . count($discount->levels) . '</span>';
                }
                if (count($discount->members) > 0) {
                    $value .= '<span class="badge badge-dark">Member : ' . count($discount->members) . '</span>';
                }
                return $value;
            })
            ->addColumn('status_set', function ($discount) {
                $value = '<label class="switch switch-text switch-pill switch-success">
                    <input type="checkbox" class="switch-input" id="siteStatus" name="siteStatus" ' . ($discount->status == 'on' ? 'checked' : '') . ' tabindex="-1"
                    onchange="discountSetting($(this));" data-id="' . $discount->id . '">
                    <span class="switch-label" data-on="On" data-off="Off"></span>
                    <span class="switch-handle"></span>
                </label>';
                return $value;
            })
            ->addColumn('action', function ($discount) {
                return
                '<a class="btn btn-success btn-sm"  href="' . route('discount.edit', ['id' => $discount->id]) . '">
                        <i class="fa fa-pencil-square-o"></i>&nbsp;Edit</a>' .
                '<form style="display:inline;" method="POST" action="' .
                route('discount.destroy', ['id' => $discount->id]) . '">' . method_field('DELETE') . csrf_field() .
                    '<button type="button" class="btn btn-danger btn-sm" onclick="removeList($(this))"><i class="fa fa-remove"></i>&nbsp;Remove</button></form>';
            })
            ->rawColumns(['value_set', 'unique_modifier', 'status_set', 'action'])
            ->make(true);
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

    //setting discount status
    public function discount_setting(Request $request){
        $discount = Discounts::find($request->id);
        $this->remove_discount($request->id);
        $discount->status = ($request->action == 'true'?'on':'off');

        if($request->action == 'true'){
            $this->dispatch(new DiscountSetting('start', $request->id));
            $delay = strtotime($discount->expired_date) - strtotime(date("Y-m-d H:i:s"));
            if($delay > 0){
                $jobs = $this->dispatch((new DiscountSetting('stop', $discount->id))->delay($delay));
                $discount->jobs_id = (string)$jobs;
            }
        }

        $discount->save();
        echo 'success';
    }

    //for getting datatable at index
    public function show(Request $request, $action)
    {
        switch ($action) {
            case "list-data":
                return $this->list_data();
                break;
            case "discount-setting":
                return $this->discount_setting($request);
                break;
        }
    }

    //view form edit
    public function edit($id)
    {
        $brands = Brand::all();
        $categories = Categories::all();
        $products = Product::all();
        $levels = Levels::all();
        $members = Member::all();
        $discount = Discounts::find($id);
        return view('panel.master-deal.discount.form-edit')->with([
            'brands' => $brands,
            'categories' => $categories,
            'products' => $products,
            'levels' => $levels,
            'members' => $members,
            'discount' => $discount,
        ]);
    }

    //update data discount
    public function update(Request $request, $id)
    {
        $discount = Discounts::find($id);
        $this->remove_discount($id);

        $discount->title = $request->title;
        $discount->key_id = $request->keyID;
        $discount->description = $request->description;
        $discount->status = ($request->status == 'on' ? 'on' : 'off');
        $discount->value = (double)$request->value;
        $discount->type = $request->type;
        $discount->expired_date = $request->expiredDate;
        $discount->brands = (isset($request->brand)?Brand::select('id', 'slug')->whereIn('_id', $request->brand)->get()->toArray():[]);
        $discount->categories = (isset($request->category)?Categories::select('_id', 'slug')->whereIn('_id', $request->category)->get()->toArray():[]);
        $discount->products = (isset($request->product)?Product::select('_id', 'sku')->whereIn('_id', $request->product)->get()->toArray():[]);
        $discount->levels = (isset($request->level)?Levels::select('_id', 'key_id')->whereIn('_id', $request->level)->get()->toArray():[]);
        $discount->members = (isset($request->member)?Member::select('_id', 'email')->whereIn('_id', $request->member)->get()->toArray():[]);

        //set discount if status on
        if (isset($request->status)) {
            $this->dispatch(new DiscountSetting('start', $discount->id));
            $delay = strtotime($discount->expired_date) - strtotime(date("Y-m-d H:i:s"));
            if($delay > 0){
                $jobs = $this->dispatch((new DiscountSetting('stop', $discount->id))->delay($delay));
                $discount->jobs_id = (string)$jobs;
            }
        }

        $discount->save();
        return redirect()->route('discount.index')->with('edit', 'Discount');
    }

    //delete data discount
    public function destroy($id)
    {
        $discount = Discounts::find($id);
        $this->remove_discount($id);
        $discount->delete();
        return redirect()->route('discount.index')->with('dlt', 'discount');
    }

}
