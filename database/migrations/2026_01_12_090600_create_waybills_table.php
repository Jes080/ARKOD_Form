<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('waybills', function (Blueprint $table) {
            $table->id();

            // Basic Info
            $table->string('no');
            $table->string('waybill_no');
            $table->string('customer_id');
            $table->json('service_type');
            $table->date('waybill_date');

            // Shipper
            $table->string('shipper_name')->nullable();
            $table->string('shipper_attention')->nullable();
            $table->string('shipper_address');
            $table->string('shipper_postcode');
            $table->string('shipper_phone')->nullable();
            $table->string('shipper_email')->nullable();

            // Receiver
            $table->string('receiver_name')->nullable();
            $table->string('receiver_attention')->nullable();
            $table->string('receiver_address');
            $table->string('receiver_postcode');
            $table->string('receiver_phone')->nullable();
            $table->string('receiver_email')->nullable();

            // Order / Cargo
            $table->string('content')->nullable();
            $table->string('category')->nullable();
            $table->string('size')->nullable();
            $table->string('total_weight')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('waybills');
    }
};

