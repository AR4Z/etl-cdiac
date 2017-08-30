<?php
namespace  App\Etl\Loaders;

use App\Etl\Traits\DateSkTrait;
use App\Etl\Traits\TimeSkTrait;
use App\Etl\Traits\WorkDatabaseTrait;
use Carbon\Carbon;
use DB;

abstract class LoadBase
{
    use WorkDatabaseTrait,DateSkTrait,TimeSkTrait;

    /**
     * @param $repositorySpaceWork
     * @param $repositoryDestination
     * @param $repositoryExist
     * @param $table
     */
    public function redirectExisting($repositorySpaceWork, $repositoryDestination, $repositoryExist, $table)
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

    /**
     * @param $stateTableValue
     * @param $date
     * @param $time
     * @param $response
     */
    public function updateDateAndTime($stateTableValue, $date, $time, $response)
    {
        $completeDate = Carbon::parse($date.' '.$time);
        $completeDate->addMinute();

        $stateTableValue->current_date = $completeDate->format('Y-m-d');
        $stateTableValue->current_time = $completeDate->format('h:i:s');
        $stateTableValue->updated =  $response;

        $stateTableValue->save();

    }

    /**
     * @param $tableSpaceWork
     * @param $sequence
     * @param $finalDate
     * @param $stateTable
     */
    public function calculateSequence($tableSpaceWork, $sequence, $finalDate, $stateTable)
    {
        $data = $this->getLastMigrateData($tableSpaceWork);
        if (!is_null($data))
        {
           $response =  ($sequence and Carbon::parse($finalDate) == Carbon::parse($this->calculateDateFromDateSk($data->date_sk))) ? true : false;

            $this->updateDateAndTime(
                $stateTable,
                $this->calculateDateFromDateSk($data->date_sk),
                $this->calculateTimeFromTimeSk($data->time_sk),
                $response
            );
        }
    }
}