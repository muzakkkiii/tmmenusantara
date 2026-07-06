<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('partners', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 120);
            $table->string('organisasi', 160)->nullable();
            $table->string('wa', 40)->nullable();
            $table->string('email', 120)->nullable();
            $table->string('jenis', 80)->nullable();
            $table->text('pesan')->nullable();
            $table->string('status', 40)->default('Baru');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('partners');
    }
};
