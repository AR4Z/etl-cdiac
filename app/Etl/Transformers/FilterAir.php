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
     * @var EtlConfig
     */
    public $etlConfig = null;

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
     * @param EtlConfig $etlConfig
     */
    public function setOptions(EtlConfig $etlConfig)
    {
        $this->etlConfig = $etlConfig;

        # Se crean los pasos que se requieren para Database
        $this->stepsList = $this->startSteps(new StepList());
    }

    /**
     *
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
        $stepList->addStep( new Step('stepGoThroughVariablesAndFilter'));

        return $stepList;
    }

    /**
     * STEP
     *
     * @return array
     */
    public function stepConfigureArrayTime()
    {
        try {

            $this->goFilters();

            return ['resultExecution' => true , 'data' => null, 'exception' => null];

        } catch (Exception $e) { return ['resultExecution' => false , 'data' => null, 'exception' => $e];}
    }



    public function insertCalculateData(string $localName, array $variablesCalculatedName)
    {
        if (in_array($localName,$variablesCalculatedName)){
            $this->generateVariableCalculated(
                $this->etlConfig->getTableSpaceWork(),
                $localName,
                $this->variablesCalculated[$localName]
            );
        }
    }

    public function goFilters()
    {
        $varFilter = $this->etlConfig->getVarForFilter();
        $variablesCalculatedName = array_keys($this->variablesCalculated);

        foreach ($varFilter as $value)
        {
            # Convertir valores extraños a null
            $this->updateForNull($this->etlConfig->getTableSpaceWork(),$value->local_name,$this->paramSearch);

            # Eliminar los datos por una hora despues $deleteLastHour
            $this->updateRageTime(
                $this->etlConfig->getTableSpaceWork(),
                $value->local_name,
                $this->deleteLastHour,
                $this->spaceTimeDelete
            );

            # Detectar los valores que sobrepasan los limites
            $this->overflow(
                $this->etlConfig->getTableSpaceWork(),
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