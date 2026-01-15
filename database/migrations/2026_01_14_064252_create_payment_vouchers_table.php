<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payment_vouchers', function (Blueprint $table) {
        $table->id();

        $table->string('no');
        $table->date('pv_date');
        $table->string('pv_no');

        $table->enum('pay_by', ['CASH AT BANK', 'CASH IN HAND']);

        $table->string('account_no')->default('PBBANK 3223583706');

        $table->string('ledger')->nullable();
        $table->string('pay_to');

        $table->string('ref_no')->nullable();

        $table->decimal('total_amount', 10, 2);
        $table->string('total_amount_word');

        $table->string('bank_cheque_no')->nullable();
        $table->date('cheque_date')->nullable();

        $table->string('prepared_by');
        $table->string('approved_by')->nullable();
        $table->string('received_by')->nullable();

        $table->timestamps();
    });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_vouchers');
    }
};
