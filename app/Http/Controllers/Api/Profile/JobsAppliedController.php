<?php

namespace App\Http\Controllers\Api\Profile;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\EmploymentResource;

class JobsAppliedController extends Controller
{
    public function index(Request $request)
    {
        $myJobs = $request->user()->jobs()->select([
            'employments.*',
            'company_profiles.company_name',
            'company_profiles.logo_img',
        ])->leftJoin(
            'company_profiles', 'company_profiles.user_id', '=', 'employments.user_id'
        )->orderByPivot(
            'created_at', 'desc'
        )->get();

        return EmploymentResource::collection($myJobs);
    }
}
