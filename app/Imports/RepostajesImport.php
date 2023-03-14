<?php

namespace App\Imports;

use App\Models\Kilometraje;
use App\Models\Repostaje;
use App\Models\User;
use App\Models\Vehiculo;
use App\Notifications\TareasRealizadas;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

use function PHPUnit\Framework\isNull;

class RepostajesImport implements ToCollection, WithHeadingRow
{

    public $data;
    public  $fecha_importacion;

    public function __construct($fecha_importacion)
    {
        $this->fecha_importacion = $fecha_importacion;
    }
    public function collection(Collection $rows)
    {


        $this->data = $rows;

        $enviar_notificacion = false;
        foreach ($rows as $key => $row) {
            
            $digitos = substr($row['matricula'], 0, 4);
            $letras = substr($row['matricula'], -3);

            $vehiculo = Vehiculo::where('matricula', $digitos . ' ' . $letras)->first();
            $matricula_noencontrada = is_null($vehiculo);





            $ano = substr($row['fec_operac'], 0, 4);
            $mes = substr($row['fec_operac'], 4, 2);
            $dia = substr($row['fec_operac'], 6, 2);
            $hora = substr($row['hor_operac'], 0, 2);
            $minuto = substr($row['hor_operac'], 2, 2);

            $fecha = Carbon::create($ano, $mes, $dia, $hora, $minuto, 0);


            $vehiculo_repostaje =  $matricula_noencontrada ? null : Repostaje::where('vehiculo_id', $vehiculo->id)->where('fecha', $fecha->format('Y-m-d'))->first();
            $matricula_fecha_duplicada = !is_null($vehiculo_repostaje);

            if ($matricula_noencontrada || $matricula_fecha_duplicada || $row['des_produ']=="BLUE+GRANE") {
                //GUARDAR ERROR DE MATRICULAS DESCARTADAS
                if ($matricula_fecha_duplicada) {
                    Log::channel('db')->info('Matricula y fechas duplicadas:' . $row['matricula'] . ', en la fila ' . $key+2);
                } elseif($matricula_fecha_duplicada) {
                    Log::channel('db')->info('Matricula no encontrada: ' . $row['matricula'] . ', en la fila ' . $key+2);
                }

                $enviar_notificacion = true;
                // log($digitos, $letras, $key);
            } else {
                //si la matricula se reconoce guardar en DB
                $matricula_id = $vehiculo->id;
                $kilometros = intval($row['kilometros']);
                Repostaje::create([
                    'vehiculo_id' =>  $matricula_id, //
                    'fecha' =>    $fecha->format('Y-m-d'),
                    'poblacion' => $row['pob_establ'],
                    'establecimiento' => $row['nom_establ'],
                    'kilometraje' => $kilometros,
                    'combustible' => $row['des_produ'],
                    'litros' => $row['num_litros'],
                    'importe' => $row['importe'],
                    'fecha_importacion' => $this->fecha_importacion,

                ]);

                //guardar kilometraje
                if ($kilometros > 0) {
                    $max_kilometros = Kilometraje::where('vehiculo_id', $matricula_id)->get()->max('kilometraje');
                    $kilometraje =  Kilometraje::where('vehiculo_id', $matricula_id)->get()->max('fecha');
                  //  dd($kilometraje);
                    $ultima_fecha_registrada =  is_null($kilometraje) ?  Carbon::parse('2000-10-28'): Carbon::createFromFormat('Y-m-d',  $kilometraje);
                    $fecha_introducida = Carbon::createFromFormat('Y-m-d',  $fecha->format('Y-m-d'));


                    //dd($ultima_fecha_registrada , $fecha_introducida);
                    if (($max_kilometros > intval( $row['kilometros'])) || ($ultima_fecha_registrada->gt($fecha_introducida))) {
                        //descartar datos si los kilometros o la fecha son inferiores a la ultima ocasion
                        //registrar un mensaje con los errores

                        if ($max_kilometros >  intval( $row['kilometros'])) {

                            Log::channel('db')->info('Kilometros inferiores al ultimo registro:' . $row['matricula'] . ', en la fila ' . $key+2);
                        } else {

                            Log::channel('db')->info('Fecha inferior al ultimo registro:' . $row['matricula'] . ', en la fila ' . $key+2);
                        }
                    } else {
                        //guardar los validos
                        Kilometraje::create([
                            'kilometraje' => $row['kilometros'],
                            'vehiculo_id' =>$matricula_id,
                            'fecha' =>  $fecha->format('Y-m-d')
                        ]);
                   
                    }
                }
            }
        }

        if ($enviar_notificacion) {

            $users = User::all();
            // Notification::send($users, new TareasRealizadas);
        }
    }
}
