<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{
    Validator,
    Hash,
};
use App\Models\{
    User,
};

class UserController extends Controller
{
    public function signup(Request $request) {
        $validator = Validator::make(
            $request->all(),
            [
                'email'         => 'email|required|unique:users',
                'first_name'    => 'required',
                'last_name'     => 'required',
                'password'      => 'required|string|min:6',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'error'     => 'invalid_input',
                'message'   => $validator->errors()->first()
            ], 400);
        }

        $password = Hash::make($request->input('password'));

        $user = User::create([
            'first_name'    => $request->input('first_name'),
            'last_name'     => $request->input('last_name'),
            'email'         => $request->input('email'),
            'password'      => $password
        ]);

		$user->login();

        return response()->json([
            'success'   => true,
            'data'      => [
                'name'          => $user->getFullName(),
                'email'         => $user->email,
                'api_token'     => $user->api_token
            ]
        ]);
    }

    public function login(Request $request) {
        $validator = Validator::make(
            $request->all(),
            [
                'email'     => 'email|required',
                'password'  => 'required',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'error'     => 'invalid_input',
                'message'   => $validator->errors()->first()
            ], 400);
        }

        $user = User::where('email', $request->input('email'))->first();

        if (!$user || !Hash::check($request->input('password'), $user->password) || $user->account_type != 'user') {
            return response()->json([
                'error'     => 'invalid_login',
                'message'   => 'The email/password provided is incorrect'
            ], 401);
        }

        $user->login();

        return response()->json([
            'id'            => $user->id,
            'name'          => $user->getFullName(),
            'email'         => $user->email,
            'api_token'     => $user->api_token,
        ]);
    }
}
