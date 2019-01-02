<?php

namespace App\Etl\Execution\Generator;

use Carbon\Carbon;
use App\Etl\Etl;

class EtlGeneratorConfig
{
    /**
     * @var Etl[]
     */
    public $etl = [];

    /**
     * @var string External | Local
     */
    private $extractor = 'External';

    /**
     * @var array
     */
    private $extractorConfig = [];

    /**
     * @var array
     */
    private $transformers = [];

    /**
     * @var string
     */
    private $load = 'Load';

    /**
     * @var array
     */
    private $loadConfig = [];

    /**
     * @var string
     */
    private $runType = 'Asynchronous';

    /**
     * @var array
     */
    private $runTypeConfig = [];

    /**
     * @var int
     */
    private $spaceDayExecution = 15;

    /**
     * @var string
     */
    private $typeProcess = 'Original';

    /**
     * @var array
     */
    private $generalOptions = [];

    /**
     * @param $stationOrStations int | array
     * @return array
     */
    public function config($stationOrStations) :array
    {
        return is_array($stationOrStations) ? $this->configStations($stationOrStations) : $this->configStation($stationOrStations);
    }

    /**
     * @param array $stations
     * @return array
     */
    private function configStations(array $stations) :array
    {
        foreach ($stations as $station) { $this->configStation($station);}
        return $this->etl;
    }

    /**
     * @param int $station
     * @return array
     */
    private function configStation(int $station) :array
    {
        $initialDate = Carbon::parse($this->extractorConfig['initialDate']);
        $finalDate = Carbon::parse($this->extractorConfig['finalDate']);

        $etl = Etl::start($this->typeProcess,null,null,$station,$this->generalOptions);

        ($this->spaceDayExecution == -1 or $initialDate->diffInDays($finalDate) <= $this->spaceDayExecution) ? $this->execute($etl,$initialDate,$finalDate) : $this->partitionExecute(clone $etl,$initialDate,$finalDate);

        return $this->etl;
    }

    /**
     * @param \App\Etl\Etl $etl
     * @param Carbon $initialDate
     * @param Carbon $finalDate
     */
    private function partitionExecute(Etl $etl,Carbon $initialDate,Carbon $finalDate)
    {
        $spaceDays = $this->spaceDayExecution;
        $interval = $initialDate->diffInDays($finalDate);
        $last = $interval % $this->spaceDayExecution;
        $control = intval($interval / $spaceDays);
        $i = 0;

        while ($i <= $control) {
            if ($i == $control){$spaceDays = $last ;}
            $dateFin = (clone ($initialDate))->addDays($spaceDays-1);
            $this->execute($etl,$initialDate,$dateFin);
            $initialDate = $dateFin->addDays(1);
            $i++;
        }

    }

    /**
     * @param \App\Etl\Etl $etl
     * @param Carbon $initialDate
     * @param Carbon $finalDate
     */
    private function execute(Etl $etl,Carbon $initialDate,Carbon $finalDate)
    {
        $this->extractorConfig['initialDate'] = $initialDate->toDateString();
        $this->extractorConfig['finalDate'] = $finalDate->toDateString();

        $etl->extract($this->extractor,$this->extractorConfig);

        foreach ($this->transformers as $transformerKey => $transformerValue){
            $etl->transform($transformerKey,$transformerValue);
        }

        $etl->load($this->load,$this->loadConfig);
        $etl->run($this->runType,$this->runTypeConfig);

        array_push($this->etl,$etl);
    }

    /**
     * @param string $extractor
     * @param string $initialDate
     * @param string $finalDate
     * @return EtlGeneratorConfig
     */
    public function setExtractor(string $extractor,string $initialDate,string $finalDate): EtlGeneratorConfig
    {
        $this->extractor = $extractor;
        $this->extractorConfig['initialDate'] = $initialDate;
        $this->extractorConfig['finalDate'] = $finalDate;
        return $this;
    }

    /**
     * @return string
     */
    public function getExtractor(): string
    {
        return $this->extractor;
    }

    /**
     * @param array $extractorConfig
     * @return EtlGeneratorConfig
     */
    public function setExtractorConfig(array $extractorConfig): EtlGeneratorConfig
    {
        $this->extractorConfig = $extractorConfig;
        return $this;
    }

    /**
     * @param string $variable
     * @param $value
     * @return EtlGeneratorConfig
     */
    public function addExtractorVariable(string $variable, $value) : EtlGeneratorConfig
    {
       $this->extractorConfig[$variable] = $value;
       return $this;
    }

