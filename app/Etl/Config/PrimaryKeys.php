<?php

namespace App\Etl\Config;

class PrimaryKeys
{
    /**
     * @var array
     */
    public $globalKeys = [];

    /**
     * @var array
     */
    public $global  = [];

    /**
     * @var array
     */
    public $load = [];

    /**
     * @var array
     */
    public $keys = [];

    /**
     * @var array
     */
    public $castKeys = [];

    /**
     * @var array
     */
    public $extractColumns = [];

    /**
     * @var array
     */
    public $localCalculatedKeys = [];

    /**
     * @var array
     */
    public $externalCalculatedKeys = [];

    /**
     * @var array
     */
    public $notLocalIncomingKeys = [];

    /**
     * @var array
     */
    public $notExternalIncomingKeys = [];

    /**
     * @var array
     */
    public $notCalculatedColumns = [];

    /**
     * @var string
     */
    public $globalCastKey = '';

    /**
     * @var string
     */
    public $loadCastKey = '';

    /**
     * @var string
     */
    public $selectCastKey = '';

    /**
     * @var string
     */
    public $selectKey = '';

    /**
     * @var string
     */
    public $mergeLocalIncomingKeys = '';

    /**
     * @var string
     */
    public $mergeExternalIncomingKeys = '';

    /**
     * @var string
     */
    public $extractConsult = '';

    /**
     * PrimaryKeys constructor.
     * @param $typeProcess
     * @param $etlMethod
     * @param $keys
     */
    function __construct(string $typeProcess, string $etlMethod, array $keys)
    {
        $this->globalKeys = $this->getReactiveKeys($etlMethod,$keys);

        $this->global = array_keys($this->globalKeys);

        #$this->config($typeProcess,$etlMethod);
    }

    /**
     * @param $etlMethod
     * @param $keys
     * @return array
     */
    private function getReactiveKeys(string $etlMethod, array $keys) : array
    {
        $arr = [];
        foreach ($keys as $key => $value) {
            if ($value['type'] == 'all' or $value['type'] == $etlMethod) { $arr[$key] = $value; }
        }
        return $arr;
    }

    /**
     * @param string $typeProcess
     * @param string $etlMethod
     * @param string $extractMethod
     * @param string $extractType
     */
    public function config(string $typeProcess, string $etlMethod = null, string $extractMethod, string $extractType = null)
    {
        #dd($typeProcess,$etlMethod,$extractMethod,$extractType);
        $temporalSelect = ' ';
        $temporalCastSelect = ' ';
        $temporalLocalMerge = ' ';
        $temporalExternalMerge = ' ';
        $temporalLoadCastKey = ' ';

        foreach ($this->globalKeys  as  $key => $value)
        {
            $this->globalCastKey .= 'CAST('.$key.' AS '.$value['type_data'].') ,';

            if (!is_null($value['cast_name'])){ array_push($this->castKeys,$value['cast_name']); }

            if ($value['key']){ array_push($this->keys,$key); }

            if (!is_null($value['calculated'])){
                if (!$value['calculated']){
                    array_push($this->notCalculatedColumns,$key);
                }
            }

            if ($value['local_incoming']){
                array_push($this->localCalculatedKeys,$key);
                $temporalSelect .= $key.' ,';
                if ($value['key']){
                    $temporalLocalMerge .= $key.' ,';
                }
            }else{
                array_push($this->notLocalIncomingKeys,$key);
            }

            if ($value['external_incoming']){
                array_push($this->externalCalculatedKeys,$key);
                $temporalCastSelect .= $value['external_name']. ' as '. $value['cast_name'].' ,';
                if ($value['key']){
                    $temporalExternalMerge .= $value['external_name'].' ,';
                }
            }else{
                array_push($this->notExternalIncomingKeys,$key);
            }

            if ($value['type'] == 'all' or $value['type'] == $etlMethod)
            {
                if ($typeProcess == 'Original' and $value['load_original'])
                {
                    $this->loadCastKey  .= ' '.$value['local_name'].' ,';
                    array_push($this->load,$value['local_name']);
                }

                if ( $typeProcess == 'Filter' and $value['load_filter'] ){
                    $this->loadCastKey .= ' CAST('.$value['local_name'].' AS '.$value['type_data'].') ,';
                    array_push($this->load,$value['local_name']);
                }
            }

            if ($extractMethod == 'Database' and  $extractType == 'External' and $value['external_incoming'] and !is_null($value['cast_name'])){
                $this->extractConsult .= $value['external_name']. ' as '. $value['cast_name'].' ,';
                array_push($this->extractColumns,$value['cast_name']);
            }

            if ($extractMethod == 'Database' and  $extractType == 'Local' and $value['local_incoming']){
                $this->extractConsult .= $value['local_name'].' ,';
                array_push($this->extractColumns,$value['local_name']);
            }
        }

        $this->selectKey = $temporalSelect;
        $this->selectCastKey = $temporalCastSelect;
        $this->mergeLocalIncomingKeys = substr($temporalLocalMerge, 0, -1);
        $this->mergeExternalIncomingKeys = substr($temporalExternalMerge, 0, -1);

    }

}