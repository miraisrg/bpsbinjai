<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KlasifikasiPelayanan extends Model
{
    use HasFactory;

    protected $fillable = ['nama_klasifikasi'];

    public function pelayanans(): HasMany
    {
        return $this->hasMany(Pelayanan::class);
    }

    public function tamus(): HasMany
    {
        return $this->hasMany(Tamu::class, 'klasifikasi_pelayanan_id');
    }

    public function Antrians(): HasMany
    {
        return $this->hasMany(Antrian::class, 'klasifikasi_pelayanan_id');
    }
}
