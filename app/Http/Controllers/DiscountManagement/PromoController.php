<?php

namespace App\Http\Controllers\DiscountManagement;

use App\Brand;
use App\Categories;
use App\Couriers;
use App\Http\Controllers\Controller;
use App\Levels;
use App\Member;
use App\Product;
use App\Promo;
use File;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class PromoController extends Controller
{
    //Protected module promo by slug
    public function __construct()
    {
        $this->middleware('perm.acc:promo');
    }

    public function find(Request $request)
    {
        if ($request->id) {
            $promo = Promo::where('code', $request->code)->first();
            if ($promo) {
                return ($request->id == $promo->id ? 'true' : 'false');
            } else {
                return 'true';
            }
        } else {
            return (Promo::where('code', $request->code)->first() ? 'false' : 'true');
        }
    }

    //public index promo
    public function index()
    {
        return view('panel.master-deal.promo.index');
    }

    //view form create
    public function create()
    {
        $brands = Brand::all();
        $categories = Categories::all();
        $products = Product::all();
        $couriers = Couriers::where('status', 'on')->get();
        $levels = Levels::all();
        $members = Member::all();
        return view('panel.master-deal.promo.form-create')->with([
            'brands' => $brands,
            'categories' => $categories,
            'products' => $products,
            'couriers' => $couriers,
            'members' => $members,
            'levels' => $levels,
        ]);
    }

    //store data promo
    public function store(Request $request)
    {
        $promo = new Promo();
        $promo->image = "";
        $promo->title = $request->title;
        $promo->code = $request->code;
        $promo->value = (double) str_replace(',', '.', str_replace('.', '', $request->value));
        $promo->type = $request->type;
        $promo->expired_date = date("Y-m-d H:i:s", strtotime($request->expiredDate));
        $brands = (isset($request->brand) ? Brand::select('id', 'slug')->whereIn('_id', $request->brand)->get()->toArray() : []);
        $categories = (isset($request->category) ? Categories::select('_id', 'slug')->whereIn('_id', $request->category)->get()->toArray() : []);
        $products = (isset($request->product) ? $products = Product::select('_id', 'sku')->whereIn('_id', $request->product)->get()->toArray() : []);
        $couriers = (isset($request->courier) ? $couriers = Couriers::select('_id', 'slug')->whereIn('_id', $request->courier)->get()->toArray() : []);
        $levels = (isset($request->level) ? $levels = Levels::select('_id', 'key_id')->whereIn('_id', $request->level)->get()->toArray() : []);
        $members = (isset($request->member) ? $members = Member::select('_id', 'email')->whereIn('_id', $request->member)->get()->toArray() : []);

        switch ($request->target) {
            case 'total price':
                $promo->target = [
                    [
                        'target' => $request->target,
                    ],
                ];
                break;
            case 'product':
                $promo->target = [
                    [
                        'target' => $request->target,
                        'brands' => $brands,
                        'categories' => $categories,
                        'products' => $products,
                    ],
                ];
                break;
            case 'courier':
                $promo->target = [
                    [
                        'target' => $request->target,
                        'couriers' => $couriers,
                    ],
                ];
                break;
        }

        $promo->content_html = ($request->contentHTML != null ? $request->contentHTML : "");
        $promo->levels = $levels;
        $promo->members = $members;
        $promo->save();
        $pictureFile = $request->file('image');
        $extension = $pictureFile->getClientOriginalExtension();
        $destinationPath = public_path('/img/promos');
        $pictureFile->move($destinationPath, $promo->id . '.' . $extension);
        $promo->image = $promo->id . '.' . $extension;
        $promo->save();

        return redirect()->route('promo.index')->with('new', 'Promo');
    }

    //for getting datatable at index
    public function show(Request $request, $action)
    {
        $promos = Promo::all();

        return Datatables::of($promos)
            ->addColumn('value_set', function ($promos) {
                $value = $promos->value;
                if ($promos->type == 'price') {
                    $value = 'Rp. ' . str_replace(',00', '', number_format($promos->value, 2, ',', '.'));
                } else {
                    $value = $value . " % ";
                }
                return $value;
            })
            ->addColumn('target_name', function ($promo) {
                return $promo->target[0]['target'];
            })
            ->addColumn('action', function ($promo) {
                return
                '<a class="btn btn-success btn-sm" href="' . route('promo.edit', ['id' => $promo->id]) . '">
                        <i class="fa fa-pencil-square-o"></i>&nbsp;Edit Promo</a>' .
                '<form style="display:inline;" method="POST" action="' .
                route('promo.destroy', ['id' => $promo->id]) . '">' . method_field('DELETE') . csrf_field() .
                    '<button type="button" class="btn btn-danger btn-sm" onclick="removeList($(this))"><i class="fa fa-remove"></i>&nbsp;Remove</button></form>';
            })
            ->rawColumns(['value_set', 'target_name', 'action'])
            ->make(true);
    }

    //view form edit
    public function edit($id)
    {
        $promo = Promo::find($id);
        $brands = Brand::all();
        $categories = Categories::all();
        $products = Product::all();
        $couriers = Couriers::where('status', 'on')->get();
        $levels = Levels::all();
        $members = Member::all();

        return view('panel.master-deal.promo.form-edit')->with([
            'promo' => $promo,
            'brands' => $brands,
            'categories' => $categories,
            'products' => $products,
            'couriers' => $couriers,
            'levels' => $levels,
            'members' => $members,
        ]);
    }

    //update data promo
    public function update(Request $request, $id)
    {
        $promo = Promo::find($id);
        $promo->title = $request->title;
        $promo->code = $request->code;
        $promo->value = (double) str_replace(',', '.', str_replace('.', '', $request->value));
        $promo->type = $request->type;
        $promo->expired_date = date("Y-m-d H:i:s", strtotime($request->expiredDate));
        $brands = (isset($request->brand) ? Brand::select('id', 'slug')->whereIn('_id', $request->brand)->get()->toArray() : []);
        $categories = (isset($request->category) ? Categories::select('_id', 'slug')->whereIn('_id', $request->category)->get()->toArray() : []);
        $products = (isset($request->product) ? $products = Product::select('_id', 'sku')->whereIn('_id', $request->product)->get()->toArray() : []);
        $couriers = (isset($request->courier) ? $couriers = Couriers::select('_id', 'slug')->whereIn('_id', $request->courier)->get()->toArray() : []);
        $levels = (isset($request->level) ? $levels = Levels::select('_id', 'key_id')->whereIn('_id', $request->level)->get()->toArray() : []);
        $members = (isset($request->member) ? $members = Member::select('_id', 'email')->whereIn('_id', $request->member)->get()->toArray() : []);

        switch ($request->target) {
            case 'total price':
                $promo->target = [
                    [
                        'target' => $request->target,
                    ],
                ];
                break;
            case 'product':
                $promo->target = [
                    [
                        'target' => $request->target,
                        'brands' => $brands,
                        'categories' => $categories,
                        'products' => $products,
                    ],
                ];
                break;
            case 'courier':
                $promo->target = [
                    [
                        'target' => $request->target,
                        'couriers' => $couriers,
                    ],
                ];
                break;
        }

        $promo->content_html = ($request->contentHTML != null ? $request->contentHTML : "");
        $promo->levels = $levels;
        $promo->members = $members;
        if ($request->file('image')) {
            $pictureFile = $request->file('image');
            $extension = $pictureFile->getClientOriginalExtension();
            $destinationPath = public_path('/img/promos');
            File::delete(public_path('/img/promos/' . $promo->image));
            $pictureFile->move($destinationPath, $promo->id . '.' . $extension);
            $promo->image = $promo->id . '.' . $extension;
            $promo->save();
        }
        $promo->save();

        return redirect()->route('promo.index')->with('edit', 'Promo');
    }

    //delete data promo
    public function destroy($id)
    {
        $promo = Promo::find($id);
        $promo->delete();
        return redirect()->route('promo.index')->with('delete', 'promo');
    }
}
