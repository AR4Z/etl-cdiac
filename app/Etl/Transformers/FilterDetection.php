<?php


namespace App\Etl\Transformers;


use App\Etl\EtlConfig;
use App\Etl\Traits\TrustTrait;

class FilterDetection extends TransformBase implements TransformInterface
{
    use TrustTrait;

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

            $this->overflow(
                    $this->etlConfig->getTableSpaceWork(),
                    $value->name_locale,
                    $value->maximum,
                    $value->minimum,
                    $value->previous_difference
             );

            // estos son los valores correctos deben ir a trust
            $this->insertGoods(
                    $this->etlConfig->getTrustRepository(),
                    $this->etlConfig->getTableSpaceWork(),
                    $this->etlConfig->getTableTrust(),
                    $value->name_locale
            );

            dd($this);

        }

        return $this;
    }



}