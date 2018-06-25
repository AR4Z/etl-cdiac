<?php

namespace App\Etl\Extractors;


use App\Etl\EtlBase;
use Carbon\Carbon;
use App\Etl\Traits\{DateSkTrait, TimeSkTrait, WorkDatabaseTrait,TrustTrait};
use DB;
use Exception;

/**
 * @property bool flagTimeSk
 * @property bool flagDateSk
 * @property bool flagStationSk
 * @property  object etlConfig
 */
abstract class ExtractorBase extends EtlBase
{
    use DateSkTrait, TimeSkTrait,WorkDatabaseTrait, TrustTrait;

    public $keyErrors = ['_','Min','Date','Time','Max','Date','Time','AVG','Num','Data[%]'];

    /**
     * @param $repository
     * @return void
     */
    public function updateDateSk($repository)
    {
        $dates = ($repository)::getDatesDistinct();
        foreach ($dates as $date){
            ($repository)::updateDateSk($this->calculateDateSk(Carbon::parse($date->date)),$date->date);
        }
        $this->flagDateSk = true;
    }

    /**
     * @param $repository
     * @return void
     */
    public  function updateTimeSk($repository)
    {
        $times = ($repository)::getTimesDistinct();
        foreach ($times as $time){
            if($time->time == '24:00:00'){
                ($repository)::incrementDateSk($time->id,1);
                ($repository)::updateTimeSkFromStationSk($time->id,$this->calculateTimeSk('00:00:00'));
            }else{
                ($repository)::updateTimeSk($this->calculateTimeSk($time->time),$time->time);
            }
        }
        $this->flagTimeSk = true;
    }

    /**
     * @param $station
     * @param $repository
     * @return bool
     */
    public function updateStationSk($station, $repository)
    {
        ($repository)::updateStationSk($station->id);
        $this->flagStationSk = true;
    }

    /**
     * @return bool
     */
    public function trustProcess()
    {
        if (!$this->etlConfig->isTrustProcess()){ return false;}

        # Calcular los datos entrantes para el preceso de confianza

        $trust= $this->incomingCalculation(
                            $this->etlConfig->getTrustRepository(),
                            $this->etlConfig->getTableSpaceWork(),
                            $this->etlConfig->getTableTrust(),
                            $this->etlConfig->getVarForFilter()->toArray()
                        );

        # Actualizar el estado del proceso de confianza
        $this->etlConfig->setTrustColumns($trust);

        # Calcular la Cantidad de datos entrante
        $this->etlConfig->setIncomingAmount(
            $this->getIncomingAmount(
                $this->etlConfig->getTableSpaceWork()
            )
        );

        return true;
    }

    /**
     *
     */
    public function configureSpaceWork()
    {
        ($this->etlConfig->getRepositorySpaceWork())::truncate();
        $this->truncateCorrectionTable();
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
     * @param $repository
     * @param $tableSpaceWork
     */
    public function getCalculateDateAndTime($repository, $tableSpaceWork)
    {
        $values = ($repository)::getDateTime();

        foreach ($values as $value)
        {
            $dateTime = $this->parseCarbonDateTime(trim($value->date_time));

            if (!is_null($dateTime)){
                $this->updateDateTimeFromId($tableSpaceWork,$value->id,$dateTime->format('Y-m-d'),$dateTime->format('H:i:s'));
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
     * @param $tableSpaceWork
     * @return bool
     */
    public function deleteTimeAndDateNull($tableSpaceWork)
    {
        $this->deleteWhereInVariable($tableSpaceWork,'date_time',$this->keyErrors);
        $this->deleteWhereInVariable($tableSpaceWork,'date',$this->keyErrors);
        $this->deleteWhereInVariable($tableSpaceWork,'time',$this->keyErrors);

        $this->deleteNullVariable($tableSpaceWork,'date');

        return true;
    }
}