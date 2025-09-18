<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pelayanans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('antrian_id')->constrained('antrians')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('klasifikasi_pelayanan_id')->constrained('klasifikasi_pelayanans');
            $table->text('kebutuhan_pengaduan')->nullable();
            $table->string('status_pelayanan');
            $table->date('tgl_penyelesaian')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pelayanans');
    }
};