<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('donations', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 120);
            $table->string('wa', 40)->nullable();
            $table->string('email', 120)->nullable();
            $table->unsignedBigInteger('nominal')->default(0);
            $table->string('program', 60)->nullable();
            $table->string('metode', 20)->default('transfer');
            $table->string('status', 40)->default('Menunggu Verifikasi');
            $table->text('catatan')->nullable();
            $table->string('bukti', 255)->nullable();
            $table->string('gateway_ref', 120)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('donations');
    }
};
