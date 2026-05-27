<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Ubah Catatan Pelanggaran') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{ route('pelanggaran.update', $pelanggaran->id_pelanggaran) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div>
                            <x-input-label :value="__('Nama Santri Terhukum')" />
                            <x-text-input class="block mt-1 w-full bg-gray-100 dark:bg-gray-700 font-bold" type="text" :value="$pelanggaran->santri->nama_santri . ' (ID: ' . $pelanggaran->id_santri . ')'" disabled />
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="md:col-span-1">
                                <x-input-label for="id_jenis_pelanggaran" :value="__('Jenis Pelanggaran')" />
                                <select name="id_jenis_pelanggaran" id="id_jenis_pelanggaran" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm" required>
                                    @foreach($jenisPelanggarans as $jenis)
                                        <option value="{{ $jenis->id_jenis_pelanggaran }}" {{ $pelanggaran->id_jenis_pelanggaran == $jenis->id_jenis_pelanggaran ? 'selected' : '' }}>
                                            {{ $jenis->nama_pelanggaran }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="md:col-span-1">
                                <x-input-label for="tanggal_melanggar" :value="__('Tanggal Kejadian')" />
                                <x-text-input id="tanggal_melanggar" class="block mt-1 w-full" type="date" name="tanggal_melanggar" :value="$pelanggaran->tanggal_melanggar->format('Y-m-d')" required />
                            </div>

                            <div class="md:col-span-2">
                                <x-input-label for="kronologi" :value="__('Kronologi Kejadian')" />
                                <textarea id="kronologi" name="kronologi" rows="2" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm">{{ $pelanggaran->kronologi }}</textarea>
                            </div>

                            <div class="md:col-span-1">
                                <x-input-label for="sanksi" :value="__('Sanksi / Hukuman')" />
                                <x-text-input id="sanksi" class="block mt-1 w-full" type="text" name="sanksi" :value="$pelanggaran->sanksi" />
                            </div>

                            <div class="md:col-span-1">
                                <x-input-label for="keterangan" :value="__('Keterangan Tambahan')" />
                                <x-text-input id="keterangan" class="block mt-1 w-full" type="text" name="keterangan" :value="$pelanggaran->keterangan" />
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('pelanggaran.index') }}" class="text-sm text-gray-400 hover:text-gray-100 mr-4">Batal</a>
                            <x-primary-button>{{ __('Simpan Perubahan') }}</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>