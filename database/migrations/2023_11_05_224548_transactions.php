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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('email_payer')->nullable();
            $table->string('email_payee')->nullable();
            $table->string('value')->nullable();
            $table->enum('status', ['success', 'fail']);
            $table->string('message')->nullable();
            $table->string('fail_code')->nullable();
            $table->dateTime('email_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
