<?php


namespace App\Etl\Transformers;

use App\Etl\EtlConfig;

class FilterDetection extends TransformBase implements TransformInterface
{
    public $method = 'Detection';

    public $etlConfig = null;

    public $paramSearch = ['-'];

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

        return $this;
    }

}