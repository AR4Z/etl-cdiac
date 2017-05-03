<?php

namespace app\Etl\Traits;


use DB;

trait TrustTrait
{
    public $incoming = 'total_incoming_';

    public $goods = 'total_good_';

    public $support = 'support_';

    public $trust = 'trust_';

    public $table = 'trust_';


    /**
     * @param $temporalTable
     * @param $tableTrust
     * @param $variables
     */
    public function incomingCalculation($temporalTable,$tableTrust,$variables)
    {
        $values = DB::connection('temporary_work')
                    ->table($temporalTable)
                    ->select(DB::raw('CAST(estacion_sk AS integer),CAST(fecha_sk AS integer)'))
                    ->groupby('estacion_sk','fecha_sk')
                    ->orderby('estacion_sk','fecha_sk')
                    ->get();



        foreach ($values as $value){

            $count = DB::connection('data_warehouse')->table($tableTrust)->select(DB::raw('count(*)'))->where('estacion_sk','=',$value->estacion_sk)->where('estacion_sk','=',$value->fecha_sk)->get();

            if ($count[0]->count){
                DB::connection('data_warehouse')->table($tableTrust)->insert(['estacion_sk'   => $value->estacion_sk,'fecha_sk' => $value->fecha_sk]);
            }

        }

        foreach ($variables as $variable)
        {

        }

        dd($temporalTable,$variables);

    }

}