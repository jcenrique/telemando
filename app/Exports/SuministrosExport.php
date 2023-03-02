<?php

namespace App\Exports;

use App\Models\Relacion;
use App\Models\Suministro;
use App\Models\Tarifa;
use App\Models\Tension;
use App\Models\Tipo;
use App\Models\Zona;
use Maatwebsite\Excel\Concerns\Exportable;
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

class SuministrosExport implements FromQuery, WithHeadings, WithMapping,WithColumnFormatting,ShouldAutoSize,WithStyles,WithDefaultStyles, WithTitle
{

    use Exportable;
    /**
     * @return \Illuminate\Support\Collection
     */
    public function query()
    {
        return Suministro::query();
    }

    public function map($suministro): array
    {
        return [
            $suministro->position,
            Zona::find($suministro->zona_id)->zona,
            $suministro->poblacion,
            $suministro->direccion,
            $suministro->instalacion,
            $suministro->tipo_id != null ? Tipo::find($suministro->tipo_id)->tipo : '',
            $suministro->CUP,
            $suministro->contrato,
            $suministro->num_contador,
            $suministro->tarifa_id != null ? Tarifa::find($suministro->tarifa_id)->tarifa : '',
            $suministro->P1,
            $suministro->P2,
            $suministro->P3,
            $suministro->P4,
            $suministro->P5,
            $suministro->P6,
            $suministro->tension_id != null ? Tension::find($suministro->tension_id)->tension : '',
            $suministro->medida,
            $suministro->relacion_id != null ? Relacion::find($suministro->relacion_id)->relacion : '',
            $suministro->icp,
            $suministro->contador,
            $suministro->observacion,
            Date::dateTimeToExcel($suministro->updated_at),

        ];
    }

    public function headings(): array
    {

        return [
            'id', 'Zona',  'Población', 'Dirección', 'Instalación', 'Tipo suministro',  'CUP', 'Contrato','Num Contador', 'Tarifa', 'P1',  'P2', 'P3', 'P4',  'P5',  'P6', 
            'Tensión', 'Medida', 'Relación', 'ICP', 'Contador', 'Observación', 'Actualizado'

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
	public function columnFormats(): array {
        return [
            'W' => NumberFormat::FORMAT_DATE_DDMMYYYY,
          
        ];
	}
	
	/**
	 *
	 * @param Worksheet $sheet
	 * @return mixed
	 */
	public function styles(Worksheet $sheet) {

        $color = new Color;
        $color->setARGB(Color::COLOR_RED);
        $sheet->getStyle('A1:' . $sheet->getHighestColumn() . 1)->getFont()->setSize(13);
        $sheet->getStyle('A1:' . $sheet->getHighestColumn() . 1)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_DOUBLE);
        $sheet->getStyle('G2:G' . $sheet->getHighestRow() )->getFont()->setColor($color);
        $sheet->getStyle('G2:G' . $sheet->getHighestRow() )->getFont()->setBold(true);
        $sheet->getStyle(1)->getFont()->setBold(true);
        $sheet->setAutoFilter('A1:' . $sheet->getHighestColumn() . '1');
        $sheet->getStyle('A2:' . $sheet->getHighestColumn() . $sheet->getHighestRow())->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
        
   	}
	/**
	 * @param \PhpOffice\PhpSpreadsheet\Style\Style $defaultStyle
	 * @return array
	 */
	public function defaultStyles(\PhpOffice\PhpSpreadsheet\Style\Style $defaultStyle) {
        
        return $defaultStyle->getFont()->setName('Calibri');
	}
	/**
	 * @return string
	 */
	public function title(): string {

        return __('SUMINISTROS');
	}
}
