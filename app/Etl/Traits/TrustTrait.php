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

    /**
     * @param $trustRepository
     * @param $temporalTable
     * @param $tableTrust
     * @param $variables
     * @return array
     */
    public function incomingCalculation($trustRepository,$temporalTable,$tableTrust,$variables)
    {
        $trustActuality = [];
        $values = $this->consultValues($temporalTable,$this->generateSelect($variables));

        foreach ($values as $value){

            $actualTrust = (array)DB::connection('data_warehouse')->table($tableTrust)->where('estacion_sk','=',$value->estacion_sk)->where('fecha_sk','=',$value->fecha_sk)->first();

            if (!$actualTrust){
                $trust = $this->createModel($trustRepository,$value);
            }else{
                $trust = $this->updateModel($trustRepository,$actualTrust,$value);
            }
            array_push($trustActuality,$trust);
        }
        return $trustActuality;
    }

    /**
     * @param $temporalTable
     * @param $countSelect
     * @return mixed
     */
    private function consultValues($temporalTable, $countSelect)
    {

        $values = DB::connection('temporary_work')
                        ->table($temporalTable)
                        ->select(DB::raw('CAST(estacion_sk AS integer),CAST(fecha_sk AS integer),'.$countSelect))
                        ->groupby('estacion_sk','fecha_sk')
                        ->orderby(DB::raw("estacion_sk,fecha_sk"),'asc')
                        ->get();
        //return (array)$values[0];
        return $values;

    }


    /**
     * @param $trustRepository
     * @param $actualTrust
     * @param $value
     * @return array
     */
    private function updateModel($trustRepository, $actualTrust, $value)
    {
        $trustModel = ($trustRepository)::createModel()->fill($actualTrust);
        foreach ($value as $key => $val){$trustModel->$key += $val;}
        ($trustRepository)::find($trustModel->id)->fill($trustModel->toArray())->save();

        return ['estacion_sk' => $value->estacion_sk,'fecha_sk' => $value->fecha_sk];
    }


    /**
     * @param $trustRepository
     * @param $value
     * @return array
     */
    private function createModel($trustRepository, $value)
    {
        $trustModel = ($trustRepository)::createModel();
        foreach ($value as $key => $val){$trustModel->$key = $val;}
        $trustModel->save();

        return ['estacion_sk' => $value->estacion_sk,'fecha_sk' => $value->fecha_sk];
    }


    /**
     * @param $variables
     * @return string
     */
    private function generateSelect($variables)
    {
        $text = '';
        foreach ($variables as $variable){$text .= 'COUNT(case '.$variable->name_locale.' when \'-\' then null else 1 end) AS '.$this->incoming.''. $variable->name_locale . ',';}
        $text[strlen($text)-1] = ' ';

        return $text;
    }

}