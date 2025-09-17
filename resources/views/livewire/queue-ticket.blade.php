<div class="min-h-screen flex flex-col items-center justify-center bg-gray-100 p-4">

    <div class="w-full max-w-sm bg-white border border-gray-300 p-6 text-center space-y-4">

        <div class="flex flex-col items-center">
            <img src="{{ asset('images/logo_bps.png') }}" alt="Logo BPS" class="h-12 w-auto mb-2">
            <p class="font-semibold text-gray-700">BPS Kota Binjai</p>
        </div>

        <hr>

        <div class="space-y-2 py-4">
            <p class="text-gray-600">Nomor Antrian Anda:</p>
            <p class="text-5xl font-bold text-black">{{ $antrian->no_antrian }}</p>
            <p class="text-sm text-gray-500">
                {{ $antrian->created_at->isoFormat('DD MMMM YYYY') }} &nbsp;&bull;&nbsp; {{ $antrian->created_at->format('H:i') }}
            </p>
            <div>
                <span class="inline-block bg-gray-200 text-gray-800 text-sm font-medium px-3 py-1 rounded-full">
                    Jenis Pelayanan: {{ $antrian->tamu->jenis_pelayanan }}
                </span>
            </div>
        </div>

        <hr>

        <div class="text-sm text-gray-600">
            <p>Silahkan menunggu panggilan petugas</p>
            <p>Terima kasih atas kunjungan Anda</p>
        </div>

    </div>
    <div class="flex items-center space-x-4 mt-6">
        {{-- <button onclick="window.print()" class="bg-orange-500 text-white font-bold py-2 px-6 rounded-lg hover:bg-orange-600 transition">
            Cetak
        </button> --}}

        <button wire:click="downloadPdf" wire:loading.attr="disabled"
            class="text-center bg-orange-500 text-white font-bold py-2 px-6 rounded-lg hover:bg-orange-600 transition disabled:bg-orange-400">
            <span wire:loading.remove wire:target="downloadPdf">Download PDF</span>
            <span wire:loading wire:target="downloadPdf">Mendownload...</span>
        </button>
    </div>
</div>