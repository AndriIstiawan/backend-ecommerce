<?php

namespace App\Http\Controllers\MailManagement;

use App\Email;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\Http\Requests\MailBlast\createRequest;
use App\Jobs\MailBlast;
use App\Member;
use App\Levels;
use App\User;
use Auth;
use Illuminate\Http\Request;
use Mail;
use Yajra\Datatables\Datatables;

class MailController extends Controller
{
    //Protected module mail by slug
    public function __construct()
    {
        $this->middleware('perm.acc:mail');
    }
    
    //public index mail
    public function index()
    {
        return view('panel.email-management.mail.index');
    }
    
    //view form create
    public function create(Request $request)
    {   
    	if($request->ajax()){
            $members = Member::select('*');
            if(isset($request->type) && !empty($request->type)){
                $members = $members->where('type', 'elemMatch', ['type' => $request->type]);
            }
            if(isset($request->level) && !empty($request->level)){
                $members = $members->where('level', 'elemMatch', ['name' => $request->level]);
            }
            return Datatables::of($members->get())
            ->addColumn('member_id', function ($member) {
                return $member->id;
            })
            ->make(true);
        }
        $level = Levels::select('key_id', 'name')->get();
        return view('panel.email-management.mail.new-blast.index', [
            'levels' => $level
        ]);
    }

    //store data mail
    public function store(createRequest $request)
    {
        $mail          = new Email();
        $mail->adminId = Auth::user()->id;
        $mail->member  = $request->member_id;
        $mail->subject = $request->subject;
        $mail->content = $request->content;
        $mail->comment = $request->comment;
        $mail->save();
        dispatch(new MailBlast($mail));
        return redirect()->route('mail.index')->with('toastr', 'mail');
    }

    //for getting datatable at index
    public function show(Request $request, $action){
        $mails = Email::select(['id','adminId','member_id','subject', 'content','comment', 'created_at', 'success']);
        
        return Datatables::of($mails)
            ->addColumn('admin_email', function ($mail){
                $admin = User::find($mail['adminId']);
                return $admin['email'];
            })
            ->editColumn('subject', function($q){
                return ucwords($q->subject);
            })
            ->editColumn('created_at', function($q){
                return Carbon::parse($q->created_at)->format('d F Y');
            })
            ->editColumn('success', function($q){
                return $q->success;
            })
            ->addColumn('action', function ($mail) {
                return
                    '<center>'.
                    // '<button class="btn btn-success btn-sm"  data-toggle="modal" data-target="#primaryModal"
                    //      onclick="funcModal($(this))" data-link="'.route('mail.edit',['id' => $mail->id]).'">
                    //     <i class="fa fa-pencil-square-o"></i><span class="d-none d-sm-none">&nbsp;Edit mail</span></button>'.
                    '<form style="display:inline;" method="POST" action="'.
                        route('mail.destroy',['id' => $mail->id]).'">'.method_field('DELETE').csrf_field().
                    '<button type="button" class="btn btn-danger btn-sm" onclick="removeList($(this))"><i class="fa fa-remove"></i><span class="d-none d-inline">&nbsp;Remove</span></button></form>'.
                    '<center>';
            })
            ->rawColumns(['content', 'admin_email', 'action'])
            ->make(true);
    }
    
    
    //delete data mail
    public function destroy($id)
    {
        $mail = Email::find($id);
        $mail->delete();
        return redirect()->route('mail.index')->with('dlt', 'mail');
    }
}
