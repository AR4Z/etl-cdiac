<?php

namespace App\Etl\Extractors\ExtractType;

use App\Etl\EtlConfig;


class Local extends ExtractTypeBase implements ExtractTypeInterface
{

    public $extractType = 'Local';

    public $extractConnection = 'data_warehouse';

    public $select = null;

    public $columns = [];

    public $extractTable = null;

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

    }

    /**
     * @param $variables
     * @param $foreignKey
     * @return mixed
     */
    public function setSelect($variables, $foreignKey)
    {
        // TODO: Implement setSelect() method.
    }

    /**
     * @param $foreignKey
     * @return mixed
     */
    public function foreignKeySearch($foreignKey)
    {
        $keyMerge = '';

        if (!$foreignKey){
            //TODO el array de claves foraneas no puede ser falso debe configurarse (exception)
        }

        foreach ($foreignKey as $value){$keyMerge .= ' '.$value.',';}

        return $keyMerge;
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
        return $this->getExternalData(
            $this->extractConnection,
                $this->extractTable,
                $keyMerge,
                $this->select,
                $this->calculateDateSk(Carbon::parse($initialDate)), // Todo .....
                $this->calculateTimeSk($initialTime),
                $this->calculateDateSk(Carbon::parse($finalDate)),
                $this->calculateTimeSk($finalTime),
                $limit
        );
    }


}