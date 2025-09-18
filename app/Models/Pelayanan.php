<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pelayanan extends Model
{
    use HasFactory;

    protected $fillable = [
        'antrian_id',
        'user_id',
        'klasifikasi_pelayanan_id',
        'kebutuhan_pengaduan',
        'status_pelayanan',
        'tgl_penyelesaian',
        'keterangan',
    ];

    public function antrian(): BelongsTo
    {
        return $this->belongsTo(Antrian::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function klasifikasi(): BelongsTo
    {
        return $this->belongsTo(KlasifikasiPelayanan::class, 'klasifikasi_pelayanan_id');
    }
}