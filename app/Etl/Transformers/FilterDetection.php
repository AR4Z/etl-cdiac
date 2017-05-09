<?php


namespace App\Etl\Transformers;


use App\Etl\EtlConfig;

class FilterDetection extends TransformBase implements TransformInterface
{

    private $method = 'Detection';

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

    /**
     *
     */
    public function transform()
    {
        //dd($this);

        $varFilter = $this->etlConfig->getVarForFilter();

        foreach ($varFilter as $value){

            if (!is_null($value->minimum))
            {
                $this->overflowMaximum($this->etlConfig->getRepositorySpaceWork(),$this->etlConfig->getTableSpaceWork(),$value->name_locale,$value->maximum);
            }
            if (!is_null($value->maximum)){
                $this->overflowMinimum($this->etlConfig->getRepositorySpaceWork(),$this->etlConfig->getTableSpaceWork(),$value->name_locale,$value->minimum);
            }
            if (!is_null($value->previous_difference)){}

        }

        return $this;
    }



}