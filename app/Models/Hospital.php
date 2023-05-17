<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Hospital extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'nama_pasien',
        'alamat',
        'umur',
        'no_telp',
        'tanggal_pendaftaran',
        'dokter'

    ];
}
