<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatAbsen extends Model
{
    use HasFactory;

    protected $table = 'absens';
    protected $fillable = ['user_id', 'name', 'nip', 'jabatan', 'photo', 'status'];
}