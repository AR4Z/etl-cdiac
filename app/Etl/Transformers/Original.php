<?php

namespace app\Etl\Transformers;


use App\Etl\EtlConfig;
use App\Etl\Transform\TransformInterface;

class Original extends TansformBase implements TransformInterface
{

    /**
     * @param EtlConfig $etlConfig
     * @return mixed
     */
    public function setOptions(EtlConfig $etlConfig)
    {
        return $this;
    }
}