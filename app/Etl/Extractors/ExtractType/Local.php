<?php

namespace App\Etl\Extractors\ExtractType;

use App\Etl\EtlConfig;
use Carbon\Carbon;
use function Couchbase\defaultDecoder;

class Local extends ExtractTypeBase implements ExtractTypeInterface
{
    /**
     * @var string
     */
    public $extractType = 'Local';

    /**
     * @var string
     */
    public $extractConnection = 'data_warehouse';

    /**
     * @var string
     */
    public $select = null;

    /**
     * @var array
     */
    public $columns = [];

    /**
     * @var string
     */
    public $extractTable = 'original_';

    /**
     * @var string
     */
    public $colOrigin = 'database_field_name';

    /**
     * @var string
     */
    public $colDestination = 'local_name';

    /**
     * @var bool
     */
    public $flagStationSk = false;

    /**
     * @var bool
     */
    public $flagDateSk = false;

    /**
     * @var bool
     */
    public $flagTimeSk = false;

    /**
     * ExtractTypeInterface constructor.
     * @param EtlConfig $etlConfig
     */
    public function __construct(EtlConfig $etlConfig)
    {
        $this->extractTable .= $etlConfig->tableDestination;
        $this->setSelect($etlConfig->varForFilter,$etlConfig->keys);
    }

    /**
     * @param $variables
     * @param $keys
     * @return mixed
     * @internal param $key
     * @internal param $Keys
     * @internal param $foreignKey
     */
    public function setSelect($variables, $keys)
    {
        $temporalSelect = $keys->selectKey;

        $this->columns= array_merge($this->columns,$keys->global);
        $this->columns= array_unique($this->columns);

        foreach ($variables as $variable){
            $temporalSelect .= $variable->{$this->colDestination}.', ';
            $this->columns[] = $variable->{$this->colDestination};
        }
        $temporalSelect[strlen($temporalSelect)-2] = ' ';
        $this->select .= $temporalSelect;

        return $this;
    }

    /**
     * @param EtlConfig $etlConfig
     * @return mixed
     * @internal param $keyMerge
     */
    public function extractData(EtlConfig $etlConfig)
    {
        return $this->getLocalDataWDT(
            $this->extractConnection,
            $this->extractTable,
            $etlConfig->station->id,
            $etlConfig->keys->mergeLocalIncomingKeys,
            $this->select,
            $this->calculateDateSk(Carbon::parse($etlConfig->initialDate)),
            $this->calculateTimeSk($etlConfig->initialTime),
            $this->calculateDateSk(Carbon::parse($etlConfig->finalDate)),
            $this->calculateTimeSk($etlConfig->finalTime)
        );
    }
}