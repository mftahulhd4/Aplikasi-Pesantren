<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Catat Pelanggaran Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8 text-gray-900 dark:text-gray-100">
                    <form action="{{ route('pelanggaran.store') }}" method="POST" class="space-y-8">
                        @csrf
                        
                        {{-- 1. PILIH SANTRI --}}
                        <div class="space-y-3">
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 border-b border-gray-200 dark:border-gray-700 pb-2">1. Pilih Santri</h3>
                            <div>
                                <x-input-label for="id_santri_select" :value="__('Cari Nama atau ID Santri')" />
                                <select id="id_santri_select" class="block w-full mt-1" name="id_santri_dummy"></select>
                                <input type="hidden" name="id_santri" id="id_santri" required>
                                <x-input-error :messages="$errors->get('id_santri')" class="mt-2" />
                            </div>
                        </div>

                        {{-- KOTAK INFO DETAIL SANTRI OTOMATIS (AUTO-FILL KETIKA TERPILIH) --}}
                        <div class="mt-2 p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg border border-gray-200 dark:border-gray-700">
                            <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-4 gap-y-2 text-sm">
                                <dt class="font-medium text-gray-500 dark:text-gray-400">Nama Lengkap</dt>
                                <dd id="info-nama" class="font-bold dark:text-gray-200 sm:col-span-1">-</dd>
                                <dt class="font-medium text-gray-500 dark:text-gray-400">ID Santri</dt>
                                <dd id="info-id" class="font-mono font-bold text-indigo-600 dark:text-indigo-400 sm:col-span-1">-</dd>
                                <dt class="font-medium text-gray-500 dark:text-gray-400">Pendidikan</dt>
                                <dd id="info-pendidikan" class="dark:text-gray-300 sm:col-span-1">-</dd>
                                <dt class="font-medium text-gray-500 dark:text-gray-400">Kelas</dt>
                                <dd id="info-kelas" class="dark:text-gray-300 sm:col-span-1">-</dd>
                                <dt class="font-medium text-gray-500 dark:text-gray-400">Kamar</dt>
                                <dd id="info-kamar" class="dark:text-gray-300 sm:col-span-1">-</dd>
                            </dl>
                        </div>

                        {{-- 2. DETAIL TRANSAKSI PELANGGARAN --}}
                        <div class="space-y-3">
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 border-b border-gray-200 dark:border-gray-700 pb-2 mt-6">2. Detail Pelanggaran</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="md:col-span-1">
                                    <x-input-label for="id_jenis_pelanggaran" :value="__('Jenis Pelanggaran (Wajib)')" />
                                    <select name="id_jenis_pelanggaran" id="id_jenis_pelanggaran" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 rounded-md shadow-sm" required>
                                        <option value="">-- Pilih Pelanggaran --</option>
                                        @foreach($jenisPelanggarans as $jenis)
                                            <option value="{{ $jenis->id_jenis_pelanggaran }}" {{ old('id_jenis_pelanggaran') == $jenis->id_jenis_pelanggaran ? 'selected' : '' }}>
                                                {{ $jenis->nama_pelanggaran }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <x-input-error :messages="$errors->get('id_jenis_pelanggaran')" class="mt-2" />
                                </div>
                                
                                <div class="md:col-span-1">
                                    <x-input-label for="tanggal_melanggar" :value="__('Tanggal Kejadian (Wajib)')" />
                                    <x-text-input id="tanggal_melanggar" class="block mt-1 w-full" type="date" name="tanggal_melanggar" :value="old('tanggal_melanggar', date('Y-m-d'))" required />
                                    <x-input-error :messages="$errors->get('tanggal_melanggar')" class="mt-2" />
                                </div>

                                <div class="md:col-span-2">
                                    <x-input-label for="kronologi" :value="__('Kronologi Kejadian (Opsional)')" />
                                    <textarea id="kronologi" name="kronologi" rows="2" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 rounded-md shadow-sm" placeholder="Ceritakan urutan kejadian secara singkat...">{{ old('kronologi') }}</textarea>
                                </div>

                                <div class="md:col-span-1">
                                    <x-input-label for="sanksi" :value="__('Sanksi / Hukuman (Opsional)')" />
                                    <x-text-input id="sanksi" class="block mt-1 w-full" type="text" name="sanksi" :value="old('sanksi')" placeholder="Cth: Ta'zir membersihkan halaman, dll." />
                                </div>

                                <div class="md:col-span-1">
                                    <x-input-label for="keterangan" :value="__('Keterangan Tambahan (Opsional)')" />
                                    <x-text-input id="keterangan" class="block mt-1 w-full" type="text" name="keterangan" :value="old('keterangan')" placeholder="Catatan ekstra..." />
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                            <a href="{{ route('pelanggaran.index') }}" class="text-sm text-gray-700 dark:text-gray-300 underline hover:no-underline">Batal</a>
                            <x-primary-button class="ml-4 bg-red-600 hover:bg-red-700 focus:bg-red-700">{{ __('Simpan Data Pelanggaran') }}</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            $(document).ready(function() {
                // 1. Fungsi kustom untuk merender hasil pencarian (Seragam dengan Perizinan)
                function formatSantri (santri) {
                    if (santri.loading) { return santri.text; }
                    
                    var fotoSrc = santri.foto 
                        ? '/storage/fotos/' + santri.foto 
                        : 'https://ui-avatars.com/api/?name=' + encodeURIComponent(santri.nama_santri) + '&background=e5e7eb&color=374151';

                    var $container = $(
                        "<div class='select2-result-santri'>" +
                            "<div class='select2-result-santri__avatar'><img src='" + fotoSrc + "' /></div>" +
                            "<div class='select2-result-santri__meta'>" +
                                "<div class='select2-result-santri__title'></div>" +
                                "<div class='select2-result-santri__id'></div>" +
                            "</div>" +
                        "</div>"
                    );
                    
                    $container.find(".select2-result-santri__title").text(santri.nama_santri);
                    $container.find(".select2-result-santri__id").text("ID: " + santri.id_santri);
                    
                    return $container;
                }

                function formatSantriSelection (santri) {
                    return santri.nama_santri || santri.text;
                }

                $('#id_santri_select').select2({
                    placeholder: 'Ketik nama atau ID santri...',
                    theme: 'bootstrap-5',
                    minimumInputLength: 1, 
                    ajax: {
                        url: '{{ route("pelanggaran.search") }}',
                        dataType: 'json',
                        delay: 250,
                        data: function (params) {
                            return { q: params.term };
                        },
                        processResults: function (data) {
                            return { 
                                results: $.map(data, function(item) { 
                                    return { id: item.id_santri, text: item.nama_santri, ...item }; 
                                }) 
                            };
                        },
                    },
                    templateResult: formatSantri,
                    templateSelection: formatSantriSelection,
                    escapeMarkup: function (markup) { return markup; }
                });

                // Auto-Fill Data ke Kotak Detail Saat Santri Dipilih
                $('#id_santri_select').on('select2:select', function (e) {
                    var data = e.params.data;
                    $('#id_santri').val(data.id_santri);
                    
                    $('#info-nama').text(data.nama_santri || '-');
                    $('#info-id').text(data.id_santri || '-');
                    $('#info-kelas').text(data.kelas ? data.kelas.nama_kelas : '-');
                    $('#info-pendidikan').text(data.pendidikan ? data.pendidikan.nama_pendidikan : '-');
                    $('#info-kamar').text(data.kamar ? data.kamar.nama_kamar : '-');
                });
            });
        </script>
        
        {{-- Style disamakan 100% dengan style Perizinan --}}
        <style>
            .select2-result-santri__avatar img { width: 40px; height: 40px; border-radius: 50%; margin-right: 10px; object-fit: cover; }
            .select2-result-santri { display: flex; align-items: center; }
            .select2-result-santri__meta { display: flex; flex-direction: column; }
            .select2-result-santri__title { font-weight: 600; color: #333; }
            .select2-result-santri__id { font-size: 0.8rem; color: #777; }
        </style>
    @endpush
</x-app-layout>