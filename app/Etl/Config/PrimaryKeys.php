<?php

namespace App\Etl\Config;


class PrimaryKeys
{
    public $globalKeys = [];

    public $global  = [];

    public $keys = [];

    public $castKeys = [];

    public $localCalculatedKeys = [];

    public $externalCalculatedKeys = [];

    public $notLocalIncomingKeys = [];

    public $notExternalIncomingKeys = [];

    public $globalCastKey = '';

    public $selectCastKey = '';

    public $selectKey = '';

    public $mergeLocalIncomingKeys = '';

    public $mergeExternalIncomingKeys = '';


    function __construct($keys)
    {
        $this->globalKeys = $keys;
        $this->global = array_keys($keys);
        $this->config();
    }

    private function config()
    {
        $temporalSelect = ' ';
        $temporalCastSelect = ' ';
        $temporalLocalMerge = ' ';
        $temporalExternalMerge = ' ';

        foreach ($this->globalKeys  as  $key => $value)
        {
            $this->globalCastKey .= 'CAST('.$key.' AS '.$value['type_data'].') ,';

            if (!is_null($value['cast_name'])){
                array_push($this->castKeys,$value['cast_name']);
            }

            if ($value['key']){
                array_push($this->keys,$key);
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
        }

        $this->selectKey = $temporalSelect;
        $this->selectCastKey = $temporalCastSelect;
        $this->mergeLocalIncomingKeys = substr($temporalLocalMerge, 0, -1);
        $this->mergeExternalIncomingKeys = substr($temporalExternalMerge, 0, -1);
    }

}