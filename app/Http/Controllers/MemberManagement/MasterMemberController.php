<?php

namespace App\Http\Controllers\MemberManagement;

use App\Http\Controllers\Controller;
use App\Levels;
use App\Member;
use App\User;
use Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Datatables;

class MasterMemberController extends Controller
{
    //Protected module master-member by slug
    public function __construct()
    {
        $this->middleware('perm.acc:master-member');
    }
    
    //Public index master-member
    public function index(){
        return view('panel.member-management.master-member.index');
    }

    //find data email
    public function find(Request $request)
    {

        if ($request->id) {
            $email = Member::where('email', $request->email)->get();
            if (count($email) > 0) {
                return ($email[0]->id == $request->id ? 'true' : 'false');
            } else {
                return 'true';
            }
        } else {
            return (Member::where('email', $request->email)->first() ? 'false' : 'true');
        }
    }
	
    //View Form create
    public function create(){
		
		$level= Levels::orderBy('point', 'ASC')->first();
        $modUser = User::where('role', 'elemMatch', array('name' => 'Sales'))->get();
        return view('panel.member-management.master-member.form-create')->with(['modUser' => $modUser, 'level' => $level]);
    }

    //Store data member 
    public function store(Request $request){

		$member = new Member();
        $member->name = $request->name;
        $member->email = $request->email;
        $member->phone = $request->phone;
        $member->point = $request->point;
        
        $level=Levels::where('_id', $request->level)->get();
        $member->level=$level->toArray();
        $member->status = ($request->status != null ? $request->status : "Unverified");
        $member->social_media = [
            [
                'status' => ($request->socialMedia != null ? true : false),
                'sosmed' => ($request->socialMedia != null ? $request->logSocialMedia : '')
            ]
        ];

        $arrLeft =[];
        for($i=0; $i < count($request->address); $i++){
            $arrLeft[] =[
                'address' => $request->address[$i],
            ];
        }
        $member->address = $arrLeft;

        $arrType =[];
        for($i=0; $i < count($request->type); $i++){
            if($request->type[$i] == "B2B"){
                $arrType[] =[
                    'type' => $request->type[$i],
                    'businessattr' =>[
                        [
                            'business' => $request->business,
                            'department' => $request->department,
                            'businesstype' => $request->businesstype,
                            'totalemployee' => $request->totalemployee,
                        ]
                    ]
                ];
            }else{
                $arrType[] =[
                    'type' => $request->type[$i],
                ];
            }
        }
        $member->type = $arrType;
        $member->dompet = $request->dompet;
        $member->koin = $request->koin;
        $member->password = bcrypt($request->password);
        $sales=user::whereIn('_id', $request->sales)->get();
        $member->sales=$sales->toArray();
        $member->save();

        if ($request->hasFile('picture')) {
			$pictureFile = $request->file('picture');
			$extension = $pictureFile->getClientOriginalExtension();
			$destinationPath = public_path('/img/avatars');
			$pictureFile->move($destinationPath, $member->id.'.'.$extension);
			$member->picture = $member->id.'.'.$extension;
		}

        $member->save();
		return redirect()->route('master-member.index')->with('toastr', 'member');
    }

    //For getting datatable at index
    public function show(Request $request, $action){
		$members = Member::all();
		
		return Datatables::of($members)
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
			->rawColumns(['status', 'action'])
			->make(true);
    }

    //view form edit
    public function edit($id){
        $member = Member::find($id);
        $modUser = User::where('role', 'elemMatch', array('name' => 'Sales'));
        if($member->sales){
            $modUser = $modUser->whereNotIn('name', array_column($member->sales,'name'))->get();
        }else{
            $modUser = $modUser->get();
        }
        
        $b2b_status = false;
        $b2c_status = false;
        $b2b_detail = [];
        foreach($member->type as $types){
            if($types['type'] == "B2B"){
                $b2b_status = true;
                $b2b_detail = (isset($types['businessattr'][0])?$types['businessattr'][0]:[]);
            }
            if($types['type'] == "B2C"){
                $b2c_status = true;
            }
        }

        return view('panel.member-management.master-member.form-edit')
        ->with([
            'member'=>$member,
            'b2b_status'=>$b2b_status,
            'b2c_status'=>$b2c_status,
            'b2b_detail'=>$b2b_detail,
            'modUser'=>$modUser
        ]);
	}

