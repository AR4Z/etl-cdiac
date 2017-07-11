<?php

namespace App\Etl\Extractors\ExtractType;

use App\Etl\Database\DatabaseConfig;
use App\Etl\EtlConfig;
use App\Etl\Traits\WorkDatabaseTrait;

class External extends ExtractTypeBase implements ExtractTypeInterface
{
    use DatabaseConfig,WorkDatabaseTrait;

    public $extractType = 'External';

    public $extractConnection = 'external_connection';

    public $select = null;

    public $columns = [];

    public $extractTable = null;

    public $colOrigin = 'database_field_name';

    public $colDestination = 'local_name';

    public $flagStationSk = false;

    public $flagDateSk = false;

    public $flagTimeSk = false;

    /**
     * External constructor.
     * @param $etlConfig
     */
    public function __construct(EtlConfig $etlConfig)
    {
        $this->extractTable = $etlConfig->getTableDestination();
        $this->extractTable = $this->setExtractTable($etlConfig->getStation()->table_db_name);
        $this->settingConnection($etlConfig->getConnection());
        $this->setSelect($etlConfig->getVarForFilter(),$etlConfig->getKeys());
    }

    /**
     * @param $variables
     * @param $keys
     * @return mixed
     * @internal param $foreignKey
     */
    public function setSelect($variables,$keys)
    {
        $temporalSelect = $keys->selectCastKey;

        $this->columns= array_merge($this->columns,$keys->castKeys);
        $this->columns= array_unique($this->columns);

        foreach ($variables as $variable){
            $temporalSelect .= $variable->{$this->colOrigin} .' as '. $variable->{$this->colDestination}.', ';
            array_push($this->columns,$variable->{$this->colDestination});
        }
        $temporalSelect[strlen($temporalSelect)-2] = ' ';
        $this->select .= $temporalSelect;

        return $this;
    }

    /**
     * @param $keyMerge
     * @param $initialDate
     * @param $initialTime
     * @param $finalDate
     * @param $finalTime
     * @param $limit
     * @return mixed
     */

    public function extractData($keyMerge, $initialDate, $initialTime, $finalDate, $finalTime, $limit)
    {
        return $this->getExternalData($this->extractConnection,$this->extractTable,$keyMerge,$this->select,$initialDate,$initialTime,$finalDate, $finalTime, $limit);
    }


    /**
     * @param $connection
     * @return $this
     */
    private function settingConnection($connection)
    {
        $this->configExternalConnection($connection);
        return $this;
    }


}