<?php


namespace App\Etl\Loaders;


use App\Etl\EtlConfig;
use App\Etl\Traits\WorkDatabaseTrait;



class Load extends LoadBase implements LoadInterface
{
    use WorkDatabaseTrait;

    private $method = 'General';

    private  $etlConfig = null;


    private $select = '';

    private  $columns = [];

    /**
     * @param EtlConfig $etlConfig
     * @return mixed
     */
    public function setOptions(EtlConfig $etlConfig)
    {
        $this->etlConfig = $etlConfig;
        $this->select = $etlConfig->getKeys()->globalCastKey;
        $this->columns = $etlConfig->getKeys()->global;
        $this->setSelect($etlConfig->getVarForFilter(), 'local_name', 'local_name');

        return $this;
    }

    /**
     * @return $this
     */
    public function load()
    {
        $this->redirectExisting(
                    $this->etlConfig->getRepositorySpaceWork(),
                    $this->etlConfig->getRepositoryDestination(),
                    $this->etlConfig->getRepositoryExist(),
                    $this->etlConfig->getTableExist()
                );

        $this->insertAllDataInFact($this->selectTemporalTable());

        dd($this);
        if ($this->etlConfig->getSequence())
        {
            $this->updateDateAndTime(
                $this->etlConfig->getRepositorySpaceWork(),
                $this->etlConfig->getStation()->{$this->etlConfig->getStateTable()}
            );
        }

        return $this;
    }

    public function setSelect($variables, $colOrigin, $colDestination)
    {
        $temporalSelect = '';
        foreach ($variables as $variable){
            $temporalSelect .= 'CAST('.$variable->$colOrigin.' AS float) AS '. $variable->$colDestination.', ';
            array_push($this->columns,$variable->$colDestination);
        }
        $temporalSelect[strlen($temporalSelect)-2] = ' ';
        $this->select .= $temporalSelect;

        return $this;
    }

    public function selectTemporalTable()
    {
        return $this->getAllData('temporary_work',$this->etlConfig->getTableSpaceWork(),$this->select);
    }

    public function insertAllDataInFact($data)
    {
       return $this->insertDataEncode('data_warehouse',$this->etlConfig->getTableDestination(),$data);
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @param string $method
     */
    public function setMethod(string $method)
    {
        $this->method = $method;
    }
}