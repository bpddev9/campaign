<?php

namespace App\Http\Controllers\Api\Profile\Resume\Manual;

use App\Models\Skill;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Manual\SkillResource;

class SkillController extends Controller
{
    public function index(Request $request)
    {
        $skills = $request->user()->skills()->get();
        return SkillResource::collection($skills);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'skill_name' => ['required'],
            'skill_id' => ['nullable', 'integer']
        ]);

        $skill = $request->user()->skills()->updateOrCreate([
            'id' => $request->input('skill_id')
        ], [
            'skill_name' => $request->skill_name
        ]);

        return new SkillResource($skill);
    }
}
