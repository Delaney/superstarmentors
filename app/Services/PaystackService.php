<?php

namespace App\Services;

use App\Transaction;
use App\Enums\{
	TransactionType,
	TransactionStatus,
};
use Carbon\Carbon;

/**
 * Paystack service class
 */
class PaystackService
{	
	public function jwt_request($endpoint, $token, $post) {
		// header('Content-Type: application/json');
		$ch = curl_init($endpoint);
		$post = json_encode($post);
		$authorization = "Authorization: Bearer ".$token;
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , $authorization ));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 10);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
		curl_setopt($ch, CURLOPT_TIMEOUT, 10); //timeout in seconds
		$result = curl_exec($ch);
		curl_close($ch);
		return json_decode($result);
    }

    public function jwt_get_request($endpoint, $token) {
		// header('Content-Type: application/json');
		$ch = curl_init($endpoint);
		$authorization = "Authorization: Bearer ".$token;
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , $authorization ));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 10);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
		curl_setopt($ch, CURLOPT_TIMEOUT, 10); //timeout in seconds
		$result = curl_exec($ch);
		curl_close($ch);
		return json_decode($result);
    }

	public function verify_transaction($reference) {
		$endpoint = 'https://api.paystack.co/transaction/verify/' . $reference;
		$data = $this->jwt_get_request($endpoint, getenv('PAYSTACK_SK'));

		return $data;
	}

	public function user_card_transaction_v2($card, $amount_to_charge, $options)
	{
		switch ($card->gateway) {
			case 'paystack':
				$endpoint = 'https://api.paystack.co/transaction/charge_authorization';
				$data = $this->jwt_request($endpoint, getenv('PAYSTACK_SK_2'), [
					'authorization_code' => $card->authorization_code,
					'email' => $card->user->email,
					'amount' => $amount_to_charge * 100
				]);

				echo '<pre>';
				print_r($data);

				if(!isset($data->data)) {
					return response()->json([
						'error' => 'payment_failed_2',
						'message' => 'Unable to charge payment card for account',
						'reference' => ''
					], 400);
				}

				if(isset($data->data->retry_by) && !isset($data->data->reference)) {
					return response()->json([
						'error' => 'retry_by',
						'message' => 'Unable to charge payment card for account, Retry again after : ' . $data->data->retry_by,
						'reference' => ''
					], 400);
				}

				if($data->data->status == 'failed') {
					return response()->json([
						'error' => 'payment_failed',
						'message' => $data->data->gateway_response,
						'reference' => $data->data->reference
					], 400);
				} else if($data->data->status == 'success') {
					return [
						'reference' => $data->data->reference
					];
				}
				break;
		}

		return ['success' => false];
	}

    public function fetch_transactions($options)
    {
        $query = http_build_query($options);
        $endpoint = 'https://api.paystack.co/transaction?' . $query;
        $data = $this->jwt_get_request($endpoint, getenv('PAYSTACK_SK'), $options);

        return $data;
    }
}
