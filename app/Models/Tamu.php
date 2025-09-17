<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tamu extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_pengunjung',
        'kategori_instansi',
        'nama_instansi',
        'no_wa',
        'email',
        'jenis_pelayanan',
    ];

    public function antrians(): HasMany
    {
        return $this->hasMany(Antrian::class);
    }
}