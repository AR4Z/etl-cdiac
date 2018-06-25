<?php

namespace App\Etl\Transformers;

use App\Etl\EtlConfig;
use App\Etl\Traits\CorrectMethod;
use function Couchbase\defaultDecoder;


class FilterAir extends TransformBase implements TransformInterface
{
    use CorrectMethod;

    public $method = 'FilterAir';

    public $etlConfig = null;

    public $paramSearch = ['Samp<', 'InVld', 'RS232', 'OffScan','-','Sin Dato','NA'];

    public $deleteLastHour = ['Span','Zero'];

    public $spaceTimeDelete = 3600; # Tiempo a eliminar en segundos (una hora)

    public $changeOverflowLower = 0;

    public $changeOverflowHigher = null;

    public $changeOverflowPreviousDeference = null;

    public $variablesCalculated = [
        'so2_local_ppb' => ['destiny' => 'so2_estan_ugm3', 'factor' =>  2.62],
        'o3_local_ppb'  => ['destiny' => 'o3_estan_ugm3', 'factor' =>   1.96],
        'co_local_ppb'  => ['destiny' => 'co_estan_ugm3', 'factor' =>   1.14],
    ];

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
        $variablesCalculatedName = array_keys($this->variablesCalculated);

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

            # Insertar datos calculados
            if (in_array($value->local_name,$variablesCalculatedName)){
                $this->generateVariableCalculated(
                    $this->etlConfig->getTableSpaceWork(),
                    $value->local_name,
                    $this->variablesCalculated[$value->local_name]
                );
            }

            # Insertar los valores correctos deben ir a trust
            $this->trustProcess($value);
        }
    }
}