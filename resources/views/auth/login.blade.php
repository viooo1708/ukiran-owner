<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Owner | Kriya Ukir</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .glass-card {
            background: rgba(255, 255, 255, 0.75);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(234, 223, 216, 0.6);
        }
    </style>
</head>
<body class="bg-[#fcfaf7] min-h-screen flex items-center justify-center p-4 relative overflow-hidden text-gray-800">

    <!-- Background Decoration -->
    <div class="absolute inset-0 z-0 pointer-events-none">
        <div class="absolute top-0 left-0 w-96 h-96 bg-amber-200/20 rounded-full blur-[128px]"></div>
        <div class="absolute bottom-0 right-0 w-96 h-96 bg-stone-300/20 rounded-full blur-[128px]"></div>
    </div>

    <!-- Login Card -->
    <div class="glass-card w-full max-w-md rounded-3xl shadow-xl p-8 md:p-10 z-10 transition-all hover:scale-[1.01] duration-500">

        <!-- Header -->
        <div class="text-center mb-8">
            <!-- WADAH LOGO YANG DIPERBAIKI -->
            <!-- Perubahan:
                 1. Hapus shadow-md dari wadah luar (untuk menghindari bayangan kotak).
                 2. Tambahkan rounded-full pada wadah luar.
            -->
            <div class="w-16 h-16 mx-auto flex items-center justify-center rounded-full mb-5 rotate-3 hover:rotate-0 transition-transform p-1 overflow-hidden">
                {{-- Memanggil logo-ukir.php dari folder public --}}
                <!-- Pertahankan: rounded-full pada gambar agar logo jpeg tampak melingkar, dan shadow-lg shadow-black/5 untuk efek bayangan lingkaran halus -->
                <img src="{{ asset('logo-kriya-ukir.jpeg') }}" alt="Logo Kriya Ukir" class="w-full h-full object-contain rounded-full shadow-lg shadow-black/5">
            </div>
            <h1 class="text-2xl font-extrabold text-[#3e2723] tracking-tight">Selamat Datang</h1>
            <p class="text-gray-500 text-xs font-semibold mt-1">Masuk ke portal manajemen pemilik Kriya Ukir</p>
        </div>

        {{-- Alert Error / Gagal Login --}}
        @if ($errors->any() || session('error'))
            <div class="mb-6 rounded-2xl border border-rose-200 bg-rose-50 p-4 shadow-sm text-xs text-rose-700 flex items-start gap-2.5">
                <span class="material-symbols-outlined text-rose-600 text-base shrink-0 mt-0.5">error</span>
                <div class="space-y-1">
                    <span class="font-bold block">Autentikasi Gagal</span>
                    @if (session('error'))
                        <p>{{ session('error') }}</p>
                    @endif
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Form --}}
        <form action="{{ url('/login') }}" method="POST" class="space-y-4">
            @csrf

            <div class="space-y-1.5">
                <label class="text-[11px] font-bold text-gray-500 uppercase tracking-wider pl-1">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required class="w-full bg-white/70 border border-gray-200 rounded-xl px-4 py-3 text-xs font-semibold text-gray-800 focus:ring-2 focus:ring-[#5d4037]/10 focus:border-[#5d4037] outline-none transition-all placeholder:text-gray-400" placeholder="owner@kriyaukir.com">
            </div>

            <div class="space-y-1.5">
                <label class="text-[11px] font-bold text-gray-500 uppercase tracking-wider pl-1">Password</label>
                <input type="password" name="password" required class="w-full bg-white/70 border border-gray-200 rounded-xl px-4 py-3 text-xs font-semibold text-gray-800 focus:ring-2 focus:ring-[#5d4037]/10 focus:border-[#5d4037] outline-none transition-all placeholder:text-gray-400" placeholder="••••••••">
            </div>

            <button type="submit" class="w-full bg-[#5d4037] text-white py-3.5 rounded-xl font-bold text-xs uppercase tracking-wider hover:bg-[#3e2723] shadow-md shadow-[#5d4037]/15 transition-all active:scale-95 mt-2">
                Masuk Sekarang
            </button>
        </form>

        <!-- Footer -->
        <p class="text-center text-[11px] text-gray-400 font-medium mt-8">
            © 2026 Kriya Ukir - Sistem Manajemen Eksklusif
        </p>
    </div>

</body>
</html>
