<header class="fixed top-4 left-1/2 -translate-x-1/2 w-[calc(100%-2rem)] max-w-7xl h-16 sm:h-20 bg-white/80 backdrop-blur-lg border border-white/50 shadow-sm shadow-amber-900/5 rounded-2xl z-50 transition-all duration-300">
    <div class="h-full w-full px-4 sm:px-6 flex items-center justify-between gap-2 sm:gap-4">

        {{-- Brand Section --}}
        <div class="flex items-center gap-3 w-auto lg:w-64 shrink-0">
            <div class="w-9 h-9 sm:w-11 sm:h-11 rounded-xl bg-gradient-to-br from-[#5d4037] to-[#3e2723] flex items-center justify-center shadow-md shadow-amber-900/20 shrink-0 overflow-hidden border border-[#3e2723]/50">
                <img src="{{ asset('images/logo-kriya-ukir.png') }}" alt="Logo Adi Ukiran" class="w-full h-full object-cover">
            </div>
            <div class="leading-tight hidden md:block">
                <h1 class="text-sm font-extrabold text-[#3e2723] tracking-wide">Adi Ukiran</h1>
                <p class="text-[10px] text-amber-700/80 font-bold tracking-wider uppercase">Owner Dashboard</p>
            </div>
        </div>

        {{-- Navigation Center Section (Responsive with hidden scrollbar) --}}
        <nav class="flex-1 max-w-2xl bg-[#5d4037]/5 border border-[#5d4037]/10 p-1.5 rounded-full flex items-center justify-start sm:justify-between gap-1 overflow-x-auto [&::-webkit-scrollbar]:hidden [-ms-overflow-style:none] [scrollbar-width:none]">
            <a href="{{ route('dashboard') }}" class="shrink-0 sm:flex-1 py-1.5 sm:py-2 px-4 sm:px-3 text-center rounded-full text-xs font-bold tracking-wide transition-all duration-300 ease-out transform active:scale-95 {{ request()->routeIs('dashboard') ? 'bg-[#5d4037] text-white shadow-md shadow-amber-900/20' : 'text-gray-500 hover:text-[#5d4037] hover:bg-[#5d4037]/10' }}">Dashboard</a>
            <a href="{{ route('orders.index') }}" class="shrink-0 sm:flex-1 py-1.5 sm:py-2 px-4 sm:px-3 text-center rounded-full text-xs font-bold tracking-wide transition-all duration-300 ease-out transform active:scale-95 {{ request()->routeIs('orders.*') ? 'bg-[#5d4037] text-white shadow-md shadow-amber-900/20' : 'text-gray-500 hover:text-[#5d4037] hover:bg-[#5d4037]/10' }}">Pesanan</a>
            <a href="{{ route('products.index') }}" class="shrink-0 sm:flex-1 py-1.5 sm:py-2 px-4 sm:px-3 text-center rounded-full text-xs font-bold tracking-wide transition-all duration-300 ease-out transform active:scale-95 {{ request()->routeIs('products.*') ? 'bg-[#5d4037] text-white shadow-md shadow-amber-900/20' : 'text-gray-500 hover:text-[#5d4037] hover:bg-[#5d4037]/10' }}">Produk</a>
            <a href="{{ route('reports.index') }}" class="shrink-0 sm:flex-1 py-1.5 sm:py-2 px-4 sm:px-3 text-center rounded-full text-xs font-bold tracking-wide transition-all duration-300 ease-out transform active:scale-95 {{ request()->routeIs('reports.*') ? 'bg-[#5d4037] text-white shadow-md shadow-amber-900/20' : 'text-gray-500 hover:text-[#5d4037] hover:bg-[#5d4037]/10' }}">Laporan</a>
            <a href="{{ route('users.index') }}" class="shrink-0 sm:flex-1 py-1.5 sm:py-2 px-4 sm:px-3 text-center rounded-full text-xs font-bold tracking-wide transition-all duration-300 ease-out transform active:scale-95 {{ request()->routeIs('users.*') ? 'bg-[#5d4037] text-white shadow-md shadow-amber-900/20' : 'text-gray-500 hover:text-[#5d4037] hover:bg-[#5d4037]/10' }}">Pelanggan</a>
        </nav>

        {{-- Right Section --}}
        <div class="w-auto lg:w-64 flex justify-end items-center gap-1 sm:gap-3 shrink-0">

            {{-- Notification Dropdown --}}
            <div class="relative">
                <button onclick="toggleNotificationMenu()" id="notiButton" class="relative w-9 h-9 sm:w-10 sm:h-10 rounded-xl hover:bg-[#5d4037]/5 active:bg-[#5d4037]/10 flex items-center justify-center transition-colors group">
                    <span class="material-symbols-outlined text-gray-400 group-hover:text-[#5d4037] transition-colors">notifications</span>
                    <span id="notiBadge" class="hidden absolute top-2 right-2.5 w-2 h-2 bg-rose-500 rounded-full ring-2 ring-white animate-pulse"></span>
                </button>

                <div id="notificationMenu" class="hidden absolute right-0 mt-3 sm:mt-4 w-72 sm:w-80 bg-white/95 backdrop-blur-xl rounded-2xl shadow-xl shadow-amber-900/5 border border-[#eadfd8] overflow-hidden z-[100] transform origin-top-right transition-all duration-200">
                    <div class="px-4 py-3 bg-[#faf8f5] border-b border-[#eadfd8] flex justify-between items-center">
                        <span class="text-xs font-bold text-[#3e2723]">Pemberitahuan</span>
                        <button onclick="markAllAsRead()" class="text-[10px] font-bold text-amber-700 hover:text-[#3e2723] hover:underline transition-colors">Tandai dibaca</button>
                    </div>
                    <div id="notificationList" class="max-h-64 overflow-y-auto divide-y divide-gray-100/60 custom-scrollbar">
                        <div class="p-4 text-center text-xs font-medium text-gray-400 flex flex-col items-center justify-center gap-2">
                            <span class="material-symbols-outlined text-gray-300 animate-spin">sync</span>
                            Memuat...
                        </div>
                    </div>
                    <a href="#" class="block text-center py-2.5 text-[11px] font-bold text-gray-500 hover:text-[#5d4037] bg-white hover:bg-[#faf8f5] transition-colors border-t border-gray-100">
                        Lihat Semua Notifikasi
                    </a>
                </div>
            </div>

            {{-- Profile Dropdown --}}
            <div class="relative">
                <button onclick="toggleProfileMenu()" class="flex items-center gap-2.5 p-1 sm:p-1.5 sm:pr-3 rounded-xl hover:bg-[#5d4037]/5 active:bg-[#5d4037]/10 transition-all duration-200 group">
                    @if(session('user.foto'))
                        <img src="{{ session('user.foto') }}" class="w-8 h-8 sm:w-9 sm:h-9 rounded-lg object-cover border border-amber-900/10 shadow-sm">
                    @else
                        <div class="w-8 h-8 sm:w-9 sm:h-9 rounded-lg bg-gradient-to-br from-[#5d4037] to-[#3e2723] text-white flex items-center justify-center font-bold text-sm shadow-sm">
                            {{ strtoupper(substr(session('user.nama','O'),0,1)) }}
                        </div>
                    @endif
                    <div class="text-left hidden lg:block">
                        <p class="text-xs font-bold text-gray-700 group-hover:text-[#5d4037] transition-colors">{{ session('user.nama','Owner') }}</p>
                        <p class="text-[9px] text-amber-700/80 font-bold tracking-wide uppercase">Administrator</p>
                    </div>
                    <span class="material-symbols-outlined text-gray-400 group-hover:text-[#5d4037] text-lg transition-transform duration-300 hidden sm:block" id="dropdown-icon">keyboard_arrow_down</span>
                </button>

                <div id="profileMenu" class="hidden absolute right-0 mt-3 sm:mt-4 w-56 sm:w-60 bg-white/95 backdrop-blur-xl rounded-2xl shadow-xl shadow-amber-900/5 border border-[#eadfd8] overflow-hidden z-[100] transform origin-top-right transition-all duration-200">
                    <div class="px-5 py-4 bg-[#faf8f5] border-b border-[#eadfd8]">
                        <p class="text-xs font-bold text-[#3e2723] truncate">{{ session('user.nama','Owner') }}</p>
                        <p class="text-[10px] text-gray-500 font-medium mt-0.5">Owner Adi Ukiran</p>
                    </div>
                    <a href="{{ route('profile.index') }}" class="flex items-center gap-3 px-5 py-3.5 text-xs font-bold text-gray-600 hover:bg-[#faf8f5] hover:text-[#5d4037] transition-colors">
                        <span class="material-symbols-outlined text-[18px]">person</span> Profil Saya
                    </a>
                    <form action="{{ url('/logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full flex items-center gap-3 px-5 py-3.5 text-xs font-bold text-rose-600 hover:bg-rose-50 transition-colors border-t border-gray-100">
                            <span class="material-symbols-outlined text-[18px]">logout</span> Keluar Aplikasi
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</header>

