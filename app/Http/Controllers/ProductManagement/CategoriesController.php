<?php

namespace App\Http\Controllers\ProductManagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Categories;
use Yajra\Datatables\Datatables;
use Box\Spout\Reader\ReaderFactory;
use Box\Spout\Writer\WriterFactory;
use Box\Spout\Common\Type;
use Rap2hpoutre\FastExcel\FastExcel;
use Auth;
use Excel;

class CategoriesController extends Controller
{   
    //Protected module categories by slug
    public function __construct()
    {
        $this->middleware('perm.acc:categories');
    }

    //public index categories
    public function index()
    {
        return view('panel.product-management.categories.index');
    }

    //find data categories
    public function find(Request $request)
    {

        if ($request->id) {
            $category = Categories::where('slug', $request->slug)->first();
            if (count($category) > 0) {
                return ($request->id == $category->id ? 'true' : 'false');
            } else {
                return 'true';
            }
        } else {
            return (Categories::where('slug', $request->slug)->first() ? 'false' : 'true');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    //view form create
    public function create()
    {
        $category = Categories::all();
        return view('panel.product-management.categories.form-create')->with(['category' => $category]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    //store data categories
    public function store(Request $request)
    {
        $category = new Categories();
        $category->name = $request->name;
        $category->slug = $request->slug;
        $category->parent = Categories::whereIn('slug',($request->parent == null ? [] : $request->parent))->get()->toArray();
        $category->save();

        return redirect()->route('category.index')->with('toastr', 'category');
    }

    //get datatables list data
    public function listData(){
        $categories = categories::all();

        return Datatables::of($categories)
            ->addColumn('action', function ($categories) {
                return
                '<button class="btn btn-success btn-sm"  data-toggle="modal" data-target="#primaryModal"
                         onclick="funcModal($(this))" data-link="' . route('category.edit', ['id' => $categories->id]) . '">
                        <i class="fa fa-pencil-square-o"></i>&nbsp;Edit category</button>' .
                '<form style="display:inline;" method="POST" action="' .
                route('category.destroy', ['id' => $categories->id]) . '">' . method_field('DELETE') . csrf_field() .
                    '<button type="button" class="btn btn-danger btn-sm" onclick="removeList($(this))"><i class="fa fa-remove"></i>&nbsp;Remove</button></form>';
            })
            ->rawColumns(['status', 'action'])
            ->make(true);
    }
    
    //reorder data categories
    public function reorder()
    {
        $categories = categories::all();
        $categories = $categories->toArray();
        $catParent = Categories::where('parent.slug', 'exists', false)->get();
        $catParent = $catParent->toArray();
        return view('panel.product-management.categories.reorder')->with(['categories' => $categories,'catParent' => $catParent]);
    }

    //export data
    public function exportData($categories){
        //target in public
        $file = public_path(). "/files/categories/category-form-import.xlsx";

        //load excel form and editing row
        $excel = Excel::selectSheetsByIndex(0)->load($file, function($reader) use ($categories) {
            //define data empty
            $category_parents = [];
            $data = [];
            foreach($categories as $category){
                $category_key = $category->slug;
                $data[] = [
                    $category->name, 
                    $category->slug,
                    "created at : ".$category->created_at
                ];
                //set category parent
                $category_parents_sub = array_map(function ($x) use ($category_key){
                    return [$category_key, $x['slug'], 'add'];
                },$category->parent);
                $category_parents = array_merge($category_parents, $category_parents_sub);
            }
            //editing sheet 1
            $reader->setActiveSheetIndex(0);
            $sheet1 = $reader->getActiveSheet();
            $sheet1->fromArray($data, null, 'A6', false, false);
            //set autosize width cell
            foreach(range('A','C') as $columnID){
                $sheet1->getColumnDimension($columnID)->setAutoSize(true);
            }
            //editing sheet 2
            $reader->setActiveSheetIndex(1);
            $sheet1 = $reader->getActiveSheet();
            $sheet1->fromArray($category_parents, null, 'A6', false, false);
            //set autosize width cell
            foreach(range('A','C') as $columnID){
                $sheet1->getColumnDimension($columnID)->setAutoSize(true);
            }
        })->setFilename('category-form-export['.date("H-i-s d-m-Y")."]")->download('xlsx');
    }

    //import form
    public function importForm(){
        return view('panel.product-management.categories.form-import');
    }

    //download import form
    public function downloadImportForm(){
        $file= public_path(). "/files/categories/category-form-import.xlsx";
        return response()->download($file);
    }

    //import data
    public function importData(Request $request){
        $file = $request->file('import');
        $filename = 'category-log-import['.date("H-i-s d-m-Y")."][".Auth::user()->email."].xlsx";
        $file->move(storage_path('exports'), $filename);

        $reader = ReaderFactory::create(Type::XLSX); // for XLSX files
        $reader->open(storage_path('exports/'.$filename));
        $sheet1[] = ['category name', 'slug', 'log status'];
        $sheet2[] = ['slug', 'parent slug', 'action', 'log status'];

        // loop semua sheet dan dapatkan sheet orders
        foreach ($reader->getSheetIterator() as $sheet) {
            if ($sheet->getName() === 'Category') {
                $i = 0;
                foreach ($sheet->getRowIterator() as $idx) {
                    $i++;
                    if($i > 5){
                        if(trim($idx[0]) != '' || trim($idx[1]) != ''){
                            if(preg_match('/^[a-z0-9]+(?:-[a-z0-9]+)*$/', $idx[1])){
                                $category = categories::where('slug', $idx[1])->update(['name' => $idx[0]]);
                                if($category){
                                    $sheet1[] = [$idx[0], $idx[1], 'success edit'];
                                }else{
                                    $category = new Categories();
                                    $category->name = $idx[0];
                                    $category->slug = $idx[1];
                                    $category->parent = [];
                                    $category->save();
                                    $sheet1[] = [$idx[0], $idx[1], 'success insert'];
                                }
                            }else{
                                $sheet1[] = [$idx[0], $idx[1], 'slug not valids, Slug only available a-z 0-9 and "-" for split character'];
                            }
                        }else{
                            $sheet1[] = [$idx[0], $idx[1], 'row not valids'];
                        }
                    }
                }
            }
            if ($sheet->getName() === 'Category Parent Set') {
                $i = 0;
                foreach ($sheet->getRowIterator() as $idx) {
                    $i++;
                    if($i > 5){
                        if(trim($idx[0]) != '' || trim($idx[1]) != ''){
                            $category = categories::where('slug', $idx[0])
                                ->pull('parent', ['slug' => $idx[1]]);
                            if($idx[2] != 'remove'){
                                $category = categories::where('slug', $idx[0])
                                    ->push('parent', Categories::where('slug',$idx[1])->get()->toArray());
                            }
                            $sheet2[] = [$idx[0], $idx[1], $idx[2], 'success update'];
                        }else{
                            $sheet1[] = [$idx[0], $idx[1], $idx[2], 'row not valids'];
                        }
                    }
                }
            }
        }
        $reader->close();

        $writer = WriterFactory::create(Type::XLSX); // for XLSX files
        $writer->openToFile(storage_path('exports/'.$filename)); // stream data directly to the browser
        $firstSheet = $writer->getCurrentSheet();
        $writer->addRows($sheet1);
        $newSheet = $writer->addNewSheetAndMakeItCurrent();
        $writer->addRows($sheet2);
        $writer->close();
        return $filename;
    }

    //for getting datatable at index
    public function show(Request $request, $action)
    {
        switch($action){
            case "list-data" : 
                return $this->listData();
                break;
            case "reorder" :
                return $this->reorder();
                break;
            case "export-data":
                //get list categories
                $categories = categories::all();
                return $this->exportData($categories);
            break;
            case "export-selected":
                $categories = categories::whereIn('_id', $request->id)->get();
                return $this->exportData($categories);
            break;
            case "import-form":
                return $this->importForm();
            break;
            case "download-import-form":
                return $this->downloadImportForm();
            break;
            default :
                return $this->index();
        }
    }

    //view form edit
    public function edit($id)
    {
        $category = Categories::find($id);
        $arrSlug = [];

        //get list array slug parent
        foreach($category->parent as $catParent){
            array_push($arrSlug,$catParent['slug']);
        }

        $categories = Categories::whereNotIn('slug', $arrSlug)->get();
        return view('panel.product-management.categories.form-edit')->with(['category' => $category, 'categories' => $categories]);
    }

    //update data categories
    public function update(Request $request, $id)
    {
        if($id == 'reorder'){
            return $this->updateReorder($request);
        }else{
            $category = Categories::find($id);
            $category->name = $request->name;
            $category->slug = $request->slug;
            $category->parent = Categories::whereIn('slug',($request->parent == null ? [] : $request->parent))->get()->toArray();
            $category->save();
            return redirect()->route('category.index')->with('update', 'category');
        }
    }

    //update reorder categories
    public function updateReorder(Request $request)
    {
        $data = $request->nestableOutput;
        $data = json_decode($data, true);

        $slugs = array_column($data, 'slug');
        Categories::where('parent.slug', 'exists', true)->update(['parent' => []]);

        function updateNested($listArr){
            foreach($listArr as $la){
                if(isset($la['children'])){
                    $parent = Categories::where('slug', $la['slug'])->first()->toArray();
                    $slugs = array_column($la['children'], 'slug');
                    Categories::whereIn('slug', $slugs)->push('parent', $parent);
                    updateNested($la['children']);
                }
            }
        }

        updateNested($data);
        return var_dump($slugs);
    }

    //delete data categories
    public function destroy($id)
    {
        $category = Categories::find($id);
        $category->delete();

        return redirect()->route('category.index')->with('dlt', 'category');
    }
}
