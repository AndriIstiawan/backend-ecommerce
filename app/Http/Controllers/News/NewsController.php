<?php

namespace App\Http\Controllers\News;

use App\News;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DataTables;
use Image;
use File;

class NewsController extends Controller
{
    public function __construct(News $news)
    {
        $this->news = $news;
        $this->middleware('perm.acc:news');
    }

    public function index(Request $request)
    {
        if($request->ajax()){
            $index = $this->news->get();
            return DataTables::of($index)
            ->editColumn('title', function($index){
                return ucwords($index->title);
            })
            ->editColumn('is_publish', function($index){
                return $index->is_publish ? '<i class="fa fa-check"></i>': '<i class="fa fa-ban"></i>';
            })
            ->editColumn('created_by', function($index){
                return ucwords($index->author_create->username);
            })
            ->editColumn('image', function($index){
                return '<img src="'.asset('img/news/'.$index->image).'" alt="'.$index->title.'" width="30" height="30" class="image-hover">';
            })
            ->editColumn('created_at', function($index){
                return Carbon::parse($index->created_at)->format('d F Y');
            })
            ->addColumn('action', function ($index) {
                return 
                    '<a style="display:inline;" class="btn btn-success btn-sm" href="'.route('news.edit',['id' => $index->id]).'">
                        <i class="fa fa-pencil-square-o"></i>&nbsp;Edit</a>'.
                    '<form style="display:inline;" method="POST" action="'.
                        route('news.destroy',['id' => $index->id]).'">'.method_field('DELETE').csrf_field().
                    '<button type="button" class="btn btn-danger btn-sm" onclick="removeList($(this))"><i class="fa fa-remove"></i>&nbsp;Remove</button></form>';
            })
            ->rawColumns(['image', 'action', 'is_publish'])
            ->make(true);
        }
        return view('panel.news.index');
    }

    public function create(Request $request)
    {
        return view('panel.news.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required | unique:news | min:3',
            'description' => 'required | min:3',
            'is_publish' => 'required',
            'image' => 'required | mimes:jpg,jpeg,png,gif | max : 1024',
        ]);

        $news = $this->news;
        $news->title = $request->title;
        $news->slug = str_slug($request->title, '-');
        $news->description = $request->description;
        $news->keyword = $request->keyword;
        $news->is_publish = $request->is_publish == '0' ? false : true;
        $news->publish_date = $request->is_publish == '1' ? Carbon::today()->format('Y-m-d H:i:s') : null;
        $news->created_by = \Auth::id();
        $news->save();

        if ($request->hasFile('image')) {
            $pictureFile = $request->file('image');
            $extension = $pictureFile->getClientOriginalExtension();
            if(!File::exists(public_path('/img/news'))){
                $destinationPath = File::makeDirectory(public_path('/img/news'));
            }
            $destinationPath = public_path('/img/news');
            $pictureFile->move($destinationPath, $news->id.time().'.'.$extension);
            $news->image = $news->id.time().'.'.$extension;
        }

        $news->save();

        return redirect()->route('news.edit', ['id' => $news->id])->with('new', 'News');
    }

    public function show(Request $request, $id)
    {
        return view('panel.news.show', [
            'news' => $this->news->find($id)
        ]);
    }

    public function edit(Request $request, $id)
    {
        return view('panel.news.create', [
            'news' => $this->news->find($id)
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required | min: 3 | unique:news,'.$id,
            'description' => 'required | min: 3',
            'is_publish' => 'required',
            'image' => 'required,'.$id.' | mimes:jpg,jpeg,png,gif | max : 1024',
        ]);
        $news = $this->news->find($id);
        $news->title = $request->title;
        $news->slug = str_slug($request->title, '-');
        $news->description = $request->description;
        $news->keyword = $request->keyword;
        $news->is_publish = $request->is_publish == '0' ? false : true;
        $news->publish_date = $request->is_publish == '1' ? Carbon::today()->format('Y-m-d H:i:s') : null;
        $news->updated_by = \Auth::id();
        $news->save();

        if ($request->hasFile('image')) {
            $pictureFile = $request->file('image');
            $extension = $pictureFile->getClientOriginalExtension();
            $destinationPath = public_path('/img/news');
            if($news->image != '' || $news->image != null){
                File::delete(public_path('/img/news/'.$news->image));
            }
            $pictureFile->move($destinationPath, $news->id.time().'.'.$extension);
            $news->image = $news->id.time().'.'.$extension;
        }

        $news->save();

        return redirect()->route('news.edit', ['id' => $news->id])->with('update', 'News');
    }

    public function destroy(Request $request, $id)
    {
        File::delete(public_path('/img/news/'.$this->news->find($id)->image));
        $this->news->find($id)->forceDelete();
        return back()->with('delete', 'News');
    }

    public function validation(Request $request)
    {
        if($request->id){
            $news = $this->news->whereTitle($request->title)->first();
            if ($news) {
                return $request->id == $news->id ? 'true' : 'false';
            } else {
                return 'true';
            }
        }else{
            return $this->news->whereTitle($request->title)->exists() ? 'false' : 'true';
        }
    }
}
