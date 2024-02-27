<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Http\Resources\EmploymentResource;
use App\Models\{Employment, EmploymentUser};

class EmploymentController extends Controller
{
    public function __construct()
    {
        $this->middleware(['user.role:applicant']);
    }

    public function index(Request $request)
    {
        $searchLocation = $request->location_type ?? null;
        $searchTitle = $request->job_title ?? null;

        $employments = Employment::select([
            'employments.id',
            'job_title_id',
            'job_type',
            'location_type',
            'min_salary',
            'max_salary',
            'job_schedule',
            'pay_rate',
            'appl_quest',
            DB::raw('SUBSTRING(job_description, 1, 100) as job_excerpt'),
            'employments.created_at',
            'company_profiles.company_name',
            DB::raw("CONCAT(street_address,' ',city,' ',state,' ',zip_code) as company_address"),
            'company_profiles.logo_img'
        ])->leftJoin(
            'company_profiles',
            'company_profiles.user_id',
            '=',
            'employments.user_id'
        )->with('jobTitle')->latest();


        if (!is_null($searchLocation) && !is_null($searchTitle)) {
            $data = $employments->where('location_type', $searchLocation)
                ->whereHas('jobTitle', function ($query) use ($searchTitle) {
                    $query->where('position', 'like', "%{$searchTitle}%");
                });
        } elseif (!is_null($searchLocation)) {
            $data = $employments->where('location_type', $searchLocation);
        } elseif (!is_null($searchTitle)) {
            $data = $employments->whereHas('jobTitle', function ($query) use ($searchTitle) {
                $query->where('position', 'like', "%{$searchTitle}%");
            });
        } else {
            $data = $employments;
        }

        return EmploymentResource::collection($data->get());
    }

    public function show($id)
    {
        return $id;
        $employment = Employment::select([
            'employments.*',
            'company_profiles.company_name',
            'company_profiles.logo_img',
            'users.phone_no as company_phone',
            DB::raw("CONCAT(company_profiles.street_address,' ',company_profiles.city,' ',company_profiles.state,' ',company_profiles.zip_code) as company_address")
        ])->leftJoin(
            'company_profiles',
            'company_profiles.user_id',
            '=',
            'employments.user_id'
        )->join(
            'users',
            'users.id',
            '=',
            'employments.user_id'
        )->addSelect([
            'has_applied' => EmploymentUser::select(
                DB::raw("COUNT(*)")
            )->whereColumn(
                'employment_id',
                'employments.id'
            )->where(
                'user_id',
                auth()->id()
            )->limit(1),
            'user_count' => EmploymentUser::select(
                DB::raw("COUNT(user_id)")
            )->where(
                'employment_id',
                $id
            )->limit(1),
        ])->find($id);

        return new EmploymentResource($employment);
    }

    public function jobApply(Request $request, $id)
    {
        $jobItem = Employment::select([
            'employments.*'
        ])->leftJoin(
            'company_profiles',
            'company_profiles.user_id',
            '=',
            'employments.user_id'
        )->find($id);

        $this->validate($request, [
            'name' => 'required',
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore(auth()->id())
            ],
            'phone_no' => ['required', Rule::unique('users')->ignore(auth()->id())],
            'street_address' => 'required',
            'resume_file' => [
                Rule::requiredIf($jobItem->can_post_resume && is_null($request->user()->resume)),
                'mimetypes:application/pdf,application/vnd.openxmlformats-officedocument.wordprocessingml.document,text/plain'
            ],
            'answer' => [
                'nullable',
                Rule::requiredIf(!is_null($jobItem->appl_quest))
            ]
        ], [
            'resume_file.required' => 'Please upload your resume',
            'resume_file.mimetypes' => 'Only pdf, docx and txt files are allowed'
        ]);

        $quesAns = null;

        if ($request->has('answer')) {
            $questions = collect(json_decode($jobItem->appl_quest))->map(function ($value, $index) {
                return $value->quest;
            });

            $quesAns = array_combine($questions->toArray(), json_decode($request->input('answer')));
        }

