<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        @yield('title', 'Dashboard Owner') | Adi Ukiran
    </title>


    {{-- Tailwind --}}
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>


    {{-- Font --}}
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap"
        rel="stylesheet">


    {{-- Material Icon --}}
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


    </style>


    @stack('styles')

</head>



<body>


<div class="min-h-screen flex flex-col">



    {{-- Navbar --}}
    @include('components.navbar')



    {{-- Main --}}
    <main class="flex-1 pt-24 px-10 pb-10 w-full">


        {{-- Alert Success --}}
        @if(session('success'))

        <div class="mb-6 rounded-xl border border-green-200 bg-green-50 p-4 text-green-700">

            {{ session('success') }}

        </div>

        @endif



        {{-- Alert Error --}}
        @if(session('error'))

        <div class="mb-6 rounded-xl border border-red-200 bg-red-50 p-4 text-red-700">

            {{ session('error') }}

        </div>

        @endif




        {{-- Validation --}}
        @if($errors->any())

        <div class="mb-6 rounded-xl border border-red-200 bg-red-50 p-4">


            <ul class="list-disc ml-5 text-red-700">

                @foreach($errors->all() as $error)

                    <li>
                        {{ $error }}
                    </li>

                @endforeach

            </ul>


        </div>

        @endif




        {{-- Page Content --}}
        <div class="w-full max-w-[1600px] mx-auto">

            @yield('content')

        </div>



    </main>




    {{-- Footer --}}
    @include('components.footer')



</div>





@stack('scripts')



<script>

function toggleProfileMenu(){

    const menu = document.getElementById('profileMenu');

    menu.classList.toggle('hidden');

}



document.addEventListener('click',function(event){


    const menu=document.getElementById('profileMenu');


    if(!menu) return;



    if(
        !event.target.closest('#profileMenu') &&
        !event.target.closest('button')
    ){

        menu.classList.add('hidden');

    }


});


</script>



</body>

</html>
