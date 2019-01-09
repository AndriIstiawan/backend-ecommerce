<?php

namespace App\Http\Controllers\MemberManagement;

use App\Member;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Http\Controllers\Controller;

class MemberCompanyController extends Controller
{
    protected $company;
    protected $view = 'panel.member-management.company.';

    public function __construct(Member $company)
    {
        $this->company = $company;
        $this->middleware('perm.acc:company-member');
    }

    public function __invoke(Request $request)
    {
        if($request->ajax()){
            $index = $this->company->where('type', 'elemMatch', ['type' => 'B2B'])->get();       
            return Datatables::of($index)
            ->addColumn('action', function ($member) {
                return 
                    '<center>'.
                    '<a class="btn btn-primary btn-sm" href="'.route('master-member.detail',['id' => $member->id]).'">
                        <i class="fa fa-eye"></i>&nbsp;Detail </a>'.
                    '<a class="btn btn-success btn-sm" href="'.route('master-member.edit',['id' => $member->id]).'">
                        <i class="fa fa-pencil-square-o"></i>&nbsp;Edit </a>'.
                    '<form style="display:inline;" method="POST" action="'.
                        route('master-member.destroy',['id' => $member->id]).'">'.method_field('DELETE').csrf_field().
                    '<button type="button" class="btn btn-danger btn-sm" onclick="removeList($(this))"><i class="fa fa-remove"></i>&nbsp;Remove</button></form>'.
                    '</center>';
            })
            ->addColumn('member_id', function ($member) {
                return $member->id;
            })
            ->editColumn('created_at', function($q){
                return Carbon::parse($q->created_at)->format('d F Y');
            })
            ->rawColumns(['status', 'action'])
            ->make(true);
        }
        return view($this->view . "index");
    }
}
