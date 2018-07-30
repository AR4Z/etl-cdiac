<?php


namespace App\Etl\Transformers;

use App\Etl\EtlConfig;

class FilterCorrection extends TransformBase implements TransformInterface
{
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

    public function ExecuteFilterWindSpeedZero($varFilter)
    {
        if (is_numeric (array_search('wind_speed', array_column($varFilter,'local_name')))){
            $this->filterWindSpeedZero();
        }
    }
}