    /**
     * @return array
     */
    public function getExtractorConfig(): array
    {
        return $this->extractorConfig;
    }

    /**
     * @param array $transformers
     * @return EtlGeneratorConfig
     */
    public function setTransformers(array $transformers): EtlGeneratorConfig
    {
        $this->transformers = $transformers;
        return $this;
    }

    /**
     * @return array
     */
    public function getTransformers(): array
    {
        return $this->transformers;
    }

    /**
     * @param string $transformer
     * @param array $config
     * @return EtlGeneratorConfig
     */
    public function addTransform(string $transformer, array $config = []) : EtlGeneratorConfig
    {
        $this->transformers[$transformer] = $config;
        return $this;
    }

    /**
     * @param string $transformer
     * @param string $variable
     * @param $value
     * @return EtlGeneratorConfig
     */
    public function addTransformVariable(string $transformer, string $variable, $value) : EtlGeneratorConfig
    {
       if (!array_key_exists($transformer,$this->transformers)){ dd('eroor'); /*TODO*/}

       $this->transformers[$transformer][$variable] = $value;
       return $this;
    }

    /**
     * @param string $load
     * @return EtlGeneratorConfig
     */
    public function setLoad(string $load): EtlGeneratorConfig
    {
        $this->load = $load;
        return $this;
    }

    /**
     * @return string
     */
    public function getLoad(): string
    {
        return $this->load;
    }

    /**
     * @param array $loadConfig
     * @return EtlGeneratorConfig
     */
    public function setLoadConfig(array $loadConfig): EtlGeneratorConfig
    {
        $this->loadConfig = $loadConfig;
        return $this;
    }

    public function addLoadVariable(string $variable,$value) : EtlGeneratorConfig
    {
        $this->loadConfig[$variable] = $value;
        return $this;
    }

    /**
     * @return array
     */
    public function getLoadConfig(): array
    {
        return $this->loadConfig;
    }

    /**
     * @param string $runType
     * @return EtlGeneratorConfig
     */
    public function setRunType(string $runType): EtlGeneratorConfig
    {
        $this->runType = $runType;
        return $this;
    }

    /**
     * @return string
     */
    public function getRunType(): string
    {
        return $this->runType;
    }

    /**
     * @param array $runTypeConfig
     * @return EtlGeneratorConfig
     */
    public function setRunTypeConfig(array $runTypeConfig): EtlGeneratorConfig
    {
        $this->runTypeConfig = $runTypeConfig;
        return $this;
    }

    public function addRunTypeVariable(string $variable,$value) :EtlGeneratorConfig
    {
        $this->runTypeConfig[$variable] = $value;
        return $this;
    }

    /**
     * @return array
     */
    public function getRunTypeConfig(): array
    {
        return $this->runTypeConfig;
    }

    /**
     * @param int $spaceDayExecution
     * @return EtlGeneratorConfig
     */
    public function setSpaceDayExecution(int $spaceDayExecution): EtlGeneratorConfig
    {
        $this->spaceDayExecution = $spaceDayExecution;
        return $this;
    }

    public function addDayInSpaceExecute(int $days) : EtlGeneratorConfig
    {
        $this->spaceDayExecution += $days;
        return $this;
    }

    /**
     * @return int
     */
    public function getSpaceDayExecution(): int
    {
        return $this->spaceDayExecution;
    }

    /**
     * @param string $typeProcess
     * @return EtlGeneratorConfig
     */
    public function setTypeProcess(string $typeProcess): EtlGeneratorConfig
    {
        $this->typeProcess = $typeProcess;
        return $this;
    }

    /**
     * @return string
     */
    public function getTypeProcess(): string
    {
        return $this->typeProcess;
    }

    /**
     * @param array $generalOptions
     * @return EtlGeneratorConfig
     */
    public function setGeneralOptions(array $generalOptions): EtlGeneratorConfig
    {
        $this->generalOptions = $generalOptions;
        return $this;
    }

    /**
     * @param string $variable
     * @param $value
     * @return EtlGeneratorConfig
     */
    public function addGeneralVariable(string $variable, $value) : EtlGeneratorConfig
    {
        $this->generalOptions[$variable] = $value;
        return $this;
    }

    /**
     * @return array
     */
    public function getGeneralOptions(): array
    {
        return $this->generalOptions;
    }

}