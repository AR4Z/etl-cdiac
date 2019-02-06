<?php

namespace App\Etl\Extractors\ExtensionLoad;

use DB;
use Config;
use Illuminate\Support\Collection;
use App\Repositories\TemporaryWork\TemporalRepositoryContract;

class ExtensionLoadBase
{
    /**
     * @param string $etlMethod
     * @param array $inputVariables
     * @param Collection $variables
     * @return array
     */
    public function getVariablesName(string $etlMethod,array $inputVariables,Collection $variables) : array
    {
        $arr = [];

        foreach ((object)Config::get('etl')['csv_keys'][$etlMethod] as $key => $value){
            if (in_array($value['incoming_name'],$inputVariables)){$arr[$value['incoming_name']] = $value['local_name'];}
        }

        foreach ($variables as $value) {
            if (in_array($value->excel_name,$inputVariables)){ $arr[$value->excel_name] = $value->local_name ;}
        }
        return $arr;
    }

    /**
     * @param TemporalRepositoryContract $repository
     * @param Collection $variables
     * @return bool
     */
    public function changeCommaForPointAllVariables(TemporalRepositoryContract $repository,Collection $variables) : bool
    {
        #Cambiar comas por puntos en los decimales.
        foreach ($variables as $value) {$this->changeCommaForPointWDT($repository,$value->local_name);}

        return true;
    }

    /**
     * @param TemporalRepositoryContract $repository
     * @param string $variable
     * @return bool
     */
    public function changeCommaForPointWDT(TemporalRepositoryContract $repository, string $variable)
    {
        return $repository->queryBuilder()->update([ $variable => DB::raw( " REGEXP_REPLACE($variable,',','.') " )]);
    }

}