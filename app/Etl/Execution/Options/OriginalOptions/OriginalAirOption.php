<?php

namespace App\Etl\Execution\Options\OriginalOptions;

use App\Etl\Execution\Generator\EtlGeneratorConfig;

class OriginalAirOption extends EtlGeneratorConfig implements OriginalOptionContract
{
    /**
     * @var int
     */
    private $station;
    /**
     * @var string
     */
    private $initialDate;
    /**
     * @var string
     */
    private $finalDate;
    /**
     * @var string
     */
    private $fileName;
    /**
     * @var string
     */
    private $extension;

    /**
     * OriginalAirOption constructor.
     * @param int $station
     * @param string $extension
     * @param string $fileName
     * @param string $initialDate
     * @param string $finalDate
     */
    public function __construct(int $station, string $extension, string $fileName, string $initialDate, string $finalDate)
    {
        $this->station = $station;
        $this->initialDate = $initialDate;
        $this->finalDate = $finalDate;
        $this->fileName = $fileName;
        $this->extension = $extension;
    }

    /**
     * @param string $typeProcess
     * @param array $executionParams
     * @return array
     */
    public function runConfig(string $typeProcess, array $executionParams): array
    {
        return $this->setTypeProcess($typeProcess)
            ->setGeneralOptions($executionParams)
            ->setExtractor('Csv',$this->initialDate,$this->finalDate)
            ->addExtractorVariable('extractType','Local')
            ->addExtractorVariable('extension',$this->extension)
            ->addExtractorVariable('fileName',$this->fileName)
            ->addTransform('Original',[])
            ->setSpaceDayExecution(-1)
            ->config($this->station);
    }
}