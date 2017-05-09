<?php

namespace App\Etl\Transformers;


use DB;

abstract class TransformBase
{
    /**
     * @param $repositorySpaceWork
     * @param $tableSpaceWork
     * @param String $variable
     * @param float $overflowValue
     */
    public function overflowMaximo($repositorySpaceWork, $tableSpaceWork, $variable, $overflowValue)
    {
        $values = ($repositorySpaceWork)::select('id','estacion_sk','fecha_sk','tiempo_sk',$variable)->where($variable, '>', (double)$overflowValue)->get();
        DB::connection('temporary_work')->table($tableSpaceWork)->where($variable, '>', (double)$overflowValue)->update([$variable => '-']);
        dd($overflowValue,$values);
    }

    /**
     *
     */
    public function overflowMinim()
    {

    }

    /**
     *
     */
    public function overflowPreviousDeference()
    {

    }

    /**
     *
     */
    public function insertInCorrectionTable(){

    }

}