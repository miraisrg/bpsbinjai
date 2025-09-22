<div class="min-h-screen flex flex-col items-center justify-center p-4">

    <div class="font-sans  text-xs w-full max-w-md bg-white rounded-4xl shadow-xl p-8">
        <div class="flex flex-col items-center mb-8">
            {{-- Pastikan logo ada di public/images/logo_bps.png --}}
            <img src="{{ asset('images/logo_bps.png') }}" alt="Logo BPS" class="h-24 w-auto mb-0">
            <h1 class="italic font-sans text-center text-xl font-bold text-gray-700">BADAN PUSAT STATISTIK</h1>
            <h2 class="font-sans text-center text-lg font-semibold text-gray-600">KOTA BINJAI</h2>
        </div>

        <form wire:submit="save">
            <div class="mb-5">
                <label for="nama_lengkap" class="block mb-2 text-sm font-medium text-gray-700">Nama Lengkap*</label>
                <input type="text" id="nama_lengkap" wire:model="nama_lengkap"
                    placeholder="Masukkan nama lengkap anda"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500">
                @error('nama_lengkap')
                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-5">
                <label for="kategori_instansi" class="block mb-2 text-sm font-medium text-gray-700">Kategori
                    Instansi*</label>
                <select id="kategori_instansi" wire:model="kategori_instansi"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500">
                    <option value="" disabled>--Pilih--</option>
                    @foreach ($kategoriInstansiOptions as $option)
                        <option value="{{ $option }}">{{ $option }}</option>
                    @endforeach
                </select>
                @error('kategori_instansi')
                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-5">
                <label for="nama_instansi" class="block mb-2 text-sm font-medium text-gray-700">Nama Instansi*</label>
                <input type="text" id="nama_instansi" wire:model="nama_instansi"
                    placeholder="Contoh: BPS Kota Binjai"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500">
                @error('nama_instansi')
                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-5">
                <label for="no_whatsapp" class="block mb-2 text-sm font-medium text-gray-700">No. Whatsapp*</label>
                <input type="text" id="no_whatsapp" wire:model="no_whatsapp" placeholder="Contoh: 081234567890"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500">
                @error('no_whatsapp')
                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-5">
                <label for="email" class="block mb-2 text-sm font-medium text-gray-700">Email*</label>
                <input type="email" id="email" wire:model="email" placeholder="example@email.com"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500">
                @error('email')
                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-6">
                <label for="klasifikasi_pelayanan_id" class="block mb-2 text-sm font-medium text-gray-700">
                    Klasifikasi Pelayanan*
                </label>
                <select id="klasifikasi_pelayanan_id" wire:model="klasifikasi_pelayanan_id"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500">
                    <option value="" disabled>--Pilih--</option>
                    @foreach ($klasifikasiPelayananOptions as $option)
                        <option value="{{ $option->id }}">{{ $option->nama_klasifikasi }}</option>
                    @endforeach
                </select>
                @error('klasifikasi_pelayanan_id')
                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <button type="submit"
                    class="w-full bg-green-600 text-white font-bold py-3 px-4 rounded-lg hover:bg-green-700 transition duration-300"
                    wire:loading.attr="disabled">
                    <span wire:loading.remove>Ambil Antrian</span>
                    <span wire:loading>Memproses...</span>
                </button>
            </div>
        </form>
    </div>
</div>
