<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="user-id" content="{{ auth()->id() }}">
    <title>@yield('title', 'Dashboard Owner') | Adi Ukiran</title>

    {{-- Tailwind --}}
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>

    {{-- Font --}}
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    {{-- Material Icon --}}
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #fdfbf7;
            color: #1c1917;
        }

        /* Konfigurasi Default Material Icons */
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }

        /* Kustomisasi Scrollbar Premium */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #fdfbf7;
        }

        ::-webkit-scrollbar-thumb {
            background: #d7ccc8;
            border-radius: 20px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #bcaaa4;
        }

        /* Animasi Transisi Halus Keluar */
        .flash-hidden {
            opacity: 0;
            transform: translateY(-10px);
            transition: all 0.5s ease-in-out;
        }
    </style>

    @stack('styles')
</head>

<body class="antialiased min-h-screen flex flex-col">

    {{-- Navbar --}}
    @include('components.navbar')

    {{-- Main Content Area --}}
    <main class="flex-1 pt-24 px-4 sm:px-8 lg:px-12 pb-12 w-full">

        {{-- Container Notifikasi Global --}}
        <div id="flash-container" class="w-full max-w-[1600px] mx-auto mb-6 space-y-3">

            {{-- Alert Success --}}
            @if(session('success'))
            <div id="alert-success" class="rounded-xl border border-emerald-200 bg-emerald-50/80 backdrop-blur-sm p-4 text-emerald-800 shadow-sm flex items-start gap-3">
                <span class="material-symbols-outlined text-emerald-500 shrink-0 select-none">check_circle</span>
                <div class="text-sm font-medium flex-1">{{ session('success') }}</div>
                <button onclick="dismissAlert('alert-success')" class="text-emerald-400 hover:text-emerald-600 transition-colors shrink-0">
                    <span class="material-symbols-outlined text-[18px]">close</span>
                </button>
            </div>
            @endif

            {{-- Alert Error --}}
            @if(session('error'))
            <div id="alert-error" class="rounded-xl border border-rose-200 bg-rose-50/80 backdrop-blur-sm p-4 text-rose-800 shadow-sm flex items-start gap-3">
                <span class="material-symbols-outlined text-rose-500 shrink-0 select-none">error</span>
                <div class="text-sm font-medium flex-1">{{ session('error') }}</div>
                <button onclick="dismissAlert('alert-error')" class="text-rose-400 hover:text-rose-600 transition-colors shrink-0">
                    <span class="material-symbols-outlined text-[18px]">close</span>
                </button>
            </div>
            @endif

            {{-- Validation Errors --}}
            @if($errors->any())
            <div id="alert-validation" class="rounded-xl border border-rose-200 bg-rose-50/80 backdrop-blur-sm p-4 text-rose-800 shadow-sm flex items-start gap-3">
                <span class="material-symbols-outlined text-rose-500 shrink-0 select-none">warning</span>
                <div class="text-sm flex-1">
                    <span class="font-bold block mb-1">Terjadi kesalahan input:</span>
                    <ul class="list-disc ml-5 space-y-0.5 text-rose-700/90">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                <button onclick="dismissAlert('alert-validation')" class="text-rose-400 hover:text-rose-600 transition-colors shrink-0">
                    <span class="material-symbols-outlined text-[18px]">close</span>
                </button>
            </div>
            @endif

        </div>

        {{-- Page Content Slot --}}
        <div class="w-full max-w-[1600px] mx-auto">
            @yield('content')
        </div>

    </main>

    {{-- Footer --}}
    @include('components.footer')

    @stack('scripts')

    {{-- Memanggil file app.js yang sudah dikompilasi Vite --}}
    @vite(['resources/js/app.js'])

    {{-- Script untuk Mendengarkan Notifikasi --}}
    <script type="module">
        document.addEventListener('DOMContentLoaded', function () {

            // Mengambil ID User dari tag meta HTML tanpa memicu error merah di editor
            const metaTag = document.querySelector('meta[name="user-id"]');
            const loggedInUserId = metaTag ? metaTag.getAttribute('content') : null;

            setTimeout(() => {
                // Pastikan loggedInUserId ada (tidak kosong) sebelum mendengarkan Echo
                if (loggedInUserId && window.Echo) {
                    console.log("Mendengarkan notifikasi untuk User ID:", loggedInUserId);

                    window.Echo.private(`App.Models.User.${loggedInUserId}`)
                        .listen('NewNotificationEvent', (event) => {
                            const newNotification = event.notification;
                            console.log("Notifikasi Baru Diterima!", newNotification);

                            alert(`🔔 NOTIFIKASI BARU!\n\n${newNotification.title}\n${newNotification.message}`);
                        })
                        .error((error) => {
                            console.error("Gagal terhubung ke Reverb:", error);
                        });
                }
            }, 500);
        });
    </script>

    {{-- Scripts Kendali UI Global --}}
    <script>
        // Fungsi Manual Tutup Alert
        function dismissAlert(elementId) {
            const alertElement = document.getElementById(elementId);
            if (alertElement) {
                alertElement.classList.add('flash-hidden');
                setTimeout(() => {
                    alertElement.remove();
                }, 500); // Sinkronisasi dengan durasi transisi CSS
            }
        }

        // Pemicu Hilang Otomatis (5 Detik / 5000 Milidetik)
        document.addEventListener('DOMContentLoaded', () => {
            const alerts = ['alert-success', 'alert-error', 'alert-validation'];
            alerts.forEach(id => {
                const element = document.getElementById(id);
                if (element) {
                    setTimeout(() => {
                        dismissAlert(id);
                    }, 5000);
                }
            });
        });

        // Kontrol Menu Profil Navigasi
        function toggleProfileMenu(){
            const menu = document.getElementById('profileMenu');
            if (menu) menu.classList.toggle('hidden');
        }

        document.addEventListener('click', function(event){
            const menu = document.getElementById('profileMenu');
            if(!menu) return;

            if(!event.target.closest('#profileMenu') && !event.target.closest('button')){
                menu.classList.add('hidden');
            }
        });
    </script>

</body>
</html>
