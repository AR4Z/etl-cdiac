<?php

namespace App\Etl\Extractors\ExtractType;

use App\Etl\EtlConfig;
use function Couchbase\defaultDecoder;

class External extends ExtractTypeBase implements ExtractTypeInterface
{
    /**
     * @var string
     */
    public $extractType = 'External';

    /**
     * @var string
     */
    public $extractConnection = 'external_connection';

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
    public $extractTable = null;

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
    public $flagStationSk = true;

    /**
     * @var bool
     */
    public $flagDateSk = true;

    /**
     * @var bool
     */
    public $flagTimeSk = true;

    /**
     * External constructor.
     * @param $etlConfig
     */
    public function __construct(EtlConfig $etlConfig)
    {
        $this->extractTable = $this->setExtractTable(($etlConfig->station)->table_db_name);
        $this->settingConnection($etlConfig->connection);
        $this->setSelect($etlConfig->varForFilter,$etlConfig->keys);
    }

    /**
     * @param $variables
     * @param $keys
     * @return mixed
     * @internal param $foreignKey
     */
    public function setSelect($variables,$keys)
    {
        $temporalSelect = $keys->extractConsult;

        $this->columns= array_merge($this->columns,$keys->extractColumns);
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
     * @param $keys
     * @param $initialDate
     * @param $initialTime
     * @param $finalDate
     * @param $finalTime
     * @param $limit
     * @return mixed
     */

    public function extractData($keys, $initialDate, $initialTime, $finalDate, $finalTime, $limit)
    {
        return $this->getExternalDataWDT(
                $this->extractConnection,
                $this->extractTable,
                $keys->mergeExternalIncomingKeys,
                $this->select,
                $initialDate,
                $initialTime,
                $finalDate,
                $finalTime,
                $limit
        );
    }


    /**
     * @param $connection
     * @return $this
     */
    private function settingConnection($connection)
    {
        if ($this->searchExternalConnection($connection,$this->extractTable)){
            return $this;
        }else{
            dd('No se hallo en ninguna conexion la tabla');
            //TODO
        }
    }


}