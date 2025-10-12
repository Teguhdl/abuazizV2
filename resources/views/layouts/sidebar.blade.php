<div id="sidebar" class="bg-white w-64 min-h-screen border-r transition-all duration-300 relative">
    <!-- Logo -->
    <div class="text-center py-6 border-b">
        <img src="{{ asset('assets/logonew.png') }}" alt="Logo"
            class="w-[8.5rem] mx-auto transition-all duration-300 sidebar-logo">
        <h1 class="mt-2 font-bold text-sm sidebar-text">SD ABU AZIZ</h1>
    </div>

    @php
        $role = Auth::user()->role;
    @endphp

    <!-- Menu -->
    <nav class="mt-4 space-y-2">
        <!-- Home -->
        <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-2 hover:bg-gray-100">
            <i data-lucide="home" class="w-5 h-5"></i>
            <span class="ml-2 sidebar-text">Home</span>
        </a>

        <!-- ================= MASTER DATA ================= -->
        @if (in_array($role, ['admin', 'tata_usaha', 'operasional_kesiswaan']))
        <div class="menu-item relative">
            <button class="flex items-center justify-between w-full px-4 py-2 hover:bg-gray-100">
                <div class="flex items-center">
                    <i data-lucide="database" class="w-5 h-5"></i>
                    <span class="ml-2 sidebar-text">Master Data</span>
                </div>
                <i data-lucide="chevron-down" class="w-4 h-4 transition-transform"></i>
            </button>

            <div class="submenu max-h-0 overflow-hidden transition-all duration-300 ml-8 space-y-2 submenu-container">
                @if(in_array($role, ['admin', 'tata_usaha']))
                    <a href="{{ route('kelas.index') }}" class="block px-2 py-1 hover:bg-gray-100 rounded">Data Kelas</a>
                    <a href="{{ route('rincian_biaya.index') }}" class="block px-2 py-1 hover:bg-gray-100 rounded">Data Rincian Biaya Transaksi</a>
                    <a href="{{ route('potongan_biaya.index') }}" class="block px-2 py-1 hover:bg-gray-100 rounded">Data Potongan Biaya Transaksi</a>
                    <a href="{{ route('pengaturan-spp.index') }}" class="block px-2 py-1 hover:bg-gray-100 rounded">Data Pengaturan SPP</a>
                @endif
                @if(in_array($role, ['admin', 'tata_usaha', 'operasional_kesiswaan']))
                    <a href="{{ route('siswa.index') }}" class="block px-2 py-1 hover:bg-gray-100 rounded">Data Siswa</a>
                @endif
                @if($role == 'admin')
                    <a href="{{ route('akun.index') }}" class="block px-2 py-1 hover:bg-gray-100 rounded">Data Akun</a>
                    <a href="{{ route('sekolah.index') }}" class="block px-2 py-1 hover:bg-gray-100 rounded">Data Sekolah</a>
                @endif
            </div>
        </div>
        @endif

        <!-- ================= TRANSAKSI ================= -->
        @if (in_array($role, ['admin', 'tata_usaha', 'bendahara_yayasan', 'operasional_kesiswaan']))
        <div class="menu-item relative">
            <button class="flex items-center justify-between w-full px-4 py-2 hover:bg-gray-100">
                <div class="flex items-center">
                    <i data-lucide="credit-card" class="w-5 h-5"></i>
                    <span class="ml-2 sidebar-text">Transaksi</span>
                </div>
                <i data-lucide="chevron-down" class="w-4 h-4 transition-transform"></i>
            </button>

            <div class="submenu max-h-0 overflow-hidden transition-all duration-300 ml-8 space-y-2 submenu-container">
                @if(in_array($role, ['admin', 'tata_usaha', 'operasional_kesiswaan']))
                    <a href="{{ route('transaksi_pendaftaran.index') }}" class="block px-2 py-1 hover:bg-gray-100 rounded">Transaksi Pendaftaran Siswa</a>
                    <a href="{{ route('transaksi_daftar_ulang.index') }}" class="block px-2 py-1 hover:bg-gray-100 rounded">Transaksi Daftar Ulang Siswa</a>
                @endif

                @if(in_array($role, ['admin', 'tata_usaha', 'bendahara_yayasan']))
                    <a href="{{ route('pendapatan.index') }}" class="block px-2 py-1 hover:bg-gray-100 rounded">Transaksi Dana Masuk</a>
                    <a href="{{ route('pembayaran_beban.index') }}" class="block px-2 py-1 hover:bg-gray-100 rounded">Transaksi Pengeluaran Operasional</a>
                @endif

                @if(in_array($role, ['admin', 'tata_usaha']))
                    <a href="{{ route('transaksi-spp.index') }}" class="block px-2 py-1 hover:bg-gray-100 rounded">Transaksi Pembayaran SPP</a>
                @endif
            </div>
        </div>
        @endif

        <!-- ================= LAPORAN ================= -->
        @if (in_array($role, ['admin', 'tata_usaha', 'bendahara_yayasan', 'ketua_yayasan']))
        <div class="menu-item relative">
            <button class="flex items-center justify-between w-full px-4 py-2 hover:bg-gray-100">
                <div class="flex items-center">
                    <i data-lucide="file-text" class="w-5 h-5"></i>
                    <span class="ml-2 sidebar-text">Laporan</span>
                </div>
                <i data-lucide="chevron-down" class="w-4 h-4 transition-transform"></i>
            </button>

            <div class="submenu max-h-0 overflow-hidden transition-all duration-300 ml-8 space-y-2 submenu-container">
                @if(in_array($role, ['admin', 'tata_usaha', 'bendahara_yayasan', 'ketua_yayasan']))
                    <a href="{{ route('jurnal') }}" class="block px-2 py-1 hover:bg-gray-100 rounded">Jurnal Umum</a>
                    <a href="{{ route('buku_besar') }}" class="block px-2 py-1 hover:bg-gray-100 rounded">Buku Besar</a>
                    <a href="{{ route('laporan-dana-masuk') }}" class="block px-2 py-1 hover:bg-gray-100 rounded">Laporan Dana Masuk</a>
                    <a href="{{ route('laporan-dana-keluar') }}" class="block px-2 py-1 hover:bg-gray-100 rounded">Laporan Pengeluaran Operasional</a>
                @endif
            </div>
        </div>
        @endif
    </nav>
</div>
