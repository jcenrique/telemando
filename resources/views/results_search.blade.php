<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">



    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">



    <style>
        body {
            font-family: 'Nunito', sans-serif;
        }
    </style>

    @livewireStyles


    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="js/script.js"></script>



    @vite('resources/css/app.css')





    @foreach (Dashboard::getResource('scripts') as $scripts)
        <script src="{{ $scripts }}" defer type="text/javascript"></script>
    @endforeach


</head>

<body class="{{ \Orchid\Support\Names::getPageNameClass() }}" data-controller="pull-to-refresh">

    <div class="container-fluid" data-controller="@yield('controller')" @yield('controller-data')>

        <nav class="bg-gray-800">
            <div class="flex justify-between">
                <div class="flex  pl-4 justify-between items-center">
                    <div class="pr-4">
                        <x-orchid-icon path="train" class="text-cyan-200 text-2xl" />

                    </div>
                    <div class="text-4xl text-gray-200 font-mono">
                        <h1>Sof<strong class="italic">Tren</strong></h1>
                    </div>
                </div>

                <div class="relative flex flex-1 h-16 mx-16 justify-between items-center ">
                    {{-- <div class="absolute inset-y-0 left-0 flex items-center "> --}}

                    <div class=" flex h-16 items-center  pr-4">

                        <a href="/" title="Inicio"
                            class="cursor-pointer hover:bg-gray-200 text-gray-900 text-sm  p-2 bg-gray-50 rounded-lg">
                            <x-orchid-icon path="home" class="text-gray-500" />
                        </a>
                    </div>
                    

                    @include('partials.search-form')
                    
                </div>


                <div class=" flex h-16 items-center justify-end pr-4">
                    <a href="/admin/" title="Administración"
                        class="cursor-pointer hover:bg-gray-200 text-gray-900 text-sm  p-2 bg-gray-50 rounded-lg">
                        <x-orchid-icon path="gear" class="text-gray-500" />
                    </a>
                </div>
            </div>

        </nav>
        <div class="p-4">
            <div class="text-4xl text-center bold text-gray-600">ALARMAS ENCONTRADAS</div>
            @include('partials.table-alarmas', ['alarmas' => $alarmas])
            
        </div>


        @livewireScripts
        @stack('scripts')
    </div>
</body>

</html>
