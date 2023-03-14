<?php

namespace App\Exports;

use App\Models\Relacion;
use App\Models\Suministro;
use App\Models\Tarifa;
use App\Models\Tension;
use App\Models\Tipo;
use App\Models\Zona;
use Illuminate\Support\Collection;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithDefaultStyles;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SuministrosExport implements FromCollection, WithHeadings, WithColumnFormatting, ShouldAutoSize, WithStyles, WithDefaultStyles, WithTitle
{



    private $suministros;
    /**
     * @return \Illuminate\Support\Collection
    
     */
    public function __construct($suministros)
    {

        $this->suministros = $suministros;
    }
    public function collection()
    {

        $suministros_formateados = new Collection();

        foreach ($this->suministros as $key => $suministro) {
            $suministros_formateados->push([

                'direccion' => $suministro->direccion,
                'CUP' => $suministro->CUP,
                'poblacion' => $suministro->poblacion,
                'zona_id' => Zona::find($suministro->zona_id)->zona,
                'tarifa_id' => Tarifa::find($suministro->tarifa_id)->tarifa,
                'P1' => $suministro->P1,
                'P2' =>  $suministro->P2,
                'P3' =>  $suministro->P3,
                'P4' =>  $suministro->P4,
                'P5' =>  $suministro->P5,
                'P6' =>  $suministro->P6,

                'tension_id' => Tension::find($suministro->tension_id)->tension,
                'contrato'  =>  $suministro->contrato,
                'instalacion' =>  $suministro->instalacion,
                'num_contador' =>  $suministro->num_contador,
                'medida' => $suministro->medida,
                'relacion_id' => is_null(Relacion::find($suministro->relacion_id)) ? '' : Relacion::find($suministro->relacion_id)->relacion,
                'telegestion' => $suministro->telegestion == 0 ? "NO" : "SÍ",
                'icp' => $suministro->icp,
                'contador' => $suministro->contador,

                'comercializadora' => $suministro->comercializadora,
                'tipo_id' => is_null(Tipo::find($suministro->tipo_id)) ? '' : Tipo::find($suministro->tipo_id)->tipo,
                'observacion' => $suministro->observacion,
                'updated_at' =>  Date::dateTimeToExcel($suministro->updated_at),
            ]);
        }
        return $suministros_formateados;
    }

    public function headings(): array
    {

        return [
            'Dirección', 'CUP', 'Población',  'Zona',  'Tarifa',  'P1',  'P2', 'P3', 'P4',  'P5',  'P6',

            'Tensión', 'Contrato', 'Instalación', 'Num Contador',  'Medida', 'Relación', 'Telegestión', 'ICP', 'Contador', 'Comercializadora', 'Tipo suministro',   'Observación', 'Actualizado'



        ];
    }
    /**
     * @return array
     */
    // public function columnFormats(): array {
    //     return [
    //         'B' => NumberFormat::FORMAT_DATE_DDMMYYYY,
    //         'C' => NumberFormat::FORMAT_CURRENCY_EUR_SIMPLE,
    //     ];

    // }



    /**
     * @return array
     */
    public function columnFormats(): array
    {
        return [
            'X' => NumberFormat::FORMAT_DATE_DDMMYYYY,

        ];
    }

    /**
     *
     * @param Worksheet $sheet
     * @return mixed
     */
    public function styles(Worksheet $sheet)
    {

        $color = new Color;
        $color->setARGB(Color::COLOR_RED);
        $sheet->getStyle('A1:' . $sheet->getHighestColumn() . 1)->getFont()->setSize(13);
        $sheet->getStyle('A1:' . $sheet->getHighestColumn() . 1)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_DOUBLE);
        $sheet->getStyle('B2:B' . $sheet->getHighestRow())->getFont()->setColor($color);
        $sheet->getStyle('B2:B' . $sheet->getHighestRow())->getFont()->setBold(true);
        $sheet->getStyle(1)->getFont()->setBold(true);
        $sheet->setAutoFilter('A1:' . $sheet->getHighestColumn() . '1');
        $sheet->getStyle('A2:' . $sheet->getHighestColumn() . $sheet->getHighestRow())->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
        $sheet->getStyle('A2:' . $sheet->getHighestColumn() . $sheet->getHighestRow())->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A2:' . $sheet->getHighestColumn() . $sheet->getHighestRow())->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        for ($i = 2; $i <  $sheet->getHighestRow() + 1; $i++) {
            $sheet->getRowDimension($i)->setRowHeight(25);
        }
        foreach ($this->suministros as $key => $suministro) {
            if($suministro->trashed()){
                $sheet->getStyle($key+2)->getFont()->setStrikethrough(true);
            }
        }
    }
    /**
     * @param \PhpOffice\PhpSpreadsheet\Style\Style $defaultStyle
     * @return array
     */
    public function defaultStyles(\PhpOffice\PhpSpreadsheet\Style\Style $defaultStyle)
    {

        return $defaultStyle->getFont()->setName('Calibri');
    }
    /**
     * @return string
     */
    public function title(): string
    {

        return __('SUMINISTROS');
    }
}
