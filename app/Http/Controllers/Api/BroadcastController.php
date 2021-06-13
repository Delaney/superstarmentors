<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\{
    Broadcast,
    Mentor
};
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Carbon\Carbon;

class BroadcastController extends Controller
{
    public function view(Request $request)
    {
        $user = $request->input('user');

        switch ($user->account_type) {
            case 'mentor':
                $mentor = $request->input('mentor');
                $mentor = Mentor::where('user_id', $user->id)->first();
                if ($mentor)
                    $broadcasts = $mentor->broadcasts;
                break;

            case 'user':
                break;
        }

        return response()->json([
            'success'   => true,
            'data'      => [
                'broadcasts'    => $broadcasts
            ]
        ]);
    }

    public function create(Request $request)
    {
        $validator = Validator::make(
			$request->all(),
			[
		        'name'                  => 'required',
		        'category'	            => 'required',
                'broadcast_datetime'    => 'required'
		    ]
		);

        if($validator->fails()) {
			return response()->json([
                'error'     => 'invalid_input',
                'message'   => $validator->errors()->first()
            ]);
        }

        $tz = config('app.timezone');
        $mentor = $request->input('mentor');

        $broadcast = new Broadcast;

        $broadcast->mentor_id = $mentor->id;
        $broadcast->name = $request->input('name');
        $broadcast->category = $request->input('category');
        $broadcast->avatar = $request->input('avatar');
        $broadcast->description = $request->input('description');

        $broadcast_datetime = Carbon::parse($request->input('broadcast_datetime'), $tz)->format('Y-m-d H:i:s');

        if ($broadcast_datetime < Carbon::now($tz)->format('Y-m-d H:i:s')) {
            return response()->json([
                'error'     => 'invalid_input',
                'message'   => 'Broadcast datetime cannot be earlier than current time'
            ]);
        }

        $broadcast->broadcast_datetime = $broadcast_datetime;

        $broadcast->save();

        return response()->json([
            'success'   => true
        ]);
    }
}
