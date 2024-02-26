<?php

namespace App\Http\Controllers;

use App\Models\Employment;
use Illuminate\Http\Request;
use App\Models\EmploymentUser;
use Illuminate\Support\Facades\DB;

class AppliedJobController extends Controller
{
    public function index(){
        $jobs = auth()->user()->jobs()->with('user.companyProfile')->latest()->get();

        return view('jobs.applied', ['jobs' => $jobs]);
    }
}
