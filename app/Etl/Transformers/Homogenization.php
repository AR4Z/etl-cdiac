<?php

namespace App\Etl\Transformers;

use App\Etl\EtlConfig;

class Homogenization extends TransformBase implements TransformInterface
{
    public $etlConfig = null;

    public $station_sk = null;

    public $dateSpace = 1; #intervalo de serialización (date) en numero de dias

    public $timeSpace = 300; #intervalo de Serialización (time) en segundos

    public $arrayDate = []; #array de fechas posibles

    public $arrayTime = []; #array de horas posibles

    public $inserts = []; #array de valores/inexistentes -> para ingresar

    public $updates = []; # array de valores para editar


    /**
     * @param EtlConfig $etlConfig
     * @return mixed
     */
    public function setOptions(EtlConfig $etlConfig)
    {
        $this->etlConfig = $etlConfig;
        return $this;
    }

    /**
     * @return $this
     */
    public function run()
    {
        $this->arrayTime = array_column($this->getStandardDataTime($this->timeSpace),'time_sk');

        $this->arrayDate = $this->getSerializationDate($this->etlConfig->getInitialDate(),$this->etlConfig->getFinalDate(), $this->dateSpace);

        $this->homogenization();

        # editar elementos
        foreach ($this->updates as $update) {
            $this->updateDateTimeFromId($this->etlConfig->getTableSpaceWork(),$update['value']->id,['date_sk' =>$update['date'], 'time_sk' =>$update['time']]);
        }

        # insertar elementos
        foreach ($this->inserts as $insert){
            $this->insertDataArray($this->etlConfig->getTableSpaceWork(),$insert);
        }

        # eliminar elementos nos pertenecientes a las series homogenizadas
        $this->deleteEldestHomogenization($this->etlConfig->getTableSpaceWork(),$this->arrayTime);

        return $this;
    }

    /**
     *
     */
    public function homogenization()
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
    }

    /**
     * Metodo para insertar un dia completo de horas
     * @param $date
     */
    public function pushAllInserts($date)
    {
        foreach ($this->arrayTime as $time)
        {
            array_push($this->inserts,['station_sk' => $this->etlConfig->getStation()->id,'date_sk' => $date, 'time_sk' => $time ]);
        }
    }

    /**
     * @param $date
     */
    public function cycleForTime($date)
    {
        foreach ($this->arrayTime as $time)
        {
           $upperLimit = $this->timeSpace + $time;
           $lowerLimit = (($time - $this->timeSpace) <= 0 ) ? 1 : $time - $this->timeSpace;

            #Evaluar cantidad en el rango actual
            $valInRangeActual = $this->getValInRange($this->etlConfig->getTableSpaceWork(),$date,$lowerLimit,$upperLimit);

            if (!is_null($valInRangeActual)) {
                # se evalua si el tiempo esta mal posicionado.
                if (!(in_array($time,array_column(  $valInRangeActual->toArray(),'time_sk')))){
                    switch (count($valInRangeActual)) {
                        case 0:
                            $this->homogenizationNotElements($date,$time);
                            break;
                        case 1:
                            $this->homogenizationOneElements($valInRangeActual[0],$date,$time);
                            break;
                        case 2:
                            $this->homogenizationTwoElements($valInRangeActual[0],$valInRangeActual[1],$date,$time);
                            break;
                        default:
                            $this->homogenizationMultipleElements($valInRangeActual,$date,$time);
                            break;
                    }
                }
            }
        }
    }

    /**
     * @param $date
     * @param $time
     */
    public function homogenizationNotElements(int $date, int $time)
    {
        array_push($this->inserts,['date_sk'=> $date,'time_sk'=> $time ]);
    }

    /**
     * @param $value
     * @param $date
     * @param $time
     */
    public function homogenizationOneElements($value, int $date, int $time)
    {
        if (!($value->time_sk == $time)){
           array_push($this->updates, ['value'=>$value,'date' => $date, 'time' => $time ]);
        }
    }

    /**
     * @param $valueOne
     * @param $valueTwo
     * @param $date
     * @param $time
     */
    public function homogenizationTwoElements($valueOne, $valueTwo, int $date, int $time)
    {
        $arr = [];
        $arr['station_sk'] = $valueOne->station_sk;
        $arr['date_sk'] = $date;
        $arr['time_sk'] = $time;

        foreach ($this->etlConfig->getVarForFilter() as $variable)
        {
            $arr[$variable->local_name] = $this->directionElements($variable->local_name,$valueOne,$valueTwo,$time,$variable->decimal_precision);
        }
        array_push($this->inserts,$arr);
    }

    /**
     * @param $valInRangeActual
     * @param $date
     * @param $time
     */
    public function homogenizationMultipleElements($valInRangeActual, $date, $time)
    {
        $arrLower = [];
        $arrHigher = [];

        $arr = [];
        $arr['station_sk'] = $valInRangeActual[0]->station_sk;
        $arr['date_sk'] = $date;
        $arr['time_sk'] = $time;

        # se particionan dependiendo de si son mayores o menores.
        foreach ($valInRangeActual as $value){array_push(${($value->time_sk <= $time) ? 'arrLower' : 'arrHigher' } , $value);}

        foreach ($this->etlConfig->getVarForFilter() as $variable)
        {
            $arr[$variable->local_name] = $this->directionElements(
                $variable->local_name,
                (float)(count($arrLower) > 1) ? $this->findNearestValue($variable->local_name,$arrLower,$time) : $arrLower[0],
                (float)(count($arrHigher) > 1) ? $this->findNearestValue($variable->local_name,$arrHigher,$time) : $arrHigher[0],
                $time,
                $variable->decimal_precision
            );

        }
        array_push($this->inserts,$arr);
    }

    /**
     * @param float $v1
     * @param float $v2
     * @param int $t1
     * @param int $t2
     * @param int $t3
     * @param int $round
     * @return float
     */
    public function executeFormula(float $v1, float $v2, int $t1, int $t2, int $t3, int $round = 2)
    {
        return round(($v1 + (($v2 - $v1)/($t2 - $t1)) * ($t3 - $t1)),2);
    }

    /**
     * @param string $variableName
     * @param array $arr
     * @param int $time
     * @return object
     */
    public function findNearestValue(string $variableName, array $arr, int $time)
    {
        $val = null;

        foreach ($arr as $value){

            if (!is_null($val)){
                if (!is_null($value->{$variableName})){ if (abs($time - $value->time_sk) < abs($time - $val->time_sk)){ $val = $value;} }
            }else{
                $val = $value;
            }
        }

        return (object)['time_sk' => $val->time_sk, $variableName => $val->{$variableName}];
    }

    /**
     * @param string $variableName
     * @param $valueOne
     * @param $valueTwo
     * @param int $time
     * @param int $decimalPrecision
     * @return float|null
     */
    public function directionElements(string $variableName, $valueOne, $valueTwo, $time, int $decimalPrecision = 2)
    {
        $value = null;

        if (!is_null($valueOne->{$variableName})){
            if (!is_null($valueTwo->{$variableName})){
                $value = $this->executeFormula((float)$valueOne->{$variableName},(float)$valueTwo->{$variableName},$valueOne->time_sk, $valueTwo->time_sk, $time, $decimalPrecision);
            }else{
                $value = $valueOne->{$variableName};
            }
        }else{
            if (!is_null($valueTwo->{$variableName})){
                $value = $valueTwo->{$variableName};
            }
        }

        return $value;
    }
}