<?php

namespace App\Etl\Extractors;


use Carbon\Carbon;
use App\Etl\Traits\{DateSkTrait, TimeSkTrait, WorkDatabaseTrait,TrustTrait};


/**
 * @property bool flagTimeSk
 * @property bool flagDateSk
 * @property bool flagStationSk
 * @property  object etlConfig
 */
abstract class ExtractorBase
{
    use DateSkTrait, TimeSkTrait,WorkDatabaseTrait, TrustTrait;

    /**
     * @param $repository
     * @return bool
     */
    public function updateDateSk($repository)
    {
        $dates = ($repository)::getDatesDistinct();
        foreach ($dates as $date){($repository)::updateDateSk($this->calculateDateSk(Carbon::parse($date->date)),$date->date);}
        $this->flagDateSk = true;
    }

    /**
     * @param $repository
     * @return void
     */
    public  function updateTimeSk($repository)
    {
        $times = ($repository)::getTimesDistinct();
        foreach ($times as $time){($repository)::updateTimeSk($this->calculateTimeSk($time->time),$time->time);}
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
        if (!$this->etlConfig->isTrustProcess()){false;}

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
        if ($this->truncateTemporal){($this->etlConfig->getRepositorySpaceWork())::truncate();}

        //workDatabaseTrait->truncateCorrectionTable
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
}