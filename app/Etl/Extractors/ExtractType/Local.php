<?php

namespace App\Etl\Extractors\ExtractType;

use App\Etl\EtlConfig;
use App\Etl\Traits\DateSkTrait;
use App\Etl\Traits\TimeSkTrait;
use App\Etl\Traits\WorkDatabaseTrait;
use Carbon\Carbon;


class Local extends ExtractTypeBase implements ExtractTypeInterface
{
    use WorkDatabaseTrait,DateSkTrait,TimeSkTrait;

    public $extractType = 'Local';

    public $extractConnection = 'data_warehouse';

    public $select = null;

    public $columns = [];

    public $extractTable = 'original_';

    public $colOrigin = 'database_field_name';

    public $colDestination = 'local_name';

    public $flagStationSk = false;

    public $flagDateSk = false;

    public $flagTimeSk = false;

    /**
     * ExtractTypeInterface constructor.
     * @param EtlConfig $etlConfig
     */
    public function __construct(EtlConfig $etlConfig)
    {
        $this->extractTable .= $etlConfig->getTableDestination();
        $this->setSelect($etlConfig->getVarForFilter(),$etlConfig->getKeys());
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
            array_push($this->columns,$variable->{$this->colDestination});
        }
        $temporalSelect[strlen($temporalSelect)-2] = ' ';
        $this->select .= $temporalSelect;

        return $this;
    }


    /**
     * @param $keys
     * @param $initialDate
     * @param $initialTime
     * @param $finalDate
     * @param $finalTime
     * @param $limit
     * @return mixed
     * @internal param $keyMerge
     */

    public function extractData($keys, $initialDate, $initialTime, $finalDate, $finalTime, $limit)
    {
        return $this->getLocalData(
            $this->extractConnection,
                $this->extractTable,
                $keys->mergeLocalIncomingKeys,
                $this->select,
                $this->calculateDateSk(Carbon::parse($initialDate)), // Todo .....
                $this->calculateTimeSk($initialTime),
                $this->calculateDateSk(Carbon::parse($finalDate)),
                $this->calculateTimeSk($finalTime),
                $limit
        );
    }


}