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
                        <h3 class="text-lg font-bold">Daftar Pelanggaran</h3>
                        <a href="{{ route('jenis-pelanggaran.create') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-md font-bold hover:bg-indigo-700">
                            + Tambah Jenis
                        </a>
                    </div>

                    @if(session('success'))
                        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded shadow-sm">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="overflow-x-auto rounded-lg shadow">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th class="px-6 py-3 w-16">No</th>
                                    <th class="px-6 py-3">Nama Pelanggaran</th>
                                    <th class="px-6 py-3 text-center w-48">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($jenisPelanggarans as $index => $jenis)
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                        <td class="px-6 py-4 font-medium">{{ $index + 1 }}</td>
                                        <td class="px-6 py-4 font-bold text-gray-900 dark:text-white">{{ $jenis->nama_pelanggaran }}</td>
                                        <td class="px-6 py-4 text-center flex justify-center gap-3">
                                            <a href="{{ route('jenis-pelanggaran.edit', $jenis->id_jenis_pelanggaran) }}" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400">Edit</a>
                                            <form action="{{ route('jenis-pelanggaran.destroy', $jenis->id_jenis_pelanggaran) }}" method="POST" onsubmit="return confirm('Hapus master ini?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-6 py-4 text-center text-gray-400">Data jenis pelanggaran kosong.</td>
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