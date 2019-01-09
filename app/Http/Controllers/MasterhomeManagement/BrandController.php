<?php

namespace App\Http\Controllers\MasterhomeManagement;

use App\Http\Controllers\Controller;
use App\Permission;
use App\Brand;
use App\User;
use App\Images;
use Session;
use Auth;
use File;
use Excel;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class BrandController extends Controller
{
    //Protected module brands by slug
    public function __construct()
    {
        $this->middleware('perm.acc:brands');
    }
    
    //public index brands
    public function index()
    {
        return view('panel.master-home.brands.index');
    }

    public function find(Request $request){
        if($request->id){
            $brand = brand::where('slug', $request->slug)->first();
            if($brand){
                return ($request->id == $brand->id ? 'true' : 'false');
            }else{
                return 'true';
            }
        }else{
            return (brand::where('slug', $request->slug)->first() ? 'false' : 'true' );    
        }
    }

    public function create()
    {
        return view('panel.master-home.brands.form-create');
    }

    //store data brands
    public function store(Request $request)
    {
        $brand = new brand();
        $brand->name = $request->name;
        $brand->slug = $request->slug;
        $brand->save();
        
        if ($request->file('picture')) {
                $pictureFile = $request->file('picture');
                $extension = $pictureFile->getClientOriginalExtension();
                $destinationPath = public_path('/img/brands');
                if ($brand->picture != '' || $brand->picture != null) {
                    File::delete(public_path('/img/brands/' . $brand->picture));
                }
                $pictureFile->move($destinationPath, $brand->id . '.' . $extension);
                $brand->picture = $brand->id . '.' . $extension;
        }
        $brand->save();
        return redirect()->route('brands.index')->with('toastr', 'brand');
    }

    //show datatable
    public function list_data(){
        $brands = brand::select(['id', 'name','slug', 'created_at']);
        
        return Datatables::of($brands)
            ->addColumn('action', function ($brand) {
                return 
                    '<a class="btn btn-success btn-sm"  href="'.route('brands.edit',['id' => $brand->id]).'">
                        <i class="fa fa-pencil-square-o"></i>&nbsp;Edit Brands</a>'.
                    '<form style="display:inline;" method="POST" action="'.
                        route('brands.destroy',['id' => $brand->id]).'">'.method_field('DELETE').csrf_field().
                    '<button type="button" class="btn btn-danger btn-sm" onclick="removeList($(this))"><i class="fa fa-remove"></i>&nbsp;Remove</button></form>';
            })
            ->rawColumns(['status', 'action'])
            ->make(true);
    }

    //export data
    public function exportData($brands){
        //target in public
        $file = public_path(). "/files/brands/brands-form-import.xlsx";
        $folder = public_path('/img/brands/');
        $destPath = public_path('/img/storage/');
        $list_picture = $brands->pluck('picture')->toArray();
        Images::whereIn('filename', $list_picture)->delete();

        //load excel form and editing row
        $excel = Excel::selectSheetsByIndex(0)->load($file, function($reader) use ($brands,$folder,$destPath) {
            //define data empty
            $dataImage = [];
            $data = [];
            foreach($brands as $brand){
                //remove uploaded image in storage
                $filename = $folder.$brand->picture;
                $destination = $destPath.$brand->picture;
                if(File::exists($destination)) { File::delete($destination); }
                File::copy($filename,$destination);
                    
                $data[] = [$brand->name, $brand->slug, url('/img/storage/'.$brand->picture), "created at : ".$brand->created_at];
                $dataImage[] = [
                    'filename' => $brand->picture,
                    'size' => 0,
                    'destination' => '/img/storage',
                    'updated_at' => date("Y-m-d H:i:s"),
                    'created_at' => date("Y-m-d H:i:s")
                ];
            }
            //editing sheet 1
            $reader->setActiveSheetIndex(0);
            $sheet1 = $reader->getActiveSheet();
            $sheet1->fromArray($data, null, 'A6', false, false);
            //set autosize width cell
            foreach(range('A','D') as $columnID){
                $sheet1->getColumnDimension($columnID)->setAutoSize(true);
            }
            Images::insert($dataImage);

        })->setFilename('brands-form-export['.date("H-i-s d-m-Y")."]")->download('xlsx');
    }

    //import form
    public function importForm(){
        return view('panel.master-home.brands.form-import');
    }

    //download import form
    public function downloadImportForm(){
        $file= public_path(). "/files/brands/brands-form-import.xlsx";
        return response()->download($file);
    }

    //import data
    public function importData(Request $request){
        $limit_chunk = 1000000000000000;
        $file = $request->import->getRealPath();
        $filename = 'brands-form-import['.date("H-i-s d-m-Y")."][".Auth::user()->email."]";
        $excel = Excel::selectSheetsByIndex(0)->load($file)->setFilename($filename)->store('xlsx', false, true);
        $brand_excel = Excel::selectSheetsByIndex(0)->load($file)->get();
        $data = 'array(';
        $brand_collection = collect($brand_excel->toArray());
        stream_context_set_default( [
            'ssl' => [
                'verify_peer' => false,
                'verify_peer_name' => false,
            ],
        ]);

        foreach ($brand_collection->chunk($limit_chunk) as  $collection) {
            foreach($collection as $listData){
                if(!isset($listData['brand_name'])||!isset($listData['key_id'])||!isset($listData['image_url'])){
                    $data .= 'array("parent column not valid"),';
                } else {
                    $brand_name = trim($listData['brand_name']);
                    $key_id = trim($listData['key_id']);
                    $image_url = trim($listData['image_url']);
                    $data .= 'array(';
                    $data .= '"'.$brand_name.'","'.$key_id.'","'.$image_url.'",';

                    if( trim($brand_name) == "" || trim($key_id) == "" || trim($image_url) == "" ){
                        $data .= '"error import => require data is empty [brand_name,key_id,image_url]"),';
                    } else {
                        //check http:// or https://
                        if(strpos($image_url, 'https://') === false && strpos($image_url, 'http://') === false ){
                            $data .= '"error import => image url not valid "),';
                        } else {
                            $image_check = get_headers($image_url);
                            if (strpos($image_check[0], '200') == false){
                                $data .= '"error import => image not found "),';
                            } else {
                                $image_file = file_get_contents($image_url);
                                $ext = pathinfo($image_url)['extension'];
                                $brand = brand::where('slug',$key_id)->first();
                                if($brand){
                                    $brand['name'] = $brand_name;
                                    File::delete(public_path('/img/brands/' . $brand['picture']));
                                    File::put(public_path('/img/brands/'.$brand['_id']).'.'.$ext, $image_file);
                                    $brand['picture'] = $brand['_id'].'.'.$ext;
                                    $brand->save();
                                    $data .= '"editing success => "),';
                                }else{
                                    $brand = new brand();
                                    $brand->name = $brand_name;
                                    $brand->slug = $key_id;
                                    $brand->save();
                                    $brand->picture = $brand->id.'.'.$ext;
                                    File::put(public_path('/img/brands/'.$brand->id).'.'.$ext, $image_file);
                                    $brand->save();
                                    $data .= '"import success => "),';
                                }
                            }
                        }
                    }
                }
            }
        }
        $data .= ')';

        $result_status = eval('return ' . $data . ';');
        $excel = Excel::selectSheetsByIndex(0)->load($file, function($reader) use ($filename,$result_status) {
            //editing sheet 1
            $sheet0 = $reader->setActiveSheetIndex(0);
            $reader->getActiveSheet()->fromArray($result_status, null, 'A6', false, false);
        })->setFilename($filename)->store('xlsx', false, true);
        return $filename.'.xlsx';
    }

    //for getting datatable at index
    public function show(Request $request, $action){
        switch($action){
            case "list-data":
                return $this->list_data();
            break;
            case "export-data":
                //get list brand
                $brands = brand::all();
                return $this->exportData($brands);
            break;
            case "export-selected":
                $brands = brand::whereIn('_id', $request->id)->get();
                return $this->exportData($brands);
            break;
            case "import-form":
                return $this->importForm();
            break;
            case "download-import-form":
                return $this->downloadImportForm();
            break;
            default:
                return redirect(route('brands.index'));
            break;
        }
    }
    
    //view form edit
    public function edit($id)
    {
        $brand = brand::find($id);
        return view('panel.master-home.brands.form-edit')->with(['brand'=>$brand]);
    }

    //update data brands
    public function update(Request $request, $id)
    {
        $brand = brand::find($id);
        $brand->name = $request->name;
        $brand->slug = $request->slug;
        $brand->save();

        if($request->file('picture')){
            $pictureFile = $request->file('picture');
            $extension = $pictureFile->getClientOriginalExtension();
            $destinationPath = public_path('/img/brands');
            if($brand->picture != '' || $brand->picture != null){
                File::delete(public_path('/img/brands/'.$brand->picture));
            }
            $pictureFile->move($destinationPath, $brand->id.'.'.$extension);
            $brand->picture = $brand->id.'.'.$extension;
        }
        
        $brand->save();
        return redirect()->route('brands.index')->with('update', 'brand');
    }

    //delete data brands
    public function destroy($id)
    {
        $brand = brand::find($id);
        $brand->delete();
        return redirect()->route('brands.index')->with('dlt', 'brand');
    }
}
