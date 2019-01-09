<?php

namespace App\Http\Controllers\MemberManagement;

use App\Member;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MemberPointController extends Controller
{
    protected $member;
    protected $view = 'panel.member-management.point.';

    public function __construct(Member $member)
    {
        $this->member = $member;
    }
    public function index(Request $request)
    {
        return view($this->view.'index');
    }
}
