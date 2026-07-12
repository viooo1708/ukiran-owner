<header class="fixed top-0 left-72 right-0 h-16 bg-white border-b border-gray-200 shadow-sm z-40">

    <div class="h-full px-8 flex items-center justify-between">

        {{-- Left --}}
        <div class="flex items-center">

            <h1 class="text-xl font-semibold text-gray-800">
                Dashboard Owner
            </h1>

        </div>

        {{-- Right --}}
        <div class="flex items-center gap-3">

            {{-- Notification --}}
            <button
                class="relative w-11 h-11 rounded-xl flex items-center justify-center
                text-gray-500 hover:bg-amber-50 hover:text-amber-700 transition">

                <span class="material-symbols-outlined">
                    notifications
                </span>

                <span
                    class="absolute top-2.5 right-2.5
                    w-2.5 h-2.5 bg-red-500 rounded-full border-2 border-white">
                </span>

            </button>

            {{-- Help --}}
            <button
                class="w-11 h-11 rounded-xl flex items-center justify-center
                text-gray-500 hover:bg-amber-50 hover:text-amber-700 transition">

                <span class="material-symbols-outlined">
                    help
                </span>

            </button>

            {{-- Divider --}}
            <div class="w-px h-8 bg-gray-200 mx-1"></div>

            {{-- Profile --}}
            <div class="relative">

                <button
                    onclick="toggleProfileMenu()"
                    class="flex items-center gap-3 rounded-xl px-3 py-2 hover:bg-gray-50 transition">

                    @if(session('user.foto'))

                        <img
                            src="{{ session('user.foto') }}"
                            class="w-10 h-10 rounded-full object-cover border border-gray-200">

                    @else

                        <div
                            class="w-10 h-10 rounded-full
                            bg-gradient-to-br from-amber-600 to-amber-800
                            text-white font-semibold
                            flex items-center justify-center">

                            {{ strtoupper(substr(session('user.nama') ?? session('user.name') ?? 'O',0,1)) }}

                        </div>

                    @endif

                    <div class="hidden md:block text-left">

                        <p class="font-semibold text-gray-800 text-sm">
                            {{ session('user.nama') ?? session('user.name') ?? 'Owner' }}
                        </p>

                        <p class="text-xs text-gray-500">
                            Administrator
                        </p>

                    </div>

                    <span class="material-symbols-outlined text-gray-400">
                        keyboard_arrow_down
                    </span>

                </button>

                {{-- Dropdown --}}
                <div
                    id="profileMenu"
                    class="hidden absolute right-0 mt-3 w-64 bg-white rounded-2xl
                    shadow-xl border border-gray-100 overflow-hidden">

                    <div class="px-5 py-4 bg-gray-50">

                        <p class="font-semibold text-gray-800">
                            {{ session('user.nama') ?? session('user.name') ?? 'Owner' }}
                        </p>

                        <p class="text-sm text-gray-500">
                            Administrator
                        </p>

                    </div>

                    <a
                        href="{{ route('profile.index') }}"
                        class="flex items-center gap-3 px-5 py-3 hover:bg-gray-50 transition">

                        <span class="material-symbols-outlined">
                            person
                        </span>

                        Profil

                    </a>

                    <div class="border-t"></div>

                    <form action="/logout" method="POST">

                        @csrf

                        <button
                            class="w-full flex items-center gap-3 px-5 py-3
                            text-red-600 hover:bg-red-50 transition">

                            <span class="material-symbols-outlined">
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
    document.getElementById('profileMenu').classList.toggle('hidden');
}

window.addEventListener('click', function (e) {

    const menu = document.getElementById('profileMenu');
    const button = e.target.closest('[onclick="toggleProfileMenu()"]');

    if (!button && !e.target.closest('#profileMenu')) {
        menu.classList.add('hidden');
    }

});
</script>
