<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('participants', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 120);
            $table->string('wa', 40)->nullable();
            $table->string('email', 120)->nullable();
            $table->string('program', 80)->nullable();
            $table->string('asal', 160)->nullable();
            $table->text('catatan')->nullable();
            $table->string('status', 40)->default('Baru');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('participants');
    }
};
