<div id="sidebar" class="bg-white w-64 min-h-screen border-r transition-all duration-300 relative">
    <!-- Logo -->
    <div class="text-center py-6 border-b">
        <img src="{{ asset('assets/logo2.png') }}" alt="Logo"
            class="w-[8.5rem] mx-auto transition-all duration-300 sidebar-logo">
        <h1 class="mt-2 font-bold text-sm sidebar-text">SD ABU AZIZ</h1>
    </div>

    <!-- Menu -->
    <nav class="mt-4 space-y-2">
        <!-- Home -->
        <a href="#" class="flex items-center px-4 py-2 hover:bg-gray-100">
            <i data-lucide="home" class="w-5 h-5"></i>
            <span class="ml-2 sidebar-text">Home</span>
        </a>

        <!-- Master Data -->
        <div class="menu-item relative">
            <button class="flex items-center justify-between w-full px-4 py-2 hover:bg-gray-100">
                <div class="flex items-center">
                    <i data-lucide="database" class="w-5 h-5"></i>
                    <span class="ml-2 sidebar-text">Master Data</span>
                </div>
                <i data-lucide="chevron-down" class="w-4 h-4 transition-transform"></i>
            </button>
            <!-- Normal submenu -->
            <div class="submenu max-h-0 overflow-hidden transition-all duration-300 ml-8 space-y-2 submenu-container">
                <a href="#" class="block px-2 py-1 hover:bg-gray-100 rounded">Data Siswa</a>
                <a href="#" class="block px-2 py-1 hover:bg-gray-100 rounded">Data Guru</a>
                <a href="#" class="block px-2 py-1 hover:bg-gray-100 rounded">Data Kelas</a>
            </div>
        </div>

        <!-- Transaksi -->
        <div class="menu-item relative">
            <button class="flex items-center justify-between w-full px-4 py-2 hover:bg-gray-100">
                <div class="flex items-center">
                    <i data-lucide="credit-card" class="w-5 h-5"></i>
                    <span class="ml-2 sidebar-text">Transaksi</span>
                </div>
                <i data-lucide="chevron-down" class="w-4 h-4 transition-transform"></i>
            </button>
            <div class="submenu max-h-0 overflow-hidden transition-all duration-300 ml-8 space-y-2 submenu-container">
                <a href="#" class="block px-2 py-1 hover:bg-gray-100 rounded">Pembayaran</a>
                <a href="#" class="block px-2 py-1 hover:bg-gray-100 rounded">Pengeluaran</a>
            </div>
        </div>

        <!-- Laporan -->
        <div class="menu-item relative">
            <button class="flex items-center justify-between w-full px-4 py-2 hover:bg-gray-100">
                <div class="flex items-center">
                    <i data-lucide="file-text" class="w-5 h-5"></i>
                    <span class="ml-2 sidebar-text">Laporan</span>
                </div>
                <i data-lucide="chevron-down" class="w-4 h-4 transition-transform"></i>
            </button>
            <div class="submenu max-h-0 overflow-hidden transition-all duration-300 ml-8 space-y-2 submenu-container">
                <a href="#" class="block px-2 py-1 hover:bg-gray-100 rounded">Laporan Harian</a>
                <a href="#" class="block px-2 py-1 hover:bg-gray-100 rounded">Laporan Bulanan</a>
            </div>
        </div>
    </nav>
</div>
