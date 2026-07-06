<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Finance extends Model
{
    protected $fillable = ['type', 'tgl', 'nama', 'prog', 'ket', 'amt'];

    protected $casts = [
        'tgl' => 'date',
        'amt' => 'integer',
    ];
}
