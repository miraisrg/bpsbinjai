<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\KlasifikasiPelayanan;

class Tamu extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_pengunjung',
        'kategori_instansi',
        'nama_instansi',
        'no_wa',
        'email',
        'klasifikasi_pelayanan_id',
    ];

    public function antrians(): HasMany
    {
        return $this->hasMany(Antrian::class);
    }

    public function klasifikasi(): BelongsTo
    {
        return $this->belongsTo(KlasifikasiPelayanan::class, 'klasifikasi_pelayanan_id');
    }
    public function pelayanans(): HasMany
    {
        return $this->hasMany(Pelayanan::class, 'user_id');
    }
}
