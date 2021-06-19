<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\{
    Broadcast,
    Mentor,
    Subscription
};
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;

class BroadcastController extends Controller
{
    public function create(Request $request) {
        $validator = Validator::make(
			$request->all(),
			[
		        'name'                  => 'required',
		        'category'	            => 'required',
                'broadcast_datetime'    => 'required',
                'price'                 => 'required'
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
        $broadcast->price = $request->input('price');

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

    #TODO - EDIT
    public function edit(Request $request) {
    }
    #TODO - MENTOR CANCEL
    
    public function view(Request $request) {
        $user = $request->input('user');
        $now = Carbon::now()->format('Y-m-d H:i:s');

        switch ($user->account_type) {
            case 'mentor':
                $mentor = $request->input('mentor');
                $mentor = Mentor::where('user_id', $user->id)->first();
                if ($mentor)
                    $broadcasts = $mentor->broadcasts;
                break;

            case 'user':
                $broadcasts = Broadcast::where('broadcast_datetime', '>', $now)
                    ->orderBy('created_at', 'desc')
                    ->paginate(10);
                $broadcasts->getCollection()->transform(function($broadcast) use ($user) {
                    $broadcast->subscribed = $broadcast->isSubscribed($user);
                    return $broadcast;
                });
                break;
        }

        return response()->json([
            'success'   => true,
            'data'      => [
                'broadcasts'    => $broadcasts
            ]
        ]);
    }

    public function view_subscribed(Request $request) {
        $user = $request->input('user');

        $broadcasts = DB::table('broadcasts')->orderBy('created_at', 'desc')->paginate(10);

        return response()->json([
            'success'   => true,
            'data'      => [
                'broadcasts'    => $broadcasts
            ]
        ]);
    }

    #TODO - SUBSCRIBE
    public function subscribe(Request $request) {
        $validator = Validator::make(
			$request->all(),
			[
		        'broadcast_id'  => 'required|exists:broadcasts,id',
		    ]
		);

        if($validator->fails()) {
			return response()->json([
                'error'     => 'invalid_input',
                'message'   => $validator->errors()->first()
            ]);
        }

        $user = $request->input('user');
        $user_wallet = \App\Services\WalletService::user_wallet($user->id);

        $broadcast = Broadcast::find($request->input('broadcast_id'));

        $now = \Carbon\Carbon::now()->format('Y-m-d H:i:s');
        $charge = false;
        if ($broadcast) {
            $options = (object) [
                'notes'         => "Subscribed | $now",
                'broadcast_id'  => $broadcast->id
            ];

            $amount = $broadcast->price;

            $charge = $user_wallet->charge($amount, $options);
            
            if ($charge) {
                Subscription::create([
                    'user_id'       => $user->id,
                    'broadcast_id'  => $broadcast->id
                ]);
            }
        }

        return [
            'success'   => $charge
        ];
    }

    #TODO - CANCEL BEFORE LIVE DATE
    public function user_cancel(Request $request) {
        $validator = Validator::make(
			$request->all(),
			[
		        'broadcast_id'  => 'required|exists:broadcasts,id',
		    ]
		);

        if($validator->fails()) {
			return response()->json([
                'error'     => 'invalid_input',
                'message'   => $validator->errors()->first()
            ]);
        }

        $user = $request->input('user');
        $user_wallet = \App\Services\WalletService::user_wallet($user->id);

        $broadcast = Broadcast::find($request->input('broadcast_id'));
        $cancel = false;

        // CHECK IF BROADCAST HAS STARTED
        $now = Carbon::now()->format('Y-m-d H:i:s');

        if ($now < $broadcast->broadcast_datetime) {
            // IF NOT, CANCEL SUBSCRIPTION
            $subscription = Subscription::where('user_id', $user->id)
                ->where('broadcast_id', $broadcast->id)
                ->where('cancelled', false)
                ->first();

            if ($subscription) {
                $subscription->cancel();
    
                // REFUND USER WALLET
                $msg = "Refunded for Broadcast #$broadcast->id | $now";
                $amount = $broadcast->price;
                $refund = $user_wallet->add_balance($amount, $msg);
                $cancel = $refund ? true : false;
            }
        }

        return [
            'success'   => $cancel
        ];
    }

    #TODO - EDIT

    
}
