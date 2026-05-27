<div x-show="sidebarOpen" @click="sidebarOpen = false" class="lg:hidden fixed inset-0 bg-black opacity-50 z-20 no-print" x-cloak></div>

<div class="w-64 bg-gray-800 text-white h-screen shadow-lg fixed top-0 left-0 flex flex-col z-30 transform transition-transform duration-300 ease-in-out -translate-x-full lg:translate-x-0 no-print"
     :class="{'translate-x-0': sidebarOpen}">
    
    <div class="p-6 flex justify-between items-center">
        <a href="{{ route('dashboard') }}">
            <h1 class="text-2xl font-bold text-white">Aplikasi Pesantren</h1>
        </a>
        <button @click="sidebarOpen = false" class="lg:hidden text-gray-400 hover:text-white focus:outline-none">
            <i class="fas fa-times fa-lg"></i>
        </button>
    </div>

    {{-- PERBAIKAN: Menambahkan overflow-y-auto dan pb-4 agar bisa discroll --}}
    <nav class="mt-2 flex-grow overflow-y-auto pb-4">
        <span class="px-6 text-gray-400 text-xs uppercase">Menu</span>
        <ul class="mt-2">
            <li>
                <a href="{{ route('dashboard') }}" class="flex items-center px-6 py-3 {{ request()->routeIs('dashboard') ? 'bg-gray-700' : '' }} hover:bg-gray-700 transition-colors duration-200">
                    <i class="fas fa-tachometer-alt w-6 text-center"></i>
                    <span class="ml-4">Dashboard</span>
                </a>
            </li>
            
            <li>
                <a href="{{ route('santri.index') }}" class="flex items-center px-6 py-3 {{ request()->routeIs('santri.*') ? 'bg-gray-700' : '' }} hover:bg-gray-700 transition-colors duration-200">
                    <i class="fas fa-users w-6 text-center"></i>
                    <span class="ml-4">Data Santri</span>
                </a>
            </li>

            @can('manage-perizinan')
                <li>
                    <a href="{{ route('perizinan.index') }}" class="flex items-center px-6 py-3 {{ request()->routeIs('perizinan.*') ? 'bg-gray-700' : '' }} hover:bg-gray-700 transition-colors duration-200">
                        <i class="fas fa-file-alt w-6 text-center"></i>
                        <span class="ml-4">Perizinan</span>
                    </a>
                </li>
            @endcan
            
            @can('view-tagihan')
                <li>
                    <a href="{{ route('tagihan.index') }}" class="flex items-center px-6 py-3 {{ request()->routeIs('tagihan.*') ? 'bg-gray-700' : '' }} hover:bg-gray-700 transition-colors duration-200">
                        <i class="fas fa-dollar-sign w-6 text-center"></i>
                        <span class="ml-4">Tagihan</span>
                    </a>
                </li>
            @endcan

            <li>
                <a href="{{ route('pelanggaran.index') }}" class="flex items-center px-6 py-3 {{ request()->routeIs('pelanggaran.*') ? 'bg-gray-700' : '' }} hover:bg-gray-700 transition-colors duration-200">
                    <i class="fas fa-exclamation-triangle w-6 text-center text-yellow-500"></i>
                    <span class="ml-4">Pelanggaran</span>
                </a>
            </li>

            @can('is-admin')
            <span class="px-6 text-gray-400 text-xs uppercase mt-4 block">Admin</span>
            <li class="mt-2" x-data="{ open: {{ request()->routeIs('master.*') || request()->routeIs('jenis-pelanggaran.*') ? 'true' : 'false' }} }">
                <button @click="open = !open" class="w-full flex justify-between items-center px-6 py-3 hover:bg-gray-700 transition-colors duration-200 text-left">
                    <div class="flex items-center">
                        <i class="fas fa-database w-6 text-center"></i>
                        <span class="ml-4">Data Master</span>
                    </div>
                    <i class="fas" :class="open ? 'fa-chevron-down' : 'fa-chevron-right'"></i>
                </button>
                <ul x-show="open" class="pl-12 bg-gray-900/50" x-collapse>
                    <li>
                        <a href="{{ route('master.pendidikan.index') }}" class="block px-4 py-2 text-sm {{ request()->routeIs('master.pendidikan.*') ? 'text-white font-bold' : 'text-gray-400' }} hover:text-white">
                            Pendidikan
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('master.kelas.index') }}" class="block px-4 py-2 text-sm {{ request()->routeIs('master.kelas.*') ? 'text-white font-bold' : 'text-gray-400' }} hover:text-white">
                            Kelas
                        </a>
                    </li>
                     <li>
                        <a href="{{ route('master.status.index') }}" class="block px-4 py-2 text-sm {{ request()->routeIs('master.status.*') ? 'text-white font-bold' : 'text-gray-400' }} hover:text-white">
                            Status
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('master.kamar.index') }}" class="block px-4 py-2 text-sm {{ request()->routeIs('master.kamar.*') ? 'text-white font-bold' : 'text-gray-400' }} hover:text-white">
                            Kamar
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('master.jenis-perizinan.index') }}" class="block px-4 py-2 text-sm {{ request()->routeIs('master.jenis-perizinan.*') ? 'text-white font-bold' : 'text-gray-400' }} hover:text-white">
                            Jenis Izin
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('jenis-pelanggaran.index') }}" class="block px-4 py-2 text-sm {{ request()->routeIs('jenis-pelanggaran.*') ? 'text-white font-bold' : 'text-gray-400' }} hover:text-white">
                            Jenis Pelanggaran
                        </a>
                    </li>
                </ul>
            </li>
            
            <li>
                <a href="{{ route('users.index') }}" class="flex items-center px-6 py-3 {{ request()->routeIs('users.*') ? 'bg-gray-700' : '' }} hover:bg-gray-700 transition-colors duration-200">
                    <i class="fas fa-user-cog w-6 text-center"></i>
                    <span class="ml-4">Manajemen User</span>
                </a>
            </li>

            <li>
                <a href="/log-viewer" class="flex items-center px-6 py-3 {{ request()->is('log-viewer*') ? 'bg-gray-700' : '' }} hover:bg-gray-700 transition-colors duration-200">
                    <i class="fas fa-bug w-6 text-center"></i>
                    <span class="ml-4">Log Viewer</span>
                </a>
            </li>
            @endcan
        </ul>
    </nav>

    <div class="mt-auto border-t border-gray-700">
         <form method="POST" action="{{ route('logout') }}">
            @csrf
            <a href="{{ route('logout') }}"
               onclick="event.preventDefault(); this.closest('form').submit();"
               class="flex items-center px-6 py-4 text-red-400 hover:bg-red-700 hover:text-white transition-colors duration-200">
                <i class="fas fa-sign-out-alt w-6 text-center"></i>
                <span class="ml-4">Logout</span>
            </a>
        </form>
    </div>
</div>