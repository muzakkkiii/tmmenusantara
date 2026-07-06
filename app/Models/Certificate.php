<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    protected $fillable = ['kode', 'nama', 'pelatihan', 'tanggal', 'penandatangan', 'jabatan_ttd'];

    protected $casts = ['tanggal' => 'date'];
}
