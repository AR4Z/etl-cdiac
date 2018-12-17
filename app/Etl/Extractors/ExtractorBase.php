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
     * @return void
     */
    public function updateDateSk()
    {
        $dates = $this->etlConfig->repositorySpaceWork->getDatesDistinct();

        foreach ($dates as $date){
            $this->etlConfig->repositorySpaceWork->updateDateSk($this->calculateDateSk(Carbon::parse($date->date)),$date->date);
        }

        $this->flagDateSk = true; # TODO es posible quitar esto ?
    }

    /**
     * @return void
     */
    public  function updateTimeSk()
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
        $this->flagTimeSk = true; # TODO es posible quitar esto ?
    }

    /**
     * @param int $stationId
     */
    public function updateStationSk(int $stationId)
    {
        $this->etlConfig->repositorySpaceWork->updateStationSk($stationId);

        $this->flagStationSk = true; # TODO es posible quitar esto ?
    }

    /**
     * @return bool
     * @throws \Rinvex\Repository\Exceptions\RepositoryException
     */
    public function trustProcess()
    {
        if (!$this->etlConfig->isTrustProcess()){ return false;}

        # Calcular los datos entrantes para el preceso de confianza

        $trust= $this->incomingCalculation($this->etlConfig->varForFilter->toArray());

        # Actualizar el estado del proceso de confianza
        $this->etlConfig->setTrustColumns($trust);

        # Calcular la Cantidad de datos entrante
        $this->etlConfig->setIncomingAmount($this->getIncomingAmountWDT($this->etlConfig->repositorySpaceWork));

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
     * @throws \Rinvex\Repository\Exceptions\RepositoryException
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
     * @throws \Rinvex\Repository\Exceptions\RepositoryException
     */
    public function deleteTimeAndDateNull() : bool
    {
        $this->deleteWhereInVariableWDT($this->etlConfig->repositorySpaceWork,'date_time',$this->keyErrors);
        $this->deleteWhereInVariableWDT($this->etlConfig->repositorySpaceWork,'date',$this->keyErrors);
        $this->deleteWhereInVariableWDT($this->etlConfig->repositorySpaceWork,'time',$this->keyErrors);

        $this->deleteNullVariableWDT($this->etlConfig->repositorySpaceWork,'date');

        return true;
    }
}