<?php

namespace App\Http\Controllers\FooterManagement;

use App\Footers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class FooterController extends Controller
{
    //Protected module footer by slug
    public function __construct()
    {
        $this->middleware('perm.acc:footer');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    //public index footer
    public function index()
    {
        $footer = Footers::first();
        return view('panel.footer-management.footer.index')->with(['footer' => $footer]);
    }

    //find data categories
    public function find(Request $request)
    {

        if ($request->id) {
            $footer = Footers::where('slug', $request->slug)->first();
            if (count($footer) > 0) {
                return ($request->id == $footer->id ? 'true' : 'false');
            } else {
                return 'true';
            }
        } else {
            return (Footers::where('slug', $request->slug)->first() ? 'false' : 'true');
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
        $footer = Footers::first();
        return view('panel.footer-management.footer.form')->with([
            'footer' => $footer,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    //store data segment
    public function store(Request $request)
    {
        $footer = Footers::first();
        $listLeft = $this->getList("idListLeft", "Left", $request);
        $footer['left'] = [[
            'title' => $request->input("leftTitle"),
            'list' => $listLeft,
        ]];

        $listMiddle = $this->getList("idListMiddle", "Middle", $request);
        $footer['middle'] = [[
            'title' => $request->input("middleTitle"),
            'list' => $listMiddle,
        ]];

        $listRight = $this->getList("idListRight", "Right", $request);
        $footer['right'] = [[
            'title' => $request->input("rightTitle"),
            'list' => $listRight,
        ]];
        
        $footer->save();
        return redirect()->route('footer.index')->with('edit', 'Footer');
    }

    //getting list
    public function getList($id_position, $position, $request)
    {
        $list = [];
        foreach($request->input($id_position) as $id){
            switch($request->input('type'.$position.$id)){
                case "Link" :
                    $list[] = [
                        "type" => "Link",
                        "link" => $request->input('link'.$position.$id),
                        "url" => $request->input('url'.$position.$id),
                    ];
                break;
                case "Text" :
                    $list[] = [
                        "type" => "Text",
                        "text" => $request->input('text'.$position.$id),
                    ];
                break;
                case "Title" :
                    $list[] = [
                        "type" => "Title",
                        "title" => $request->input('title'.$position.$id),
                    ];
                break;
                case "Icon Text" :
                    $list[] = [
                        "type" => "Icon Text",
                        "icon" => $request->input('icon'.$position.$id),
                        "text" => $request->input('text'.$position.$id)
                    ];
                break;
            }
        }

        return $list;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //for getting datatable at index
    public function show(Request $request, $action)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //view form edit
    public function edit($id)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //update data courier
    public function update(Request $request, $id)
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //delete data carriers
    public function destroy($id)
    {
    }
}
