<?php

namespace App\Http\Controllers\SpecialProduct;

use App\Segment;
use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DataTables;
use File;


class SegmentController extends Controller
{
	private $segments;

    public function __construct(Segment $segments, Product $product)
    {
        $this->segments = $segments;
        $this->product = $product;
    }

    public function index(Request $request)
    {
    	if($request->ajax()){
    		$index = $this->segments->get();
            return DataTables::of($index)
                ->editColumn('images', function($index){
                    return is_null($index->images) ? '<img src="http://placehold.it/100x100" alt="">' : '<img src="'. asset('img/segments-products/'.$index->images) .'" alt="'.$index->images.'" width="100" height="100">';
                })
                ->editColumn('type', function($index){
                    return "Segment $index->type";
                })
                ->editColumn('products', function($index){
                    return count($index->products);
                })
                ->editColumn('created_at', function($index){
                    return \Carbon\Carbon::parse($index->created_at)->format('d F Y');
                })
                ->editColumn('created_by', function($index){
                    return $index->user->name;
                })
                ->editColumn('is_publish', function($index){
                    return $index->is_publish ? 'Published' : 'Draft';
                })
                ->addColumn('action', function ($index) {
                    return 
                        '<a style="display:inline;" class="btn btn-success btn-sm" href="'.route('segments.edit',['id' => $index->id]).'">
                            <i class="fa fa-pencil-square-o"></i>&nbsp;Edit</a>'.
                        '<form style="display:inline;" method="POST" action="'.
                            route('segments.destroy',['id' => $index->id]).'">'.method_field('DELETE').csrf_field().
                        '<button type="button" class="btn btn-danger btn-sm" onclick="removeList($(this))"><i class="fa fa-remove"></i>&nbsp;Remove</button></form>';
                })
                ->rawColumns(['images','action'])
            ->make(true);
    	}
    	return view('panel.special-product.segments.index');
    }

    public function create(Request $request)
    {
    	// $segment = $this->segments->whereType($request->version)->first();
    	// if($segment){
    	// 	return redirect()->route('segments.edit', ['id' => $segment->id]);
    	// }
    	return view('panel.special-product.segments.create', [
    		'version' => $request->version
    	]);
    }

    public function store(Request $request)
    {
    	$request->validate([
			'title' => 'required|unique:segment_products',
			'order' => 'required',
			'images' => 'mimes:jpg,jpeg,png,gif | max : 1024',
            'is_publish' => 'required',
    	]);
    	$images = null;
    	if ($request->hasFile('images')) {
            $images = $this->uploader($request, 'images', '');
        }
    	$created = $this->segments->create([
    		'title' => $request->title,
    		'order' => $request->order,
    		'images' => $images,
    		'type' => $request->version,
    		'products' => count($request->product) > 0 ? $request->product : [],
    		'created_by' => auth()->id(),
            'is_publish' => $request->is_publish == 'published' ? true : false
    	]);
    	return redirect()->route('segments.edit', ['id' => $created->id]);
    }

    public function edit($id)
    {
    	$data = $this->segments->find($id);
    	return view('panel.special-product.segments.create', [
    		'version' => $data->type,
    		'segments' => $data
    	]);
    }

    public function update(Request $request, $id)
    {
    	$request->validate([
			'title' => 'required|unique:segment_products,'.$id,
			'order' => 'required',
			'images' => 'required,'.$id.'mimes:jpg,jpeg,png,gif | max : 1024',
            'is_publish' => 'required'
    	]);
    	$segments = $this->segments->find($id);
    	$images = $segments->images;
    	if ($request->hasFile('images')) {
            $images = $this->uploader($request, 'images', $this->segments->find($id));
        }
    	$created = $segments->update([
    		'title' => $request->title,
    		'order' => $request->order,
    		'images' => $images,
    		'type' => $request->version,
    		'products' => count($request->product) > 0 ? $request->product : [],
    		'created_by' => auth()->id(),
            'is_publish' => $request->is_publish == 'published' ? true : false
    	]);
    	return redirect()->route('segments.edit', ['id' => $segments->id]);
    }

    public function destroy($id)
    {
    	$model = $this->segments->find($id);
    	if($model){
            File::delete(public_path('/img/segments-products/'.$model->images));
            $model->destroy($id);
        }
        return redirect()->back();
    }

    private function uploader($request, $name, $model = null)
    {
    	$pictureFile = $request->file($name);
        $extension = $pictureFile->getClientOriginalExtension();
        if(!File::exists(public_path('/img/segments-products'))){
            $destinationPath = File::makeDirectory(public_path('/img/segments-products'));
        }
        $destinationPath = public_path('/img/segments-products');
        $pictureFile->move($destinationPath, str_random(32).time().'.'.$extension);
        $images = str_random(32).time().'.'.$extension;
        if($model){
        	if($model->images != '' || $model->images != null){
	            File::delete(public_path('/img/segments-products/'.$model->images));
	        }
        }
        return $images;
    }

    public function validation(Request $request)
    {
    	if($request->id)
    		return $this->isDuplicate($this->segments, ['title' => $request->title], $request->id);
    	return $this->isDuplicate($this->segments, ['title' => $request->title], null);
    }

    public function getProduct(Request $request)
    {
        $products = $this->product->select(['id', 'name', 'brand.name'])->get();
        $products->map(function($p) use ($request){
            $p->selected = false;
            $p->brand = $p->brand[0]['name'];
            if(isset($request->id)){
                $segment = $this->segments->find($request->id);
                if(in_array($p->id, $segment->products)){
                    $p->selected = true;
                }else{
                    $p->selected = false;
                }
            }
        });
        $array = collect($products)->toArray();
        array_multisort(array_map(function($element) {
            return $element['selected'] == true;
        }, $array), SORT_DESC, $array);
        
        return response()->json([
            'products' => $array,
            'total_row' => $this->product->count(),
            'skip' => $request->skip,
            'selected' => isset($request->id) ? $this->segments->find($request->id)->products : []
        ], 200);
    }

    public function getProductBACKUP(Request $request)
    {
    	$products = $this->product->select(['id', 'name', 'brand.name'])->skip(intVal($request->skip))->take(15)->get();
    	$products->map(function($p) use ($request){
    		$p->selected = false;
    		$p->brand = $p->brand[0]['name'];
	    	if(isset($request->id)){
	    		$segment = $this->segments->find($request->id);
	    		if(in_array($p->id, $segment->products)){
	    			$p->selected = true;
	    		}else{
	    			$p->selected = false;
	    		}
	    	}
    	});
    	$array = collect($products)->toArray();
    	array_multisort(array_map(function($element) {
	      	return $element['selected'] == true;
	  	}, $array), SORT_DESC, $array);
	  	
    	return response()->json([
    		'products' => $array,
    		'total_row' => $this->product->count(),
    		'skip' => $request->skip,
    		'selected' => isset($request->id) ? $this->segments->find($request->id)->products : []
    	], 200);
    }
}
