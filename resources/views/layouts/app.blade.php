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

        /* Animasi Transisi Halus Alert */
        @keyframes slideInDown {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .alert-enter {
            animation: slideInDown 0.4s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        .flash-hidden {
            opacity: 0;
            transform: translateY(-10px) scale(0.98);
            transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        }
    </style>

    @stack('styles')
</head>

<body class="antialiased min-h-screen flex flex-col selection:bg-[#5d4037] selection:text-white">

    {{-- Navbar --}}
    @include('components.navbar')

    {{-- Main Content Area --}}
    {{-- Padding X diselaraskan dengan Footer (px-4 sm:px-6 lg:px-8) --}}
    <main class="flex-1 pt-28 pb-12 w-full px-4 sm:px-6 lg:px-8">

        {{-- Container Notifikasi Global (Diselaraskan ke max-w-7xl) --}}
        <div id="flash-container" class="w-full max-w-7xl mx-auto mb-6 space-y-3 relative z-40">

            {{-- Alert Success --}}
            @if(session('success'))
            <div id="alert-success" class="alert-enter rounded-xl border border-emerald-100 border-l-4 border-l-emerald-500 bg-white p-4 text-emerald-800 shadow-md shadow-emerald-900/5 flex items-start gap-3">
                <span class="material-symbols-outlined text-emerald-500 shrink-0 select-none">check_circle</span>
                <div class="text-sm font-semibold flex-1 mt-0.5">{{ session('success') }}</div>
                <button onclick="dismissAlert('alert-success')" class="text-gray-400 hover:text-gray-600 transition-colors shrink-0 p-1 rounded-lg hover:bg-gray-100">
                    <span class="material-symbols-outlined text-[18px]">close</span>
                </button>
            </div>
            @endif

            {{-- Alert Error --}}
            @if(session('error'))
            <div id="alert-error" class="alert-enter rounded-xl border border-rose-100 border-l-4 border-l-rose-500 bg-white p-4 text-rose-800 shadow-md shadow-rose-900/5 flex items-start gap-3">
                <span class="material-symbols-outlined text-rose-500 shrink-0 select-none">error</span>
                <div class="text-sm font-semibold flex-1 mt-0.5">{{ session('error') }}</div>
                <button onclick="dismissAlert('alert-error')" class="text-gray-400 hover:text-gray-600 transition-colors shrink-0 p-1 rounded-lg hover:bg-gray-100">
                    <span class="material-symbols-outlined text-[18px]">close</span>
                </button>
            </div>
            @endif

            {{-- Validation Errors --}}
            @if($errors->any())
            <div id="alert-validation" class="alert-enter rounded-xl border border-amber-100 border-l-4 border-l-amber-500 bg-white p-4 text-amber-900 shadow-md shadow-amber-900/5 flex items-start gap-3">
                <span class="material-symbols-outlined text-amber-500 shrink-0 select-none">warning</span>
                <div class="text-sm flex-1 mt-0.5">
                    <span class="font-bold block mb-1">Mohon periksa kembali inputan Anda:</span>
                    <ul class="list-disc ml-5 space-y-0.5 text-amber-800/90 font-medium">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                <button onclick="dismissAlert('alert-validation')" class="text-gray-400 hover:text-gray-600 transition-colors shrink-0 p-1 rounded-lg hover:bg-gray-100">
                    <span class="material-symbols-outlined text-[18px]">close</span>
                </button>
            </div>
            @endif

        </div>

        {{-- Page Content Slot (Diselaraskan ke max-w-7xl) --}}
        <div class="w-full max-w-7xl mx-auto">
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

                            // Menggunakan custom alert dari browser
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
                }, 400); // Sinkronisasi dengan durasi transisi CSS
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
