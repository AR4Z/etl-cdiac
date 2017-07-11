<?php

namespace App\Etl\Config;


class PrimaryKeys
{
    public $globalKeys = [];

    public $keys = [];

    public $castKeys = [];

    public $calculatedKeys = [];

    public $notIncomingKeys = [];

    public $selectCastKey = '';

    public $mergeIncomingKeys = '';


    function __construct($keys)
    {
        $this->globalKeys = $keys;
        $this->keys = array_keys($keys);
        $this->mergeIncomingKeys = $this->setMergeIncomingKeys();
        $this->selectCastKey = $this->setSelectCastKey();
    }

    /**
     *
     */
    private function setSelectCastKey()
    {
        $keyMerge = '';
        if (!$this->globalKeys){
            //TODO el array de claves foraneas no puede ser falso debe configurarse (exception)
        }

        foreach ($this->globalKeys as $key => $value)
        {
            if ($value['incoming']){
                $keyMerge .= ' '.$value['external_name'].' as '.$value['cast_name'].',';
                array_push($this->calculatedKeys,$key);
            }
        }
        return $keyMerge;
    }

    private function setMergeIncomingKeys()
    {
        $keyMerge = [];
        foreach ($this->globalKeys as $key => $value)
        {
            if ($value['incoming']){
                array_push($keyMerge,$value['external_name']);
                array_push($this->castKeys,$value['cast_name']);
            }else{
                array_push($this->notIncomingKeys,$key);
            }
        }
        return  implode(',',$keyMerge);
    }



}