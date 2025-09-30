<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'SD ABU AZIZ') }}</title>

    {{-- Tailwind pakai CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/alpinejs" defer></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<style>
    /* floating mode */
    .sidebar-compact .submenu-container {
        position: absolute;
        left: 100%;
        top: 0;
        margin-left: 0.5rem;
        background: white;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        border-radius: 0.5rem;
        width: 10rem;
        padding: 0.5rem;
        z-index: 50;
        max-height: none !important;
        display: none;
    }

    .sidebar-compact .submenu-container.show {
        display: block;
        animation: fadeIn 0.2s ease-in-out;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(5px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>


<body class="flex bg-gray-100">

    {{-- Sidebar --}}
    @include('layouts.sidebar')

    {{-- Bagian kanan: header, konten, footer --}}
    <div class="flex flex-col w-full h-screen">
        
        {{-- Header tetap di atas --}}
        <header class="flex-shrink-0">
            @include('layouts.header')
        </header>

        {{-- Konten yang bisa scroll --}}
        <main class="flex-1 overflow-y-auto p-6 bg-gray-100">
            {{-- Breadcrumb --}}
            @hasSection('breadcrumb')
            <div class="flex items-center justify-between mb-4">
                <div>
                    @yield('breadcrumb')
                </div>
                <ul class="flex space-x-2 text-sm text-gray-600">
                    <li>
                        <a href="{{ url('/') }}" class="hover:underline">Home</a>
                        <span>&gt;</span>
                    </li>
                    <li>
                        <span class="font-semibold text-gray-800">
                            @yield('title')
                        </span>
                    </li>
                </ul>
            </div>
            @endif

            @yield('content')
        </main>

        {{-- Footer tetap di bawah --}}
        <footer class="flex-shrink-0">
            @include('layouts.footer')
        </footer>
    </div>
    <script>
        lucide.createIcons();

        const toggle = document.getElementById("sidebarToggle");
        const sidebar = document.getElementById("sidebar");
        const sidebarTexts = document.querySelectorAll(".sidebar-text");
        const sidebarLogo = document.querySelector(".sidebar-logo");

        // Toggle Sidebar
        toggle.addEventListener("click", () => {
            sidebar.classList.toggle("w-64");
            sidebar.classList.toggle("w-16");
            sidebar.classList.toggle("sidebar-compact");

            sidebarTexts.forEach(text => text.classList.toggle("hidden"));

            if (sidebar.classList.contains("w-16")) {
                sidebarLogo.classList.replace("w-[8.5rem]", "w-12");
            } else {
                sidebarLogo.classList.replace("w-12", "w-[8.5rem]");
            }

            // close semua submenu ketika resize
            document.querySelectorAll('.submenu').forEach(s => {
                s.style.maxHeight = "0px";
                s.classList.remove("show");
            });
        });

        // Submenu Toggle
        document.querySelectorAll('.menu-item button').forEach(button => {
            button.addEventListener('click', (e) => {
                e.stopPropagation();
                const submenu = button.nextElementSibling;
                const icon = button.querySelector('[data-lucide="chevron-down"]');

                // Reset semua submenu lain
                document.querySelectorAll('.submenu').forEach(s => {
                    if (s !== submenu) {
                        s.style.maxHeight = "0px";
                        s.classList.remove("show");
                        const otherIcon = s.previousElementSibling.querySelector('[data-lucide="chevron-down"]');
                        if (otherIcon) otherIcon.style.transform = "rotate(0deg)";
                    }
                });

                if (sidebar.classList.contains("sidebar-compact")) {
                    // Floating mode
                    submenu.classList.toggle("show");
                } else {
                    // Normal expand mode
                    if (submenu.style.maxHeight !== "0px" && submenu.style.maxHeight !== "") {
                        submenu.style.maxHeight = "0px";
                        icon.style.transform = "rotate(0deg)";
                    } else {
                        submenu.style.maxHeight = submenu.scrollHeight + "px";
                        icon.style.transform = "rotate(180deg)";
                    }
                }
            });
        });

        // Klik luar submenu → close floating
        document.addEventListener("click", (e) => {
            if (!sidebar.contains(e.target)) {
                document.querySelectorAll('.submenu').forEach(s => s.classList.remove("show"));
            }
        });

         $(document).ready(function () {
            $('#akunTable').DataTable({
                responsive: true,
                language: {
                    search: "Cari:",
                    lengthMenu: "Tampilkan _MENU_ data",
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                    paginate: {
                        previous: "Sebelumnya",
                        next: "Berikutnya"
                    }
                }
            });
        });
    </script>


</body>

</html>