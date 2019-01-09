<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs\SendWelcomeEmail;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $this->dispatch((new SendWelcomeEmail())->delay(60 * 2));
        return view('panel.dashboard');
    }   
}
