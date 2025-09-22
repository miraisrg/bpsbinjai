<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('tamus', function (Blueprint $table) {
            // hapus kolom lama
            if (Schema::hasColumn('tamus', 'jenis_pelayanan')) {
                $table->dropColumn('jenis_pelayanan');
            }

            // tambahkan kolom FK
            $table->unsignedBigInteger('klasifikasi_pelayanan_id')->after('email');

            $table->foreign('klasifikasi_pelayanan_id')
                ->references('id')
                ->on('klasifikasi_pelayanans')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tamus', function (Blueprint $table) {
            $table->dropForeign(['klasifikasi_pelayanan_id']);
            $table->dropColumn('klasifikasi_pelayanan_id');

            // kembalikan kolom lama kalau rollback
            $table->string('jenis_pelayanan')->nullable();
        });
    }
};
