<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('news', function (Blueprint $t) {
            $t->id();
            $t->string('label');           // mis. "Program 2026"
            $t->string('title');
            $t->string('img')->nullable(); // URL gambar
            $t->text('body');              // ringkasan
            $t->text('full')->nullable();  // isi "lihat selengkapnya"
            $t->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('news');
    }
};
