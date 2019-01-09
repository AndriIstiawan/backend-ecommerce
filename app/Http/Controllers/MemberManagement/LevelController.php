<?php

namespace App\Http\Controllers\MemberManagement;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Levels;
use Excel;
use Yajra\Datatables\Datatables;
use MongoDB\BSON\ObjectID;

class LevelController extends Controller
{
    //private data arrLevelListData
    private $arrLevel;

    //Protected module level by slug
    public function __construct(){
        $this->middleware('perm.acc:level');
    }

    public function find(Request $request){
        if($request->id){
            $level = Levels::where('key_id', $request->key_id)->first();
            if($level){
                return ($request->id == $level->id ? 'true' : 'false');
            }else{
                return 'true';
            }
        }else{
            return (levels::where('key_id', $request->key)->first() ? 'false' : 'true' );    
        }
    }
    
    //Public index level
    public function index(){
        return view('panel.member-management.level.index');
    }
	
    //View Form level
    public function create(){
        $levels = Levels::all();
        return view('panel.member-management.level.form-create')->with([
        	'levels'=>$levels
        ]);
    }

    //Store data level 
    public function store(Request $request){
        $level = new Levels();
        $level->order = $request->order;
        $level->key_id = $request->key;
        $parent=Levels::find($request->parent);
        if($parent){
            $parent->toArray();
            $parent['_id'] = new ObjectID($parent['_id']);
            $parent = [$parent];
        }else{
            $parent = [];
        }
        $level->parent = $parent;
        $level->name = $request->name;
        $level->loyalty_point = (int)$request->point;
        $level->hutang = (double)str_replace(',', '.',str_replace('.', '',$request->hutang));
        $level->save();
		return redirect()->route('level.index')->with('toastr', 'new');
    }

    //for loop level
    public function loopLevel($levels, $in){
        foreach ($levels as $level) {
            $temp = Levels::where('parent', 'elemMatch', array('key_id' => $level['key_id']));
            if(count($in) > 0){
                $temp = $temp->whereIn('_id', $in);
            }
            $temp = $temp->orderBy('order', 'ASC')->get();
            array_push($this->arrLevel, $level['key_id']);
            if(count($temp) > 0){
                $this->loopLevel($temp, []);
            }
        }
    }

    //show datatable
    public function list_data(){
        //sort order level
        $levels = Levels::where('parent.key_id', 'exists', false)->orderBy('order', 'ASC')->get();
        $this->loopLevel($levels, []);
        $levels_selected = Levels::whereIn('key_id', $this->arrLevel)->get();
        
        return Datatables::of($levels_selected)
            ->addColumn('hutang_format', function ($level) {
                return 'Rp. '.str_replace(',00','',number_format($level->hutang,2,',','.'));
            })
            ->addColumn('parent_column', function ($level) {
                if(isset($level->parent[0]['name'])){
                    return $level->parent[0]['name'];
                }else{
                    return "";
                }
            })
			->addColumn('action', function ($level) {
				return
					'<a class="btn btn-success btn-sm" href="'.route('level.edit',['id' => $level->id]).'">
                        <i class="fa fa-pencil-square-o"></i>&nbsp;Edit level</a>'.
					'<form style="display:inline;" method="POST" action="'.
						route('level.destroy',['id' => $level->id]).'">'.method_field('DELETE').csrf_field().
					'<button type="button" class="btn btn-danger btn-sm" onclick="removeList($(this))"><i class="fa fa-remove"></i>&nbsp;Remove</button></form>';
			})
			->rawColumns(['parent_column', 'hutang_format', 'action'])
			->make(true);
    }

    //export data
    public function exportData($levels){
        //target in public
        $file = public_path(). "/files/levels/levels-form-import.xlsx";
        //load excel form and editing row
        $excel = Excel::selectSheetsByIndex(0)->load($file, function($reader) use ($levels) {
            $data = [];
            foreach($levels as $level){
                $data[] = [
                    $level->order,
                    $level->key_id,
                    $level->name,
                    (isset($level->parent[0]['key_id'])?$level->parent[0]['key_id']:''),
                    $level->loyalty_point,
                    $level->hutang,
                    "created at : ".$level->created_at
                ];
            }
            //editing sheet 1
            $reader->setActiveSheetIndex(0);
            $sheet1 = $reader->getActiveSheet();
            $sheet1->fromArray($data, null, 'A6', false, false);
            //set autosize width cell
            foreach(range('A','G') as $columnID){
                $sheet1->getColumnDimension($columnID)->setAutoSize(true);
            }

        })->setFilename('levels-form-export['.date("H-i-s d-m-Y")."]")->download('xlsx');
    }

    //For getting datatable at index
    public function show(Request $request, $action){
        $this->arrLevel = [];
        switch($action){
            case "list-data":
                return $this->list_data();
            break;
            case "export-data":
                //sort order level
                $levels = Levels::where('parent.key_id', 'exists', false)->orderBy('order', 'ASC')->get();
                $this->loopLevel($levels, []);
                $levels_selected = Levels::whereIn('key_id', $this->arrLevel)->get();
                return $this->exportData($levels_selected);
            break;
            case "export-selected":
                $levels = Levels::whereIn('_id', $request->id)->where('parent.key_id', 'exists', false)->orderBy('order', 'ASC')->get();
                if(count($levels) == 0){
                    $levels = Levels::whereIn('_id', $request->id)->orderBy('order', 'ASC')->get();
                }
                $this->loopLevel($levels, $request->id);
                $levels_selected = Levels::whereIn('key_id', $this->arrLevel)->get();
                return $this->exportData($levels_selected);
            break;
            case "import-form":
                return $this->importForm();
            break;
            case "download-import-form":
                return $this->downloadImportForm();
            break;
            default:
                return redirect(route('level.index'));
            break;
        }
    }

    //view form edit
    public function edit($id){
        $level_detail = Levels::find($id);
        $levels = Levels::all();
        return view('panel.member-management.level.form-edit')
        ->with([
            'level_detail'=>$level_detail,
            'levels'=>$levels
        ]);
	}

	//Update data level
    public function update(Request $request, $id){
        $level = Levels::find($id);
        $level->order = $request->order;
        $level->key_id = $request->key;
        $parent=Levels::find($request->parent);
        if($parent){
            $parent->toArray();
            $parent['_id'] = new ObjectID($parent['_id']);
            $parent = [$parent];
        }else{
            $parent = [];
        }
        $level->parent = $parent;
        $level->name = $request->name;
        $level->loyalty_point = (int)$request->point;
        $level->hutang = (double)str_replace(',', '.',str_replace('.', '',$request->hutang));
        $level->save();
		return redirect()->route('level.index')->with('update', 'level');
    }

    //Delete data level
    public function destroy($id){
        $level = Levels::find($id);
        Levels::where('key_id', $level->key_id)->delete();
		$level->delete();
		return redirect()->route('level.index')->with('dlt', 'level');
    }
}
