<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        @yield('title', 'Dashboard Owner') | Kriya Ukir
    </title>

    {{-- Tailwind CSS --}}
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>

    {{-- Google Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap"
        rel="stylesheet">

    {{-- Material Icons --}}
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined"
        rel="stylesheet">

    <style>
        body{
            font-family:'Plus Jakarta Sans',sans-serif;
            background:#fbf9f5;
            color:#1b1c1a;
        }

        .material-symbols-outlined{
            font-variation-settings:
            'FILL' 0,
            'wght' 400,
            'GRAD' 0,
            'opsz' 24;
        }

        ::-webkit-scrollbar{
            width:8px;
        }

        ::-webkit-scrollbar-thumb{
            background:#d4c3be;
            border-radius:10px;
        }

        ::-webkit-scrollbar-thumb:hover{
            background:#827470;
        }
    </style>

    @stack('styles')

</head>

<body>

    {{-- Sidebar --}}
    @include('components.sidebar')

    <div class="ml-72 min-h-screen flex flex-col">

        {{-- Navbar --}}
        @include('components.navbar')

        {{-- Content --}}
        <main class="flex-1 pt-16 px-6 pb-6">

            {{-- Alert Success --}}
            @if(session('success'))
                <div class="mt-6 mb-5 rounded-xl border border-green-200 bg-green-50 p-4 text-green-700">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Alert Error --}}
            @if(session('error'))
                <div class="mt-6 mb-5 rounded-xl border border-red-200 bg-red-50 p-4 text-red-700">
                    {{ session('error') }}
                </div>
            @endif

            {{-- Validation --}}
            @if($errors->any())
                <div class="mt-6 mb-5 rounded-xl border border-red-200 bg-red-50 p-4">

                    <ul class="list-disc ml-5 text-red-700">

                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach

                    </ul>

                </div>
            @endif

            @yield('content')

        </main>

        {{-- Footer --}}
        @include('components.footer')

    </div>

    @stack('scripts')

</body>

</html>
