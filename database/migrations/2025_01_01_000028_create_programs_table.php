<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('programs', function (Blueprint $table) {
            $table->id();
            $table->integer('urutan')->default(0);
            $table->string('tag', 200)->nullable();
            $table->string('judul', 200);
            $table->text('poin')->nullable();
            $table->string('pic_nama', 120)->nullable();
            $table->string('pic_telp', 40)->nullable();
            $table->string('info', 255)->nullable();
            $table->string('visual_label', 120)->nullable();
            $table->string('cta_label', 120)->nullable();
            $table->string('cta_route', 40)->nullable();
            $table->boolean('aktif')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('programs');
    }
};