	//Update data setting
    public function update(Request $request, $id){

    	$member = Member::find($id);
        $member->name = $request->name;
        $member->email = $request->email;
        $member->phone = $request->phone;
        $member->sales = $request->sales;

        $levels=Levels::where('_id', $request->level)->get();
        $member->level=$levels->toArray();
        $member->social_media = [
            [
                'status' => ($request->socialMedia != null ? true : false),
                'sosmed' => ($request->socialMedia != null ? $request->logSocialMedia : '')
            ]
        ];

        $arrLeft =[];
        for($i=0; $i < count($request->address); $i++){
            $arrLeft[] =[
                "address_alias" => $request->addressAlias[$i],
                "receiver_name" => $request->addressAlias[$i],
                "phone_number" => $request->receiverName[$i],
                "address" => $request->phoneNumber[$i],
                "city_name" => $request->cityName[$i],
                "post_code" => $request->postCode[$i],
                "address" => $request->address[$i],
                "primary" => false,
            ];
        }
        $member->address = $arrLeft;

        $arrType =[];
        for($i=0; $i < count($request->type); $i++){
            if($request->type[$i] == "B2B"){
                $arrType[] =[
                    'type' => $request->type[$i],
                    'businessattr' =>[
                        [
                            'business' => $request->business,
                            'department' => $request->department,
                            'businesstype' => $request->businesstype,
                            'totalemployee' => $request->totalemployee,
                        ]
                    ]
                ];
            }else{
                $arrType[] =[
                    'type' => $request->type[$i],
                ];
            }
        }
        $member->type = $arrType;
        $member->status = ($request->status != null ? $request->status : "Unverified");
        $sales=user::whereIn('_id', $request->sales)->get();
        $member->sales=$sales->toArray();
		$member->save();

        if ($request->hasFile('picture')) {
			$pictureFile = $request->file('picture');
			$extension = $pictureFile->getClientOriginalExtension();
			$destinationPath = public_path('/img/avatars');
			if($member->picture != '' || $member->picture != null){
					File::delete(public_path('/img/avatars/'.$member->picture));
				}
			$pictureFile->move($destinationPath, $member->id.'.'.$extension);
			$member->picture = $member->id.'.'.$extension;
		}

		$member->save();
		return redirect()->route('master-member.index')->with('update', 'member');
    }

    //Delete data setting
    public function destroy($id){
		$member = Member::find($id);
		$member->delete();
		
		return redirect()->route('master-member.index')->with('dlt', 'member');
    }

    /**
     * export member
     * @return [type] [description]
     */
    public function export() {

        $today = date("F_j_Y");

        $members = Member::all();

        //return view('template-excel.export-member', compact('products'));
                
        $this->excelProcess($members);

    }


    /**
     * export member selected
     * @return [type] [description]
     */
    public function export_selected(Request $request) {
        
        $this->excelProcess(Member::whereIn('_id', $request->member_id)->get());

        //return view('template-excel.export-member', compact('products'));
                
        

    }

    /**
     * function global process membber export
     * @param  [type] $members [description]
     * @return [type]          [description]
     */
    private function excelProcess($members) {

        $today = date("F_j_Y");

        Excel::create('List of Members -' . $today, function ($excel) use ($members) {
            
            $excel->sheet('Data Member', function ($sheet) use ($members) {
                
                $sheet->cell(1, function ($row) {
                    $row->setFont(array(
                        'family' => 'Calibri',
                        'size'   => '12',
                        'bold'   => true
                    ));
                    $row->setBackground('#FFBF00');
                });
                
                $sheet->loadView('template-excel.export-member', compact('members'));
                
                
            });
        })
             ->download('xls');
    }


    /**
     * select2 with server side
     * return data member
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function ajaxSelect2(Request $request) {

        if ($request->ajax()) {
            
            if($request->term=="")
                $members = Member::paginate(5);
                else
                    $members = Member::where('name', 'LIKE', '%' . $request->term. '%')->paginate(10);

            
            return response()->json(array(
                "results"    => $members,
                
            ));

        } else {
            #Sent Form Validation Error
            return response()->json('Access Denied', 500);
        }
    }
    /**
     * Detail of Member
     * @param  Request $request 
     * @param (String) $id
     * @return Illuminate\Support\Facades\View
     */
    public function detail(Request $request, $id)
    {
        $member = Member::find($id);
        return view('panel.member-management.master-member.detail', [
            'member' => $member
        ]);
    }
}
