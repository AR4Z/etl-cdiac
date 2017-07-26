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
        $values = ($repositorySpaceWork)::all();
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