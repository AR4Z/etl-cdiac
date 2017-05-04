<?php

namespace app\Etl\Traits;


use DB;

trait TrustTrait
{
    private $incoming = 'total_incoming_';

    private $goods = 'total_good_';

    private $support = 'support_';

    private $trust = 'trust_';

    private $table = 'trust_';

    private $trustColumns = ['estacion_sk','fecha_sk'];


    /**
     * @param $temporalTable
     * @param $tableTrust
     * @param $variables
     */
    public function incomingCalculation($temporalTable,$tableTrust,$variables)
    {

        $countSelect = $this->generateSelect($variables);

        $values = DB::connection('temporary_work')
                    ->table($temporalTable)
                    ->select(DB::raw('CAST(estacion_sk AS integer),CAST(fecha_sk AS integer),'.$countSelect))
                    ->groupby('estacion_sk','fecha_sk')
                    ->orderby(DB::raw("estacion_sk,fecha_sk"),'asc')
                    ->get();


        foreach ($values as $value){

            $actualTrust = DB::connection('data_warehouse')->table($tableTrust)->where('estacion_sk','=',$value->estacion_sk)->where('fecha_sk','=',$value->fecha_sk)->first();

            //dd($actualTrust,$value->fecha_sk);
            if (!$actualTrust){
                dd('insert');
                DB::connection('data_warehouse')->table($tableTrust)->insert(['estacion_sk'   => $value->estacion_sk,'fecha_sk' => $value->fecha_sk]);
            }else{
                dd('update');
            }

        }

        dd($temporalTable,$variables);

    }


    private function generateSelect($variables)
    {
        $text = '';
        foreach ($variables as $variable)
        {
            array_push($this->trustColumns,$this->incoming.''. $variable->name_locale);
            $text .= 'COUNT(case '.$variable->name_locale.' when \'-\' then null else 1 end) AS '.$this->incoming.''. $variable->name_locale . ',';
        }

        $text[strlen($text)-1] = ' ';
        dd($this->trustColumns);
        return $text;
    }

}