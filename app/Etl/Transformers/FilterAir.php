<?php

namespace App\Etl\Transformers;

use App\Etl\EtlConfig;
use App\Etl\Traits\CorrectMethod;


class FilterAir extends TransformBase implements TransformInterface
{
    use CorrectMethod;

    public $method = 'FilterAir';

    public $etlConfig = null;

    public $paramSearch = ['Samp<', 'InVld', 'RS232', 'OffScan','-'];

    public $deleteLastHour = ['Span','Zero'];

    public $spaceTimeDelete = 3600; # Tiempo a eliminar en segundos (una hora)

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

    public function run()
    {
        $varFilter = $this->etlConfig->getVarForFilter();

        foreach ($varFilter as $value)
        {
            # Convertir valores extraños a null
            $this->updateForNull($this->etlConfig->getTableSpaceWork(),$value->local_name,$this->paramSearch);

            # Eliminar los datos por una hora despues $deleteLastHour
            $this->updateRageTime(
                $this->etlConfig->getTableSpaceWork(),
                $value->local_name,
                $this->deleteLastHour,
                $this->spaceTimeDelete
            );

            # Cambiar las comas por puntos
            $this->changeCommaForPoint($this->etlConfig->getTableSpaceWork(),$value->local_name);

            # Detectar los valores que sobrepasan los limites
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

            # Insertar los valores correctos deben ir a trust
            $this->trustProcess($value->local_name);
        }
    }
}