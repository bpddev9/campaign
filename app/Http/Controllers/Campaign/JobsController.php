<?php

namespace App\Http\Controllers\Campaign;

use App\Models\Employment;
use Illuminate\Http\Request;
use App\Models\EmploymentUser;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class JobsController extends Controller
{
    public function index()
    {
        $jobs = auth()->user()->employments()->applicantCount()->get();

        return view('campaign.jobs.index', compact('jobs'));
    }

    public function create()
    {
        $payRates = ['hourly', 'daily', 'weekly', 'monthly', 'yearly'];

        $jobTypes = ['Full time', 'Part time', 'Internship'];

        $jobSchedules = [
            'Monday to Friday',
            'Weekends only',
            'On Call',
        ];

        $jobRoles = collect(json_decode(\File::get(storage_path('app/json-db/jobtypes.json')), true));

        $jobRoles = $jobRoles->toJson();

        return view('campaign.jobs.create', compact('payRates', 'jobRoles', 'jobTypes', 'jobSchedules'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'job_title' => ['required', 'string', 'max:100'],
            'location_type' => ['required', 'string'],
            'job_position' => ['required', 'string'],
            'job_description' => ['required'],
            'job_type' => ['required'],
            'job_schedule' => ['required'],
            'no_of_people' => ['required'],
            'min_salary' => ['nullable', 'numeric'],
            'max_salary' => ['nullable', 'numeric'],
            'pay_rate' => ['required'],
            'can_call' => ['nullable'],
            'can_post_resume' => ['nullable'],
        ]);

        $request->user()->employments()->create([
            'job_title' => $request->input('job_title'),
            'job_position' => $request->input('job_position'),
            'location_type' => $request->input('location_type'),
            'job_description' => $request->input('job_description'),
            'job_type' => $request->input('job_type'),
            'job_schedule' => $request->input('job_schedule'),
            'no_of_people' => $request->input('no_of_people'),
            'min_salary' => $request->input('min_salary'),
            'max_salary' => $request->input('max_salary'),
            'pay_rate' => $request->input('pay_rate'),
            'can_call' => (int) $request->input('can_call'),
            'can_post_resume' => (int) $request->input('can_post_resume'),
        ]);

        return response()->json([
            'data' => ['success' => true, 'msg' => 'Job details registered successfully!']
        ]);
    }

    public function edit(Employment $job)
    {
        $payRates = ['hourly', 'daily', 'weekly', 'monthly', 'yearly'];

        $jobTypes = ['Full time', 'Fresher', 'Part time', 'internship'];

        $jobSchedules = [
            'Monday to Friday',
            'Weekends only',
            'Holidays',
            'On Call',
            'No Weekends',
            'Overtime'
        ];

        $jobRoles = collect(json_decode(\File::get(storage_path('app/json-db/jobtypes.json')), true));

        $jobRoles = $jobRoles->toJson();

        return view('campaign.jobs.edit', compact('job', 'payRates', 'jobSchedules', 'jobTypes', 'jobRoles'));
    }

    public function update(Request $request, Employment $job)
    {
        $this->validate($request, [
            'job_title' => ['required', 'string', 'max:100'],
            'location_type' => ['required', 'string'],
            'job_position' => ['required', 'string'],
            'job_description' => ['required'],
            'job_type' => ['required'],
            'job_schedule' => ['required'],
            'no_of_people' => ['required'],
            'min_salary' => ['nullable', 'numeric'],
            'max_salary' => ['nullable', 'numeric'],
            'pay_rate' => ['required'],
            'can_call' => ['nullable'],
            'can_post_resume' => ['nullable'],
        ]);

        $job->update([
            'job_title' => $request->input('job_title'),
            'job_position' => $request->input('job_position'),
            'location_type' => $request->input('location_type'),
            'job_description' => $request->input('job_description'),
            'job_type' => $request->input('job_type'),
            'job_schedule' => $request->input('job_schedule'),
            'no_of_people' => $request->input('no_of_people'),
            'min_salary' => $request->input('min_salary'),
            'max_salary' => $request->input('max_salary'),
            'pay_rate' => $request->input('pay_rate'),
            'can_call' => (int) $request->input('can_call'),
            'can_post_resume' => (int) $request->input('can_post_resume'),
        ]);

        return response()->json([
            'data' => [
                'success' => true, 'job' => $job
            ]
        ]);
    }

    public function destroy(Employment $job)
    {
        $job->delete();
        return back()->with('success', 'Job details removed successfully!');
    }

    public function applied($jobid)
    {
        $applies = EmploymentUser::select([
            'employment_user.created_at',
            'users.name',
            'users.email',
            'users.phone_no'
        ])->where('employment_id', $jobid)->join(
            'users',
            'users.id',
            '=',
            'employment_user.user_id'
        )->get();

        return view('campaign.jobs.applied', [
            'applies' => $applies
        ]);
    }

    public function jobApplicants()
    {
        $applicants = DB::table('employment_user')->select([
            DB::raw('
            DISTINCT users.id,
            users.name,
            users.email,
            users.phone_no
            '),
        ])
        ->join('employments', 'employments.id', '=', 'employment_user.employment_id')
        ->join('users', 'users.id', '=', 'employment_user.user_id')
        ->where('employments.user_id', auth()->id())
        ->get();

        return view('campaign.applicant_list', [
            'applicants'=> $applicants
        ]);
    }
}
