<?php

namespace App\Etl\Extractors\ExtensionLoad;

use App\Etl\Extractors\ExtensionLoad\Imports\PlaneImport;
use Illuminate\Support\Collection;
use App\Repositories\TemporaryWork\TemporalRepositoryContract;

class Csv extends ExtensionLoadBase implements ExtensionLoadContract
{
    /**
     * @var bool
     */
    public $dateTime = false;

    /**
     * @param TemporalRepositoryContract $repository
     * @param string $method
     * @param Collection $variables
     * @param string $fileName
     * @return bool
     */
    public function loadFormatData(TemporalRepositoryContract $repository, string $method, Collection $variables, string $fileName) : bool
    {
        $planeImport = new PlaneImport();
        $planeImport->import(storage_path().'/app/public/'. $fileName,null,\Maatwebsite\Excel\Excel::CSV);

        $variablesName = $this->getVariablesName($method, $planeImport->headers, $variables);

        $variablesNameExcel = array_keys($variablesName);

        $this->dateTime = in_array('date_time',$planeImport->headers);

        foreach ($planeImport->elements as $values){
            $val = [];
            $values->toArray();

            foreach ($planeImport->headers as $key => $variableName){
                if (in_array($variableName,$variablesNameExcel)){
                    $val[$variablesName[$variableName]] = $values[$key];
                }
            }

            $repository->create($val);
        }

        # cambiar de comas a puntos los datos de las variables
        $this->changeCommaForPointAllVariables($repository,$variables);

        return true;
    }

    /**
     * @return bool
     */
    public function isDateTime() : bool
    {
        return $this->dateTime;
    }

    /**
     * @param bool $dateTime
     */
    public function setDateTime(bool $dateTime) : void
    {
        $this->dateTime = $dateTime;
    }
}