<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('finances', function (Blueprint $t) {
            $t->id();
            $t->string('type')->default('masuk'); // masuk | keluar
            $t->date('tgl');
            $t->string('nama');                   // donatur / kegiatan
            $t->string('prog')->default('Umum');
            $t->string('ket')->nullable();
            $t->bigInteger('amt')->default(0);
            $t->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('finances');
    }
};
