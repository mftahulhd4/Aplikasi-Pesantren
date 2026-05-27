<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Manajemen Pelanggaran Santri') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-bold">Daftar Pelanggaran Santri</h3>
                        <a href="{{ route('pelanggaran.create') }}" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700">
                            + Catat Pelanggaran
                        </a>
                    </div>

                    @if(session('success'))
                        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded shadow-sm">
                            {{ session('success') }}
                        </div>
                    @endif

                    {{-- Kotak Filter Pencarian --}}
                    <form method="GET" action="{{ route('pelanggaran.index') }}" class="mb-6 p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <x-input-label for="search" :value="__('Cari Nama / ID')" />
                            <x-text-input id="search" class="block mt-1 w-full" type="text" name="search" :value="request('search')" placeholder="Ketik di sini..." />
                        </div>
                        <div>
                            <x-input-label for="id_kamar" :value="__('Kamar')" />
                            <select name="id_kamar" id="id_kamar" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm">
                                <option value="">Semua Kamar</option>
                                @foreach($kamars as $kamar)
                                    <option value="{{ $kamar->id_kamar }}" {{ request('id_kamar') == $kamar->id_kamar ? 'selected' : '' }}>{{ $kamar->nama_kamar }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <x-input-label for="id_kelas" :value="__('Kelas')" />
                            <select name="id_kelas" id="id_kelas" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm">
                                <option value="">Semua Kelas</option>
                                @foreach($kelases as $kelas)
                                    <option value="{{ $kelas->id_kelas }}" {{ request('id_kelas') == $kelas->id_kelas ? 'selected' : '' }}>{{ $kelas->nama_kelas }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex items-end gap-2">
                            <button type="submit" class="w-full px-4 py-2 bg-indigo-600 text-white rounded-md font-bold hover:bg-indigo-700">Filter</button>
                            <a href="{{ route('pelanggaran.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded-md font-bold hover:bg-gray-600">Reset</a>
                        </div>
                    </form>

                    {{-- Tabel Data --}}
                    <div class="overflow-x-auto rounded-lg shadow">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th class="px-6 py-3">ID Log</th>
                                    <th class="px-6 py-3">Nama Santri</th>
                                    <th class="px-6 py-3">Jenis Pelanggaran</th>
                                    <th class="px-6 py-3">Tanggal</th>
                                    <th class="px-6 py-3 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pelanggarans as $p)
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                        <td class="px-6 py-4 font-mono font-semibold">{{ $p->id_pelanggaran }}</td>
                                        <td class="px-6 py-4 font-bold text-gray-900 dark:text-white">
                                            {{ $p->santri->nama_santri }} <br>
                                            <span class="text-xs font-normal text-gray-400">Kamar: {{ $p->santri->kamar->nama_kamar ?? '-' }}</span>
                                        </td>
                                        <td class="px-6 py-4 text-red-600 dark:text-red-400 font-semibold">
                                            {{ $p->jenisPelanggaran->nama_pelanggaran }}
                                        </td>
                                        <td class="px-6 py-4">{{ $p->tanggal_melanggar->format('d/m/Y') }}</td>
                                        <td class="px-6 py-4 text-center flex justify-center gap-3">
                                            <a href="{{ route('pelanggaran.edit', $p->id_pelanggaran) }}" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400">Edit</a>
                                            <form action="{{ route('pelanggaran.destroy', $p->id_pelanggaran) }}" method="POST" onsubmit="return confirm('Hapus rekam pelanggaran ini?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-4 text-center text-gray-400">Belum ada catatan pelanggaran santri.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $pelanggarans->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>