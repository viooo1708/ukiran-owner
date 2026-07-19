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
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
    </style>
</head>
<body class="bg-[#fcfaf7] min-h-screen flex items-center justify-center p-4 relative overflow-hidden">

    <!-- Background Decoration -->
    <div class="absolute inset-0 z-0">
        <div class="absolute top-0 left-0 w-96 h-96 bg-amber-200/30 rounded-full blur-[128px]"></div>
        <div class="absolute bottom-0 right-0 w-96 h-96 bg-stone-300/30 rounded-full blur-[128px]"></div>
    </div>

    <!-- Login Card -->
    <div class="glass-card w-full max-w-md rounded-3xl shadow-2xl p-8 md:p-10 z-10 transition-all hover:scale-[1.01] duration-500">

        <!-- Header -->
        <div class="text-center mb-10">
            <div class="w-16 h-16 bg-[#5d4037] rounded-2xl mx-auto flex items-center justify-center shadow-lg mb-6 rotate-3 hover:rotate-0 transition-transform">
                <span class="material-symbols-outlined text-white text-3xl">chair</span>
            </div>
            <h1 class="text-2xl font-extrabold text-[#3e2723]">Selamat Datang</h1>
            <p class="text-gray-500 text-sm mt-1">Masuk ke portal pemilik Adi Ukiran</p>
        </div>

        <!-- Form -->
        <form action="{{ url('/login') }}" method="POST" class="space-y-5">
            @csrf

            <div class="space-y-2">
                <label class="text-[11px] font-bold text-gray-400 uppercase tracking-widest pl-1">Email</label>
                <input type="email" name="email" required class="w-full bg-white/50 border border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-[#5d4037]/20 focus:border-[#5d4037] outline-none transition-all" placeholder="owner@adiukiran.com">
            </div>

            <div class="space-y-2">
                <label class="text-[11px] font-bold text-gray-400 uppercase tracking-widest pl-1">Password</label>
                <input type="password" name="password" required class="w-full bg-white/50 border border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-[#5d4037]/20 focus:border-[#5d4037] outline-none transition-all" placeholder="••••••••">
            </div>

            <button type="submit" class="w-full bg-[#3e2723] text-white py-4 rounded-xl font-bold text-sm hover:bg-black shadow-lg shadow-[#5d4037]/20 transition-all active:scale-95 mt-4">
                MASUK SEKARANG
            </button>
        </form>

        <!-- Footer -->
        <p class="text-center text-[11px] text-gray-400 mt-8">
            © 2026 Adi Ukiran - Sistem Manajemen Eksklusif
        </p>
    </div>

</body>
</html>
