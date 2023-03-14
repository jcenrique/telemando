<!DOCTYPE html>
<html lang="{{ is_null(Illuminate\Support\Facades\Auth::user())?app()->getLocale(): Illuminate\Support\Facades\Auth::user()->lang }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    
       

        <title>Circulación y estaciones</title>

    



 @vite('resources/js/app.js')



    @foreach(Dashboard::getResource('scripts') as $scripts)
    <script src="{{  $scripts }}" defer type="text/javascript"></script>
@endforeach


    </head>
    <body class="">

        <div class="container-fluid m-lg-1" data-controller="@yield('controller')" @yield('controller-data')>
       
        @livewire('show-alarmas')
        

       
        @livewireScripts
       
        </div>
        {{-- @include('partials.footer') --}}
    </body>
</html>

