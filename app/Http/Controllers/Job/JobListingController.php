<?php

namespace App\Http\Controllers\Job;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\{Employment, CompanyProfile};

class JobListingController extends Controller
{
    public function __invoke(Request $request)
    {
        $jobs = Employment::query();
        
        $jobs = $jobs->select([
            'employments.*',
            'company_profiles.company_name',
            \DB::raw("DATE_FORMAT(employments.created_at, '%m-%d-%Y') as posted_on")
        ])
        ->leftJoin('company_profiles', 'company_profiles.user_id', '=', 'employments.user_id')
        ->formattedCompanyAddress()
        ->orderBy('employments.created_at', 'desc')
        ->paginate(15);

        return response()->json([
            'data' => $jobs,
        ], 200);
    }
}
