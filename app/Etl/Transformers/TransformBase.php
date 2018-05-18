<?php

namespace App\Etl\Transformers;

use App\Etl\Traits\TrustTrait;
use App\Etl\Traits\WorkDatabaseTrait;
use DB;

abstract class TransformBase
{
    use TrustTrait,WorkDatabaseTrait;
    /**
     * @param $tableSpaceWork
     * @param String $variable
     * @param $overflowMaximum
     * @param $overflowMinimum
     * @param $overflowPreviousDeference
     * @internal param $overflowMinimum
     * @internal param float $overflowValue
     */
    public function overflow($tableSpaceWork, $variable, $overflowMaximum = null, $overflowMinimum = null,$overflowPreviousDeference = null)
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
                $this->insertInCorrectionTable($value,$variable,'outside_maximum_rank');
                DB::connection('temporary_work')->table($tableSpaceWork)->where('id', '=', $value->id)->update([$variable => null]);
                unset($values[$key]);
            }
            if (!is_null($overflowMinimum) and $floatValue < $overflowMinimum){
                $this->insertInCorrectionTable($value,$variable,'outside_minimum_rank');
                DB::connection('temporary_work')->table($tableSpaceWork)->where('id', '=', $value->id)->update([$variable => null]);
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
                                $this->insertInCorrectionTable($value,$variable,'outside_previous_deference');
                                DB::connection('temporary_work')->table($tableSpaceWork)->where('id', '=', $value->id)->update([$variable => null]);
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
     * @param $local_name
     * @return bool
     */
    public function trustProcess($local_name)
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
     * @param $tableSpaceWork
     * @param $variable
     * @param $searchParams
     */
    public function updateForNull($tableSpaceWork, $variable,$searchParams)
    {
        DB::connection('temporary_work')->table($tableSpaceWork)->whereIn($variable,$searchParams)->update([$variable => null]);
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
     * @param $observation
     */
    private function insertInCorrectionTable($value,$variable,$observation)
    {
        DB::connection('temporary_work')
                ->table('temporary_correction')
                ->insert([
                    'temporary_id'  => $value->id,
                    'station_sk'   => $value->station_sk,
                    'date_sk'      => $value->date_sk,
                    'time_sk'     => $value->time_sk,
                    'variable'      => $variable,
                    'error_value'   => $value->$variable,
                    'observation'   => $observation,
                ]);
    }

    private function evaluateExistenceInHistoryCorrection($id,$variable){

        $value=  DB::connection('temporary_work')
                    ->table('temporary_correction')
                    ->where('temporary_id','=',$id)
                    ->where('variable','=',$variable)
                    ->get()->count();

        return ($value == 0) ? false : true;
    }



}