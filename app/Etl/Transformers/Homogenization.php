<?php

namespace App\Etl\Transformers;

use App\Etl\EtlConfig;
use App\Etl\Steps\{StepList,Step,StepContract};
use Exception;

class Homogenization extends TransformBase implements TransformInterface, StepContract
{
    /**
     * @var string
     */
    public $method = 'Homogenization';

    /**
     * @var EtlConfig
     */
    public $etlConfig = null;

    /**
     * @var StepList
     */
    public $stepsList = null;

    /**
     * Intervalo de serialización (date) en numero de dias
     * @var int
     */
    public $dateSpace = 1;

    /**
     * Intervalo de Serialización (time) en segundos
     * @var int
     */
    public $timeSpace = 300;

    /**
     * Array de fechas posibles
     * @var array
     */
    public $arrayDate = [];

    /**
     * Array de horas posibles
     * @var array
     */
    public $arrayTime = [];

    /**
     * Array de valores/inexistentes -> para ingresar
     * @var array
     */
    public $inserts = [];

    /**
     * Array de valores para editar
     * @var array
     */
    public $updates = [];

    /**
     * Dato anterior al inicio del proceso por fecha
     * @var
     */
    public $previousData = null;

    /**
     * @param EtlConfig $etlConfig
     */
    public function setOptions(EtlConfig $etlConfig)
    {
        $this->etlConfig = $etlConfig;

        # Se crean los pasos que se requieren para Database
        $this->stepsList = $this->startSteps(new StepList());
    }

    /**
     * Punto de acceso para ejecutar funcionalidad
     */
    public function run()
    {
        # Se ejecutan los pasos que se requieren para el proceso
        $this->stepsList->runStartList($this->etlConfig->processState,$this);
    }

    /**
     * EL ORDEN DE LOS PASOS ES MUY IMPORTANTE
     * @param StepList $stepList
     * @return StepList
     */
    public function startSteps(StepList $stepList) : StepList
    {
        $stepList->addStep( new Step('stepConfigureArrayTime'));
        $stepList->addStep( new Step('stepConfigureArrayDate'));
        $stepList->addStep( new Step('stepExecuteHomogenization'));
        $stepList->addStep( new Step('stepUpdateElements'));
        $stepList->addStep( new Step('stepInsertElements'));
        $stepList->addStep( new Step('stepDeleteElements'));

        return $stepList;
    }

    /**
     * STEP
     * Se configuran los tiempos en los cuales se va a trabajar
     * @return array
     */
    public function stepConfigureArrayTime()
    {
        try {
            $this->arrayTime = $this->getStandardDataTime($this->timeSpace);

            return ['resultExecution' => true , 'data' => null, 'exception' => null];

        } catch (Exception $e) { return ['resultExecution' => false , 'data' => null, 'exception' => $e];}
    }

    /**
     * STEP
     * Se configuran las fechas en los cuales se va a trabajar
     * @return array
     */
    public function stepConfigureArrayDate()
    {
        try {

            $this->arrayDate = $this->getDateAndDateSk(
                $this->getSerializationDate(
                    $this->etlConfig->initialDate,
                    $this->etlConfig->finalDate,
                    $this->dateSpace
                )
            );

            return ['resultExecution' => true , 'data' => null, 'exception' => null];

        } catch (Exception $e) { return ['resultExecution' => false , 'data' => null, 'exception' => $e];}
    }

    /**
     * STEP
     * Se ejecuta el algoritmo de homogenización
     * @return array
     */
    public function stepExecuteHomogenization()
    {
        try {
            $this->homogenization();

            return ['resultExecution' => true , 'data' => null, 'exception' => null];

        } catch (Exception $e) { return ['resultExecution' => false , 'data' => null, 'exception' => $e];}
    }

    /**
     * STEP
     * @return array
     */
    public function stepUpdateElements()
    {
        try {
            foreach ($this->updates as $update) {
                $this->updateDateTimeFromId(
                    $update['value']->id,
                    [
                        'date_sk'   => $update['date_sk'],
                        'date'      => $update['date'],
                        'time_sk'   => $update['time_sk'],
                        'time'      => $update['time']
                    ]
                );
            }

            return ['resultExecution' => true , 'data' => null, 'exception' => null];

        } catch (Exception $e) { return ['resultExecution' => false , 'data' => null, 'exception' => $e];}
    }

    /**
     * STEP
     * @return array
     */
    public function stepInsertElements()
    {
        try {

            foreach ($this->inserts as $insert){ $this->insertDataArray($insert);}

            return ['resultExecution' => true , 'data' => null, 'exception' => null];

        } catch (Exception $e) { return ['resultExecution' => false , 'data' => null, 'exception' => $e];}
    }

    /**
     * STEP
     * eliminar elementos no pertenecientes a las series homogenizadas
     * @return array
     */
    public function stepDeleteElements()
    {
        try {

            $this->deleteEldestHomogenization(array_column($this->arrayTime,'time_sk'));

            return ['resultExecution' => true , 'data' => null, 'exception' => null];

        } catch (Exception $e) { return ['resultExecution' => false , 'data' => null, 'exception' => $e];}
    }

