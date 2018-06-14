<?php

namespace App\Etl\Transformers;

use App\Etl\EtlBase;
use function Couchbase\defaultDecoder;
use DB;

abstract class TransformBase extends EtlBase
{
    /**
     * @param string $tableSpaceWork
     * @param string $variable
     * @param null $overflowMaximum
     * @param null $overflowMinimum
     * @param null $overflowPreviousDeference
     * @param null $changeOverflowLower
     * @param null $changeOverflowHigher
     * @param null $changeOverflowPreviousDeference
     */
    public function overflow(
        string $tableSpaceWork,
        string $variable,
        $overflowMaximum = null,
        $overflowMinimum = null,
        $overflowPreviousDeference = null,
        $changeOverflowLower = null,
        $changeOverflowHigher = null,
        $changeOverflowPreviousDeference = null
    )
    {
        $values =DB::connection('temporary_work')->table($tableSpaceWork)
                    ->select('id','station_sk','date_sk','time_sk',DB::raw("CAST($variable AS double precision)"))
                    ->whereNotNull($variable)
                    ->orderby('id','DESC')
                    ->get();

        foreach ($values as $key => $value)
        {
            $floatValue = (float)$value->$variable;

            if(!is_null($overflowMaximum) and $floatValue > $overflowMaximum){
                $this->insertInCorrectionTable($value,$variable,$changeOverflowHigher,'outside_maximum_rank');
                DB::connection('temporary_work')->table($tableSpaceWork)->where('id', '=', $value->id)->update([$variable => $changeOverflowHigher]);
                unset($values[$key]);
            }
            if (!is_null($overflowMinimum) and $floatValue < $overflowMinimum){
                $this->insertInCorrectionTable($value,$variable,$changeOverflowLower,'outside_minimum_rank');
                DB::connection('temporary_work')->table($tableSpaceWork)->where('id', '=', $value->id)->update([$variable => $changeOverflowLower]);
                unset($values[$key]);
            }
        }

        if(!is_null($overflowPreviousDeference)){
            if (!is_null($values)){
                foreach ($values as $key =>$value){

                    $previous_value = DB::connection('temporary_work')
                        ->table($tableSpaceWork)
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
                                DB::connection('temporary_work')->table($tableSpaceWork)->where('id', '=', $value->id)->update([$variable => $changeOverflowPreviousDeference]);
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
     * @param string $tableSpaceWork
     * @param string $variable
     * @param $deleteLastHour
     * @param $spaceTimeDelete
     * @return bool
     */
    public function updateRageTime(string $tableSpaceWork, string $variable, $deleteLastHour, $spaceTimeDelete)
    {
        $values = $this->getWhereIn($tableSpaceWork,$variable,$deleteLastHour);

        if (is_null($values)){ return false;}

        # MaxValueSk esta en TimeSkTrait: es el ultimo tiempo sk en la tabla
        $limit = $this->maxValueSk - $spaceTimeDelete;

        foreach ($values as $value){
            $secondTimeSk = $value->time_sk + $spaceTimeDelete;
            $secondDateSk = $value->date_sk;

            if ($limit <= $value->time_sk){ $secondTimeSk = $value->time_sk - $limit; $secondDateSk += 1; }

            if ($value->date_sk = $secondDateSk){
                $this->updateInRange($tableSpaceWork,$variable,$value->date_sk,$value->time_sk,$secondTimeSk,null);
            }else{
                $this->updateInRange($tableSpaceWork,$variable,$value->date_sk,$value->time_sk,$limit,null);
                $this->updateInRange($tableSpaceWork,$variable,$secondDateSk,$value->time_sk,$limit,null);
            }
        }

        return true;
    }

    /**
     * @param string $tableSpaceWork
     * @param string $variable
     * @param $initDateSk
     * @param $initTimeSk
     * @param $finalTimeSk
     * @param null $valueForChange
     * @return bool
     */
    public function updateInRange(string $tableSpaceWork, string $variable, $initDateSk, $initTimeSk, $finalTimeSk, $valueForChange = null)
    {
        $query  = DB::connection('temporary_work')->table($tableSpaceWork)->where('date_sk','=',$initDateSk)->where('time_sk','>=', $initTimeSk)->where('time_sk', '<=', $finalTimeSk);

        # Extraer todos los campos que cumplen las condiciones
        $values = $query->get();

        # Ingresar los valores que no son null al historial de correciones
        foreach ($values as $value) { if (!is_null($value->$variable)){ $this->insertInCorrectionTable($value,$variable,$valueForChange,'span_zero');}}

        # Editar los campos que cumplen las condiciones
        $query->update([$variable => $valueForChange]);

        return true;
    }

    /**
     * @param string $local_name
     * @return bool
     */
    public function trustProcess(string $local_name)
    {
        if (!$this->etlConfig->isTrustProcess()){return false;}

        $this->insertGoods(
            $this->etlConfig->getTrustRepository(),
            $this->etlConfig->getTableSpaceWork(),
            $this->etlConfig->getTableTrust(),
            $local_name
        );
    }


    /**
     * @param string $tableSpaceWork
     * @param string $variable
     * @param array $searchParams
     * @return bool
     */
    public function updateForNull(string $tableSpaceWork, string $variable, array $searchParams = ['-'])
    {
       $values =  DB::connection('temporary_work')
                       ->table($tableSpaceWork)
                       ->select('id','station_sk','date_sk','time_sk',$variable)
                       ->whereIn($variable,$searchParams)
                       ->get();

       if (is_null($values) or empty($values)){return false;}

       foreach ($values as $value ) {$this->insertInCorrectionTable($value,$variable,null,'known_error_value');}

        DB::connection('temporary_work')->table($tableSpaceWork)->whereIn($variable,$searchParams)->update([$variable => null]);

       return true;

    }

    /**
     * @param $value
     * @param $variable
     * @param $correctValue
     * @param $applied_correction_type
     */
    public function updateHistoryCorrect($value, $variable, $correctValue, $applied_correction_type)
    {
        if (!$this->evaluateExistenceInHistoryCorrection($value->id,$variable)){
            DB::connection('temporary_work')
                ->table('temporary_correction')
                ->insert([
                    'temporary_id'              => $value->id,
                    'station_sk'                => $value->station_sk,
                    'date_sk'                   => $value->date_sk,
                    'time_sk'                   => $value->time_sk,
                    'variable'                  => $variable,
                    'observation'               => 'not_existence',
                    'correct_value'             => $correctValue,
                    'applied_correction_type'   => $applied_correction_type
                ]);

        }else{
            DB::connection('temporary_work')
                ->table('temporary_correction')
                ->where('temporary_id','=',$value->id)
                ->where('variable','=',$variable)
                ->update([
                    'correct_value' => $correctValue,
                    'applied_correction_type' => $applied_correction_type
                ]);
        }


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
     * @param $id
     * @param $variable
     * @return bool
     */
    private function evaluateExistenceInHistoryCorrection($id, $variable){

        $value=  DB::connection('temporary_work')
                    ->table('temporary_correction')
                    ->where('temporary_id','=',$id)
                    ->where('variable','=',$variable)
                    ->get()->count();

        return ($value == 0) ? false : true;
    }

    /**
     * @param array $params
     */
    public function setParamSearch(array $params)
    {
        foreach ($params as $param){ array_push($this->paramSearch, $param);}
    }

    /**
     * @param string $tableSpaceWork
     * @param string $variable
     * @return bool
     */
    public function changeCommaForPoint(string $tableSpaceWork, string $variable)
    {
        $values = DB::connection('temporary_work')->table($tableSpaceWork)->select('station_sk','date_sk','time_sk',$variable)->whereNotNull($variable)->get();

        if (is_null($values) or count($values) == 0){return false;}

        foreach ($values as $value)
        {
            $val = str_replace (",", ".",$value->$variable);

            DB::connection('temporary_work')
                ->table($tableSpaceWork)
                ->where('station_sk','=',$value->station_sk)
                ->where('date_sk','=',$value->date_sk)
                ->where('time_sk','=',$value->time_sk)
                ->update([$variable => $val]);
        }

        return true;
    }

}