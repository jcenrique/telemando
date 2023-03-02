<div class="">
    @if ($alarmas != null && $alarmas->count() != 0)
        @foreach ($alarmas as $key => $value)
            <div class="grid grid-cols-3 font-mono  rounded-lg  border-gray-200 border border-x border-t  mb-1">

                <div class="flex justify-between  col-span-3  border text-green-700  px-2 py-1">
                    <div class="cursor-pointer flex-1 self-center " onclick="desplegar('{{ $value->id }}')">{{ $value->alarma }}</div>
                    <div>
                        <button onclick="desplegar('{{ $value->id }}')"
                            class="flex items-center px-1 py-1 border rounded bg-gray-600 border-gray-400">

                            <div class="elementos m-1 hidden" id="up{{ $value->id }}">
                                <x-orchid-icon path="arrow-up" class="text-gray-200 font-bold  hover:text-red-400 " />
                            </div>
                            <div class="elementos m-1 " id="down{{ $value->id }}">
                                <x-orchid-icon path="arrow-down" class="text-gray-200 font-bold  hover:text-red-400" />
                            </div>


                        </button>
                    </div>



                </div>


                <div id="accion{{ $value->id }}" class="elementos col-span-3 bg-gray-100  bg-clip-padding hidden">
                    <div class="text-left grid grid-cols-8 pl-6 gap-x-4 justify-items-stretch auto-cols-min ">
                        <div class="font-bold text-gray-600 col-span-3">{{ __('Consecuencias') }}</div>
                        <div class="font-bold text-gray-600 col-span-3">{{ __('Actuación') }}</div>
                        <div class="max-w-md font-bold text-gray-600">{{ __('Origen') }}</div>
                        <div class="text-gray-500 col-span-3">{{ $value->consecuencia }}</div>
                        <div  class="text-gray-500 col-span-3">{{ $value->actuacion }}</div>
                        <div class="max-w-md text-gray-500">{{ $value->origen }}</div>
                    </div>
                </div>

            </div>
        @endforeach

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4 mb-8">
            {{ $alarmas->links('vendor.livewire.tailwind') }}
        </div>
    @else
        <div class="text-gray-500 text-center text-3xl">{{ __('No hay alarmas disponibles') }}</div>
    @endif



</div>