        // user update
        $request->user()->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone_no' => $request->input('phone_no'),
        ]);

        // user profile update
        $request->user()->profile()->updateOrCreate([
            'user_id' => auth()->id()
        ], [
            'street_address' => $request->input('street_address'),
        ]);

        // user resume update
        if ($request->has('resume_file')) {
            if (optional($request->user()->resume)->file_name !== null) {
                unlink(storage_path('app/public/' . $request->user()->resume->file_path));
            }

            $filePath = $request->file('resume_file')->store('uploads/resumes', 'public');

            $request->user()->resume()->updateOrCreate([
                'user_id' => auth()->id()
            ], [
                'file_name' => $request->file('resume_file')->getClientOriginalName(),
                'mime_type' => $request->file('resume_file')->getMimeType(),
                'file_path' => $filePath
            ]);
        }

        // add applied user table
        auth()->user()->jobs()->attach($jobItem->id, [
            'quest_ans' => !is_null($quesAns) ? json_encode($quesAns) : null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        if (!is_null($request->file('resume_file'))) {
            $path_file = $filePath;
        } else {
            $path_file = optional(auth()->user()->resume)->file_path;
        }

        // send email
        Mail::to($jobItem->user->email)->send(
            new \App\Mail\ApplyJobMail(
                $jobItem,
                $request->user(),
                $jobItem->can_post_resume,
                $path_file
            )
        );

        return response()->json([
            'data' => [
                'msg' => 'Job applied successfully',
                'has_applied' => true,
            ]
        ]);
    }

    public function appliedJobs()
    {
        $myJobs = request()->user()->jobs()->select([
            'employments.*',
            'company_profiles.company_name',
            'company_profiles.logo_img',
        ])->leftJoin(
            'company_profiles',
            'company_profiles.user_id',
            '=',
            'employments.user_id'
        )->orderByPivot(
            'created_at',
            'desc'
        )->get();

        return EmploymentResource::collection($myJobs);
    }

    public function saveJob(Request $request, $job_id)
    {
        $saved_job = DB::table('saved_jobs')->where('job_id', $job_id)->where('applicant_id', $request->user()->id);

        if ($saved_job->first()) {
            $saved_job->delete();

            return response()->json([
                'msz' => 'Removed Successfully'
            ]);
        } else {
            $request->user()->savedJobs()->attach($job_id, [
                'created_at' => now(),
                'updated_at' => now()
            ]);

            return response()->json([
                'msz' => 'Saved Successfully'
            ]);
        }
    }

    public function allSavedJob(Request $request)
    {
        $searchLocation = $request->location_type ?? null;
        $searchTitle = $request->job_title ?? null;

        $saved_jobs = $request->user()->savedJobs()->select([
            'employments.id',
            'job_title_id',
            'job_type',
            'location_type',
            'min_salary',
            'max_salary',
            'job_schedule',
            'pay_rate',
            'appl_quest',
            DB::raw('SUBSTRING(job_description, 1, 100) as job_excerpt'),
            'employments.created_at',
            'company_profiles.company_name',
            DB::raw("CONCAT(street_address,' ',city,' ',state,' ',zip_code) as company_address"),
            'company_profiles.logo_img'
        ])->leftJoin(
            'company_profiles',
            'company_profiles.user_id',
            '=',
            'employments.user_id'
        )->with('jobTitle');

        if (!is_null($searchLocation) && !is_null($searchTitle)) {
            $data = $saved_jobs->where('location_type', $searchLocation)
                ->whereHas('jobTitle', function ($query) use ($searchTitle) {
                    $query->where('position', 'like', "%{$searchTitle}%");
                });
        } elseif (!is_null($searchLocation)) {
            $data = $saved_jobs->where('location_type', $searchLocation);
        } elseif (!is_null($searchTitle)) {
            $data = $saved_jobs->whereHas('jobTitle', function ($query) use ($searchTitle) {
                $query->where('position', 'like', "%{$searchTitle}%");
            });
        } else {
            $data = $saved_jobs;
        }

        return EmploymentResource::collection($data->get());
    }
}
