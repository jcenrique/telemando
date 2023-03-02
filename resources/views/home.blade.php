<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" data-controller="html-load" dir="{{ \Orchid\Support\Locale::currentDir() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=no">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <title>Circulación y estaciones</title>





    @vite('resources/js/app.js')

</head>

<body class=" bg-gray-800">

    <div class="grid grid-cols-1  sm:grid-cols-2  md:grid-cols-4  gap-4   content-center justify-items-center w-screen  h-screen px-4">

        <!-- 1 -->
        <div
            class="max-w-sm flex-row  justify-items-stretch bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
            <a class="" href="/alarmas">
                <img class="object-cover h-40 w-96  rounded-t-lg" src="{{ asset('/img/alarmas.jpg') }}"
                    alt="" />
            </a>
            <div class="flex-col content-end  p-5 ">
                <a href="/alarmas">
                    <h5 class="mb-2 h-16 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                        {{ __('Alarmas Telemando Energía') }}</h5>
                </a>
                <p class="h-32 mb-3 text-justify backdrop:font-normal text-gray-700 dark:text-gray-400">
                    {{ __('Todas las alarmas del Telemando de Energía organizadas para su consulta.
                                        Podrás buscar facilmente una alarma con las herremientas de busqueda.') }}
                </p>
                <a href="/alarmas"
                    class="self-end inline-flex items-center justify-end  px-3 py-2 h-16 w-full text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    {{ __('Ver alarmas') }}
                    <svg aria-hidden="true" class="w-4 h-4 ml-2 -mr-1" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z"
                            clip-rule="evenodd"></path>
                    </svg>
                </a>
            </div>
        </div>

        <!-- 2 -->
        <div
            class="max-w-sm flex-row justify-items-stretch bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 ">
            <a href="/suministros">
                <img class="object-cover h-40 w-96  rounded-t-lg" src="{{ asset('/img/suministros.jpg') }}"
                    alt="" />
            </a>
            <div class="flex-col content-end p-5">
                <a href="suministros">
                    <h5 class="h-16 mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                        {{ __('Suministros de baja tesión ETS-RFV') }}</h5>
                </a>
                <p class="h-32 mb-3 text-justify font-normal text-gray-700 dark:text-gray-400">
                    {{ __('Listado de todos los suministros de baja tensión de ETS-RFV. Podras consultar los datos relativos a cualquier punto de suministro de la Red de ETS-RFV.') }}
                </p>
                <a href="/suministros"
                    class="inline-flex items-center justify-end  px-3 py-2 h-16 w-full text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    {{ __('Ver suministros') }}
                    <svg aria-hidden="true" class="w-4 h-4 ml-2 -mr-1" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z"
                            clip-rule="evenodd"></path>
                    </svg>
                </a>
            </div>
        </div>

        <!-- 3 -->

        <div
            class="max-w-sm flex-row justify-items-stretch bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 ">
            <a href="admin/vehiculos">
                <img class="object-cover h-40 w-96  rounded-t-lg" src="{{ asset('/img/flota.jpg') }}" alt="" />
            </a>
            <div class="flex-col content-end    p-5">
                <a href="/admin/vehiculos">
                    <h5 class="mb-2 h-16 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                        {{ __('Flota de vehículos ETS-RFV') }}</h5>
                </a>
                <p class="mb-3 h-32 text-justify font-normal text-gray-700 dark:text-gray-400">
                    {{ __('Listado los vehiculos pertenecientes a la flota de ETS-RFV.') }}</p>
                <a href="admin/vehiculos"
                    class=" inline-flex items-center justify-end px-3 py-2 h-16 w-full text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    {{ __('Ver Flota') }}
                    <svg aria-hidden="true" class="w-4 h-4 ml-2 -mr-1" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z"
                            clip-rule="evenodd"></path>
                    </svg>
                </a>
            </div>
        </div>

        <!-- 4 -->

        <div
            class="max-w-sm flex-row justify-items-stretch bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 ">
            <a href="admin/vehiculos">
                <img class="object-cover h-40 w-96  rounded-t-lg" src="{{ asset('/img/inventarios.jpg') }}"
                    alt="" />
            </a>
            <div class="flex-col content-end    p-5">
                <a href="/admin/vehiculos">
                    <h5 class="mb-2 h-16 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                        {{ __('Inventario estaciones ETS-RFV') }}</h5>
                </a>
                <p class="mb-3 h-32 text-justify font-normal text-gray-700 dark:text-gray-400">
                    {{ __('En el se enumeran y catalogan todos los dispositivos que componen las instalaciones de ETS-RVF, su localización y caracteristicas.') }}
                </p>
                <a href="admin/vehiculos"
                    class=" inline-flex items-center justify-end px-3 py-2 h-16 w-full text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    {{ __('Ver Inventario') }}
                    <svg aria-hidden="true" class="w-4 h-4 ml-2 -mr-1" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z"
                            clip-rule="evenodd"></path>
                    </svg>
                </a>
            </div>
        </div>










    </div>


    {{-- @stack('scripts') --}}


</body>

</html>
