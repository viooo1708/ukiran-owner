<header class="fixed top-4 left-4 right-4 h-20 bg-white/70 backdrop-blur-md border border-white/20 shadow-[0_8px_32px_0_rgba(93,64,55,0.04)] rounded-2xl z-50 transition-all duration-300">
    <div class="h-full w-full px-6 flex items-center justify-between">

        {{-- Brand Section --}}
        <div class="flex items-center gap-3 w-64">
            <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-[#5d4037] to-[#3e2723] flex items-center justify-center shadow-md shadow-amber-900/10 shrink-0 overflow-hidden">
                <img src="{{ asset('images/logo-kriya-ukir.png') }}" alt="Logo Kriya Ukir" class="w-full h-full object-cover">
            </div>
            <div class="leading-tight hidden sm:block">
                <h1 class="text-sm font-bold text-[#3e2723] tracking-wide">Adi Ukiran</h1>
                <p class="text-[10px] text-gray-400 font-semibold tracking-wider uppercase">Owner Dashboard</p>
            </div>
        </div>

        {{-- Navigation Center Section --}}
        <nav class="flex-1 max-w-2xl bg-[#5d4037]/5 border border-[#5d4037]/5 p-1.5 rounded-full flex justify-between items-center gap-1">
            <a href="{{ route('dashboard') }}" class="flex-1 py-2 px-3 text-center rounded-full text-xs font-bold tracking-wide transition-all duration-300 ease-out transform active:scale-95 {{ request()->routeIs('dashboard') ? 'bg-[#5d4037] text-white shadow-md shadow-amber-900/20' : 'text-gray-500 hover:text-[#5d4037] hover:bg-[#5d4037]/5' }}">Dashboard</a>
            <a href="{{ route('orders.index') }}" class="flex-1 py-2 px-3 text-center rounded-full text-xs font-bold tracking-wide transition-all duration-300 ease-out transform active:scale-95 {{ request()->routeIs('orders.*') ? 'bg-[#5d4037] text-white shadow-md shadow-amber-900/20' : 'text-gray-500 hover:text-[#5d4037] hover:bg-[#5d4037]/5' }}">Pesanan</a>
            <a href="{{ route('products.index') }}" class="flex-1 py-2 px-3 text-center rounded-full text-xs font-bold tracking-wide transition-all duration-300 ease-out transform active:scale-95 {{ request()->routeIs('products.*') ? 'bg-[#5d4037] text-white shadow-md shadow-amber-900/20' : 'text-gray-500 hover:text-[#5d4037] hover:bg-[#5d4037]/5' }}">Produk</a>
            <a href="{{ route('reports.index') }}" class="flex-1 py-2 px-3 text-center rounded-full text-xs font-bold tracking-wide transition-all duration-300 ease-out transform active:scale-95 {{ request()->routeIs('reports.*') ? 'bg-[#5d4037] text-white shadow-md shadow-amber-900/20' : 'text-gray-500 hover:text-[#5d4037] hover:bg-[#5d4037]/5' }}">Laporan</a>
            <a href="{{ route('users.index') }}" class="flex-1 py-2 px-3 text-center rounded-full text-xs font-bold tracking-wide transition-all duration-300 ease-out transform active:scale-95 {{ request()->routeIs('users.*') ? 'bg-[#5d4037] text-white shadow-md shadow-amber-900/20' : 'text-gray-500 hover:text-[#5d4037] hover:bg-[#5d4037]/5' }}">Pelanggan</a>
        </nav>

        {{-- Right Section --}}
        <div class="w-64 flex justify-end items-center gap-3">
            <div class="relative">
                <button onclick="toggleNotificationMenu()" id="notiButton" class="relative w-10 h-10 rounded-xl hover:bg-[#5d4037]/5 active:bg-[#5d4037]/10 flex items-center justify-center transition-colors group">
                    <span class="material-symbols-outlined text-gray-400 group-hover:text-[#5d4037] transition-colors">notifications</span>
                    <span id="notiBadge" class="hidden absolute top-2.5 right-2.5 w-2 h-2 bg-rose-500 rounded-full ring-2 ring-white"></span>
                </button>

                <div id="notificationMenu" class="hidden absolute right-0 mt-3 w-80 bg-white/90 backdrop-blur-md rounded-2xl shadow-xl border border-amber-900/5 overflow-hidden z-[100] transform origin-top-right transition-all duration-200">
                    <div class="px-4 py-3 bg-[#5d4037]/5 border-b border-[#5d4037]/5 flex justify-between items-center">
                        <span class="text-xs font-bold text-[#3e2723]">Pemberitahuan</span>
                        <button onclick="markAllAsRead()" class="text-[10px] font-bold text-amber-700 hover:underline">Tandai semua dibaca</button>
                    </div>
                    <div id="notificationList" class="max-h-64 overflow-y-auto divide-y divide-gray-100">
                        <div class="p-4 text-center text-xs text-gray-500">Memuat notifikasi...</div>
                    </div>
                    <a href="#" class="block text-center py-2.5 text-[11px] font-bold text-[#5d4037] bg-gray-50 hover:bg-gray-100 transition-colors border-t border-gray-100">Lihat Semua Notifikasi</a>
                </div>
            </div>

            {{-- Profile Dropdown --}}
            <div class="relative">
                <button onclick="toggleProfileMenu()" class="flex items-center gap-2.5 p-1.5 pr-3 rounded-xl hover:bg-[#5d4037]/5 active:bg-[#5d4037]/10 transition-all duration-200 group">
                    @if(session('user.foto')) <img src="{{ session('user.foto') }}" class="w-9 h-9 rounded-lg object-cover border border-amber-900/10 shadow-sm"> @else <div class="w-9 h-9 rounded-lg bg-gradient-to-br from-[#5d4037] to-[#3e2723] text-white flex items-center justify-center font-bold text-sm shadow-sm">{{ strtoupper(substr(session('user.nama','O'),0,1)) }}</div> @endif
                    <div class="text-left hidden md:block">
                        <p class="text-xs font-bold text-gray-700 group-hover:text-[#5d4037] transition-colors">{{ session('user.nama','Owner') }}</p>
                        <p class="text-[9px] text-gray-400 font-bold tracking-wide uppercase">Administrator</p>
                    </div>
                    <span class="material-symbols-outlined text-gray-400 group-hover:text-[#5d4037] text-lg transition-all duration-200" id="dropdown-icon">keyboard_arrow_down</span>
                </button>
                <div id="profileMenu" class="hidden absolute right-0 mt-3 w-60 bg-white/90 backdrop-blur-md rounded-xl shadow-xl border border-amber-900/5 overflow-hidden z-[100] transform origin-top-right transition-all duration-200">
                    <div class="px-5 py-4 bg-[#5d4037]/5 border-b border-[#5d4037]/5">
                        <p class="text-xs font-bold text-[#3e2723]">{{ session('user.nama','Owner') }}</p>
                        <p class="text-[10px] text-gray-400 font-medium mt-0.5">Owner Adi Ukiran</p>
                    </div>
                    <a href="{{ route('profile.index') }}" class="flex items-center gap-3 px-5 py-3 text-xs font-bold text-gray-600 hover:bg-[#5d4037] hover:text-white transition-colors"><span class="material-symbols-outlined text-lg">person</span> Profil Saya</a>
                    <form action="{{ url('/logout') }}" method="POST"> @csrf <button type="submit" class="w-full flex items-center gap-3 px-5 py-3 text-xs font-bold text-rose-600 hover:bg-rose-600 hover:text-white transition-colors"><span class="material-symbols-outlined text-lg">logout</span> Keluar Aplikasi</button></form>
                </div>
            </div>
        </div>
    </div>
</header>

<script>
async function loadNotifications() {
    try {
        // Hapus /api/
        const response = await fetch('/notifications');
        const result = await response.json();
        // ... sisa kode ...
    } catch (e) { console.error(e); }
}

async function markAsRead(id) {
    // Hapus /api/
    await fetch(`/notifications/${id}/read`, {
        method: 'POST',
        headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'}
    });
    loadNotifications();
}

async function markAllAsRead() {
    // Hapus /api/
    await fetch('/notifications/read-all', {
        method: 'POST',
        headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'}
    });
    loadNotifications();
}

function toggleNotificationMenu() {
    const notiMenu = document.getElementById('notificationMenu');
    document.getElementById('profileMenu')?.classList.add('hidden');
    if (notiMenu.classList.contains('hidden')) loadNotifications();
    notiMenu.classList.toggle('hidden');
}

function toggleProfileMenu() {
    const menu = document.getElementById('profileMenu');
    const icon = document.getElementById('dropdown-icon');
    document.getElementById('notificationMenu')?.classList.add('hidden');
    if(menu) {
        const isHidden = menu.classList.toggle('hidden');
        if(icon) icon.style.transform = isHidden ? 'rotate(0deg)' : 'rotate(180deg)';
    }
}

document.addEventListener('click', function(e) {
    if (!e.target.closest('#profileMenu') && !e.target.closest('button[onclick="toggleProfileMenu()"]')) document.getElementById('profileMenu')?.classList.add('hidden');
    if (!e.target.closest('#notificationMenu') && !e.target.closest('#notiButton')) document.getElementById('notificationMenu')?.classList.add('hidden');
});

// Cek notifikasi baru setiap 30 detik (30000 milidetik)
setInterval(loadNotifications, 30000);

// Panggil sekali saat halaman pertama kali dibuka
document.addEventListener('DOMContentLoaded', loadNotifications);
</script>