    /**
     *
     */
    public function homogenization()
    {
        $iterations = 1;

        # Se extrae de la bodega de datos el elemento exactamente anteior a la fecha de migracion
        $this->previousData = $this->getElementInFact($this->arrayDate[0]->date_sk -1 , $this->maxValueSk - $this->timeSpace + 1);

        #Se hace ciclo por cada dia en las fechas ingresadas
        foreach ($this->arrayDate as $date)
        {
            if ($iterations > 1){
               $this->previousData = $this->getElementInTemporal($date->date_sk -1 , $this->maxValueSk - $this->timeSpace + 1);
            }

            #contar la cantidad de horas en un dia
            $count = $this->countRowForDate($date->date_sk);

            if($count == 0){
                $this->pushAllInserts($date); #insertar todas las horas para una fecha que no trae nunguna hora
            }else{
                $this->cycleForTime($date); #Evaluar las diferentes opciones de cada hora
            }

            $iterations++;
        }
    }

    /**
     * Metodo para insertar un dia completo de horas
     * @param $date
     */
    public function pushAllInserts($date)
    {
        foreach ($this->arrayTime as $time) {
            array_push($this->inserts,['station_sk' => ($this->etlConfig->station)->id,'date_sk' => $date->date_sk,'date' => $date->date, 'time_sk' => $time->time_sk,'time' => $time->time]);
        }
    }

    /**
     * @param $date
     */
    public function cycleForTime($date)
    {
        foreach ($this->arrayTime as $time)
        {
           $upperLimit = $this->timeSpace + $time->time_sk;
           $lowerLimit = (($time->time_sk - $this->timeSpace) <= 0 ) ? 1 : $time->time_sk - $this->timeSpace;

            #Evaluar cantidad en el rango actual
            $valInRangeActual = $this->getValInRange($date->date_sk,$lowerLimit,$upperLimit);

            if ($time->time_sk == 1 and !is_null($this->previousData)){
                $temporalValInRange = [];
                array_push($temporalValInRange,$this->previousData);
                foreach ($valInRangeActual as $value){ array_push($temporalValInRange,$value); }
                $valInRangeActual = $temporalValInRange;
            }

            if (!is_null($valInRangeActual)) {
                # se evalua si el tiempo esta mal posicionado.
                if (!(in_array((array)$time,array_column( (!is_array($valInRangeActual)) ? $valInRangeActual->toArray() : $valInRangeActual,'time_sk')))){

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
    public function homogenizationNotElements($date, $time)
    {
        array_push($this->inserts,['date_sk'=> $date->date_sk,'date'=>$date->date,'time_sk'=> $time->time_sk, 'time'=> $time->time ]);
    }

    /**
     * @param $value
     * @param $date
     * @param $time
     */
    public function homogenizationOneElements($value, $date, $time)
    {
        if (!($value->time_sk == $time->time_sk)){
           array_push($this->updates, ['value'=> $value,'date_sk'=> $date->date_sk,'date'=>$date->date,'time_sk'=> $time->time_sk, 'time'=> $time->time ]);
        }
    }

    /**
     * @param $valueOne
     * @param $valueTwo
     * @param $date
     * @param $time
     */
    public function homogenizationTwoElements($valueOne, $valueTwo, $date, $time)
    {
        $arr = [];
        $arr['station_sk'] = $valueOne->station_sk;
        $arr['date_sk'] = $date->date_sk;
        $arr['date'] = $date->date;
        $arr['time_sk'] = $time->time_sk;
        $arr['time'] = $time->time;

        foreach ($this->etlConfig->varForFilter as $variable) {
            $arr[$variable->local_name] = $this->directionElements($variable->local_name,$valueOne,$valueTwo,$time->time_sk,$variable->decimal_precision);
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
        $arr['date_sk'] = $date->date_sk;
        $arr['date'] = $date->date;
        $arr['time_sk'] = $time->time_sk;
        $arr['time'] = $time->time;

        # se particionan dependiendo de si son mayores o menores.
        foreach ($valInRangeActual as $value){array_push(${($value->time_sk <= $time->time_sk) ? 'arrLower' : 'arrHigher' } , $value);}

        foreach ($this->etlConfig->varForFilter as $variable)
        {
            $arr[$variable->local_name] = $this->directionElements(
                $variable->local_name,
                (float)(count($arrLower) > 1) ? $this->findNearestValue($variable->local_name,$arrLower,$time->time_sk) : $arrLower[0],
                (float)(count($arrHigher) > 1) ? $this->findNearestValue($variable->local_name,$arrHigher,$time->time_sk) : $arrHigher[0],
                $time->time_sk,
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
                $value = $this->executeFormula(
                    (float)$valueOne->{$variableName},
                    (float)$valueTwo->{$variableName},
                    $valueOne->time_sk,
                    $valueTwo->time_sk,
                    $time,
                    $decimalPrecision
                );
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

    /**
     * @param int $dateSpace
     */
    public function setDateSpace(int $dateSpace)
    {
        $this->dateSpace = $dateSpace;
    }

    /**
     * @param int $timeSpace
     */
    public function setTimeSpace(int $timeSpace)
    {
        $this->timeSpace = $timeSpace;
    }
}