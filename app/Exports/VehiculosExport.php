<?php

namespace App\Exports;

use App\Models\Departamento;
use App\Models\Detalletecnologia;
use App\Models\Marcavehiculo;
use App\Models\Modelovehiculo;
use App\Models\Tecnologia;
use App\Models\Tipovehiculo;
use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Style\Border;


class VehiculosExport implements FromCollection , WithTitle,WithColumnFormatting,WithHeadings,WithStyles,ShouldAutoSize 
{

    private $vehiculos;
    /**
     * @return \Illuminate\Support\Collection
     */

    public function __construct($vehiculos)
    {

        $this->vehiculos = $vehiculos;
    }
    public function collection()
    {

        $vehiculo_formateados = new Collection();
       
        foreach ($this->vehiculos as $key => $vehiculo) {
            $vehiculo_formateados->push([
                'id' => $vehiculo->id,
                'matricula' => $vehiculo->matricula,
                'tipovehiculo_id' => Tipovehiculo::find($vehiculo->tipovehiculo_id)->tipo,
                'marcavehiculo_id' => Marcavehiculo::find($vehiculo->marcavehiculo_id)->marca,
                'modelvehiculo_id' => Modelovehiculo::find($vehiculo->modelovehiculo_id)->modelo,
                'departamento_id' =>Departamento::find($vehiculo->departamento_id)->departamento,
                'responsable' => User::find(Departamento::find($vehiculo->departamento_id)->user_id)->name,
                'tecnologia_id' => Tecnologia::find($vehiculo->tecnologia_id)->tecnologia,
                'detalletecnologia_id' => Detalletecnologia::find($vehiculo->detalletecnologia_id)==null? '' : Detalletecnologia::find($vehiculo->detalletecnologia_id)->detalle,
                'kilometrajeinicial' =>  $vehiculo->kilometraje_inicial==null? 0:  $vehiculo->kilometraje_inicial,
                'fecha_matriculacion' =>$vehiculo->fecha_matriculacion ==null ? '' : $vehiculo->fecha_matriculacion,
                'regimen' => $vehiculo->regimen,
                'observacion' => $vehiculo->observacion ==null? '': $vehiculo->observacion,
                'fecha_baja' => $vehiculo->fecha_baja ==null ? '' : $vehiculo->fecha_baja,
            ]);
        }
        return $vehiculo_formateados;
    }

    public function title(): string {

        return __('VEHICULOS');
	}

    
	public function columnFormats(): array {
        return [
            'K' => NumberFormat::FORMAT_DATE_DDMMYYYY,
          
        ];
	}

    public function headings(): array
    {

        return [  'id' => 'id',
        'matricula' => __('Matrícula'),
        'tipovehiculo_id' => __('Tipo vehículo'),
        'marcavehiculo_id' => __('Marca'),
        'modelvehiculo_id' => __('Modelo'),
        'departamento_id' => __('Departamento'),
        'responsable' => __('Responsable'),
        'tecnologia_id' => __('Tecnología'),
        'detalletecnologia_id' => __('Sub-tecnología'),
        'kilometrajeinicial' => __('Kilometraje inicial'),
        'fecha_matriculacion' => __('Fecha matriculación'),
        'regimen' => __('Régimen'),
        'observacion' => __('Observación'),
        'fecha_baja' => __('Fecha baja'),

        ];
    }

    public function styles(Worksheet $sheet) 
    {

      
        $sheet->getStyle('A1:' . $sheet->getHighestColumn() . 1)->getFont()->setSize(13);
        $sheet->getStyle('A1:' . $sheet->getHighestColumn() . 1)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_DOUBLE);
      
        $sheet->getStyle(1)->getFont()->setBold(true);
        $sheet->setAutoFilter('A1:' . $sheet->getHighestColumn() . '1');
        $sheet->getStyle('A2:' . $sheet->getHighestColumn() . $sheet->getHighestRow())->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
        
   	}
}
