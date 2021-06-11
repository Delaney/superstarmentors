<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\{
    Mentor,
    User,
    ApiToken,
};
use Carbon\Carbon;
use Illuminate\Http\Request;

class MentorApiAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $error_response = [
            'error' => 'invalid_api_key',
            'message' => 'Invalid api key provided.'
        ];

        if($request->bearerToken() != null && $request->bearerToken() != "") {

            $api_token = ApiToken::where('api_token', $request->bearerToken())
                ->where('api_token_expire_at', '>', Carbon::now())
                ->first();

            if($api_token) {
                $user = User::find($api_token->user_id);
                if($user) {
                    $mentor = Mentor::where('user_id', $user->id)->first();
                    if ($mentor) {
                        $request->merge(['mentor' => $mentor, 'user' => $user]);
                    }
                    else {
                        return response()->json($error_response, 401);
                    }
                } else {
                    return response()->json($error_response, 401);
                }
            } else {
                return response()->json($error_response, 401);
            }
        } else {
            return response()->json($error_response, 401);
        }

        return $next($request);
    }
}
