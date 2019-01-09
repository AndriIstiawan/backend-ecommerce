<?php

namespace App\Http\Controllers\MemberManagement;

use App\Saldo;
use App\Member;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Http\Controllers\Controller;

class MemberSaldoController extends Controller
{
    protected $saldo;
    protected $member;
    protected $view = 'panel.member-management.saldo.';

    public function __construct(Saldo $saldo, Member $member)
    {
        $this->saldo = $saldo;
        $this->member = $member;
        $this->middleware('perm.acc:saldo-member');
    }

    public function index(Request $request)
    {
        if($request->ajax()){
            $index = $this->saldo->whereStatus('waiting')->orderBy('created_at', 'desc')->get();        
            return Datatables::of($index)
            ->addColumn('member', function ($q) {
                return $q->member->name;
            })
            ->editColumn('description', function($q){
                return ucwords($q->description);
            })
            ->editColumn('nominal', function($q){
                return price('Rp', $q->nominal);
            })
            ->editColumn('status', function($q){
                return ucwords($q->status);
            })
            ->editColumn('date', function($q){
                return Carbon::parse($q->date)->format('d F Y');
            })
            ->addColumn('action', function ($q) {
                return 
                    '<center>'.
                    '<a class="btn btn-primary btn-sm is-text-white approved" data-id="'.$q->id.'">
                        <i class="fa fa-check"></i>&nbsp;Approve </a>'.
                    '</center>';
            })
            ->make(true);
        }
        return view($this->view . "index");
    }

    public function update(Request $request, $id)
    {
        $saldo = $this->saldo->find($id);
        $saldo->status = request('status');
        $saldoIsSaved = $saldo->save();
        if($saldoIsSaved){
            $member = $this->member->find($saldo->member_id);
            $member->saldo = $member->saldo + $saldo->nominal;
            $memberIsUpdated = $member->save();
            if($memberIsUpdated){
                return response()->json(['status' => 'success']);
            }
            $saldo = $this->saldo->find($id);
            $saldo->status = 'waiting';
            $saldoIsSaved = $saldo->save();
            return response()->json(['status' => 'failure']);
        }
        return response()->json(['status' => 'failure']);
    }
}
