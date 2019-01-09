<?php

namespace App\Http\Controllers\ImageManagement;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Images;
use Yajra\Datatables\Datatables;
use File;
use Excel;

class ImageUploadController extends Controller
{
    //Protected module permission by slug
    public function __construct()
    {
        $this->middleware('perm.acc:image-upload');
    }

    //public index permission
    public function index()
    {
        return view('panel.image-management.image-upload.index');
    }

    //generate image file name
	
    //view form create 
    public function create()
    {
        return view('panel.image-management.image-upload.form-create');
    }

    //store data permission
    public function store(Request $request)
    {
        $image = new Images();
        if ($request->hasFile('file')) {
            $pictureFile = $request->file('file');
            $filename = $pictureFile->getClientOriginalName();
            $size = $pictureFile->getClientSize();
            $destinationPath = public_path('/img/storage');
            $pictureFile->move($destinationPath, $filename);

            $image->filename = $filename;
            $image->size = $size;
            $image->destinationPath = '/img/storage';
            $image->save();

            return '{
                "initialPreview":["'.asset('/img/storage/'.$filename).'"],
                "initialPreviewConfig":[
                    {
                        "caption":"'.$filename.'",
                        "size":'.$size.',
                        "url": "'.route('image-upload.destroy',['id' => $filename]).'",
                        "key":"'.$request->key.'"
                    }
                ]}';
        }else{ return '{}'; }
    }

    //for getting datatable at index
    public function show(Request $request, $action){
        $images = Images::all();
        
        return Datatables::of($images)
            ->addColumn('action', function ($images) {
                return 
                    '<form style="display:inline;" method="POST" action="'.
                        route('image-upload.destroy',['id' => $images->filename]).'">'.method_field('DELETE').csrf_field().
                    '<button type="submit" name="submit" value="submit" class="btn btn-danger btn-sm"><i class="fa fa-remove"></i>&nbsp;Remove</button></form>';
            })
            ->addColumn('fileSize', function($images){
                return number_format($images->size / 1024, 2) . ' KB';
            })
            ->addColumn('image_id', function($images){
                return $images->id;
            })
            ->make(true);
    }

    //view form edit
    public function edit($id)
    {
        return "image-upload edit";
    }

    //update data permission
    public function update(Request $request, $id)
    {
        return "image-upload update";
    }

    //delete data permission
    public function destroy(Request $request, $id)
    {
        $image = Images::where('filename', $id)->get();
        $filename = $image[0]->filename;
        $image = Images::where('filename', $id)->delete();
        File::delete(public_path('/img/storage/'.$filename));
        
        if($request->submit){
            return redirect()->route('image-upload.index')->with('dlt', 'image');
        }else{
            return '{"delete":"success"}';
        }
    }

    /**
     * export images
     * @return [type] [description]
     */
    public function export()
    {

        $images = Images::all();

        $this->excelProcess($images);
        //return view('template-excel.export-image', compact('images'));
                        
    }


    /**
     * export images
     * @return [type] [description]
     */
    public function export_selected(Request $request)
    {

        $images = Images::whereIn('_id', $request->image_id)->get();

        $this->excelProcess($images);
        //return view('template-excel.export-image', compact('images'));
                        
    }



    /**
     * global function for export images
     * @param  [type] $images [description]
     * @return [type]         [description]
     */
    private function excelProcess($images) {

        $today = date("F_j_Y");

        Excel::create('List of Images -' . $today, function ($excel) use ($images) {
            
            $excel->sheet('Data Images', function ($sheet) use ($images) {
                
                $sheet->cell(1, function ($row) {
                    $row->setFont(array(
                        'family' => 'Calibri',
                        'size'   => '12',
                        'bold'   => true
                    ));
                    $row->setBackground('#FFBF00');
                });
                
                $sheet->loadView('template-excel.export-image', compact('images'));
                
                
            });
        })
             ->download('xls');

    }
}
