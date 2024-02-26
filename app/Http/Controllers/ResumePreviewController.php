<?php

namespace App\Http\Controllers;

use App\Models\Resume;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class ResumePreviewController extends Controller
{
    public function preview($user_id = null)
    {
        if (!is_null($user_id)) {
            $resume = Resume::where('user_id', $user_id)->first();
        }
        else {
            $resume = Resume::where('user_id', auth()->id())->first();
        }

        if (!$resume) {
            return response()->json([
                'message' => 'No Resume Found'
            ]);
        }

        return view("resume-preview", [
            "resume" => optional($resume),
        ]);
    }
}
