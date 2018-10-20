<?php

namespace app\Etl\Traits;

use DB;

trait TrustTrait
{
    /**
     * @var string
     */
    private $incoming = '_total_records';

    /**
     * @var string
     */
    private $goods = '_correct_records';

    /**
     * @var string
     */
    private $support = '_support';

    /**
     * @var string
     */
    private $trust = '_trust';

    /**
     * @param $variables
     * @return array
     */
    public function incomingCalculation($variables)
    {
        $values = $this->consultValues($this->generateSelect($variables));

        $trustActuality = [];
        foreach ($values as $value){

            $actualTrust = (array)DB::connection('data_warehouse')->table($this->etlConfig->tableTrust)->where('station_sk','=',$value->station_sk)->where('date_sk','=',$value->date_sk)->first();

            if (empty($actualTrust)){
                $trust = $this->createModel($this->etlConfig->trustRepository,$value);
            }else{
                $trust = $this->updateModel($this->etlConfig->trustRepository,$actualTrust,$value);
            }
            array_push($trustActuality,$trust);
        }
        return $trustActuality;
    }

    /**
     * @param $variable
     * @param $reliability_name
     * @return void
     */
    public function insertGoods($variable,$reliability_name)
    {
        $values = DB::connection('temporary_work')
                    ->table($this->etlConfig->tableSpaceWork)
                    ->select(DB::raw("CAST(station_sk AS integer),CAST(date_sk AS integer),COUNT($variable) AS ".$reliability_name.$this->goods))
                    ->groupby('station_sk','date_sk')
                    ->orderby(DB::raw("station_sk,date_sk"),'asc')
                    ->get();

        foreach ($values as $value ){
            $actualTrust = (array)DB::connection('data_warehouse')->table($this->etlConfig->tableTrust)->where('station_sk','=',$value->station_sk)->where('date_sk','=',$value->date_sk)->first();
            if ($actualTrust){$this->updateModel($this->etlConfig->trustRepository, $actualTrust, $value,'insertGoods');}
        }

    }

    /**
     * @param $columns
     * @param $variables
     * @param $measurementsPerDay
     */
    public function generateTrustAndSupport($columns, $variables, $measurementsPerDay)
    {
        foreach ($columns as $column){
            $value = $this->etlConfig->trustRepository->where('station_sk',$column['station_sk'])->where('date_sk' , $column['date_sk'])->first();
            foreach ($variables as $variable){
                if (!is_null($variable->reliability_name)){

                    $total_records = $value->{$variable->reliability_name.$this->incoming};
                    $correct_records = $value->{$variable->reliability_name.$this->goods};

                    $value->{$variable->reliability_name.$this->trust} = $this->calculateTrust($total_records,$correct_records);
                    $value->{$variable->reliability_name.$this->support} = $this->calculateSupport($correct_records,$measurementsPerDay);
                }
            }
            $value->update();
        }
    }


    /**
     * @param $total_records
     * @param $correct_records
     * @return float|int|null
     */
    private function calculateTrust($total_records, $correct_records)
    {
        $return = null;
        if (!is_null($total_records) and !is_null($correct_records)){
            $return = ($total_records != 0 and $correct_records != 0 ) ? round(($correct_records / $total_records),4) : 0;
        }
        return $return;
    }

    /**
     * @param $correct_records
     * @param $measurementsPerDay
     * @return float|int|null
     */
    private function calculateSupport($correct_records, $measurementsPerDay)
    {
        $return = null;
        if (!is_null($correct_records) and !is_null($measurementsPerDay)){
            $return = ($correct_records != 0 and $measurementsPerDay != 0 ) ?  round(($correct_records / $measurementsPerDay),4) : 0 ;
        }
        return $return;
    }


    /**
     * @param $countSelect
     * @return mixed
     */
    private function consultValues($countSelect)
    {
        $values = DB::connection('temporary_work')
                        ->table($this->etlConfig->tableSpaceWork)
                        ->select(DB::raw('CAST(station_sk AS integer),CAST(date_sk AS integer),'.$countSelect))
                        ->groupby('station_sk','date_sk')
                        ->orderby(DB::raw("station_sk,date_sk"),'asc')
                        ->get();
        //return (array)$values[0];
        return $values;
    }


    /**
     * @param $repository
     * @param $actualTrust
     * @param $value
     * @return array
     */
    private function updateModel($repository, $actualTrust, $value,$ban = null) : array
    {
        $trustModel = $repository->createModel()->fill($actualTrust);
        foreach ($value as $key => $val){if (!($key == 'station_sk' || $key == 'date_sk')){($trustModel->$key += $val);}}

        $repository->find($trustModel->id)->fill($trustModel->toArray())->save();

        return ['station_sk' => $value->station_sk,'date_sk' => $value->date_sk];
    }

    /**
    /**
     * @param $repository
     * @param $value
     * @return array
     */
    private function createModel($repository, $value) : array
    {
        $trustModel = $repository->createModel();
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
        foreach ($variables as $variable){
            if (!is_null($variable->reliability_name)){
                $text .= 'COUNT(case '.$variable->local_name.' when \'-\' then null else 1 end) AS '. $variable->reliability_name .''.$this->incoming.',';
            }
        }
        $text[strlen($text)-1] = ' ';

        return $text;
    }



}