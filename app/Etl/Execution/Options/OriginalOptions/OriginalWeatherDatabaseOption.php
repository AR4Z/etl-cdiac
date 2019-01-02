<?php

namespace App\Etl\Execution\Options\OriginalOptions;


use App\Etl\Execution\Generator\EtlGeneratorConfig;

class OriginalWeatherDatabaseOption extends EtlGeneratorConfig implements OriginalOptionContract
{

    private $stationOrStations;
    /**
     * @var string
     */
    private $initialDate;
    /**
     * @var string
     */
    private $finalDate;

    /**
     * OriginalWeatherDatabaseOption constructor.
     * @param $stationOrStations
     * @param string $initialDate
     * @param string $finalDate
     */
    public function __construct($stationOrStations, string $initialDate, string  $finalDate)
    {
        $this->stationOrStations = $stationOrStations;
        $this->initialDate = $initialDate;
        $this->finalDate = $finalDate;
    }

    /**
     * @param string $typeProcess
     * @param array $executionParams
     * @return array
     */
    public function runConfig(string $typeProcess, array $executionParams): array
    {
        $this->setTypeProcess($typeProcess)
            ->setGeneralOptions($executionParams)
            ->setExtractor('Database',$this->initialDate,$this->finalDate)
            ->addTransform('Original',[])
            ->config($this->stationOrStations);
    }
}