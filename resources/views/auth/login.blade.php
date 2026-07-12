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

        body{

            font-family:'Plus Jakarta Sans',sans-serif;

            background:#f8f6f2;

        }

        .wood{

            position:fixed;

            inset:0;

            background:url('https://www.transparenttextures.com/patterns/wood-pattern.png');

            opacity:.05;

            z-index:-2;

        }

        .ornament-top{

            position:fixed;

            top:-100px;

            left:-100px;

            width:350px;

            height:350px;

            background:url('https://images.unsplash.com/photo-1519710164239-da123dc03ef4?q=80&w=800');

            background-size:cover;

            opacity:.08;

            border-radius:50%;

            z-index:-1;

        }

        .ornament-bottom{

            position:fixed;

            right:-120px;

            bottom:-120px;

            width:380px;

            height:380px;

            background:url('https://images.unsplash.com/photo-1519710164239-da123dc03ef4?q=80&w=800');

            background-size:cover;

            opacity:.08;

            border-radius:50%;

            transform:rotate(180deg);

            z-index:-1;

        }

        .card{

            background:rgba(255,255,255,.82);

            backdrop-filter:blur(15px);

        }

        .btn-login{

            background:#5d4037;

            transition:.3s;

        }

        .btn-login:hover{

            background:#3e2723;

        }

    </style>

</head>

<body>

<div class="wood"></div>

<div class="ornament-top"></div>

<div class="ornament-bottom"></div>

<div class="min-h-screen flex justify-center items-center px-5">

    <div class="card w-full max-w-md rounded-2xl shadow-xl p-8">

        <div class="text-center mb-8">

            <h1 class="text-3xl font-bold text-[#4e342e]">

                Kriya Ukir

            </h1>

            <p class="text-gray-500 mt-2">

                Website Owner UMKM Adi Ukiran

            </p>

        </div>

        @if(session('error'))

            <div class="bg-red-100 text-red-700 rounded-lg p-3 mb-4">

                {{ session('error') }}

            </div>

        @endif

        @if(session('success'))

            <div class="bg-green-100 text-green-700 rounded-lg p-3 mb-4">

                {{ session('success') }}

            </div>

        @endif

        @if($errors->any())

            <div class="bg-red-100 text-red-700 rounded-lg p-3 mb-4">

                <ul class="list-disc ml-5">

                    @foreach($errors->all() as $error)

                        <li>{{ $error }}</li>

                    @endforeach

                </ul>

            </div>

        @endif

        <form action="{{ url('/login') }}" method="POST">

            @csrf

            <div class="mb-5">

                <label class="block mb-2 text-sm text-gray-600">

                    Email

                </label>

                <div class="relative">

                    <span class="material-symbols-outlined absolute left-3 top-3 text-gray-500">

                        mail

                    </span>

                    <input
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        class="w-full rounded-xl border border-gray-300 py-3 pl-12 pr-4 focus:outline-none focus:ring-2 focus:ring-amber-700"
                        placeholder="owner@email.com">

                </div>

            </div>

            <div class="mb-6">

                <label class="block mb-2 text-sm text-gray-600">

                    Password

                </label>

                <div class="relative">

                    <span class="material-symbols-outlined absolute left-3 top-3 text-gray-500">

                        lock

                    </span>

                    <input
                        type="password"
                        name="password"
                        required
                        class="w-full rounded-xl border border-gray-300 py-3 pl-12 pr-4 focus:outline-none focus:ring-2 focus:ring-amber-700"
                        placeholder="********">

                </div>

            </div>

            <button
                type="submit"
                class="btn-login w-full text-white rounded-full py-3 font-semibold">

                LOGIN OWNER

            </button>

        </form>

        <div class="mt-8 border-t pt-5 text-center">

            <p class="text-sm text-gray-500">

                Halaman ini hanya dapat diakses oleh Owner.

            </p>

            <p class="text-sm text-gray-400 mt-2">

                Pelanggan melakukan registrasi melalui aplikasi Android.

            </p>

        </div>

    </div>

</div>

</body>

</html>
