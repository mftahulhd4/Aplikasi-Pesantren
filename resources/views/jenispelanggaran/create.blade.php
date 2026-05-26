<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tambah Jenis Pelanggaran') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{ route('jenis-pelanggaran.store') }}" method="POST" class="space-y-6">
                        @csrf
                        
                        <div>
                            <x-input-label for="nama_pelanggaran" :value="__('Nama Pelanggaran')" />
                            <x-text-input id="nama_pelanggaran" class="block mt-1 w-full" type="text" name="nama_pelanggaran" :value="old('nama_pelanggaran')" required autofocus />
                            <x-input-error :messages="$errors->get('nama_pelanggaran')" class="mt-2" />
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="kategori" :value="__('Kategori')" />
                                <select name="kategori" id="kategori" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm" required>
                                    <option value="Ringan">Ringan</option>
                                    <option value="Sedang">Sedang</option>
                                    <option value="Berat">Berat</option>
                                </select>
                            </div>
                            <div>
                                <x-input-label for="poin_minus" :value="__('Poin Minus (Angka)')" />
                                <x-text-input id="poin_minus" class="block mt-1 w-full" type="number" min="0" name="poin_minus" :value="old('poin_minus', 5)" required />
                            </div>
                        </div>

                        <div>
                            <x-input-label for="keterangan" :value="__('Keterangan / Deskripsi (Opsional)')" />
                            <textarea id="keterangan" name="keterangan" rows="3" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm">{{ old('keterangan') }}</textarea>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('jenis-pelanggaran.index') }}" class="text-sm text-gray-400 hover:text-gray-100 mr-4">Batal</a>
                            <x-primary-button>{{ __('Simpan Data') }}</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>