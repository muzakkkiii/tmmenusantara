<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityReport extends Model
{
    protected $fillable = ['judul', 'tanggal', 'lokasi', 'peserta', 'ringkasan', 'img'];

    protected $casts = ['tanggal' => 'date', 'peserta' => 'integer'];
}
