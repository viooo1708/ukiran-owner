<header class="fixed top-0 left-0 right-0 h-20 bg-white border-b border-[#e5ddd8] shadow-sm z-50">
    <div class="h-full w-full px-8 flex items-center justify-between">

        {{-- Brand Section --}}
        <div class="flex items-center gap-4 w-64">
            <div class="w-11 h-11 rounded-xl bg-[#5d4037] flex items-center justify-center shadow-sm shrink-0">
                <span class="material-symbols-outlined text-white text-2xl">
                    carpenter
                </span>
            </div>
            <div class="leading-tight hidden sm:block">
                <h1 class="text-base font-bold text-[#5d4037] tracking-wide">
                    Adi Ukiran
                </h1>
                <p class="text-[11px] text-gray-400 font-medium tracking-wider uppercase">
                    Owner Dashboard
                </p>
            </div>
        </div>

        {{-- Navigation Center Section --}}
        <nav class="flex-1 h-full flex justify-center items-center gap-8">

            {{-- Dashboard Link --}}
            <a href="{{ route('dashboard') }}"
                class="relative h-full flex items-center px-1 text-sm font-semibold transition-colors duration-200
                {{ request()->routeIs('dashboard')
                    ? 'text-[#5d4037]'
                    : 'text-gray-500 hover:text-[#5d4037]' }}">
                Dashboard
                @if(request()->routeIs('dashboard'))
                    <span class="absolute bottom-0 left-0 w-full h-[3px] bg-[#d4a373] rounded-t-md"></span>
                @endif
            </a>

            {{-- Pesanan Link --}}
            <a href="{{ route('orders.index') }}"
                class="relative h-full flex items-center px-1 text-sm font-semibold transition-colors duration-200
                {{ request()->routeIs('orders.*')
                    ? 'text-[#5d4037]'
                    : 'text-gray-500 hover:text-[#5d4037]' }}">
                Pesanan
                @if(request()->routeIs('orders.*'))
                    <span class="absolute bottom-0 left-0 w-full h-[3px] bg-[#d4a373] rounded-t-md"></span>
                @endif
            </a>

            {{-- Produk Link --}}
            <a href="{{ route('products.index') }}"
                class="relative h-full flex items-center px-1 text-sm font-semibold transition-colors duration-200
                {{ request()->routeIs('products.*')
                    ? 'text-[#5d4037]'
                    : 'text-gray-500 hover:text-[#5d4037]' }}">
                Produk
                @if(request()->routeIs('products.*'))
                    <span class="absolute bottom-0 left-0 w-full h-[3px] bg-[#d4a373] rounded-t-md"></span>
                @endif
            </a>

            {{-- Laporan Link --}}
            <a href="{{ route('reports.index') }}"
                class="relative h-full flex items-center px-1 text-sm font-semibold transition-colors duration-200
                {{ request()->routeIs('reports.*')
                    ? 'text-[#5d4037]'
                    : 'text-gray-500 hover:text-[#5d4037]' }}">
                Laporan
                @if(request()->routeIs('reports.*'))
                    <span class="absolute bottom-0 left-0 w-full h-[3px] bg-[#d4a373] rounded-t-md"></span>
                @endif
            </a>

            {{-- Pelanggan Link --}}
            <a href="{{ route('users.index') }}"
                class="relative h-full flex items-center px-1 text-sm font-semibold transition-colors duration-200
                {{ request()->routeIs('users.*')
                    ? 'text-[#5d4037]'
                    : 'text-gray-500 hover:text-[#5d4037]' }}">
                Pelanggan
                @if(request()->routeIs('users.*'))
                    <span class="absolute bottom-0 left-0 w-full h-[3px] bg-[#d4a373] rounded-t-md"></span>
                @endif
            </a>

        </nav>

        {{-- Right Section --}}
        <div class="w-64 flex justify-end items-center gap-4">

            {{-- Notification Button --}}
            <button class="relative w-10 h-10 rounded-xl hover:bg-[#faf7f4] active:bg-[#f3ece6] flex items-center justify-center transition-colors">
                <span class="material-symbols-outlined text-gray-500 hover:text-gray-700">
                    notifications
                </span>
                <span class="absolute top-2.5 right-2.5 w-2 h-2 bg-red-500 rounded-full ring-2 ring-white"></span>
            </button>

            {{-- Profile Dropdown Wrapper --}}
            <div class="relative">
                <button onclick="toggleProfileMenu()"
                    class="flex items-center gap-3 p-1.5 pr-3 rounded-xl hover:bg-[#faf7f4] active:bg-[#f3ece6] transition-all duration-200 group">

                    @if(session('user.foto'))
                        <img src="{{ session('user.foto') }}" class="w-9 h-9 rounded-lg object-cover border border-gray-100 shadow-sm">
                    @else
                        <div class="w-9 h-9 rounded-lg bg-[#6d4c41] text-white flex items-center justify-center font-bold text-sm shadow-sm">
                            {{ strtoupper(substr(session('user.nama','O'),0,1)) }}
                        </div>
                    @endif

                    <div class="text-left hidden md:block">
                        <p class="text-sm font-bold text-gray-700 group-hover:text-[#5d4037] transition-colors">
                            {{ session('user.nama','Owner') }}
                        </p>
                        <p class="text-[10px] text-gray-400 font-medium tracking-wide uppercase">
                            Administrator
                        </p>
                    </div>

                    <span class="material-symbols-outlined text-gray-400 group-hover:text-gray-600 text-lg transition-transform duration-200">
                        keyboard_arrow_down
                    </span>
                </button>

                {{-- Dropdown Card --}}
                <div id="profileMenu"
                    class="hidden absolute right-0 mt-3 w-60 bg-white rounded-xl shadow-xl border border-gray-100 overflow-hidden z-[100] transform origin-top-right transition-all">

                    <div class="px-5 py-4 bg-[#faf7f4] border-b border-[#f3ece6]">
                        <p class="text-sm font-bold text-[#5d4037]">
                            {{ session('user.nama','Owner') }}
                        </p>
                        <p class="text-xs text-gray-400 mt-0.5">
                            Owner Adi Ukiran
                        </p>
                    </div>

                    <a href="{{ route('profile.index') }}"
                        class="flex items-center gap-3 px-5 py-3.5 text-sm text-gray-600 hover:bg-[#faf7f4] hover:text-[#5d4037] transition-colors">
                        <span class="material-symbols-outlined text-gray-400 text-xl">
                            person
                        </span>
                        Profil Saya
                    </a>

                    <div class="border-t border-gray-50"></div>

                    <form action="{{ url('/logout') }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="w-full flex items-center gap-3 px-5 py-3.5 text-sm font-medium text-red-500 hover:bg-red-50 transition-colors">
                            <span class="material-symbols-outlined text-xl">
                                logout
                            </span>
                            Logout
                        </button>
                    </form>

                </div>
            </div>

        </div>
    </div>
</header>

<script>
function toggleProfileMenu() {
    const menu = document.getElementById('profileMenu');
    menu.classList.toggle('hidden');
}

document.addEventListener('click', function(e) {
    const menu = document.getElementById('profileMenu');
    const button = e.target.closest('button[onclick="toggleProfileMenu()"]');

    if (menu && !menu.contains(e.target) && !button) {
        menu.classList.add('hidden');
    }
});
</script>
