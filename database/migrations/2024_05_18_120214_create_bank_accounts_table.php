<?php

use App\Enums\BankAccountStatus;
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
        Schema::create('bank_accounts', function (Blueprint $table) {
            $table->ulid('id')->primary();

            $table->foreignUlid('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignUlid('bank_id')->nullable()->constrained('banks')->cascadeOnDelete();

            $table->string('item_id');
            $table->string('account_id')->nullable();
            $table->string('mask', 4)->nullable();

            $table->string('access_token');

            $table->string('status')->default(BankAccountStatus::PENDING);

            $table->timestamp('access_token_expired_at')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bank_accounts');
    }
};
