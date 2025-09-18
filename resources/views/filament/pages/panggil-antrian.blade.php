<x-filament-panels::page>
    <div class="flex items-center justify-between p-4 mb-6 bg-white dark:bg-gray-800 rounded-lg shadow">
        <div class="flex items-center space-x-4">
            <span class="text-lg font-semibold">Status:</span>
            @if ($layananBuka)
                <span class="px-3 py-1 text-sm font-bold text-green-800 bg-green-200 rounded-full">BUKA</span>
            @else
                <span class="px-3 py-1 text-sm font-bold text-red-800 bg-red-200 rounded-full">TUTUP</span>
            @endif
        </div>
        <div>
            <x-filament::button wire:click="toggleLayanan" :color="$layananBuka ? 'danger' : 'success'">
                {{ $layananBuka ? 'Tutup Pelayanan' : 'Buka Pelayanan' }}
            </x-filament::button>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        <div
            class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md flex flex-col items-center justify-between min-h-[300px]">
            <h2 class="text-lg font-semibold text-gray-500 dark:text-gray-400">Loket 1 (PPID)</h2>

            @if ($dipanggilPpid)
                <div class="text-center">
                    <p class="text-gray-600">Sedang Melayani:</p>
                    <p class="text-5xl font-bold text-green-600 dark:text-green-400">{{ $dipanggilPpid->no_antrian }}
                    </p>
                    <p class="mt-2 text-gray-600 dark:text-gray-300">{{ $dipanggilPpid->tamu->nama_pengunjung }}</p>
                </div>
                <div class="flex items-center space-x-2 mt-4">
                    <x-filament::button color="success"
                        wire:click="tandaiSelesai({{ $dipanggilPpid->id }})">Selesai</x-filament::button>
                    <x-filament::button color="warning"
                        wire:click="lewatiAntrian({{ $dipanggilPpid->id }})">Lewati</x-filament::button>
                </div>
            @else
                <div class="text-center flex-grow flex flex-col justify-center">
                    @if ($berikutnyaPpid)
                        <p class="text-gray-600">Antrian Berikutnya:</p>
                        <p class="text-5xl font-bold text-blue-600 dark:text-blue-400">{{ $berikutnyaPpid->no_antrian }}
                        </p>
                        <p class="mt-2 text-gray-600 dark:text-gray-300">{{ $berikutnyaPpid->tamu->nama_pengunjung }}
                        </p>
                    @else
                        <p class="text-4xl font-bold text-gray-400 dark:text-gray-500">-</p>
                        <p class="mt-2 text-gray-500">Tidak ada antrian</p>
                    @endif
                </div>
                <div class="mt-4">
                    <x-filament::button wire:click="panggilBerikutnya('PPID')" :disabled="!$berikutnyaPpid || !$layananBuka">Panggil
                        Sekarang</x-filament::button>
                </div>
            @endif
        </div>

        <div
            class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md flex flex-col items-center justify-between min-h-[300px]">
            <h2 class="text-lg font-semibold text-gray-500 dark:text-gray-400">Loket 2 (PST)</h2>

            @if ($dipanggilPst)
                <div class="text-center">
                    <p class="text-gray-600">Sedang Melayani:</p>
                    <p class="text-5xl font-bold text-green-600 dark:text-green-400">{{ $dipanggilPst->no_antrian }}</p>
                    <p class="mt-2 text-gray-600 dark:text-gray-300">{{ $dipanggilPst->tamu->nama_pengunjung }}</p>
                </div>
                <div class="flex items-center space-x-2 mt-4">
                    <x-filament::button color="success"
                        wire:click="tandaiSelesai({{ $dipanggilPst->id }})">Selesai</x-filament::button>
                    <x-filament::button color="warning"
                        wire:click="lewatiAntrian({{ $dipanggilPst->id }})">Lewati</x-filament::button>
                </div>
            @else
                <div class="text-center flex-grow flex flex-col justify-center">
                    @if ($berikutnyaPst)
                        <p class="text-gray-600">Antrian Berikutnya:</p>
                        <p class="text-5xl font-bold text-blue-600 dark:text-blue-400">{{ $berikutnyaPst->no_antrian }}
                        </p>
                        <p class="mt-2 text-gray-600 dark:text-gray-300">{{ $berikutnyaPst->tamu->nama_pengunjung }}
                        </p>
                    @else
                        <p class="text-4xl font-bold text-gray-400 dark:text-gray-500">-</p>
                        <p class="mt-2 text-gray-500">Tidak ada antrian</p>
                    @endif
                </div>
                <div class="mt-4">
                    <x-filament::button wire:click="panggilBerikutnya('PST')" :disabled="!$berikutnyaPst || !$layananBuka">Panggil
                        Sekarang</x-filament::button>
                </div>
            @endif
        </div>

    </div>

    {{-- Script untuk Text-to-Speech (Suara) --}}
    @push('scripts')
        <script>
            document.addEventListener('livewire:initialized', () => {
                Livewire.on('play-sound', (event) => {
                    const numberToRead = event.number.replace(/-/g, ' ');
                    const textToSpeak = `Nomor antrian, ${numberToRead}, silahkan menuju ke loket`;

                    const utterance = new SpeechSynthesisUtterance(textToSpeak);
                    utterance.lang = 'id-ID';
                    utterance.rate = 0.9;

                    window.speechSynthesis.cancel();
                    window.speechSynthesis.speak(utterance);
                });
            });
        </script>
    @endpush
</x-filament-panels::page>
