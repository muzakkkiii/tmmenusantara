<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = ['judul', 'mulai', 'selesai', 'lokasi', 'deskripsi', 'status'];

    protected $casts = ['mulai' => 'datetime', 'selesai' => 'datetime'];
}
