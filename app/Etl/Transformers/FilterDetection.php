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

            $this->updateForNull($this->etlConfig->getTableSpaceWork(),$value->name_locale);

            $correctValues= $this->overflow(
                                $this->etlConfig->getTableSpaceWork(),
                                $value->name_locale,
                                $value->maximum,
                                $value->minimum,
                                $value->previous_difference
                            );
            dd($correctValues); // estos son los valores correctos deben ir a trust

        }

        return $this;
    }



}