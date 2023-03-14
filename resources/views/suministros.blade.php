<!DOCTYPE html>
<html lang="{{  is_null(Illuminate\Support\Facades\Auth::user())?app()->getLocale(): Illuminate\Support\Facades\Auth::user()->lang}}" data-controller="html-load" dir="{{ \Orchid\Support\Locale::currentDir() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=no">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <title>Circulación y estaciones</title>

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
   

    <script src="//unpkg.com/alpinejs" defer></script>
    <script defer src="js/script.js"></script>

    @vite('resources/js/app.js')
</head>

<body class=" bg-gray-100">
<div>
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

            <div class="relative flex flex-1  justify-end  items-start mx-2 flex-wrap">
                <div class=" flex h-16 items-center justify-start pr-4">
                    <a href="/"
                        class="cursor-pointer hover:bg-gray-200 text-gray-900 text-sm  p-2 bg-gray-50 rounded-lg">
                        <x-orchid-icon path="home" class="text-gray-500" />
                    </a>
                </div>

            </div>
            <div>

                <div class=" flex h-16 items-center  pr-4">
                    <a href="/admin/"
                        class="cursor-pointer hover:bg-gray-200 text-gray-900 text-sm  p-2 bg-gray-50 rounded-lg">
                        <x-orchid-icon path="gear" class="text-gray-500" />
                    </a>
                </div>
            </div>

    </nav>
</div>

    <div class="m-4 p-2">
        <livewire:suministros.suministros-table />
    </div>


    @livewireScripts


    </div>




    {{-- @stack('scripts') --}}


</body>

</html>
