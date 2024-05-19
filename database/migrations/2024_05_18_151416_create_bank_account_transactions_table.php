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
        Schema::create('bank_account_transactions', function (Blueprint $table) {
            $table->ulid('id')->primary();

            $table->foreignUlid('bank_account_id')->constrained('bank_accounts')->cascadeOnDelete();

            $table->string('transaction_id');

            $table->string('merchant_name', 150);
            $table->string('merchant_logo_url')->nullable();

            $table->unsignedBigInteger('amount');
            $table->string('transaction_type', 7);

            $table->string('payment_channel', 15);

            $table->string('category');

            $table->dateTime('spent_at');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bank_account_transactions');
    }
};
