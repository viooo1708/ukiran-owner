<footer class="bg-white/60 backdrop-blur-md border-t border-amber-900/10 mt-auto shadow-[0_-8px_32px_0_rgba(93,64,55,0.02)]">

    <div class="max-w-[1600px] mx-auto px-6 sm:px-8 lg:px-12 py-12">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10 lg:gap-12">

            {{-- Logo & Deskripsi --}}
            <div class="space-y-4">
                <div class="flex items-center gap-3.5">
                    <!-- Logo Kustom Menggunakan Tag IMG Anda -->
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-[#5d4037] to-[#3e2723] flex items-center justify-center shadow-md shadow-amber-900/10 shrink-0 overflow-hidden">
                        <img src="{{ asset('images/logo-kriya-ukir.png') }}" alt="Logo Kriya Ukir" class="w-full h-full object-cover">
                    </div>
                    <div>
                        <h3 class="font-bold text-base text-[#3e2723] tracking-wide">
                            UMKM Adi Ukiran
                        </h3>
                        <p class="text-[11px] font-semibold text-amber-700/80 tracking-wider uppercase">
                            Furniture & Kriya Ukir
                        </p>
                    </div>
                </div>
                <p class="text-xs text-gray-500 leading-relaxed font-medium">
                    Menyediakan berbagai produk ukiran kayu berkualitas tinggi dengan perpaduan desain modern dan seni tradisional asli Nusantara.
                </p>
            </div>

            {{-- Alamat --}}
            <div>
                <h4 class="text-xs font-bold uppercase tracking-widest text-[#3e2723] mb-5">
                    Workshop & Galeri
                </h4>
                <div class="flex gap-3 items-start">
                    <span class="material-symbols-outlined text-amber-700 text-xl shrink-0 mt-0.5">
                        location_on
                    </span>
                    <p class="text-xs text-gray-500 leading-relaxed font-medium">
                        <span class="text-gray-800 font-semibold block mb-0.5">Graha Adi Ukiran</span>
                        Jl. Raya Indarung,<br>
                        Padang, Sumatera Barat
                    </p>
                </div>
            </div>

            {{-- Kontak --}}
            <div>
                <h4 class="text-xs font-bold uppercase tracking-widest text-[#3e2723] mb-5">
                    Hubungi Kami
                </h4>
                <div class="space-y-3.5">
                    <div class="flex items-center gap-3 group">
                        <span class="material-symbols-outlined text-amber-700 text-xl group-hover:scale-110 transition-transform">
                            call
                        </span>
                        <span class="text-xs text-gray-500 font-medium group-hover:text-[#5d4037] transition-colors">
                            +62 812-3456-7890
                        </span>
                    </div>

                    <div class="flex items-center gap-3 group">
                        <span class="material-symbols-outlined text-amber-700 text-xl group-hover:scale-110 transition-transform">
                            mail
                        </span>
                        <span class="text-xs text-gray-500 font-medium group-hover:text-[#5d4037] transition-colors">
                            info@adiukiran.com
                        </span>
                    </div>

                    <div class="flex items-start gap-3">
                        <span class="material-symbols-outlined text-amber-700 text-xl mt-0.5">
                            schedule
                        </span>
                        <p class="text-xs text-gray-500 font-medium leading-tight">
                            Senin - Sabtu<br>
                            <span class="text-gray-400 text-[11px] font-normal block mt-1">08.00 - 17.00 WIB</span>
                        </p>
                    </div>
                </div>
            </div>

            {{-- Media Sosial --}}
            <div>
                <h4 class="text-xs font-bold uppercase tracking-widest text-[#3e2723] mb-5">
                    Jejaring Sosial
                </h4>
                <div class="flex gap-2.5 mb-5">
                    <a href="#" aria-label="Website"
                        class="w-9 h-9 rounded-xl bg-[#5d4037]/5 text-gray-500 hover:bg-[#5d4037] hover:text-white hover:shadow-md hover:shadow-amber-900/10 active:scale-95 transition-all duration-300 flex items-center justify-center">
                        <span class="material-symbols-outlined text-lg">public</span>
                    </a>

                    <a href="#" aria-label="Instagram"
                        class="w-9 h-9 rounded-xl bg-[#5d4037]/5 text-gray-500 hover:bg-[#5d4037] hover:text-white hover:shadow-md hover:shadow-amber-900/10 active:scale-95 transition-all duration-300 flex items-center justify-center">
                        <span class="material-symbols-outlined text-lg">photo_camera</span>
                    </a>

                    <a href="#" aria-label="YouTube"
                        class="w-9 h-9 rounded-xl bg-[#5d4037]/5 text-gray-500 hover:bg-[#5d4037] hover:text-white hover:shadow-md hover:shadow-amber-900/10 active:scale-95 transition-all duration-300 flex items-center justify-center">
                        <span class="material-symbols-outlined text-lg">smart_display</span>
                    </a>
                </div>

                <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-emerald-50 border border-emerald-100">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    <span class="text-[10px] text-emerald-700 font-bold tracking-wider uppercase">
                        Sistem Online
                    </span>
                </div>
            </div>

        </div>
    </div>

    {{-- Bottom Footer --}}
    <div class="border-t border-amber-900/5 bg-[#5d4037]/5 backdrop-blur-sm">
        <div class="max-w-[1600px] mx-auto px-6 sm:px-8 lg:px-12 py-5">
            <div class="flex flex-col sm:flex-row justify-between items-center gap-4">

                <p class="text-xs text-gray-500 font-medium text-center sm:text-left">
                    © {{ date('Y') }} <span class="font-bold text-[#3e2723]">UMKM Adi Ukiran</span>. Hak Cipta Dilindungi Undang-Undang.
                </p>

                <div class="flex items-center gap-4 text-[11px] font-bold tracking-wide text-gray-400 uppercase">
                    <span>Dashboard Owner</span>
                    <span class="text-amber-900/20">•</span>
                    <span>Laravel 12</span>
                    <span class="text-amber-900/20">•</span>
                    <span class="text-[#5d4037]/70">v1.0</span>
                </div>

            </div>
        </div>
    </div>

</footer>
