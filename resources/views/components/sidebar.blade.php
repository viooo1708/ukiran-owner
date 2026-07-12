<!-- <aside
    class="fixed left-0 top-0 h-screen w-72 bg-[#f8f6f3] border-r border-[#ded5ce] shadow-sm flex flex-col z-50">


    {{-- Logo --}}
    <div class="px-6 py-6 border-b border-[#ded5ce]">

        <div class="flex items-center gap-3">

            <div
                class="w-12 h-12 rounded-xl bg-[#5d4037] flex items-center justify-center shadow">

                <span class="material-symbols-outlined text-white text-2xl">
                    carpenter
                </span>

            </div>


            <div>

                <h2 class="text-xl font-bold text-[#5d4037]">
                    Kriya Ukir
                </h2>

                <p class="text-xs text-gray-500">
                    Owner Dashboard
                </p>

            </div>

        </div>

    </div>



    {{-- Menu --}}
    <nav class="flex-1 px-4 py-6 space-y-2">


        {{-- Dashboard --}}
        <a href="{{ route('dashboard') }}"
            class="group flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200

            {{ request()->routeIs('dashboard')
                ? 'bg-[#fed488] text-[#5d4037] shadow-sm font-semibold'
                : 'text-gray-700 hover:bg-[#ebe6df]' }}">

            <span class="material-symbols-outlined
                {{ request()->routeIs('dashboard')
                    ? 'text-[#5d4037]'
                    : 'text-gray-500 group-hover:text-[#5d4037]' }}">
                dashboard
            </span>

            Dashboard

        </a>



        {{-- Pesanan --}}
        <a href="{{ route('orders.index') }}"
            class="group flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200

            {{ request()->routeIs('orders.*')
                ? 'bg-[#fed488] text-[#5d4037] shadow-sm font-semibold'
                : 'text-gray-700 hover:bg-[#ebe6df]' }}">

            <span class="material-symbols-outlined">
                shopping_cart
            </span>

            Pesanan

        </a>



        {{-- Produk --}}
        <a href="{{ route('products.index') }}"
            class="group flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200

            {{ request()->routeIs('products.*')
                ? 'bg-[#fed488] text-[#5d4037] shadow-sm font-semibold'
                : 'text-gray-700 hover:bg-[#ebe6df]' }}">

            <span class="material-symbols-outlined">
                inventory_2
            </span>

            Produk

        </a>



        {{-- Laporan --}}
        <a href="{{ route('reports.index') }}"
            class="group flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200

            {{ request()->routeIs('reports.*')
                ? 'bg-[#fed488] text-[#5d4037] shadow-sm font-semibold'
                : 'text-gray-700 hover:bg-[#ebe6df]' }}">

            <span class="material-symbols-outlined">
                analytics
            </span>

            Laporan

        </a>



        {{-- Pelanggan --}}
        <a href="{{ route('users.index') }}"
        class="group flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200
        {{ request()->routeIs('users.*')
        ? 'bg-[#fed488] text-[#5d4037] shadow-sm font-semibold'
        : 'text-gray-700 hover:bg-[#ebe6df]' }}">

            <span class="material-symbols-outlined">
                groups
            </span>

            Pelanggan

        </a>


        {{-- Profil Saya --}}
        <a href="{{ route('profile.index') }}"
        class="group flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200
        {{ request()->routeIs('profile.*')
        ? 'bg-[#fed488] text-[#5d4037] shadow-sm font-semibold'
        : 'text-gray-700 hover:bg-[#ebe6df]' }}">

            <span class="material-symbols-outlined">
                account_circle
            </span>

            Profil Saya

        </a>

    </nav>

    {{-- User Card --}}
    <div class="p-5 border-t border-[#ded5ce]">


        <div class="bg-white rounded-2xl p-4 border border-gray-100 shadow-sm">


            <div class="flex items-center gap-3">


                {{-- Avatar --}}
                <div
                    class="w-12 h-12 rounded-xl bg-gradient-to-br from-[#795548] to-[#4e342e]
                    text-white flex items-center justify-center font-bold text-lg">

                    {{ strtoupper(substr(session('user.nama','Owner'),0,1)) }}

                </div>



                <div class="min-w-0">

                    <h4 class="font-semibold text-gray-800 truncate">

                        {{ session('user.nama','Owner') }}

                    </h4>


                    <p class="text-sm text-gray-500">

                        {{ ucfirst(session('user.role','Owner')) }}

                    </p>

                </div>


            </div>



            {{-- Logout --}}
            <form action="{{ url('/logout') }}" method="POST" class="mt-4">

                @csrf


                <button
                    class="w-full flex items-center justify-center gap-2
                    bg-red-500 hover:bg-red-600
                    text-white py-2.5 rounded-xl
                    transition duration-200">


                    <span class="material-symbols-outlined text-lg">
                        logout
                    </span>


                    Logout

                </button>


            </form>


        </div>


    </div>


</aside> -->
