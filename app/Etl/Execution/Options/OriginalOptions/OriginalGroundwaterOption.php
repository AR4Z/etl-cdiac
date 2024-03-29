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
     * OriginalGroundwaterOption constructor.
     * @param int $station
     * @param string $fileName
     */
    public function __construct(int $station, string $fileName)
    {
        $this->station = $station;
        $this->fileName = $fileName;
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
            ->setExtractor('Plane')
            ->addExtractorVariable('fileName',$this->fileName)
            ->addTransform('Original',[])
            ->setSpaceDayExecution(-1)
            ->config($this->station);
    }
}