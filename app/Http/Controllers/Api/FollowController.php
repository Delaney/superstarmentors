<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\{
    Mentor,
    User
};

class FollowController extends Controller
{
    public function following(Request $request) {
        $user = $request->input('user');
        $following = $user->followings->map(function($user) {
            return $user->mentor;
        });

        return [
            'success'   => true,
            'data'      => $following
        ];
    }

    public function follow(Request $request) {
        $validator = Validator::make(
            $request->all(),
            [
                'mentor_id' => 'required|exists:mentors,id'
            ]
        );

        if($validator->fails()) {
            return response()->json([
                'error'     => 'invalid_input',
                'message'   => $validator->errors()->first()
            ]);
        }

        $user = $request->input('user');
        $mentor_user = Mentor::find($request->input('mentor_id'))->user;

        $user->follow($mentor_user);

        return [
            'success'   => true
        ];
    }

    public function unfollow(Request $request) {
        $validator = Validator::make(
            $request->all(),
            [
                'mentor_id' => 'required|exists:mentors,id'
            ]
        );

        if($validator->fails()) {
            return response()->json([
                'error'     => 'invalid_input',
                'message'   => $validator->errors()->first()
            ]);
        }

        $user = $request->input('user');
        $mentor_user = Mentor::find($request->input('mentor_id'))->user;

        $user->unfollow($mentor_user);

        return [
            'success'   => true
        ];
    }
}
