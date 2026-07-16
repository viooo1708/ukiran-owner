<header class="fixed top-4 left-4 right-4 h-20 bg-white/70 backdrop-blur-md border border-white/20 shadow-[0_8px_32px_0_rgba(93,64,55,0.04)] rounded-2xl z-50 transition-all duration-300">
    <div class="h-full w-full px-6 flex items-center justify-between">

        {{-- Brand Section --}}
        <div class="flex items-center gap-3 w-64">
            <!-- Penggantian Logo Menggunakan Tag IMG sesuai keinginan Anda -->
            <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-[#5d4037] to-[#3e2723] flex items-center justify-center shadow-md shadow-amber-900/10 shrink-0 overflow-hidden">
                <img src="{{ asset('images/logo-kriya-ukir.png') }}" alt="Logo Kriya Ukir" class="w-full h-full object-cover">
            </div>
            <div class="leading-tight hidden sm:block">
                <h1 class="text-sm font-bold text-[#3e2723] tracking-wide">
                    Adi Ukiran
                </h1>
                <p class="text-[10px] text-gray-400 font-semibold tracking-wider uppercase">
                    Owner Dashboard
                </p>
            </div>
        </div>

        {{-- Navigation Center Section (Modern Pill Tabs Style) --}}
        <nav class="flex-1 max-w-2xl bg-[#5d4037]/5 border border-[#5d4037]/5 p-1.5 rounded-full flex justify-between items-center gap-1">

            {{-- Dashboard Link --}}
            <a href="{{ route('dashboard') }}"
                class="flex-1 py-2 px-3 text-center rounded-full text-xs font-bold tracking-wide transition-all duration-300 ease-out transform active:scale-95
                {{ request()->routeIs('dashboard')
                    ? 'bg-[#5d4037] text-white shadow-md shadow-amber-900/20'
                    : 'text-gray-500 hover:text-[#5d4037] hover:bg-[#5d4037]/5' }}">
                Dashboard
            </a>

            {{-- Pesanan Link --}}
            <a href="{{ route('orders.index') }}"
                class="flex-1 py-2 px-3 text-center rounded-full text-xs font-bold tracking-wide transition-all duration-300 ease-out transform active:scale-95
                {{ request()->routeIs('orders.*')
                    ? 'bg-[#5d4037] text-white shadow-md shadow-amber-900/20'
                    : 'text-gray-500 hover:text-[#5d4037] hover:bg-[#5d4037]/5' }}">
                Pesanan
            </a>

            {{-- Produk Link --}}
            <a href="{{ route('products.index') }}"
                class="flex-1 py-2 px-3 text-center rounded-full text-xs font-bold tracking-wide transition-all duration-300 ease-out transform active:scale-95
                {{ request()->routeIs('products.*')
                    ? 'bg-[#5d4037] text-white shadow-md shadow-amber-900/20'
                    : 'text-gray-500 hover:text-[#5d4037] hover:bg-[#5d4037]/5' }}">
                Produk
            </a>

            {{-- Laporan Link --}}
            <a href="{{ route('reports.index') }}"
                class="flex-1 py-2 px-3 text-center rounded-full text-xs font-bold tracking-wide transition-all duration-300 ease-out transform active:scale-95
                {{ request()->routeIs('reports.*')
                    ? 'bg-[#5d4037] text-white shadow-md shadow-amber-900/20'
                    : 'text-gray-500 hover:text-[#5d4037] hover:bg-[#5d4037]/5' }}">
                Laporan
            </a>

            {{-- Pelanggan Link --}}
            <a href="{{ route('users.index') }}"
                class="flex-1 py-2 px-3 text-center rounded-full text-xs font-bold tracking-wide transition-all duration-300 ease-out transform active:scale-95
                {{ request()->routeIs('users.*')
                    ? 'bg-[#5d4037] text-white shadow-md shadow-amber-900/20'
                    : 'text-gray-500 hover:text-[#5d4037] hover:bg-[#5d4037]/5' }}">
                Pelanggan
            </a>

        </nav>

        {{-- Right Section --}}
        <div class="w-64 flex justify-end items-center gap-3">

            {{-- Notification Dropdown Wrapper --}}
        <div class="relative">
            {{-- Tombol Notifikasi (Ditambahkan fungsi onclick dan id) --}}
            <button onclick="toggleNotificationMenu()" id="notiButton"
                class="relative w-10 h-10 rounded-xl hover:bg-[#5d4037]/5 active:bg-[#5d4037]/10 flex items-center justify-center transition-colors group">
                <span class="material-symbols-outlined text-gray-400 group-hover:text-[#5d4037] transition-colors">
                    notifications
                </span>
                {{-- Titik indikator merah jika ada notifikasi baru --}}
                <span id="notiBadge" class="absolute top-2.5 right-2.5 w-2 h-2 bg-rose-500 rounded-full ring-2 ring-white"></span>
            </button>

            {{-- Dropdown Card List Notifikasi (Default di-hidden) --}}
            <div id="notificationMenu"
                class="hidden absolute right-0 mt-3 w-80 bg-white/90 backdrop-blur-md rounded-2xl shadow-xl border border-amber-900/5 overflow-hidden z-[100] transform origin-top-right transition-all duration-200">

                {{-- Header Notifikasi --}}
                <div class="px-4 py-3 bg-[#5d4037]/5 border-b border-[#5d4037]/5 flex justify-between items-center">
                    <span class="text-xs font-bold text-[#3e2723]">Pemberitahuan Terbaru</span>
                    <button onclick="clearBadge()" class="text-[10px] font-bold text-amber-700 hover:underline">Tandai semua dibaca</button>
                </div>

                {{-- List Notifikasi --}}
                <div class="max-h-64 overflow-y-auto divide-y divide-gray-100">
                    <!-- Item 1: Pesanan Baru -->
                    <a href="{{ route('orders.index') }}" class="flex gap-3 p-3 hover:bg-[#5d4037]/5 transition-colors items-start">
                        <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                            <span class="material-symbols-outlined text-sm">shopping_bag</span>
                        </div>
                        <div class="space-y-0.5">
                            <p class="text-xs font-semibold text-gray-800">Pesanan Baru #ORD-1024</p>
                            <p class="text-[11px] text-gray-500 leading-tight">Kursi Ganesha Madura (DP Telah Diterima).</p>
                            <span class="text-[9px] text-gray-400 block font-medium">5 menit yang lalu</span>
                        </div>
                    </a>

                    <!-- Item 2: Stok Menipis -->
                    <a href="{{ route('products.index') }}" class="flex gap-3 p-3 hover:bg-[#5d4037]/5 transition-colors items-start">
                        <div class="w-8 h-8 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center shrink-0">
                            <span class="material-symbols-outlined text-sm">warning</span>
                        </div>
                        <div class="space-y-0.5">
                            <p class="text-xs font-semibold text-gray-800">Bahan Baku Kritis</p>
                            <p class="text-[11px] text-gray-500 leading-tight">Stok Kayu Mahoni tersisa di bawah 3 meter kubik.</p>
                            <span class="text-[9px] text-gray-400 block font-medium">2 jam yang lalu</span>
                        </div>
                    </a>
                </div>

                {{-- Footer Notifikasi --}}
                <a href="#" class="block text-center py-2.5 text-[11px] font-bold text-[#5d4037] bg-gray-50 hover:bg-gray-100 transition-colors border-t border-gray-100">
                    Lihat Semua Notifikasi
                </a>
            </div>
        </div>

            {{-- Profile Dropdown Wrapper --}}
            <div class="relative">
                <button onclick="toggleProfileMenu()"
                    class="flex items-center gap-2.5 p-1.5 pr-3 rounded-xl hover:bg-[#5d4037]/5 active:bg-[#5d4037]/10 transition-all duration-200 group">

                    @if(session('user.foto'))
                        <img src="{{ session('user.foto') }}" class="w-9 h-9 rounded-lg object-cover border border-amber-900/10 shadow-sm">
                    @else
                        <div class="w-9 h-9 rounded-lg bg-gradient-to-br from-[#5d4037] to-[#3e2723] text-white flex items-center justify-center font-bold text-sm shadow-sm">
                            {{ strtoupper(substr(session('user.nama','O'),0,1)) }}
                        </div>
                    @endif

                    <div class="text-left hidden md:block">
                        <p class="text-xs font-bold text-gray-700 group-hover:text-[#5d4037] transition-colors">
                            {{ session('user.nama','Owner') }}
                        </p>
                        <p class="text-[9px] text-gray-400 font-bold tracking-wide uppercase">
                            Administrator
                        </p>
                    </div>

                    <span class="material-symbols-outlined text-gray-400 group-hover:text-[#5d4037] text-lg transition-all duration-200" id="dropdown-icon">
                        keyboard_arrow_down
                    </span>
                </button>

                {{-- Dropdown Card Premium --}}
                <div id="profileMenu"
                    class="hidden absolute right-0 mt-3 w-60 bg-white/90 backdrop-blur-md rounded-xl shadow-xl border border-amber-900/5 overflow-hidden z-[100] transform origin-top-right transition-all duration-200">

                    <div class="px-5 py-4 bg-[#5d4037]/5 border-b border-[#5d4037]/5">
                        <p class="text-xs font-bold text-[#3e2723]">
                            {{ session('user.nama','Owner') }}
                        </p>
                        <p class="text-[10px] text-gray-400 font-medium mt-0.5">
                            Owner Adi Ukiran
                        </p>
                    </div>

                    <a href="{{ route('profile.index') }}"
                        class="flex items-center gap-3 px-5 py-3 text-xs font-bold text-gray-600 hover:bg-[#5d4037] hover:text-white transition-colors group">
                        <span class="material-symbols-outlined text-gray-400 group-hover:text-white text-lg transition-colors">
                            person
                        </span>
                        Profil Saya
                    </a>

                    <div class="border-t border-gray-100"></div>

                    <form action="{{ url('/logout') }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="w-full flex items-center gap-3 px-5 py-3 text-xs font-bold text-rose-600 hover:bg-rose-600 hover:text-white transition-colors group">
                            <span class="material-symbols-outlined text-rose-400 group-hover:text-white text-lg transition-colors">
                                logout
                            </span>
                            Keluar Aplikasi
                        </button>
                    </form>

                </div>
            </div>

        </div>
    </div>
</header>

<script>
// Kontrol Menu Profil
function toggleProfileMenu() {
    const menu = document.getElementById('profileMenu');
    const icon = document.getElementById('dropdown-icon');

    // Tutup menu notifikasi jika sedang terbuka
    document.getElementById('notificationMenu')?.classList.add('hidden');

    if(menu) {
        const isHidden = menu.classList.toggle('hidden');
        if(icon) icon.style.transform = isHidden ? 'rotate(0deg)' : 'rotate(180deg)';
    }
}

// Kontrol Menu Notifikasi
function toggleNotificationMenu() {
    const notiMenu = document.getElementById('notificationMenu');

    // Tutup menu profil jika sedang terbuka
    document.getElementById('profileMenu')?.classList.add('hidden');
    const profileIcon = document.getElementById('dropdown-icon');
    if(profileIcon) profileIcon.style.transform = 'rotate(0deg)';

    if(notiMenu) {
        notiMenu.classList.toggle('hidden');
    }
}

// Fungsi menghapus titik merah (Tandai semua dibaca)
function clearBadge() {
    const badge = document.getElementById('notiBadge');
    if(badge) badge.remove();
}

// Deteksi klik di luar elemen untuk menutup otomatis
document.addEventListener('click', function(e) {
    const profileMenu = document.getElementById('profileMenu');
    const profileIcon = document.getElementById('dropdown-icon');
    const profileButton = e.target.closest('button[onclick="toggleProfileMenu()"]');

    const notiMenu = document.getElementById('notificationMenu');
    const notiButton = e.target.closest('#notiButton');

    // Tutup profil
    if (profileMenu && !profileMenu.contains(e.target) && !profileButton) {
        profileMenu.classList.add('hidden');
        if(profileIcon) profileIcon.style.transform = 'rotate(0deg)';
    }

    // Tutup notifikasi
    if (notiMenu && !notiMenu.contains(e.target) && !notiButton) {
        notiMenu.classList.add('hidden');
    }
});
</script>
