<?php

namespace App\Filament\Resources\Pelayanans\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;
use App\Models\Antrian;
use App\Models\Tamu;
use App\Models\KlasifikasiPelayanan;

class PelayananForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([
                Select::make('antrian_id')
                    ->label('Nomor Antrian Tamu')
                    ->options(
                        Antrian::whereDate('tanggal_antrian', today())
                            ->with(['tamu', 'klasifikasi'])
                            ->get()
                            ->mapWithKeys(fn($antrian) => [
                                $antrian->id => $antrian->no_antrian . ' - ' . $antrian->tamu->nama_pengunjung
                            ])
                            ->toArray()
                    )
                    ->default(fn() => request()->query('antrian_id'))
                    ->disabled() // biar user tidak ubah
                    ->reactive() // Membuat field reactive
                    ->afterStateUpdated(function ($state, callable $set) {
                        // Otomatis set klasifikasi ketika antrian dipilih
                        if ($state) {
                            $antrian = Antrian::find($state);
                            if ($antrian && $antrian->klasifikasi_pelayanan_id) {
                                $set('klasifikasi_pelayanan_id', $antrian->klasifikasi_pelayanan_id);
                            }
                        }
                    })
                    ->required(),

                Select::make('klasifikasi_pelayanan_id')
                    ->label('Klasifikasi Layanan')
                    ->options(function () {
                        // Ambil antrian_id dari query parameter atau record yang ada
                        $antrianId = request()->query('antrian_id');

                        // Jika ada antrian_id, ambil klasifikasi yang sesuai
                        if ($antrianId) {
                            $antrian = Antrian::find($antrianId);
                            if ($antrian && $antrian->klasifikasi_pelayanan_id) {
                                $klasifikasi = KlasifikasiPelayanan::find($antrian->klasifikasi_pelayanan_id);
                                if ($klasifikasi) {
                                    return [$klasifikasi->id => $klasifikasi->nama_klasifikasi];
                                }
                            }
                        }

                        // Fallback ke semua klasifikasi jika tidak ada antrian_id
                        return KlasifikasiPelayanan::pluck('nama_klasifikasi', 'id');
                    })
                    ->default(function () {
                        // Set default value berdasarkan antrian_id
                        $antrianId = request()->query('antrian_id');

                        if ($antrianId) {
                            $antrian = Antrian::find($antrianId);
                            return $antrian?->klasifikasi_pelayanan_id;
                        }

                        return null;
                    })
                    ->disabled() // Membuat field tidak bisa diubah seperti antrian_id
                    ->required(),

                Select::make('status_pelayanan')
                    ->label('Status Pelayanan')
                    ->options([
                        'Selesai' => 'Selesai',
                        'Perlu Tindak Lanjut' => 'Perlu Tindak Lanjut',
                        'Belum Selesai' => 'Belum Selesai',
                    ])
                    ->default('Selesai')
                    ->required(),

                DatePicker::make('tgl_penyelesaian')
                    ->label('Tanggal Penyelesaian')
                    ->default(now()),

                Textarea::make('kebutuhan_pengaduan')
                    ->label('Kebutuhan / Pengaduan')
                    ->columnSpanFull(),

                Textarea::make('keterangan')
                    ->label('Keterangan Tambahan')
                    ->columnSpanFull(),
            ]);
    }
}
