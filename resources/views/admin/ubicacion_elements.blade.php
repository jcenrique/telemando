<style>
    table.paleBlueRows {
        font-family: "Courier New", Courier, monospace;
        border: 1px solid #B6B6B6;
        background-color: #EEEEEE;


        text-align: center;
        border-collapse: collapse;
    }

    table.paleBlueRows td,
    table.paleBlueRows th {
        border: 1px solid #BBBBBB;
        padding: 2px 2px;
    }

    table.paleBlueRows tbody td {
        font-size: 13px;
    }

    table.paleBlueRows tr:nth-child(even) {
        background: #f5f3f3;
    }

    table.paleBlueRows thead {
        background: #353333;
        border-bottom: 0px solid #FFFFFF;
    }

    table.paleBlueRows thead th {
        font-size: 17px;
        font-weight: bold;
        color: #FFFFFF;
        text-align: center;
        border-left: 0px solid #FFFFFF;
    }

    table.paleBlueRows thead th:first-child {
        border-left: none;
    }

    table.paleBlueRows tfoot {
        font-size: 12px;
        font-weight: bold;
        color: #333333;
        background: #D0E4F5;
        border-top: 3px solid #444444;
    }

    table.paleBlueRows tfoot td {
        font-size: 14px;
    }
</style>
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

                @foreach ($elementos1 as $elemento)
                    <tr style="height: 20px;">
                        <td>{{ $elemento->elemento }} </td>
                        
                    </tr>
                @endforeach

            </tbody>
        </table>
    </div>

    @if ($elementos1->count() == 0)
        <div class="text-center py-5 w-100">

            <x-orchid-icon path="table" class="block m-b" />
            {!! __('No hay registros en esta vista.') !!}
        </div>
    @else
        @include('platform::layouts.pagination', [
            'paginator' => $elementos1,
        ])
    @endif
</div>
