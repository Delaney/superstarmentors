<?php

namespace App\Services;

use App\Models\{
	Transaction,
	Wallet
};

class WalletService
{
	public static function user_wallet($user_id) {
		$wallet = Wallet::where('user_id', $user_id)->first();
		if (!$wallet) {
			$wallet = Wallet::create([
				'user_id'	=> $user_id,
				'balance'	=> 0
			]);
		}

		return $wallet;
	}

	public static function user_wallet_transactions($user_id) {
		$transactions = Transaction::where('user_id', $user_id)
			->where('transaction_group', 'wallet')
			->orderBy('id', 'desc')
			->get();

		$response = [];
		foreach ($transactions as $transaction) {
			$response[] = [
				'amount'		=> $transaction->amount,
				'type'			=> $transaction->transaction_type,
				'status'        => $transaction->payment_status,
                'notes'         => $transaction->notes,
                'created_at'    => \Carbon\Carbon::parse($transaction->created_at)->format('Y-m-d H:i:s')
			];
		}
		return $response;
	}
}