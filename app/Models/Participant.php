<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Participant extends Model
{
    protected $fillable = ['nama', 'wa', 'email', 'program', 'asal', 'catatan', 'status'];
}
