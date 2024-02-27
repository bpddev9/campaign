<?php

namespace App\Http\Resources;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class EmploymentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'industry' => $this->jobTitle->industry->title,
            'job_title' => $this->jobTitle->position,
            'job_type' => $this->job_type,
            'location_type' => $this->location_type,
            'min_salary' => $this->min_salary,
            'max_salary' => $this->max_salary,
            'pay_rate' => $this->pay_rate,
            'job_schedule' => $this->job_schedule,
            'job_excerpt' => $this->when(
                !$request->segment(4),
                fn () => $this->job_excerpt
            ),
            'job_description' => $this->when(
                $request->segment(4),
                fn () => $this->job_description
            ),
            'job_benefit' => $this->when(
                $request->segment(4),
                fn () => $this->job_benefit
            ),
            'questions' => $this->when(
                $request->segment(4) !== 'applied-jobs',
                fn () => collect(json_decode($this->appl_quest))
            ),
            'created_at' => $this->when(
                $request->segment(3) === 'employments',
                fn () => $this->created_at->format('m/d/Y')
            ),
            'applied_at' => $this->when(
                $request->segment(4) === 'applied' && $request->segment(5) === 'jobs',
                fn () => $this->pivot->created_at->format('m/d/Y')
            ),
            'company_name' => $this->company_name,
            'company_address' => $this->company_address,
            'company_phone' => $this->company_phone,
            'company_logo' => !is_null($this->logo_img) ? asset('storage/' . $this->logo_img) : null,
            'can_call' => (bool) $this->can_call,
            'can_post_resume' => (bool) $this->can_post_resume,
            'has_applied' => $this->when($request->segment(4) !== 'applied-jobs', fn () => (bool) $this->has_applied),
            'user_count' => $this->when($request->segment(3) == 'employments' && $request->segment(4), fn () => $this->user_count),
            'applied_text' => $this->when($request->segment(3) == 'employments' && $request->segment(4), fn () => $this->appliedText($this->has_applied, $this->user_count)),
            'applicant' => $this->when(
                $request->segment(4) !== 'applied-jobs',
                fn () => new UserResource($request->user())
            ),
            'is_saved' => $this->when(
                $request->segment(4),
                fn () => DB::table('saved_jobs')->where('applicant_id', $request->user()->id)->where('job_id', $this->id)->count() ? true : false
            )
        ];
    }

    private function appliedText($has_applied, $user_count)
    {
        if ($user_count == 1) {
            $text = 'user';
        } else {
            $text = Str::plural('user');
        }

        if (!$user_count) {
            return 'Be the first to apply';
        } else {
            if ($has_applied) {
                if ($user_count > 1) {
                    return 'You and ' . $user_count - 1 . ' others applied';
                } else {
                    return 'Only you applied';
                }
            } else {
                return $user_count . ' ' . $text . ' applied';
            }
        }
    }
}
