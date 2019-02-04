<?php

namespace App\Etl\Execution\Options\FilterOptions;

use App\Etl\Execution\Generator\EtlGeneratorConfig;

class FilterWeatherOption extends EtlGeneratorConfig implements FilterOptionContract
{
    /**
     * @var
     */
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
     * FilterAirOption constructor.
     * @param $stationOrStations
     * @param string $initialDate
     * @param string $finalDate
     */
    public function __construct($stationOrStations,string $initialDate,string $finalDate)
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
    public function runConfig(string $typeProcess,array $executionParams): array
    {
        return $this->setTypeProcess($typeProcess)
            ->setGeneralOptions($executionParams)
            ->setExtractor('Database')
            ->addExtractorVariable('initialDate',$this->initialDate)
            ->addExtractorVariable('finalDate',$this->finalDate)
            ->addExtractorVariable('extractType','Local')
            ->addTransform('FilterDetection',[])
            ->addTransform('FilterCorrection',[])
            ->addTransform('Homogenization',[])
            ->config($this->stationOrStations);
    }
}