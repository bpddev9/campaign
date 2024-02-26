<?php

namespace App\Http\Middleware\Api;

use Closure;
use Illuminate\Http\Request;

class CanApplyJobMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $query = \DB::table('employment_user')->where('user_id', auth()->id())->where('employment_id', $request->segment(4))->count();

        if ($query === 1) {
            return response()->json([
                'msg' => 'You have already applied for this job'
            ], 403);
        }
        
        return $next($request);
    }
}
