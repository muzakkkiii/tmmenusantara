<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('leads', function (Blueprint $t) {
            $t->id();
            $t->string('nama');
            $t->string('wa')->nullable();
            $t->string('email')->nullable();
            $t->string('kategori')->default('Lainnya');
            $t->text('pesan')->nullable();
            $t->string('status')->default('Baru'); // Baru | Diproses | Selesai
            $t->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('leads');
    }
};
