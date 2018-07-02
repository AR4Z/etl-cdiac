<?php

namespace App\Etl\Transformers;

use App\Etl\EtlConfig;

class Serialization extends TransformBase implements TransformInterface
{
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
        #Extraer el tiempo serializado apartir del espacio en segundos
        $this->arrayTime = $this->getSerializationTime($this->timeSpace);

        #extraer los diferentes dias en la lista de fechas entradas
        $this->arrayDate = $this->getSerializationDate($this->etlConfig->getInitialDate(),$this->etlConfig->getFinalDate(), $this->dateSpace);

        #Ejecutar la serializacion
        $this->serialization();

        return $this;
    }

    /**
     *
     */
    public function serialization()
    {
        #Se hace ciclo por cada dia en las fechas ingresadas
        foreach ($this->arrayDate as $date)
        {
            #contar la cantidad de horas en un dia
            $count = $this->countRowForDate($this->etlConfig->getTableSpaceWork(),$date);

            if($count == 0){
                $this->pushAllInserts($date); #insertar todas las horas para una fecha que no trae nunguna hora
            }else{
                $this->cycleForTime($date); #Evaluar las diferentes opciones de cada hora
            }
        }
        #despues del proceso de evaluacion se incertan las horas que no fueron halladas en el espacio de trabajo
        $this->serializationInsert($this->etlConfig->getTableSpaceWork(),$this->inserts);
    }

    /**
     * Metodo para insertar en el array que controla las inserciones en el espacio de trabajo
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
            #obtener intervalo de evaluacion
            $intervalActual = $this->timeSpace + $time - 1;

            #Evaluar cantidad en el rango actual
            $valInRangeActual = $this->getValInRange($this->etlConfig->getTableSpaceWork(),$date,$time,$intervalActual);

            #Evaluar cantidad en el rango siguiente
            $valInRangeNext = $this->getValInRange($this->etlConfig->getTableSpaceWork(),$date,$intervalActual,$intervalActual + $this->timeSpace);

            #Evaluar
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
                    unset($valInRangeActual[$countActual-1]);
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
     * Metodo para insertar un dia completo de horas
     * @param $date
     */
    public function pushAllInserts($date)
    {
        foreach ($this->arrayTime as $time){
            $this->insertArray($date,$time);
        }
    }

}