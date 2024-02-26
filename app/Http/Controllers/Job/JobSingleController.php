<?php

namespace App\Http\Controllers\Job;

use App\Models\Employment;
use Illuminate\Http\Request;
use App\Models\EmploymentUser;
use App\Http\Controllers\Controller;

class JobSingleController extends Controller
{
    public function __invoke($id)
    {
        $employ = Employment::with('user.companyProfile')->find($id);

        $pivot = EmploymentUser::select('*')
        ->addSelect([
            'user_count' => EmploymentUser::select(
                \DB::raw("COUNT(user_id)")
            )->where(
                'employment_id', $id
            )->limit(1)
        ])->where(
            'user_id', auth()->id()
        )->where(
            'employment_id', $id
        )->first();

        $questions = optional($employ->user->companyProfile)->appl_quest;

        if (!is_null($questions)) {
            $questions = collect(json_decode($questions))->all();
        }

        return view('jobs.single', ['employ' => $employ, 'pivot' => $pivot, 'questions' => $questions]);
    }
}
