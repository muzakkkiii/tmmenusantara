<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 120);
            $table->string('wa', 40)->nullable();
            $table->string('email', 120)->nullable();
            $table->string('peran', 40)->default('Relawan');
            $table->string('bidang', 120)->nullable();
            $table->string('alamat', 255)->nullable();
            $table->string('status', 40)->default('Aktif');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};
