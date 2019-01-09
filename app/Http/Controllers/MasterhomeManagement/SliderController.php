<?php

namespace App\Http\Controllers\MasterhomeManagement;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\slider;
use App\Product;
use App\Images;
use File;
use Excel;
use Yajra\Datatables\Datatables;

class SliderController extends Controller
{
    //Protected module slider by slug
    public function __construct()
    {
        $this->middleware('perm.acc:slider');
    }
    
    //public index slider
    public function index()
    {
        return view('panel.master-home.slider.index');
    }

    public function find(Request $request)
    {
        
        if ($request->id){
            $slider = slider::where('name', $request->name)->first();
            if (count($slider) > 0){
                return ($request->id == $slider->id ? 'true' : 'false');
            } else {
                return 'true';
            }
        } else {
            return (slider::where('name', $request->name)->first() ? 'false' : 'true' );    
        }
    }

    //view form create
    public function create()
    {
        return view('panel.master-home.slider.form-create');
    }

    //store data slider
    public function store(Request $request)
    {
        $slider = new slider();
        $slider->title = $request->title;
        $slider->redirect = (isset($request->redirect)?'on':'off');
        $slider->url = $request->url;
        $slider->save();

        $pictureFile = $request->file('image');
        $extension = $pictureFile->getClientOriginalExtension();
        $destinationPath = public_path('/img/sliders');
        $pictureFile->move($destinationPath, $slider->id.'.'.$extension);
        $slider->image = $slider->id.'.'.$extension;
        $slider->save();
        
        return redirect()->route('slider.index')->with('new', 'Slider');
    }

    //show datatable
    public function list_data(){
        $sliders = slider::all();
        return Datatables::of($sliders)
            ->addColumn('url_link', function ($slider) {
                $url_link = "";
                if($slider->redirect){
                    $url_link = $slider->url;
                }
                return $url_link;
            })
            ->addColumn('action', function ($slider) {
                return 
                    '<a class="btn btn-success btn-sm"  href="'.route('slider.edit',['id' => $slider->id]).'">
                        <i class="fa fa-pencil-square-o"></i>&nbsp;Edit Slider</a>'.
                    '<form style="display:inline;" method="POST" action="'.
                        route('slider.destroy',['id' => $slider->id]).'">'.method_field('DELETE').csrf_field().
                    '<button type="button" class="btn btn-danger btn-sm" onclick="removeList($(this))"><i class="fa fa-remove"></i>&nbsp;Remove</button></form>';
            })
            ->rawColumns(['url_link', 'action'])
            ->make(true);
    }

    //export data
    public function exportData($sliders){
        //target in public
        $file = public_path(). "/files/sliders/sliders-form-import.xlsx";
        $folder = public_path('/img/sliders/');
        $destPath = public_path('/img/storage/');
        $list_image = $sliders->pluck('image')->toArray();
        Images::whereIn('filename', $list_image)->delete();

        //load excel form and editing row
        $excel = Excel::selectSheetsByIndex(0)->load($file, function($reader) use ($sliders,$folder,$destPath) {
            //define data empty
            $dataImage = [];
            $data = [];
            foreach($sliders as $slider){
                //remove uploaded image in storage
                $filename = $folder.$slider->image;
                $destination = $destPath.$slider->image;
                if(File::exists($destination)) { File::delete($destination); }
                File::copy($filename,$destination);
                    
                $data[] = [$slider->title, url('/img/storage/'.$slider->image), $slider->url, $slider->redirect, "created at : ".$slider->created_at];
                $dataImage[] = [
                    'filename' => $slider->image,
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
            foreach(range('A','E') as $columnID){
                $sheet1->getColumnDimension($columnID)->setAutoSize(true);
            }
            Images::insert($dataImage);

        })->setFilename('sliders-form-export['.date("H-i-s d-m-Y")."]")->download('xlsx');
    }

    //for getting datatable at index
    public function show(Request $request, $action){
        switch($action){
            case "list-data":
                return $this->list_data();
            break;
            case "export-data":
                //get list slider
                $sliders = slider::all();
                return $this->exportData($sliders);
            break;
            case "export-selected":
                $sliders = slider::whereIn('_id', $request->id)->get();
                return $this->exportData($sliders);
            break;
            case "import-form":
                return $this->importForm();
            break;
            case "download-import-form":
                return $this->downloadImportForm();
            break;
            default:
                return redirect(route('slider.index'));
            break;
        }
    }
    
    //view form edit
    public function edit($id)
    {
        $slider = slider::find($id);
        return view('panel.master-home.slider.form-edit')->with(['slider'=>$slider]);
    }

    //update data slider
    public function update(Request $request, $id)
    {
        $slider = slider::find($id);
        $slider->title = $request->title;
        $slider->redirect = (isset($request->redirect)?'on':'off');
        $slider->url = $request->url;
        $slider->save();

        if($request->file('image')){
            $pictureFile = $request->file('image');
            $extension = $pictureFile->getClientOriginalExtension();
            $destinationPath = public_path('/img/sliders');
            File::delete(public_path('/img/sliders/'.$slider->image));
            $pictureFile->move($destinationPath, $slider->id.'.'.$extension);
            $slider->image = $slider->id.'.'.$extension;
            $slider->save();
        }

        return redirect()->route('slider.index')->with('edit', 'Slider');
    }

    //delete data slider
    public function destroy($id)
    {
        $slider = slider::find($id);
        $slider->delete();
        return redirect()->route('slider.index')->with('delete', 'Slider');
    }
}
