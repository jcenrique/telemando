<div>
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
    <div >
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

                <div
                    class="relative grid grid-cols-1  sm:grid-cols-2 gap-4  lg:grid-cols-4 items-center mx-2 py-3 flex-wrap">
                    {{-- <div class="absolute inset-y-0 left-0 flex items-center "> --}}

                    <div class="flex items-baseline mx-4">
                        <label class="text-gray-400 mr-2">{{ __('Zona') }}:</label>
                        <select
                            wire:model="zona_id"class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full  p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option value="0">{{ __('Seleccione una opción') }}</option>
                            @foreach ($zonas as $value)
                                <option value="{{ $value->id }}">{{ $value->zona }}</option>
                            @endforeach



                        </select>

                    </div>






                    <div class="flex items-baseline mr-4">
                        <label class="text-gray-400 mr-2">{{ __('Ubicación') }}:</label>
                        <select wire:model="ubicacion_id"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full  p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option value="0">{{ __('Seleccione una opción') }}</option>
                            @if ($ubicaciones != null)
                                @foreach ($ubicaciones as $value)
                                    <option value="{{ $value->id }}">{{ $value->ubicacion }}</option>
                                @endforeach
                            @endif
                        </select>


                    </div>



                    <div class="flex items-baseline mx-4">
                        <label class="text-gray-400 mr-2">{{ __('Equipamiento') }}:</label>
                        <select wire:model="equipo_id"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full  p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option value="0">{{ __('Seleccione una opción') }}</option>
                            @if ($equipos != null)
                                @foreach ($equipos as $value)
                                    <option value="{{ $value->id }}">{{ $value->equipo }}</option>
                                @endforeach
                            @endif
                        </select>


                    </div>
                    <div class="w-auto justify-self-stretch">
                        @include('partials.search-form')
                    </div>



                    {{-- </div> --}}
                </div>



                <div class=" flex h-16 items-center justify-end pr-4">

                    <a href="/"
                        class="cursor-pointer hover:bg-gray-200 text-gray-900 text-sm  p-2 mr-2 bg-gray-50 rounded-lg">
                        <x-orchid-icon path="home" class="text-gray-500" />
                    </a>
                    <a href="/admin/"
                        class="cursor-pointer hover:bg-gray-200 text-gray-900 text-sm  p-2 bg-gray-50 rounded-lg">
                        <x-orchid-icon path="gear" class="text-gray-500" />
                    </a>
                </div>
            </div>

        </nav>
    </div>
    <div>

        @if (!empty($array_elementos))



            <div class="flex h-screen bg-gray-50">
                <!--actual component start-->
                <div x-data="setup({{ $array_elementos }})" class="w-full">
                    <ul class="flex justify-center flex-wrap items-center my-4 ">
                        <template x-for="(tab, index) in tabs" :key="index">
                            <li class="text-xs small text-center h-12 cursor-pointer py-2 px-8 border-b-8"
                                x-on:click="$wire.resetTabs()"
                                :class="activeTab === index ? 'text-green-700 border-gray-500 font-bold' : ' text-green-500 '"
                                @click="activeTab = index" x-on:click="resetPages()" x-text="tab"></li>
                        </template>
                    </ul>
                    <div class="text-3xl text-center font-bold text-gray-600">{{__('ALARMAS')}}</div>
                    <div class=" h-auto  m-5  ">
                        @foreach ($elementos as $key => $elemento)
                            @php
                                $alarmas = \App\Models\Alarma::where('elemento_id', $elemento->id)->paginate();
                            @endphp
                            <div x-show="activeTab==={{ $key }}">@include('partials.table-alarmaslivewire', [$elemento, $alarmas])</div>
                        @endforeach

                    </div>
                </div>


                <!--actual component end-->
            </div>





        @endif

    </div>


    <script>
        window.addEventListener('clickElemento', event => {
            alert('Name updated to: ' + event.detail.newName);
        })

        function setup(array_elementos) {




            return {
                activeTab: 0,
                tabs: array_elementos
            };
        };
    </script>






</div>



{{-- --}}
