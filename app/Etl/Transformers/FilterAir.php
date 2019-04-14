<?php

namespace App\Etl\Transformers;

use App\Etl\EtlConfig;
use App\Etl\Steps\{StepList,Step,StepContract};
use Exception;

class FilterAir extends TransformBase implements TransformInterface, StepContract
{
    /**
     * @var string
     */
    public $method = 'FilterAir';

    /**
     * @var StepList
     */
    public $stepsList = null;

    /**
     * @var array
     */
    public $paramSearch = ['Samp<', 'InVld', 'RS232', 'OffScan','-','Sin Dato','NA'];

    /**
     * @var array
     */
    public $deleteLastHour = ['Span','Zero','Cero','Muestra<'];

    /**
     *  Tiempo a eliminar en segundos (una hora)
     * @var int
     */
    public $spaceTimeDelete = 3600;

    /**
     * @var int
     */
    public $changeOverflowLower = 0;

    /**
     * @var int
     */
    public $changeOverflowHigher = null;

    /**
     * @var int
     */
    public $changeOverflowPreviousDeference = null;

    /**
     * @var array
     */
    public $variablesCalculated = [
        'so2_local_ppb' => ['destiny' => 'so2_estan_ugm3', 'factor' =>  2.62],
        'o3_local_ppb'  => ['destiny' => 'o3_estan_ugm3', 'factor' =>   1.96],
        'co_local_ppb'  => ['destiny' => 'co_estan_ugm3', 'factor' =>   1.14],
    ];

    /**
     *
     */
    public function run() : void
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
        $stepList->addStep( new Step('stepGoThroughVariablesAndFilter'));

        return $stepList;
    }

    /**
     * STEP
     *
     * @return array
     */
    public function stepConfigureArrayTime() : array
    {
        try {

            $this->goFilters();

            return ['resultExecution' => true , 'data' => null, 'exception' => null];

        } catch (Exception $e) { return ['resultExecution' => false , 'data' => null, 'exception' => $e];}
    }

    /**
     * @param array $paramSearch
     */
    public function setParamSearch(array $paramSearch = []) : void
    {
        foreach ($paramSearch as $param){ $this->paramSearch[] = $param; }
    }

    /**
     * @param array $deleteLastHour
     */
    public function setDeleteLastHour(array $deleteLastHour = []) : void
    {
        foreach ($deleteLastHour as $param){ $this->deleteLastHour[] = $param; }
    }

    /**
     * @param int $spaceTimeDelete
     */
    public function setSpaceTimeDelete(int $spaceTimeDelete = 3600) : void
    {
        $this->spaceTimeDelete = $spaceTimeDelete;
    }

    /**
     * @param int $changeOverflowLower
     */
    public function setChangeOverflowLower(int $changeOverflowLower = null) : void
    {
        $this->changeOverflowLower = $changeOverflowLower;
    }

    /**
     * @param int $changeOverflowPreviousDeference
     */
    public function setChangeOverflowPreviousDeference(int $changeOverflowPreviousDeference = null) : void
    {
        $this->changeOverflowPreviousDeference = $changeOverflowPreviousDeference;
    }

    /**
     * @param array $variablesCalculated
     */
    public function setVariablesCalculated(array $variablesCalculated = []) : void
    {
        foreach ($variablesCalculated as $key => $value){ $this->variablesCalculated[] = [$key => $value]; }
    }


    /**
     * @param string $localName
     * @param array $variablesCalculatedName
     */
    private function insertCalculateData(string $localName, array $variablesCalculatedName) : void
    {
        if (in_array($localName,$variablesCalculatedName)){
            $this->generateVariableCalculatedWDT($this->etlConfig->repositorySpaceWork, $localName, $this->variablesCalculated[$localName]);
        }
    }

    /**
     *
     */
    private function goFilters() : void
    {
        $varFilter = $this->etlConfig->varForFilter;
        $variablesCalculatedName = array_keys($this->variablesCalculated);

        foreach ($varFilter as $value) {
            # Convertir valores extraños a null
            $this->updateForNull($value->local_name,$this->paramSearch);

            # Eliminar los datos por una hora despues $deleteLastHour
            $this->updateRageTime($value->local_name, $this->deleteLastHour, $this->spaceTimeDelete);

            # Detectar los valores que sobrepasan los limites
            $this->overflow(
                $value->local_name,
                $value->maximum,
                $value->minimum,
                $value->previous_deference,
                $this->changeOverflowLower,
                $this->changeOverflowHigher,
                $this->changeOverflowPreviousDeference
            );

            # Insertar datos calculados
            $this->insertCalculateData($value->local_name,$variablesCalculatedName);

            # Insertar los valores correctos deben ir a trust
            $this->trustProcess($value);
        }
    }
}