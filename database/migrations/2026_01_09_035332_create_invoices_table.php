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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->date('invoice_date');
            $table->string('no');
            $table->string('invoice_no');
            $table->string('customer_id');
            $table->decimal('sst_percentage', 5, 2);
            $table->string('payment_method');
            $table->string('company_name')->nullable();
            $table->string('attention')->nullable();
            $table->text('address')->nullable();
            $table->string('phone')->nullable();
            $table->string('payment_terms')->nullable();
            $table->date('due_date')->nullable();
            $table->decimal('subtotal', 10, 2);
            $table->decimal('sst_amount', 10, 2);
            $table->decimal('final_price', 10, 2);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
