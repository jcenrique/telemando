<div class="">
    @if ($alarmas!= null && $alarmas->count() != 0  )
        @foreach ($alarmas as $key => $value)
            
            <div class="grid grid-cols-3 font-mono  shadow-md border-gray-200 border  mb-1">

                <div class="flex justify-between col-span-3   text-blue-500  px-2 py-1">
                    <div class="cursor-pointer"  onclick="desplegar('{{$value->id }}')">{{ $value->alarma }}</div>
                    <div> <button onclick="desplegar('{{$value->id }}')"
                      class="flex items-center px-1 py-1 border rounded bg-gray-600 border-gray-400">
                     
                      <div class="m-1 hidden" id="up{{$value->id }}">
                        <x-orchid-icon path="arrow-up" class="text-gray-200 font-bold  hover:text-red-400 "/>
                      </div>
                      <div class="m-1 " id="down{{$value->id }}">
                        <x-orchid-icon  path="arrow-down" class="text-gray-200 font-bold  hover:text-red-400" />
                      </div>

                  </button></div>
                  
                  
                 
                </div>


                <div id="accion{{$value->id }}" class="col-span-3  hidden">
                    <div class="text-left grid grid-cols-3 pl-6 gap-x-4 justify-items-stretch auto-cols-min ">
                        <div class="font-bold text-gray-600">{{ __('Consecuencias') }}</div>
                        <div class="font-bold text-gray-600">{{ __('Actuación') }}</div>
                        <div class="max-w-md font-bold text-gray-600">{{ __('Origen') }}</div>
                        <div>{{ $value->consecuencia }}</div>
                        <div>{{ $value->actuacion }}</div>
                        <div class="max-w-md">{{ $value->origen }}</div>
                    </div>
                </div>

            </div>
        @endforeach
          
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4 mb-8">
           {{$alarmas->links('vendor.livewire.tailwind')}} 
      </div>
    @else
        <div class="text-gray-500 text-center text-3xl">{{ __('No hay alarmas disponibles') }}</div>
    @endif



</div>
