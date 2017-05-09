<?php

namespace App\Etl\Transformers;

use App\Repositories\TemporaryWork\TemporaryCorrectionRepository;
use DB;

abstract class TransformBase
{
    /**
     * @param $repositorySpaceWork
     * @param $tableSpaceWork
     * @param String $variable
     * @param float $overflowValue
     */
    public function overflowMaximum($repositorySpaceWork, $tableSpaceWork, $variable, $overflowValue)
    {
        $values = ($repositorySpaceWork)::select('id','estacion_sk','fecha_sk','tiempo_sk',$variable)->where($variable, '>', (double)$overflowValue)->get();
        //DB::connection('temporary_work')->table($tableSpaceWork)->where($variable, '>', (float)$overflowValue)->update([$variable => '-']);

        $val = DB::connection('temporary_work')->table($tableSpaceWork)->select(DB::raw("CAST($variable AS double precision)"))->where($variable, '>', (double)$overflowValue)->get();
        dd($val);
        $this->insertInCorrectionTable($values,$variable,'overflow_maximum');

        dd($values);
    }

    /**
     * @param $repositorySpaceWork
     * @param $tableSpaceWork
     * @param $variable
     * @param $overflowValue
     */
    public function overflowMinimum($repositorySpaceWork, $tableSpaceWork, $variable, $overflowValue)
    {
        $values = ($repositorySpaceWork)::select('id','estacion_sk','fecha_sk','tiempo_sk',$variable)->where($variable, '<', (double)$overflowValue)->get();
        DB::connection('temporary_work')->table($tableSpaceWork)->where($variable, '<', (double)$overflowValue)->update([$variable => '-']);
        $this->insertInCorrectionTable($values,$variable,'overflow_minimum');

        dd($values);
    }

    /**
     *
     */
    public function overflowPreviousDeference()
    {

    }

    /**
     * @param $values
     * @param $variable
     * @param $observation
     */
    public function insertInCorrectionTable($values,$variable,$observation)
    {
        foreach ($values as $value){
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

}