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
        $skill = $request->user()->skill()->first();
        if ($skill) {
            return new SkillResource($skill);
        }
        return response()->json([
            'msz' => 'No Skill found'
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'skill_name' => ['required', 'array']
        ]);

        $skill = $request->user()->skill()->updateOrCreate([
            'user_id' => $request->user()->id
        ], [
            'skill_name' => json_encode($request->skill_name)
        ]);

        return new SkillResource($skill);
    }
}
