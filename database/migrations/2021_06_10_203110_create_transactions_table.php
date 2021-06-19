<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->bigInteger('broadcast_id')->nullable();
            $table->string('paystack_reference')->nullable();
            $table->enum('transaction_type', ['credit', 'debit']);
            $table->enum('transaction_group', ['wallet', 'broadcast']);
            $table->enum('payment_method', ['wallet', 'card', 'bank', 'ussd']);
            $table->string('payment_status')->default('pending');
            $table->text('notes')->nullable();
            $table->decimal('amount', 10, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
