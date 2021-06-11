<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\{
    Wallet,
    Transaction,
    User
};
use Carbon\Carbon;

class WalletController extends Controller
{
    public function details(Request $request) {
        $user = $request->input('user');
        $user_wallet = \App\Services\WalletService::user_wallet($user->id);
        $wallet_transactions = \App\Services\WalletService::user_wallet_transactions($user->id);

        return [
            'balance'           => $user_wallet->balance,
            'last_updated_at'   => Carbon::parse($user_wallet->updated_at)->format('Y-m-d H:i:s'),
            'history'           => $wallet_transactions
        ];
    }

    public function deposit(Request $request) {
        $user = $request->input('user');

        $validator = Validator::make(
			$request->all(),
			[
		        'amount'	=> 'required',
		        'reference'	=> 'required',
		    ]
		);

        if($validator->fails()) {
			return response()->json([
                'error'     => 'invalid_input',
                'message'   => $validator->errors()->first()
            ]);
        }

		$reference = $request->input('reference');

        $transaction = Transaction::where('paystack_reference', $reference)->first();

        $ps = new \App\Services\PaystackService;
        $trx = $ps->verify_transaction($reference);

        if (!$trx->status) {
            return response()->json([
                'error'     => 'invalid_transaction',
                'message'   => $trx->message,
            ], 400);
        }

        if($transaction) {
            return response()->json([
                'error'     => 'invalid_input',
                'message'   => 'Reference has been used before',
            ], 400);
        }

        $user_wallet = \App\Services\WalletService::user_wallet($user->id);
        $amount = $trx->data->amount / 100;
        $channel = isset($trx->data->channel) ?  $trx->data->channel : 'wallet';
        $user_wallet->deposit($amount, (object) [
            'reference' => $reference,
            'channel'   => $channel
        ]);

        return [
            'success'   => true
        ];

        return print_r($trx, true);
    }
}
