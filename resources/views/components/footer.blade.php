<footer class="bg-white/70 backdrop-blur-md border-t border-amber-900/10 mt-auto shadow-[0_-8px_32px_0_rgba(93,64,55,0.03)] relative z-10">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10 lg:gap-12">

            {{-- Logo & Deskripsi --}}
            <div class="space-y-4">
                <div class="flex items-center gap-3.5">
                    <!-- Logo Kustom -->
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-[#5d4037] to-[#3e2723] flex items-center justify-center shadow-md shadow-amber-900/20 shrink-0 overflow-hidden border border-[#3e2723]/50">
                        <img src="{{ asset('images/logo-kriya-ukir.png') }}" alt="Logo Adi Ukiran" class="w-full h-full object-cover">
                    </div>
                    <div>
                        <h3 class="font-bold text-base text-[#3e2723] tracking-wide">
                            Adi Ukiran
                        </h3>
                        <p class="text-[11px] font-semibold text-amber-700/90 tracking-wider uppercase">
                            Furniture & Kriya Ukir
                        </p>
                    </div>
                </div>
                <p class="text-xs text-gray-600 leading-relaxed font-medium pr-4">
                    Menyediakan berbagai produk ukiran kayu berkualitas tinggi dengan perpaduan desain modern dan seni tradisional asli Nusantara.
                </p>
            </div>

            {{-- Alamat --}}
            <div>
                <h4 class="text-xs font-bold uppercase tracking-widest text-[#3e2723] mb-5">
                    Workshop & Galeri
                </h4>
                <div class="flex gap-3 items-start group">
                    <span class="material-symbols-outlined text-amber-700 text-xl shrink-0 mt-0.5 group-hover:animate-bounce">
                        location_on
                    </span>
                    <p class="text-xs text-gray-600 leading-relaxed font-medium">
                        <span class="text-gray-900 font-bold block mb-1">Workshop Adi Ukiran</span>
                        Lubuk Ipuh No.5<br>
                        Milik: Adriansyah
                    </p>
                </div>
            </div>

            {{-- Kontak --}}
            <div>
                <h4 class="text-xs font-bold uppercase tracking-widest text-[#3e2723] mb-5">
                    Hubungi Kami
                </h4>
                <div class="space-y-4">
                    <a href="https://wa.me/6289514640926" target="_blank" class="flex items-center gap-3 group w-fit">
                        <span class="material-symbols-outlined text-amber-700 text-xl group-hover:scale-110 transition-transform">
                            call
                        </span>
                        <span class="text-xs text-gray-600 font-semibold group-hover:text-[#5d4037] transition-colors">
                            +62 895-1464-0926
                        </span>
                    </a>

                    <a href="mailto:info@adiukiran.com" class="flex items-center gap-3 group w-fit">
                        <span class="material-symbols-outlined text-amber-700 text-xl group-hover:scale-110 transition-transform">
                            mail
                        </span>
                        <span class="text-xs text-gray-600 font-medium group-hover:text-[#5d4037] transition-colors">
                            info@adiukiran.com
                        </span>
                    </a>

                    <div class="flex items-start gap-3">
                        <span class="material-symbols-outlined text-amber-700 text-xl mt-0.5">
                            schedule
                        </span>
                        <p class="text-xs text-gray-600 font-medium leading-tight">
                            Senin - Sabtu<br>
                            <span class="text-gray-500 text-[11px] font-normal block mt-1">08.00 - 17.00 WIB</span>
                        </p>
                    </div>
                </div>
            </div>

            {{-- Media Sosial --}}
            <div>
                <h4 class="text-xs font-bold uppercase tracking-widest text-[#3e2723] mb-5">
                    Jejaring Sosial
                </h4>
                <div class="flex gap-3 mb-6">
                    <a href="#" aria-label="Website"
                        class="w-10 h-10 rounded-xl bg-white border border-[#eadfd8] text-gray-500 hover:bg-[#5d4037] hover:text-white hover:border-[#5d4037] hover:shadow-md hover:-translate-y-1 transition-all duration-300 flex items-center justify-center">
                        <span class="material-symbols-outlined text-lg">public</span>
                    </a>

                    <a href="#" aria-label="Instagram"
                        class="w-10 h-10 rounded-xl bg-white border border-[#eadfd8] text-gray-500 hover:bg-[#5d4037] hover:text-white hover:border-[#5d4037] hover:shadow-md hover:-translate-y-1 transition-all duration-300 flex items-center justify-center">
                        <span class="material-symbols-outlined text-lg">photo_camera</span>
                    </a>

                    <a href="#" aria-label="YouTube"
                        class="w-10 h-10 rounded-xl bg-white border border-[#eadfd8] text-gray-500 hover:bg-[#5d4037] hover:text-white hover:border-[#5d4037] hover:shadow-md hover:-translate-y-1 transition-all duration-300 flex items-center justify-center">
                        <span class="material-symbols-outlined text-lg">smart_display</span>
                    </a>
                </div>

                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-emerald-50 border border-emerald-200/60 shadow-sm">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    <span class="text-[10px] text-emerald-700 font-bold tracking-wider uppercase">
                        Sistem Online Aktif
                    </span>
                </div>
            </div>

        </div>
    </div>

    {{-- Bottom Footer --}}
    <div class="border-t border-amber-900/10 bg-[#faf8f5]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-5">
            <div class="flex flex-col sm:flex-row justify-between items-center gap-4">

                <p class="text-xs text-gray-500 font-medium text-center sm:text-left">
                    © {{ date('Y') }} <span class="font-bold text-[#3e2723]">Adi Ukiran</span>. Hak Cipta Dilindungi.
                </p>

                <div class="flex items-center gap-3 text-[11px] font-bold tracking-wider text-gray-400 uppercase">
                    <span>Dashboard Owner</span>
                    <span class="text-amber-900/20">•</span>
                    <span>Laravel 11</span>
                    <span class="text-amber-900/20">•</span>
                    <span class="text-[#5d4037] bg-[#5d4037]/10 px-2 py-0.5 rounded-md">v1.0</span>
                </div>

            </div>
        </div>
    </div>

</footer>
