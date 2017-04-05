<?php

namespace App\Etl\Transformers;


use App\Etl\EtlConfig;


class Original extends TransformBase implements TransformInterface
{

    /**
     * @param EtlConfig $etlConfig
     * @return mixed
     */
    public function setOptions(EtlConfig $etlConfig)
    {
        return $this;
    }
    public function transform()
    {
        return $this;
    }
}