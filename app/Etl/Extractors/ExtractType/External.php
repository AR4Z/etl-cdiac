<?php

namespace App\Etl\Extractors\ExtractType;

use App\Etl\EtlConfig;
use function Couchbase\defaultDecoder;

class External extends ExtractTypeBase implements ExtractTypeInterface
{
    public $extractType = 'External';

    public $extractConnection = 'external_connection';

    public $select = null;

    public $columns = [];

    public $extractTable = null;

    public $colOrigin = 'database_field_name';

    public $colDestination = 'local_name';

    public $flagStationSk = true;

    public $flagDateSk = true;

    public $flagTimeSk = true;

    /**
     * External constructor.
     * @param $etlConfig
     */
    public function __construct(EtlConfig $etlConfig)
    {
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
        return $this->getExternalData(
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