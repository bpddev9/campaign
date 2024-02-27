<?php

namespace App\Http\Controllers\Api\Campaign;

use App\Http\Resources\Manual\SkillResource;
use App\Models\User;
use App\Models\Industry;
use App\Models\JobTitle;
use App\Models\Employment;
use Illuminate\Http\Request;
use App\Models\EmploymentUser;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\ResumeResource;
use App\Http\Resources\AppliedUserResource;
use App\Http\Resources\PublicationResource;
use App\Http\Resources\CertificationResource;
use App\Http\Resources\QualificationResource;
use App\Http\Resources\EmploymentUserResource;
use App\Http\Resources\WorkExperienceResource;
use App\Http\Resources\Campaign\CampaignJobResource;

class JobsController extends Controller
{
    public function index(Request $request)
    {
        $jobs = $request->user()->employments()->get();

        return CampaignJobResource::collection($jobs);
    }

    public function storeTitle(Request $request)
    {
        $data = $this->validate($request, [
            'industry_id' => ['required'],
            'position' => ['required', 'unique:job_titles,position'],
            'description' => ['required'],
        ], [
            'position.unique' => 'Title has already been taken'
        ]);

        $title = JobTitle::create($data);
        return response()->json([
            'data' => [
                'job_title_id' => $title->id,
                'position' => $title->position,
                'description' => $title->description
            ]
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'job_id' => ['nullable', 'integer', 'exists:employments,id'],
            'job_title_id' => ['required', 'integer'],
            'location_type' => ['required', 'string', Rule::in(['office', 'remote'])],
            'job_position' => ['required', 'string'],
            'job_description' => ['required'],
            'job_type' => ['required'],
            'job_schedule' => ['required'],
            'no_of_people' => ['required', 'integer'],
            'min_salary' => ['required', 'numeric'],
            'max_salary' => ['nullable', 'numeric', 'gt:min_salary'],
            'pay_rate' => ['required'],
            'can_call' => ['nullable', 'boolean'],
            'can_post_resume' => ['nullable', 'boolean'],
            'job_benefit' => ['nullable']
        ]);

        $jobData = $request->user()->employments()->updateOrCreate([
            'id' => $request->input('job_id')
        ], [
            'job_title_id' => $request->input('job_title_id'),
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
            'job_benefit' => $request->input('job_benefit'),
        ]);

        return new CampaignJobResource($jobData);
    }

    public function jobQuestions($job_id)
    {
        $questions = Employment::find($job_id)->appl_quest;

        return response()->json([
            'data' => json_decode($questions, true)
        ]);
    }

    public function storeQuestion(Request $request)
    {
        $this->validate($request, [
            'job_id' => ['required'],
            'question.*' => ['required', 'string', 'distinct']
        ]);

        $questions = collect($request->input('question'))->map(fn ($item, $key) => [
            'sl_no' => $key + 1, 'quest' => $item
        ]);

        $employ = Employment::find($request->job_id);
        $employ->update([
            'appl_quest' => $questions->toJson()
        ]);

        $questions = collect(json_decode($employ->appl_quest));

        return response()->json([
            'data' => $questions->all()
        ]);
    }

    public function show($id)
    {
        $jobData = Employment::find($id);

        return new CampaignJobResource($jobData);
    }

    public function destroy($id)
    {
        $jobData = Employment::find($id);
        $jobData->delete();

        return response()->json(null, 200);
    }

    public function infos()
    {
        $payRates = ['hourly', 'daily', 'weekly', 'monthly', 'yearly'];

        $jobTypes = ['Full time', 'Part time', 'Internship'];

        $jobSchedules = [
            'Monday to Friday',
            'Weekends only',
            'On Call',
        ];

        $industry = Industry::with('jobTitles')->get(['id', 'title']);

        return response()->json([
            'data' => [
                'pay_rates' => $payRates,
                'job_types' => $jobTypes,
                'schedules' => $jobSchedules,
                'industries' => $industry,
                'location_type' => ['office', 'remote']
            ]
        ]);
    }

    public function appliedUsers(Request $request)
    {
        $searchKey = $request->search_key ?? null;

        $applicants = EmploymentUser::distinct('users.id')
            ->join('employments', 'employments.id', '=', 'employment_user.employment_id')
            ->join('users', 'users.id', '=', 'employment_user.user_id')
            ->where('employments.user_id', auth()->id())
            ->with('user.profile')
            ->select(
                'employment_user.user_id'
            );

        if (!is_null($searchKey)) {
            $data = $applicants->whereHas('user', function ($query) use ($searchKey) {
                $query->where('name', 'like', "%{$searchKey}%");
            });
        } else {
            $data = $applicants;
        }

        return AppliedUserResource::collection($data->get());
    }

    public function appliedJobs($user_id)
    {
        $applied_jobs = EmploymentUser::where('user_id', $user_id)->with(['employment' => function ($query) {
            $query->select(
                'employments.id',
                'employments.job_description',
                'job_titles.position'
            )->leftJoin(
                'job_titles',
                'employments.job_title_id',
                '=',
                'job_titles.id'
            );
        }], 'user')->get();

        return EmploymentUserResource::collection($applied_jobs);
    }

    public function removeApplicant($applied_job_id)
    {
        $appliedJob = EmploymentUser::findOrfail($applied_job_id);
        if ($appliedJob) {
            $appliedJob->update([
                'is_rejected' => true
            ]);
            return response()->json(null, 200);
        }
    }

    public function applied($jobid)
    {
        $applies = EmploymentUser::where('employment_id', $jobid)
            ->with('user', 'employment')
            ->get();

        return EmploymentUserResource::collection($applies);
    }

    public function userResume($userid)
    {
        $user = User::find($userid);
        $skill = $user->skill()->first();

        return response()->json([
            'data' => [
                'manual' => [
                    'experiences' => WorkExperienceResource::collection($user->workExperiences),
                    'qualifications' => QualificationResource::collection($user->qualifications),
                    'publications' => PublicationResource::collection($user->publications),
                    'certificates' => CertificationResource::collection($user->certificates),
                    'awards' => CertificationResource::collection($user->awards),
                    'skills' => $skill ? new SkillResource($skill) : null,
                ],
                'uploaded' => new ResumeResource($user->resume)
            ],
        ]);
    }

    public function userAnswer($applied_job_id)
    {
        $applied = EmploymentUser::find($applied_job_id);

        return response()->json(['data' => json_decode($applied->quest_ans)]);
    }
}
