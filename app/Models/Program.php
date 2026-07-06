<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    protected $fillable = [
        'urutan', 'tag', 'judul', 'poin', 'pic_nama', 'pic_telp',
        'info', 'visual_label', 'img', 'cta_label', 'cta_route', 'aktif',
    ];

    protected $casts = [
        'aktif' => 'boolean',
        'urutan' => 'integer',
    ];
}
