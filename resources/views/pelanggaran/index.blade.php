<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Master Jenis Pelanggaran') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-bold">Daftar Jenis Pelanggaran</h3>
                        <a href="{{ route('jenis-pelanggaran.create') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-md font-bold hover:bg-indigo-700">
                            + Tambah Jenis
                        </a>
                    </div>

                    @if(session('success'))
                        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="overflow-x-auto rounded-lg shadow">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th class="px-6 py-3">Nama Pelanggaran</th>
                                    <th class="px-6 py-3">Kategori</th>
                                    <th class="px-6 py-3 text-center">Poin Minus</th>
                                    <th class="px-6 py-3 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($jenisPelanggarans as $jenis)
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                        <td class="px-6 py-4 font-bold text-white">{{ $jenis->nama_pelanggaran }}</td>
                                        <td class="px-6 py-4">
                                            <span class="px-2 py-1 rounded text-xs font-bold 
                                                {{ $jenis->kategori == 'Berat' ? 'bg-red-900/50 text-red-400' : ($jenis->kategori == 'Sedang' ? 'bg-yellow-900/50 text-yellow-400' : 'bg-green-900/50 text-green-400') }}">
                                                {{ $jenis->kategori }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-center font-bold text-red-500">-{{ $jenis->poin_minus }}</td>
                                        <td class="px-6 py-4 text-center flex justify-center gap-3">
                                            <a href="{{ route('jenis-pelanggaran.edit', $jenis->id_jenis_pelanggaran) }}" class="text-blue-500 hover:text-blue-700">Edit</a>
                                            <form action="{{ route('jenis-pelanggaran.destroy', $jenis->id_jenis_pelanggaran) }}" method="POST" onsubmit="return confirm('Hapus data master ini?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="text-red-500 hover:text-red-700">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-4 text-center text-gray-400">Data jenis pelanggaran belum ada.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>