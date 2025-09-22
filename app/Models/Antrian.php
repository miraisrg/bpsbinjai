<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Antrian extends Model
{
    use HasFactory;

    protected $fillable = [
        'tamu_id',
        'no_antrian',
        'tanggal_antrian',
        'status',
    ];

    public function tamu(): BelongsTo
    {
        return $this->belongsTo(Tamu::class);
    }
    public function pelayanan(): BelongsTo
    {
        return $this->belongsTo(Pelayanan::class);
    }
    public function klasifikasi(): BelongsTo
    {
        return $this->belongsTo(KlasifikasiPelayanan::class, 'klasifikasi_pelayanan_id');
    }
}
