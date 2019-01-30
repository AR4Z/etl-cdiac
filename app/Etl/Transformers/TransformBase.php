<?php

namespace App\Etl\Transformers;

use App\Etl\EtlBase;
use App\Etl\EtlConfig;
use DB;
use phpDocumentor\Reflection\Types\This;

abstract class TransformBase extends EtlBase
{
    /**
     * @param string $variable
     * @param null $overflowMaximum
     * @param null $overflowMinimum
     * @param null $overflowPreviousDeference
     * @param null $changeOverflowLower
     * @param null $changeOverflowHigher
     * @param null $changeOverflowPreviousDeference
     */
    public function overflow(
        string $variable,
        $overflowMaximum = null,
        $overflowMinimum = null,
        $overflowPreviousDeference = null,
        $changeOverflowLower = null,
        $changeOverflowHigher = null,
        $changeOverflowPreviousDeference = null
    )
    {
        $values =DB::connection('temporary_work')->table($this->etlConfig->tableSpaceWork)
                    ->select('id','station_sk','date_sk','time_sk',DB::raw("CAST($variable AS double precision)"))
                    ->whereNotNull($variable)
                    ->orderby('id','DESC')
                    ->get();

        foreach ($values as $key => $value)
        {
            $floatValue = (float)$value->$variable;

            if(!is_null($overflowMaximum) and $floatValue > $overflowMaximum){
                $this->insertInCorrectionTable($value,$variable,$changeOverflowHigher,'outside_maximum_rank');
                DB::connection('temporary_work')->table($this->etlConfig->tableSpaceWork)->where('id', '=', $value->id)->update([$variable => $changeOverflowHigher]);
                unset($values[$key]);
            }
            if (!is_null($overflowMinimum) and $floatValue < $overflowMinimum){
                $this->insertInCorrectionTable($value,$variable,$changeOverflowLower,'outside_minimum_rank');
                DB::connection('temporary_work')->table($this->etlConfig->tableSpaceWork)->where('id', '=', $value->id)->update([$variable => $changeOverflowLower]);
                unset($values[$key]);
            }
        }

        if(!is_null($overflowPreviousDeference)){
            if (!is_null($values)){
                foreach ($values as $key =>$value){

                    $previous_value = DB::connection('temporary_work')
                        ->table($this->etlConfig->tableSpaceWork)
                        ->select('id',DB::raw("CAST($variable AS double precision)"))
                        ->where('date_sk', '<=' ,$value->date_sk)
                        ->where('time_sk', '<' ,$value->time_sk)
                        ->orderBy('date_sk', 'DESC')
                        ->orderBy('time_sk', 'DESC')
                        ->first();

                    if (!is_null($previous_value)){
                        if (!is_null($previous_value->$variable)){
                            $deference = abs($value->$variable - $previous_value->$variable);
                            if ($deference > $overflowPreviousDeference){
                                $this->insertInCorrectionTable($value,$variable,$changeOverflowPreviousDeference,'outside_previous_deference');
                                DB::connection('temporary_work')->table($this->etlConfig->tableSpaceWork)->where('id', '=', $value->id)->update([$variable => $changeOverflowPreviousDeference]);
                                unset($values[$key]);
                            }
                        }

                    }
                }
            }
        }
        return;
    }

    /**
     * @param string $variable
     * @param $deleteLastHour
     * @param $spaceTimeDelete
     * @return bool
     * @throws \Rinvex\Repository\Exceptions\RepositoryException
     */
    public function updateRageTime(string $variable, $deleteLastHour, $spaceTimeDelete)
    {
        $values = $this->getWhereInWDT($this->etlConfig->repositorySpaceWork,$variable,$deleteLastHour);

        if (is_null($values)){ return false;}

        # MaxValueSk esta en TimeSkTrait: es el ultimo tiempo sk en la tabla
        $limit = $this->maxValueSk - $spaceTimeDelete;

        foreach ($values as $value){
            $secondTimeSk = $value->time_sk + $spaceTimeDelete;
            $secondDateSk = $value->date_sk;

            if ($limit <= $value->time_sk){ $secondTimeSk = $value->time_sk - $limit; $secondDateSk += 1; }

            if ($value->date_sk = $secondDateSk){
                $this->updateInRange($variable,$value->date_sk,$value->time_sk,$secondTimeSk,null);
            }else{
                $this->updateInRange($variable,$value->date_sk,$value->time_sk,$limit,null);
                $this->updateInRange($variable,$secondDateSk,$value->time_sk,$limit,null);
            }
        }

        return true;
    }

    /**
     * @param string $variable
     * @param $initDateSk
     * @param $initTimeSk
     * @param $finalTimeSk
     * @param null $valueForChange
     * @return bool
     */
    public function updateInRange(string $variable, $initDateSk, $initTimeSk, $finalTimeSk, $valueForChange = null)
    {
        $query  = DB::connection('temporary_work')->table($this->etlConfig->tableSpaceWork)->where('date_sk','=',$initDateSk)->where('time_sk','>=', $initTimeSk)->where('time_sk', '<=', $finalTimeSk);

        # Extraer todos los campos que cumplen las condiciones
        $values = $query->get();

        # Ingresar los valores que no son null al historial de correciones
        foreach ($values as $value) { if (!is_null($value->$variable)){ $this->insertInCorrectionTable($value,$variable,$valueForChange,'span_zero');}}

        # Editar los campos que cumplen las condiciones
        $query->update([$variable => $valueForChange]);

        return true;
    }

