<?php

namespace App\Etl\Transformers;

use App\Repositories\TemporaryWork\TemporaryCorrectionRepository;
use DB;

abstract class TransformBase
{
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
        $overflowPreviousDeference = 0.1;
        $values =DB::connection('temporary_work')->table($tableSpaceWork)
                    ->select('id','estacion_sk','fecha_sk','tiempo_sk',DB::raw("CAST($variable AS double precision)"))
                    ->whereNotNull($variable)
                    ->orderby('id','DESC')
                    ->get();

        foreach ($values as $key => $value)
        {
            $floatValue = (float)$value->$variable;
            if ($floatValue > $overflowMaximum || $floatValue < $overflowMinimum){
                $this->insertInCorrectionTable($value,$variable,'outside_rank');
                DB::connection('temporary_work')->table($tableSpaceWork)->where('id', '=', $value->id)->update([$variable => null]);
                unset($values[$key]);
            }
        }

        if(!is_null($overflowPreviousDeference)){
            if (!is_null($values)){
                foreach ($values as $key =>$value){
                    $previous_id = $value->id - 1;
                    $previous_value =DB::connection('temporary_work')->table($tableSpaceWork)->select('id',DB::raw("CAST($variable AS double precision)"))->where('id', '=' ,$previous_id)->first();
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
        return $values;
    }

    /**
     * @param $repositorySpaceWork
     * @param $tableSpaceWork
     * @param $variable
     * @param $overflowValue
     */
    public function overflowMinimum($repositorySpaceWork, $tableSpaceWork, $variable, $overflowValue)
    {

    }

    /**
     *
     */
    public function overflowPreviousDeference()
    {

    }

    /**
     * @param $tableSpaceWork
     * @param $variable
     */
    public function updateForNull($tableSpaceWork, $variable)
    {
        DB::connection('temporary_work')->table($tableSpaceWork)->where($variable, '=','-' )->update([$variable => null]);
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
                    'estacion_sk'   => $value->estacion_sk,
                    'fecha_sk'      => $value->fecha_sk,
                    'tiempo_sk'     => $value->tiempo_sk,
                    'variable'      => $variable,
                    'error_value'   => $value->$variable,
                    'observation'   => $observation,
                ]);
    }

}