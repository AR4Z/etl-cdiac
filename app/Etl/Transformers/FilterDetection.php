<?php


namespace App\Etl\Transformers;

use App\Etl\EtlConfig;

class FilterDetection extends TransformBase implements TransformInterface
{
    public $method = 'Detection';

    public $etlConfig = null;

    public $paramSearch = ['-'];

    public $commentFilters = ['CappedRainGauge'];

    public $changeOverflowLower = 0;

    public $changeOverflowHigher = null;

    public $changeOverflowPreviousDeference = null;

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
     *
     */
    public function run()
    {
        $varFilter = $this->etlConfig->getVarForFilter();

        # Ejecutar los filtros definidos para el campo de comentarios
        foreach ($this->commentFilters as $filter){ $this->{'ExecuteFilter'.$filter}($varFilter->toArray()); }

        foreach ($varFilter as $value){

            # Convertir valores extraños a null
            $this->updateForNull($this->etlConfig->getTableSpaceWork(),$value->local_name,$this->paramSearch);

            // detectar los valores que sobrepasan los limites
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

            // insertar los valores correctos deben ir a trust
            $this->trustProcess($value);
        }

        $staticVariables = $this->etlConfig->getKeys()->notCalculatedColumns;

        foreach ($staticVariables as $variable){
            $this->updateForNull($this->etlConfig->getTableSpaceWork(),$variable,$this->paramSearch);
        }

        return $this;
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

}