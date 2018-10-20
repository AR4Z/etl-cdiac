<?php


namespace App\Etl\Transformers;

use App\Etl\EtlConfig;
use App\Etl\Steps\{StepList,Step,StepContract};
use Exception;

class FilterDetection extends TransformBase implements TransformInterface, StepContract
{
    /**
     * @var string
     */
    public $method = 'Detection';

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
    public $paramSearch = ['-'];

    /**
     * @var array
     */
    public $commentFilters = ['CappedRainGauge'];

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
     * @param EtlConfig $etlConfig
     * @return mixed
     */
    public function setOptions(EtlConfig $etlConfig)
    {
        $this->etlConfig = $etlConfig;

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
        $stepList->addStep( new Step('stepExecuteCementFilters'));
        $stepList->addStep( new Step('stepTraverseDynamicVariablesToFilter'));
        $stepList->addStep( new Step('stepTraverseStaticVariablesToFilter'));

        return $stepList;
    }

    /**
     * @param $varFilter
     */
    public function ExecuteFilterCappedRainGauge($varFilter)
    {
        if (is_numeric (array_search('rainfall', array_column($varFilter,'local_name')))){
            $this->filterCappedRainGauge(['rainfall' => null,'accumulated_rainfall' => null]);
        }
    }

    /**
     *  STEP
     *  Ejecutar los filtros definidos para el campo de comentarios
     *  @return array
     */
    public function stepExecuteCementFilters()
    {
        try {
            # Se extraen las variables a evaluar
            $varFilter = $this->etlConfig->varForFilter->toArray();

            # Se evaluan los filtros registrados para el campo de comentarios.
            foreach ($this->commentFilters as $filter){ $this->{'ExecuteFilter'.$filter}($varFilter); }

            return ['resultExecution' => true , 'data' => null, 'exception' => null];

        } catch (Exception $e) { return ['resultExecution' => false , 'data' => null, 'exception' => $e]; }
    }

    /**
     *  STEP
     *  Convertir valores extraños a null
     *  Detectar los valores que sobrepasan los limites
     *  insertar los valores correctos deben ir a trust
     *  @return array
     */
    public function stepTraverseDynamicVariablesToFilter()
    {
        try {

            foreach ($this->etlConfig->varForFilter as $value){

                # Convertir valores extraños a null
                $this->updateForNull($value->local_name,$this->paramSearch);

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

                # insertar los valores correctos deben ir a trust
                $this->trustProcess($value);
            }

            return ['resultExecution' => true , 'data' => null, 'exception' => null];

        } catch (Exception $e) { return ['resultExecution' => false , 'data' => null, 'exception' => $e]; }
    }

    /**
     * STEP
     *
     * @return array
     */
    public function stepTraverseStaticVariablesToFilter()
    {
        try {
            # se extraen las variables estaticas
            $staticVariables = $this->etlConfig->keys->notCalculatedColumns;

            foreach ($staticVariables as $variable){ $this->updateForNull($variable,$this->paramSearch);}

            return ['resultExecution' => true , 'data' => null, 'exception' => null];

        } catch (Exception $e) { return ['resultExecution' => false , 'data' => null, 'exception' => $e]; }
    }

    /**
     * @param array $paramSearch
     */
    public function setParamSearch(array $paramSearch = [])
    {
        foreach ($paramSearch as $value){ array_push($this->paramSearch,$value);}
    }

    /**
     * @param array $commentFilters
     */
    public function setCommentFilters(array $commentFilters = [])
    {
        foreach ($commentFilters as $value){ array_push($this->commentFilters,$value);}
    }

    /**
     * @param int $changeOverflowLower
     */
    public function setChangeOverflowLower(int $changeOverflowLower)
    {
        $this->changeOverflowLower = $changeOverflowLower;
    }

    /**
     * @param int $changeOverflowHigher
     */
    public function setChangeOverflowHigher(int $changeOverflowHigher)
    {
        $this->changeOverflowHigher = $changeOverflowHigher;
    }

    /**
     * @param int $changeOverflowPreviousDeference
     */
    public function setChangeOverflowPreviousDeference(int $changeOverflowPreviousDeference)
    {
        $this->changeOverflowPreviousDeference = $changeOverflowPreviousDeference;
    }

}