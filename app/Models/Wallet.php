<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'balance'
    ];

    public function charge($amount, $options) {
        // if(isset($options->notes) && $options->notes)
        //     $notes = $options->notes;

        // if($this->balance >= $amount) {
        //     $this->balance -= $amount;
        //     $this->save();

        //     $data = [
        //         'user_id'               => $this->user_id,
        //         'amount'                => $amount,
        //         'amount_sub'            => $amount,
        //         'transaction_type'      => 'debit',
        //         'payment_method'        => 'wallet',
        //         'payment_status'        => 'completed',
        //         'transaction_group'     => 'wallet',
        //         'notes'                 => $notes
        //     ];

        //     if(isset($options->order_id))
        //         $data['order_id'] = $options->order_id;

        //     $transaction = Transaction::create($data);

        //     return true;
        // }

        // return false;
    }

    public function deposit($amount, $options) {
        $this->add_balance($amount);
        $transaction = Transaction::create([
            'user_id'               => $this->user_id,
            'amount'                => $amount,
            'amount_sub'            => $amount,
            'transaction_type'      => 'credit',
            'payment_method'        => 'wallet',
            'payment_status'        => 'completed',
            'transaction_group'     => 'wallet',
            'paystack_reference'    => $options->reference,
            'notes'                 => ''
        ]);
    }

    public function add_balance($amount, $msg = '', $data = []) {
        $this->balance += $amount;
        $this->save();

        if($msg) {
            $notes = $msg;
            if(isset($options->notes) && $options->notes)
                $notes = $options->notes;

            $data = array_merge($data, [
                'user_id'               => $this->user_id,
                'amount'                => $amount,
                'amount_sub'            => $amount,
                'transaction_type'      => 'credit',
                'payment_method'        => 'wallet',
                'payment_status'        => 'completed',
                'transaction_group'     => 'wallet',
                'notes'                 => $notes
            ]);

            $transaction = Transaction::create($data);

            return $transaction;
        }

        return false;
    }

    public function remove_balance($amount, $msg = '', $data = []) {
        $this->balance -= $amount;
        $this->save();

        if($msg) {
            $notes = $msg;
            if(isset($options->notes) && $options->notes)
                $notes = $options->notes;

            $data = array_merge($data, [
                'user_id'               => $this->user_id,
                'amount'                => $amount,
                'amount_sub'            => $amount,
                'transaction_type'      => 'debit',
                'payment_method'        => 'wallet',
                'payment_status'        => 'completed',
                'transaction_group'     => 'wallet',
                'notes'                 => $notes
            ]);

            $transaction = Transaction::create($data);
        }
    }

    public function withdraw($amount, $options) {

    }
}
