<?php


namespace App\Etl\Transformers;


use App\Etl\EtlConfig;
use App\Etl\Traits\CorrectMethod;

class FilterCorrection extends TransformBase implements TransformInterface
{
    use CorrectMethod;

    private $method = 'Correction';

    private $etlConfig = null;

    /**
     * @param EtlConfig $etlConfig
     * @return mixed
     */
    public function setOptions(EtlConfig $etlConfig)
    {
        $this->etlConfig = $etlConfig;

        return $this;
    }

    public function transform()
    {
        $varFilter = $this->etlConfig->getVarForFilter();

        foreach ($varFilter as $variable)
        {
            switch ($variable->correction_type){
                case "promedio":
                    $this->correctAverageData();
                    break;
                case  "dato_anterior":
                    $this->correctPreviousData($this->etlConfig->getTrustRepository(),$this->etlConfig->getTableSpaceWork(),$variable->name_locale);
                    break;
                case "diferencia_de_0,2":
                    $this->correctDifferenceData();
                    break;
                case "a_cero":
                    $this->correctToZeroData();
                default:
                    // Metodo de correccion no encontrado

            }
        }
    }

}