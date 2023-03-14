@isset($repostajes_importados)
    

<div class="bg-white rounded shadow-sm mb-3 p-4" data-controller="table">

    <div class="table-responsive">
        <table @class([
            'paleBlueRows',
            'table',
            'table-compact' => true,
            'table-striped' => false,
            'table-bordered' => true,
            'table-hover' => true,
        ])>
            <thead>
                <tr>
                    <th>{{ __('Elemento') }}</th>
                   
                </tr>
            </thead>
            <tbody>

                @foreach ($repostajes_importados as $repostaje)
                    <tr style="height: 20px;">
                        <td>{{ $repostaje->matricula }} </td>
                        
                    </tr>
                @endforeach

            </tbody>
        </table>
    </div>

    @if ($repostajes_importados->count() == 0)
        <div class="text-center py-5 w-100">

            <x-orchid-icon path="table" class="block m-b" />
            {!! __('No hay registros en esta vista.') !!}
        </div>
    @else
        @include('platform::layouts.pagination', [
            'paginator' => $repostajes_importados,
        ])
    @endif
</div>
@endisset