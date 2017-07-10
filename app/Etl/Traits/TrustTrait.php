<?php

namespace app\Etl\Traits;

use DB;

trait TrustTrait
{
    private $incoming = '_total_records';

    private $goods = '_correct_records';

    private $support = '_support';

    private $trust = '_trust';

    /**
     * @param $trustRepository
     * @param $temporalTable
     * @param $tableTrust
     * @param $variables
     * @return array
     */
    public function incomingCalculation($trustRepository,$temporalTable,$tableTrust,$variables)
    {
        $values = $this->consultValues($temporalTable,$this->generateSelect($variables));
        $trustActuality = [];
        foreach ($values as $value){

            $actualTrust = (array)DB::connection('data_warehouse')->table($tableTrust)->where('station_sk','=',$value->station_sk)->where('date_sk','=',$value->station_sk)->first();

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
     * @param $trustRepository
     * @param $temporalTable
     * @param $tableTrust
     * @param $variable
     * @return array
     */
    public function insertGoods($trustRepository, $temporalTable, $tableTrust, $variable)
    {
        $values = DB::connection('temporary_work')
                    ->table($temporalTable)
                    ->select(DB::raw("CAST(station_sk AS integer),CAST(date_sk AS integer),COUNT($variable) AS ".$variable.$this->goods))
                    ->groupby('station_sk','date_sk')
                    ->orderby(DB::raw("station_sk,date_sk"),'asc')
                    ->get();

        foreach ($values as $value ){
            $actualTrust = (array)DB::connection('data_warehouse')->table($tableTrust)->where('station_sk','=',$value->station_sk)->where('date_sk','=',$value->date_sk)->first();
            if ($actualTrust){$this->updateModel($trustRepository, $actualTrust, $value,'insertGoods');}
        }

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
                        ->select(DB::raw('CAST(station_sk AS integer),CAST(date_sk AS integer),'.$countSelect))
                        ->groupby('station_sk','date_sk')
                        ->orderby(DB::raw("station_sk,date_sk"),'asc')
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
    private function updateModel($trustRepository, $actualTrust, $value,$ban = null)
    {
        $trustModel = ($trustRepository)::createModel()->fill($actualTrust);
        foreach ($value as $key => $val){if (!($key == 'station_sk' || $key == 'date_sk')){($trustModel->$key += $val);}}
        ($trustRepository)::find($trustModel->id)->fill($trustModel->toArray())->save();

        return ['station_sk' => $value->station_sk,'date_sk' => $value->date_sk];
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

        return ['station_sk' => $value->station_sk,'date_sk' => $value->date_sk];
    }


    /**
     * @param $variables
     * @return string
     */
    private function generateSelect($variables)
    {
        $text = '';
        foreach ($variables as $variable){$text .= 'COUNT(case '.$variable->local_name.' when \'-\' then null else 1 end) AS '. $variable->local_name .''.$this->incoming.',';}
        $text[strlen($text)-1] = ' ';

        return $text;
    }

}