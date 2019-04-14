<?php

namespace App\Etl\Transformers;

use App\Etl\EtlConfig;
use App\Etl\Steps\{StepList,Step,StepContract};
use Exception;
use Nexmo\Call\Collection;

class Homogenization extends TransformBase implements TransformInterface, StepContract
{
    /**
     * @var string
     */
    public $method = 'Homogenization';

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
     * Intervalo de Serialización (time) en segundos para el caso en que solo existan un valor en el rango $timeSapce
     * @var int
     */
    public $timeSpaceOneMissingData = 150;

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
     * Punto de acceso para ejecutar funcionalidad
     */
    public function run()
    {
        # Se crean los pasos que se requieren para Database
        $this->stepsList = $this->startSteps(new StepList());

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
                $this->getSerializationDate($this->etlConfig->initialDate, $this->etlConfig->finalDate, $this->dateSpace)
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
                $this->updateDateTimeFromIdWDT(
                    $this->etlConfig->repositorySpaceWork,
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

            foreach ($this->inserts as $insert){ $this->insertDataArrayWDT($this->etlConfig->repositorySpaceWork,$insert);}

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

            $this->deleteEldestHomogenizationWDT($this->etlConfig->repositorySpaceWork,array_column($this->arrayTime,'time_sk'));

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
        foreach ($this->arrayDate as $date) {
            if ($iterations > 1){
               $this->previousData = $this->getElementInTemporal($date->date_sk -1 , $this->maxValueSk - $this->timeSpace + 1);
            }

            #contar la cantidad de horas en un dia
            $count = $this->etlConfig->repositorySpaceWork->countRowForDate($date->date_sk);

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
            $this->inserts[] = ['station_sk' => $this->etlConfig->station->id,'date_sk' => $date->date_sk,'date' => $date->date, 'time_sk' => $time->time_sk,'time' => $time->time];
        }
    }

    /**
     * @param $date
     */
    public function cycleForTime($date)
    {
        foreach ($this->arrayTime as $time) {

            #Evaluar cantidad en el rango actual
            $valInRangeActual = $this->etlConfig->repositorySpaceWork->getValInRange(
                $this->etlConfig->station->id,
                $date->date_sk,
                (($time->time_sk - $this->timeSpace) <= 0 ) ? 1 : $time->time_sk - $this->timeSpace,
                $this->timeSpace + $time->time_sk
            );

            # Primer caso: cuando es la primera hora del dia
            if ($time->time_sk == 1 and !is_null($this->previousData)){

                # Se inicializa el array temporal para almacenar los valores
                $temporalValInRange = [];

                # se inserta el ultimo valor de la fecha anterior al array temporal
                $temporalValInRange[] = $this->previousData;

                # se recorren los valores en el array de valores de la fecha actual en el rango inicial y se insertan al array temporal
                foreach ($valInRangeActual as $value){ $temporalValInRange[] = $value; }

                # se asigna el array temporal al array al array public para enviarlo en las funciones de homogenizacion
                $valInRangeActual = $temporalValInRange;
            }

            if (!is_null($valInRangeActual)){
                $this->homogenizationDirection((is_array($valInRangeActual)) ? $valInRangeActual : $valInRangeActual->toArray(),$date,$time);
            }
        }
    }

    /**
     * @param array $valInRangeActual
     * @param object $date ['date_sk'=> 'value','date'=> value]
     * @param object $time ['time_sk'=> 'value','time'=> value]
     */
    public function homogenizationDirection(array $valInRangeActual, object $date,object $time) : void
    {
        # se evalua si el tiempo esta mal posicionado.
        if (!(in_array((array)$time,array_column( (!is_array($valInRangeActual)) ? $valInRangeActual : $valInRangeActual,'time_sk')))){

            switch (count($valInRangeActual)) {
                case 0:
                    $this->homogenizationNotElements($this->etlConfig->station->id,$date,$time);
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

    /**
     * @param int $stationSk
     * @param $date
     * @param $time
     */
    public function homogenizationNotElements(int $stationSk,$date, $time) : void
    {
        $this->inserts[] = ['station_sk'=> $stationSk,'date_sk'=> $date->date_sk,'date'=>$date->date,'time_sk'=> $time->time_sk, 'time'=> $time->time ];
    }

    /**
     * @param $value
     * @param $date
     * @param $time
     */
    public function homogenizationOneElements($value, $date, $time)
    {
        # pivotTime: bandera para evaluar la diferencia real entre dos time_sk teniendo en cuenta las fechas diferentes
        $pivotTime = ($value->date_sk == $date->date_sk) ? $time->time_sk : $this->maxValueSk - $time->time_sk;

        if (!($value->time_sk == $time->time_sk)){
            if ($this->validateTimeSpaceOneMissingData($pivotTime,$value->time_sk)){
                $this->updates[] = ['value'=> $value,'date_sk'=> $date->date_sk,'date'=>$date->date,'time_sk'=> $time->time_sk, 'time'=> $time->time ];
            }else{
                $this->homogenizationNotElements($this->etlConfig->station->id,$date,$time);
            }
        }
    }

    /**
     * @param $valueOne
     * @param $valueTwo
     * @param $date
     * @param $time
     */
    public function homogenizationTwoElements(object $valueOne,object $valueTwo,object $date,object $time)
    {
        $arr = $this->formatActualElement($valueOne->station_sk,$date->date_sk,$time->time_sk,$date->date,$time->time);

        foreach ($this->etlConfig->varForFilter as $variable) {
            $arr[$variable->local_name] = $this->directionElements(
                $variable->local_name,
                $time->time_sk,
                (!is_null($valueOne->{$variable->local_name})) ? $valueOne : null,
                (!is_null($valueTwo->{$variable->local_name})) ? $valueTwo : null,
                $variable->decimal_precision
            );
        }
        $this->inserts[] = $arr;
    }

    /**
     * @param $valInRangeActual
     * @param $date
     * @param $time
     */
    public function homogenizationMultipleElements($valInRangeActual, $date, $time) : void
    {
        $arr = $this->formatActualElement($valInRangeActual[0]->station_sk,$date->date_sk,$time->time_sk,$date->date,$time->time);

        $arrPartition = $this->partitionArrayForTime($valInRangeActual,$time->time_sk);

        foreach ($this->etlConfig->varForFilter as $variable){
            $arr[$variable->local_name] = $this->directionElements(
                $variable->local_name,
                $time->time_sk,
                $this->findNearestValue($variable->local_name,$arrPartition['arrLower'],$time->time_sk),
                $this->findNearestValue($variable->local_name,$arrPartition['arrHigher'],$time->time_sk),
                $variable->decimal_precision
            );
        }
        $this->inserts[] = $arr;
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
    private function executeFormula(float $v1, float $v2, int $t1, int $t2, int $t3, int $round = 2) : float
    {
        return round(($v1 + (($v2 - $v1)/($t2 - $t1)) * ($t3 - $t1)),2);
    }

    /**
     * @param string $variableName
     * @param array $arr
     * @param int $time
     * @return object
     */
    private function findNearestValue(string $variableName, array $arr, int $time)
    {
        if (count($arr) == 0){ return null;}

        if (count($elements = $this->extractNotNullVariable($variableName,$arr)) == 0){ return null;}

        $value = $this->validateTheClosest($elements,$time);

        return (object)['time_sk' => $value->time_sk, $variableName => $value->{$variableName}];
    }

    /**
     * @param array $elements
     * @param int $time
     * @return object
     */
    private  function validateTheClosest(array $elements, int $time) : object
    {
        $val = $elements[0];
        for ($i = 1; $i < count($elements); $i++) { if ($this->validateTime($time,$val->time_sk,$elements[$i]->time_sk)){$val = $elements[$i];}}
        return $val;
    }

    /**
     * @param string $variableName
     * @param array $objectiveValidate
     * @return array
     */
    private function extractNotNullVariable(string $variableName, array $objectiveValidate) : array
    {
       $arr = [];
       foreach ($objectiveValidate as $value){ if (!is_null($value->{$variableName})){ $arr[] = $value;}}
       return $arr;
    }

    /**
     * @param string $variableName
     * @param int $time
     * @param object $valLower
     * @param object $valHigher
     * @param int $decimalPrecision
     * @return float|null
     */
    private function directionElements(string $variableName, int $time, object $valLower = null,object $valHigher = null,int $decimalPrecision = 2)
    {
        if (is_null($valLower) and is_null($valHigher)){ return null;}

        if (!is_null($valLower) and is_null($valHigher)){ return ($this->validateTimeSpaceOneMissingData($time,$valLower->time_sk)) ? $valLower->{$variableName} : null;}

        if (is_null($valLower) and !is_null($valHigher)){ return ($this->validateTimeSpaceOneMissingData($time,$valHigher->time_sk)) ? $valHigher->{$variableName} : null;}

        return $this->executeFormula((float)$valLower->{$variableName},(float)$valHigher->{$variableName}, $valLower->time_sk, $valHigher->time_sk, $time, $decimalPrecision);
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

    /**
     * @param int $stationSk
     * @param int $dateSk
     * @param int $timeSk
     * @param string $date
     * @param string $time
     * @return array
     */
    private function formatActualElement(int $stationSk, int $dateSk, int $timeSk, string $date, string $time) : array
    {
        return ['station_sk'=> $stationSk,'date_sk'=> $dateSk,'date'=> $date,'time_sk'=> $timeSk,'time'=> $time];
    }

    /**
     * @param array $valInRangeActual
     * @param int $timeSk
     * @return array
     */
    private function partitionArrayForTime(array $valInRangeActual, int $timeSk) : array
    {
        $arr = ['arrLower' => [],'arrHigher' => []];
        foreach ($valInRangeActual as $value){ $arr[($value->time_sk <= $timeSk) ? 'arrLower' : 'arrHigher'][] = $value;}
        return $arr;
    }

    /**
     * @param int $timeBase
     * @param int $timeObjective
     * @return bool
     */
    private function validateTimeSpaceOneMissingData(int $timeBase, int $timeObjective) : bool
    {
        return (abs($timeBase - $timeObjective)<= $this->timeSpaceOneMissingData);
    }

    /**
     * @param int $timeObjective
     * @param int $timeActual
     * @param int $timeIncoming
     * @return bool
     */
    private function validateTime(int $timeObjective, int $timeActual, int $timeIncoming) : bool
    {
        return abs($timeObjective - $timeIncoming) < abs($timeObjective - $timeActual);
    }
}