<?php

namespace App\Http\Controllers\SpecialProduct;

use App\HotDeals;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DataTables;
use File;

class HotDealsController extends Controller
{
    private $deals;

    public function __construct(HotDeals $deals)
    {
        $this->deals = $deals;
    }

    public function index(Request $request)
    {
        if($request->ajax()){
            $index = HotDeals::get();
            return DataTables::of($index)
                ->editColumn('images', function($index){
                    return is_null($index->hot_images) ? '<img src="http://placehold.it/100x100" alt="">' : '<img src="'. asset('img/hot-deals/'.$index->hot_images) .'" alt="'.$index->hot_images.'" width="100" height="100">';
                })
                ->editColumn('product', function($index){
                    return $index->product->name;
                })
                ->editColumn('created_at', function($index){
                    return \Carbon\Carbon::parse($index->created_at)->format('d F Y');
                })
                ->editColumn('created_by', function($index){
                    return $index->user->name;
                })
                ->addColumn('action', function ($index) {
                    return 
                        '<a style="display:inline;" class="btn btn-success btn-sm" href="'.route('hot-deals.edit',['id' => $index->id]).'">
                            <i class="fa fa-pencil-square-o"></i>&nbsp;Edit</a>'.
                        '<form style="display:inline;" method="POST" action="'.
                            route('hot-deals.destroy',['id' => $index->id]).'">'.method_field('DELETE').csrf_field().
                        '<button type="button" class="btn btn-danger btn-sm" onclick="removeList($(this))"><i class="fa fa-remove"></i>&nbsp;Remove</button></form>';
                })
                ->rawColumns(['images','action'])
            ->make(true);
        }
        return view('panel.special-product.hot.index');
    }

    public function store(Request $request) 
    {
        foreach($request->product_id as $v){
            $data = [];
            if(! HotDeals::whereProductId($v)->exists())
                $data[] = [
                    'product_id' => $v,
                    'hot_images' => null,
                    'created_by' => \Auth::id(),
                    'created_at' => \Carbon\Carbon::today()->toDateTimeString(),
                ];
        }
        if(sizeof($data) > 0)
            $this->deals->insert($data);
        return redirect()->route('hot-deals.index')->with('toastr', 'Hot deals');
    }

    public function edit(Request $request, $id) 
    {
        return view('panel.special-product.hot.create', [
            'deals' => $this->deals->find($id)
        ]);
    }

    public function update(Request $request, $id) 
    {
        $request->validate([
            'image' => 'mimes:jpg,jpeg,png,gif | max : 1024',
        ]);
        $images = null;
        $deals = $this->deals->find($id);
        if ($request->hasFile('image')) {
            $pictureFile = $request->file('image');
            $extension = $pictureFile->getClientOriginalExtension();
            if(!File::exists(public_path('/img/hot-deals'))){
                $destinationPath = File::makeDirectory(public_path('/img/hot-deals'));
            }
            if($deals->hot_images != '' || $deals->hot_images != null){
                File::delete(public_path('/img/hot-deals/'.$deals->hot_images));
            }
            $destinationPath = public_path('/img/hot-deals');
            $pictureFile->move($destinationPath, $deals->id.time().'.'.$extension);
            $images = $deals->id.time().'.'.$extension;
        }
        $deals->update([
            'hot_images' => $images,
            'updated_by' => \Auth::id(),
        ]);
        return redirect()->route('hot-deals.index')->with('update', 'Hot deals');
    }

    public function destroy(Request $request, $id) 
    {
        File::delete(public_path('/img/hot-deals/'.$this->deals->find($id)->hot_images));
        $this->deals->find($id)->forceDelete();
        return redirect()->route('hot-deals.index')->with('delete', 'Hot deals');
    }
}
