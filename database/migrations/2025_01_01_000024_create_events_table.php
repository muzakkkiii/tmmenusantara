<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('judul', 200);
            $table->dateTime('mulai');
            $table->dateTime('selesai')->nullable();
            $table->string('lokasi', 200)->nullable();
            $table->text('deskripsi')->nullable();
            $table->string('status', 40)->default('Terjadwal');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
