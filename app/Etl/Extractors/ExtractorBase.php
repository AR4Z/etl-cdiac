<?php

namespace App\Etl\Extractors;

use App\Etl\EtlBase;
use App\Etl\EtlConfig;
use Carbon\Carbon;
use Exception;

abstract class ExtractorBase extends EtlBase
{
    /**
     * @var array
     */
    public $keyErrors = ['_','Min','Date','Time','Max','Date','Time','AVG','Num','Data[%]'];

    /**
     * @var EtlConfig etlConfig
     * @return bool
     */
    public function updateDateSk() :bool
    {
        $dates = $this->etlConfig->repositorySpaceWork->getDatesDistinct();

        foreach ($dates as $date){
            $this->etlConfig->repositorySpaceWork->updateDateSk($this->calculateDateSk(Carbon::parse($date->date)),$date->date);
        }

        return true;
    }

    /**
     * @return bool
     */
    public  function updateTimeSk() : bool
    {
        $times = $this->etlConfig->repositorySpaceWork->getTimesDistinct();

        foreach ($times as $time){
            if($time->time == '24:00:00'){
                $this->etlConfig->repositorySpaceWork->incrementDateSk($time->id,1);
                $this->etlConfig->repositorySpaceWork->updateTimeSkFromStationSk($time->id,$this->calculateTimeSk('00:00:00'));
            }else{
                $this->etlConfig->repositorySpaceWork->updateTimeSk($this->calculateTimeSk($time->time),$time->time);
            }
        }

        return true;
    }

    /**
     * @param int $stationId
     * @return bool
     */
    public function updateStationSk(int $stationId) : bool
    {
        $this->etlConfig->repositorySpaceWork->updateStationSk($stationId);
        return true;
    }

    /**
     * @return bool
     */
    public function trustProcess()
    {
        # Calcular la total de datos entrantes
        $this->etlConfig->trustObject->setIncomingAmount($this->etlConfig->repositorySpaceWork->getIncomingAmount());

        # Calcular los datos entrantes para por variable
        $this->etlConfig->trustObject->incomingCalculation(
            $this->etlConfig->repositorySpaceWork,
            $this->etlConfig->station->id,
            $this->etlConfig->varForFilter->toArray()
        );

        return true;
    }

    /**
     *
     */
    public function configureSpaceWork()
    {
        try {
            $this->etlConfig->repositorySpaceWork->truncate();
            $this->truncateCorrectionTable();

            return ['resultExecution' => true , 'data' => null, 'exception' => null];

        } catch (Exception $e) {

            return ['resultExecution' => false , 'data' => null, 'exception' => $e];
        }
    }

    /**
     * @param $extractType
     * @param $etlConfig
     * @return mixed|object
     */
    public function createExtractType($extractType,$etlConfig)
    {
        if (! class_exists($extractType)) {
            if (isset($aliases['ExtractType'][$extractType])) {
                $extractType = $aliases['ExtractType'][$extractType];
            }
            $extractType = __NAMESPACE__ . '\\' . ucwords('ExtractType') . '\\' . $extractType;
        }
        return new $extractType($etlConfig);
    }

    /**
     * @param string $directory
     * @param string $class
     * @return mixed
     */
    public function factoryExtractorClass(string $directory, string $class)
    {
        if (! class_exists($class)) {
            if (isset($aliases[$directory][$class])) { $class = $class[$directory][$class]; }

            $class = __NAMESPACE__ . '\\' . ucwords($directory) . '\\' . ucwords($class);
        }

        return new $class();
    }

    /**
     *
     */
    public function getCalculateDateAndTime()
    {
        $values = $this->etlConfig->repositorySpaceWork->getDateTime();

        foreach ($values as $value)
        {
            $dateTime = $this->parseCarbonDateTime(trim($value->date_time));

            if (!is_null($dateTime)){
                $this->updateDateTimeFromIdWDT($this->etlConfig->repositorySpaceWork,$value->id,[ 'date' => $dateTime->format('Y-m-d'),'time' =>$dateTime->format('H:i:s')]);
            }
        }
    }

    /**
     * @param string $dateTime
     * @return Carbon
     */
    public function parseCarbonDateTime(string $dateTime = '')
    {
        $value = null;
        try {
            if (!empty($dateTime)){
                $value = Carbon::parse($dateTime);
            }
            return $value;
        } catch (Exception $e) {
            return $value;
        }
    }

    /**
     * @return bool
     */
    public function deleteTimeAndDateNull() : bool
    {
        $this->deleteWhereInVariableWDT($this->etlConfig->repositorySpaceWork,'date_time',$this->keyErrors);
        $this->deleteWhereInVariableWDT($this->etlConfig->repositorySpaceWork,'date',$this->keyErrors);
        $this->deleteWhereInVariableWDT($this->etlConfig->repositorySpaceWork,'time',$this->keyErrors);

        $this->etlConfig->repositorySpaceWork->deleteNullVariable('date');

        return true;
    }
}