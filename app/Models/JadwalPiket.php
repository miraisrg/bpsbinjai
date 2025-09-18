<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JadwalPiket extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'tgl_piket'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}