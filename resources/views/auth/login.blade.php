<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Owner | Kriya Ukir</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #fdfbf7;
        }
        .wood-overlay {
            position: fixed;
            inset: 0;
            background: url('https://www.transparenttextures.com/patterns/wood-pattern.png');
            opacity: 0.04;
            z-index: -2;
            pointer-events: none;
        }
        /* Ornamen estetik menggunakan gradien halus menggantikan gambar unspash yang terlalu ramai */
        .ambient-glow-1 {
            position: fixed;
            top: -10%;
            left: -10%;
            width: 50vw;
            height: 50vw;
            background: radial-gradient(circle, rgba(217,119,6,0.08) 0%, rgba(255,255,255,0) 70%);
            z-index: -1;
        }
        .ambient-glow-2 {
            position: fixed;
            bottom: -10%;
            right: -10%;
            width: 50vw;
            height: 50vw;
            background: radial-gradient(circle, rgba(93,64,55,0.08) 0%, rgba(255,255,255,0) 70%);
            z-index: -1;
        }
    </style>
</head>

<body class="antialiased text-gray-800">

<div class="wood-overlay"></div>
<div class="ambient-glow-1"></div>
<div class="ambient-glow-2"></div>

<div class="min-h-screen flex flex-col justify-center items-center px-4 sm:px-6 lg:px-8">

    <!-- Card Container -->
    <div class="w-full max-w-md bg-white/80 backdrop-blur-md rounded-2xl border border-amber-900/10 shadow-[0_8px_30px_rgb(0,0,0,0.04)] p-8 transition-all duration-300 hover:shadow-[0_8px_30px_rgb(93,64,55,0.08)]">

        <!-- Header / Logo -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-14 h-14 rounded-full bg-amber-50 text-[#5d4037] mb-3 border border-amber-900/10 shadow-sm">
                <span class="material-symbols-outlined text-3xl">handyman</span>
            </div>
            <h1 class="text-3xl font-bold tracking-tight text-[#3e2723]">
                Kriya Ukir
            </h1>
            <p class="text-sm text-gray-500 mt-1.5 font-medium">
                Pusat Kendali Owner UMKM Adi Ukiran
            </p>
        </div>

        {{-- Flash Messages & Error Validation --}}
        @if(session('error'))
            <div class="bg-rose-50 border border-rose-200 text-rose-700 rounded-xl p-4 mb-5 text-sm flex items-start gap-3">
                <span class="material-symbols-outlined text-rose-500 shrink-0 select-none text-[20px]">error</span>
                <div class="font-medium">{{ session('error') }}</div>
            </div>
        @endif

        @if(session('success'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl p-4 mb-5 text-sm flex items-start gap-3">
                <span class="material-symbols-outlined text-emerald-500 shrink-0 select-none text-[20px]">check_circle</span>
                <div class="font-medium">{{ session('success') }}</div>
            </div>
        @endif

        @if($errors->any())
            <div class="bg-rose-50 border border-rose-200 text-rose-700 rounded-xl p-4 mb-5 text-sm flex items-start gap-3">
                <span class="material-symbols-outlined text-rose-500 shrink-0 select-none text-[20px]">warning</span>
                <div>
                    <span class="font-semibold block mb-1">Periksa kembali data Anda:</span>
                    <ul class="list-disc ml-4 space-y-0.5 text-rose-600/90">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        {{-- Form Login --}}
        <form action="{{ url('/login') }}" method="POST" class="space-y-5">
            @csrf

            <!-- Input Email -->
            <div>
                <label for="email" class="block mb-2 text-xs font-semibold tracking-wider text-gray-600 uppercase">
                    Alamat Email
                </label>
                <div class="relative group">
                    <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-amber-700 transition-colors duration-200 select-none">
                        mail
                    </span>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        class="w-full rounded-xl border border-gray-200 bg-gray-50/50 py-3 pl-11 pr-4 text-sm outline-none transition-all duration-200 focus:border-amber-700 focus:bg-white focus:ring-4 focus:ring-amber-700/10 placeholder:text-gray-400"
                        placeholder="owner@email.com">
                </div>
            </div>

            <!-- Input Password -->
            <div>
                <label for="password" class="block mb-2 text-xs font-semibold tracking-wider text-gray-600 uppercase">
                    Kata Sandi
                </label>
                <div class="relative group">
                    <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-amber-700 transition-colors duration-200 select-none">
                        lock
                    </span>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        required
                        class="w-full rounded-xl border border-gray-200 bg-gray-50/50 py-3 pl-11 pr-4 text-sm outline-none transition-all duration-200 focus:border-amber-700 focus:bg-white focus:ring-4 focus:ring-amber-700/10 placeholder:text-gray-400"
                        placeholder="••••••••">
                </div>
            </div>

            <!-- Tombol Submit -->
            <button
                type="submit"
                class="w-full bg-[#5d4037] hover:bg-[#4a322b] active:scale-[0.98] text-white rounded-xl py-3.5 font-semibold text-sm tracking-wide shadow-md shadow-amber-900/10 hover:shadow-lg hover:shadow-amber-900/20 transition-all duration-200 mt-2">
                MASUK SEBAGAI OWNER
            </button>
        </form>

        <!-- Footer Card -->
        <div class="mt-8 border-t border-gray-100 pt-5 text-center space-y-1.5">
            <p class="text-xs font-medium text-gray-500 flex items-center justify-center gap-1">
                <span class="material-symbols-outlined text-[16px] text-amber-600">verified_user</span>
                Akses terbatas khusus akun Owner.
            </p>
            <p class="text-[11px] text-gray-400 leading-relaxed max-w-[280px] mx-auto">
                Pelanggan umum silakan melakukan registrasi dan transaksi melalui aplikasi Android.
            </p>
        </div>

    </div>
</div>

</body>
</html>
