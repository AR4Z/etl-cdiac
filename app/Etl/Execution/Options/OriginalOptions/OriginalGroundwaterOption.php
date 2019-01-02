<?php

namespace App\Etl\Execution\Options\OriginalOptions;


use App\Etl\Execution\Generator\EtlGeneratorConfig;

class OriginalGroundwaterOption extends EtlGeneratorConfig implements OriginalOptionContract
{
    /**
     * @var int
     */
    private $station;
    /**
     * @var string
     */
    private $fileName;
    /**
     * @var string
     */
    private $initialDate;
    /**
     * @var string
     */
    private $finalDate;

    /**
     * OriginalGroundwaterOption constructor.
     * @param int $station
     * @param string $fileName
     * @param string $initialDate
     * @param string $finalDate
     */
    public function __construct(int $station, string $fileName, string $initialDate, string $finalDate)
    {
        $this->station = $station;
        $this->fileName = $fileName;
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
            ->setExtractor('Csv',$this->initialDate,$this->finalDate)
            ->addExtractorVariable('fileName',$this->fileName)
            ->addTransform('Original',[])
            ->config($this->station);
    }
}