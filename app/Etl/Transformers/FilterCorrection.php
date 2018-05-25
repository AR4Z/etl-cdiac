<?php


namespace App\Etl\Transformers;

use App\Etl\EtlConfig;
use App\Etl\Traits\CorrectMethod;

class FilterCorrection extends TransformBase implements TransformInterface
{
    use CorrectMethod;

    public $method = 'Correction';

    public $etlConfig = null;

    /**
     * @param EtlConfig $etlConfig
     * @return mixed
     */
    public function setOptions(EtlConfig $etlConfig)
    {
        $this->etlConfig = $etlConfig;

        return $this;
    }

    public function run()
    {
        $varFilter = $this->etlConfig->getVarForFilter();

        foreach ($varFilter as $variable){
            if ($variable->correction_type){
                $this->correctControl(
                    $this->etlConfig->getTableSpaceWork(),
                    $variable,
                    $this->etlConfig->getIncomingAmount()
                );
            }
        }

    }

}