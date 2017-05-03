<?php
namespace  App\Etl\Loaders;

use App\Etl\Traits\WorkDatabaseTrait;
use Carbon\Carbon;
use DB;

abstract class LoadBase
{
    use WorkDatabaseTrait;

    public function redirectExisting($repositorySpaceWork,$repositoryDestination,$repositoryExist,$table)
    {
        /*aqui debe ir el ini
             $deference = DB::table('etl-cdiac.tempory_work.temporal_weather as db1')
                                ->select('db1.estacion_sk,db1.fecha_sk,db1.tiempo_sk')
                                ->Join(
                                    'datawarehouse.public.original_fact_table as db2',
                                    function ($join)
                                    {
                                        $join   ->on('db1.estacion_sk','=','db2.estacion_sk')
                                                ->on('db1.fecha_sk','=','db2.fecha_sk')
                                                ->on('db1.tiempo_sk','=','db1.tiempo_sk');
                                    }
                                )->get();

            dd($deference);
        */

        $values = ($repositorySpaceWork)::all();

        dd($values);

        foreach ($values as $value)
        {

            if ($this->evaluateExistence($repositoryDestination,$value))
            {
                $this->insertExistTable($table,$repositoryExist::fill($value->toArray())->toArray());

                ($repositorySpaceWork)::delete($value->id);
            }
        }
    }

    public function updateDateAndTime($repositorySpaceWork,$stateTableValue)
    {
        $values = ($repositorySpaceWork)::select('*')->orderby('id','desc')->first();

        if (!empty($values))
        {
            $completeDate = Carbon::parse($values->fecha.' '.$values->hora);
            $completeDate->addMinute();

            $stateTableValue->current_date = $completeDate->format('Y-m-d');
            $stateTableValue->current_time = $completeDate->format('h:i:s');
            $stateTableValue->it_update =  ($completeDate >= Carbon::today()->addMinute(-10))?? true;

        }else{
            $stateTableValue->it_update =  true;
        }

        $stateTableValue->save();

    }
}