<script>
async function loadNotifications() {
    try {
        const token = "{{ Session::get('token') }}";
        const response = await fetch('http://127.0.0.1:1000/api/notifications', {
            method: 'GET',
            headers: {
                'Authorization': 'Bearer ' + token,
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        });

        if (!response.ok) throw new Error('Status: ' + response.status);

        const result = await response.json();
        const list = document.getElementById('notificationList');

        if (result.data && result.data.length > 0) {
            list.innerHTML = result.data.map(n => {
                // Pastikan order_id benar-benar dikirim sebagai angka atau string ID yang valid
                const orderId = n.order_id ? n.order_id : 'null';
                return `
                    <div onclick="markAsReadAndRedirect(${n.id}, ${orderId})" class="p-4 border-b border-gray-100/50 cursor-pointer transition-colors ${n.is_read ? 'bg-white hover:bg-[#faf8f5]' : 'bg-[#faf8f5] hover:bg-[#f5f0ec]'}">
                        <div class="flex justify-between items-start gap-2">
                            <p class="font-bold text-xs leading-relaxed ${n.is_read ? 'text-gray-600' : 'text-[#3e2723]'}">
                                ${n.title}
                            </p>
                            ${n.is_read ? '' : '<span class="shrink-0 w-2 h-2 rounded-full bg-rose-500 mt-1 shadow-sm shadow-rose-500/40 animate-pulse"></span>'}
                        </div>
                        <p class="text-[11px] leading-relaxed ${n.is_read ? 'text-gray-400' : 'text-gray-500'} mt-1">${n.message}</p>
                    </div>
                `;
            }).join('');

            const hasUnread = result.data.some(n => n.is_read == 0);
            document.getElementById('notiBadge').classList.toggle('hidden', !hasUnread);
        } else {
            list.innerHTML = `
                <div class="p-8 text-center text-gray-400 flex flex-col items-center gap-2">
                    <span class="material-symbols-outlined text-3xl opacity-50">notifications_off</span>
                    <p class="text-xs font-medium">Tidak ada pemberitahuan baru.</p>
                </div>`;
            document.getElementById('notiBadge').classList.add('hidden');
        }
    } catch (e) {
        console.error("Error memuat notifikasi:", e);
        document.getElementById('notificationList').innerHTML = '<div class="p-4 text-center text-xs text-rose-500">Gagal memuat notifikasi.</div>';
    }
}

// Perbarui fungsi redirect untuk menangani parameter angka ID secara langsung
async function markAsReadAndRedirect(id, orderId) {
    const token = "{{ Session::get('token') }}";
    try {
        await fetch(`http://127.0.0.1:1000/api/notifications/${id}/read`, {
            method: 'POST',
            headers: {
                'Authorization': 'Bearer ' + token,
                'Accept': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });

        // Cek apakah orderId ada dan bukan null
        if (orderId && orderId !== 'null' && orderId !== null) {
            window.location.href = `/orders/${orderId}`;
        } else {
            window.location.href = '/orders';
        }
    } catch (e) {
        console.error("Gagal menandai dibaca:", e);
        window.location.href = '/orders';
    }
}

async function markAsRead(id) {
    const token = "{{ Session::get('token') }}";
    try {
        const response = await fetch(`http://127.0.0.1:1000/api/notifications/${id}/read`, {
            method: 'POST',
            headers: {
                'Authorization': 'Bearer ' + token,
                'Accept': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });
        if (response.ok) loadNotifications();
    } catch (e) { console.error("Gagal menandai dibaca:", e); }
}

async function markAllAsRead() {
    const token = "{{ Session::get('token') }}";
    try {
        const response = await fetch('http://127.0.0.1:1000/api/notifications/read-all', {
            method: 'POST',
            headers: {
                'Authorization': 'Bearer ' + token,
                'Accept': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });
        if (response.ok) loadNotifications();
    } catch (e) { console.error("Gagal menandai semua dibaca:", e); }
}

function toggleNotificationMenu() {
    const notiMenu = document.getElementById('notificationMenu');
    document.getElementById('profileMenu')?.classList.add('hidden');

    // Animate Profile dropdown icon back
    const icon = document.getElementById('dropdown-icon');
    if(icon) icon.style.transform = 'rotate(0deg)';

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

// Tutup menu jika klik di luar elemen
document.addEventListener('click', function(e) {
    if (!e.target.closest('#profileMenu') && !e.target.closest('button[onclick="toggleProfileMenu()"]')) {
        document.getElementById('profileMenu')?.classList.add('hidden');
        const icon = document.getElementById('dropdown-icon');
        if(icon) icon.style.transform = 'rotate(0deg)';
    }
    if (!e.target.closest('#notificationMenu') && !e.target.closest('#notiButton')) {
        document.getElementById('notificationMenu')?.classList.add('hidden');
    }
});

// Cek notifikasi setiap 30 detik
setInterval(loadNotifications, 30000);

// Panggil pertama kali halaman dibuka
document.addEventListener('DOMContentLoaded', loadNotifications);
</script>
