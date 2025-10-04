<?php

namespace App\Livewire;

use App\Models\Tamu;
use App\Models\Antrian;
use App\Models\KlasifikasiPelayanan;
use Livewire\Component;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Title;
use Barryvdh\DomPDF\Facade\Pdf;
use Livewire\Attributes\Layout;
use App\Models\Pelayanan;


class GuestForm extends Component
{
    #[Rule('required|string|min:3|max:255')]
    public $nama_lengkap = '';

    #[Rule('required')]
    public $kategori_instansi = '';

    #[Rule('required|string|min:3|max:255')]
    public $nama_instansi = '';

    #[Rule('required|numeric|min:10')]
    public $no_whatsapp = '';

    #[Rule('required|email:rfc,dns')]
    public $email = '';

    #[Rule('required|exists:klasifikasi_pelayanans,id')]
    public $klasifikasi_pelayanan_id = '';

    public $kategoriInstansiOptions = [
        'Pemerintahan',
        'Pendidikan',
        'Swasta',
        'Perorangan',
        'Lainnya'
    ];

    public $klasifikasiPelayananOptions = [];

    public function mount()
    {
        // Ambil semua jenis pelayanan dari tabel klasifikasi
        $this->klasifikasiPelayananOptions = KlasifikasiPelayanan::all();
    }

    public function messages()
    {
        return [
            'nama_lengkap.required' => 'Nama lengkap wajib diisi.',
            'nama_lengkap.min' => 'Nama lengkap minimal harus 3 karakter.',

            'kategori_instansi.required' => 'Kategori instansi wajib dipilih.',

            'nama_instansi.required' => 'Nama instansi wajib diisi.',
            'nama_instansi.min' => 'Nama instansi minimal harus 3 karakter.',

            'no_whatsapp.required' => 'Nomor WhatsApp wajib diisi.',
            'no_whatsapp.numeric' => 'Nomor WhatsApp harus berupa angka.',
            'no_whatsapp.min' => 'Nomor WhatsApp tidak valid.',

            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format alamat email tidak valid.',

            'klasifikasi_pelayanan_id.required' => 'Jenis pelayanan wajib dipilih.',
            'klasifikasi_pelayanan_id.exists' => 'Jenis pelayanan tidak valid.',
        ];
    }

    public function save()
    {
        $validatedData = $this->validate();

        $tamu = Tamu::create([
            'nama_pengunjung' => $this->nama_lengkap,
            'kategori_instansi' => $this->kategori_instansi,
            'nama_instansi' => $this->nama_instansi,
            'no_wa' => $this->no_whatsapp,
            'email' => $this->email,
            'klasifikasi_pelayanan_id' => $this->klasifikasi_pelayanan_id,
        ]);

        $klasifikasi = KlasifikasiPelayanan::find($this->klasifikasi_pelayanan_id);

        // gunakan nama singkat untuk prefix
        $prefix = strtoupper(str_contains($klasifikasi->nama_klasifikasi, 'PST') ? 'PST' : 'PPID');

        $today = now()->format('Y-m-d');
        $lastQueueNumber = Antrian::where('tanggal_antrian', $today)
            ->where('no_antrian', 'LIKE', $prefix . '-%')
            ->count();
        $newQueueNumber = $lastQueueNumber + 1;
        $formattedQueueNumber = $prefix . '-' . str_pad($newQueueNumber, 3, '0', STR_PAD_LEFT);

        $antrian = Antrian::create([
            'tamu_id' => $tamu->id,
            'no_antrian' => $formattedQueueNumber,
            'tanggal_antrian' => $today,
            'status' => 'menunggu',
        ]);

        Pelayanan::create([
            'antrian_id' => $antrian->id,
            'user_id' => null,
            'klasifikasi_pelayanan_id' => $this->klasifikasi_pelayanan_id,

            // user_id akan diisi nanti oleh petugas yang melayani
            // klasifikasi_pelayanan_id juga akan diisi nanti
            'status_pelayanan' => 'Menunggu Dilayani', // Status awal
        ]);

        return redirect()->route('antrian.ticket', ['antrian' => $antrian->id]);
    }

    #[Title('Form Kunjungan')]
    #[Layout('components.layouts.guest')]

    public function render()
    {
        return view('livewire.guest-form', [
            'kategoriInstansiOptions' => $this->kategoriInstansiOptions,
            'jenisPelayananOptions' => $this->klasifikasiPelayananOptions,
        ]);
    }
}
