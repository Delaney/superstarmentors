<?php

namespace App\Services;

use App\Models\Wallet;

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
		return [];
	}
}