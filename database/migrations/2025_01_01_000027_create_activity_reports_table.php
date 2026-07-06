<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('activity_reports', function (Blueprint $table) {
            $table->id();
            $table->string('judul', 200);
            $table->date('tanggal')->nullable();
            $table->string('lokasi', 200)->nullable();
            $table->integer('peserta')->nullable();
            $table->text('ringkasan')->nullable();
            $table->string('img', 255)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activity_reports');
    }
};
