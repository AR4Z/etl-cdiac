<?php

namespace App\Etl\Transformers;

use App\Etl\EtlConfig;
use App\Etl\Traits\DateSkTrait;
use App\Etl\Traits\TimeSkTrait;

class Serialization extends TransformBase implements TransformInterface
{
    use TimeSkTrait,DateSkTrait;

    public $etlConfig = null;

    public $station_sk = null;

    public $dateSpace = 1; #intervalo de serialización (date) en numero de dias

    public $timeSpace = 300; #intervalo de Serialización (time) en segundos

    public $arrayDate = []; #array de fechas posibles

    public $arrayTime = []; #array de horas posibles

    public $inserts = []; #array de valores/inexistentes -> para ingresar

    /**
     * @param EtlConfig $etlConfig
     * @return mixed
     */
    public function setOptions(EtlConfig $etlConfig)
    {
        $this->etlConfig = $etlConfig;
        $this->station_sk = $etlConfig->getStation()->id;
        return $this;
    }

    /**
     *
     */
    public function run()
    {
        $this->arrayTime = $this->getSerializationTime($this->timeSpace);
        $this->arrayDate = $this->getSerializationDate($this->etlConfig->getInitialDate(),$this->etlConfig->getFinalDate(), $this->dateSpace);
        $this->serialization();

        return $this;
    }

    /**
     *
     */
    public function serialization()
    {
        foreach ($this->arrayDate as $date)
        {
            $count = $this->countRowForDate($this->etlConfig->getTableSpaceWork(),$date);
            if($count == 0){
                $this->pushAllInserts($date);
            }else{
                $this->cycleForTime($date);
            }
        }
        $this->serializationInsert($this->etlConfig->getTableSpaceWork(),$this->inserts);
    }

    /**
     * @param $date
     * @param $time
     */
    public function insertArray($date, $time)
    {
        array_push($this->inserts,['station_sk' => $this->station_sk,'date_sk' => $date, 'time_sk' =>$time ]);
    }

    /**
     * @param $date
     */
    public function cycleForTime($date)
    {
        foreach ($this->arrayTime as $time)
        {
            $intervalActual = $this->timeSpace + $time - 1;

            $valInRangeActual = $this->getValInRange($this->etlConfig->getTableSpaceWork(),$date,$time,$intervalActual);
            $valInRangeNext = $this->getValInRange($this->etlConfig->getTableSpaceWork(),$date,$intervalActual,$intervalActual + $this->timeSpace);

            $this->conditionalSerialization(
                $valInRangeActual,
                $valInRangeNext,
                count($valInRangeActual),
                count($valInRangeNext),
                $intervalActual,
                $date,
                $time
            );
        }
    }

    /**
     * @param $valInRangeActual
     * @param $valInRangeNext
     * @param $countActual
     * @param $countNext
     * @param $intervalActual
     * @param $date
     * @param $time
     */
    public function conditionalSerialization($valInRangeActual, $valInRangeNext, $countActual, $countNext, $intervalActual, $date, $time)
    {
        if ($countActual == 0 ){
            if ($countNext == 0 or $countNext == 1 ){
                # ingresar array de datos inexistentes
                $this->insertArray($date,$time);
            }
            else{
                #cambiar primero de next a actual
                $this->serializationUpdate($this->etlConfig->getRepositorySpaceWork(), $valInRangeNext[0],$date,$time);
            }
        }else{
            if ($countActual == 1){
                #Corregir fecha y hora en actual
                $this->serializationUpdate($this->etlConfig->getRepositorySpaceWork(), $valInRangeActual[0],$date,$time);
            }
            else{
                if ($countNext == 0){
                    #pasar ultimo actual a next
                    $this->serializationUpdate($this->etlConfig->getRepositorySpaceWork(), $valInRangeActual[$countActual-1],$date,$intervalActual + 1);
                    unset($intervalActual[$countActual-1]);
                }
                #Promediar en anterior
                $this->serializationCorrect(
                        $this->etlConfig->getTableSpaceWork(),
                        $this->etlConfig->getVarForFilter(),
                        $this->etlConfig->getStation()->id,
                        $valInRangeActual,
                        $date,
                        $time,
                        $intervalActual
                    );
            }
        }
    }

    /**
     * @param $date
     */
    public function pushAllInserts($date)
    {
        foreach ($this->arrayTime as $time){
            $this->insertArray($date,$time);
        }
    }

}