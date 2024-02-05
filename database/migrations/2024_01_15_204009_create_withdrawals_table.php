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
        Schema::create('withdrawals', function (Blueprint $table) {
            $table->id();
            $table->string('rekening');
            $table->double('nominal', 12);
            $table->string('kode_unik');
            $table->enum('status', ['menunggu', 'dikonfirmasi', 'ditolak']);
            $table->timestamps();

            $table->foreign('rekening')->references('rekening')->on('wallets')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('withdrawals');
    }
};