    /**
     * @param $variables
     * @return bool
     */
    public function trustProcess($variables)
    {
        if (is_null($variables->reliability_name)){return false;}

        $this->etlConfig->trustObject->insertGoods(
            $this->etlConfig->repositorySpaceWork,
            $this->etlConfig->station->id,
            $variables->local_name,
            $variables->reliability_name
        );
    }

    /**
     * @param string $variable
     * @param array $searchParams
     * @return bool
     */
    public function updateForNull(string $variable, array $searchParams = ['-'])
    {
       $values =  DB::connection('temporary_work')
                       ->table($this->etlConfig->tableSpaceWork)
                       ->select('id','station_sk','date_sk','time_sk',$variable)
                       ->whereIn($variable,$searchParams)
                       ->get();

       if (is_null($values) or empty($values)){return false;}

       foreach ($values as $value ) {$this->insertInCorrectionTable($value,$variable,null,'known_error_value');}

        DB::connection('temporary_work')->table($this->etlConfig->tableSpaceWork)->whereIn($variable,$searchParams)->update([$variable => null]);

       return true;

    }

    /**
     * @param $value
     * @param $variable
     * @param null $change
     * @param null $observation
     */
    private function insertInCorrectionTable($value, $variable, $change = null, $observation = null)
    {
        DB::connection('temporary_work')
                ->table('temporary_correction')
                ->insert([
                    'temporary_id'  => $value->id,
                    'station_sk'    => $value->station_sk,
                    'date_sk'       => $value->date_sk,
                    'time_sk'       => $value->time_sk,
                    'variable'      => $variable,
                    'error_value'   => $value->$variable,
                    'correct_value' => $change,
                    'observation'   => $observation,
                ]);
    }

    /**
     * @param array $params
     */
    public function setParamSearch(array $params)
    {
        foreach ($params as $param){ array_push($this->paramSearch, $param);}
    }

    public function filterWindSpeedZero()
    {
        return DB::connection('temporary_work')
            ->table($this->etlConfig->tableSpaceWork)
            ->whereNotNull('wind_direction')
            ->where(function ($query){$query->whereRaw('CAST(wind_speed AS FLOAT) = 0')->orWhere('wind_speed','=',null);})
            ->update(['wind_direction' => null, 'comment' => DB::raw("CONCAT(comment,  ' filterWindSpeedZero -' )")]);
    }

    /**
     * @param $variables
     * @return bool
     * @throws \Rinvex\Repository\Exceptions\RepositoryException
     */
    public function filterCappedRainGauge($variables)
    {
       $result =  DB::connection('temporary_work')
                    ->table($this->etlConfig->tableSpaceWork)
                    ->select('id','comment')
                    ->where('comment','like','% PTI %')
                    ->orWhere('comment','like','% PTF %')
                    ->orderBy('id')
                    ->get()
                    ->toArray();

       if (count($result) == 0){ return false;}

       $flag = 'PTF';
       foreach ($result as $key => $var){
           $var->banderCRG = (is_numeric(strpos($var->comment,'PTI'))) ? 'PTI' : 'PTF';

           if ($var->banderCRG === $flag){ unset($result[$key]); }

           if (!empty($var)){ $flag = $var->banderCRG; }
       }

       $result = array_combine(range(0, count($result)-1), array_values($result));
       $countData = count($result);

       if ($countData == 1){
          $this->deleteAfterIdVariableWDT($this->etlConfig->repositorySpaceWork,$result[0]->id,$variables);
       }else{
           if ($countData % 2 !== 0){
               $this->deleteAfterIdVariableWDT($this->etlConfig->repositorySpaceWork,$result[$countData - 1]->id,$variables);
               unset($result[$countData - 1]);
               $countData -= 1;
           }

           for( $i = 0; $i < $countData; $i += 2){
               $this->deleteInRangeIdVariableWDT($this->etlConfig->repositorySpaceWork,$result[$i]->id,$result[$i + 1]->id,$variables);
           }
       }

       return true;
    }

    /**
     * @param $date
     * @param $time
     * @return mixed
     */
    public function getElementInFact($date, $time)
    {
        return DB::connection('data_warehouse')
            ->table($this->etlConfig->tableDestination)
            ->select('*')
            ->where('date_sk','=',$date)
            ->where('time_sk','>=',$time)
            ->first();
    }

    /**
     * @param $date
     * @param $time
     * @return mixed
     */
    public function getElementInTemporal($date, $time)
    {
        return DB::connection('temporary_work')
            ->table($this->etlConfig->tableSpaceWork)
            ->select('*')
            ->where('date_sk','=',$date)
            ->where('time_sk','>=',$time)
            ->first();
    }
}
