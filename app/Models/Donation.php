<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    protected $fillable = [
        'nama',
        'wa',
        'email',
        'nominal',
        'program',
        'metode',
        'status',
        'catatan',
        'bukti',
        'gateway_ref',
    ];

    protected $casts = [
        'nominal' => 'integer',
    ];
}
