<?php

namespace App\Etl\Config;


class PrimaryKeys
{
    public $globalKeys = [];

    public $global  = [];

    public $load = [];

    public $keys = [];

    public $castKeys = [];

    public $localCalculatedKeys = [];

    public $externalCalculatedKeys = [];

    public $notLocalIncomingKeys = [];

    public $notExternalIncomingKeys = [];

    public $notCalculatedColumns = [];

    public $globalCastKey = '';

    public $loadCastKey = '';

    public $selectCastKey = '';

    public $selectKey = '';

    public $mergeLocalIncomingKeys = '';

    public $mergeExternalIncomingKeys = '';


    function __construct($typeProcess, $etlMethod, $keys)
    {
        $this->globalKeys = $this->getReactiveKeys($typeProcess,$etlMethod,$keys);
        $this->global = array_keys($this->globalKeys);
        $this->config($typeProcess,$etlMethod);
    }

    private function getReactiveKeys($typeProcess, $etlMethod, $keys)
    {
        $arr = [];
        foreach ($keys as $key => $value)
        {
            if ($value['type'] == 'all' or $value['type'] == $etlMethod){

                if (($typeProcess == 'Original' and $value['external_incoming']) or ( $typeProcess == 'Filter' and $value['local_incoming'] ) or ( $value['key'])){
                    $arr[$key] = $value;
                }
            }
        }
        return $arr;
    }

    private function config($typeProcess,$etlMethod)
    {
        $temporalSelect = ' ';
        $temporalCastSelect = ' ';
        $temporalLocalMerge = ' ';
        $temporalExternalMerge = ' ';
        $temporalLoadCastKey = ' ';

        foreach ($this->globalKeys  as  $key => $value)
        {
            $this->globalCastKey .= 'CAST('.$key.' AS '.$value['type_data'].') ,';

            if (!is_null($value['cast_name'])){
                array_push($this->castKeys,$value['cast_name']);
            }

            if ($value['key']){
                array_push($this->keys,$key);
            }
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

            if ($value['type'] == 'all' or $value['type'] == $etlMethod){

                if ($typeProcess == 'Original' and $value['load_original']){
                    $this->loadCastKey  .= ' '.$value['local_name'].' ,';
                    array_push($this->load,$value['local_name']);
                }

                if ( $typeProcess == 'Filter' and $value['load_filter'] ){
                    $this->loadCastKey .= ' CAST('.$value['local_name'].' AS '.$value['type_data'].') ,';
                    array_push($this->load,$value['local_name']);
                }
            }

        }

        $this->selectKey = $temporalSelect;
        $this->selectCastKey = $temporalCastSelect;
        $this->mergeLocalIncomingKeys = substr($temporalLocalMerge, 0, -1);
        $this->mergeExternalIncomingKeys = substr($temporalExternalMerge, 0, -1);
    }

}