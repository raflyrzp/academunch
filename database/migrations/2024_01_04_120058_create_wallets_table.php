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
        Schema::create('wallets', function (Blueprint $table) {
            $table->id();
            $table->string('rekening')->unique();
            $table->foreignId('id_user')->constrained('users', 'id')->onDelete('cascade');
            $table->double('saldo', 10);
            $table->enum('status', ['aktif', 'blokir']);
            $table->timestamps();

            // $table->index('rekening');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wallets');
    }
};
