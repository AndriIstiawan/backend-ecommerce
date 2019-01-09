<?php

namespace App\Http\Controllers\SpecialProduct;

use App\BestProduct;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DataTables;

class BestChoiceController extends Controller
{
    private $bests;

    public function __construct(BestProduct $bests)
    {
        $this->bests = $bests;
    }

    public function index(Request $request)
    {
        if($request->ajax()){
            $bests = BestProduct::get();
            return DataTables::of($bests)
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
                        '<form style="display:inline;" method="POST" action="'.
                            route('best-choice.destroy',['id' => $index->id]).'">'.method_field('DELETE').csrf_field().
                        '<button type="button" class="btn btn-danger btn-sm" onclick="removeList($(this))"><i class="fa fa-remove"></i>&nbsp;Remove</button></form>';
                })
                ->rawColumns(['images','action'])
            ->make(true);
        }
        return view('panel.special-product.choice.index');
    }

    public function store(Request $request) 
    {
        foreach($request->product_id as $v){
            $data = [];
            if(! BestProduct::whereProductId($v)->exists())
                $data[] = [
                    'product_id' => $v,
                    'created_by' => \Auth::id(),
                    'created_at' => \Carbon\Carbon::today()->toDateTimeString(),
                ];
        }
        if(sizeof($data) > 0)
            $this->bests->insert($data);
        return redirect()->route('best-choice.index')->with('toastr', 'Best Choice');
    }

    public function destroy(Request $request, $id) 
    {
        $this->bests->find($id)->forceDelete();
        return redirect()->route('best-choice.index')->with('delete', 'Best Choice');
    }
}
